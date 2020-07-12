<?php
if($include_check == "bXnqwa") {
    if(isset($nick)) {
        if($continue == "yes") {
            if(Isset($aaa)) {
                $count = count($aaa);
                $nick_lower = strtolower($nick);
                for ($i=1; $i <= $count;  $i++) {
                    
                    $tmp_sub = explode("|", $aaa[$i]);
                    $file = $tmp_sub[0]."_".$nick_lower.".txt";
                    $file2 = $tmp_sub[0].".txt";
                    $path = "data/betting/".$current_season."/";
                    if(!is_dir($path)) {mkdir($path);}
                    if(file_exists($path.$file)) {$overwritten[$i] = "yes";}
                    if($tmp_sub[0]!= "") {
                        //echo $i." - ".$tmp_sub[0]."<br>";
                        
                        $write[$i] = StripSlashes($aaa[$i]);
                        $fp = FOpen ($path.$file, "w");
                    				FWrite ($fp, $write[$i]);
                    				FClose ($fp); 
                                    
                        $write_list[$i] = StripSlashes($tmp_sub[0]."_".$nick_lower.".txt\n");
            			/*if ((!File_Exists($path.$file2)) || (Count(File($path.$file2))==0)) {
                            $write_list = $tmp_sub[0]."_all.txt\n";
            				$fp2 = FOpen ($path.$file2, "w");
                            FWrite ($fp2, $write_list);
                            FClose ($fp2); }
                        */
                        if($overwritten[$i] != "yes") {
                        if ((File_Exists($path.$file2)) && (Count(File($path.$file2))!=0)) {
            				$fp2 = FOpen ($path.$file2, "r");
            				$data2[$i] = FRead ($fp2, FileSize($path.$file2));
            				FClose($fp2); }
                        
            			$fp2 = FOpen ($path.$file2, "w");
            			FWrite ($fp2, $write_list[$i].$data2[$i]);
            			FClose ($fp2); }
                    }
                 }	echo "<br /><center>Your ticket was added successfully<p>
            	<form name=\"ok\" method=\"post\" action=\"sc.php?id=bo.php\">
            	<input type=\"submit\" class=\"date\" value=\"-- OK --\" />
            	</form>
            	
            	</center>";
            } else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=bo.php\">";}
        } else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=bo.php\">";}
    } else {echo "You have been logged out due to innactivity!<br /><br />please try again <a href=\"sc.php?id=bo.php\">here</a>";}
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>