<?php
/*
    Date creation : 25-05-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 25-05-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Obtenir les affectations
*/
	session_start();

	include('../config/Connexion.php');
	include_once('../functions/Date_function.php');
	include_once('../functions/Table_value_function.php');
	include_once('../functions/Last_day_function.php');

	//liste des chargeur
	function GetChargeur ($bdd,$user,$fact,$debut,$fin,$ide,$ville,$nom,$bloc,$com,$adgeo,$numcc,$tel,$email,$bp){
		$query = "SELECT * FROM chargeur ";
		$result=$bdd->query($query);

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
		$nb=0;
	
		$tab[$i]=10;
		$i++;

		while ($donnees = $result->fetch()){
		
			$tab[$i]=$donnees['IDENTIFIANT'];
			$i++;
	
			$tab[$i]=$donnees['NOM'];
			$i++;
	
			$tab[$i] = $donnees['BLOCKED'];
			$i++;
	
			$tab[$i]=$donnees['VILLE'];
			$i++;
	
			$tab[$i] = $donnees['COMMUNE'];
			$i++;
	
			$tab[$i] = $donnees['ADRESSE_GEO'];
			$i++;
	
			$tab[$i] = $donnees['NUM_CC'];
			$i++;

			$tab[$i] = $donnees['TELEPHONE'];
			$i++;

			$tab[$i] = $donnees['EMAIL'];
			$i++;

			$tab[$i] = $donnees['BP'];
			$i++;
	
		}
		$result->closeCursor();	
		$tab[0] = $nb;
	
		return $tab;
	}
	$tab=GetChargeur($bdd,$_SESSION['ID'],0,$_POST['debut'],$_POST['fin'],$_SESSION['ID'],'','','','','','','','','');

    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);

?>