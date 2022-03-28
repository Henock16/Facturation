<?php

//use function PHPSTORM_META\type;

session_start();

include('../config/Connexion.php');
include('../functions/Date_function.php');
include('../functions/PDF_Facture_function.php');

if($mpdf==6)
	include("../mpdf/mpdf.php");
elseif($mpdf==7)
	require_once '../vendors/autoload.php';

$user=(isset($_GET['userid'])?$_GET['userid']:'');
$pont=(isset($_GET['pont'])?$_GET['pont']:'');
$debut=(isset($_GET['debut'])?$_GET['debut']:'');
$fin=(isset($_GET['fin'])?$_GET['fin']:'');
$cafe=(isset($_GET['cafe'])?$_GET['cafe']:'');
//$cajou=(isset($_GET['cajou'])?$_GET['cajou']:'');
$autres=(isset($_GET['autres'])?$_GET['autres']:'');

if($cafe==0 && $autres==1)
	$type='2';
else if($cafe==1 && $autres==0)
	$type='1';
else if($cafe==1 && $autres==1)
	$type='1,2';
// $user='compta';

$debut=datesitetoserver($debut);
$fin=datesitetoserver($fin);
$annee=substr($debut,0,4);
$mois=substr($debut,5,2);
$path=PDFfile('PATH',$repfact,$annee,$mois,$pont,'',$cafe,/*$cajou*/'',$autres);
$file=PDFfile('FILE',$repfact,$annee,$mois,$pont,'',$cafe,/*$cajou*/'',$autres);
		
//*
if(file_exists($path.$file))
	header ("Location: ".$path.$file);
else
	// PDF_Facture($pont,$debut,$fin,$cafe,/*$cajou*/$type,$autres,$mpdf,'I',$user);
	PDF_Facture($pont,$debut,$fin,$type,$mpdf,'I',$user);
//*/
/*
if(!file_exists($path.$file))
@	PDF_Facture($pont,$debut,$fin,$cafe,$cajou,$autres,$mpdf,'F',$user);

header ("Location: ".$path.$file);
//*/
echo json_encode($type.'user '.$user.' autre'.$autres.' cafe'.$cafe);
?>
