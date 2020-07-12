<?php
function parsemagazinecomment($id_magazine) {
	echo "<table width=\"70%\" align=\"center\">";
	$uu = "data/magazine/comments/". $id_magazine .".txt";
	if(file_exists($uu)) {
	$f = fopen($uu,"r");
	$z = 1;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) != "") {
			$IP_HIDDEN = explode (".",$tmp[3]);
			echo "<tr><td><hr><span class=\"text\"><b>$tmp[1]</b> | </span><span class=\"note\">$tmp[0] | $IP_HIDDEN[0].$IP_HIDDEN[1].$IP_HIDDEN[2].???</span></td></tr><tr><td>".trim($tmp[2])."</td></tr>";


			}
		}
	}
	else {echo "<tr><td align=\"center\"><b>No comments to this article yet!</b></td></tr>";}
	echo "</table><br />";
	
}
function parsemagazinecommentcount($id_magazine) {
	$uu = "data/magazine/comments/". $id_magazine .".txt";
	if(file_exists($uu)) {
		$count_uu = file($uu);	
		$count_uu = count($count_uu);
		echo " $count_uu comments ";
		}
}


function parsemagazine($id_page, $id_magazine) {global $include_check;
	
	$upload_dir = "data/magazine";
	if (File_Exists($upload_dir."/magazine.txt")) {
	$magazine = file($upload_dir."/magazine.txt");
	$page = Ceil((Count($magazine)-10)/10+1);
	if (!IsSet($id_page)) {$id_page=1;} 
	if ($id_page > $page) {$id_page=1;}
    if ($id_page <= 0) {$id_page=1;}
    if (!is_numeric($id_page)) {$id_page=1;}
	
	if ($id_page==1) {$start = 0; $end = 9;} else {$start = $id_page*10-10;$end = $id_page*10-1;}	
	
	include("counter.php");
	include("data/pass/pass.php");
	$count = Count($magazine);
	if($id_magazine > count($magazine) || ($id_magazine <= 0) || (!is_numeric($id_magazine))) {unset($id_magazine);}
	//clanok
	if (isset($id_magazine)) {
        $article_file = "data/magazine/".$id_magazine.".txt"; 
    	if(file_exists($article_file)) {
    	   $f = fopen($article_file,"r");
           while(!feof($f)) {
        		$tmp = explode("|",fgets($f,10000));
        		if (trim($tmp[0]) !== "") {
        			counterAdd_mag($id_magazine);
        			$date = explode(".",$tmp[1]);
        			$title = Str_Replace("\\", "", $tmp[0]);
        			echo "<p><center><a class=\"mag_title_new\" href=\"sc.php?id=magazine_form.php\"><b>--> Write your own articles here! <--</b></a></center><hr>";
        			echo "<div class=\"headline\">".trim($title)."</div>";
        			echo "<div class=\"note\"><table border=\"0\" width=\"99%\"><tr valign=\"center\"><td colspan=\"2\"><span class=\"note1\">".trim($tmp[1])."";
        			$nick = strtolower(trim($tmp[2]));
        			if (trim($tmp[2]) !== "") {echo " | <a class=\"note1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&whom=$tmp[2]&subject=Stanley Cup\">$tmp[2]</a> | ".counterDisplay_mag($id_magazine)." views | ";
        		$uu = "data/magazine/comments/". $id_magazine .".txt";
        		if(file_exists($uu)) {
        		$count_uu = file($uu);	
        		$count_uu = count($count_uu);
        		echo " $count_uu comments ";
        		}
        		else {echo "0 comments, be the first!";} echo "<br />";
        			if ($team_short[$nick] !=="") { 
        			echo "</span></td><td></td><td align=\"right\"><span class=\"note1\">From <a class=\"note1\" href=\"sc.php?id=teams.php&team=$team_short[$nick]\">$team_full[$nick]</a></td><td width=\"20px\"><img alt=\"$team_short[$nick]\" title=\"$team_full[$nick]\" src=\"img/team_logo/small/$team_short[$nick].png\"></span>";}
                    echo "</td></tr></table><p></div>\n";}
        			echo "<table width=\"95%\"><tr><td>";
        			$text = Str_Replace("\\", "", $tmp[4]);
        			echo "<div class=\"text\">".trim($tmp[3]).$text."</div><p>";
        			echo "</td></tr></table><hr>"; 
       			}
		}
		
	
    	include("magazine_comment_form.php");
    	parsemagazinecomment($id_magazine);
    	
    	$last = ($page* 10) - ($count) - 10 ; 
    	$id_page = $page - ceil(($count - $i + $last +1)/10);
    	echo "<hr><a class=\"text1\" href=\"sc.php?id=magazine.php&id_page=$id_page\"><- back to magazine</a>"; 
	   }
    }
    
    //zoznam
	else {
	echo "<b>: Stanley Cup Magazine</b>";
	echo "<p><center><a class=\"mag_title_new\" href=\"sc.php?id=magazine_form.php\"><b>--> Write your own articles here! <--</b></a></center><hr>";
	for ($i=$start;$i<=$end;$i++) {
	   	$tmp = explode("|",$magazine[$i]);
		if (trim($tmp[0]) !== "") {$id_magazine = $count - $i;}
    	    $article_file = "data/magazine/".$id_magazine.".txt"; 
    	    if(file_exists($article_file)) {
    	        $f = fopen($article_file,"r");
                 	while(!feof($f)) {
                		$tmp = explode("|",fgets($f,10000));
                		if (trim($tmp[0]) != "") {
                                $date = explode(".",$tmp[1]);
                    			if (mktime(0,0,0,$date[1],$date[0]+3,$date[2]) > (time())) {$flag = " <img alt\"[new]\" title=\"NEW!\" src=\"img/new.gif\">";} 
                    			else {$flag = "";}
                    			$title = Str_Replace("\\", "", $tmp[0]);
                    			echo "<div class=\"headline\"><a class=\"headline\" href=\"sc.php?id=magazine.php&id_magazine=$id_magazine\">".$title."</a> $flag</div>";
                    			echo "<div class=\"note\"><table border=\"0\" width=\"99%\"><tr valign=\"center\"><td colspan=\"2\"><span class=\"note1\">".trim($tmp[1])."";
                    			$nick = strtolower(trim($tmp[2]));
                    			if (trim($tmp[2]) !== "") {echo " | <a class=\"note1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&whom=$tmp[2]&subject=Stanley Cup\">$tmp[2]</a> | ".counterDisplay_mag($id_magazine)."  views <br />";
                                if ($team_short[$nick] !=="") {
                    			echo "</span></td><td></td><td align=\"right\"><span class=\"note1\">From  <a class=\"note1\" href=\"sc.php?id=teams.php&team=$team_short[$nick]\">$team_full[$nick]</a>&nbsp;</td><td width=\"20px\"><img alt=\"$team_short[$nick]\" title=\"$team_full[$nick]\" src=\"img/team_logo/small/$team_short[$nick].png\">";}
                                echo "</td></tr></table></div>\n";}
                    			$text = Str_Replace("\\", "", $tmp[4]);
                    			$short = explode(" <br /> ",$text);
                    			echo "<div class=\"text\">$short[0]"; 
                                if (strstr($short[0],"<b>") && !strstr($short[0],"</b>")) {echo "</b>";}
                                if (strstr($short[0],"<i>") && !strstr($short[0],"</i>")) {echo "</i>";}
                                if (strstr($short[0],"<u>") && !strstr($short[0],"</u>")) {echo "</u>";}
                                echo "<p>[<a class=\"text1\" href=\"sc.php?id=magazine.php&id_magazine=$id_magazine\">read more</a> | ";
                    		$uu = "data/magazine/comments/". $id_magazine .".txt";
                    		if(file_exists($uu)) {
                    		$count_uu = file($uu);	
                    		$count_uu = count($count_uu);
                    		echo " $count_uu comments ";    		  
              		        }
                            else {echo "0 comments, be the first!";}
		                  	echo "]</div><br />";
			                echo "<p>";
		
                    }
                }fclose($f);
	       }
			
	}
			
	echo "<hr>";echo "\n<br /><br />";
	if ($page > 1) {
	echo "<table align=\"right\"><tr><td><span class=\"note\">-> page: </span>\n";
	for ($x=1;$x<=$page;$x++) {if ($id_page == $x) {echo "<span class=\"whitedate\"><b>- $x -</b></span> \n";}
	else {echo "<a class=\"note\" href=\"sc.php?id=magazine.php&id_page=$x\">$x</a> \n";}}
	echo "</td></tr></table>\n";
	}	
}
	
}	
	
}


?>

		


<?php

if($include_check == "bXnqwa") {

	if (!IsSet($id_page)) {$id_page=1;} 
		parsemagazine($id_page, $id_magazine, $include_check);
		
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
		
?>