<?php
/**
 * Created by PhpStorm.
 * User: Stephane
 * Date: 23/04/2021
 * Time: 22:01
 */
	include_once('../functions/Isdayofrest_function.php');

//sens= + / -
function LastDay($bdd,$sens)
	{
	$decale=1;

	while(isdayofrest($bdd,date('Y-m-d',strtotime($sens.$decale." days"))) || in_array(date('w',strtotime($sens.$decale." days")),array(6,0)))
		$decale++;

	return $sens.$decale;
	}

?>