<?php
//use Mpdf\Tag\Center;

include_once('../functions/Date_function.php');
include_once('../functions/Chiffre_en_lettre_function.php');
include_once('../functions/Produit_function.php');
include_once('../functions/Nom_chargeur_function.php');
include_once('../functions/Liste_chargeur_function.php');
include_once('../functions/Table_value_function.php');

   
function getChargeursHtml($pont,$debut,$fin,$type,$user,$numfac){


		 global $tarif,$bds,$bdf;
    
         $debut =  datesitetoserver($debut);
         $fin =  datesitetoserver($fin);
		   $annee=substr($debut,0,4);
		   $mois=substr($debut,5,2);
         $critere=Produit($type);
         $exclu=GetChargeurFac ($bdf);
         $exclu=implode(",",$exclu[0]);
         $account=getvalue($bdf,'VALEUR','PARAMETRE','IDENTIFIANT',($type==1)?31:32);
         $numfac=$account[0]; 
         

      setlocale(LC_TIME, 'fr_FR',"French");


///////////////////////////////////////////////////////DEUXIEME PAGES ///////////////////////////////////////////////
$border=';border: 1px solid black;border-collapse: collapse;padding-left:0px;padding-right:10px';
$titre=';font-size: 100px;font-weight: bold;font-family: Arial Black;';
$titre1=';font-weight: bold;font-family: Arial Black;';
$align=';text-align: center;';
$center=';margin: auto;';
            

   
         $entete='<br>
         <br><br><br><br>
         <p>CHAMBRE DE COMMERCE ET D INDUSTRIE DE COTE D IVOIRE</p>
         <br>
         <br>
         <div style="'.$border.''.$align.'text-align: center; border: 2px solid black; margin-left: 80px;"   width="80%">
                 <p style="'.$titre.'">LISTE DES CHARGEURS</p> 
              
            
         </div>
<br>';
setlocale(LC_ALL, 'fr_FR', 'fra_FRA');

           
            $query1 =  " SELECT T.PONT, CO.DERIVE,CO.ORIGINAL, COUNT(DISTINCT CO.ORIGINAL) AS NBCH, COUNT(DISTINCT T.N_CONTENEUR_1) AS NBTC,P.NOM ";
            $query1 .= " FROM TICKET T,CORRESPONDANCE CO,PONT P ";
            $query1 .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT= P.ID_PONT ";
            $query1 .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>0 ";
            $query1 .= " AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")";		
            $query1 .= (!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
            $query1 .= (!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
            $query1 .= (!empty($user)?" AND P.STRC IN('".$user."')":" ");
            $query1 .=(!empty($pont)?" AND T.PONT IN('".$pont."')":"");
            $query1 .= (!empty($exclu)?" AND CO.ORIGINAL NOT IN(".$exclu.")":" ");
            $query1 .=" GROUP BY CO.ORIGINAL ,T.PONT";
            $query1.=" ORDER BY T.PONT ";
                     
            
            
            $test = $bds -> query ($query1);
             $i=0;
             $tableaux='';
             $cntt=0;
            
             
              while( $donnees = $test->fetch() ){
             
               $chargeur=GetNomChargeur($bds,$donnees['ORIGINAL']);

                if($i>0 && $tableaux != $donnees['NOM']){


                     $entete.='
                     <tr bgcolor="#87ceeb">
                           <td colspan="4">TOTAL '.$tchar.'</td>
                           <td colspan="2" align="center" >'.$cntt.'</td>
               </table> <br>';          
               }
                
                if($tableaux != $donnees['NOM'])
                {
                  $tableaux = $donnees['NOM'];
                  $tchar=0;
                  $cntt=0;
                  $entete.='<br> 
                  <table style="'.$center.'" width="100%">
                  <tr width="100%">
                     <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour Le Pont :</p></td>
                     <td><p style="'.$titre1.'">'.$donnees['NOM'].'</p></td>
                     <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour La Facture :</p></td>
                     <td><p style="'.$titre1.'">'.$numfac.'</p></td>
                     <td  style="'.$border.'" border=1 bgcolor="#87ceeb"><p>du :</p></td>
                     <td><p style="'.$titre1.'">'.strftime('%d %B %Y').'</p></td>
                  </tr>';

               

                  $entete.='<tr style="'.$border.'" border=1 bgcolor="#87ceeb" width="100%">
                  <td colspan="4" >CHARGEUR</td>
                  <td colspan="2">CONTENEURS</td>
                  </tr>';
               }
                  
                  $entete.='<tr border=1>
                  <td colspan="4">'.($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)').'</td>
                  <td colspan="2" align="Center">'.$donnees['NBTC'].'</td>
                  </tr>';
                  if($tableaux == $donnees['NOM']){
                     $tchar++;
                     $cntt+=$donnees['NBTC'];
                  }
                  

                  

                  
                 
                 
         $i++;

       }


                $entete.='
                    <tr bgcolor="#87ceeb">
                           <td colspan="4">TOTAL '.$tchar.'</td>
                           <td colspan="2" align="center" >'.$cntt.'</td>
               </table> <br>';   

    return $entete;
}
?>