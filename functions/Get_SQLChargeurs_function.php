<?php

	include_once('../functions/Produit_function.php');
	include_once('../functions/Chargeur_facturation_function.php');
	include_once('../functions/Users_get_nbticket_chargeur.php');
    
    function GetSQLChargeurs($debut,$fin,$char,$pont,$type){
        global $tarif,$bdf,$bds;
		
		$bdd=$bdf;

        $query =  " SELECT ID_CHAR, NBCH, NBTC, NBPONT,MONTANT FROM FACTURE ";
		$query .= " WHERE TYPE IN('".$type."')";
		$query .= " AND ANNEE >='".substr($debut,0,4)."' AND ANNEE<='".substr($fin,0,4)."' AND MOIS>='".substr($debut,5,2)."'AND MOIS<='".substr($fin,5,2)."'"; 
		$query .= " AND ID_USER = 0";
		
			$result = $bdd -> query ($query);
//si aucun resultat trouve on attaque la requete lourde
            if($result -> rowCount()==0){
			
                $bdd=$bds;
                
                $critere=Produit($type);
                $exclu=GetChargeurFac ($bdd);
			 	$exclu=implode(",",$exclu[0]);
			 	$nbtc=getNbticket($pont,$debut,$fin,$type,$char);
                
            $query =  " SELECT CO.DERIVE,CO.ORIGINAL,T.PONT, P.NOM ,COUNT(DISTINCT CO.ORIGINAL) AS NBCH,$nbtc AS NBTC, COUNT(DISTINCT T.PONT) AS NBPONT";
			// $query .= " COUNT(DISTINCT T.N_CONTENEUR_1)*".$tarif." AS MONTANT ";
			$query .= " FROM TICKET T,CORRESPONDANCE CO,PONT P ";
            $query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT= P.ID_PONT ";
			$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>0 ";
            $query .= " AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";
            $query .= (!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
			$query .= (!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
            $query .=(!empty($pont)?" AND T.PONT IN('".$pont."')":"");
            $query .= (!empty($exclu)?" AND CO.ORIGINAL IN(".$exclu.")":" ");
            $query .= "GROUP BY CO.ORIGINAL";
			
            }
        return array($bdd,$query);
    }
?>