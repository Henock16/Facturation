<?php
    session_start();

    include('../config/Connexion.php');
	include_once('../functions/Date_function.php');
	include_once('../functions/Table_value_function.php');
	include_once('../functions/Get_reqUser_function.php');
	include_once('../functions/Produit_function.php');
    include_once('../functions/Complete_function.php');
    
    
    function GetTexte($debut,$fin,$pont,$type,$strc){
        global $tarif,$bdf,$bds;
    
        $fichiertxt=fopen('texte/facturation.txt','c+b');
       
            $debut =  datesitetoserver($debut);
		    $fin =  datesitetoserver($fin);
    
        $moiss = array('janvier','fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre');

            $bdd=$bdf;
            
            $query =  " SELECT U.IDENTIFIANT AS IDENTIFIANT, U.STRUCTURE AS STRUCTURE,F.MOIS AS MOIS,F.ANNEE AS ANNEE,F.NBPONT As PONT,F.NBTC AS NBTC,F.MONTANT AS MONTANT ,F.NBPONT as PONT,F.TYPE AS TYPE ,F.SEND_MAIL,F.ID_CHAR AS TYPES,F.NUM_FACTURE AS NUMFAC,U.NUM_CC AS NUM_CC
                        FROM user U,facture F  ";
            $query .= " WHERE F.TYPE NOT BETWEEN '".$type."'AND'".$type."'AND F.ID_USER = U.IDENTIFIANT ";
            $query .= " AND F.ANNEE >='".substr($debut,0,4)."' AND F.ANNEE<='".substr($fin,0,4)."' AND F.MOIS>='".substr($debut,5,2)."'AND F.MOIS<='".substr($fin,5,2)."'"; 
            $query .= (!empty($strc)?" AND F.ID_USER IN('".$strc."') ":" ");
            $query.="GROUP BY U.STRUCTURE , F.MOIS,F.TYPE";
            $query.=" UNION ";
            $query .=  " SELECT C.IDENTIFIANT AS IDENTIFIANT, C.NOM AS STRUCTURE,F.MOIS AS MOIS,F.ANNEE AS ANNEE, F.NBPONT as PONT,F.NBTC AS NBTC,F.MONTANT AS MONTANT ,F.IDENTIFIANT AS ID_P,F.TYPE AS TYPE,F.SEND_MAIL,F.ID_CHAR AS TYPES,F.NUM_FACTURE AS NUMFAC,C.NUM_CC AS NUM_CC   FROM chargeur C,facture F   ";
            $query .= " WHERE F.TYPE NOT BETWEEN '".$type."'AND'".$type."'AND F.ID_CHAR = C.IDENTIFIANT AND C.STATUT=0 ";
            $query .= " AND F.ANNEE >='".substr($debut,0,4)."' AND F.ANNEE<='".substr($fin,0,4)."' AND F.MOIS>='".substr($debut,5,2)."'AND F.MOIS<='".substr($fin,5,2)."'"; 
            $query .= (!empty($char)?" AND F.ID_CHAR IN(".$char.") ":" ");
            $query.="GROUP BY C.NOM, F.MOIS,F.TYPE";
          
    

    $result = $bdd -> query ($query);

		$i=0;
		$tab[$i]=0;
		$i++;

		$tab[$i]='texte/facturation.txt';
		$i++;
	
		$tab[$i]=$result -> rowCount();
		$i++;
	
		$tab[$i]=8;
		$i++;

        $tabulation=' ';
        $inutile1='"';
        $inutile2='   ';//3espace
        $inutile3='       ';//7""
        $inutile4='        ';//8""
        $code_j='VEN';
        // $datepiece=date("dmy");
        $cmpt_colec=411230;
        $numprod=706109;

        while ($donnees = $result->fetch()){
                /////La premiere ligne de la facture solas
            $datepiece='01'.$tab[$i]=Complete($donnees['MOIS'],1);
            $datepiece.=$tab[$i]=substr($donnees['ANNEE'],-2);
                fwrite( $fichiertxt,$inutile1.$code_j.$datepiece.$tab[$i] = $donnees['NUMFAC']);
                fwrite($fichiertxt,$inutile2);
				$i++;

                fwrite( $fichiertxt,$cmpt_colec);
                fwrite($fichiertxt,$inutile3);
                $i++;

                fwrite( $fichiertxt,$tab[$i]=$donnees['NUM_CC']);
                fwrite($fichiertxt,$inutile4);
                $i++;

                fwrite($fichiertxt,'FACTURE SOLAS'.$tab[$i]=$donnees['NUMFAC'].'             ');
                $i++;
                fwrite($fichiertxt,$tab[$i]=Complete($donnees['MONTANT'],12).'D');
                $i++;
                fwrite($fichiertxt,'  SOLASG'.$inutile1."\r\n");
                $i++;
                /////La deuxieme ligne de la facture avec n°de produit et la strucutre en plus
                  fwrite( $fichiertxt,$inutile1.$code_j.$datepiece.$tab[$i] = $donnees['NUMFAC']);
                fwrite($fichiertxt,$inutile2);
                $i++;

                fwrite( $fichiertxt,$numprod);
                fwrite($fichiertxt,$inutile3);
                $i++;

                fwrite( $fichiertxt,'         ');
                fwrite($fichiertxt,$inutile4);
                $i++;

                fwrite($fichiertxt,substr('FACTURE '.$tab[$i]=$donnees['STRUCTURE'],0,35).Carractere('FACTURE '.$tab[$i]=$donnees['STRUCTURE'],''));
                $i++;
                fwrite($fichiertxt,$tab[$i]=Complete($donnees['MONTANT'],12).'C11');
                $i++;
                fwrite($fichiertxt,'SOLASG'.$inutile1."\r\n");
                $i++;
                /////La troisieme ligne de la facture
                 fwrite( $fichiertxt,$inutile1.$code_j.$datepiece.$tab[$i] = $donnees['NUMFAC']);
                fwrite($fichiertxt,$inutile2);
                $i++;

                fwrite( $fichiertxt,$numprod);
                fwrite($fichiertxt,$inutile3);
                $i++;

                fwrite( $fichiertxt,'         ');
                fwrite($fichiertxt,$inutile4);
                $i++;

                fwrite($fichiertxt,substr('FACTURE '.$tab[$i]=$donnees['STRUCTURE'],0,35).Carractere('FACTURE '.$tab[$i]=$donnees['STRUCTURE'],''));
                $i++;
                fwrite($fichiertxt,$tab[$i]=Complete($donnees['MONTANT'],12).'C11');
                $i++;
                fwrite($fichiertxt,'SOLASA'.$inutile1."\r\n");
                $i++;

				// fwrite( $fichiertxt,$tab[$i]=$donnees['STRUCTURE']);
    //             fwrite($fichiertxt,$tabulation);
				// $i++;
				// $ch=substr($donnees['MOIS'],1);

        }
        // $query -> closeCursor();
        return $tab;
    }
    if($_POST['cafe']==1 && $_POST['autres']==0)
    $type=2;
    else if($_POST['cafe']== 0 && $_POST['autres']==1)
    $type=1;
    else if($_POST['cafe']== 1 && $_POST['autres']==1)
    $type= 3;
    // $tab=GetTexte($debut,$fin,$user,$pont,$type,$strc);
        // $tab=GetTexte($debut,$fin,$user,$pont,$type,$strc);
    $tab=GetTexte($_POST['debut'],$_POST['fin'],$_POST['pont'],$type,$_POST['strc']);
    header('Content-type: application/json');
    echo json_encode($tab);

           
           
?>