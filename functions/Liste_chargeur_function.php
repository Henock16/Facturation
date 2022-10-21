<?php
/*
    Date creation : 29-08-2022
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
*/

    include_once('Date_function.php');
    include_once('../functions/Produit_function.php');
    include_once('../functions/Get_SQLChargeurs_function.php');

    function GetListChargeur ($bdd,$idchar,$pont){
		global $bds,$bdf;
            
            $critere=Produit($type);
            $exclu=GetChargeurFac ($bdf);
            $exclu=implode(",",$exclu[0]);

            $nom = "";

            $query =" SELECT DERIVE FROM CORRESPONDANCE CO ,TICKET T"; 
            $query.=" WHERE CO.ORIGINAL='".$idchar."' AND T.PONT IN(".$pont.")";
            
            $query .="GROUP BY CO.ORIGINAL";
            $result = $bdd -> query ($query);

            $donnees = $result->fetch();	
            $nom = (($result->rowCount()>0)?$donnees['DERIVE']:$nom);
            $result->closeCursor();
            return $nom;
	}

?>