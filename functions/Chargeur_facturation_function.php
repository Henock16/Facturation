<?php
	 include('../config/Connexion.php');	
    function GetChargeurFac ($bdd){
		 global $bdf;
	
	 $query ="SELECT IDENTIFIANT FROM chargeur  WHERE STATUT = 0";
			$bdd=$bdf;
	 $result = $bdd -> query ($query);
	 $id=array();
		
		 while ($donnees = $result->fetch()){
			 
			 //IDENTIFIANT
			$id[] = $donnees['IDENTIFIANT'];
		 }
		 $result->closeCursor();	
		 return array($id);
		//  json_encode($id);
		
	}
	
?> 
		
	
 