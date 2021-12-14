<?php

    function GetNomPont($bdd,$id){
		
		$query = "SELECT NOM FROM PONT WHERE ID_PONT='".$id."'";
		$result = $bdd -> query ($query);

		$donnees = $result->fetch();	
		$nom = $donnees['NOM'];
		$result->closeCursor();

		return $nom;
	}

?>