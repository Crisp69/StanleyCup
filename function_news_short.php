<?php

function parsenews_short() {
	$upload_dir = "data/data";
	if (File_Exists($upload_dir."/news.txt")) {
	$news = file($upload_dir."/news.txt");
	$count = Count($news);

	/*echo "<a class=\"mag\" href=\"sc.php?id=magazine.php\"><img title=\"Stanley Cup Magazine\" alt=\"Stanley Cup Magazine\" class=\"logo\" src=\"img/scmagazine2.jpg\"></a>";*/
	for ($i=0;$i<=2;$i++) {
		$tmp = explode("|",$news[$i]);
		if (trim($tmp[0]) != "") {$id_news = $count - $i;
			$nick = trim($tmp[2]);
			$date = explode("/",$tmp[1]);
			if (mktime(0,0,0,$date[1],$date[0]+5,$date[2]) > (time())) {echo "<div class=\"mag_title_new\"><a class=\"mag_title_new\" href=\"sc.php?id=news.php&amp;id_news=$id_news\">".trim($tmp[0])."</a> </div>";}
			else {echo "<div class=\"mag_title\"><a class=\"mag_title\" href=\"sc.php?id=news.php&amp;id_news=$id_news\">".trim($tmp[0])."</a> </div>";}
				echo "<div class=\"date\">".trim($tmp[1]);
		
			echo "<p></div>";
			
			
			
		}
		
	}
	
}
}


?>