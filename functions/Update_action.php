<?php

	$last_page=$_SESSION['LAST_PAGE'];

	$query = $bdd -> prepare("UPDATE User SET DERNIERE_ACTION = :time,LAST_PAGE=:last_page WHERE IDENTIFIANT = :id");
	$query -> bindParam(':time', $time, PDO::PARAM_INT);
	$query -> bindParam(':last_page', $last_page, PDO::PARAM_STR);
	$query -> bindParam(':id', $_SESSION['ID'], PDO::PARAM_INT);
	$query -> execute();
	$query -> closeCursor();
	$bdd = null;

?>
