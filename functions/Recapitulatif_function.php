<?php
	
	include_once('../functions/Mail_function.php');


require('../vendors/fpdf/fpdf.php');

class PDF extends FPDF
	{
	
	// Tableau coloré
	function Tableau($titre1,$titre2,$header, $data)
		{
		    // En-tête
		    $w = array(30, 30, 30, 40,30,30);
		    $h = 6;
		    $fill = true;
		    $i = 0;
		    if(count($data))
			{
			    foreach($data as $row)
				    {
					if($i==0)
						{
						    $this->AddPage();
						    // Police Arial gras 15
						    $this->SetDrawColor(128,0,0);
						    $this->SetFont('Arial','B',15);
						    // Titre 1
						    $this->Cell(0,10,$titre1,'LRT',0,'C');
						    // Saut de ligne
						    $this->Ln();
						    // Titre 2
						    $this->Cell(0,10,$titre2,'LRB',0,'C');
						    // Saut de ligne
						    $this->Ln(20);

						    $this->SetFont('Arial','',7);
						    // Couleurs, épaisseur du trait et police grasse
						    $this->SetFillColor(255,0,0);
						    $this->SetTextColor(255);
						    $this->SetDrawColor(128,0,0);
						    $this->SetLineWidth(.3);
						    $this->SetFont('','B');
						    // En-tête
						    for($i=0;$i<count($header);$i++)
							$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
						    $this->Ln();
						    // Restauration des couleurs et de la police
						    $this->SetTextColor(0);
						    $this->SetFont('');
						}				
					$i++;
					$this->SetFillColor((($i % 2)?255:224),(($i % 2)?255:235),(($i % 2)?255:255));
					$this->Cell($w[0],$h,number_format($row[0],0,',',' '),'LR',0,'C',$fill);
					$this->Cell($w[1],$h,$row[1],'LR',0,'L',$fill);
					$this->Cell($w[2],$h,$row[2],'LR',0,'L',$fill);
					$this->Cell($w[3],$h,$row[3],'LR',0,'L',$fill);
					$this->Cell($w[4],$h,$row[4],'LR',0,'C',$fill);
					$this->Cell($w[5],$h,$row[5],'LR',0,'C',$fill);
					$this->Ln();

					if($i==40)
						{
						$i=0;
						$this->Cell(array_sum($w),0,'','T');
						}
				    }
			    // Trait de terminaison
			    $this->Cell(array_sum($w),0,'','T');
			}
		}
	}


function recapitulatif($bdd,$query,$idop,$idville)
	{		
	$chemin="";
	$nomop="";
	$debut="";
	$fin="";
	$data = array();
	$ligne="";
	$i=0;
	$reponse=$bdd->query($query);
	while ($donnees = $reponse->fetch())
		{
		$i++;
		$nomagent="";
		$telagent="";
		//retrouver le l'inspecteur de la reservation
		$query="SELECT I.IDENTIFIANT,I.NOM,I.PRENOMS,I.CONTACT_FLOTTE,I.CONTACT_PERSO,U.LOGIN,A.DATE_CREATION ";
		$query.=" FROM Affectation A,Inspecteur I,User U WHERE A.RESERVATION='".$donnees['IDENTIFIANT']."' AND A.INSPECTEUR=I.IDENTIFIANT AND A.USER=U.IDENTIFIANT AND A.STATUT='1' AND U.TYPE_COMPTE='1' ORDER BY A.IDENTIFIANT DESC LIMIT 0,1";
		$res=$bdd->query($query);
		while ($lign = $res->fetch())
			{
			$nomagent=str_replace(";","",$lign['NOM']." ".$lign['PRENOMS']);
			$telagent=str_replace(";","",$lign['CONTACT_FLOTTE'].(($lign['CONTACT_FLOTTE']&&$lign['CONTACT_PERSO'])?'/':'').$lign['CONTACT_PERSO']);
			}
		$res->closeCursor();	
		$ligne=$i.";".str_replace(";","",$donnees['LIBELLE']).";".str_replace(";","",$donnees['SITE_STRUCTURE']).";".str_replace(";","",$nomagent).";".str_replace(";","",$telagent).";".substr($donnees['DATE_RESERVATION'],8,2).'/'.substr($donnees['DATE_RESERVATION'],5,2).'/'.substr($donnees['DATE_RESERVATION'],0,4)." ".(($donnees['PLAGE_HORAIRE']==1)?"JOUR":(($donnees['PLAGE_HORAIRE']==2)?"NUIT":(($donnees['PLAGE_HORAIRE']==3)?"RELAIS":"NON DEFINI")));
		$data[] = explode(';',$ligne);
		$debut=(($debut)?(($donnees['DATE_RESERVATION']<$debut)?$donnees['DATE_RESERVATION']:$debut):$donnees['DATE_RESERVATION']);
		$fin=(($fin)?(($fin<$donnees['DATE_RESERVATION'])?$donnees['DATE_RESERVATION']:$fin):$donnees['DATE_RESERVATION']);
		$nomop=(($idop && !$nomop)?str_replace(" ","_",str_replace("/","_",$donnees['OPERATEUR_STRUCTURE'])):$nomop);
		}
	$reponse->closeCursor();	

	if($i)
		{
		$fin=(($fin==$debut)?"":$fin);
		$debut=substr($debut,8,2).'/'.substr($debut,5,2).'/'.substr($debut,0,4);
		$fin=($fin?substr($fin,8,2).'/'.substr($fin,5,2).'/'.substr($fin,0,4):"");
		$fichier=($idop?$nomop."_":"")."Programme_pour_".(($idville=="1")?"Abidjan":(($idville=="2")?"San-pedro":"Tous"))."_du_".str_replace("/","-",$debut).($fin?"_au_".str_replace("/","-",$fin):"").".pdf";

		$chemin="recaps/".(($idville=="1")?"Abidjan":(($idville=="2")?"San-pedro":"Tous"))."/".$fichier;

		$pdf = new PDF();

		// Titre 1
		$titre1='PROGRAMMATION DES OPERATIONS DE PESEE '.($idop?"":'D'.(($idville=="1")?"'ABIDJAN":"E ".(($idville=="2")?"SAN-PEDRO":"TOUS")));
		// Titre 2
		$titre2='DU '.$debut.($fin?" AU ".$fin:"");
		// Titres des colonnes
		$header = array('NUMERO D\'ORDRE', 'PONTS BASCULES', 'PROPRIETAIRES','NOM ET PRENOMS','CONTACTS','OBSERVATIONS');
		// Remplissage du tableau
		$pdf->Tableau($titre1,$titre2,$header,$data);
		// Creation du fichier PDF
		$pdf->Output('F',"../".$chemin);	

		$message="Veuillez trouver ci-joint, ".($idop?"votre":"le")." programme des opérations de pesée ".($idop?"":"d".(($idville=="1")?"'Abidjan":"e ".(($idville=="2")?"San-pédro":"Tous")).",")." du ".$debut.($fin?" au ".$fin:"").".";


		//Envoi du programme par mails aux utilisateurs/administrateurs de la ville
		$result="";
		$query="SELECT E.LIBELLE FROM Email E,User U WHERE E.USER=U.IDENTIFIANT AND U.STATUT_COMPTE='0' AND E.STATUT='0' AND U.".($idop?"IDENTIFIANT='".$idop:"TYPE_COMPTE='1")."'  ";
		$reponse=$bdd->query($query);
		while ($donnees = $reponse->fetch())
			$result.=envoimail($donnees['LIBELLE'],$titre1." ".$titre2,$message,$fichier,"../".$chemin);
		$reponse->closeCursor();	
		}

	return $chemin;	
	}	  

?>
