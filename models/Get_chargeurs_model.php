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
	include_once('../functions/Date_function.php');
	include_once('../functions/Produit_function.php');
	include_once('../functions/Nom_chargeur_function.php');

	
	//liste des chargeur
	function GetChargeur ($bdd,$debut,$fin,$pont,$cafe,/*$cajou*/$autres){

		global $tarif;
		
		$debut =  datesitetoserver($debut);
		$fin =  datesitetoserver($fin);
		$pont =((empty($pont))? $_SESSION["ID_PONT"] : $pont);

		// echo $_SESSION['ID_PONT'];
		 

		$critere=Produit($cafe,/*$cajou*/$autres);
		
		$query = " SELECT  T.N_CONTENEUR_1 ,  CO.ORIGINAL ";
		// $query = " SELECT COUNT(DISTINCT T.N_CONTENEUR_1) AS NBTC, COUNT(DISTINCT T.N_CONTENEUR_1)*".$tarif." AS COUT,CO.ORIGINAL ";
		$query .= " FROM TICKET T,CORRESPONDANCE CO ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" , CORRESPROD CP ");
		$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 ";
		$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT = CP.DERIVE AND CP.ORIGINAL ".$critere);	
		$query .= ((!empty($cafe)/*&&!empty($cajou)*/&&!empty($autres))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")");	
		$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
		$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		$query .=(!empty($pont)?" AND T.PONT='".$pont."' ":"");
		$query .=" ORDER BY T.N_CONTENEUR_1,T.DATE_RECEPT DESC,T.HEURE_RECEPT DESC";
		// $query .=" GROUP BY CO.ORIGINAL";


		// echo $query;
		$result = $bdd -> query ($query);

		$nbtc=0;
		$cnt="";
		$tabchar=array();
		$tabtick=array();
		 while ($donnees = $result->fetch()){
			 
			if($cnt!=$donnees["N_CONTENEUR_1"]){
				
				$cnt=$donnees["N_CONTENEUR_1"];
			 
				if(!in_array($donnees["ORIGINAL"],$tabchar)){
					$tabchar[]=$donnees["ORIGINAL"];
					$tabtick[]=1;
				}else
					$tabtick[array_search($donnees["ORIGINAL"],$tabchar)]++;

				$nbtc++;
			}               
 
		 }
		

		$i=0;
		$tab[$i]=0;
		$i++;
	
		$tab[$i]=count($tabchar) ;
		$i++;
	
		$tab[$i]=4;
		$i++;

		$j=0;

		while ($j< count($tabtick)){
			
			
			$tab[$i] = $tabchar[$j];
			$i++;
		
			$chargeur=GetNomChargeur($bdd,$tabchar[$j]);
			
			$tab[$i]=($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)');
			$i++;

			$tab[$i]=$tabtick[$j];
			$i++;

			$tab[$i]=number_format(($tabtick[$j]*$tarif),0,""," ")." F";
			$i++;

			
			$j++;
	
		}
		// $result->closeCursor();	
	
		return $tab;
	}

	$tab=GetChargeur($bds,$_POST['debut'],$_POST['fin'],$_POST['pont'],$_POST['cafe'],'',$_POST['autres']);

     
    header('Content-type: application/json');
   echo json_encode($tab);

?>