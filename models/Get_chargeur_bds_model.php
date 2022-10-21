<?php
    session_start();
	include('../config/Connexion.php');
    $bdd = $bds;

    $query ="SELECT IDENTIFIANT,NOM,NUM_CC FROM chargeur ORDER BY NOM ASC";
    $result = $bdd -> query ($query);

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
	
		$tab[$i]=3;
		$i++;

        while ($donnees = $result->fetch()){
			
            //IDENTIFIANT
            $tab[$i] = $donnees['IDENTIFIANT'];
			$i++;

            //CHARGEUR
            $tab[$i] = $donnees['NOM'];
            $i++;

            //NUMERO COMPTE
            $tab[$i] = $donnees['NUM_CC'];
            $i++;

        }

    header('Content-type: application/json');
    echo json_encode($tab);
?>