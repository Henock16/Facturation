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
	include_once('../functions/Produit_function.php');

	
	//liste des chargeur
	function GetUsersFac($debut,$fin,$user,$pont,$type,$strc){
	//function GetPonts($debut,$fin,$pont,$cafe,$cajou,$autres){

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
		
		//$res = GetSQLPonts($debut,$fin,$pont,$cafe,$cajou,$autres);
		$res = GetReqUser($debut,$fin,$user,$pont,$type,$strc);		
		$bdd = $res[0];
		$query = $res[1];
		// var_dump($query);
			// $month = array("janvier","fevrier","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","decembre");

		

	//echo $query;

		//Si les factures n'ont pas ete generees, attendre qu'elles le soit
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
			$tab[$i]=10;
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
			// $tab[$i]=$query;
			// $i++;

			//si pas de pont specifie et la bd est solas
			//initialisation de la requete d'insertion dans la  table tampon
			$insert=((($bdd==$bds)&&(!$user))?"INSERT":"");
			

			while ($donnees =$result->fetch()){
				//Construction de la requete d'insertion dans la table tampon
				$insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,NBCH,NBTC,MONTANT) VALUES":","):"");
				// $insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,PONT,NBCH,NBTC,MONTANT) VALUES":","):"");
				//	$insert.=($insert?"('".$annee."','".$mois."',".$cafe.",".$cajou.",".$autres.",".$donnees['PONT'].",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees['MONTANT'].")":"");
				$insert.=($insert?"('".$annee."','".$mois."',".$type.",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees['MONTANT'].")":"");

				//compte d'utilisateur du pont
				$account=getvalue($bdf,'IDENTIFIANT','PONT','ID_PONT',$donnees['IDENTIFIANT']);
				
				$tab[$i] = $donnees['IDENTIFIANT'];
				$i++;

				$tab[$i]=$donnees['STRUCTURE'];
				$i++;
				// $ch=substr($donnees['MOIS'],1);
				$ch=$donnees['MOIS'];
				$tab[$i] =($moiss[$ch-1])/*strftime('%B',strtotime($ch))/*$donnees['MOIS']*/;
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
				//Pont ayant un compte d'utilisateur ou non
				$tab[$i]=($account[0]?$account[0]:0);
				$i++;		
				
				//nom de la structure ayant le compte d'utilisateur
				// $struct=((($bdd==$bdf)||($pont))?($account[0]?getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE',/*'PONT'*/'','ID_PONT',/*$donnees['PONT']*/'')):"");
				// $tab[$i]=((($bdd==$bdf)||($pont))?($struct[0]?$struct[0]:''):"");
				// $i++;						
		
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

	//$tab=GetPonts($_POST['debut'],$_POST['fin'],$_POST['pont'],$_POST['cafe'],$_POST['cajou'],$_POST['autres']);
	// $t=[$_POST['cafe'],$_POST['autres']];
	$type=array();	
	if($_POST['cafe']==1 && $_POST['autres']==0)
			$type=2;
		else if($_POST['cafe']== 0 && $_POST['autres']==1)
			$type=1;
		else if($_POST['cafe']== 1 && $_POST['autres']==1)
			$type= 3;
	$tab=GetUsersFac($_POST['debut'],$_POST['fin'],$_POST['user_id'],$_POST['pont'],$type,$_POST['strc']);

     
    header('Content-type: application/json');
    echo json_encode($tab);

?>