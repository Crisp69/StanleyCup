<?php
if($include_check == "bXnqwa") {

	$IP = $_SERVER['REMOTE_ADDR'];
	$time = time();
	$date_input = date("H:i d.m.Y", $time);
	$mail = "sollu17@gmail.com";
	
	
	if ($regtype == "old") {
		$file = "data/reg/reg_old.txt";	
		if ($continue1 == "yes") {$write = StripSlashes(trim($nick) ."|" . $team_reg . "|" . $team_id . "|" . $date_input ."|".  $IP . "|" . "pending\n");
			if ((File_Exists($file)) && (Count(File($file))!==0)) {
				$fp = FOpen ($file, "r");
				$data = FRead ($fp, FileSize($file));
				FClose($fp); }
				$fp = FOpen ($file, "w");
				FWrite ($fp, $write.$data);
				FClose ($fp); 
		
		
		$message = "REGISTRATION: Nick: ". $nick."; Team: ".$team. "; IP: " . $IP;
		$header = "From: SC admin <admin@crash.sk>";
		mail($mail, "REG OLD", $message, $header);
		echo "<br />Your registration has been successfully added to the database and admin has been informed. Check your status whether your registration has been already confirmed. If your registration has not been confirmed within 24 hours, please contact <a rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&whom=Trsto\">Trsto via HA mail</a>.";
		}else {echo "There was a problem with your registration, please try again.";}
	}
elseif ($regtype == "new") {
		$file = "data/reg/reg_new.txt";	
		if ($continue3 == "yes") {$write = StripSlashes(trim($nick) ."|" . $team_reg . "|" . $team_id . "|" . $time_reg . "|" .$date_input ."|".  $IP . "|" . "pending|" . $play . "\n");
			if ((File_Exists($file)) && (Count(File($file))!==0)) {
				$fp = FOpen ($file, "r");
				$data = FRead ($fp, FileSize($file));
				FClose($fp); }
				$fp = FOpen ($file, "w");
				FWrite ($fp, $write.$data);
				FClose ($fp); 
		
		
		$message = "REGISTRATION: Nick: ". $nick."; Team: ".$team_reg. "; IP: " . $IP;
		$header = "From: SC admin <admin@crash.sk>";
		mail($mail, "REG NEW", $message, $header);
		echo "<br />you have successfully signed up for qualification, you will be contacted by HA mail if you will be invited to the qualification. You may check your status for qualification at Stanley Cup web, but final list of participants in the qualification will be available after registration of current manager is finnished.";
		}
		else {echo "There was a problem with your registration, please try again.";}
	}
    else {echo "<br />There was a problem with your registration, please try again.";}
    $IP_HIDDEN = explode (".",$IP);
    echo "<p>Your IP: $IP_HIDDEN[0].$IP_HIDDEN[1].$IP_HIDDEN[2].???<br />Your registration will be confirmed based on your IP.";
    echo "<hr>";
    echo "<br /><center>
    	<form name=\"ok\" method=\"post\" action=\"sc.php?id=reg.php\">
    	<input type=\"submit\" class=\"date\" value=\"-- OK --\" />
    	</form>
    	
    	</center>";
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
