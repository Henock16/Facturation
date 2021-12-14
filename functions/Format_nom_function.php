<?php
/**
 * Created by PhpStorm.
 * User: Stephane
 * Date: 13/05/2021
 * Time: 15:33
 */


function formatnom($chp,$typ){

    $val=array();

    $chp=explode(" ",trim($chp));
	
    for($i=0;$i<count($chp);$i++)
        $val[] = (($i==0 && $typ=='propre')?strtoupper($chp[$i]):(($typ=='commun' && strlen($chp[$i])<=2)?strtolower($chp[$i]):strtoupper(substr($chp[$i],0,1)).strtolower(substr($chp[$i],1))));

    return implode(" ",$val);
}

?>