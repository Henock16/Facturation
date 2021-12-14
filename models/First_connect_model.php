<?php

	session_start(); //demarrage de la session
 
	include_once('../config/Connexion.php');


	$id = $_SESSION['ID'];
	$bp = $_POST['bp'];
	$tel = $_POST['tel'];
	$numcc = $_POST['numcc'];
	$adgeo = $_POST['adgeo'];
	$mdp = $_POST['mdp'];
	
	$reponse = $bdf->prepare("UPDATE EMAIL SET STATUT=1 WHERE ID_USER=:id ");
	$reponse -> bindParam(':id', $id, PDO::PARAM_INT);
	$reponse -> execute();

	$j = 0;
	while($j < $_POST['t2']){
		$mail = $_POST["mail".$j];
		
		$reponse = $bdf->prepare("SELECT * FROM EMAIL WHERE ID_USER=:id AND LIBELLE=:mail");
		$reponse -> bindParam(':mail', $mail, PDO::PARAM_STR);
		$reponse -> bindParam(':id', $id, PDO::PARAM_INT);
		$reponse -> execute();
		if($reponse -> rowCount()>0)	
			$reponse = $bdf->prepare("UPDATE EMAIL SET STATUT=0 WHERE ID_USER=:id AND LIBELLE=:mail");
		else
			$reponse = $bdf->prepare("INSERT INTO EMAIL (STATUT,LIBELLE,ID_USER) VALUES(0,:mail,:id)");
		$reponse -> bindParam(':mail', $mail, PDO::PARAM_STR);
		$reponse -> bindParam(':id', $id, PDO::PARAM_INT);
		$reponse -> execute();
		$j++;
	}

	
	$reponse = $bdf->prepare("UPDATE USER SET FIRST_CONNECTION=1, BP=:bp, TELEPHONE=:tel,
				NUM_CC=:numcc,ADRESSE_GEO=:adgeo,PASS=:mdp WHERE IDENTIFIANT=:id");
	$reponse -> bindParam(':bp', $bp, PDO::PARAM_STR);
	$reponse -> bindParam(':tel', $tel, PDO::PARAM_STR);
	$reponse -> bindParam(':numcc', $numcc, PDO::PARAM_STR);
	$reponse -> bindParam(':adgeo', $adgeo, PDO::PARAM_STR);
	$reponse -> bindParam(':mdp', $mdp, PDO::PARAM_STR);
	$reponse -> bindParam(':id', $id, PDO::PARAM_INT);
	
	$reponse -> execute();

	$_SESSION = array();

	$bdf = NULL;

	$result['0'] = 0 ;
		
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($result) ;

?>	
