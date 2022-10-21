<?php
/*
    Date creation : 25-05-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 25-05-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Obtenir les affectations
*/

//use function PHPSTORM_META\type;

session_start();

	include('../config/Connexion.php');
	include_once('../functions/Date_function.php');
	// include_once('Get_mois_model.php');
	include_once('../functions/Table_value_function.php');
	include_once('../functions/Get_reqUser_function.php');
	include_once('../functions/Get_Id_pont_chargeurex.php');
	include_once('../functions/Produit_function.php');

	
	//liste des chargeur
	function GetUsersFac($debut,$fin,$user,$pont,$type,$strc,$char){

		global $cout,$bdf,$bds,$genfact;

		setlocale(LC_TIME, 'french');
		
		$debut =  datesitetoserver($debut);
		$fin =  datesitetoserver($fin);

		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);
		// $anneedebut=substr($debut,0,4);
		// $moisdebut=substr($debut,5,2);
		// $anneefin=substr($fin,0,4);
		// $moisfin=substr($fin,5,2);
		$moiss = array('janvier','fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre');
		
		$res = GetReqUser($debut,$fin,$user,$pont,$type,$strc,$char);	
		$bdd = $res[0];
		$query = $res[1];
		// $idpont= GetIdPont ($bds,$char);
		if(($bdd==$bds)&&(!$genfact))
			$tab[0]=1;
		else{
			
			$result = $bdd -> query ($query);

			$i=0;
			$tab[$i]=0;
			$i++;
			//1-lignes
			$tab[$i]=$result -> rowCount();
			$i++;
			$nb=0;
			//2-colonnes
			$tab[$i]=11;
			$i++;
			//3-total des tickets
			$tab[$i]=0;
			$i++;
			//4-cout total  
			$tab[$i]=0;
			$i++;
			//5-total des ponts n'ayant pas de compte d'utilisateur
			$tab[$i]=0;
			$i++;
			
			//si pas de pont specifie et la bd est solas
			//initialisation de la requete d'insertion dans la  table tampon
			$insert=((($bdd==$bds)&&(!$user))?"INSERT":"");
			

			while ($donnees =$result->fetch()){
				//Construction de la requete d'insertion dans la table tampon
				$insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,NBCH,NBTC,NBPONT,MONTANT) VALUES":","):"");
				$insert.=($insert?"('".$annee."','".$mois."',".$type.",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees[' NBPONT'].",".$donnees['MONTANT'].")":"");

				//compte d'utilisateur du pont
				$account=getvalue($bdf,'IDENTIFIANT','PONT','ID_PONT',$donnees['IDENTIFIANT']);

				// pour trouver l'id du
				// $nomchar=getvalue($bds,'DERIVE','CORRESPONDANCE','ORIGINAL',$char);
				
				$tab[$i] = $donnees['IDENTIFIANT'];
				$i++;

				$tab[$i]=$donnees['STRUCTURE'];
				$i++;
		
				$ch=$donnees['MOIS'];
				$tab[$i] =/*($moiss[$ch-1])*/$ch;
				$i++;

				$tab[$i] = $donnees['ANNEE'];
				$i++;

				$tab[$i] = $donnees['TYPE'];
				$i++;

				$tab[$i] = $donnees['PONT'];
				$i++;

				// $tab[$i]=$donnees['NBCH'];
				// $i++;

				$tab[$i]=number_format($donnees['NBTC'],0,""," ");
				$i++;

				$tab[$i]=number_format($donnees['MONTANT'],0,""," ")." F";
				$i++;

				$tab[$i]=$donnees['ID_P'];
				$i++;

				$tab[$i]=$donnees['SEND_MAIL'];
				$i++;	

				$tab[$i]=$donnees['TYPES'];
				$i++;	
				
						
		
				//3-total des tickets
				$tab[3]+=$donnees['NBTC'];
				//4-cout total  
				$tab[4]+=$donnees['MONTANT'];
				//5-total des ponts n'ayant pas de compte d'utilisateur
				$tab[5]+=($account[0]?0:1);

			}
			$result->closeCursor();	
			
			//3-total des tickets
			$tab[3]=number_format($tab[3],0,""," ");
			//4-cout total  
			$tab[4]=number_format($tab[4],0,""," ");

			//insertion ds la table tampon
			if($insert && $insert!="INSERT"){		
				$query = $bdf->prepare($insert.";");
				$query->execute();
				$query->closeCursor();
			}
		}
			
			return $tab;
	}

	
	if($_POST['cafe']==1 && $_POST['autres']==0)
			$type=2;
		else if($_POST['cafe']== 0 && $_POST['autres']==1)
			$type=1;
		else if($_POST['cafe']== 1 && $_POST['autres']==1)
			$type= 3;
$tab=GetUsersFac($_POST['debut'],$_POST['fin'],$_POST['user_id'],$_POST['pont'],$type,$_POST['strc'],$_POST['char']);
    header('Content-type: application/json');
    echo json_encode($tab);
    // echo new JResponseJson($tab);

?>