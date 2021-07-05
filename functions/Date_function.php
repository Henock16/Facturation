<?php

    function datesitetoserver($datetoconvert){
      return implode('-',array_reverse(explode('/', $datetoconvert)));
    }

    function dateservertosite($datetoconvert){
      return implode('/',array_reverse(explode('-', $datetoconvert)));
    }


 function date_outil($date,$nombre_jour) {

    $year = substr($date, 0, -6);
    $month = substr($date, -5, -3);
    $day = substr($date, -2);

    // récupère la date du jour
    $date_string = mktime(0,0,0,$month,$day,$year);

    // Supprime les jours
    $timestamp = $date_string - ($nombre_jour * 86400);
    $nouvelle_date = date("Y-m-d", $timestamp);

    // pour afficher
   return $nouvelle_date;

    }


    // calcul des années bissextiles
    function leap_year($year)
    {
        return date("L", mktime(0, 0, 0, 1, 1, $year));
    }

function nb_jours( $date1, $date2 )
    {

    $timestamp1    = strtotime($date1);
    $timestamp2    = strtotime($date2);

    $tot = 0; // total de jours entre les 2 dates

    // dates en jours de l'année ( depuis le 1er jan )
    $date1 = date("z", $timestamp1) ; // date de depart
    $date2 = date("z", $timestamp2) ; //date d'arrivée

    $day_stamp = 86400 ; //(3600 * 24 ); // un journée en timestamp

    // années des deux dates
    $year1 = date("Y", $timestamp1) ;
    $year2 = date("Y", $timestamp2) ;

    $num = 0; // nombre de jours feries a compter sur la duree totale
    $counter = 0; // la durée entre deux date par année

    $year = $year1; // l'année en cours ( defaut : $year1 )


    // on calcule le nombre de jours de différence entre les deux dates, en tenant
    // compte des années
    while ( $year <= $year2 )
    {
        $date3         = date("d-n-Y", mktime(0, 0, 0, 1,  1,  $year));
        $timestamp3 = strtotime($date3);
        // date de référence pour l'année en cours
        $counter = 0; // compteur de jours pour chaque année

        //on récupère la date de pâques
        $easterDate   = easter_date($year) ;
        $easterDay    = date('j', $easterDate) ;
        $easterMonth  = date('n', $easterDate) ;
        $easterYear   = date('Y', $easterDate) ;

        // le tableau sort les jours fériés de l'année depuis le premier janvier
        $closed = array
        (
            // dates fixes
            date("z", mktime(0, 0, 0, 1,  1,  $year)),  // 1er janvier
            date("z", mktime(0, 0, 0, 5,  1,  $year)),  // Fête du travail
           // date("z", mktime(0, 0, 0, 5,  8,  $year)),  // Victoire des alliés
            date("z", mktime(0, 0, 0, 8,  7, $year)),  // Fête nationale
            date("z", mktime(0, 0, 0, 8,  15, $year)),  // Assomption
            date("z", mktime(0, 0, 0, 11, 1,  $year)),  // Toussaint
           // date("z", mktime(0, 0, 0, 11, 11, $year)),  // Armistice
            date("z", mktime(0, 0, 0, 12, 25, $year)),  // Noel

            // Dates basées sur Paques
            date("z", mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear)

            ),  // Lundi de Paques
            date("z", mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear

            )), // Ascension
            date("z", mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear

            ))  // Lundi de Pentecote

        );

        // si c'est la première année -> on commence par la date de depart;
        // le compteur compte les jours jusqu'au 31dec
        if( $year == $year1 && $year < $year2 )
        {
            $i = $date1;
            $counter +=  (364+leap_year($year)) ;
        }


        // si c'est ni la première ni la dernière année -> on commence au premier
        // janvier;
        //le compteur compte tous les jours de l'année
        if( $year > $year1 && $year < $year2 )
        {
            $i = date("z", mktime(0, 0, 0, 1,  1,  $year));
            $counter += 364+leap_year($year);
        }

        // si c'est la dernière année -> on commence au premier janvier;
        // le compteur va jusqu'a la date d'arrivée
        if( $year == $year2 && $year > $year1 )
        {
            $i = date("z", mktime(0, 0, 0, 1,  1,  $year));
            $counter += $date2 ;
        }

        // si les deux dates sont dans la même année
        if( $year == $year1 && $year == $year2 )
        {
            $i = $date1;
            $counter += $date2 ;
        }

        // on boucle les jours sur la période donnée
        while ( $i <= $counter )
        {
            $tot = $tot +1; // on ajoute 1 pour chaque jour passé en revue

            if( in_array($i, $closed) )
            {
                 $num++; // on ajoute 1 pour chaque jour férié rencontré
            }

            // on compte chaque samedi et chaque dimanche
            if(((date("w", $timestamp3 + $i * $day_stamp) == 6) or (date("w",
            $timestamp3 + $i * $day_stamp) == 0)) and !in_array($i, $closed))
            {
                $num++ ;
            }
            $i++;
        }
        $year++ ; // on incremente l'année
    }
    $res = $tot - $num;
    // nombre de jours entre les 2 dates fournies - nombre de jours non ouvrés
    return $res;
}

function isNotWorkable($date)
    {

        if ($date === null)
        {
            $date = time();
        }

        //$date = strtotime(date('m/d/Y',$date));
        $date_year = new DateTime($date);
        $year= $date_year->format('Y');
       // $year = date('Y',$date);

        $easterDate  = easter_date($year);
        $easterDay   = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear   = date('Y', $easterDate);

        $holidays = array(
        // Dates fixes
        mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
        mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
        //mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
        mktime(0, 0, 0, 8,  7, $year),  // Fête nationale
        mktime(0, 0, 0, 8,  15, $year),  // Assomption
        mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
        //mktime(0, 0, 0, 11, 11, $year),  // Armistice
        mktime(0, 0, 0, 12, 25, $year),  // Noel

        // Dates variables
        mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
        mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
        mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
    );

    return in_array($date, $holidays);
}

function dateFrench($date1)
    {

       $date = utf8_encode(strftime("%d/%m/%Y", strtotime($date1)));
       return $date;
    }

//la function da  datefr2en 
function datefr2en($mydate)
	{
	@list($jour,$mois,$annee)=explode('/',$mydate);
	return ((!empty($annee)&&!empty($mois)&&!empty($jour))?($annee.'-'.$mois.'-'.$jour):'');
	}

function dateen2fr($mydate)
	{
	@list($annee,$mois,$jour)=explode('-',$mydate);
	return ((!empty($annee)&&!empty($mois)&&!empty($jour))?($jour.'/'.$mois.'/'.$annee):'');
	}

function liste_des_agents($pont,$selected,$ville)
	{
	$agent = array();
	$lundi=date('Y-m-d',strtotime("-".(date('w')?(date('w')-1):"6")." days"));

	$html='<option value="" selected="selected">&lt;CHOISIR UN AGENT&gt;</option>';

	global $bdd;

	$query="SELECT * FROM Inspecteur WHERE STATUT='0' ".((isset($ville)&&$ville>0)?" AND VILLE='".$ville."'":"")." ORDER BY NOM,PRENOMS ";
	$result=$bdd->query($query);
	$nbr_agents=0;
	while ($lign = $result->fetch())
		{
		$nbr_agents++;


		$query="SELECT * FROM Affectation A,Reservation R WHERE A.INSPECTEUR='".$lign['IDENTIFIANT']."' AND A.STATUT='1' AND A.RESERVATION=R.IDENTIFIANT AND R.STATUT='3' AND R.DATE_RESERVATION>='".$lundi."' AND (R.DATE_RESERVATION<'".date('Y-m-d')."' OR (R.DATE_RESERVATION='".date('Y-m-d')."' AND R.PLAGE_HORAIRE IN('1','3'))) ";
		$res=$bdd->query($query);
		$num = 0;
		$heures = 0;
		while ($donnees = $res->fetch())
			{
			$num++;
			$heures+=(($donnees['PLAGE_HORAIRE']==3)?3:8);
			}
		$res->closeCursor();



		$infos=$lign['IDENTIFIANT'].";".str_replace(";","",$lign['NOM']." ".$lign['PRENOMS']).";".$heures.";".$num.";".nomsite($bdd,$lign['SITE_AFFECTATION']).";".nivsite($bdd,$lign['SITE_AFFECTATION']);
		$agent[]=explode(";",$infos);
		}
	$result->closeCursor();	

	$agent=tri($agent,$nbr_agents,6,2,0);

	for($j=0;$j<$nbr_agents;$j++)
		if($agent[$j][2]<40)
			$html.='<option value="'.$agent[$j][0].'" '.(!empty($agent)?(($selected==$agent[$j][0])?'selected="selected"':''):'').'>'.$agent[$j][1].'  '.(($agent[$j][2])?'| '.$agent[$j][2].' heure'.(($agent[$j][2]>1)?'s':'').' d\'affectation':'').' </option>';
//			$html.='<option value="'.$agent[$j][0].'" '.(!empty($agent)?(($selected==$agent[$j][0])?'selected="selected"':''):'').'>'.$agent[$j][1].' (Depuis lundi, '.(($agent[$j][2])?$agent[$j][2]:'aucune').' heure'.(($agent[$j][2]>1)?'s':'').' '.(($agent[$j][3])?$agent[$j][3]:'aucune').' affectation'.(($agent[$j][3]>1)?'s':'').') ['.(($agent[$j][4])?'Site d\'affectation: '.$agent[$j][4]:'Aucun site d\'affectation').''.(($agent[$j][2])?' Niveau: '.$agent[$j][5]:'').']</option>';

	return $html;
	}


?>
