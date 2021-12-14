<?php
session_start();

include('../config/Connexion.php');

function Numerotation($bdd){

	$query="SELECT * FROM USER WHERE TYPE=2 ORDER BY IDENTIFIANT DESC LIMIT 0,1";
	$result=$bdd->query($query);
	$num=0;
	while ($lign = $result->fetch())
		$num=substr($lign['LOGIN'],-3);
	$result->closeCursor();	

	return array(0,$num);
}
	
function Connexion($bdd,$id,$action){

	global $pass;

	$query="UPDATE USER SET FIRST_CONNECTION='".(($action==4)?2:0)."',PASS='".$pass."' WHERE IDENTIFIANT='".$id."' ";
	$req1=$bdd->exec($query);
	$tab[0]=($req1?0:"Erreur liée à la base de données");

	return $tab;
}


function Activation($bdd,$id,$statut,$iduser){

	$query="UPDATE USER SET STATUT='".(1-$statut)."' WHERE IDENTIFIANT='".$id."' AND STATUT='".$statut."'";
	$req1=$bdd->exec($query);
	$tab[0]=0;

	return $tab;
}

function UpdatePonts($bdd,$id){

		//liste des pont a supprimmer
		$query="SELECT ID_PONT FROM PONT WHERE STATUT='0' AND ID_USER='".$id."'";
		$result=$bdd->query($query);
		$pontdel=array();
		while ($lign = $result->fetch())
			$pontdel[]=$lign['ID_PONT'];
		$result->closeCursor();	

		//ponts a ajouter
		$pontadd=array();
		$pontval=array();

		//retrouver les ponts a ajouter et
		//annuler la suppression des ponts a ajouter
		for($i=0;$i<$_POST["pont"];$i++)
			if(isset($_POST["pont".$i])){
				$egal=false;
				for($j=0;(($j<count($pontdel))&&($egal==false));$j++)
					if($pontdel[$j]==$_POST["pont".$i]){
						$pontdel[$j]=0;
						$egal=true;
					}
				$pontadd[]=$_POST["pont".$i];
				$pontval[]=($_POST["valpont".$i]?$_POST["valpont".$i]:0);
			}

		//supprimer les ponts supprimmer
		for($i=0;$i<count($pontdel);$i++)
			if($pontdel[$i]!=0)
				$bdd->exec("UPDATE PONT SET STATUT='1' WHERE ID_USER='".$id."' AND ID_PONT='".$pontdel[$i]."'");

		//ajouter les ponts a ajouter 
		for($i=0;$i<count($pontadd);$i++){
			
			$query="SELECT * FROM PONT WHERE ID_PONT='".$pontadd[$i]."'";
			$result=$bdd->query($query);
				
			if($result->rowCount())
				$bdd->exec("UPDATE PONT SET IMPAYES=".$pontval[$i].",STATUT=0,ID_USER=".$id." WHERE ID_PONT=".$pontadd[$i]."");				
			else
				$bdd->exec("INSERT INTO PONT(IMPAYES,ID_USER,ID_PONT) VALUES('".$pontval[$i]."','".$id."','".$pontadd[$i]."')");
		}
}

function Modification($bdd,$iduser){

	$date_modif=date("Y-m-d H:i:s");

    $id = (isset($_POST['user-id'])?$_POST['user-id']:''); 
    $statut = (isset($_POST['statut'])?$_POST['statut']:0); 
    $login = (isset($_POST['login'])?$_POST['login']:'');
    $structure = (isset($_POST['structure'])?$_POST['structure']:''); 
    $numcc = (!empty($_POST['numcc'])?$_POST['numcc']:''); 
    $bp = (isset($_POST['bp'])?$_POST['bp']:'');
    $tel = (!empty($_POST['tel'])?$_POST['tel']:''); 
    $adresse = (isset($_POST['adresse'])?$_POST['adresse']:'');
	$acompte = (isset($_POST['acompte'])?($_POST['acompte']?$_POST['acompte']:0):0);

    $query=" SELECT * FROM USER WHERE IDENTIFIANT<>'".$id."' AND LOGIN='".$login."'"; 
    $result=$bdd->query($query);

    $i=0;
    $exist= "";
    while ($lign = $result->fetch()){
        $exist=$lign['LOGIN'];
        $i++;
    }
    $result->closeCursor();	

    if($i)
        $tab=array(1,$exist);
	else{
		$modif="UPDATE USER SET STATUT='".$statut."',LOGIN='".str_replace("'","''",$login)."',
		STRUCTURE='".str_replace("'","''",$structure)."',
		NUM_CC='".str_replace("'","''",$numcc)."',BP='".str_replace("'","''",$bp)."',
		TELEPHONE='".str_replace("'","''",$tel)."',ADRESSE_GEO='".str_replace("'","''",$adresse)."',
		ACOMPTE='".$acompte."',MODIFICATEUR='".$iduser."',DATE_MODIF='".$date_modif."' 
		WHERE IDENTIFIANT='".$id."'";

		$bdd->exec($modif);

		UpdatePonts($bdd,$id);

		$tab=array(0);
				
	}

	return $tab;
}

function Creation($bdd,$iduser){
	
	
	global $pass;
	
	$date_creation=date("Y-m-d H:i:s");

    $query=" SELECT * FROM USER WHERE LOGIN='".$_POST["login"]."'"; 
    $result=$bdd->query($query);

    $i=0;
    $exist= "";
    while ($lign = $result->fetch()){
        $exist=$lign['LOGIN'];
        $i++;
    }
    $result->closeCursor();	

    if($i)
        $tab=array(1,$exist);
	else{

		$statut = (isset($_POST['statut'])?$_POST['statut']:0); 
		$login = (isset($_POST['login'])?$_POST['login']:'');
		$structure = (isset($_POST['structure'])?$_POST['structure']:''); 
		$numcc = (!empty($_POST['numcc'])?$_POST['numcc']:''); 
		$bp = (isset($_POST['bp'])?$_POST['bp']:'');
		$tel = (!empty($_POST['tel'])?$_POST['tel']:''); 
		$adresse = (isset($_POST['adresse'])?$_POST['adresse']:'');
		$acompte = (isset($_POST['acompte'])?($_POST['acompte']?$_POST['acompte']:0):0);

		$sql=" INSERT INTO USER(TYPE,STATUT,LOGIN,STRUCTURE,PASS,NUM_CC,BP,TELEPHONE,ADRESSE_GEO,ACOMPTE,CREATEUR,DATE_CREATION)"; 
		$sql.="VALUES(2,".$statut.",'".str_replace("'","''",$login)."','".str_replace("'","''",$structure)."',
		'".str_replace("'","''",$pass)."','".str_replace("'","''",$numcc)."','".str_replace("'","''",$bp)."',
		'".str_replace("'","''",$tel)."','".str_replace("'","''",$adresse)."',".$acompte.",".$iduser.",
		'".str_replace("'","''",$date_creation)."')";

		$result= $bdd->exec($sql);

		$id=$bdd->LastInsertId();

		UpdatePonts($bdd,$id);

		$tab[0]=0;
	}

	return $tab;	
}

if($_POST['action-id']==1)
	$tab=Numerotation($bdf);
elseif($_POST['action-id']==4 || $_POST['action-id']==5)
	$tab=Connexion($bdf,$_POST['confirmation-id'],$_POST['action-id']);
if($_POST['action-id']==3)
	$tab=Activation($bdf,$_POST['confirmation-id'],$_POST['statut'],$_SESSION['ID']);
elseif($_POST['action-id']==2)
	$tab=Modification($bdf,$_SESSION['ID']);
elseif($_POST['action-id']==0)
	$tab=Creation($bdf,$_SESSION['ID']);


header('Content-type: application/json');
echo json_encode($tab);
?>