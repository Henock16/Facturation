<?php
    session_start();
	include('../config/Connexion.php');

    $bdd = $bdf;
    $query ="SELECT IDENTIFIANT,NOM FROM CHARGEUR WHERE STATUT=0";

    $result = $bdd -> query ($query);

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
	
		$tab[$i]=2;
		$i++;

        while ($donnees = $result->fetch()){
			
            //IDENTIFIANT
            $tab[$i] = $donnees['IDENTIFIANT'];
			$i++;

            //MATRICULE
            $tab[$i] = $donnees['NOM'];
            $i++;
        }
        // $query -> closeCursor();

    header('Content-type: application/json');
    echo json_encode($tab);
?>