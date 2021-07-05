<?php
    session_start();
    include('../config/Connexion.php');
    //include_once('../../functions/Table_value_function.php');

    $username = $_POST['user'];
	$password = $_POST['pass'];
	$today = date('Y-m-d');

        $query = $bdd->prepare("SELECT * FROM USER WHERE BINARY LOGIN =:user AND BINARY PASS=:pass AND TYPE NOT IN(1,2,3,4,5,6)");
		$query -> bindParam(':user', $username, PDO::PARAM_STR);
		$query -> bindParam(':pass', $password, PDO::PARAM_STR);
		$query -> execute();

		$rows = $query -> rowCount();

        if($rows > 0){

        while($data = $query->fetch())
			{
               
			    $interval = time() - $data['DERNIERE_ACTION'] ;

                    //COMPTE DESACTIVE
                if($data['STATUT'] == 1){
                    $result['0'] = 1 ;
                }
                //COMPTE EN COURS D'UTILISATION
                elseif(($data['DERNIERE_ACTION'] > 0) && ($interval < $deconnect)){
                    $result['0'] = 2 ;
                }
                //PREMIERE CONNEXION
                elseif($data['TYPE'] == 7){
                   
                    $result['0'] = 5 ;
    
                    $_SESSION['CONNECT'] = 1;
                    $_SESSION['ID'] = $data['IDENTIFIANT'];
                    $_SESSION['NAME'] = $data['NOM'];       
                    $_SESSION['TYPE'] = $data['TYPE'];
                    $_SESSION['DERNIERE_ACTION'] = time();
                    $_SESSION['LAST_PAGE'] = $data['LAST_PAGE'];
                    $result['1'] = $_SESSION['LAST_PAGE'] ;

                    $id=$data['IDENTIFIANT'];
				
                    
                }
            }
        }
				
                else{
                    $result['0'] = 0 ;
                }
                $query->closeCursor();
                
                $bdd = null;
            
                /* Output header */
                header('Content-type: application/json');
                echo json_encode($result) ;
				
			
				
?>
