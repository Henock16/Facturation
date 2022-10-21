<?php
include_once('../functions/Complete_function.php');

function PDFfile($type,$repfact,$annee,$mois,$user,$char,$typ){


		$res="";
		
		$prod=$typ;
		
		if($type=='PATH')
			if($char=='')
				$res="../".$repfact."/".$annee."/".$mois."/".Complete($user,3)."/".$prod."/";
			else
				$res="../".$repfact."/".$annee."/".$mois."/".Complete($char,4)."/".$prod."/";

		elseif($type=='FILE')
			if($char=='')
				
				$res.="FACTURE_".$annee.$mois.$prod.Complete($user,3).".PDF";
			else
				
				$res.="FACTURE_CHAR_".$annee.$mois.$prod.Complete($char,4).".PDF";
		
		return $res;
	}
	/////////////////////////////CSV//////////////////////////////
	function CSVfile($type,$repfact,$annee,$mois,$pont,$char,$typ){


		$res="";
		
		$prod=$typ;
		
		if($type=='PATH')
			$res="../".$repfact."/".$annee."/".$mois."/".Complete($pont,3)."/".$prod."/";
		elseif($type=='FILE')
			if($char==='')
				$res="";
			else
				$res.="DETAILS_".$annee.$mois.Complete($pont,3).$prod.Complete($char,4).".CSV";
		
		return $res;
	}