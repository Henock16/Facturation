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
            // $c=0;
            if($cafe==0 && $autres==1)
                $type='2';
            else if($cafe==1 && $autres==0)
                $type='1';
            // else if($cafe==1 && $autres==1)
            //     $type='1,2';


                $query = $bds -> prepare(requestExtraction($pont,$chrg,$debut,$fin,$type));

                $query -> execute();
                $rows = $query -> rowCount();

                $annee=substr($debut,0,4);
		        $mois=substr($debut,5,2);

                $ln="\n";
                $i=0;
                $cnt="";

                if($i==0){
                    $account=getvalue($bdf,'ID_USER','PONT','ID_PONT',$pont);
		            $user=($account[0]?getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE','PONT','ID_PONT',$pont));

                    $titre=addchmp("Pour Le Client :");
                    $titre.=addchmp($user[0]);
                    $titre.=addchmp("Pour La Facture :");
                    $titre.=addchmp("SOL".$annee.$mois.Complete($pont,3).$type);
                    $titre.=addchmp("du :".strftime('%d %B %Y'));
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
							$entete.=addchmp(number_format($data['POIDS_VGM'],0,""," "));
							$entete.=addchmp($data['chp57']);
                            $entete.=$ln;

                            $i++;
                        }
                        $date=strtoupper(strftime("%B", strtotime($donnees['DATE_RECEPT'])));
                        // $data['DATE_RECEPT'];
                        // $data['ORIGINAL'];
                        // $data['HEURE_RECEPT'];
                        // $data['CHARGEUR'];
                        // $data['N_DOSSIER_BOOKING'];
                        // $data['N_CONTENEUR_1'];
                        // $data['N_PLOMB_1'];
                        // $data['TRANSITAIRE'];
                        // $data['COMPAGNIE_MARITIME'];
                        // $data['CHARGEUR'];
                        // $data['METHODE_DE_PESEE_VGM'];
                        // $data['POIDS_VGM'];
                        // $data['PRODUIT'];
                        // $data['N_CONTRAT'];
                        // $data['chp57'];
                        // $data['DATE_EMIS'];
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
                // echo $csv=fputcsv($pont,$chrg,$debut,$fin,$type);
                
            //    $cvs= requestExtraction($pont,$chrg,$debut,$fin,$type);
            //    $csv=getChargeursHtml($pont,$debut,$fin,$type,$user);
            $account=getvalue($bdf,'ID_USER','PONT','ID_PONT',$pont);
		    $user=($account[0]?getvalue($bdf,'STRUCTURE','USER','IDENTIFIANT',$account[0]):getvalue($bds,'STRUCTURE','PONT','ID_PONT',$pont));

            $bds = null;

            $ligne=$titre.$entete;
            // $debut=datesitetoserver($debut);
            // $fin=datesitetoserver($fin);
            // $annee=substr($debut,0,4);
            // $mois=substr($debut,5,2);
            // $path=CSVfile('PATH',$repfact,$annee,$mois,$pont,$chrg,$cafe,$autres);
            // $file=CSVfile('FILE',$repfact,$annee,$mois,$pont,$chrg,$cafe,$cajou,$autres);
            $fichier=nomdefichier($user[0]);
            $path = "../".$uploadrep."/".$fichier.".csv";
            

            // while($rs = $rows->fetch(PDO::FETCH_ASSOC)){
            //     $tab[] = [$rs['DATE_RECEPT'], $rs['ORIGINAL'], $rs['HEURE_RECEPT'],$rs['CHARGEUR'], $rs['N_DOSSIER_BOOKING'], $rs['N_CONTENEUR_1'], $rs['N_PLOMB_1'],$rs['TRANSITAIRE'], $rs['COMPAGNIE_MARITIME'], $rs['CHARGEUR']];
            // } 

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