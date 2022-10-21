<?php
/*
    Date creation : 25-05-2021
    Auteur : Cellule SOLAS - ABRS
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
*/
date_default_timezone_set("Africa/Abidjan");
$month = array("janvier","fevrier","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","decembre");
$verbose=1;//afficher le traitement de la generation automatique des factures dans le log
$host='localhost';
$user='root';
//$pass="kj2ji63E8bmpYSedjqaP658IYN78uL2Evg";//cci desktop
$pass=""; //my laptop
//$pass="NRtPEvqJYXtPE5gK"; //ipage
//$pass="KRbKsjK6jRrxQi"; //NSIA

$basefact='facturation';
$basesolas='solas';

$bdf = new PDO('mysql:host='.$host.';dbname='.$basefact.';charset=utf8',$user , $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$bds = new PDO('mysql:host='.$host.';dbname='.$basesolas.';charset=utf8',$user , $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$uploadrep="uploads/";
$lang=1; //1=FR/2=EN
$mpdf=6; //6=mpdf version 6 pour apache 5 /7=mpdf version 7 pour apache 7 avec autoloader
$repfact="factures";
///////////////////////////////////////////////////////////////////////
$deconnect=15*60;//(minute*60=second)

$appli="FACTURATION SOLAS";
$nom_site="facturation.pesagecci.com"; //URL du site ou est hebergee l'application sans le http:// ou https://
$mail_server=0;	//0=pas de transmission de mail 1=transmission de mail=presence de serveur de mail
$test_mail=1; //1=envoyer tous les mails dans ma boite   0=envoyer des mails dans la boite  de l'utilisateur
$mail_admin="stephaneabro@cci.ci"; //Adresse électronique de l'administrateur
$mail_fact=1;//1=activer la generation des factures en debut de mois   0=désactiver la generation des factures en debut de mois
$facture=5;//Nombre de  mois en arrière de facturation

$tarif=2750;//Coût de la prestation SOLAS
$cafe=0;//Facturation des pesées café/cacao
$cajou=1;//Facturation des pesées coton/cajou
$autres=1;//Facturation des autre pesées 
$cumul=1;//1-Facture cumulative 0-non

$nbpnt=10;//Nombre de ponts par  page
$nbchg=10;//Nombre de chargeurs par  page
$nbuser=10;//Nombre d'utilisateurs par  page
$genfact=1; //Forcer la génération des factures si elles ne l'ont pas encore été
$pass='12345';//Mot de passe par défaut

$numcc='9-206.388.X';
$regime='Régime du réel normal';
$impot='Direction des grandes entreprises';
$bank='UBA COTE DIVOIRE';
$compte='CI150 0100 101090011461';
$tva="0";//Taux de la TVA
$signature='facture_solas.png';
$cmpt_colec=411230;//compte collectif
$code_j='VEN';//code journal
$numprod=706109;

$query="SELECT * FROM PARAMETRE ";
$res=$bdf->query($query);
while ($donnees = $res->fetch())
	{
	if("deconnect"==$donnees['NOM'])
		$deconnect=$donnees['VALEUR']*60;
	elseif("appli"==$donnees['NOM'])
		$appli=$donnees['VALEUR'];
	elseif("nom_site"==$donnees['NOM'])
		$nom_site=$donnees['VALEUR'];
	elseif("mail_server"==$donnees['NOM'])
		$mail_server=$donnees['VALEUR'];
	elseif("test_mail"==$donnees['NOM'])
		$test_mail=$donnees['VALEUR'];
	elseif("mail_admin"==$donnees['NOM'])
		$mail_admin=$donnees['VALEUR'];
	elseif("mail_fact"==$donnees['NOM'])
		$mail_fact=$donnees['VALEUR'];
	elseif("facture"==$donnees['NOM'])
		$facture=$donnees['VALEUR'];
	elseif("tarif"==$donnees['NOM'])
		$tarif=$donnees['VALEUR'];
	elseif("cafe"==$donnees['NOM'])
		$cafe=$donnees['VALEUR'];
	elseif("cajou"==$donnees['NOM'])
		$cajou=$donnees['VALEUR'];
	elseif("autres"==$donnees['NOM'])
		$autres=$donnees['VALEUR'];
	elseif("nbpnt"==$donnees['NOM'])
		$nbpnt=$donnees['VALEUR'];
	elseif("nbchg"==$donnees['NOM'])
		$nbchg=$donnees['VALEUR'];
	elseif("nbuser"==$donnees['NOM'])
		$nbuser=$donnees['VALEUR'];
	elseif("genfact"==$donnees['NOM'])
		$genfact=$donnees['VALEUR'];
	elseif("pass"==$donnees['NOM'])
		$pass=$donnees['VALEUR'];
	elseif("numcc"==$donnees['NOM'])
		$numcc=$donnees['VALEUR'];
	elseif("regime"==$donnees['NOM'])
		$regime=$donnees['VALEUR'];
	elseif("impot"==$donnees['NOM'])
		$impot=$donnees['VALEUR'];
	elseif("bank"==$donnees['NOM'])
		$bank=$donnees['VALEUR'];
	elseif("compte"==$donnees['NOM'])
		$compte=$donnees['VALEUR'];
	elseif("tva"==$donnees['NOM'])
		$tva=$donnees['VALEUR'];
	elseif("signature"==$donnees['NOM'])
		$signature=$donnees['VALEUR'];
	elseif("cumul"==$donnees['NOM'])
		$cumul=$donnees['VALEUR'];
	elseif("cmpt_colec"==$donnees['NOM'])
		$cmpt_colec=$donnees['VALEUR'];
	elseif("code_j"==$donnees['NOM'])
		$code_j=$donnees['VALEUR'];
	elseif("'num_prod"==$donnees['NOM'])
		$numprod=$donnees['VALEUR'];
	}
$res->closeCursor();	





?>
