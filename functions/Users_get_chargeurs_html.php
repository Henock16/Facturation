<?php
//use Mpdf\Tag\Center;

include_once('../functions/Date_function.php');
include_once('../functions/Chiffre_en_lettre_function.php');
include_once('../functions/Produit_function.php');
include_once('../functions/Nom_chargeur_function.php');


 //function getChargeursHtml($pont,$debut,$fin,$cafe,$cajou,$autres){
function getChargeursHtml($pont,$debut,$fin,$type,$user){


		 global $tarif,$bds,$bdf;
    
         $debut =  datesitetoserver($debut);
         $fin =  datesitetoserver($fin);
		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);
		 
		//$critere=Produit($cafe,$cajou,$autres);
      $critere=Produit($type);
   


		$query = " SELECT  T.N_CONTENEUR_1 ,  CO.ORIGINAL , P.STRC,T.PONT";
		$query .= " FROM TICKET T,CORRESPONDANCE CO, PONT P ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" , CORRESPROD CP ");
		$query .= " WHERE T.DISABLED = 0 AND T.ARCHIVE= 0 AND T.BANNED= 0 AND T.BLOCKED= 0 AND T.PONT=P.ID_PONT ";
		$query .= " AND T.COMPAGNIE_MARITIME NOT IN('CCI') AND T.CHARGEUR = CO.DERIVE AND T.COMP_MAR_TRY>0 AND T.COMP_MAR_GONE>=1 ";
		// $query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT = CP.DERIVE AND CP.ORIGINAL ".$critere);	
		//$query .= ((!empty($cafe)&&!empty($cajou)&&!empty($autres))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")");	
      $query .= ((!empty($type))?" ":" AND T.PRODUIT IN(SELECT DERIVE FROM CORRESPROD WHERE ORIGINAL ".$critere.")");	
		$query .=(!empty($debut)?" AND T.DATE_EMIS>='".$debut."' ":"");
		$query .=(!empty($fin)?" AND T.DATE_EMIS<='".$fin."' ":"");
		$query .=(!empty($pont)?" AND T.PONT='".$pont."'":"");
      // $query .=(!empty($user)?" AND P.STRC='".$user."' ":"");
        $query .=" ORDER BY T.N_CONTENEUR_1,T.DATE_RECEPT DESC,T.HEURE_RECEPT DESC";

		 $result = $bds -> query ($query);
         
       $nbtc=0;
       $cnt="";
       $tabchar=array();
       $tabtick=array();
        while ($donnees = $result->fetch()){
         if($cnt!=$donnees["N_CONTENEUR_1"])
         {
            $cnt=$donnees["N_CONTENEUR_1"];
        
      
            if(!in_array($donnees["ORIGINAL"],$tabchar)){
               $tabchar[]=$donnees["ORIGINAL"];
               $tabtick[]=1;
            }else{
               $tabtick[array_search($donnees["ORIGINAL"],$tabchar)]++;
            }
          
          
             
             $nbtc++;
         }               

        }

    //   $cli=$result->fetch();
    //   $client= $cli['CHARGEUR'];
     
      //$date=new DateTime($cli['DATE_RECEPT']);
      
      setlocale(LC_TIME, 'fr_FR',"French");
    //   $date1=$cli['DATE_RECEPT'];
    //   $date=strftime("%B", strtotime($date1));
    //   $anne=substr($cli['DATE_RECEPT'],0,4);

      
// echo $user;
     
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


   // $html1='<table style="'.$border.'" border=1  width="100%">
   //             <tr style="'.$border.'" border=1 bgcolor="#87ceeb">
   //                <td >CHARGEUR</td>
   //                <td>CONTENEURS</td>
   //             </tr>
   //             ';

          
   //          $i=0;
           
            //  while ($i< count($tabtick) ){
            //       $chargeur=GetNomChargeur($bds,$tabchar[$i]);
               
            //       $html1.="
            //         <tr border=1>
            //         <td >".($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)')." </td>
            //         <td align='Center'>".$tabtick[$i]." </td>
            //         </tr>";
                    
            //         $i++;
				 
				// $chargeur=GetNomChargeur($bds,$tabchar[$i]);
               
            //     $html1.="
            //       <tr border=1>
            //       <td >".($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)')." </td>
            //       <td align='Center'>".$tabtick[$i]." </td>
            //       </tr>";
                  
            //       $i++;
                               
            //  }

                      
            //    $html1.='
				// 	<tr bgcolor="#87ceeb">
            //          <td >TOTAL '.$i.'</td>
            //          <td align="center" >'.number_format($nbtc,0,""," ").'</td>
				// 	</tr>
				// 	</table>';
            

   
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

            // $pnt= getvalue($bds,'NOM','PONT','ID_PONT',$pont);
            //  $pnt= getvalue($bds,'NOM','PONT','STRC',$user);
             $nom= 'select NOM FROM PONT WHERE STRC ='.$user;
             $test = $bds -> query ($nom);
             $i=0;
            //  while($donnees=$pnt){
              while($i< count($tabtick) && $donnees = $test->fetch() ){

               // if($cnt!=$donnees["N_CONTENEUR_1"])
               // {
               //    $cnt=$donnees["N_CONTENEUR_1"];
              
            
               //    if(!in_array($donnees["ORIGINAL"],$tabchar)){
               //       $tabchar[]=$donnees["ORIGINAL"];
               //       $tabtick[]=1;
               //    }else{
               //       $tabtick[array_search($donnees["ORIGINAL"],$tabchar)]++;
               //    }
                
                
                   
               //     $nbtc++;
               // }               
           
               /////////////////////////////////////   
                  $entete.='<br> 
         <table style="'.$center.'" width="100%">
          <tr width="100%">
            <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour Le Pont :</p></td>
            <td><p style="'.$titre1.'">'. $donnees['NOM'].'</p></td>
            <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour La Facture :</p></td>
            <td><p style="'.$titre1.'">SOL'.$annee.$mois.Complete($user,3).$type.'</p></td>
            <td  style="'.$border.'" border=1 bgcolor="#87ceeb"><p>du :</p></td>
            <td><p style="'.$titre1.'">'.strftime('%d %B %Y').'</p></td>
          </tr>
          <tr style="'.$border.'" border=1 bgcolor="#87ceeb" width="100%">
            <td colspan="4" >CHARGEUR</td>
            <td colspan="2">CONTENEURS</td>
         </tr>';
         // if ($i< count($tabtick) ){
            $chargeur=GetNomChargeur($bds,$tabchar[$i]);
            $entete.='<tr border=1>
              <td colspan="4">'.($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)').'</td>
              <td colspan="2" align="Center">'.$tabtick[$i].'</td>
              </tr>';
              
             
         // }
         $entete.='
				 	<tr bgcolor="#87ceeb">
                      <td colspan="4">TOTAL '.count($chargeur).'</td>
                      <td colspan="2" align="center" >'.$tabtick[$i].'</td>
				 	</tr>
         </table> <br>';
         // $html1='<table style="'.$border.'" border=1  width="100%">
         // <tr style="'.$border.'" border=1 bgcolor="#87ceeb">
         //    <td >CHARGEUR</td>
         //    <td>CONTENEURS</td>
         // </tr>
         // ';

         $i++;
      // $i=0;
      //    if ($i< count($tabtick) ){
      //       $chargeur=GetNomChargeur($bds,$tabchar[$i]);
         
      //       $html1.="
      //         <tr border=1>
      //         <td >".($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)')." </td>
      //         <td align='Center'>".$tabtick[$i]." </td>
      //         </tr>";
              
      //         $i++;
       
      // $chargeur=GetNomChargeur($bds,$tabchar[$i]);
         
      //     $html1.="
      //       <tr border=1>
      //       <td >".($chargeur?$chargeur:'CHARGEUR(S) NON IDENTIFIE(S)')." </td>
      //       <td align='Center'>".$tabtick[$i]." </td>
      //       </tr>";
            
      //       $i++;
                         
       }

                
         // $html1.='
         // <tr bgcolor="#87ceeb">
         //       <td >TOTAL '.$i.'</td>
         //       <td align="center" >'.number_format($nbtc,0,""," ").'</td>
         // </tr>
         // </table>';
      
               
            //  }
// $entete.='<br> 
//          <table style="'.$center.'" width="95%">
//          <tr>
//             <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour Le Pont :</p></td>
//             <td><p style="'.$titre1.'">'. $pnt[0].'</p></td>
//             <td style="'.$border.'" border=1 bgcolor="#87ceeb"><p>Pour La Facture :</p></td>
//             <td><p style="'.$titre1.'">SOL'.$annee.$mois.Complete($user,3).$type.'</p></td>
//             <td  style="'.$border.'" border=1 bgcolor="#87ceeb"><p>du :</p></td>
//             <td><p style="'.$titre1.'">'.strftime('%d %B %Y').'</p></td>
//           </tr>

//          </table> <br>';

         //   echo $entete;
         // var_dump($query);

    return $entete;
}
?>