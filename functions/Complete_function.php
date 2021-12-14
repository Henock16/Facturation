<?php


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


?>