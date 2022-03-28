<?php
include_once('../functions/Complete_function.php');

//function PDFfile($type,$repfact,$annee,$mois,$pont,$chrg,$cafe,$cajou,$autres){
function PDFfile($type,$repfact,$annee,$mois,$pont,$chrg,$typ){


		$res="";
		
		$prod=$typ;
		
		if($type=='PATH')
			$res="../".$repfact."/".$annee."/".$mois."/".Complete($pont,3)."/".$prod."/";
		elseif($type=='FILE')
			if($chrg==='')
				$res.="FACTURE_".$annee.$mois.Complete($pont,3).$prod.".PDF";
			else
				$res.="DETAILS_".$annee.$mois.Complete($pont,3).$prod.Complete($chrg,4).".PDF";
		
		return $res;
	}
	/////////////////////////////CSV//////////////////////////////
	function CSVfile($type,$repfact,$annee,$mois,$pont,$chrg,$typ){


		$res="";
		
		$prod=$typ;
		
		if($type=='PATH')
			$res="../".$repfact."/".$annee."/".$mois."/".Complete($pont,3)."/".$prod."/";
		elseif($type=='FILE')
			if($chrg==='')
				// $res.="FACTURE_".$annee.$mois.Complete($pont,3).$prod.".PDF";
				$res="";
			else
				$res.="DETAILS_".$annee.$mois.Complete($pont,3).$prod.Complete($chrg,4).".CSV";
		
		return $res;
	}