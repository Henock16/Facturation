<?php
//function Produit($cafe,$cajou,$autres){
	function Produit($type){
		$res="";
			


		// if(empty($cafe)&&empty($cajou)&&empty($autres))
		// 	$res=" IN (0) ";
		// elseif(empty($cafe)&&empty($cajou)&&!empty($autres))
		// 	$res="NOT IN (2,3,6,11)";
		// elseif(empty($cafe)&&!empty($cajou)&&empty($autres))
		// 	$res="IN (6,11)";
		// elseif(empty($cafe)&&!empty($cajou)&&!empty($autres))
		// 	$res="NOT IN (2,3)";
		// elseif(!empty($cafe)&&empty($cajou)&&empty($autres))
		// 	$res="IN (2,3)";
		// elseif(!empty($cafe)&&empty($cajou)&&!empty($autres))
		// 	$res="NOT IN (6,11)";
		// elseif(!empty($cafe)&&!empty($cajou)&&empty($autres))
		// 	$res="IN (2,3,6,11)";
		// elseif(!empty($cafe)&&!empty($cajou)&&!empty($autres))
		// 	$res=" ";
		if($type == 0)
			$res=" IN (0) ";
		elseif($type == 1)
			$res="NOT IN (6,11)";
		elseif($type == 2)
			$res="NOT IN (6,11)";
		elseif($type == 1)
			$res="IN (2,3)";
		elseif($type == 2)
			$res="IN (6,11)";
		
		return $res;
	}