<?php
if($include_check == "bXnqwa") {
/*
	if(IsSet($nick) && IsSet($text) && ($send == "ok")) {
	$IP = $_SERVER['REMOTE_ADDR'];
	$date_input = date("d.m.Y", $time);
	$text = Str_Replace("\t", "|", $text);
	$text = Str_Replace(",", ".", $text);
				
		$file = "data/stats/teams".$current_season.".txt";
		if ($send == "ok") {$write = StripSlashes($text);
		
				$fp = FOpen ($file, "w");
				FWrite ($fp, $write);
				FClose ($fp); 
        }
	$mail = "sollu17@gmail.com";
	$message = "Team stats updated by ".$nick. "; IP: " . $IP. "\n\n". $text ;
	$header = "From: SC admin <admin@crash.sk>";
	mail($mail, "Team stats update", $message, $header);

	echo "<hr>";
	echo "<br /><center>Stats updated successfully<p>
	<form name=\"ok\" method=\"post\" action=\"sc.php?id=teams_stats.php\">
	<input type=\"submit\" class=\"date\" value=\"-- OK --\" />
	</form>";
	
	echo "</center>";
*/
echo "teams stats update running automatically now";	
	}
	else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
	
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>