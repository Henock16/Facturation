<?php
    session_start();
    include('../config/Connexion.php');
	include_once('../functions/Table_value_function.php');

    $username = $_POST['user'];
	$password = $_POST['pass'];

    $query = $bdf->prepare("SELECT * FROM USER WHERE BINARY LOGIN =:user AND BINARY PASS=:pass ");
	$query -> bindParam(':user', $username, PDO::PARAM_STR);
	$query -> bindParam(':pass', $password, PDO::PARAM_STR);
	$query -> execute();

	$rows = $query -> rowCount();

    if($rows > 0){

		while($data = $query->fetch()){
               
			    $interval = time() - $data['DERNIERE_ACTION'] ;

                //COMPTE DESACTIVE
                if($data['STATUT'] == 1)
                {
                    $result['0'] = 1 ;
                }
                //COMPTE EN COURS D'UTILISATION
                elseif(($data['DERNIERE_ACTION'] > 0) && ($interval < $deconnect))
                {
                    $result['0'] = 2 ;
                }
                //MOT DE PASSE REINITIALISE
                elseif($data['FIRST_CONNECTION']==2 )
                {
                    $result['0'] = 3 ;
					$_SESSION['ID'] = $data['IDENTIFIANT'] ;
                }
                //PREMIERE CONNEXION
                elseif($data['FIRST_CONNECTION']==0 )
                {
					$result['0'] = 4;
					$_SESSION['ID'] = $data['IDENTIFIANT'] ;
					$result['1'] = $data['STRUCTURE'];
					$result['2'] = $data['BP'];
					$result['3'] = $data['TELEPHONE'];
					$result['4'] = $data['NUM_CC'];
					$result['5'] = $data['ADRESSE_GEO'];
					
					$query = $bdf -> prepare("SELECT * FROM EMAIL WHERE STATUT=0 AND ID_USER=".$data['IDENTIFIANT']);
					$query -> execute();
					$mails='';
					while($data = $query -> fetch())
						$mails.=(($mails=='')?'':',').$data['LIBELLE'];
					$result['6'] = $mails;				
				}
                //CONNEXION
                elseif($data['TYPE'] == 1 || $data['TYPE'] == 2)
                {
                    $result['0'] = 5 ;
                    $_SESSION['CONNECT'] = 1;
                    $_SESSION['ID'] = $data['IDENTIFIANT'];
                    $_SESSION['NAME'] = $data['STRUCTURE'];       
                    $_SESSION['TYPE'] = $data['TYPE'];
                    $_SESSION['DERNIERE_ACTION'] = time();
                    $_SESSION['LAST_PAGE'] = $data['LAST_PAGE'];
                    $result['1'] = $_SESSION['LAST_PAGE'] ;

                    $id=$data['IDENTIFIANT'];
				
					$query1 = $bdf -> prepare("SELECT ID_PONT FROM PONT WHERE ID_USER=".$data['IDENTIFIANT']." ");
					$query1 -> execute();
					$ponts='';
					while($data1 = $query1 -> fetch())
						$ponts.=($ponts?',':'').$data1['ID_PONT'];
					$query -> closeCursor();
 
                    $_SESSION['PONTS'] = $ponts ;
 
                }
		}
		$query->closeCursor();
			
    }else{	//UTILISATEUR OU MOT DE PASSE ERRONE

        $result['0'] = 0 ;
    }
                                
    $bdf= null;
            
    /* Output header */
    header('Content-type: application/json');
    echo json_encode($result) ;
				
?>
