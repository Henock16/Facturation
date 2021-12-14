<?php
/**
 * Created by PhpStorm.
 * User: Stephane
 * Date: 29/06/2020
 * Time: 17:33
 */


function getvalue($bdd,$chp,$table,$ident,$id){

    $val=array();
    $champ=explode(",",$chp);
    $query = $bdd->prepare("SELECT ".$chp." FROM ".$table." WHERE ".$ident." = '".$id."' ORDER BY ".$champ[0]." DESC LIMIT 0,1");
    $query->execute();
	$data = $query->fetch();
    $champ=explode(",",$chp);
    for($i=0;$i<count($champ);$i++)
        $val[] = (isset($data[trim($champ[$i])]) ? $data[trim($champ[$i])] : "");
    $query->closeCursor();
    return $val;
}

?>