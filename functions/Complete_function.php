<?php
/*
    Date creation : 20-08-2022
    Auteur : Cellule SOLAS - KENT
    Version:1.0
    Dernière modification : 04-10-2022
    Dernier modificateur : Cellule SOLAS - KENT
    Description: Mettre des espaces dans le fichier texte genéré 
*/

function Complete($id,$dgt)
	{
	$j=10;
	$i=10;
	for($k=1;$k<$dgt;$k++)
		$i*=$j;

	while(strlen($id)<$dgt)
		{
		$id=(($id<$i)?'0':'').$id;
		$i/=10;	
		}

	return $id;			
	}
/// la function Carractere permet de mettre des espaces en fonction de la longuer en lettre du chargeur
	function Carractere($id,$espace)
	{
	
if(strlen($id)<=3)
		$espace='                                ';
elseif(strlen($id)<=4)
	{
		$espace='                               ';	
	}
elseif(strlen($id)<=5)
	{
		$espace='                              ';	
	}
elseif(strlen($id)<=6)
	{
		$espace='                             ';	
	}
elseif(strlen($id)<=7)
	{
		$espace='                            ';	
	}
elseif(strlen($id)<=8)
	{
		$espace='                           ';	
	}
elseif(strlen($id)<=9)
	{
		$espace='                          ';	
	}
elseif(strlen($id)<=10)
	{
		$espace='                         ';	
	}
elseif(strlen($id)<=11)
	{
		$espace='                        ';	
	}
elseif(strlen($id)<=12)
	{
		$espace='                       ';	
	}
elseif(strlen($id)<=13)
	{
		$espace='                      ';	
	}
elseif(strlen($id)<=14)
	{
		$espace='                     ';	
	}
elseif(strlen($id)<=15)
	{
		$espace='                    ';	
	}
elseif(strlen($id)<=16)
	{
		$espace='                   ';	
	}
elseif(strlen($id)<=17)
	{
		$espace='                  ';	
	}
elseif(strlen($id)<=18)
	{
		$espace='                 ';	
	}
elseif(strlen($id)<=19)
	{
		$espace='                ';	
	}
elseif(strlen($id)<=20)
	{
		$espace='               ';	
	}
elseif(strlen($id)<=21)
	{
		$espace='              ';	
	}
elseif(strlen($id)<=22)
	{
		$espace='             ';	
	}
elseif(strlen($id)<=23)
	{
		$espace='            ';	
	}
elseif(strlen($id)<=24)
	{
		$espace='           ';	
	}
elseif(strlen($id)<=25)
	{
		$espace='          ';	
	}
elseif(strlen($id)<=26)
	{
		$espace='         ';	
	}
elseif(strlen($id)<=27)
	{
		$espace='        ';	
	}
elseif(strlen($id)<=28)
	{
		$espace='       ';	
	}
elseif(strlen($id)<=29)
	{
		$espace='      ';	
	}
elseif(strlen($id)<=30)
	{
		$espace='     ';	
	}
elseif(strlen($id)<=31)
	{
		$espace='    ';	
	}
elseif(strlen($id)<=32)
	{
		$espace='   ';	
	}
elseif(strlen($id)<=33)
	{
		$espace='  ';	
	}
elseif(strlen($id)<=34)
	{
		$espace=' ';	
	}
elseif(strlen($id)<=35)
	{
		$espace='';	
	}else  substr($id, 0, 35);
		return $espace;
	}


?>