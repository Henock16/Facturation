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
	include_once('../functions/Produit_function.php');
	include_once('../functions/Nom_chargeur_function.php');

	
	//liste des chargeur
	function GetChargeur ($bdd,$debut,$fin,$pont,$cafe,$cajou,$autres){
		$debut =  datesitetoserver($debut);
		$fin =  datesitetoserver($fin);

		$critere=Produit($cafe,$cajou,$autres);
		

		$query = " SELECT COUNT(DISTINCT T.IDENTIFIANT) AS NBT, COUNT(DISTINCT T.IDENTIFIANT)*2750 AS COUT,CO.ORIGINAL ";
		$query .= " FROM TICKET T,CORRESPONDANCE CO ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" , CORRESPROD CP ");
		$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 ";
		$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT = CP.DERIVE AND CP.ORIGINAL ".$critere);	
		$query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")");	
		$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
		$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		$query .=(!empty($pont)?" AND T.PONT='".$pont."' ":"");
		$query .=" AND CO.ORIGINAL <> 0 ";
		$query .=" GROUP BY CO.ORIGINAL";


		//echo $query;



		$result = $bdd -> query ($query);

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
		$nb=0;
	
		$tab[$i]=4;
		$i++;

		while ($donnees = $result->fetch()){
			
			
			$tab[$i] = $donnees['ORIGINAL'];
			$i++;
		
			$tab[$i]=GetNomChargeur($bdd,$donnees['ORIGINAL']);
			$i++;

			$tab[$i]=$donnees['NBT'];
			$i++;

			$tab[$i]=$donnees['COUT'];
			$i++;

			
			
	
		}
		$result->closeCursor();	
		$tab[0] = $nb;
	
		return $tab;
	}

	$tab=GetChargeur($bdd,$_POST['debut'],$_POST['fin'],$_POST['pont'],$_POST['cafe'],$_POST['cajou'],$_POST['autres']);

     
    header('Content-type: application/json');
    echo json_encode($tab);

?>