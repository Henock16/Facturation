<?php
/*
    Date creation : 18-05-2021
    Auteur : Cellule SOLAS - ABR0 Stephane
    Version:1.0
    Dernière modification : 18-05-2021
    Dernier modificateur : Cellule SOLAS - ABR0 Stephane
    Description: Obtenir les details d'un inspecteur
*/
	session_start();

	include('../config/Connexion.php');
    include_once('../functions/Get_UsersPonts_function.php');

    function GetUserDetails($bdd,$id,$iduser){
		
		$query = " SELECT * FROM USER WHERE IDENTIFIANT = ".$id."  ";  

		//requete SQL
		$reponse=$bdd->query($query);
        // echo $query;

        $i=0;
		$tab[$i]=0;
		$i++;
	
		$n=$reponse->rowCount();
		if($n>0)
			$donnees = $reponse->fetch();

		$tab[$i] = ($n?$donnees['STATUT']:0);
		$i++;
					
		$tab[$i] = ($n?$donnees['STRUCTURE']:'');
		$i++;

		$tab[$i] = ($n?$donnees['LOGIN']:'');
		$i++;
					
		$tab[$i] = ($n?$donnees['NUM_CC']:'');
		$i++;
					
		$tab[$i] = ($n?$donnees['BP']:'');
		$i++;
					
		$tab[$i] = ($n?$donnees['TELEPHONE']:'');
		$i++;
					
		$tab[$i] = ($n?$donnees['ADRESSE_GEO']:'');
		$i++;
					
		$tab[$i] = ($n?$donnees['ACOMPTE']:'');
		$i++;
					
		$ponts = GetUsersPonts($n?$donnees['IDENTIFIANT']:0);
		 
		$tab[$i] = $ponts[0];
		$i++;
					
		$tab[$i] = $ponts[1];
		$i++;
					
		$tab[$i] = $ponts[2];
		$i++;
									
	return $tab;
	}

    $tab= GetUserDetails($bdf,$_POST['id'],$_SESSION['ID']);

    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);

?>