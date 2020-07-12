<?php



function parseresult($trophy) {global $current_season;
		

	
	
	//obrazok trofeje
	$f1 = "data/awards/desc/$trophy.txt";
	$file = "data/ballot/$trophy.txt";
	if(file_exists($file)) {
		if(file_exists($f1)) {
		$fx = fopen($f1,"r");
		$tmp_desc = explode("|",fgets($fx,2000));
		if (trim($tmp_desc[0]) != "") {
				echo "<br /><table class=\"awards\" width=\"50%\" align=\"center\"><tr><td rowspan=\"2\" align=\"center\" valign=\"top\"><br /><a target=\"_blank\" href=\"sc.php?id=awards.php&trophy=$tmp_desc[0]\"><img alt=\"$tmp_desc[1]\" height=\"100px\" title=\"$tmp_desc[1]\" class=\"awards\" src=\"img/trophies/$tmp_desc[0].jpg\"></a><p></td>";
				echo "<td valign=\"top\" height=\"20px\" align=\"center\"><div class=\"headline\">$tmp_desc[1]<p></div></td></tr>";
				echo "<tr><td valign=\"top\" width=\"60%\" align=\"center\" valign=\"top\"><div class=\"text\">$tmp_desc[2]<p></div></td></tr>";
				echo "</table><br /><center>$tmp_desc[3]</center><br />";
			}
		fclose($fx);
		}
		
		//zobrazenie vysledkov
	
		echo "<table class=\"overview\" align=\"center\">";
		echo "<tr>
			<th align=\"center\" width=\"4%\"></th>
			<th align=\"left\" width=\"23%\">name</th>
			<th width=\"13%\" align=\"left\">team</th>";
			echo "<th width=\"60%\" align=\"left\">votes</th>
			</tr>
		";
		echo "<form method=\"post\" name=\"$trophy\" action=\"sc.php?id=ballot_vote.php\">";
		$f = fopen($file,"r");
			while(!feof($f)) {
				$tmp_main = explode("|",fgets($f,2000));
				if (trim($tmp_main[0]) != "") {
					$tmp = explode(";",$tmp_main[0]);
					if ($tmp_main[2] < 10) {$tmp_main[2] = "0.".$tmp_main[2];} 
					$count_votes = $tmp_main[2]."|".$tmp[0]."|".$tmp[1]."|".$tmp_main[1]."|".$tmp[2]."|".$tmp[4];
					$total_votes[] = $count_votes;

					}
				}fclose($f);
				$z = 1; $c = 1;
				arsort($total_votes);
				foreach ($total_votes as $count_votes){
					if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
					echo "<td>$c.</td>";
					$tmp_vote = explode("|",$count_votes);
					
					if($trophy == "jack") {$name = $tmp_vote[1];} else {$name = $tmp_vote[1];}
					if($tmp_vote[4] == "goalie") {echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp_vote[1]\" target=\"_blank\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name="; parseplayer_link($name = $name); echo "&amp;id_player=$tmp_vote[5]\">" . $tmp_vote[1] . "</a></td>";} elseif($tmp_vote[4] == "manager") {echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp_vote[1]\" class=\"text1\" href=\"jquery.php?id=ballot_manager_stats.php&manager=$name\">" . $tmp_vote[1] . "</a></td>";} else{
					echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp_vote[1]\" target=\"_blank\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name="; parseplayer_link($name = $name); echo "&amp;id_player=$tmp_vote[5]\">" . $tmp_vote[1] . "</a></td>";}
					echo "<td>$tmp_vote[2]</td>";
					$tmp_num = explode(".",$tmp_vote[0]);
					if(trim($tmp_num[0]) !== "0") {
					echo "<td>$tmp_num[0] votes [".trim($tmp_vote[3])."]</td></tr>\n";}
					elseif(trim($tmp_num[1]) !== "") {
					echo "<td>$tmp_num[1] votes [".trim($tmp_vote[3])."]</td></tr>\n";}
					else {echo "<td>0 votes</td>";}
				$c++;
				}
				
			
	echo "</table><hr>";
	}
}
?>