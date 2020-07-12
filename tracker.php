<?php
if($include_check == "bXnqwa") {

    $time_q = time();
    $date_input_q = date("H:i:s d.m.Y", $time_q);
    $IP = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $id_q = $_GET['id'];
    if (IsSet($redirect)) {$id_q=$id_q.$redirect;$log = $redirect;}
    if (isset($aaa)) {$pos_q=$aaa;} else {$pos_q = $pos;}
    //$hilight = $_COOKIE["SC_highlighter"];
    
    //echo $_SERVER['HTTP_USER_AGENT'] . "<br /><br />";
    //$browser1 = get_browser(null,true);
    //print_r($browser1);
    
    if (($id_q == "news.php") && (isset($id_page))) {$log = "&id_page=$id_page";}
    if (($id_q == "news.php") && (isset($id_news))) {$log = "&id_news=$id_news";}
    if (($id_q == "teams.php") && (isset($team))) {$log = "&team=$team&detail=$detail";}
    if (($id_q == "teams_compare.php")) {$log = "&team1=$team1&team2=$team2";}
    if (($id_q == "schedule.php")) {$log = "&s=$s&type=$type&team=$team";}
    if (($id_q == "standings.php")) {$log = "&s=$s";}
    if (($id_q == "stars.php")) {$log = "&s=$s";}
    if (($id_q == "stats.php")) {$log = "&s=$s&pos=$aaa&type=$bbb&team=$team&sort=$sort&page=$page&active=$active";}
    if (($id_q == "awards_season.php")) {if (isset($s)) {$log = "&s=$s";}}
    if (($id_q == "awards.php")) {$log = "&trophy=$trophy";}
    if (($id_q == "magazine.php") && (isset($id_page))) {$log = "&id_page=$id_page";}
    if (($id_q == "magazine.php") && (isset($id_magazine))) {$log = "&id_magazine=$id_magazine";}
    if (($id_q == "player_stats.php")) {$log = "&pos=$pos&name=$name&id_player=$id_player&s=$s";}
    if (($id_q == "player_stats_old.php")) {$log = "&pos=$pos&name=$name";}
    if (($id_q == "magazine_comment_add.php")) {$log = "&id_magazine=$id_magazine";}
    if (($id_q == "manager_stats.php")) {$log = "&manager=$manager";}
    if (($id_q == "news_comment_add.php")) {$log = "&id_news=$id_news";}
    if (($id_q == "ballot_vote.php")) {$log2 = "$vote;$nick"; $log = "&trophy=$trophy";}
    if (($id_q == "ballot_nominate.php")) {$log2 = "$nominate;$nick"; $log = "&trophy=$trophy";}
    if (($id_q == "teams_stats.php")) {$log = "&s=$s&sort1=$sort1&sort2=$sort2";}
    if (($id_q == "teams_addinfo.php")) {$log = "&sort=$sort&divs_select=$divs_select&divs[1]=$divs[1]&divs[2]=$divs[2]&divs[3]=$divs[3]&divs[4]=$divs[4]&divs[5]=$divs[5]&divs[6]=$divs[6]";}
    if (($id_q == "bo_tickets.php")) {$log = "&manager=$manager&date=$date&game=$game";}
	if (($id_q == "bo.php")) {$log = "&s=$s";}
    if (($id_q == "stats_income.php")) {$log = "&s=$s&sort=$sort&sort2=$sort2";}
    
    
    $log_i = $date_input_q."|".$IP."|".$id_q."|".$log."|".$log2."|".$browser."|".$hilight." - ".$nick."\n";
    $file_log = "data/_log/log.txt";
    $write_log = $log_i;
    if (($IP !== "127.0.0.1") && ($IP !== "188.167.89.135") && ($IP !== "212.5.222.197") && ($IP !== "212.5.222.203") && ($IP !== "66.249.65.99")) {
    $size = Count(File($file_log));
    if ($size > 200) {
    	$arch_time = time();
    	$arch_time = date("Ymd_His", $arch_time);
    	$file_log_arch = "data/_log/".$arch_time."_log.txt";
    				$fp_log = FOpen ($file_log, "r");
    				$data_log_arch = FRead ($fp_log, FileSize($file_log));
    				FClose($fp_log); 
    				$fp_log_arch = FOpen ($file_log_arch, "w");
    				FWrite ($fp_log_arch, $data_log_arch);
    				FClose ($fp_log_arch);
    				unlink($file_log);
    }
    			if ((File_Exists($file_log)) && (Count(File($file_log))!==0)) {
    				$fp_log = FOpen ($file_log, "r");
    				$data_log = FRead ($fp_log, FileSize($file_log));
    				FClose($fp_log); }
    				$fp_log = FOpen ($file_log, "w");
    				FWrite ($fp_log, $write_log.$data_log);
    				FClose ($fp_log); 
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>