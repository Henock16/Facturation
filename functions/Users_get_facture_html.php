<?php
include_once('Date_function.php');
include_once('../functions/Get_SQLPonts_function.php');
include_once('Chiffre_en_lettre_function.php');
include_once('../functions/Table_value_function.php');
include_once('../functions/Complete_function.php');


//  function getFactureHtml($pont,$debut,$fin,$cafe,$cajou,$autres){
   function getFactureHtml($pont,$debut,$fin,$type){

    
		global $mpdf,$cumul,$tarif,$bds,$bdf,$numcc,$regime,$impot,$bank,$compte,$tva,$signature;
 
		$debut =  datesitetoserver($debut);
        $fin =  datesitetoserver($fin);
		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);

//		$res = GetSQLPonts($debut,$fin,$pont,$cafe,$cajou,$autres);
      $res = GetSQLPonts($debut,$fin,$pont,$type);


		$bdd = $res[0];
		$query = $res[1];

        $result = $bdd -> query ($query);
        		 
		$donnees=$result->fetch();
		  
		$account=getvalue($bdf,'ID_USER,IMPAYES','PONT','ID_PONT',$pont);
		$user=($account[0]?getvalue($bdf,'STRUCTURE,BP,TELEPHONE,NUM_CC,ACOMPTE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE','PONT','ID_PONT',$pont));
		$bp=($account[0]?($user[1]?$user[1]:'&nbsp;'):'&nbsp;');
		$tel=($account[0]?($user[2]?$user[2]:'&nbsp;'):'&nbsp;');
		$ncc=($account[0]?($user[3]?$user[3]:'&nbsp;'):'&nbsp;');
		$acompte=($account[0]?($user[4]?$user[4]:'0'):'0');

		$nbtc= $donnees['NBTC'];
		$montant=$donnees['MONTANT'];
     
		$impayes=$account[1];

      
      setlocale(LC_TIME, 'fr_FR',"French");
 
	  $date=strftime("%B", strtotime($debut));
      $anne=substr($debut,0,4);

      
    $titre=';font-size: 30px;font-weight: bold;font-family: Arial Black;';
    $titre1='font-size: 13px;font-weight: bold;font-family: Arial Black;white-space: nowrap;';

	$entete= $titre1.'; font-style : italic;';
	$signe= $titre1.'; ';
 ///////////////////////////////////////////////ENTETE///////////////////////////////////////////////
   $html='<img width="300px" height="60px" src="../images/cci.jpg" alt="profile"/> 
            <br>
            <br>
            <br>
            <table width="100%">
                  <tr>
                     <td rowspan="8" width="60%" valign="top"><b><i>
					 <br/>
					 <br/>
					 <p style="'.$entete.' ">N&deg; COMPTE CONTRIBUABLE: '.htmlentities($numcc).'</p>
					 <p style="'.$entete.' white-space: nowrap;">'. htmlentities($regime).'</p>
					 <p style="'.$entete.' white-space: nowrap;">Centre des Imp&ocirc;ts: '.htmlentities($impot).'</p>
					 <p style="'.$entete.' white-space: nowrap;">Banque: '.htmlentities($bank).'</p>
                     <p style="'.$entete.' white-space: nowrap;">COMPTE: '.htmlentities($compte).'</p>
					 </i></b></td>
                     <td colspan="2"  width="40%"><p style="'.$titre.'font-size: 20px;">&nbsp;&nbsp;<u>DOIT :</u></p></td>
                  </tr>
                  <tr>
                     <td style="'.$titre.'font-size: 30px;" width="50%">'.$user[0].'</td>
                  </tr>
                  <tr>
                     <td width="40%">&nbsp;</td>
                 </tr>
                  <tr>
                     <td width="40%">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="40%">
					 <p style="'.$titre1.' white-space: nowrap;">'.$bp.'</p>
					 </td>
                  </tr>
                  <tr>
                     <td width="40%">
					 <p style="'.$titre1.' white-space: nowrap;">'.$tel.'</p>
					 </td>
                  </tr>
                  <tr>
                     <td width="40%">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="40%">
					 <p style="'.$titre1.' white-space: nowrap;">'.(($ncc=='&nbsp;')?'':'NCC: ').$ncc.'</p>
					 </td>
                 </tr>
            </table>';

///////////////////////////////////////////////AVANT FACTURE///////////////////////////////////////////////
   
   $html.=' <p style="'.$titre.' font-size: 40px;margin-bottom:0px">&nbsp;&nbsp;FACTURE</p>
            <table style=";border: 1px solid black;border-collapse: collapse;padding-left:0px;padding-right:10px"  border=1 width="100%">
               <thead>
                  <tr height="60px">
                     <th height="30px" style="border: 1px solid black;" align="center" valign="middle">NUMERO</th>
                     <th height="30px" style="border: 1px solid black;" align="center" valign="middle">DATE</th>
                     <th height="30px" style="border: 1px solid black;" align="center" valign="middle">CENTRE DE PROFIT</th>
                     <th height="30px" style="border: 1px solid black;" align="center" valign="middle">N&deg; COMPTE</th>
                     <th height="30px" style="border: 1px solid black;" align="center" valign="middle">CPTE GENERAL</th>
                  </tr>
               </thead>
               <tbody>
                  <tr height="60px">
                     <th height="30px" style="border: 1px solid black;" align="center">
						SOL'/*.$annee.$mois.Complete($pont,3).$cafe.$cajou.$autres.*/
                  .$annee.$mois.Complete($pont,3).$type.'
					 </th>
                     <th height="30px" style="border: 1px solid black;" align="center">'.strftime('%d/%m/%Y').'</th>
                     <th height="30px" style="border: 1px solid black;" align="center"><p>SOLAS</p></th>
                     <th height="30px" style="border: 1px solid black;" align="center"></th>
                     <th height="30px" style="border: 1px solid black;" align="center"></th>
                  </tr>
               </tbody>
               
            </table>
                    
                 ';

////////////////////////////////////////////////FACTURE///////////////////////////////////////////////
  
   
    $html.='<br> 
				<table style=";border:1px solid black;border-collapse:collapse;padding-left:5px;padding-right:5px;vertical-align:top;" width="100%">
                     
					<thead>
                        <tr> 
                           <th height="30px" style="border: 1px solid black;" align="center" valign="bottom">Nb</th>
                           <th height="30px" style="border: 1px solid black;" align="center" valign="bottom">REFERENCE</th>
                           <th height="30px" style="border: 1px solid black;" align="center" valign="bottom"><p>DESIGNATION</p></th>
                           <th height="30px" style="border: 1px solid black;" align="center" valign="bottom"><p>NBRE</p></th>
                           <th height="30px" style="border: 1px solid black;" align="center" valign="bottom"><p>PRIX</p></th>
                           <th height="30px" style="border: 1px solid black;" align="center" valign="bottom"><p>MONTANT HT</p></th>
                        </tr>
				   </thead>
				   <tbody>
                        <tr height="80px">
                           <td style="border: 1px solid black;" align="center"><br><br>1<br><br><br></td>
                           <td style="border: 1px solid black;" align="center"><br><br><br>CONV-SOLAS<br><br></td>
                           <td style="border: 1px solid black;" align="center">CONVENTION SOLAS<br>
                           CERTIFICATION & TRANSMISSION DES VGM <br><br>Mois de '. $date.' '.$anne.'<br><br></td>
                           <td style="border: 1px solid black;" align="center"><br><br><br>'.$nbtc.'<br><br></td>
                           <td style="border: 1px solid black;" align="center"><br><br><br>'.number_format($tarif,0,""," ").' F<br><br></td>
                           <td style="border: 1px solid black;" align="center"><br><br><br>'.number_format($montant,0,""," ").' F<br><br></td>
                        </tr>';

    $html.='			<tr height="80px">
                           <td style="border: 1px solid black;" align="right" colspan="5">TOTAL HT</td>
                           <td style="border: 1px solid black;" align="center">'.number_format($montant,0,""," ").' F<br><br></td>
                        </tr>';

	if($tva)
    $html.='			<tr height="80px">
                           <td style="border: 1px solid black;" align="right" colspan="5">TVA A '.$tva.'%</td>
                           <td style="border: 1px solid black;" align="center">'.number_format($tva*$montant/100,0,""," ").' F<br><br></td>
                        </tr>';

	if($impayes)
    $html.='            <tr height="80px">
                           <td style="border: 1px solid black;" align="right" colspan="5">IMPAYES ANTERIEURS</td>
                           <td style="border: 1px solid black;" align="center">'.number_format($impayes,0,""," ").' F<br><br></td>
                        </tr>';
						
	$montant+=($tva*$montant/100)+$impayes;		
	if($tva || $impayes)
    $html.='			<tr height="80px">
                           <td style="border: 1px solid black;" align="right" colspan="5">TOTAL '.(($tva)?'TTC':'HT + IMPAYES').'</td>
                           <td style="border: 1px solid black;" align="center">'.number_format($montant,0,""," ").' F<br><br></td>
                        </tr>';                      
    $html.='	   </tbody>                        
              </table>
              <br>';
			  

$total=(($montant>$acompte)?($montant-$acompte):0);

///////////////////////////////////////////////////////APRES FACTURE///////////////////////////////////////////////

$html.='		<table style="border-collapse: collapse;"  width="100%">
				   <thead>
					  <tr>
						 <td>
						 <b><i><p style="'.$entete.'">Arr&ecirc;t&eacute;e la pr&eacute;sente facture &agrave; la somme de :</p></i></b>
						 <b><i><p style="'.$entete.'"><u>'.strtoupper(int2str($total)).' FCFA</u></p></i></b>
						 </td>
						 <th height="30px" style="border: 1px solid black;" align="center" valign="bottom">MONTANT '.(($tva)?'TTC':'HT').'</th>
						 <th height="30px" style="border: 1px solid black;" align="center" valign="bottom">ACOMPTE</th>
						 <th height="30px" style="border: 1px solid black;" align="center" valign="bottom">MONTANT</th>
					  </tr>
				   </thead>
				   <tbody>
					  <tr>
						 <td></td>
						 <th height="30px" style="border: 1px solid black;" align="center">'.number_format($montant,0,""," ").' F</th>
						 <td height="30px" style="border: 1px solid black;" align="center"><b>'.number_format($acompte,0,""," ").' F</b></td>
						 <th height="30px" style="border: 1px solid black;" align="center">'.number_format($total,0,""," ").' F</th>
					  </tr>
				   </tbody>
				</table>';

///////////////////MISE A JOUR DES IMPAYES//////////////////////////
if($cumul)
	$bdf->exec("UPDATE PONT SET IMPAYES='".$total."' WHERE ID_PONT='".$pont."' AND ID_USER='".$account[0]."'");

/////////////MISE A JOUR DE L'ACCOMPTE/////////////////
if($acompte && $account[0]){
	$acompte=(($montant>$acompte)?0:$acompte-$montant);	
	$bdf->exec("UPDATE USER SET ACOMPTE='".$acompte."' WHERE IDENTIFIANT='".$account[0]."'");
}		
///////////////////////////////////////////////////////signature///////////////////////////////////////////////

$html.='<br>
<table width="100%">
      <tr>
         <td width="50%"><b>
		 <p style="'.$signe.'">Condition de paiement:</p>
         <p style="'.$signe.'">A payer d&egrave;s r&eacute;ception de la facture</p>
		 <br/>
		 <br/>
		 <br/>
		 <p style="'.$signe.'">NB:Veuillez &eacute;tablir,le ch&egrave;que &agrave; l\'ordre de:</p>
		 <p style="'.$signe.'">Chambre de commerce et d Industrie de CI-SOLAS</p>
		 <p style="'.$signe.'">ou</p>
		 <p style="'.$signe.'">CCICI-SOLAS</p>
		 </b></td>
         <td width="50%" align="right">
		 <img src="../images/'.$signature.'" width="300px">
		 </td>
      </tr>
      <tr>
         <td width="50%">
		 </td>
         <td width="50%" align="right"> 
		 <br>
		 <b style="'.$signe.'">Le Chef De D&eacute;partement Comptable et Financier</b>
		 </td>
      </tr>
</table>';
if(!($tva || $impayes))
$html.='<br><br><br><br>';

if($mpdf==7){
$html.='<br><br><br><br>';
$html.='<br><br><br><br>';
}
/**/
///////////////////////////////////////////////////////DEUXIEME PAGES ///////////////////////////////////////////////

    return $html;
}
?>