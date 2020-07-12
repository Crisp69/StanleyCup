<?php

if($include_check == "bXnqwa") {

	


	$end_reg_formatted = date("H:i, d.m.Y", $end_reg);
	$end_qual_formatted = date("H:i, d.m.Y", $end_qual);
	
	$end_qual1 = $end_qual;
	
	if((time()<$end_qual) && (time() > $start_reg)) {$next_season = $current_season + 1;} else {$next_season = $current_season;}
	echo "<center><div class=\"headline\">Stanley Cup $next_season registration<p></div>";
	
	
	if ($end_qual < time()) {echo "<br /><div class=\"headline\">Registration is over, <a class=\"headline\" href=\"sc.php?id=qualification.php\">schedule for qualification is available here</a>, you will be informed by HA mail.<br />Please do not plan any games for upcoming weekend</div><hr>";} 
	elseif ($end_reg <time()) {echo "<br /><div class=\"headline\">Deadline for direct registration to tournament has expired, you can register for Qualification only!<p>Registration for Qualification DEADLINE: $end_qual_formatted<p></div>";
	echo "<form name=\"reg\" method=\"post\" action=\"sc.php?id=reg_form.php\">
	<input type=\"submit\" class=\"date\" value=\"-- REGISTER --\" />
	</form><hr>";
	}                                                                                                                                                                                                                                            
	else {                                                                                                                                                                                                                                       
	echo "<form name=\"reg\" method=\"post\" action=\"sc.php?id=reg_form.php\">
	<input type=\"submit\" class=\"date\" value=\"-- REGISTER --\" />
	</form>";
	echo "<br /><div class=\"headline\">Registration for the Stanley Cup $next_season - DEADLINE: $end_reg_formatted<p></div><hr>";
	}
	
	$upload_dir = "data/reg/";
	$n1 = "reg_old";
	$n2 = ".txt";
	$z = 1;
	$f2 = $n1.$n2;
	echo "<br /><b>Stanley Cup teams</b><p></center><table class=\"overview\" align=\"center\">\n";
	echo "<tr><th width=\"3%\"></th><th align=\"center\" width=\"17%\">manager</th><th align=\"center\" width=\"30%\">team</th><th align=\"center\" width=\"25%\">registered</th><th align=\"center\" width=\"25%\">status</th></tr>";
	if (file_exists("$upload_dir$f2")) {
	$x = File ($upload_dir.$f2);
	$i = Count ($x); 
	$f = fopen($upload_dir.$f2,"r");

	$c = 0;
		while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
			echo "<td align=\"center\">$i.</td><td align=\"center\">$tmp[0]</td><td align=\"center\"><a target=\"_blank\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[2]\">$tmp[1]</a></td><td align=\"center\">$tmp[3]</td><td align=\"center\">$tmp[5]</td></tr>
			
			";}$c++; $i--;
		}fclose($f);	
    } 
	echo "</table><br /><div class=\"note\"><b>STATUS:</b><br /> - pending - waiting for confirmation from <a class=\"note\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&whom=Trsto\">Trsto</a>, decision shall be taked within 24 hours since registration<br /> - confirmed - you are confirmed for Stanley Cup $next_season<br /> - rejected - your registration was cancelled by Trsto, for more details, please write a HA mail to <a class=\"note\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&whom=Trsto\">Trsto</a></div><br /><br />";	
	
	$n1 = "reg_new";
	$n2 = ".txt";
	$z = 1;
	$f2 = $n1.$n2;
	//tuto sa zacina reg rpe novych
	/*echo "<center><b>Registered for Qualification - not opened yet!</b><p></center>";*/
	if (file_exists("$upload_dir$f2")) {
	echo "<table class=\"overview\" align=\"center\">\n";
	echo "<tr><th width=\"3%\"></th><th align=\"center\" width=\"17%\">manager</th><th align=\"center\" width=\"30%\">team</th><th align=\"center\" width=\"25%\">";
	if ($end_qual < time()) {echo "aplied for";} else {
	echo "registered";}
	echo "</th><th align=\"center\" width=\"25%\">status</th></tr>";
	
	
	$x = File ($upload_dir.$f2);
	$i = Count ($x); 

	$f = fopen($upload_dir.$f2,"r");
		$c = 0;
		while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
			echo "<td align=\"center\">$i.</td><td align=\"center\">$tmp[0]</td><td align=\"center\"><a target=\"_blank\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[2]\">$tmp[1]</a></td><td align=\"center\">";
			if ($end_qual1 < time()) {echo "$tmp[7]";} else {
			echo "$tmp[4]";}
			
			echo "</td><td align=\"center\">$tmp[6]</td></tr>
			
			";}$c++; $i--;
		}fclose($f); 
	echo "</table><br /><div class=\"note\"><b>STATUS:</b><br /> - pending - all registered for qualification will remain <i>pending</i> until registration is closed unless rejected due to not meeting requirements<br /> - confirmed / qualification - will take part in the qualification or directly confirmed for Stanley Cup $next_season<br /> - rejected - not meeting tournament requirements or rejected due to too many applicants (better teams favoured)</div><br />";
	}
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}


?>