<?php
//include_once('Users_get_request_applicant_function.php');
//include_once('User_get_request_details.php');
//include_once('User_get_request_evolution.php');
//include_once('Format_nom_function.php');
//include_once('Chargeur_function.php');
include_once('Date_function.php');
include_once('Chiffre_en_lettre_function.php');


 function getRequestHtml($bdd,$id,$uploadrep,$debut,$fin,$pont){

    
         $debut =  datesitetoserver($debut);
         $fin =  datesitetoserver($fin);
         $query = " SELECT  COUNT(T.IDENTIFIANT) AS NBT, COUNT(T.IDENTIFIANT)*2750 AS COUT, T.DATE_RECEPT,T.HEURE_RECEPT,T.CHARGEUR ,T.N_DOSSIER_BOOKING,T.N_CONTENEUR_1, ";
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
      $cli=$result->fetch();
      $client= $cli['CHARGEUR'];
      $nbr= $cli['NBT'];
      $cout=$cli['COUT'];
     
      //$date=new DateTime($cli['DATE_RECEPT']);
      
      setlocale(LC_TIME, 'fr_FR',"French");
      $date1=$cli['DATE_RECEPT'];
      $date=strftime("%B", strtotime($date1));
      $anne=substr($cli['DATE_RECEPT'],0,4);

      

     
   //  $dmd=GetChargeur($bdd,0,$_POST['debut'],$_POST['fin'],$_POST['pont'],'','','',$_SESSION['ID']);
	// $stat=getvalue($bdd,$id,'IDENTIFIANT','demande','STATUT');

   
   //$result = substr($data['IDENTIFIANT'],0,5);

   


      //$query = $bdd -> query("SELECT DATE_CREATION FROM demande WHERE IDENTIFIANT = ".$id);
      $mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	
   //  $date = dateservertosite(substr($data['DATE_CREATION'],0,10));

    $border=';border: 1px solid black;border-collapse: collapse;padding-left:0px;padding-right:10px';
    $titre=';font-size: 60px;font-weight: bold;font-family: Arial Black;';
    $titre1=';font-weight: bold;font-family: Arial Black;';
    $align=';text-align: center;';
   $html='<img width="300px" height="60px" src="../images/cci.jpg" alt="profile"/> 
            <br>
            <br>
            <br>
            <table width="100%">
                  <tr>
                     <td><p style="'.$titre1.'">N&deg; COMPTE CONTRIBUABLE: 9-206.388.X</p></td>
                     <td colspan="2"><p style="'.$titre1.'"><u>DOIT :</u></p></td>
                  </tr>
                  <tr>
                     <td> <p style="'.$titre1.'">Regime du reel normal</p>
                     </td>
                     <td style="'.$titre1.'">'.$client.'</td>
                  </tr>
                  <tr>
                     <td><p style="'.$titre1.'">Centre des Impots : Direction de grandes entreprises</p></td>
                     <td></td>
                  </tr>
                  <tr>
                     <td><p style="'.$titre1.'">Banque: UBA COTE DIVOIRE</p></td>
                     <td></td>
                  </tr>
                  <tr>
                     <td><p style="'.$titre1.'">COMPTE : CI150 0100 101090011461</p></td>
                     <td></td>
                  </tr>
                  <tr>
                     <td>BP </td>
                     <td>ABIDJAN  18</td>
                  </tr>
                  <tr>
                     <td></td>
                     <td> </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td> NCC: 
                    </td>
                  </tr>
            </table>';

  
   $html.='<br>     <p style="'.$titre.'"> FACTURE</p>
            <table style="'.$border.'"  border=1 width="100%">
               <thead>
                  <tr height="60px">
                     <th>NUMERO</th>
                     <th>DATE</th>
                     <th>CENTRE DE PROFIT</th>
                     <th>N&deg; COMPTE</th>
                     <th>CPTE GENERAL</th>
                  </tr>
               </thead>
               <tbody>
                  <tr height="60px">
                     <td>SOLL76567</td>
                     <td>'.strftime('%d/%m/%Y').'</td>
                     <td align="center"><p>SOLAS</p></td>
                     <td></td>
                     <td></td>
                  </tr>
               </tbody>
               
            </table>
                    
                <br> ';

////////////////////////////////////////////////IDENTIFICATION DE L'AGENT///////////////////////////////////////////////

   // $agent=get_request_applicant($bdd,$id,0);
  
   
    $border=';border:1px solid black;border-collapse:collapse;padding-left:5px;padding-right:5px;vertical-align:top;';
    $nom=';font-size: 5px;font-weight: bold;';
    $val='';

    $html.='<br> <table style="'.$border.'" width="100%">
                     
                        <tr> 
                           <th style="border: 1px solid black;" >Nb</th>
                           <th style="border: 1px solid black;" >REFERENCE</th>
                           <th style="border: 1px solid black;" ><p>DESIGNATION</p></th>
                           <th style="border: 1px solid black;" ><p>NBRE</p></th>
                           <th style="border: 1px solid black;" ><p>PRIX</p></th>
                           <th style="border: 1px solid black;" ><p>MONTANT HT</p></th>
                        </tr>
                        <tr height="80px">
                           <td style="border: 1px solid black;" align="center" rowspan="2"><br><br>1</td>
                           <td style="border: 1px solid black;" align="center" rowspan="2"><br><br><br>CONV.SOLAS</td>
                           <td style="border: 1px solid black;" align="center" rowspan="2">CONVENTION SOLAS
                           CERTIFICATION & TRANSMISSION DES VGM <br><br> Mois De '. $date.' '.$anne.'</td>
                           <td style="border: 1px solid black;" align="center" rowspan="2"> <br><br><br> '.$nbr.'</td>
                           <td style="border: 1px solid black;" align="center" rowspan="2"><br><br><br> 2750</td>
                           <td style="border: 1px solid black;" align="center" rowspan="2"><br><br><br> '.$cout.'</td>
                        </tr>
                        
                        <tr>
                           <td style="border:0px;"></td>
                           <td style="border:0px;" align="center"></td>
                           <td style="border:0px;" align="center"></td>
                           <td style="border:0px;" align="center"></td>
                           <td style="border:0px;" align="center"></td>
                           <td style="border:0px;" align="center"></td>
                        </tr>
                        
              </table>
              
               <br><br>';

   
   
    

///////////////////////////////////////////////////////DETAILS DE LA DEMANDE///////////////////////////////////////////////
$border=';border:1px solid black;border-collapse:collapse;padding-left:5px;padding-right:5px;vertical-align:top;';
//$nom=';font-size: 5px;font-weight: bold;';
$tableaux=';display: inline-block; vertical-align:top;';
$val='';
$conversion =int2str($cout);

$html.='<br>
               <table style="border-collapse: collapse;" class="'.$tableaux.'"  width="100%">
                  <tr>
                     <td><p style="'.$titre1.'">Arrete la presente facture a la somme de :</p></td>
                     <td style="border: 1px solid black;">MONTANT HT</td>
                     <td style="border: 1px solid black;">ACOMPTE </td>
                     <td style="border: 1px solid black;" >MONTANT </td>
                  </tr>
                     <tr>
                     <td><p style="'.$titre1.'"><u>'.$conversion.' FCFA</u></p></td>
                     <td height="45px" style="border: 1px solid black;" align="center">'.$cout.'</td>
                     <td height="45px" style="border: 1px solid black;" align="center"></td>
                     <td height="45px" style="border: 1px solid black;" align="center">'.$cout.'</td>
                  </tr>
               </table>
               <br>
               <br>
            
            ';

$html.='<br>
<table width="100%">
      <tr>
         <td><p style="'.$titre1.'">Condition de paiement:</p></td>
         <td colspan="2"></td>
         <td> </td>
      </tr>
      <tr>
         <td> <p style="'.$titre1.'">A payer des reception de la facture</p>
         </td>
         <td></td>
      </tr>
</table>';

$html.='<br>
<table width="100%">
      <tr>
         <td><p style="'.$titre1.'">NB:Veuillez etablir,le cheque a l ordre de:</p></td>
         <td > </td>
         <td rowspan="3"> <br>LE CHEF DE DEPARTEMENT COMPTABLE ET FINANCIER</td>
      </tr>
      <tr>
         <td> <p style="'.$titre1.'">Chambre de commerce et d Industlie de CI-SOLAS</p>
         </td>
         <td></td>
      </tr>
      <tr>
         <td> <p style="'.$titre1.'">ou CCICI-SOLAS</p>
         </td>
         <td></td>
      </tr>
</table><br><br><br><br><br><br>';
///////////////////////////////////////////////////////DEUXIEME PAGES ///////////////////////////////////////////////

    return $html;
}
?>