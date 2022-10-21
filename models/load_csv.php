<?php
    session_start();

    include('../config/Connexion.php');
    include('../functions/Request_Extraction_function.php');
    include('../functions/PDF_File_function.php');
    include_once('../functions/Table_value_function.php');
    include('../functions/Users_get_chargeurs_html.php');
    
    function addchmp($val){
        $val=str_replace(CHR(10),"",$val);
        $val=str_replace(CHR(13),"",$val);
        $val=str_replace("\n","",$val);
        $val=str_replace("\r","",$val);
        $val=";".str_replace(";","",$val);
        return $val;
    }

    function nomdefichier($fichier){

        for($i=0;$i<strlen($fichier);$i++) {
            $char=substr($fichier,$i,1);
            if (!(($char >= CHR(65) && $char <= CHR(90)) || ($char >= CHR(97) && $char <= CHR(122)) || ($char >= CHR(48) && $char <= CHR(57))))
                $fichier=str_replace($char, "_", $fichier);
        }
    
        return substr($fichier,0,30);
    }

            $pont=(isset($_GET['pont'])?$_GET['pont']:'');
            $chrg=(isset($_GET['chrg'])?$_GET['chrg']:'');
            $debut=(isset($_GET['debut'])?datesitetoserver($_GET['debut']):'');
            $fin=(isset($_GET['fin'])?datesitetoserver($_GET['fin']):'');
            $cafe=(isset($_GET['cafe'])?$_GET['cafe']:'');
            $autres=(isset($_GET['autres'])?$_GET['autres']:'');
            $strc=(isset($_GET['user_id'])?$_GET['user_id']:'');
            $mois=$_GET['mois'];
            $annee=$_GET['annee'];
            // $c=0;
            if($cafe==0 && $autres==1)
                $type='2';
            else if($cafe==1 && $autres==0)
                $type='1';
            // else if($cafe==1 && $autres==1)
            //     $type='1,2';


                $query = $bds -> prepare(requestExtraction($pont,$chrg,$debut,$fin,$type,$mois,$annee));

                $query -> execute();
                $rows = $query -> rowCount();
                $moiss = array('Janvier','Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
          //       $annee=substr($debut,0,4);
		        // $mois=substr($debut,5,2);

                $ln="\n";
                $i=0;
                $cnt="";

                if($i==0){
                    $user=(($strc==$chrg)?getvalue($bds,'DERIVE','CORRESPONDANCE','ORIGINAL',$chrg):getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$strc));

		            $numfac=(($strc==$chrg)?getvalue($bdf,'NUM_FACTURE','FACTURE','ID_CHAR',$chrg):getvalue($bdf,'NUM_FACTURE','FACTURE','ID_USER',$strc));


                    $titre=addchmp("Pour Le Client :");
                    $titre.=addchmp($user[0]);
                    $titre.=addchmp("Pour La Facture :");
                    $titre.=addchmp($numfac[0]);
                    $titre.=addchmp("du : 01".' '.strtoupper($moiss[$mois-1]).' '. $annee);
                    $titre.=$ln;
                    $titre.=$ln;
                    $entete=addchmp("DATE DE PESEE");
                    $entete.=addchmp("N CONTENEUR");
                    $entete.=addchmp("N BOOKING");
                    $entete.=addchmp("N PLOMB");
                    $entete.=addchmp("ARMATEUR");
                    $entete.=addchmp("TRANSITAIRE");
                    $entete.=addchmp("PRODUIT");
                    $entete.=addchmp("POIDS VGM");
                    $entete.=addchmp("N DOSSIER");
                    $entete.=$ln;
                    while($data = $query -> fetch()){
                        if($cnt!=$data["N_CONTENEUR_1"]){
                            $cnt=$data["N_CONTENEUR_1"];

                            $produit= getvalue($bds,'ORIGINAL','CORRESPROD','DERIVE',$data['PRODUIT']);
						    $produit= getvalue($bds,'NOM','PRODUIT','IDENTIFIANT',$produit[0]);

                            // $entete.=addchmp($data['CHARGEUR']);
							$entete.=addchmp($data['DATE_RECEPT']);
							$entete.=addchmp($data['N_CONTENEUR_1']);
							$entete.=addchmp($data['N_DOSSIER_BOOKING']);
							$entete.=addchmp($data['N_PLOMB_1']);
							$entete.=addchmp($data['COMPAGNIE_MARITIME']);
							$entete.=addchmp($data['TRANSITAIRE']);
							$entete.=addchmp($produit[0]);
							$entete.=addchmp(/*number_format(*/$data['POIDS_VGM'],0,""," ")/*)*/;
							$entete.=addchmp($data['chp57']);
                            $entete.=$ln;

                            $i++;
                        }
                        $date=strtoupper(strftime("%B", strtotime($donnees['DATE_RECEPT'])));
                    }
                    $cout= $i*$tarif;
                    $entete.=addchmp("TOTAL");
                    $entete.=addchmp("MOIS DE ". $date);
                    $entete.=addchmp($i."TICKETS");
                    $entete.=addchmp(number_format($cout,0,""," "). "F");
                    $entete.=$ln;
                    $entete.=$ln;
                    $entete.=addchmp("TOTAL GENERAL");
                    $entete.=addchmp($i."TICKETS");
                    $entete.=addchmp(number_format($cout,0,"",".")." F");
                    $query -> closeCursor();
                }
              
      //       $account=getvalue($bdf,'ID_USER','PONT','ID_PONT',$pont);
		    // $user=($account[0]?getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE','PONT','ID_PONT',$pont));

            $bds = null;

            $ligne=$titre.$entete;
            $fichier=nomdefichier($user[0]);
            $path = "../".$uploadrep."/".$fichier.".csv";
            

            if (!$handle = fopen(/*$path, 'w'*/$fichier,'w'))
                exit;
            if (fwrite($handle, $ligne) === FALSE)
                exit;
            fclose($handle);

            ignore_user_abort(true);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$fichier.".csv".'"');

            readfile($fichier);
            unlink($fichier);

?>