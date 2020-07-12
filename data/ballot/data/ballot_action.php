<?php
$ballot_start = "11.01.2013.20.00";
$date = explode(".",$ballot_start);
$start = mktime($date[3],$date[4],0,$date[1],$date[0],$date[2]);
$dead_nomination = mktime("20",$date[4],0,$date[1],$date[0]+8,$date[2]);
$dead_regular = mktime("20",$date[4],0,$date[1],$date[0]+16,$date[2]);
$start_conn = mktime("19",$date[4],0,$date[1],$date[0]+25,$date[2]);
$dead_conn = mktime("20",$date[4],0,$date[1],$date[0]+27,$date[2]);


if((time()>$start) && (time()<$dead_nomination)) {$action = "1";}
elseif((time()>$dead_nomination) && (time() < $dead_regular)) {$action = "2";}	
elseif((time()>$dead_regular) && (time() < $start_conn)) {$action = "4";}
elseif((time()>$start_conn) && (time() < $dead_conn)) {$action = "3";}
elseif(time() > $dead_conn) {$action = "4";}
else {$action = "4";}


// 1 = nominacie; 2 = zakladna cast; 3 = CS; 4 = vysledky;
//$action = "1";					
$deadline_nomination = date("H:i, d.m.Y", $dead_nomination);
$deadline_regular = date("H:i, d.m.Y", $dead_regular);
$deadline_conn = date("H:i, d.m.Y", $dead_conn);
?>