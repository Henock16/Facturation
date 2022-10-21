<?php
/*
    Date creation : 16-05-2022
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: Fonction qui ramene le nom du chargeur à partir du ID 
*/
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

?>