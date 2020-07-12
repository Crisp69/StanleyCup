<?
if($include_check == "bXnqwa") {
    
    $tmp_check = explode(";", $vote);
    if (($continue = "yes") && isset($nick) && isset($trophy) && ($nick != "") && ($nick != "all") && ($trophy != "") && ($tmp_check[0] != "") && ($tmp_check[1] != "")) {
    
    	//kontrola hlasovanych
    	$file_votes = "data/ballot/".$trophy."_votes.txt";
    	if(file_exists($file_votes)) {
    	$f_votes = fopen($file_votes, "r");
    	while(!feof($f_votes)) {
    		$tmp_vote = explode("|",fgets($f_votes,2000));
    		if (trim($tmp_vote[0]) != "") {
    			if (trim(strtolower($tmp_vote[1])) == strtolower($nick)) {$ok = "nope";$tmp_voted = explode(";", $tmp_vote[2]);$voted = $tmp_voted[0]." - ".$tmp_voted[2];}			
    			}
    		}fclose($f_votes);}
    		
    		if ($ok !== "nope") {
    			include ("data/magazine/pass.php");
    			$trophy = $trophy;
    			$file = "data/ballot/$trophy.txt";
    			$line = (file($file));
    			$count = count($line);
    
    			$f = fopen($file,"r");
    				for($i=0; $i<$count; $i++) {
    					$tmp = explode("|",$line[$i]);
    					if (trim($tmp[0]) != "")
    						{if ($tmp[0] == $vote) {$tmp[2] = $tmp[2] + 1;
    							if ($tmp[1] == "") {$write[$i] = StripSlashes($tmp[0] ."|".  $nick . "|" . trim($tmp[2]));}
    							else {$write[$i] = StripSlashes($tmp[0] ."|". $tmp[1] . ", " .  $nick . "|" . trim($tmp[2]));}
    							}
    						else {$write[$i] = StripSlashes($tmp[0] ."|". $tmp[1] . "|" . trim($tmp[2]));}				
    						}
    					}
    
    			echo "<center>You have voted for: $vote</center><p>";
    			if ((File_Exists($file)) && (Count(File($file))!==0)) {
    				$fp = FOpen ($file, "r");
    				$data = FRead ($fp, FileSize($file));
    				FClose($fp); }
    		
    		
    			$fp = FOpen ($file, "w");
    			for($i=0; $i<$count; $i++) {
    			FWrite ($fp, $write[$i]."\n");
    			}
    			FClose ($fp);
    				
    			$IP = $_SERVER['REMOTE_ADDR'];
    			$time = time();
    			$date = date("H:i:s d.m.Y", $time);
    			
    			$file_votes = "data/ballot/".$trophy."_votes.txt";
    			$write_votes = StripSlashes($date."|".($nick)."|".$IP."|".$vote."\n");
    			if ((File_Exists($file_votes)) && (Count(File($file_votes))!==0)) {
    				$fp_votes = FOpen ($file_votes, "r");
    				$data_votes = FRead ($fp_votes, FileSize($file_votes));
    				FClose($fp_votes); }
    		
    		
    			$fp_votes = FOpen ($file_votes, "w");
    			FWrite ($fp_votes, $write_votes.$data_votes);
    			FClose ($fp_votes);
    	
    			echo "<center>you have successfully voted for this award!<br />";
    		}
    		else {
    			echo "<center>you have voted for: $voted<br />";
    		}
    	echo "<center><form name=\"ok\" method=\"post\" action=\"sc.php?id=ballot.php\">
    	<input type=\"submit\" class=\"date\" value=\"-- CONTINUE --\" />
    	</form></center>";
    }
    else {echo "an error occured, please try <a href=\"sc.php?id=ballot.php\">again</a>";
    }

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>