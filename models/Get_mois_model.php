<?php
/*
    Date creation : 20-04-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 20-04-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Obtenir la liste des inspecteurs affectables
*/

	include_once('../functions/Complete_function.php');


function GetMois($year){

	$month = array("janvier","fevrier","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","decembre");

	$annee=date('Y');

	$i=0;
	$tab[$i]=0;
	$i++;
	
	$tab[$i]=0;
	$i++;
	
	$tab[$i]=2;
	$i++;
	
	$mois=1;
	while($mois<=12 && ($year<$annee || Complete($mois,2)< date('m'))){
		
		$tab[$i]=Complete($mois,2);
		$i++;

		$tab[$i]=strtoupper($month[$mois-1]);
		$i++;
 		
		$mois++;
	}	
	$tab[1]=$mois-1;

	return $tab;
	}
	
    $tab=GetMois($_POST['critere']);

    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);

?>