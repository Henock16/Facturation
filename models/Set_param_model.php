<?php
/*
    Date creation : 14-07-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 14-07-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Sauvegarder la liste des parametres
*/
	session_start();

	include('../config/Connexion.php');


	function SetParams($bdd,$user){

		$query="SELECT * FROM PARAMETRE WHERE IDENTIFIANT>0 ORDER BY IDENTIFIANT ASC";
		$result=$bdd->query($query);


		while ($lign = $result->fetch())
			if(isset($_POST[$lign['NOM']])){
			
			$query="UPDATE PARAMETRE SET VALEUR='".$_POST[$lign['NOM']]."' WHERE NOM='".$lign['NOM']."' ";
			$bdd->exec($query);
		}
		$result->closeCursor();	

		$tab[0]=0;
		return $tab;
	}
	
    $tab=SetParams($bdf,$_SESSION['ID']);

    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);

?>