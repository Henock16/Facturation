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
    $query3 = $bdd->prepare("SELECT ".$chp." FROM ".$table." WHERE ".$ident." = :id ORDER BY ".$champ[0]." DESC LIMIT 0,1");
    $query3->bindParam(':id', $id, PDO::PARAM_INT);
    $query3->execute();
    $data3 = $query3->fetch();
    $champ=explode(",",$chp);
    for($i=0;$i<count($champ);$i++)
        $val[] = (isset($data3[trim($champ[$i])]) ? $data3[trim($champ[$i])] : "");
    $query3->closeCursor();
    return $val;
}

?>