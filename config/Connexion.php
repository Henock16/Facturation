<?php
$uploadrep="uploads/";
$lang=1; //1=FR/2=EN
$mpdf=7; //6=mpdf version 6 pour apache 5 /7=mpdf version 7 pour apache 7 avec autoloader

$deconnect=15*60;//(minute*60=second)
$appli="FACTURATION";
$nom_site="facturationcci.ci"; //URL du site ou est hebergee l'application sans le http:// ou https://
$mail_server=0;	//0=pas de transmission de mail 1=transmission de mail=presence de serveur de mail
$test_mail=1; //1=envoyer tous les mails dans ma boite   0=envoyer des mails dans la boite  de l'agent

$nbreserv=10; //nb de reservation par page
$nbdays=0; //0=nb de jr off / >0=nb de jr / -1=nb de jr infini
$plagejour=8; //nb Heure lors de la plage jour
$plagenuit=8; //nb Heure lors de la plage nuit
$heuremax=40; //nb Heure maximum a ne pas depasser
$nbaffect=5; //nb daffectations a afficher pour un inspecteur


$host='localhost';
$user='root';
//$pass="kj2ji63E8bmpYSedjqaP658IYN78uL2Evg";//cci desktop
$pass=""; //my laptop
//$pass="NRtPEvqJYXtPE5gK"; //ipage
//$pass="KRbKsjK6jRrxQi"; //NSIA
$base='solas';

date_default_timezone_set("Africa/Abidjan");

$bdd = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8',$user , $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>
