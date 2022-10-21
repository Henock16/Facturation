<?php
	include('../config/Connexion.php');
    include_once('Date_function.php');
    include_once('../functions/Produit_function.php');

// function GetIdPont nous permet de rechercher l'id d'un pont specifique 
    function GetIdPont ($bdd,$char){
		global $bdf,$bds;

		$bdd=$bds;
		$idchar = "";
		$critere=Produit($type);

		$query=" SELECT T.PONT, P.NOM" ;
		$query.=" FROM TICKET T,PONT P,CORRESPONDANCE CO ";
		$query.="WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT= P.ID_PONT AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>0"; 
		$query .= " AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";	
		$query .= (!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":""); 
		$query .= (!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		$query .= "AND CO.ORIGINAL IN(".$char.")";
		$query .= "GROUP BY CO.ORIGINAL";
		$result = $bdd -> query ($query);

		$donnees = $result->fetch();	
		$idchar = (($result->rowCount()>0)?$donnees['PONT']:$idchar);
		$result->closeCursor();

		return $idchar;
	}
	
?>