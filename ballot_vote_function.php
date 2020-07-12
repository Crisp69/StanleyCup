<?php

function parsevote($trophy, $nick) {global $current_season, $deadline_regular, $deadline_conn;
		
	//kontrola hlasovanych
	$file_votes = "data/ballot/".$trophy."_votes.txt";
	if(file_exists($file_votes)) {
	$f_votes = fopen($file_votes, "r");
	while(!feof($f_votes)) {
		$tmp_vote = explode("|",fgets($f_votes,2000));
		if (trim($tmp_vote[0]) != "") {
			if (trim(strtolower($tmp_vote[1])) == strtolower($nick)) {$ok = "nope";$tmp_voted = explode(";", $tmp_vote[3]);$voted = $tmp_voted[0];}			
			}
		}fclose($f_votes);}
		
	
	
	//obrazok trofeje
	$f1 = "data/awards/desc/$trophy.txt";
	$file = "data/ballot/$trophy.txt";
	if(file_exists($file)) {
		if(file_exists($f1)) {
		$fx = fopen($f1,"r");
		$tmp_desc = explode("|",fgets($fx,2000));
		if (trim($tmp_desc[0]) != "") {
			if ($ok !== "nope") {
				echo "<hr><span class=\"text\">";
				if ($trophy == "jack") {echo "Please vote for one manager in following award (you are not allowed to vote for yourself):<p>";} else {echo "Please vote for one player in following award:<p>";}
				echo "</span><p><table class=\"awards\" width=\"50%\" align=\"center\"><tr><td rowspan=\"2\" align=\"center\" valign=\"top\"><br /><a target=\"_blank\" href=\"sc.php?id=awards.php&trophy=$tmp_desc[0]\"><img alt=\"$tmp_desc[1]\" height=\"100px\" title=\"$tmp_desc[1]\" class=\"awards\" src=\"img/trophies/$tmp_desc[0].jpg\"></a><p></td>";
				echo "<td valign=\"top\" height=\"20px\" align=\"center\"><div class=\"headline\">$tmp_desc[1]<p></div></td></tr>";
				echo "<tr><td valign=\"top\" width=\"60%\" align=\"center\" valign=\"top\"><div class=\"text\">$tmp_desc[2]<p></div></td></tr>";
				echo "</table><br /><center><span class=\"text\">$tmp_desc[3]</span></center><br />";}
				
			else {echo " - $tmp_desc[1] - voting done for $voted!<br />";}
			}
		fclose($fx);}
		
		//zobrazenie nominacii
	if ($ok !== "nope") {
		echo "<table class=\"overview\" align=\"center\">";
		echo "<tr>
			<th align=\"center\" width=\"5%\"></th>
			<th align=\"left\" width=\"22%\">name</th>
			<th width=\"13%\" align=\"left\">team</th>";
			if($trophy !== "jack") {
			echo "<th width=\"12%\" align=\"left\">position</th>";}
			echo "<th width=\"48%\" align=\"left\">stats</th>
			</tr>
		";$z = 1;
		echo "<form method=\"post\" name=\"$trophy\" action=\"sc.php?id=ballot_vote.php\">";
		$f = fopen($file,"r");
			while(!feof($f)) {
				$tmp_string = explode("|",fgets($f,2000));
				$string = strtolower($tmp_string[0])."|".$tmp_string[0]."|".$tmp_string[1]."|".$tmp_string[2];
				$sort[] = $string;

			}fclose($f);
				
				$z = 1; $c = 1;
				sort($sort);
				foreach ($sort as $string){
					$tmp_main = explode("|",$string);
					$tmp = explode(";",$tmp_main[1]);
					if (trim($tmp_main[0]) != "") {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						if (($nick !== "all") &&(strtolower($tmp[0]) !== strtolower($nick)))  {
							
								echo "<td><input name=\"vote\" value=\"$tmp[0];$tmp[1];$tmp[2];$tmp[3]\" type=\"radio\">&nbsp;</input></td>";} else {echo "<td></td>";}
								if($trophy == "jack") {$name = $tmp[0];} else {$name = $tmp[0];}
								if($tmp[2] == "goalie") {echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp[0]\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
								parseplayer_link($name = $name);
								echo "&amp;id_player=$tmp[4]\">" . trim($tmp[0]) . "</a></td>";} 
								elseif($tmp[2] == "manager") {echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp[0]\" target=\"_blank\" class=\"text1\" href=\"jquery.php?id=ballot_manager_stats.php&manager=$name\">" . trim($tmp[0]) . "</a></td>";} else{
								echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp[0]\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name=";
								parseplayer_link($name = $name);
								echo "&amp;id_player=$tmp[4]\">" . trim($tmp[0]) . "</a></td>";}
								echo "<td>$tmp[1]</td>";
								if($trophy !== "jack") {echo "<td>$tmp[2]</td>";}
								echo "<td>$tmp[3]</td></tr>\n";
						
					}
				}
			
			include ("data/ballot/data/pass.php");
			$nick_lower = strtolower($nick);
			$password_main = $password_main[$nick_lower];
			echo "</table><br />\n";
			if ($nick !== "all") {
			echo "<center>
			<input type=\"hidden\" name=\"trophy\" value=\"$trophy\">\n
			<input class=\"date\" value=\"-- VOTE --\" type=\"submit\" onClick=\"valbutton($trophy);return false;\">\n
			</form></center><br />";

echo "<script language=\"JavaScript\">
function valbutton(thisform) {
myOption = -1;
for (i=thisform.vote.length-1; i > -1; i--) {
if (thisform.vote[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
alert(\"You must select a player!\");
return false;
}
thisform.submit();
}
</script>";
			
			
				}
			}
		}
	
	
}


?>