<?php
include_once('../functions/Date_function.php');
include_once('../functions/Chiffre_en_lettre_function.php');
include_once('../functions/Produit_function.php');
include_once('../functions/Nom_chargeur_function.php');
include_once('../functions/Table_value_function.php');
include_once('../functions/Complete_function.php');


//function getTicketsHtml($pont,$chrg,$debut,$fin,$cafe,$cajou,$autres){
function getTicketsHtml($pont,$chrg,$debut,$fin,$type){


		global $tarif,$bds,$bdf;
    
        $debut =  datesitetoserver($debut);
        $fin =  datesitetoserver($fin);
		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);
		 
//		$critere=Produit($cafe,$cajou,$autres);
		$critere=Produit($type);


        $query = " SELECT T.DATE_RECEPT,CO.ORIGINAL,T.HEURE_RECEPT,T.CHARGEUR ,T.N_DOSSIER_BOOKING,T.N_CONTENEUR_1, ";
        $query .= " T.N_PLOMB_1,T.TRANSITAIRE,T.COMPAGNIE_MARITIME,T.CHARGEUR, ";
        $query .= " T.METHODE_DE_PESEE_VGM,T.POIDS_VGM,T.PRODUIT,T.N_CONTRAT,T.chp57,T.DATE_EMIS ";
		$query .= " FROM TICKET T,CORRESPONDANCE CO ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" , CORRESPROD CP ");
		$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 ";
		$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT = CP.DERIVE AND CP.ORIGINAL ".$critere);	
		$query .= ((!empty($type))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.") ");	
		//$query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.") ");	
		$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
		$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		$query .=(!empty($pont)?" AND T.PONT='".$pont."' ":"");
		$query .=" ORDER BY T.N_CONTENEUR_1,T.DATE_RECEPT DESC,T.HEURE_RECEPT DESC";

		$result = $bds -> query ($query);

    //   $cli=$result->fetch();
    //   $client= $cli['CHARGEUR'];
     
      //$date=new DateTime($cli['DATE_RECEPT']);
      
      setlocale(LC_TIME, 'fr_FR',"French");
	  
    //   $date1=$cli['DATE_RECEPT'];
    //   $date=strftime("%B", strtotime($date1));
    //   $anne=substr($cli['DATE_RECEPT'],0,4);

      

     
   //  $dmd=GetChargeur($bds,0,$_POST['debut'],$_POST['fin'],$_POST['pont'],'','','',$_SESSION['ID']);
	// $stat=getvalue($bds,$id,'IDENTIFIANT','demande','STATUT');

   
   //$result = substr($data['IDENTIFIANT'],0,5);

   


      //$query = $bds -> query("SELECT DATE_CREATION FROM demande WHERE IDENTIFIANT = ".$id);
    


///////////////////////////////////////////////////////DEUXIEME PAGES ///////////////////////////////////////////////
$border=';border: 1px solid black;border-collapse: collapse;padding-left:0px;padding-right:10px';
$titre=';font-size: 100px;font-weight: bold;font-family: Arial Black;';
$titre1=';font-weight: bold;font-family: Arial Black;';
$align=';text-align: center;';
$center=';margin: auto;';


    $html1='<table style="'.$border.'" border=1  width="100%">
				<tr style="'.$border.'" border=1 bgcolor="#87ceeb">
					'.($chrg?'':'<td style="white-space:nowrap">CHARGEUR</td>').'
					<td style="white-space:nowrap">DATE DE PESEE</td>
					<td style="white-space:nowrap">N CONTENEUR</td>
					<td style="white-space:nowrap">N BOOKING</td>
					<td style="white-space:nowrap">N PLOMB</td>
					<td style="white-space:nowrap">ARMATEUR</td>
					<td style="white-space:nowrap">TRANSITAIRE</td>
					<td style="white-space:nowrap">PRODUIT</td>
					<td style="white-space:nowrap">POIDS VGM</td>
					<td style="white-space:nowrap">N DOSSIER</td>
				</tr>';
				  

             
               
             
            $i=0;
            $cnt="";
            while ($donnees = $result->fetch()){

                if($cnt!=$donnees["N_CONTENEUR_1"]){
				   
					$cnt=$donnees["N_CONTENEUR_1"];
					
					if($donnees['ORIGINAL'] == $chrg ){

						$produit= getvalue($bds,'ORIGINAL','CORRESPROD','DERIVE',$donnees['PRODUIT']);
						$produit= getvalue($bds,'NOM','PRODUIT','IDENTIFIANT',$produit[0]);

						$html1.="
						<tr border=1>
							".($chrg?'':"<td>".$donnees['CHARGEUR']." </td>")."
							<td>".dateservertosite($donnees['DATE_RECEPT'])." </td>
							<td>".$donnees['N_CONTENEUR_1']." </td>
							<td>".$donnees['N_DOSSIER_BOOKING']." </td>
							<td>".$donnees['N_PLOMB_1']." </td>
							<td>".$donnees['COMPAGNIE_MARITIME']." </td>
							<td>".$donnees['TRANSITAIRE']." </td>
							<td>".$produit[0]." </td>
							<td>".number_format($donnees['POIDS_VGM'],0,""," ")." </td>
							<td>".$donnees['chp57']." </td>
						</tr>";
					  
						$i++;
					}

					$date=strtoupper(strftime("%B", strtotime($donnees['DATE_RECEPT'])));
				}

            }

             //pour le nombre et le cout des tickets
             $cout= $i*$tarif;
             
          
            $html1.='
                  <tr bgcolor="#87ceeb">
                     <td colspan="'.($chrg?'3':'4').'">TOTAL</td>
                     <td align="center" colspan="3">MOIS DE '. $date.'</td>
                     <td align="center" colspan="2">'.$i.' TICKETS</td>
                     <td align="center" style="white-space: nowrap;" colspan="2">'.number_format($cout,0,""," ").' F</td>
               </tr>
            </table>';
            
            
            $html1.='<br>
				 
				 <div style="background-color: #87ceeb; white-space: nowrap; word-spacing: 6em;" width="100%">
						  TOTAL-GENERAL
					
						  '.$i.' TICKETS
						  '.number_format($cout,0,"",".").' F
				 </div>';

		        $chargeur= GetNomChargeur($bds,$chrg);

				$entete='
				 
				 <br>
				 
				<p>CHAMBRE DE COMMERCE ET D INDUSTRIE DE COTE D IVOIRE</p>
				<br>
				<br>
				<div style="'.$border.''.$align.'text-align: center; border: 2px solid black; margin-left: 80px;"   width="80%">
						<p style="'.$titre.'">LISTE DES PESEES '.($chargeur?'DU CHARGEUR '.$chargeur:'DU/DES CHARGEUR(S) NON IDENTIFIE(S) ').'</p> 
				</div>
				<br>';
setlocale(LC_ALL, 'fr_FR', 'fra_FRA');

		$account=getvalue($bdf,'ID_USER','PONT','ID_PONT',$pont);
		$user=($account[0]?getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE','PONT','ID_PONT',$pont));

		$entete.='<br> 
         <table style="'.$center.'" width="95%">
         <tr>
            <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour Le Client :</p></td>
            <td><p style="'.$titre1.'">'.$user[0].'</p></td>
            <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour La Facture :</p></td>
            <td><p style="'.$titre1.'">SOL'.$annee.$mois.Complete($pont,3)./*$cafe.$cajou.$autres.*/$type.'</p></td>
            <td  style="'.$border.'" border=1 bgcolor="#87ceeb"><p>du :</p></td>
            <td><p style="'.$titre1.'">'.strftime('%d %B %Y').'</p></td>
          </tr>

         </table> <br>';


    return $entete.$html1;
}
?>