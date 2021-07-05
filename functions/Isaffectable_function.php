<?php
/**
 * Created by PhpStorm.
 * User: Stephane
 * Date: 23/04/2021
 * Time: 22:01
 */
	include_once('../functions/Isdayofrest_function.php');

//date_reservee / plage / jour actuel/ heure actuelle / heure de delai
function isaffectable($bdd,$date_reserv,$plage,$jour,$heure,$heure_delai)
	{
	$decale=0;
	$affectable=0;
	$isaffectable=0;

	while (!$isaffectable && (strtotime(date('Y-m-d',strtotime("+".$decale." days")))<=strtotime($date_reserv))){
		
		//le jour courant est un jour de travail sil nest  pas (ferie) et nest pas samedi ni dimanche
		$working_time=(!isdayofrest($bdd,date('Y-m-d',strtotime("+".$decale." days"))) && !in_array(date('w',strtotime("+".$decale." days")),array(6,0))) ;

		//si le jour courant est un jour de travail et est le jour actuel et lheure actuel n'est pas expiree
		//ou si le jour courant est un jour de travail et est apres le jour actuel
		if($working_time  &&(($decale==0&& $heure < $heure_delai )||$decale>0))
		$affectable++;

		if($affectable && ((strtotime($date_reserv)==strtotime($jour) && $plage==2 && $heure < $heure_delai ) || (strtotime($jour)<strtotime($date_reserv) && $affectable>(2-($working_time?$plage:2)))))
		$isaffectable=1;	

		$decale++;
	}

	return $isaffectable;
	}

?>