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
	include_once('../functions/Chargeur_facturation_function.php');
	include_once('../functions/Nom_chargeur_function.php');
	include_once('../functions/Nom_pont_function.php');
	include_once('../functions/Table_value_function.php');
	include_once('../functions/Chargeur_facturation_function.php');

	
	//liste des chargeur
	function GetChargeur($bdd,$debut,$fin,$pont,$user,$cafe,$autres){

			global $tarif,$type,$char,$bdf,$bds;
			
			$debut =  datesitetoserver($debut);
			$fin =  datesitetoserver($fin);
			$char=$_POST['char'] ;
			$mois=$_POST['mois'];
			// $annee=substr($fin,0,4);
			$annee=$_POST['annee'];
			 $exclu=GetChargeurFac ($bdd);
			$exclu=implode(",",$exclu[0]);
			// $pont =((empty($pont))? $_SESSION["ID_PONT"] : $pont);
			if($cafe==1 && $autres==0)
				$type='1';
				// $type='1,0';
			elseif($cafe==0 && $autres ==1)
				$type='2';

				$critere=Produit($type);
			if($char ==0 || $char=='')
			{
				$query = " SELECT  T.N_CONTENEUR_1 ,  CO.ORIGINAL,T.PONT/*,COUNT(DISTINCT T.N_CONTENEUR_1) AS NBTC*/ ";
			$query .= " FROM TICKET T,CORRESPONDANCE CO, PONT P";
			$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT=P.ID_PONT";
			$query.=" AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
			$query .=" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";	
			$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$annee."/".$mois."/01/' ":"");
			$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$annee."/".$mois."/31' ":"");
			$query .=(!empty($user)?" AND P.STRC='".$user."'":"");
			$query .= (!empty($exclu)?" AND CO.ORIGINAL NOT IN(".$exclu.")":" ");
			// $query.="GROUP BY T.PONT,CO.ORIGINAL ";
			// $query .= "GROUP BY T.N_CONTENEUR_1";
			$query .="ORDER BY T.PONT,T.N_CONTENEUR_1,T.DATE_RECEPT DESC,T.HEURE_RECEPT DESC";
			}else
			{
				$query = " SELECT  T.N_CONTENEUR_1 ,  CO.ORIGINAL,T.PONT ";
			$query .= " FROM TICKET T,CORRESPONDANCE CO, PONT P";
			$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT=P.ID_PONT";
			$query.=" AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
			$query .=" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";	
			$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$annee."/".$mois."/01/' ":"");
			$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$annee."/".$mois."/31' ":"");
			$query .=(!empty($user)?" AND CO.ORIGINAL='".$char."'":"");
			// $query .= "GROUP BY T.N_CONTENEUR_1";
			$query .=" ORDER BY T.PONT,T.N_CONTENEUR_1,T.DATE_RECEPT DESC,T.HEURE_RECEPT DESC";
			}
			
			

			// var_dump ($query);
			$result = $bdd -> query ($query);

			$nbtc=0;
			$cnt="";
			
			$tabchar=array();
			$tabtick=array();
			$tabpont=array();
			$idpont="";

			
			 while ($donnees = $result->fetch()){
			 	
				if($cnt!=$donnees["N_CONTENEUR_1"]){
					
					$cnt=$donnees["N_CONTENEUR_1"];
				 
					if(!in_array($donnees["ORIGINAL"],$tabchar)){
						$tabchar[]=$donnees["ORIGINAL"];
						$tabpont[]=$donnees["PONT"];
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

			// $tab[$i]= ;
			// $i++;
		
			$tab[$i]=6;
			$i++;
			$j=0;


			while ($j< count($tabtick)){
				
				$tab[$i] = $tabchar[$j];
					$i++;
			
			 		$chargeur=GetNomChargeur($bdd,$tabchar[$j]);
			 		$nompont=GetNomPont($bdd,$tabpont[$j]);

					
					$tab[$i]=($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)');
					$i++;

					$tab[$i]=$tabtick[$j];
					$i++;


					$tab[$i]=number_format(($tabtick[$j]*$tarif),0,""," ")." F";
					$i++;

					$tab[$i]=$tabpont[$j];
					$i++;

					$tab[$i]=$nompont;
					$i++;

				
				$j++;
				// var_dump($i.''.$j,json_encode($i.''.$j));
				//   json_encode($i.''.$j);
				// var_dump(json_encode($i.''.$j));
			// echo json_encode($i.''.$j);
			// echo json_decode($i.''.$j);
			}
			
		 	$result->closeCursor();	
			
		 	return $tab;
			//  $reponse =array($tab,$i,$j);
	 }	
$tab=GetChargeur($bds,$_POST['debut'],$_POST['fin'],/*$_POST['pont']*/'',$_POST['user_id'],$_POST['cafe'],$_POST['autres']);

     
    header('Content-type: application/json');
 echo json_encode($tab);
// var_dump(json_encode($tab));

?>