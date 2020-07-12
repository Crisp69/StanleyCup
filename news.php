<?php

function parsenewscomment($id_news) {
	echo "<table width=\"70%\" align=\"center\">";
	$uu = "data/data/comments/". $id_news .".txt";
	if(file_exists($uu)) {
	$f = fopen($uu,"r");
	$z = 1;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) !== "") {
			$IP_HIDDEN = explode (".",$tmp[3]);
			echo "<tr><td><hr><span class=\"text\"><b>$tmp[1]</b></span><span class=\"note\"> | $tmp[0] | $IP_HIDDEN[0].$IP_HIDDEN[1].$IP_HIDDEN[2].???</span></td></tr><tr><td>".trim($tmp[2])."</td></tr>";


			}
		}
	}
	else {echo "<tr><td align=\"center\"><b>No comments to this news yet!</b></td></tr>";}
	echo "</table><br />";
	
}


//news na hlavnej stranke//
function parseNews($id_page, $id_news) {global $include_check;
	$upload_dir = "data/data";
	
	$news = file($upload_dir."/news.txt");
	$page = Ceil((Count($news)-5)/10+1);
	if (!IsSet($id_page)) {$id_page=1;} 
	if ($id_page > $page) {$id_page=1;}
    if ($id_page <= 0) {$id_page=1;}
    if (!is_numeric($id_page)) {$id_page=1;}
    
	if($id_news > count($news) || ($id_news <= 0) || (!is_numeric($id_news))) {unset($id_news);}
	
    if ($id_page==1) {$start = 0; $end = 4;} else {$start = $id_page*10-15;$end = $id_page*10-6;}	
	
	$f = fopen($upload_dir."/news.txt","r");
	$count = Count($news);
	
	//detail
	if (isset($id_news)) {
	$show = $count - $id_news;
	for ($i=$show;$i<=$show;$i++) {
	$tmp = explode("|",$news[$i]);
		if (trim($tmp[0]) != "") {
			echo "<table border=\"0\" width=\"99%\"><tr valign=\"middle\"><td>";
			$date = explode("/",$tmp[1]);
			if (mktime(0,0,0,$date[1],$date[0]+5,$date[2]) > (time())) {$flag = " <img alt=\"[new]\" title=\"NEW!\" src=\"img/new.gif\">";} 
				else {$flag = "";}
			if (trim($tmp[3]) !== "") {echo "<img alt=\"$tmp[3]\" title=\"$tmp[0]\" align=\"left\" class=\"imgnews\" src=\"img/news/$tmp[3]\">";}
			echo "<div class=\"headline\">".trim($tmp[0])." $flag</div>";
			echo "<div class=\"note\">".trim($tmp[1])."";
			if (trim($tmp[4]) !== "") {echo " | - <a class=\"note\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&amp;whom=$tmp[4]&amp;subject=Stanley Cup\">".trim($tmp[4])."</a> - |\n";}
			else {echo " | - <a class=\"note\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&amp;whom=$sollu&amp;subject=Stanley Cup\">sollu</a> - | ";}
		$uu = "data/data/comments/". $id_news .".txt";
		if(file_exists($uu)) {
		$count_uu = file($uu);	
		$count_uu = count($count_uu);
		echo " $count_uu comments ";
		}
		else {echo "0 comments, be the first!";}
		echo "<p></div>\n";
			
			echo "<div class=\"text\">".trim($tmp[2])."</div><p></td></tr></table><hr>";
			
		}
		
	}include("news_comment_form.php");
	parsenewscomment($id_news);
	
	$last = ($page* 10) - ($count) - 10 ; 
	$id_page = $page - Round(($count - $i + $last)/10);
	echo "<hr><a class=\"text1\" href=\"sc.php?id=news.php&amp;id_page=$id_page\"><- back to news</a>"; 
	}
	
    //zoznam
    else {
	for ($i=$start;$i<=$end;$i++) {
		$tmp = explode("|",$news[$i]);
		if (trim($tmp[0]) != "") {$id_news = $count - $i;
			$date = explode("/",$tmp[1]);
			if (mktime(0,0,0,$date[1],$date[0],$date[2]) > (time())) {echo "";} else {
			echo "\n<table border=\"0\" ><tr valign=\"center\"><td>";
			if (mktime(0,0,0,$date[1],$date[0]+5,$date[2]) > (time())) {$flag = " <img alt=\"[new]\" title=\"NEW!\" src=\"img/new.gif\">";} 
				else {$flag = "";}
			if (trim($tmp[3]) !== "") {echo "<img alt=\"$tmp[3]\" title=\"$tmp[0]\" align=\"left\" class=\"imgnews\" src=\"img/news/$tmp[3]\">";}
			echo "<div class=\"headline\"><a class=\"headline\" href=\"sc.php?id=news.php&amp;id_news=$id_news\">".trim($tmp[0])."</a> $flag</div>";
			echo "<div class=\"note\">".trim($tmp[1])."";
			if (trim($tmp[4]) !== "") {echo " | - <a class=\"note\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&amp;whom=$tmp[4]&amp;subject=Stanley Cup\">".trim($tmp[4])."</a> - | ";}
			else {echo " | - <a class=\"note\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&amp;whom=$sollu&amp;subject=Stanley Cup\">sollu</a> - | ";}
		$uu = "data/data/comments/". $id_news .".txt";
		if(file_exists($uu)) {
		$count_uu = file($uu);	
		$count_uu = count($count_uu);
		echo " $count_uu comments ";
		}
		else {echo "0 comments, be the first!";}
		echo "<p></div>\n";
			$short = explode ("<p>", trim($tmp[2]));
			echo "<div class=\"text\">".$short[0];
			if (trim($short[1]) !== "") {echo ".. <p>[<a class=\"text\" href=\"sc.php?id=news.php&amp;id_news=$id_news\">read more</a>]";}
			echo "</div></td></tr></table><hr>";
			
		}
		}
	}
	echo "\n<br /><table align=\"right\"><tr><td><span class=\"note\">select page: </span>\n";
	/*for ($x=1;$x<=$page;$x++) {if ($id_page == $x) {echo "<span class=\"whitedate\"><b>- $x -</b></span> \n";}
	else {echo "<a class=\"note\" href=\"sc.php?id=news.php&amp;id_page=$x\">$x</a> \n";}}
    */
    echo "<select class=\"list\" onchange=\"document.location.href=value;\">";
    for ($x=1;$x<=$page;$x++) {if ($id_page == $x) {echo "<option SELECTED value=\"sc.php?id=news.php&amp;id_page=$x\">$x. page</option>\n";}
	else {echo "<option value=\"sc.php?id=news.php&amp;id_page=$x\">$x. page</option>\n";}}
	
    
    
	echo "</td></tr></table><br />\n";
	}
}



?>

		


<?php
if($include_check == "bXnqwa") {
	if ((!IsSet($id_page)) || ($id_page == "")) {$id_page=1;} 
		if (($id_page == 1) && !IsSet($id_news)) {
		}
	parseNews($id_page, $id_news, $include_check);
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
?>