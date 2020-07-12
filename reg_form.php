<?php
	//ak sa maju prihlasovat aj novi manazeri, tak v settings treba dat $no_new = "no"; 
if($include_check == "bXnqwa") {


	
	if ($end_qual < time()) {echo "<center>Registration is over!</center>";} 
    else {
    	$next_season = $current_season + 1;
    	echo "<div class=\"headline\">Stanley Cup $next_season Registration form</div> ";
    	echo "<table width=\"50%\"><tr><td><form name=\"reg_form\" method=\"post\" >
    	HA nick:</td><td>
    	<input type=\"text\" name=\"nick\" size=\"20\" ";
    	if ($nick !== "") {echo "value=\"$nick\"";}
    	echo "/></tr><td></td><td>
    	<input type=\"hidden\" name=\"continue1\" value=\"yes\">
    	<input type=\"submit\" class=\"date\" value=\"-- CONTINUE --\" />
    	</form></td></tr></table>";
    	
        if (($continue1 == "yes") && ($nick !== "")) {
        	$nick1 = strtolower(trim($nick));
        	echo "<p>";	
        	if (File_Exists("data/reg/reg_old.txt")) {
        	   $f3 = fopen("data/reg/reg_old.txt","r");
                $c = 0;
                while(!feof($f3)) {
                    $tmp = explode("|",fgets($f3,2000));
        			if (trim($tmp[0]) != "") {
        				if (strtolower(trim($tmp[0])) == $nick1 ) {$test1 = "ee";} 
                    }
    			}fclose($f3);
            }
        	if (File_Exists("data/reg/reg_new.txt")) {
                $f4 = fopen("data/reg/reg_new.txt","r");
        		$c = 0;
        		while(!feof($f4)) {
        			$tmp = explode("|",fgets($f4,2000));
        			if (trim($tmp[0]) !== "") {
        				if (strtolower(trim($tmp[0])) == $nick1 ) {$test2 = "ee";} 
        			}
       			}fclose($f4);
            }
        
            if (($test1 == "ee") || ($test2 == "ee")) {echo "You are already registered!<br /><center>
            	<form name=\"ok\" method=\"post\" action=\"sc.php?id=reg.php\">
            	<input type=\"submit\" class=\"date\" value=\"-- OK --\" />
            	</form></center>";
            }
        }
            	
        if ($end_reg > (time())) {
            if (($test1 !== "ee") && ($test2 !== "ee"))  {
                $upload_dir = "data/teams/";
                $n1 = "teams";
                $n2 = ".txt";
                $f2 = $n1.$n2;
                $f = fopen($upload_dir.$f2,"r");
                $c = 0;
                while(!feof($f)) {
                    $tmp = explode("|",fgets($f,2000));
                        if (trim($tmp[0]) !== "") {
                            if (strtolower(trim($tmp[4])) == $nick1 ) { 
                                echo "Your team: $tmp[1]<br />Team ID: <a target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[3]\">$tmp[3]</a>"; $team_reg = $tmp[1]; $team_reg_id = $tmp[3]; $nick = $tmp[4];
                                echo "<p>If details above are ok, click <i>FINISH</i> to register - this is the last step. By clicking <i>FINISH</i> you agree with <a target=\"_blank\" href=\"sc.php?id=rules.php\">tournament rules</a>";
                            } 
                        }
                }fclose($f);
            }
        } 
        else {$deadline = "over"; echo "<div class=\"headline\">Deadline for registration has expired, you can register for qualification now only!</div><p>";}
        
        if (($test1 != "ee") && ($test2 != "ee") && ($continue1 == "yes"))  {
            if (($team_reg == "") && ($no_new == "yes")) {echo "No registration opened for new managers yet, please come back later to check if there are any open positions in the tournament, thank you.";} 
            elseif (($team_reg == "") && ($no_new != "yes")) {echo "You did not play Stanley Cup this season, you can sign up for qualification only!<p>You must play HA for at least 3 seasons and have no GM  punishment for cheating / multiplaying ever, otherwise your registration will be rejected<p>"; $team_reg = "none";
    	
                if (($team_reg == "none") || ($deadline == "over")) {
                    echo "<table><tr><td><form name=\"reg_form\" method=\"post\" ><input type=\"hidden\" name=\"nick\" value=\"$nick\">
                    <input type=\"hidden\" name=\"continue\" value=\"yes\">
                    <input type=\"hidden\" name=\"continue1\" value=\"yes\">
                    <input type=\"submit\" class=\"date\" value=\"-- CONTINUE TO REGISTER --\" />
                    </form></td><td>
                    <form name=\"quit\" method=\"post\" action=\"sc.php?id=news.php\">	
                    <input type=\"submit\" class=\"date\" value=\"-- QUIT --\" />
                    </form></td></tr></table>";
    		
        			if ($continue == "yes") {
        				echo "<br /><table><tr><td><form name=\"reg_form1\" method=\"post\" >
        				your HA nick:</td><td><b>$nick</b></td></tr><tr><td>
        				<input type=\"hidden\" name=\"nick\" value=\"$nick\"></td></tr><tr><td>
        				Your team name:</td><td>
        				<input type=\"text\" name=\"team_reg_new\"";
        				if ($team_reg_new !== "") {echo "value=\"$team_reg_new\"";}
        				echo " size=\"20\" /></td></tr><tr><td>
        				Your team ID:</td><td>
        				<input type=\"text\" name=\"team_reg_id\"";
        				if ($team_reg_id !== "") {echo "value=\"$team_reg_id\"";}
        				echo " size=\"20\" /></td></tr><tr><td>
        				How long you play HA:</td><td>
        				<input type=\"text\" name=\"time_reg\"";
        				if ($time_reg !== "") {echo "value=\"$time_reg\"";}
        				echo " size=\"20\" /></td></tr>";
        				echo "<tr><td>Choose your favorite team:</td><td>
        				<select size=\"1\" name=\"play\" class=\"list\">";
        				if ($play !== "") {echo "<option value=\"$play\">$play</option>";}
        				echo "<option value=\"Dont care\">Dont care...</option>
        				<option value=\"Senators\">Senators</option>
						<option value=\"Ducks\">Ducks</option>
        				
        				</td></tr>";
        				echo "<tr><td>";
        				$aa = rand(1,5);
        				$bb = rand(1,5);
        				$cc = $aa + $bb;
        				echo "antispam: $aa + $bb = </td><td><input type=\"text\" name=\"antispam\" size=\"2\" /></td></tr><tr><td></td>";				
        				echo "<input type=\"hidden\" name=\"d\" value=\"$cc\">";	
        				echo "<input type=\"hidden\" name=\"continue3\" value=\"yes\">";	
        				echo "<td>
        					<input type=\"hidden\" name=\"continue\" value=\"yes\">
        					<input type=\"hidden\" name=\"continue1\" value=\"yes\">
        					<input type=\"submit\" class=\"date\" value=\"-- CONTINUE TO REGISTER --\" /></form></td></tr>";
            				if (($continue3 == "yes") && ($team_reg_id !== "") && ($team_reg_new !== "") && ($antispam == $d)) {
                                echo "<tr><td colspan=\"2\"><br />By clicking <i>FINISH</i> you agree with <a target=\"_blank\" href=\"sc.php?id=rules.php\">tournament rules</a> and you agree to take part in qualification!";
                                echo "<p> If you have selected any team from the list, you will play qualification in a group for this team. if you have not selected a team, you will be added to the group with lowest number of participants";
                                echo "</td></tr>
                                <tr><td></td><td><form name=\"reg_finish\" method=\"post\" action=\"sc.php?id=reg_submit.php&regtype=new\"><input type=\"hidden\" name=\"nick\" value=\"$nick\"><input type=\"hidden\" name=\"team_id\" value=\"$team_reg_id\"><input type=\"hidden\" name=\"team_reg\" value=\"$team_reg_new\"><input type=\"hidden\" name=\"time_reg\" value=\"$time_reg\">
                                <input type=\"hidden\" name=\"play\" value=\"$play\">
                                <input type=\"hidden\" name=\"continue\" value=\"yes\">
                                <input type=\"hidden\" name=\"continue1\" value=\"yes\">
                                <input type=\"hidden\" name=\"continue3\" value=\"yes\">
                                <input type=\"submit\" class=\"date\" value=\"-- FINISH --\" />
                                </form></td></tr>
                                ";
                            }
                        echo "</table>";
                        }
                    }
                }
            else {
                echo "<form name=\"reg_finish\" method=\"post\" action=\"sc.php?id=reg_submit.php&regtype=old\"><input type=\"hidden\" name=\"nick\" value=\"$nick\"><input type=\"hidden\" name=\"team_reg\" value=\"$team_reg\"><input type=\"hidden\" name=\"team_id\" value=\"$team_reg_id\">
                <input type=\"hidden\" name=\"continue1\" value=\"yes\">
                <input type=\"submit\" class=\"date\" value=\"-- FINISH --\" />
                </form>";
            }
        }
   }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>