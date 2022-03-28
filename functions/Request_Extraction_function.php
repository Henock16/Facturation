<?php
include_once('../functions/Produit_function.php');

	function requestExtraction($pont,$chrg,$debut,$fin,$type){
        $critere=Produit($type);

		$sql= " SELECT T.DATE_RECEPT,CO.ORIGINAL,T.HEURE_RECEPT,T.CHARGEUR ,T.N_DOSSIER_BOOKING,T.N_CONTENEUR_1, ";
        $sql .= " T.N_PLOMB_1,T.TRANSITAIRE,T.COMPAGNIE_MARITIME,T.CHARGEUR, ";
        $sql .= " T.METHODE_DE_PESEE_VGM,T.POIDS_VGM,T.PRODUIT,T.N_CONTRAT,T.chp57,T.DATE_EMIS ";
		$sql .= " FROM TICKET T,CORRESPONDANCE CO ";
		$sql .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 ";
		$sql .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
		$sql .= ((!empty($type))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.") ");	
		$sql .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
		$sql .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		$sql .=(!empty($pont)?" AND T.PONT='".$pont."' ":"");
		$sql .=" ORDER BY T.N_CONTENEUR_1,T.DATE_RECEPT DESC,T.HEURE_RECEPT DESC";
					
		return  $sql;
	}
?>
