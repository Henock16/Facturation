<?php
/*
    Date creation : 25-05-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 25-05-2021
    Dernier modificateur : Cellule SOLAS - ABRS
    Description: Obtenir les affectations
*/
	session_start();

	include('../config/Connexion.php');
    include_once('../functions/Get_UsersPonts_function.php');
 	
	
	//liste des users 

    function GetUsers($bdd){
		
		
        $query = " SELECT * FROM USER WHERE TYPE = 2 ORDER BY STRUCTURE";

        //echo $query;

		$result = $bdd -> query ($query);

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
	
		$tab[$i]=6;
		$i++;

        while ($donnees = $result->fetch()){
			
            $tab[$i] = $donnees['IDENTIFIANT'];
			$i++;

            $tab[$i] = $donnees['STATUT'];
			$i++;

            $tab[$i] = $donnees['FIRST_CONNECTION'];
			$i++;

            $tab[$i] = $donnees['LOGIN'];
			$i++;

            $tab[$i] = $donnees['STRUCTURE'];
			$i++;

			$ponts = GetUsersPonts($donnees['IDENTIFIANT']);

			$nbpt=0;
			for($j=0;$j<count($ponts[2]);$j++){
				$stat=explode("-",$ponts[2][$j]);
				$nbpt+=$stat[0];
			}
            $tab[$i] = $nbpt;
			$i++;

        }


        $result->closeCursor();	
	
		return $tab;

    }
    $tab= GetUsers($bdf);

    header('Content-type: application/json');
    echo json_encode($tab);
?>