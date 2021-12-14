<?php

	session_start(); //demarrage de la session
 
	include_once('../config/Connexion.php');


	$id = $_SESSION['ID'];
	$mdp = $_POST['mdp'];
		
	
	$reponse = $bdf->prepare("UPDATE USER SET PASS=:mdp, FIRST_CONNECTION=1 WHERE IDENTIFIANT=:id");
	$reponse -> bindParam(':mdp', $mdp, PDO::PARAM_STR);
	$reponse -> bindParam(':id', $id, PDO::PARAM_INT);
	$reponse -> execute();



	$bdd = NULL;

	$result['0'] = 0 ;
		
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($result) ;

?>	
