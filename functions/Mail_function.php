<?php
 
function envoimailfacture($destinataire,$sujet,$message,$filename,$fichier){
	
	global $mail_server,$test_mail,$mail_admin;	

	$depotmail="";
	
	if($mail_server){
		
		$source = array();
		for($i=0;$i<count($filename);$i++){
			$filename[$i].=$fichier[$i];
			$source[] = ($fichier[$i]?file_get_contents($filename[$i]):"");
		}
				$domaine="cci.ci";
				$nomexp="CCI - COTE D'IVOIRE<vgm@cci.ci>";
				$expediteur="vgm@cci.ci";
	
				$boundary = md5(uniqid(rand(), true));
				$entetes  ='MIME-Version: 1.0'."\r\n";
				$entetes .='Organization: '.$domaine."\r\n";
				$entetes .='From: '.$nomexp."\r\n";
				$entetes .='Reply-To: '.$expediteur."\r\n";
				$entetes .='X-Mailer: PHP/'.phpversion()."\r\n";
				$entetes .='Content-Type: multipart/mixed; boundary="'.$boundary.'"';
				$n="\n";
				$body  = 'This is a multi-part message in MIME format.'.$n;
				$body .= '--'.$boundary.$n;
				$body .= 'Content-Type: text/html; charset="UTF-8"'.$n;
				$body .= "Content-Transfer-Encoding: 8bit".$n;
				$body .= $n;
				$body .= 'Bonjour,<br/><br/> '.$message.' <br/><br/>Cordialement<br/><br/>';
				$body .= '<strong><center>Ce mail vous a été envoyé automatiquement. Merci de ne pas repondre.</center></strong>';
				for($i=0;$i<count($filename);$i++)
					if($source[$i]){
						$fich=explode(".",$fichier[$i]);
						$ext=explode(".",$fichier[$i]);
						$body .= $n.'--'.$boundary.$n;
						$body .= 'Content-Type: application/octet-stream; name="'.substr(str_replace("_","",$fich[0]),8,12).'.'.$ext[count($ext)-1].'"'.$n;
						$body .= 'Content-Transfer-Encoding: base64'.$n;
						$body .= 'Content-Disposition: attachment; filename="'.$fichier[$i].'"'.$n;
						$body .= $n;

						$source[$i] = base64_encode($source[$i]);
						$source[$i] = chunk_split($source[$i]);
						$body .= $source[$i];
					}
				$body .= $n.'--'.$boundary.'--'.$n;
				$body = wordwrap($body, 70);

				if (!mail(($test_mail?$mail_admin:$destinataire), ($test_mail?"[".$destinataire."] ":"").$sujet, $body, $entetes,$expediteur))		//IPAGE
//				if (!mail(($test_mail?$mail_admin:$destinataire), ($test_mail?"[".$destinataire."] ":"").$sujet, $body, $entetes,"-f'$expediteur."))	//SOLAS & NSIA
					$depotmail=("Echec d'envoi du  mail '".$sujet."' à {".$destinataire."}");
	}

	return $depotmail;
}


?>
