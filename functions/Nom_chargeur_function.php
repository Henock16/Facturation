<?php

    include_once('Date_function.php');

    function GetNomChargeur ($bdd,$idchar){
		
		$nom = "";

		$query = " SELECT NOM  FROM CHARGEUR WHERE IDENTIFIANT='".$idchar."' AND IDENTIFIANT<>0  ";
		$result = $bdd -> query ($query);

		$donnees = $result->fetch();	
		$nom = (($result->rowCount()>0)?$donnees['NOM']:$nom);
		$result->closeCursor();

		return $nom;
	}
	// $tab=GetChargeur($bdd,$_POST['idchar']);

?>