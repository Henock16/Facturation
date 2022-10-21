<?php
/*
    Date creation : 14-07-2022
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: Requete d'insertion en bd des chargeurs exclus 
*/
	include_once('../functions/Produit_function.php');
	include_once('../functions/Chargeur_facturation_function.php');
	include_once('../functions/Users_get_nbticket.php');
	
	function GetSQLPonts($debut,$fin,$user,$pont,$type){
		
		global $tarif,$bdf,$bds;
		
		$bdd=$bdf;
		
		$query =  " SELECT ID_USER, NBCH, NBTC,NBPONT,MONTANT FROM FACTURE ";
		$query .= " WHERE TYPE IN('".$type."')";
		$query .= " AND ANNEE >='".substr($debut,0,4)."' AND ANNEE<='".substr($fin,0,4)."' AND MOIS>='".substr($debut,5,2)."'AND MOIS<='".substr($fin,5,2)."'"; 
		$query .= " AND ID_CHAR = 0";
			$result = $bdd -> query ($query);

		//si aucun resultat trouve on attaque la requete lourde
		if($result -> rowCount()==0){
			
			$bdd=$bds;
			 $critere=Produit($type);
			 $exclu=GetChargeurFac ($bdd);
			 $exclu=implode(",",$exclu[0]);
			 $nbtc=getNbticket($pont,$debut,$fin,$type,$user);

			$query =  " SELECT T.PONT, P.STRC,CO.ORIGINAL, COUNT(DISTINCT CO.ORIGINAL) AS NBCH,$nbtc AS NBTC,COUNT(T.PONT) AS NBPONT";
			// $query .= $nbtc*$tarif." AS MONTANT ";
			$query .= " FROM TICKET T,CORRESPONDANCE CO,PONT P ";
			$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT= P.ID_PONT ";
			$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>0 ";
			$query .= " AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";		
			$query .= (!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
			$query .= (!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
			$query .=(!empty($pont)?" AND T.PONT IN('".$pont."')":" ");
			$query .= (!empty($user)?" AND P.STRC IN('".$user."')":" ");
			$query .= (!empty($exclu)?" AND CO.ORIGINAL NOT IN(".$exclu.")":" ");
			$query .= " GROUP BY P.STRC";
		}
		
		return array($bdd,$query);
	}
?>