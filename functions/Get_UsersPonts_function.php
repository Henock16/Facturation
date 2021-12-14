<?php

    
    //Activation désactivation
    function GetUsersPonts($iduser){

		global $bdf,$bds;

        $query = " SELECT ID_PONT,ID_USER,IMPAYES,STATUT FROM PONT WHERE IDENTIFIANT>0 ORDER BY IDENTIFIANT ASC";

		$result = $bdf -> query($query); 
		
		$pont=array();
		$user=array();
		$unpaid=array();
		$statut=array();
		$pont[]=0;
		$user[]=0;
		$unpaid[]=0;
		$statut[]=0;

        while ($donnees = $result->fetch()){

			$pont[]=$donnees['ID_PONT'];
			$user[]=$donnees['ID_USER'];
 			$unpaid[]=$donnees['IMPAYES'];
  			$statut[]=$donnees['STATUT'];
        }
        $result->closeCursor();	


        $query = " SELECT ID_PONT,NOM FROM PONT WHERE TYPE IN(1,2)
		AND NOT(BLOCKED=1 AND DISABLED=1) AND ID_PONT NOT IN(2,46,86,87,88,91,149,212) 
		ORDER BY NOM";

		$result = $bds -> query ($query);

		$id=array();
		$nom=array();
		$select=array();

        while ($donnees = $result->fetch()){
			
			$position=array_search($donnees['ID_PONT'],$pont);
			$found=in_array($donnees['ID_PONT'],$pont);
			
			if(!$found || $statut[$position]==1 || ($user[$position]==$iduser && $statut[$position]==0)){
			
				$id[] = $donnees['ID_PONT'];
				$nom[] = $donnees['NOM'];
				$select[] = (($iduser && ($user[$position]==$iduser) && ($statut[$position]==0))?1:0)."-".($found?$unpaid[$position]:0);
			}
        }
        $result->closeCursor();	
		
		return array($id,$nom,$select);
	}

?>