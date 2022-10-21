<?php
/*
    Date creation : 29-08-2022
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: La fonction qui permet de crée le code du ticket et de l'incrementé 
*/

include_once('Complete_function.php');
include_once('../config/Connexion.php');
include_once('../functions/Table_value_function.php');

//les diferrentes fonctions sont utiliser pour constituer le numeros des factures et passer au numeros suivant en ajoutant +1 
function Numfact($bdd,$type)
{
	global $bdf,$bds;

	$bdd=$bdf;

	$nom=($type==2) ? 32 : 31;

	$years=date("y");
	
	$index = nextIndex($bdd, $type, $nom);
	
	$numfac = formatNumFac($years, $index, $type);

	$query2 =" UPDATE PARAMETRE SET VALEUR = '".$numfac."' WHERE IDENTIFIANT IN('".$nom."') ";
					 
	$resultat2 = $bdf->prepare($query2);
	
	$resultat2->execute();

	return $numfac;

}

function nextIndex($bdd, $type, $nom) {
	$query = "SELECT VALEUR FROM PARAMETRE WHERE IDENTIFIANT =".$nom;
	
	$result =$bdd ->query($query);	
	
	$data = $result->fetch();

	$lastRef = $data['VALEUR'];

	if($type==1) {
		$condition = intval(substr($lastRef,-2)) >= 99 && intval(substr($lastRef,-4, -2)) !== $years;
		return $condition ? 1 : intval(substr($lastRef,-2)) + 1;
	}
	
	$condition = intval(substr($lastRef,-4)) >= 9999 && substr($lastRef,-4, -2) !== $years;
	return $condition ? 1 : intval(substr($lastRef,-4)) + 1;	
}

function formatNumFac($years, $index, $type) {
	return ($type==1) ? "SOLCC".$years.Complete($index, 2) : "SOL".$years.(Complete($index,4)); 
}

?>