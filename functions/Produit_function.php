<?php
	function Produit($type){
		$res="";
		if($type == '0')
			$res=" IN (0) ";
		elseif($type == '1'){
			$res="IN (2,3)";
		}
		elseif($type == '2'){
			$res="NOT IN (2,3)";
		}
		return $res;
	}