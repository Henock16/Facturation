<?php

	include_once('../functions/Produit_function.php');
	
    //function GetSQLPonts($debut,$fin,$pont,$cafe,$cajou,$autres){
	function GetSQLPonts($debut,$fin,$user,$pont,$type){

		global $tarif,$bdf,$bds;

		$bdd=$bdf;
		
		$query =  " SELECT ID_USER, NBCH, NBTC, MONTANT FROM FACTURE ";
		$query .= " WHERE TYPE=".$type;
		//$query .= " WHERE CAFE=".$cafe." AND CAJOU=".$cajou." AND  AUTRES=".$autres." ";
		$query .= " AND ANNEE='".substr($debut,0,4)."' AND MOIS='".substr($debut,5,2)."' ";
		//$query .= (!empty($pont)?" AND PONT IN(".$pont.") ":"");
		$query .= (!empty($user)?" AND ID_USER IN(".$user.") ":"");
		
		$result = $bdd -> query ($query);
		
		//si aucun resultat trouve on attaque la requete lourde
		if($result -> rowCount()==0){
			
			$bdd=$bds;
			//$critere=Produit($cafe,$cajou,$autres);
			 $critere=Produit($type);

			$query =  " SELECT T.PONT, COUNT(DISTINCT CO.ORIGINAL) AS NBCH, COUNT(DISTINCT T.N_CONTENEUR_1) AS NBTC, ";
			$query .= " COUNT(DISTINCT T.N_CONTENEUR_1)*".$tarif." AS MONTANT ";
			$query .= " FROM TICKET T,CORRESPONDANCE CO ";
			// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" , CORRESPROD CP ");
			$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 ";
			$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>0 ";
			// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT = CP.DERIVE AND CP.ORIGINAL ".$critere);	
			//$query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")");
			 $query .= ((!empty($type))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")");		
			$query .= (!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
			$query .= (!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
			$query .= (!empty($pont)?" AND T.PONT IN(".$pont.") ":"");
			//$query .= (empty($pont)?" GROUP BY T.PONT":"");
			$query .= " GROUP BY T.PONT";
		}
		
		return array($bdd,$query);
	}

?>