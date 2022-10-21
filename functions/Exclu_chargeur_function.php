<?php
/*
    Date creation : 14-07-2022
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-08-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: La fonction qui exclus les chargeur et change leurs status 
*/
 include('../config/Connexion.php');
 include_once('../functions/Table_value_function.php');

    function GetChargeurex ($bdd,$id_char,$char,$numcc){
        global $bdf,$bds,$champstxt;

        $id_char=$_POST['char_des'];
        $char=$_POST['char_act'];
        $numcc=$_POST['numcc'];
       if($id_char !=='')
        {
            $bdd = $bds;
            $query ="SELECT IDENTIFIANT,NOM,NUM_CC FROM chargeur  WHERE IDENTIFIANT=$id_char";
       
            $result = $bdd -> query ($query);
        
                $i=0;
                $tab[$i]=0;
                $i++;
            
                $tab[$i]=$result -> rowCount()>0;
                $i++;
            
                $tab[$i]=3;
                $i++;
                    $donnees = $result->fetch();

                    
                    // IDENTIFIANT
                    $tab[$i] = $donnees['IDENTIFIANT'];
                    $i++;
        
                    // NOM CHARGEUR
                    $tab[$i] = $donnees['NOM'];
                    $i++;

                     // NUMERO COMPTE
                    $tab[$i] = $donnees['NUM_CC'];
                    $i++;

                $result->closeCursor();
                //recuperation des infos de la table chargeur bd facturation
                $res=getvalue($bdf,'IDENTIFIANT,NOM,STATUT','CHARGEUR','IDENTIFIANT',$id_char);
                //modification du statut en 1
                if($res[0]==$id_char){
                    $i=0;
                    $tab[$i]=2;
                    $i++;
                   $modif1="UPDATE chargeur SET STATUT = '1',NUM_CC='".$numcc."' WHERE IDENTIFIANT =".$id_char;
                   $bdf->exec($modif1);
               }else
               //insertion en bd l'orsque le chargeur n'exciste pas dans la bd facturation
               {
                
                    $query1=("INSERT INTO CHARGEUR(IDENTIFIANT,NOM,VILLE,STATUT,NUM_CC) VALUES(".$donnees['IDENTIFIANT'].",'".$donnees['NOM']."','',1,'".$donnees['NUM_CC']."')");
                    $result1 = $bdf->prepare($query1);
                    $result1->execute();
                    $result1->closeCursor();
               }	
                
                    
        }
        else if($char !== $numcc)
        {

            $i=0;
            $tab[$i]=4;
            $i++;
            //recuperation des infos de la table chargeur bd facturation
             $res=getvalue($bdf,'IDENTIFIANT,NOM,STATUT','CHARGEUR','NUM_CC',$char);
            $modif="UPDATE chargeur SET `NUM_CC` = '".$numcc."' WHERE `IDENTIFIANT` ='".$res[0]."' ";
            $bdf->exec($modif);
        }
        
        else
        {
            $i=0;
            $tab[$i]=1;
            
        }   
    return $tab;
    

    }
    $tab=GetChargeurex ($bds,$_POST['char_des'],$_POST['char_act'],$_POST['numcc']);
    header('Content-type: application/json');
    echo json_encode($tab);
?>