<?php
function GetReqUser($debut,$fin,$user,$pont,$type,$strc){
    global $tarif,$bdf,$bds;
		

		$bdd=$bdf;
		
		$query =  " SELECT U.IDENTIFIANT AS IDENTIFIANT, U.STRUCTURE AS STRUCTURE,F.MOIS AS MOIS,F.ANNEE AS ANNEE,COUNT(P.ID_PONT) As PONT,F.NBTC AS NBTC,F.MONTANT AS MONTANT ,P.ID_PONT AS ID_P,F.TYPE AS TYPE
		            FROM user U,pont P,facture F  ";
		$query .= " WHERE F.TYPE NOT BETWEEN '".$type."'AND'".$type."'AND F.ID_USER = U.IDENTIFIANT AND P.ID_USER = F.ID_USER";
		// $query .= " AND F.ANNEE='".substr($debut,0,4)."' AND F.MOIS='".substr($fin,5,2)."' GROUP BY U.STRUCTURE";
		// $query .= " AND CONCAT(F.ANNEE ,'-', F.MOIS) BETWEEN CONCAT(F.ANNEE='".substr($debut,0,4)."' ,'-', F.MOIS='".substr($debut,5,2)."') AND CONCAT(F.ANNEE='".substr($fin,0,4)."' ,'-', F.MOIS='".substr($fin,5,2)."')"; 
		$query .= " AND F.ANNEE >='".substr($debut,0,4)."' AND F.ANNEE<='".substr($fin,0,4)."' AND F.MOIS>='".substr($debut,5,2)."'AND F.MOIS<='".substr($fin,5,2)."'"; 
		$query .= (!empty($strc)?" AND F.ID_USER IN(".$strc.") ":"");
		$query.="GROUP BY U.STRUCTURE , F.MOIS,F.TYPE";
		// $query.="ORDER BY U.STRUCTURE ";
		

		// $query .= (!empty($user)?" AND F.ID_USER IN(".$user.") ":"");
		// $query .= (!empty($pont)?" AND P.ID_PONT IN(".$pont.") ":"");
		
		$result = $bdd -> query ($query);

		// var_dump(substr($debut,0,4));
		// var_dump($query);
		// echo json_decode($result);
        return array($bdd,$query);
}