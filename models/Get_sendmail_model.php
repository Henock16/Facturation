<?php

/*
    Date creation : 30-03-2022
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 30-03-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: Generer la facture des utulisateurs et le details des tickets par chargeur et par pont
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
	// $user='';
	$user=$_POST['id_strc'];
	// $debut='07-07-2020';
	// $fin='31-08-2020';
	// $type=1;


	Facturation($mois,$annee,$pont,$cafe,$autres,$user);

	//liste des chargeur
	function Facturation($mois,$annee,$pont,$cafe,$autres,$user){

		global $verbose,$mpdf,$bdf,$bds,$repfact,$month,$nom_site,$appli;
		
		$debut=$annee."-".$mois."-01";
		$fin=$annee."-".$mois."-31";
		
		if($cafe==1 && $autres==0)
			$type='1';
			
		elseif($cafe==0 && $autres ==1)
			$type='2';

		$res = GetSQLPonts($debut,$fin,$user,$pont,$type);
		$bdd = $res[0];
		$query = $res[1];
		$result = $bdd -> query ($query);
	
		if($result -> rowCount()>0 && ($bdd==$bds || $user))
		 {
				
				//si pas de pont specifie et la bd est solas
				//initioalisation de la requete d'insertion dans la  table tampon
				 $insert=((($bdd==$bds)&&(!$user))?"INSERT":"");

				$tabiduser=array();
				$tabuser=array();
				$tabpont=array();
				$tabpath=array();
				$tabfile=array();

				$nbpont=0;//Ponts
				$nbuser=0;//users
				$nbcree=0;//crees
				$echecs=array();//echecs
				$nbexis=0;//existent

				 while ($donnees = $result->fetch())
				 	{	
							
						$nbpont++;
						$pont=$donnees['PONT'];
						$nbuser++;
						$user=/*$donnees['STRC'];*/$_POST['id_strc'];
						
						// $insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,ID_USER,NBCH,NBTC,MONTANT) VALUES":","):"");
						// $insert.=($insert?"('".$annee."','".$mois."',".$type.",".$user.",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees['MONTANT'].")":"");
				
						//construction du chemin d'acces et du nom du fichier pdf du pont
						$nompont=GetNomPont($bds,$pont);
						$path=PDFfile('PATH',$repfact,$annee,$mois,$pont,/*$user,*/'',$cafe,$autres);//modifier
						$file=PDFfile('FILE',$repfact,$annee,$mois,$pont,/*$user,*/'',$cafe,$autres);//modifier

						// echo "nbpont".$nbpont."nompont".$nompont."nbuser ".$nbuser;
						//creation du fichier si inexistant
							$fichier='';
						if(!file_exists($path.$file))
						{
						
							if(file_exists($path))
								rmdir($path);
							
						 @ $fichier=PDF_Facture($pont,$debut,$fin,$type,$mpdf,'F',$user);
							// var_dump ('le ID:'.$donnees['STRC']);

							if($verbose)
							echo ($fichier?'CREATION DU FICHIER':'ECHEC DE CREATION DU FICHIER').' '.$fichier."\n";

							$nbcree+=($fichier?1:0);
							if(!$fichier) $echecs[]="(".$pont.")=".$nompont;
						}	
						else
						{
						
							$fichier=$path.$file;
							
							if($verbose)
							echo 'LE FICHIER '.$fichier." EXISTE DEJA\n";					

							$nbexis++;
						}

						// recuperation de l'id de l'utilisateur
						$idstrc=$_POST['id_strc'];
						
						//recuperation du nom de l'utilisateur
						$user=$_POST['name_strc'];
						$account=getvalue($bdf,'STATUT','USER','IDENTIFIANT',$idstrc);			
						$statut=1-($account[0]?$account[1]:1);

						// $account=getvalue($bdf,'STATUT,ID_USER','PONT','ID_PONT',$pont);
						$account=getvalue($bdf,'STATUT,IDENTIFIANT','USER','IDENTIFIANT',$idstrc);			
						$idstrc=(($account[1]&&($account[0]==0))?$account[1]:0);
						//recuperation du nom du pont
						$pont=getvalue($bds,'NOM','PONT','STRC',$idstrc);			
						$pont=($pont[0]?$pont[0]:'');
						// collecte de l'utilisateur s'il est actif, ce pont en a, et si le fichier facture du pont existe
						if($statut && $idstrc && $fichier)
						if(!in_array($idstrc,$tabiduser))
						{
							$tabiduser[]=$idstrc;
							$tabuser[]=$user;
							$tabuser[]=array($user);
							$tabpont[]=array($pont);
							$tabpath[]=array($path);
							$tabfile[]=array($file);
							}else
							{
								$position=array_search($idstrc,$tabiduser);
								$tabpont[$position][]=$pont;
								$tabpath[$position][]=$path;
								$tabfile[$position][]=$file;
							}
							$result->closeCursor();	


							echo $nbpont." Ponts \n".$nbuser;
							echo $nbexis." PDF Existent deja \n";
							echo $nbcree." PDF Crees \n";
							echo count($echecs)." Echec de creation du PDF ".implode(" | ",$echecs)." \n";
							
							//insertion ds la table tampon
							if($insert && $insert!="INSERT")
							{		
								$query = $bdf->prepare($insert.";");
								$query->execute();
								$query->closeCursor();	
							}

							$i=0;
							$i++;
							$query="SELECT * FROM EMAIL WHERE ID_USER = $idstrc AND STATUT = 0 ORDER BY LIBELLE ASC";
							$result = $bdf->prepare($query);
							// $result -> bindParam(':id', $tabiduser[$i], PDO::PARAM_INT);
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
								
								// echo "Destinataires: ".$mails."\n";
								// echo "Sujet: ".$sujet."\n";
								// echo "Message: ".$message."\n";
								for($j=0;$j<count($tabpont[$i]);$j++)
									// echo "	".$tabpont[$i][$j]."\n";
								
								envoimailfacture($mails,$sujet,$message,$tabpath[$i],$tabfile[$i]);
							}

					}//END Pour chaque utilisateur

		  }//END S'il ya des tickets et (la bd tampon n'a pas encore ete generee ou les ponts ont ete specifies)


	}//END FUNCTION
 
?>