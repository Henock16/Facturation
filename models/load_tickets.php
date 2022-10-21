<?php
session_start();

include('../config/Connexion.php');
include('../functions/PDF_Tickets_function.php');


if($mpdf==6)
	include("../mpdf/mpdf.php");
elseif($mpdf==7)
	require_once '../vendors/autoload.php';

$pont=(isset($_GET['pont'])?$_GET['pont']:'');
$chrg=(isset($_GET['chrg'])?$_GET['chrg']:'');
$debut=(isset($_GET['debut'])?$_GET['debut']:'');
$fin=(isset($_GET['fin'])?$_GET['fin']:'');
$cafe=(isset($_GET['cafe'])?$_GET['cafe']:'');
// $cajou=(isset($_GET['cajou'])?$_GET['cajou']:'');
$autres=(isset($_GET['autres'])?$_GET['autres']:'');
$user=(isset($_GET['user_id'])?$_GET['user_id']:'');
$mois=$_GET['mois'];
$annee=$_GET['annee'];
if($cafe==0 && $autres==1)
	$type='2';
else if($cafe==1 && $autres==0)
	$type='1';


$debut=datesitetoserver($debut);
$fin=datesitetoserver($fin);
$path=PDFfileticket('PATH',$repfact,$annee,$mois,$user,$chrg,$type);
// $file=PDFfile('FILE',$repfact,$annee,$mois,$user,$chrg,$cafe,/*$cajou,*/$autres);
$file=PDFfileticket('FILE',$repfact,$annee,$mois,$user,$chrg,$type);
		
//*
if(file_exists($path.$file))
	header ("Location: ".$path.$file);
// PDF_Tickets($pont,$chrg,$debut,$fin,$type,$mpdf,'I',$user);
else
	// header ("Location: ".$path.$file);
	PDF_Tickets($pont,$chrg,$debut,$fin,$type,$mpdf,'I',$user,$mois);
	// PDF_Tickets('',574,'01/03/2022','31/03/2022',2,6,'I',5);
	
echo json_encode($type.'user '.$user.' autre'.$autres.' cafe'.$cafe);
?>
