<?php

	session_start();

	if(isset($_POST['x'])){

	$time=0;
	
	include('../config/Connexion.php');

	include('../functions/Update_action.php');

	$tab[0] = 0;
	}

	$_SESSION = array();

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>
