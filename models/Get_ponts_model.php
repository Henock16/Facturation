<?php
/*
    Date creation : 25-05-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 25-05-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Obtenir les affectations
*/
	session_start();

	include('../config/Connexion.php');
	include_once('../functions/Date_function.php');
	include_once('../functions/Get_SQLPonts_function.php');
	include_once('../functions/Nom_pont_function.php');
	include_once('../functions/Table_value_function.php');

	
	//liste des chargeur
	function GetPonts($debut,$fin,$pont,$type){
	//function GetPonts($debut,$fin,$pont,$cafe,$cajou,$autres){

		global $cout,$bdf,$bds,$genfact;
		
		$debut =  datesitetoserver($debut);
		$fin =  datesitetoserver($fin);

		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);
		
		//$res = GetSQLPonts($debut,$fin,$pont,$cafe,$cajou,$autres);
		$res = GetSQLPonts($debut,$fin,$pont,'',$type);		
		$bdd = $res[0];
		$query = $res[1];

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
			$tab[$i]=7;
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
			$insert=((($bdd==$bds)&&(!$pont))?"INSERT":"");

			while ($donnees = $result->fetch()){
				
				//Construction de la requete d'insertion dans la table tampon
				$insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,NBCH,NBTC,MONTANT) VALUES":","):"");
				// $insert.=($insert?(($insert=="INSERT")?" INTO FACTURE(ANNEE,MOIS,TYPE,PONT,NBCH,NBTC,MONTANT) VALUES":","):"");
			//	$insert.=($insert?"('".$annee."','".$mois."',".$cafe.",".$cajou.",".$autres.",".$donnees['PONT'].",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees['MONTANT'].")":"");
				$insert.=($insert?"('".$annee."','".$mois."',".$type.",".$donnees['NBCH'].",".$donnees['NBTC'].",".$donnees['MONTANT'].")":"");

				//compte d'utilisateur du pont
			$account=getvalue($bdf,'ID_USER','PONT','ID_PONT',$donnees['ID_USER']);
				
				 $tab[$i] = $donnees['ID_USER'];
				 $i++;
			
				// $tab[$i]=GetNomPont($bds,$donnees['PONT']);
				// $i++;

				$tab[$i]=$donnees['NBCH'];
				$i++;

				$tab[$i]=number_format($donnees['NBTC'],0,""," ");
				$i++;

				$tab[$i]=number_format($donnees['MONTANT'],0,""," ")." F";
				$i++;

				//Pont ayant un compte d'utilisateur ou non
				$tab[$i]=($account[0]?$account[0]:0);
				$i++;		
				
				//nom de la structure ayant le compte d'utilisateur
				// $struct=((($bdd==$bdf)||($pont))?($account[0]?getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE',/*'PONT'*/'','ID_PONT',/*$donnees['PONT']*/'')):"");
				// $tab[$i]=((($bdd==$bdf)||($pont))?($struct[0]?$struct[0]:''):"");
				//  $i++;						
		
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
		if($_POST['cafe']==1 && $_POST['autres']==0)
			$type=1;
		else if($_POST['cafe']== 0 && $_POST['autres']==1)
			$type=1;
		else if($_POST['cafe']== 1 && $_POST['autres']==1)
			$type=1;
	$tab=GetPonts($_POST['debut'],$_POST['fin'],$_POST['pont'],$type);

     
    header('Content-type: application/json');
    echo json_encode($tab);

?>