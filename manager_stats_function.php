<?php
function parseteamsearch($team) {
	
	$f = fopen("data/default/teams_list.txt", "r");
    if($team == "atl") {echo "<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=atl\">Atlanta</a>";} else {
    	while (!feof($f)) {
    		$tmp = explode("|", fgets($f, 2000));
    		if (trim($tmp[0]) != "") {
    			if ($team == trim($tmp[1])) {
    				echo "<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[1]\">" . ($tmp[0])."</a>";
    			}
    		}
    	}
    }
	if ($team == "all") {
		echo " - ALL TEAMS";
	}
}


function parsemanagerhistory($manager) {
	$upload_dir = "data/teams/";
	$n1 = "teams";
	$n2 = ".txt";
	$z = 1;
	echo "<table class=\"overview2\" align=\"center\">\n<tr><th align=\"center\" title=\"season\">s&nbsp;</th><th>team</th><th align=\"center\" title=\"Division ranking\">div</th><th align=\"center\" title=\"Conference ranking\">conf</th><th align=\"center\" title=\"Wins - Ties - Lost\">W-T-L</th><th align=\"center\">score</th><th align=\"center\" title=\"Conference Quarterfinals\">conf 1/4</th><th align=\"center\" title=\"Conference Semifinals\">conf 1/2</th><th align=\"center\" title=\"Conference Finals\">conf fin</th><th align=\"center\" title=\"Stanley Cup Finals\">SC fin</th>\n";

	$cent = "<td align=\"center\">";
	$s = 0;$w = 0; $t = 0; $l = 0; $goa = 0; $gal = 0;
	$f2 = $n1."_history".$n2;
	$f = fopen($upload_dir.$f2,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {if (($tmp[1] == "wpg") && ($tmp[0] <27)) {echo "";} else {
			if (strtolower($manager) == strtolower(trim($tmp[2]))) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
				echo "<td>&nbsp;<a class=\"note2\" href=\"sc.php?id=standings.php&amp;s=$tmp[0]\">$tmp[0].</a></td><td><img src=\"img/team_logo/small/$tmp[1].png\" width=\"21px\" alt=\"$tmp[1]\" title=\"$tmp[1]\">&nbsp;";
				$team = $tmp[1];
				parseteamsearch($team);
				$tmp_sc = explode("-",$tmp[5]);
				$tmp_sc1 = explode(":",$tmp[6]);
				echo "</td>$cent$tmp[3].</td>$cent$tmp[4].</td>$cent$tmp[5]</td>$cent$tmp[6]</td>$cent$tmp[7]</td>$cent$tmp[8]</td>$cent$tmp[9]</td>$cent$tmp[10]</td></tr>\n";$s++; $w = $w + $tmp_sc[0]; $t = $t + $tmp_sc[1];$l = $l + $tmp_sc[2]; $goa = $goa + $tmp_sc1[0]; $gal = $gal + $tmp_sc1[1];}
			}
		}
	}
	fclose($f);
	echo "</td></tr><tr class=\"sum\"><td colspan=\"10\" align=\"center\">$s seasons played: $w wins $t ties $l losses ($goa:$gal)</tr></table><br />";
}


function parseawards($manager) {global $id;
	$upload_dir = "data/awards/";
	$n1 = "awards";
	$n2 = ".txt";
	
	echo "\n<table align=\"center\"><tr><td>\n";
	$x = File ("data/default/season.txt");
	$z = 1;
    $awards_list = "data/default/awards_list.txt";
    if (file_exists($awards_list)) {
        $f3 = fopen($awards_list,"r");
        while(!feof($f3)) {
            $tmp_awards = explode("|",fgets($f3,2000));
            if (trim($tmp_awards[0]) !== "") {
                $trophy = $tmp_awards[1];
                	for ($i = Count ($x); $i > 0 ; $i--) {
                		$f2 = $n1.$i.$n2;
                		if (file_exists($upload_dir.$f2)) {
                			$f = fopen($upload_dir.$f2,"r");
                			while(!feof($f)) {
                			$tmp = explode("|",fgets($f,2000));
                                if (trim($tmp[0]) != "") {$aaa = StrTr ($tmp[3], "áäâccddéeëínnóörršttúuüýžÁÄCDÉEËÍNÓÖRŠTÚUÜÝŽ'", "aaaccddeeeinnoorrsttuuuyzAACDEEEINOORSTUUUYZ ");
                					if ($tmp[0] == $trophy) {
                                        if (strtolower(trim($manager)) == strtolower($aaa)) 
                    					{
                    					echo "<table height=\"165px\" width=\"95px\"align=\"left\"class=\"awards_small\"><tr><td align=\"center\">";
                    					echo "<a class=\"note\" href=\"sc.php?id=awards_season.php&amp;s=$i\">$i. season</a></td></tr>";
                    					echo "<tr><td height=\"25px\" align=\"center\"><span class=\"whitedate\"><b>$tmp[1]</b></span></td></tr>";
                    					echo "<tr><td height=\"25px\" align=\"center\">";
                    					if (($tmp[0] !== "stanleycup") && ($tmp[0] !== "pres") && ($tmp[0] !== "wall") && ($tmp[0] !== "cla") && ($tmp[0] !== "jack")) {echo "<a class=\"note\" href=\"sc.php?id=player_stats.php&amp;pos=points&amp;name=$name\"><b>$tmp[3]</b></a>";} else {echo "<span class=\"note\"><b>$tmp[3]</b></span>";}
                    					echo "</td></tr>";
                    					echo "<tr><td class=\"trophies3\" align=\"center\"><a href=\"sc.php?id=awards.php&amp;trophy=".trim($tmp[0])."\"><img class=\"awards_small\" alt=\"$tmp[1]\" class=\"logo\" height=\"70px\" title=\"$tmp[1]: $tmp[5]\" src=\"img/trophies/$tmp[0].jpg\"></a></td></tr><tr><td>&nbsp;</td></tr>";
                    					echo "</table>\n" ;
                    					if ($z ==6) {echo "</td></tr><tr><td>"; $z = 1;} else $z++; 
                    					}
                                    }
                				}
                			}
                		fclose($f);
                		}
                    }
                }
        }fclose($f3);
	} 
	echo "</td></tr></table><br />";
}


function parseawards_count($manager, $award) {global $id;
	$upload_dir = "data/awards/";
	$n1 = "awards";
	$n2 = ".txt";
	
	$count = 0;
	$x = File ("data/default/season.txt");
	$z = 1;
	for ($i = Count ($x); $i > 0 ; $i--) {
		$f2 = $n1.$i.$n2;
		if (file_exists($upload_dir.$f2)) {
			$f = fopen($upload_dir.$f2,"r");
			while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
				if (trim($tmp[0]) != "") {$aaa = StrTr ($tmp[3], "áäâccddéeëínnóörršttúuüýžÁÄCDÉEËÍNÓÖRŠTÚUÜÝŽ'", "aaaccddeeeinnoorrsttuuuyzAACDEEEINOORSTUUUYZ ");
					if (strtolower(trim($manager)) == strtolower($aaa)) 
					{
						if (($tmp[0] == "stanleycup") && ($award == "stanleycup")) {$count = $count + 1; }
						if (($tmp[0] == "pres") && ($award == "pres")) {$count = $count + 1;}
						if ((($tmp[0] == "wall") && ($award == "conf")) || (($tmp[0] == "cla") && ($award == "conf"))) {$count = $count + 1;}
						if (($tmp[0] == "jack") && ($award == "jack")) {$count = $count + 1;}
						
						
					}
				}
			}
		fclose($f);
		}
		
	}echo $count; 

}

function parsecount_div($manager) {
	$upload_dir = "data/data/";
	$f = fopen($upload_dir."hall.txt","r");
	$count = 0;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) !== "") {if(strtolower($tmp[1]) == strtolower($manager)) {
		$count = $count + $tmp[3];
		} 
		}
	}
	echo $count;
	fclose($f);
	
}

?>