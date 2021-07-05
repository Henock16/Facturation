<?php
	
	include_once('../functions/Mail_function.php');


function Notification($bdd,$action,$idreserv)
	{
	$idop="";
	$inspecteur="";
	$telephone="";
	$site="";
	$plage="";
	$reserv="";
	$query="SELECT R.DATE_RESERVATION,R.PLAGE_HORAIRE,R.USER, S.LIBELLE ".(($action==3)?"":", I.NOM,I.PRENOMS,I.CONTACT_FLOTTE,I.CONTACT_PERSO ");
	$query.=" FROM Reservation R,Site S ".(($action==3)?"":" ,Inspecteur I,Affectation A ");
	$query.=" WHERE R.IDENTIFIANT='".$idreserv."' AND  R.SITE=S.IDENTIFIANT ".(($action==3)?"":" AND A.INSPECTEUR=I.IDENTIFIANT AND A.RESERVATION=R.IDENTIFIANT AND A.STATUT='".(($action==5)?"2":"1")."' ORDER BY A.IDENTIFIANT DESC LIMIT 0,1");
	$res=$bdd->query($query);
	while ($lign = $res->fetch())
		{
		$inspecteur=(($action==3)?"":$lign['NOM']." ".$lign['PRENOMS']);
		$telephone=(($action==3)?"":$lign['CONTACT_FLOTTE'].(($lign['CONTACT_FLOTTE']&&$lign['CONTACT_PERSO'])?'/':'').$lign['CONTACT_PERSO']);
		$site=$lign['LIBELLE'];
		$idop=$lign['USER'];
		$plage=$lign['PLAGE_HORAIRE'];
		$reserv=$lign['DATE_RESERVATION'];
		}
	$res->closeCursor();	

	$sujet=(($action==3)?"REJET POUR ":(($action==4)?"MODIFICATION POUR ":(($action==5)?"ANNULATION POUR ":"")))."OPERATION DE PESEES DE TCS SUR ".strtoupper($site);
	$reserv=substr($reserv,8,2).'/'.substr($reserv,5,2).'/'.substr($reserv,0,4);
	if($action==3)
		$message="Votre demande d'inspecteur sur <b>".strtoupper($site)."</b> pour la <b>".(($plage=="1")?"journée":"nuit")."</b> du <b>".$reserv."</b> a été rejetée . ";
	else if($action==5)
		$message="L'affectation de l'inspecteur <b>".$inspecteur." (".$telephone.")</b> sur <b>".strtoupper($site)."</b> pour la <b>".(($plage=="1")?"journée":"nuit")."</b> du <b>".$reserv."</b> a été annulée. ";
	else
		$message="En réponse à votre demande, l'inspecteur <b>".$inspecteur."(".$telephone.")</b> a été affecté sur <b>".strtoupper($site)."</b> pour la <b>".(($plage=="1")?"journée":"nuit")."</b> du <b>".$reserv."</b>. ";

	$result="";
	$query="SELECT E.LIBELLE FROM Email E,User U WHERE E.USER=U.IDENTIFIANT AND U.STATUT_COMPTE='0' AND  E.STATUT='0' AND U.IDENTIFIANT='".$idop."' ";
	$reponse=$bdd->query($query);
	while ($donnees = $reponse->fetch())
		$result=(!$result?envoimail($donnees['LIBELLE'],$sujet,$message,"",""):$result);
	$reponse->closeCursor();	
	}

?>
