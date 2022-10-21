<?php

include('../functions/Users_get_tickets_html.php');
include('../functions/PDF_File_Ticket_function.php');

//mode : 'I'=dans le navigateur 'F'=dans le systeme de fichier

function PDF_Tickets($pont,$chrg,$debut,$fin,$type,$mpdf,$mode,$user,$mois){

	$tickets = getTicketsHtml($pont,$chrg,$debut,$fin,$type);
	$space= ' ';
	$title = "TICKET";


	global $repfact;

	if($mode=='I'){
		$path=time().".PDF";
	}
	
	else{
		
		$annee=substr($debut,0,4);
		
		$path=PDFfileticket('PATH',$repfact,$annee,$mois,$user,$chrg,$type);

		
		if(@ mkdir($path, 0777, true))
			
			$path.=PDFfileticket('FILE',$repfact,$annee,$mois,$user,$chrg,$type);
		else
			$path="";
					
	}

	if($path=="")
			return false;
	else
	if($mpdf==6){

		$pdf = new mPDF();
		ini_set("pcre.backtrack_limit", "1000000");
		$pdf->SetDisplayMode('fullpage');
		$pdf->SetFooter('AVENUE JOSEPH ANOMA &bull; 01 B.P. 1399 ABIDJAN 01 &bull; TEL lignes group&eacute;es : (225) 20.33.16.00 &bull; FAX : (225) 20.32.39.42 &bull; www.cci.ci');
		$pdf->WriteHTML(utf8_encode($tickets));
		$moiss = array('Janvier','Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
		$m=date('n');
		setlocale(LC_TIME, 'fr_FR',"French");
		$pdf->SetFooter(''.strftime('%A %d').' '.$moiss[$m-1].' '.strftime('%Y').'|'.strftime('%H:%M:%S').'|  Page{PAGENO}/{PAGENO} | ' );
		
		var_dump($path.'le mode'.$mode);
		$pdf->Output($path,$mode);
		echo"apres output";
	
		if($mode=='I')
			exit;
		else
			return $path;

	}else
		if($mpdf==7){
		
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

			$pdf->WriteHTML(utf8_encode($tickets));
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
