<?php
session_start();

include('../config/Connexion.php');
include('../functions/Users_request_get_html.php');
require_once '../vendors/autoload.php';
require_once __DIR__ . '/../vendors/autoload.php';

$id=(isset($_GET['id'])?$_GET['id']:'');
$pont=(isset($_GET['pont'])?$_GET['pont']:'');
$debut=(isset($_GET['debut'])?$_GET['debut']:'');
$fin=(isset($_GET['fin'])?$_GET['fin']:'');
// $userDowloader=$_SESSION['NAME'];
$html =  getRequestHtml($bdd,$id,$uploadrep,$debut,$fin,$pont);
//echo $html;
$title = "FACTURE";
$time = time();

    //  try {
    //      $pdf = new \Mpdf\Mpdf(['default_font_size' => 7,'default_font' => 'Helvetica']);
         
		
    //     $pdf->SetDisplayMode('fullpage');
     //    // $pdf->SetHeader(' | ' . $title . ' |{PAGENO}');

// //		$typdem=getvalue($bdd,$_GET['id'],'IDENTIFIANT','demande','ID_TYPE_DEMANDE');
// //		if($typdem[0]==3){
			// $footer='6, AVENUE JOSEPH ANOMA • 01 B.P. 1399 ABIDJAN 01 • TEL. Lignes groupées : (225) 27.20.33.16.00 • FAX : (225) 27.20.32.39.42 • www.cci.ci';
			// $footer = array('odd' => array (
			// 					'C' => array (
			// 						'content' => $footer,
			// 						'font-size' => 10,
			// 						'font-style' => 'B',
			// 						'font-family' => 'arial',
			// 						'color'=>'#000000'
			// 						),
			// 					'line' => 1,
			// 					)
			// 				);
			// $pdf->SetFooter($footer);
// //		}else
// //			$pdf->SetFooter(' | imprim&eacute; le  {DATE j-m-Y} | par ' . $userDowloader);
//         $pdf->WriteHTML($html);
//         $pdf->Output($time . '.pdf', 'I');
//         exit;

//     } 
//     catch (\Mpdf\MpdfException $e) {
//         $msg = "{ERROR: '" . $e->getMessage() . "}";
//         echo  $msg ;
//         return array('ERROR ' => $msg);
//    }

?>
