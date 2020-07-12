<?
if($include_check == "bXnqwa") {
    
    $tmp_check = explode(";", $nominate);
    if (($continue = "yes") && isset($nick) && isset($trophy) && ($nick != "") && ($nick != "all") && ($trophy != "") && ($tmp_check[0] != "") && ($tmp_check[1] != "")) {
    	if($nick !== "admin") { 
    		$file_votes = "data/ballot/".$trophy."_nominates.txt";
    		if(file_exists($file_votes)) {
        		$f_votes = fopen($file_votes, "r");
        		while(!feof($f_votes)) {
        			$tmp_vote = explode("|",fgets($f_votes,2000));
        			if (trim($tmp_vote[0]) != "") {
        				if (trim(strtolower($tmp_vote[1])) == strtolower($nick)) {$ok = "nope";}			
        			}
        		}fclose($f_votes);
    		}
    	}
    
    	if ($ok !== "nope") {
    		
    		$trophy = $trophy;
    		$file = "data/ballot/$trophy.txt";
    		$tmp = explode(";", $nominate);
    		if ($tmp[2] == "") {
    		$def_file = "data/stats/defs".$current_season."reg.txt";
    		$f = fopen($def_file, "r");
    			while (!feof($f)) {
    				$tmp_def = explode("|", fgets($f, 2000));
    				if (trim($tmp_def[0]) != "") {
    					if ($tmp[0] == $tmp_def[2]) {$tmp[2] = "defender";} 
    				}
    			}
    		}
    		if ($tmp[2] == "") {$tmp[2] = "forward";}
    			$nominate = $tmp[0].";".$tmp[1].";".$tmp[2].";".$tmp[3];
    		echo "<center>You have nominated: $nominate</center><p>";
    		$write = StripSlashes(trim($nominate)."||\n");
    			if ((File_Exists($file)) && (Count(File($file))!==0)) {
    				$fp = FOpen ($file, "r");
    				$data = FRead ($fp, FileSize($file));
    				FClose($fp); }
    		
    		
    			$fp = FOpen ($file, "w");
    			FWrite ($fp, $write.$data);
    			FClose ($fp); 
    			
    			
    			$IP = $_SERVER['REMOTE_ADDR'];
    			$time = time();
    			$date = date("H:i:s d.m.Y", $time);
    			
    			$file_nominates = "data/ballot/".$trophy."_nominates.txt";
    					$write_nominates = StripSlashes($date."|".($nick)."|".$nominate."|".$IP."\n");
    						if ((File_Exists($file_nominates)) && (Count(File($file_nominates))!==0)) {
    							$fp_nominates = FOpen ($file_nominates, "r");
    							$data_nominates = FRead ($fp_nominates, FileSize($file_nominates));
    							FClose($fp_nominates); }
    					
    					
    							$fp_nominates = FOpen ($file_nominates, "w");
    							FWrite ($fp_nominates, $write_nominates.$data_nominates);
    							FClose ($fp_nominates);
    			
    			
    			echo "<center>Your nomination for this award was successfully added!<br />";
    	}
    	
    	else {
    		echo "<center>You have already made your nomination for this award!<br />";
    	}
    	echo "<form name=\"ok\" method=\"post\" action=\"sc.php?id=ballot.php\">
    	<input type=\"submit\" class=\"date\" value=\"-- CONTINUE --\" />
    	</form></center>";
    }
    else {echo "an error occured, please try <a href=\"sc.php?id=ballot.php\">again</a>";
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}


?>