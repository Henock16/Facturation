<?php

/*
    Date creation : 10-08-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 10-08-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Generer la facture des ponts et le details des tickets par chargeur
*/
	session_start();

	include('../config/Connexion.php');	
	include_once('../functions/Get_SQLPonts_function.php');
	include_once('../functions/PDF_Facture_function.php');
	include_once('../functions/Nom_pont_function.php');
	include_once('../functions/Mail_function.php');
	include_once('../functions/Table_value_function.php');

	if($mpdf==6)
		include("../mpdf/mpdf.php");
	elseif($mpdf==7)
		require_once '../vendors/autoload.php';


	$date=date("Y-m",strtotime(date("Y-m")." - ".$facture." month"));

	$mois='01';
	$annee='2020';
	$mois=substr($date,5,2);
	$annee=substr($date,0,4);
	$pont='';
	$user='';
	

	Facturation($mois,$annee,$pont,$cafe,$cajou,$autres,$user);

	
	//liste des chargeur
	function Facturation($mois,$annee,$pont,$cafe,$cajou,$autres,$user){

		global $verbose,$mpdf,$bdf,$bds,$repfact,$month,$nom_site,$appli;
		
		$debut=$annee."-".$mois."-01";
		$fin=$annee."-".$mois."-31";
		
		$res = GetSQLPonts($debut,$fin,$pont,$cafe,$cajou,$autres);

		$bdd = $res[0];
		$query = $res[1];

		$result = $bdd -> query ($query);
		
		echo $result -> rowCount()." Ponts\n";

		//S'il ya des tickets et (la bd tampon n'a pas encore ete generee ou les ponts ont ete specifies)
		if($result -> rowCount()>0 && ($bdd==$bds || $pont)){
			
			//si pas de pont specifie et la bd est solas
			//initioalisation de la requete d'insertion dans la  table tampon
			$insert=((($bdd==$bds)&&(!$pont))?"INSERT":"");

			$tabiduser=array();
			$tabuser=array();
			$tabpont=array();
			$tabpath=array();
			$tabfile=array();

			$nbpont=0;//Ponts
			$nbcree=0;//crees
			$echecs=array();//echecs
			$nbexis=0;//existent
			while ($donnees = $result->fetch()){
						
				$nbpont++;
				$pont=$donnees['PONT'];
				
				//Construction de la requete d'insertion dans la table tampon
				$insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,CAFE,CAJOU,AUTRES,PONT,NBCH,NBTC,MONTANT) VALUES":","):"");
				$insert.=($insert?"('".$annee."','".$mois."',".$cafe.",".$cajou.",".$autres.",".$pont.",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees['MONTANT'].")":"");
		
				//construction du chemin d'acces et du nom du fichier pdf du pont
				$nompont=GetNomPont($bds,$pont);
				$path=PDFfile('PATH',$repfact,$annee,$mois,$pont,'',$cafe,$cajou,$autres);
				$file=PDFfile('FILE',$repfact,$annee,$mois,$pont,'',$cafe,$cajou,$autres);

				echo $nbpont."	".$nompont." ";
		
				//creation du fichier si inexistant
				$fichier='';
				if(!file_exists($path.$file)){
					
					if(file_exists($path))
						rmdir($path);
					
					@ $fichier=PDF_Facture($pont,$debut,$fin,$cafe,$cajou,$autres,$mpdf,'F',$user);

					if($verbose)
					echo ($fichier?'CREATION DU FICHIER':'ECHEC DE CREATION DU FICHIER').' '.$fichier."\n";

					$nbcree+=($fichier?1:0);
					if(!$fichier) $echecs[]="(".$pont.")=".$nompont;
				}else{
					
					$fichier=$path.$file;
					
					if($verbose)
					echo 'LE FICHIER '.$fichier." EXISTE DEJA\n";					

					$nbexis++;
				}

				//recuperation de l'id de l'utilisateur
				$account=getvalue($bdf,'STATUT,ID_USER','PONT','ID_PONT',$pont);			
				$iduser=(($account[1]&&($account[0]==0))?$account[1]:0);

				//recuperation du nom de l'utilisateur
				$account=getvalue($bdf,'STRUCTURE,STATUT','USER','IDENTIFIANT',$iduser);			
				$user=($account[0]?$account[0]:'');
				$statut=1-($account[0]?$account[1]:1);

				//recuperation du nom du pont
				$pont=getvalue($bds,'NOM','PONT','ID_PONT',$pont);			
				$pont=($pont[0]?$pont[0]:'');


				//collecte de l'utilisateur s'il est actif, ce pont en a, et si le fichier facture du pont existe
				if($statut && $iduser && $fichier)
					if(!in_array($iduser,$tabiduser)){
						$tabiduser[]=$iduser;
						$tabuser[]=$user;
						$tabpont[]=array($pont);
						$tabpath[]=array($path);
						$tabfile[]=array($file);
					}else{
						$position=array_search($iduser,$tabiduser);
						$tabpont[$position][]=$pont;
						$tabpath[$position][]=$path;
						$tabfile[$position][]=$file;
					}
				
			}
			$result->closeCursor();	

			echo $nbpont." Ponts \n";
			echo $nbexis." PDF Existent deja \n";
			echo $nbcree." PDF Crees \n";
			echo count($echecs)." Echec de creation du PDF ".implode(" | ",$echecs)." \n";
			
			//insertion ds la table tampon
			if($insert && $insert!="INSERT"){		
				$query = $bdf->prepare($insert.";");
				$query->execute();
				$query->closeCursor();	
			}
			

			//Pour chaque utilisateur
			for($i=0;$i<count($tabiduser);$i++){
				
				$query="SELECT * FROM EMAIL WHERE ID_USER = :id AND STATUT = 0 ORDER BY LIBELLE ASC";
				$result = $bdf->prepare($query);
				$result -> bindParam(':id', $tabiduser[$i], PDO::PARAM_INT);
				$result -> execute();
				$mails="";
				while ($donnees = $result->fetch())
					$mails.=($mails?',':'').$donnees['LIBELLE'];
				$result->closeCursor();

				if($mails){					
					$s=((count($tabpont[$i])>1)?'s':'');
					$sujet="FACTURATION SOLAS DE ".strtoupper($month[intval($mois)-1])." ".$annee." POUR LE COMPTE DE ".strtoupper($tabuser[$i]);
					$message="Veuillez trouver ci-joint, ";
					$message.="vo".($s?'s':'tre')." facture".$s." SOLAS du mois de ".strtoupper($month[intval($mois)-1])." ".$annee.", ";
					$message.="pour le".$s." pont".$s." suivant".$s.":<br/>";
					for($j=0;$j<count($tabpont[$i]);$j++)
						$message.=($j+1).". ".$tabpont[$i][$j]."<br/>";
					$message.="<br>Pour consulter les détails de ".($s?'ces':'cette')." facture".($s?'s':'').", cliquez sur le lien suivant: <a href=\"https://".$nom_site."\">".$appli."<a><br/>";
					$message.=" et connectez-vous avec l'identifiant et le mot de passe qui vous ont été fournis par la CCI-CI.<br/>";
					
					echo "Destinataires: ".$mails."\n";
					echo "Sujet: ".$sujet."\n";
					echo "Message: ".$message."\n";
					for($j=0;$j<count($tabpont[$i]);$j++)
						echo "	".$tabpont[$i][$j]."\n";
					
					envoimailfacture($mails,$sujet,$message,$tabpath[$i],$tabfile[$i]);
				}
							
			}//END Pour chaque utilisateur

		}//END S'il ya des tickets et (la bd tampon n'a pas encore ete generee ou les ponts ont ete specifies)


	}//END FUNCTION
 
 
 
?>