<?php
include_once('../functions/Complete_function.php');

function PDFfileticket($type,$repfact,$annee,$mois,$user,$char,$typ){

		$res="";
		
		$prod=$typ;
		if($type=='PATH')
			if($char=='')
				$res="../".$repfact."/".$annee."/".$mois."/".Complete($user,3)."/".$prod."/";
			else
				$res="../".$repfact."/".$annee."/".$mois."/".Complete($char,4)."/".$prod."/";
		elseif($type=='FILE')
				$res.="DETAILS_".$annee.$mois.Complete($user,3).$prod.Complete($char,4).".PDF";
		
		return $res;

	}

	
?>
