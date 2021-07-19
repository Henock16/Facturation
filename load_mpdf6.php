<?php
session_start();

include('../config/Connexion.php');
include('../functions/Users_request_get_html.php');
include('../functions/Users_request_get_html_2pages_function.php');
include("../mpdf/mpdf.php");

$id=(isset($_GET['id'])?$_GET['id']:'');
$pont=(isset($_GET['pont'])?$_GET['pont']:'');
$debut=(isset($_GET['debut'])?$_GET['debut']:'');
$fin=(isset($_GET['fin'])?$_GET['fin']:'');
$userDowloader='compta';

//$userDowloader=$_SESSION['NAME'];
$ticket = getRequestHtmlpages2($bdd,$id,$uploadrep,$debut,$fin,$pont);
$facture =  getRequestHtml($bdd,$id,$uploadrep,$debut,$fin,$pont);
$space= ' ';
$title = "FACTURE";
$time = time();
$pdf = new mPDF();
//$pdf2 = new mPDF("A4-L");

$pdf->SetDisplayMode('fullpage');
//$pdf->SetHeader(' | ' . $title . ' |{PAGENO}');
$pdf->SetFooter('AVENUE JOSEPH ANOMA &bull; 01 B.P. 1399 ABIDJAN 01 &bull; TEL lignes group&eacute;es : (225) 20.33.16.00 &bull; FAX : (225) 20.32.39.42 &bull; www.cci.ci');
$pdf->WriteHTML(utf8_encode($facture));
$pdf->WriteHTML(utf8_encode($ticket));
//$pdf->AddPage($ticket,'L');
//$pdf->SetAutoPageBreak($ticket);
setlocale(LC_TIME, 'fr_FR',"French");
$pdf->SetFooter(''.strftime('%A %d %B %Y').'|'.strftime('%H:%M:%S').'|  Page{PAGENO}/{PAGENO} | ' );
$pdf->Output($time . '.pdf', 'I');


exit;

?>
