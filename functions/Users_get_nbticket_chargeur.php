<?php
 include('../config/Connexion.php');
 include_once('../functions/Produit_function.php');
 include_once('../functions/Chargeur_facturation_function.php');
function getCharNbticket($pont,$debut,$fin,$type,$char){
///Récupération du nombre de ticket dans la meme requete que la liste des chargeurs.
global $bdf,$bds;
 		 $critere=Produit($type);
         $exclu=GetChargeurFac ($bdf);
         $exclu=implode(",",$exclu[0]);

     $query1 =  " SELECT T.PONT, CO.DERIVE,CO.ORIGINAL, COUNT(DISTINCT CO.ORIGINAL) AS NBCH, COUNT(DISTINCT T.N_CONTENEUR_1) AS NBTC,P.NOM";
            $query1 .= " FROM TICKET T,CORRESPONDANCE CO,PONT P ";
            $query1 .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT= P.ID_PONT ";
            $query1 .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>0 ";
            $query1 .= " AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";
            $query1 .= (!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
            $query1 .= (!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
            $query1 .= (!empty($char)?" AND CO.ORIGINAL IN(".$char.")":" ");
            $query1 .=" GROUP BY CO.ORIGINAL ,T.PONT";
            // $query1.=" ORDER BY T.PONT ";
                     
            
            
            $test = $bds -> query ($query1);
            $allnbtc=0;
            
            while($data = $test->fetch() ){
               $allnbtc+=$data['NBTC'];
            }
return $allnbtc;
// echo $allnbtc;
}
	// getNbticket('','2022-01-01','2022-01-31',2,'05');

?>