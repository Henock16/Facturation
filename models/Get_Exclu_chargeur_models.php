<?php
 include('../config/Connexion.php');
 include_once('../functions/Table_value_function.php');

    function GetCharex ($bdd,$id_char,$char,$numcc){
        global $bdf,$bds;

        $id_char=$_POST['char_des'];
        $char=$_POST['char_act'];
        $numcc=$_POST['numcc'];
      
            $i=0;
            if($i==0){
            $tab[$i]=1;
            $i++;
            //recuperation des infos de la table chargeur bd facturation
             $res=getvalue($bdf,'IDENTIFIANT,NOM,STATUT','CHARGEUR','NUM_CC',$char);
            $modif="UPDATE chargeur SET `STATUT` = '0' WHERE `NUM_CC` =".$char;
            $bdf->exec($modif);
            // $result2->execute();
            // $result2->closeCursor();

    //   
            }
    return $tab;
   
    }
    //  GetChargeurex ($bds,$_POST['char_des'],$_POST['char_act']);
    $tab=GetCharex ($bds,$_POST['char_des'],$_POST['char_act'],$_POST['numcc']);
    header('Content-type: application/json');
    echo json_encode($tab);
    //   var_dump($query);
?>