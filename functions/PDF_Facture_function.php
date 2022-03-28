<?php

// include('../functions/Users_get_facture_html.php');
include('../functions/Users_get_facture_cafe_html.php');
include('../functions/Users_get_chargeurs_html.php');
include('../functions/PDF_File_function.php');

//mode : 'I'=dans le navigateur 'F'=dans le systeme de fichier

//function PDF_Facture($pont,$debut,$fin,$cafe,$cajou,$autres,$mpdf,$mode,$user){
function PDF_Facture($pont,$debut,$fin,$type,$mpdf,$mode,$user){
	// $facture =  getFactureHtml($pont,$debut,$fin,$cafe,$cajou,$autres);
	$facture =  getFactureHtml($user,$debut,$fin,$type,$pont);
	//$chargeurs = getChargeursHtml($pont,$debut,$fin,$cafe,$cajou,$autres);
	 $chargeurs = getChargeursHtml($pont,$debut,$fin,$type,$user);
	$space= ' ';
	$title = "FACTURE";

	global $repfact;

	if($mode=='I')
		$path=time().".PDF";
	else{
		
		$annee=substr($debut,0,4);
		$mois=substr($debut,5,2);

		
		// $path=PDFfile('PATH',$repfact,$annee,$mois,$pont,'',$cafe,$cajou,$autres);
		$path=PDFfile('PATH',$repfact,$annee,$mois,$pont,'',$type);

		
		if(@ mkdir($path, 0777, true))
			// $path.=PDFfile('FILE',$repfact,$annee,$mois,$pont,'',$cafe,$cajou,$autres);
			$path.=PDFfile('FILE',$repfact,$annee,$mois,$pont,'',$type);

		else
			$path="";
					
	}

	if($path=="")
			return false;
	else
	if($mpdf==6){

		$pdf = new mPDF();
		//$pdf2 = new mPDF("A4-L");
		ini_set("pcre.backtrack_limit", "1000000");
		// $facture=preg_replace($facture);

		$pdf->SetDisplayMode('fullpage');
		//$pdf->SetHeader(' | ' . $title . ' |{PAGENO}');
		$pdf->SetFooter('AVENUE JOSEPH ANOMA &bull; 01 B.P. 1399 ABIDJAN 01 &bull; TEL lignes group&eacute;es : (225) 20.33.16.00 &bull; FAX : (225) 20.32.39.42 &bull; www.cci.ci');
		$pdf->WriteHTML(utf8_encode($facture));
		$pdf->WriteHTML(utf8_encode($chargeurs));
		//$pdf->AddPage($ticket,'L');
		//$pdf->SetAutoPageBreak($ticket);
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
