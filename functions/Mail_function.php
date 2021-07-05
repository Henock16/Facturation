<?php
 
function envoimail($destinataire,$sujet,$message,$fichier,$filename)
	{
	global $mail_server,$test_mail;	

	$depotmail="";
	
	if($mail_server)
	if(($fichier && file_exists($filename))||(!$fichier && !$filename))
		{
		if(($fichier && filesize($filename))||(!$fichier && !$filename))
			{
			$source = ($fichier?file_get_contents($filename):"");

			if(($fichier && $source)||(!$fichier && !$filename))
				{
				$domaine="cci.ci";
				$nomexp="CCI - COTE D'IVOIRE<vgm@cci.ci>";
				$expediteur="vgm@cci.ci";
	
				$boundary = md5(uniqid(rand(), true));
				$entetes  ='MIME-Version: 1.0'."\r\n";
				$entetes .='Organization: '.$domaine."\r\n";
				$entetes .='From: '.$nomexp."\r\n";
				$entetes .='Reply-To: '.$expediteur."\r\n";
				$entetes .='X-Mailer: PHP/'.phpversion()."\r\n";
				$entetes .='Content-Type: multipart/'.((!$fichier && !$filename)?"mixed":"mixed").'; boundary="'.$boundary.'"';
				$n="\n";
				$body  = 'This is a multi-part message in MIME format.'.$n;
				$body .= '--'.$boundary.$n;
				$body .= 'Content-Type: text/html; charset="UTF-8"'.$n;
				$body .= "Content-Transfer-Encoding: 8bit".$n;
				$body .= $n;
				$body .= 'Bonjour,<br/><br/> '.$message.' <br/><br/>Cordialement<br/><br/><strong><center>Ce mail vous a été envoyé automatiquement. Merci de ne pas repondre.</center></strong>';
				if($source)
					{
					$fich=explode("_",$fichier);
					$ext=explode(".",$fichier);
					$body .= $n;
					$body .= '--'.$boundary.$n;
					$body .= 'Content-Type: application/octet-stream; name="'.substr($fich[0],0,10).'.'.$ext[count($ext)-1].'"'.$n;
					$body .= 'Content-Transfer-Encoding: base64'.$n;
					$body .= 'Content-Disposition: attachment; filename="'.$fichier.'"'.$n;
					$body .= $n;

					$source = base64_encode($source);
					$source = chunk_split($source);
					$body .= $source;
					}
				$body .= $n.'--'.$boundary.'--'.$n;
				$body = wordwrap($body, 70);

				if (!mail(($test_mail?"stephaneabro@cci.ci":$destinataire), ($test_mail?"[".$destinataire."] ":"").$sujet, $body, $entetes,$expediteur))		//IPAGE
//				if (!mail(($test_mail?"stephaneabro@cci.ci":$destinataire), ($test_mail?"[".$destinataire."] ":"").$sujet, $body, $entetes,"-f'$expediteur."))	//SOLAS & NSIA
					$depotmail=("Echec d'envoi du  mail '".$sujet."' à {".$destinataire."}");
				}
			else
				$depotmail=("Le contenu charge du fichier $filename est vide");;
			}
		else
			$depotmail=("Le fichier $filename est vide");;
		}
	else
		$depotmail=("Le fichier $filename n'existe pas");;

	return $depotmail;
	}


?>
