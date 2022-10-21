<?php

/*
    Date creation : 10-08-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 10-07-2022
    Dernier modificateur : Cellule SOLAS - HENOCK
    Description: Generer la facture des prietaires de pont et le details des tickets par utilisateur et par chargeur (seulement les chargeurs exclus).
*/
	session_start();

	include('../config/Connexion.php');	
	include_once('../functions/Get_SQLPonts_function.php');
	include_once('../functions/PDF_Facture_function.php');
	include_once('../functions/PDF_File_function.php');
	include_once('../functions/Nom_pont_function.php');
	include_once('../functions/Mail_function.php');
	include_once('../functions/Users_get_nbticket.php');
	include_once('../functions/Table_value_function.php');
	include_once('../functions/Incrementation_function.php');
	include_once('../functions/Get_SQLChargeurs_function.php');
	include_once('../functions/Users_get_nbticket_chargeur.php');

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
	$char='';
	$user=(isset($_POST['id_strc']))?$_POST['id_strc']:'';

	Facturation($mois,$annee,$pont,$cafe,$autres,$user,$char,$numfac);

	
	function Facturation($mois,$annee,$pont,$cafe,$autres,$user,$char,$numfac){

		global $verbose,$mpdf,$bdf,$bds,$repfact,$month,$nom_site,$appli;
		
		$debut=$annee."-".$mois."-01";
		$fin=$annee."-".$mois."-31";
		$dateact= date("Y-m-d H:i:s");
		// $nbtc=getNbticket($pont,$debut,$fin,$type,$user);
		if($cafe==1 && $autres==0)
			$type='1';
		elseif($cafe==0 && $autres ==1)
			$type='2';


			//preparation de la requette qui genere les factures des chargeurs exclus
			
		if($user=='')//l'execution de la fonction facturation 
		{
		
				$res1 =  GetSQLChargeurs($debut,$fin,$char,$pont,$type);
				$bdd = $res1[0];
				$query1 = $res1[1];
				$result1 =$bdd ->query($query1);
				$nbchar=$result1 -> rowCount()." chargeurs\n";
				echo $nbchar;
				
				
				if($result1 -> rowCount()>0 && ($bdd==$bds || $char)){
					echo "Generation des factures par chargeurs exclus  \n";
					//initialisation de la requete d'insertion dans la  table tampon
					$insert1=((($bdd==$bds))?"INSERT":"");
					$tabidchar=array();
					$tabchar=array();
					$tabpath1=array();
					$tabfile1=array();
					$nbcree1=0;//crees
					$echecs1=array();//echecs
					$nbexis1=0;//existent
					while ($data = $result1->fetch()){
						$char=$data['ORIGINAL'];
						// $pont=$data['PONT'];
						$numfac= Numfact($bdf,$type);
						$nbtc=getCharNbticket($pont,$debut,$fin,$type,$char);
						$tarif=2750;
						//Construction de la requete d'insertion dans la table tampon
						$insert1.=($insert1?(($insert1=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,NUM_FACTURE,ID_CHAR,ID_USER,NBCH,NBTC,NBPONT,MONTANT) VALUES":","):"");
						$insert1.=($insert1?"('".$annee."','".$mois."','".$type."','".$numfac."','".$char."','0','".$data['NBCH']."','".$nbtc."','".$data['NBPONT']."','".$nbtc*$tarif."')":"");

						//construction du chemin d'acces et du nom du fichier pdf 
							$account=getvalue($bdf,'NOM','CHARGEUR','IDENTIFIANT',$char);			
							$nomchar=$account[0];
						$path=PDFfile('PATH',$repfact,$annee,$mois,'',$type,$char);//modifier
						$file=PDFfile('FILE',$repfact,$annee,$mois,'',$type,$char);//modifier
						//creation du fichier si il est inexistant
						$fichier='';

						if(!file_exists($path.$file)){
								
							if(file_exists($path))
								rmdir($path);
							
							$fichier=PDF_Facture($debut,$fin,$type,$mpdf,'F','',$char);

							if($verbose)
							echo ($fichier?'CREATION DU FICHIER':'ECHEC DE CREATION DU FICHIER').' '.$fichier."\n";

							$nbcree1+=($fichier?1:0);
							var_dump($numfac);
							if(!$fichier) $echecs1[]="(".$char.")=".$nomchar;
						}else{
							
							$fichier=$path.$file;
							
							if($verbose)
							echo 'LE FICHIER '.$fichier." EXISTE DEJA\n";					

							$nbexis1++;
						}

						// recuperation de l'id de l'utilisateur
					$account=getvalue($bdf,'STATUT,IDENTIFIANT','CHARGEUR','IDENTIFIANT',$char);			
					$idchar=(($account[1]&&($account[0]==0))?$account[1]:0);

					//recuperation du nom de l'utilisateur
					$account=getvalue($bdf,'NOM,STATUT','CHARGEUR','IDENTIFIANT',$iduser);			
					$char=($account[0]?$account[0]:'');
					$statut=1-($account[0]?$account[1]:1);


			
					// collecte de l'utilisateur s'il est actif, ce pont en a, et si le fichier facture existe
					if($statut && $idchar)
						if(!in_array($idchar,$tabidchar)){
							$tabidchar[]=$idchar;
							$tabchar[]=$char;
							$tabchar[]=array($user);
							$tabpath[]=array($path);
							$tabfile[]=array($file);
						}else{
							$position=array_search($idchar,$tabidchar);
							$tabpath[$position][]=$path;
							$tabfile[$position][]=$file;
						}

					}//end while*
					$result1->closeCursor();	

					echo $nbexis1." PDF Existent deja \n";
					echo $nbcree1." PDF Crees \n";
					echo count($echecs1)." Echec de creation du PDF ".implode(" | ",$echecs1)." \n";
				
					///fin des chargeurs 

					if($insert1 && $insert1!="INSERT"){		
						$query1 = $bdf->prepare($insert1.";");
						$query1->execute();
						$query1->closeCursor();	
					}
					
					} 
				}//end if pour une seule structure
		///////////////////////////////
		$res = GetSQLPonts($debut,$fin,$user,$pont,$type);
		$bdd = $res[0];
		$query = $res[1];
		 $result = $bdd -> query ($query);
		
		 
		echo $result -> rowCount()." structures\n";
		//S'il ya des tickets et (la bd tampon n'a pas encore ete generee ou les ponts ont ete specifies)
		 if($result -> rowCount()>0 && ($bdd==$bds || $user)){
			echo"Generation des factures par utilisateur   \n";
			
			// si pas de proprietaire(user) specifie et la bd est solas
			//initialisation de la requete d'insertion dans la  table tampon
			 $insert=((($bdd==$bds)&&(!$user))?"INSERT":"");

			$tabiduser=array();
			$tabuser=array();
			$tabpath=array();
			$tabfile=array();

			$nbuser=0;//users
			$nbcree=0;//crees
			$echecs=array();//echecs
			$nbexis=0;//existent
				while ($donnees = $result->fetch()){
					
					if(isset($_POST['id_strc'])){
						$i=0;
						$tab[$i]=0;
						$i++;
					
						$tab[$i]=6;
						$i++;
					}
				
					
					$pont=$donnees['PONT'];
					$nbuser++;
					$user=$donnees['STRC'];
					$numfac= Numfact($bdf,$type);
					$nbtc=getNbticket($pont,$debut,$fin,$type,$user);
					$tarif=2750;
					
					//Construction de la requete d'insertion dans la table tampon
					$insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,NUM_FACTURE,ID_CHAR,ID_USER,NBCH,NBTC,NBPONT,MONTANT) VALUES":","):"");
					$insert.=($insert?"('".$annee."','".$mois."','".$type."','".$numfac."','0','".$user."','".$donnees['NBCH']."','".$nbtc."','".$donnees['NBPONT']."','".$nbtc*$tarif."')":"");
					
					//construction du chemin d'acces et du nom du fichier pdf
					$path=PDFfile('PATH',$repfact,$annee,$mois,$type,'',$user);//modifier
					$file=PDFfile('FILE',$repfact,$annee,$mois,$type,'',$user);//modifier

					$account=getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$user);			
					$nomuser=$account[0];
					//creation du fichier si inexistant
					$fichier='';

					if(!file_exists($path.$file)){
						
						if(file_exists($path))
							rmdir($path);
						
						$fichier=PDF_Facture($debut,$fin,$type,$mpdf,'F',$user,'');

						if($verbose)
						echo ($fichier?'CREATION DU FICHIER':'ECHEC DE CREATION DU FICHIER').' '.$fichier."\n";

						$nbcree+=($fichier?1:0);
						var_dump($numfac);
						if(!$fichier) $echecs[]="(".$user.")=".$nomuser;
					}else{
						
						$fichier=$path.$file;
						
						if($verbose)
						echo 'LE FICHIER '.$fichier." EXISTE DEJA\n";					

						$nbexis++;
					}

					// recuperation de l'id de l'utilisateur
					$account=getvalue($bdf,'STATUT,IDENTIFIANT','USER','IDENTIFIANT',$user);			
					$iduser=(($account[1]&&($account[0]==0))?$account[1]:0);

					//recuperation du nom de l'utilisateur
					$account=getvalue($bdf,'STRUCTURE,STATUT','USER','IDENTIFIANT',$iduser);			
					$user=($account[0]?$account[0]:'');
					$statut=1-($account[0]?$account[1]:1);

					//recuperation du nom du pont
					$pont=getvalue($bds,'NOM','PONT','STRC',$iduser);			
					$pont=($pont[0]?$pont[0]:'');

			
					// collecte de l'utilisateur s'il est actif, ce pont en a, et si le fichier facture du pont existe
					if($statut && $iduser /*&& $fichier*/)
						if(!in_array($iduser,$tabiduser)){
							$tabiduser[]=$iduser;
							$tabuser[]=$user;
							$tabuser[]=array($user);
							// $tabpont[]=array($pont);
							$tabpath[]=array($path);
							$tabfile[]=array($file);
						}else{
							$position=array_search($iduser,$tabiduser);
							// $tabpont[$position][]=$pont;
							$tabpath[$position][]=$path;
							$tabfile[$position][]=$file;
						}
					
				 } //End du while
			 $result->closeCursor();	


				echo $nbexis." PDF Existent deja \n";
				echo $nbcree." PDF Crees \n";
				echo count($echecs)." Echec de creation du PDF ".implode(" | ",$echecs)." \n";
		

			// insertion ds la table tampon
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
					$s=((count($tabuser[$i])>1)?'s':'');
					$sujet="FACTURATION SOLAS DE ".strtoupper($month[intval($mois)-1])." ".$annee." POUR LE COMPTE DE ".strtoupper($tabuser[$i]);
					$message="Veuillez trouver ci-joint, ";
					$message.="vo".($s?'s':'tre')." facture".$s." SOLAS du mois de ".strtoupper($month[intval($mois)-1])." ".$annee.", ";
					$message.="pour la".$s." Structure".$s." suivant".$s.":<br/>";
					for($j=0;$j<count($tabuser[$i]);$j++)
						$message.=($j+1).". ".$tabuser[$i][$j]."<br/>";
					$message.="<br>Pour consulter les détails de ".($s?'ces':'cette')." facture".($s?'s':'').", cliquez sur le lien suivant: <a href=\"https://".$nom_site."\">".$appli."<a><br/>";
					$message.=" et connectez-vous avec l'identifiant et le mot de passe qui vous ont été fournis par la CCI-CI.<br/>";
					
					echo "Destinataires: ".$mails."\n";
					echo "Sujet: ".$sujet."\n";
					echo "Message: ".$message."\n";
					for($j=0;$j<count($tabuser[$i]);$j++)
						echo "	".$tabpont[$i][$j]."\n";
						
					$req =" UPDATE facture SET SEND_MAIL = '".$dateact."' WHERE ID_USER = '".$tabiduser[$i]."' ";
					$req .=" AND ANNEE >='".substr($debut,0,4)."' AND ANNEE<='".substr($fin,0,4)."'AND MOIS>='".substr($debut,5,2)."'AND MOIS<='".substr($fin,5,2)."'"; 
					 // var_dump($req);
					$res = $bdf->prepare($req);
					$res -> execute();
					envoimailfacture($mails,$sujet,$message,$tabpath[$i],$tabfile[$i]);
				}
							
			}//END Pour chaque utilisateur

		}//END S'il ya des tickets et (la bd tampon n'a pas encore ete generee ou les ponts ont ete specifies)
		
		

		return $tab;
	}//END FUNCTION
	
 	if($user=$_POST['id_strc']){
    	header('Content-type: application/json');
 		echo json_encode($tab);
 
  }
	 
?>