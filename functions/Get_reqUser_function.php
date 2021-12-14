<?php
function GetReqUser($debut,$fin,$user,$pont,$type){
    global $tarif,$bdf,$bds;

		$bdd=$bdf;
		
		$query =  " SELECT U.IDENTIFIANT AS IDENTIFIANT, U.STRUCTURE AS STRUCTURE,COUNT(P.ID_PONT) As PONT,F.NBTC AS NBTC,F.MONTANT AS MONTANT ,P.ID_PONT AS ID_P
		            FROM user U,pont P,facture F  ";
		$query .= " WHERE F.TYPE='".$type."'AND F.ID_USER = U.IDENTIFIANT AND P.ID_USER = F.ID_USER";
		$query .= " AND F.ANNEE='".substr($debut,0,4)."' AND F.MOIS='".substr($debut,5,2)."' GROUP BY U.STRUCTURE";
		//$query .= (!empty($user)?" AND F.ID_USER IN(".$user.") ":"");
		
		$result = $bdd -> query ($query);

        return array($bdd,$query);
}