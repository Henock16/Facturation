<?php
/*
    Date creation : 20-04-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 20-04-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Obtenir la liste des inspecteurs affectables
*/

function GetAnnee(){

	$annee=date('Y')-2;
	$i=0;
	$tab[$i]=0;
	$i++;
	
	$tab[$i]=3;
	$i++;
	
	$tab[$i]=2;
	$i++;
	while ($annee<= date('Y')){
		
		$tab[$i]=$annee;
		$i++;

		$tab[$i]=$annee;
		$i++;
        $annee++;
	}	

	return $tab;
	}
	
    $tab=GetAnnee();

    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);

?>