<?php
    // session_start();
	include('../config/Connexion.php');

    $bdd = $bdf;
    $query ="SELECT IDENTIFIANT,NOM,NUM_CC FROM chargeur  WHERE STATUT = 0";

    $result = $bdd -> query ($query);

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
	
		$tab[$i]=3;
		$i++;

        while ($donnees = $result->fetch()){
			
            //NUMERO COMPTE
            $tab[$i] = $donnees['NUM_CC'];
            $i++;

            //CHARGEUR
            $tab[$i] = $donnees['NOM'];
            $i++;


             //IDENTIFIANT
            $tab[$i] = $donnees['IDENTIFIANT'];
            $i++;
        }
        // $query -> closeCursor();

    header('Content-type: application/json');
    echo json_encode($tab);
?>