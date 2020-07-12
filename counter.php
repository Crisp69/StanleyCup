<?php

function counterAdd_mag($id_magazine) {
	$c = 0;
	$upload_dir = "data/magazine/counter/";
	$n = $upload_dir."mag_".$id_magazine.".dat";
	
	if (file_exists("$n")) {
		$f = fopen("$n","r");
		$c = fgets($f,16);
		$c++;
		fclose($f);
	}
	
	$f = fopen("$n","w");
	fputs($f,$c);
	fclose($f);
}

function counterDisplay_mag($id_magazine) {
	$upload_dir = "data/magazine/counter/";
	$n = $upload_dir."mag_".$id_magazine.".dat";
	if (file_exists("$n")) {
	$f = fopen("$n","r");
	$c = fgets($f,16);
	fclose($f);
	return $c+1;
	}
	else {return 0;}

}



?>