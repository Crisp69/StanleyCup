<?

function parsestar_short() {global $current_season;
	$upload_dir = "data/stars/";
	if (!isset($s)) {$s = $current_season;}
	$n = "star";
	$k = ".txt";
	
	if (!IsSet($s)) {$s = $current_season;}	
	$g = ($upload_dir.$n.$current_season.".txt");
	if (file_exists($g)) {$s_short = $current_season;} else {$s_short= $current_season-1;}
	
	echo "<table class=\"star\" width=\"99%\" align=\"center\">\n";
	
	$f2 = $n.$s_short.$k;
    if(File_Exists($upload_dir.$f2)) {
	$f = fopen($upload_dir.$f2,"r");
	while(!feof($f) && $c < 1) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) != "") {
			echo "<tr><td colspan=\"2\" align=\"center\"><span class=\"date\"><b>".trim($tmp[0])."</b></span></td></tr><tr><td>\n";
			echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;1st star</span>&nbsp;<img alt=\"star\" src=\"img/star.gif\"><img alt=\"star\" src=\"img/star.gif\"><img alt=\"star\" src=\"img/star.gif\"></td></tr>\n";
			echo "<tr><td valign=\"top\" rowspan=\"2\" width=\"50px\" align=\"right\"><img src=\"img/winners/star/".trim($tmp[2]).".jpg\" alt=\"picture not loaded\" width=\"50px\" title=\"1st Star: $tmp[1]\">&nbsp;</td><td><a rel=\"shadowbox;width=1100;height=600\" class=\"polltext\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&amp;id=$tmp[4]\"><b>".trim($tmp[1])."</b></a></td></tr>\n<tr><td valign=\"top\"><span class=\"polltext\">".trim($tmp[3])."<p></span></td></tr></table>\n";
			
			echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;2nd star</span>&nbsp;<img alt=\"star\" src=\"img/star.gif\"><img alt=\"star\" src=\"img/star.gif\"></td></tr>\n";
			echo "<tr><td valign=\"top\" rowspan=\"2\" width=\"50px\" align=\"right\"><img src=\"img/winners/star/".trim($tmp[6]).".jpg\" alt=\"picture not loaded\" width=\"50px\" title=\"2nd Star: $tmp[5]\">&nbsp;</td><td><a class=\"polltext\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&amp;id=$tmp[8]\"><b>".trim($tmp[5])."</b></a></td></tr>\n<tr><td valign=\"top\"><span class=\"polltext\">".trim($tmp[7])."<p></span></td></tr></table>\n";
			
			echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;3rd star</span>&nbsp;<img alt=\"star\" src=\"img/star.gif\"></td></tr>\n";
			echo "<tr><td valign=\"top\" rowspan=\"2\" width=\"50px\" align=\"right\"><img src=\"img/winners/star/".trim($tmp[10]).".jpg\" alt=\"picture not loaded\" width=\"50px\" title=\"3rd Star: $tmp[9]\">&nbsp;</td><td><a rel=\"shadowbox;width=1100;height=600\" class=\"polltext\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&amp;id=$tmp[12]\"><b>".trim($tmp[9])."</b></a></td></tr>\n<tr><td valign=\"top\"><span class=\"polltext\">".trim($tmp[11])."<p></span></td></tr></table>\n";
			

			
			$c++;
		}
	}
    }
		echo "</td></tr><tr><td colspan=\"2\" align=\"right\">";
		echo "<hr class=\"hrstar\"><a class=\"date\" href=\"sc.php?id=stars.php\"><b>more stars</b></a>&nbsp;<br /><br /></td></tr></table>\n";
}

?>
