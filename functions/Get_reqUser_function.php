<?php
/*
    Date creation : 14-07-2021
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: Requete de recherche des chargeurs exclus et des styructures 
*/
function GetReqUser($debut,$fin,$user,$pont,$type,$strc,$char){
    global $tarif,$bdf,$bds;
		

		$bdd=$bdf;
		
		/////requete de l'affichage des chargeurs exclus
		$query =  " SELECT U.IDENTIFIANT AS IDENTIFIANT, U.STRUCTURE AS STRUCTURE,F.MOIS AS MOIS,F.ANNEE AS ANNEE,F.NBPONT As PONT,F.NBTC AS NBTC,F.MONTANT AS MONTANT ,P.ID_PONT AS ID_P,F.TYPE AS TYPE
		          ,F.SEND_MAIL,F.ID_CHAR AS TYPES   FROM user U,pont P,facture F  ";
		$query .= " WHERE F.TYPE NOT BETWEEN '".$type."'AND'".$type."'AND F.ID_USER = U.IDENTIFIANT AND P.ID_USER = F.ID_USER";
		$query .= " AND F.ANNEE >='".substr($debut,0,4)."' AND F.ANNEE<='".substr($fin,0,4)."' AND F.MOIS>='".substr($debut,5,2)."'AND F.MOIS<='".substr($fin,5,2)."'"; 
		$query .= (!empty($strc)?" AND F.ID_USER IN(".$strc.") ":"");
		$query.="GROUP BY U.STRUCTURE , F.MOIS,F.TYPE";
		////union des deux requete 
		$query.=" UNION ";
		///requete de l'affichage des structures
		$query .=  " SELECT C.IDENTIFIANT AS IDENTIFIANT, C.NOM AS STRUCTURE,F.MOIS AS MOIS,F.ANNEE AS ANNEE, F.NBPONT as PONT,F.NBTC AS NBTC,F.MONTANT AS MONTANT ,F.IDENTIFIANT AS ID_P,F.TYPE AS TYPE,F.SEND_MAIL,F.ID_CHAR AS TYPES  FROM chargeur C,facture F   ";
		$query .= " WHERE F.TYPE NOT BETWEEN '".$type."'AND'".$type."'AND F.ID_CHAR = C.IDENTIFIANT AND C.STATUT=0 ";
		$query .= " AND F.ANNEE >='".substr($debut,0,4)."' AND F.ANNEE<='".substr($fin,0,4)."' AND F.MOIS>='".substr($debut,5,2)."'AND F.MOIS<='".substr($fin,5,2)."'"; 
		$query .= (!empty($char)?" AND F.ID_CHAR IN(".$char.") ":"");
		$query.="GROUP BY C.NOM, F.MOIS,F.TYPE";
		
		
		$result = $bdd -> query ($query);

		
        return array($bdd,$query);
}