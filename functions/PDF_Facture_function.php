<?php
/*
    Date creation : 14-07-2021
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: Generation de la facture en pdf  
*/
// include('../functions/Users_get_facture_html.php');
include('../functions/Users_get_facture_cafe_html.php');
include('../functions/Users_get_chargeurs_Exclu_html.php');
include('../functions/Users_get_chargeurs_html.php');
include('../functions/PDF_File_function.php');
include('../functions/Users_get_facture_chargeur_html.php');

//mode : 'I'=dans le navigateur 'F'=dans le systeme de fichier

function PDF_Facture($debut,$fin,$type,$mpdf,$mode,$user,$char){
	if($user){
		$facture = getFactureUserHtml($user,$debut,$fin,$type,$pont,$numfac);
		
		$chargeurs = getChargeursHtml($pont,$debut,$fin,$type,$user,$numfac);
	}
		

	else{
		$facture= getFactureChargeurHtml($char,$debut,$fin,$type,$pont,$numfac);
		 $chargeurs = getChargeursExcluHtml($pont,$debut,$fin,$type,$char,$numfac);
	}
		
	$space= ' ';
	$title = "FACTURE";

	global $repfact;

	if($mode=='I')
		$path=time().".PDF";
	else{
		
		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);

		
		
		$path=PDFfile('PATH',$repfact,$annee,$mois,$user,$char,$type);

		
		if(@ mkdir($path, 0777, true)) 
		
			$path.=PDFfile('FILE',$repfact,$annee,$mois,$user,$char,$type);
			
		else
			$path="";
	 }
		
					
	

	 if($path=="")
			return false;
	elseif($mpdf==6){

		$pdf = new mPDF();
		ini_set("pcre.backtrack_limit", "1000000");

		$pdf->SetDisplayMode('fullpage');
		$pdf->SetFooter('AVENUE JOSEPH ANOMA &bull; 01 B.P. 1399 ABIDJAN 01 &bull; TEL lignes group&eacute;es : (225) 20.33.16.00 &bull; FAX : (225) 20.32.39.42 &bull; www.cci.ci');
		$pdf->WriteHTML(utf8_encode($facture));
		$pdf->WriteHTML(utf8_encode($chargeurs));
		setlocale(LC_TIME, 'fr_FR',"French");
		$pdf->SetFooter(''.strftime('%A %d %B %Y').'|'.strftime('%H:%M:%S').'|  Page{PAGENO}/{PAGENO} | ' );

		$pdf->Output($path,$mode);
	
		if($mode=='I')
			exit;
		else
			return $path;

	}elseif($mpdf==7){
		
		try {
			$pdf = new \Mpdf\Mpdf(['default_font_size' => 7,'default_font' => 'Helvetica']);
         
			$pdf->SetDisplayMode('fullpage');
	
			$footer='6, AVENUE JOSEPH ANOMA • 01 B.P. 1399 ABIDJAN 01 • TEL. Lignes groupées : (225) 27.20.33.16.00 • FAX : (225) 27.20.32.39.42 • www.cci.ci';
			$footer = array('odd' => array (
			 					'C' => array (
			 						'content' => $footer,
			 						'font-size' => 10,
			 						'font-style' => 'B',
			 						'font-family' => 'arial',
			 						'color'=>'#000000'
			 						),
			 					'line' => 1,
			 					)
			 				);
			$pdf->SetFooter($footer);


			$pdf->WriteHTML(utf8_encode($facture));
			$pdf->WriteHTML(utf8_encode($chargeurs));
			setlocale(LC_TIME, 'fr_FR',"French");

			$pdf->Output($path,$mode);

			if($mode=='I')
				exit;
			else
				return $path;

		}catch (\Mpdf\MpdfException $e){
			$msg = "{ERROR: '" . $e->getMessage() . "}";
			echo  $msg ;
			return array('ERROR ' => $msg);
		}
		
	}else
		return false;

 }
?>
