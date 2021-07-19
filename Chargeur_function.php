<?php

    include_once('Date_function.php');

    function GetChargeur ($bdd,$fact,$debut,$fin,$pont,$nbt,$count,$nom,$ide){
		$debut =  datesitetoserver($debut);
		$fin =  datesitetoserver($fin);
		$query = " SELECT COUNT(T.IDENTIFIANT) AS NBT, COUNT(T.IDENTIFIANT)*2750 AS COUT,CH.NOM,CH.IDENTIFIANT ";
		$query .= " FROM TICKET T,CHARGEUR CH,CORRESPONDANCE CO ";
		$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND CH.BLOCKED= 0 AND T.BLOCKED= 0 ";
		$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND CO.ORIGINAL = CH.IDENTIFIANT AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
		$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
		$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		if($pont=''){
			$query .=(!empty($pont)?"AND T.PONT ":"");
		}else{
			$query .=(!empty($pont)?" AND T.PONT='".$pont."' ":"");
		}
		$query .=" GROUP BY CH.IDENTIFIANT ORDER BY CH.NOM ";
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
		
			$tab[$i]=$donnees['IDENTIFIANT'];
			$i++;

			$tab[$i] = $donnees['NOM'];
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
	$tab=GetChargeur($bdd,0,$_POST['debut'],$_POST['fin'],$_POST['pont'],'','','',$_SESSION['ID']);

?>