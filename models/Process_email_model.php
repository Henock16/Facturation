<?php

session_start();	
          
include('../config/Connexion.php');


function Afficher($bdd,$iduser){
      
		$sql=" SELECT IDENTIFIANT,ID_USER, LIBELLE, STATUT 
              FROM EMAIL 
              WHERE ID_USER = :id AND STATUT = 0  
              ORDER BY LIBELLE ASC ";
		$result = $bdd->prepare($sql);
		$result -> bindParam(':id', $iduser, PDO::PARAM_INT);
		$result -> execute();
		$head = null;
		$body = null;
			
		if(!$result -> rowCount()){
			$head.=' <tr><th style="text-align:center;;background-color:lightblue;" colspan=2>
						<h3>Adresse électronique</h3>
						</th></tr>';

			$body.='<tr>                                                   
							<td style="width:100%; margin:auto;" style="text-align:center;" bgcolor="white" >
								<p style="text-align:center;">Vous n\'avez aucune adresse électronique configurée</p>
							</td>
					</tr>';
		}else{
			$head.=' <tr><th style="text-align:center;;background-color:lightblue;"><h3>Adresse électronique</h3></th>
					<th style="text-align:center;;background-color:lightblue;">Option</th></tr>';
               	   			
                      
			while ($donnees = $result->fetch())
				$body.='<tr id="ligne_'.$donnees['IDENTIFIANT'].'">                                                   
                <td margin:auto;" bgcolor="white" >
                    <input type="label" style=" height:30px;" class="form-control" name="" value="'.$donnees['LIBELLE'].'" disabled="disabled">
                </td>
                <td style="text-align:center;" bgcolor="white" >
                    <a href="javascript:delmail('.$donnees['IDENTIFIANT'].')" class="btn btn-danger" style=" height:30px;">Desactiver</a>
                </td>
				</tr>';
			$result->closeCursor();
		} 		
      

	return array($head,$body);
}

function Desactiver($bdd,$iduser){    
  
    $result = $bdd->prepare("UPDATE EMAIL SET STATUT =1 WHERE IDENTIFIANT =:user AND ID_USER =:id ");
    $result -> bindParam(':user', $_POST['idmail'], PDO::PARAM_INT);
    $result -> bindParam(':id',$iduser, PDO::PARAM_INT);
    $result -> execute();    	
    $result->closeCursor();
      
 	return "ok";    
}
      		     	
       
function Ajouter($bdd,$iduser){    
          
        $sql="SELECT IDENTIFIANT,STATUT,ID_USER
            FROM EMAIL
            WHERE ID_USER =:user 
            AND LIBELLE =:mail
            LIMIT 1";
        $result = $bdd->prepare($sql);
        $result -> bindParam(':user', $iduser, PDO::PARAM_INT);
        $result -> bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
        $result -> execute();
               
        $exist = $result->rowCount();;
              
        if($exist){
          
          $donnees = $result->fetch();
          $stat = $donnees['STATUT'];
          $id = $donnees['IDENTIFIANT'];
        
          if($stat){
    
            $result = $bdd->prepare("UPDATE EMAIL SET STATUT =0 WHERE IDENTIFIANT =:id");
            $result -> bindParam(':id', $id, PDO::PARAM_INT);
            $result -> execute();				
            $result->closeCursor();
            
            $tab="ok;".$id.";".str_replace(";","",$_POST['mail']);
          }else
            $tab="ko;";
        }
        else{
          $result = $bdd->prepare("INSERT INTO EMAIL(LIBELLE,STATUT,ID_USER) VALUES(:mail,0,:iduser)");
          $result -> bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
          $result -> bindParam(':iduser', $iduser, PDO::PARAM_INT);
          $result -> execute();			
          $result->closeCursor();
          
          $tab="ok;".$bdd->lastInsertId().";".str_replace(";","",$_POST['mail']);
        }   				     	
         
	return $tab;		 
}
		
if($_POST['action']=='afficher')
	$tab=Afficher($bdf,$_SESSION['ID']);
if($_POST['action']=='ajouter')    
	$tab=Ajouter($bdf,$_SESSION['ID']);
if($_POST['action']=='desactiver')    
	$tab=Desactiver($bdf,$_SESSION['ID']);

/* Output header */
  header('Content-type: application/json');
  echo json_encode($tab);

?>