<?php
//include_once('Users_get_request_applicant_function.php');
//include_once('User_get_request_details.php');
//include_once('User_get_request_evolution.php');
//include_once('Format_nom_function.php');
//include_once('Chargeur_function.php');
include_once('Date_function.php');
include_once('Chiffre_en_lettre_function.php');


 function getRequestHtmlpages2($bdd,$id,$uploadrep,$debut,$fin,$pont){

    
         $debut =  datesitetoserver($debut);
         $fin =  datesitetoserver($fin);
         $query = " SELECT T.DATE_RECEPT,T.HEURE_RECEPT,T.CHARGEUR ,T.N_DOSSIER_BOOKING,T.N_CONTENEUR_1, ";
         $query .= " T.N_PLOMB_1,T.TRANSITAIRE,T.COMPAGNIE_MARITIME, CH.NOM AS CHARGEUR,P.NOM AS PONT,";
         $query .= " T.METHODE_DE_PESEE_VGM,T.POIDS_VGM,T.PRODUIT,T.N_CONTRAT,T.chp57,T.DATE_EMIS,P.VILLE ";
         $query .= " FROM TICKET T,CHARGEUR CH,CORRESPONDANCE CO,PONT P ";
         $query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 ";
         $query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND CO.ORIGINAL = ".$id." AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
         $query .= " AND CO.ORIGINAL= CH.IDENTIFIANT AND T.PONT= P.ID_PONT";
         $query .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
         $query .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
         $query .=(!empty($pont)?" AND T.PONT='".$pont."' ":"");
      $result = $bdd -> query ($query);
    //   $cli=$result->fetch();
    //   $client= $cli['CHARGEUR'];
     
      //$date=new DateTime($cli['DATE_RECEPT']);
      
      setlocale(LC_TIME, 'fr_FR',"French");
    //   $date1=$cli['DATE_RECEPT'];
    //   $date=strftime("%B", strtotime($date1));
    //   $anne=substr($cli['DATE_RECEPT'],0,4);

      

     
   //  $dmd=GetChargeur($bdd,0,$_POST['debut'],$_POST['fin'],$_POST['pont'],'','','',$_SESSION['ID']);
	// $stat=getvalue($bdd,$id,'IDENTIFIANT','demande','STATUT');

   
   //$result = substr($data['IDENTIFIANT'],0,5);

   


      //$query = $bdd -> query("SELECT DATE_CREATION FROM demande WHERE IDENTIFIANT = ".$id);
    


///////////////////////////////////////////////////////DEUXIEME PAGES ///////////////////////////////////////////////
$border=';border: 1px solid black;border-collapse: collapse;padding-left:0px;padding-right:10px';
$titre=';font-size: 100px;font-weight: bold;font-family: Arial Black;';
$titre1=';font-weight: bold;font-family: Arial Black;';
$align=';text-align: center;';
$center=';margin: auto;';


   $html1='<table style="'.$border.'" border=1  width="100%">
               <tr style="'.$border.'" border=1 bgcolor="#87ceeb">
                  <td>DATE DE PESEE</td>
                  <td>CLIENT</td>
                  <td>CONTENEUR</td>
                  <td>BOOKING</td>
                  <td>PLONB</td>
                  <td>COMPAGNIE MARITINE</td>
                  <td>PONT</td>
                  <td>TRANSITAIRE</td>
                  <td>PRODUIT</td>
                  <td>VILLE</td>
                  <td>POIDS VOM</td>
                  <td>DOSSIER</td>
               </tr>

               ';
              

             
               
             
            $i=0;
             while ($donnees = $result->fetch()){
               
               
                $html1.="
                  <tr border=1>
                  <td>".$donnees['DATE_RECEPT']." </td>
                  <td>".$donnees['CHARGEUR']." </td>
                  <td>".$donnees['N_CONTENEUR_1']." </td>
                  <td>".$donnees['N_DOSSIER_BOOKING']." </td>
                  <td>".$donnees['N_PLOMB_1']." </td>
                  <td>".$donnees['COMPAGNIE_MARITIME']." </td>
                  <td>".$donnees['PONT']." </td>
                  <td>".$donnees['TRANSITAIRE']." </td>
                  <td>".$donnees['PRODUIT']." </td>
                  <td>".$donnees['VILLE']." </td>
                  <td>".$donnees['POIDS_VGM']." </td>
                  <td>".$donnees['chp57']." </td>
                  </tr>";
                  
                  $i++;
                 
                  $client= $donnees['CHARGEUR'];
                  $date1=$donnees['DATE_RECEPT'];
                  $date=strftime("%B", strtotime($date1));
                  

             }

             //pour le nombre et le cout des tickets
             $cout= $i*(2750);
             
             
             
             
             
             
               $html1.='
                  <tr bgcolor="#87ceeb">
                     <td colspan="3">TOTAL</td>
                     <td align="center" colspan="3">MOIS DE '. $date.'</td>
                     <td colspan="4">'.$i.'</td>
                     <td align="center" colspan="2">'.$i*(2750).'</td>
               </tr>
            </table>';
            

            $html1.='<br>
         
         <div style="background-color: #87ceeb;  word-spacing: 15em;" width="100%">
            
                  TOTAL-GENERAL
            
                  '.$i.'
                  '.$cout.'
         </div>';

         $entete='<br>
         <br><br><br><br>
         <p>CHAMBRE DE COMMERCE ET D INDUSTRIE DE COTE D IVOIRE</p>
         <br>
         <br>
         <div style="'.$border.''.$align.'text-align: center; border: 2px solid black; margin-left: 80px;"   width="80%">
                 <p style="'.$titre.'">LISTE DES PESEES CLIENTS</p> 
              
            
         </div>
<br>';
setlocale(LC_ALL, 'fr_FR', 'fra_FRA');

$entete.='<br> 
         <table style="'.$center.'" width="95%">
         <tr>
            <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour Le Client :</p></td>
            <td><p style="'.$titre1.'">'.$client.'</p></td>
            <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour La Facture :</p></td>
            <td><p style="'.$titre1.'">SOL176567</p></td>
            <td  style="'.$border.'" border=1 bgcolor="#87ceeb"><p>du :</p></td>
            <td><p style="'.$titre1.'">'.strftime('%d %B %Y').'</p></td>
          </tr>

         </table> <br>';


    return $entete.$html1;
}
?>