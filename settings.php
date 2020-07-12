<?php
$logo_type = "jpg";

$page_title = "STANLEY CUP - HockeyArena.net Tournament";
if ($id == "") {$counter = true;}
$default_dir = "data/default";
$default_link = "news.php";
$css = "href=\"css/design_v8.css\"";
$menucss = "href=\"css/menu_css_v5.css\"";


//$new_season_time = mktime(0,0,0,12,13,2011);
//if(time() < $new_season_time) {$current_season = "28";} else {$current_season = "29";}
$current_season = "35"; //aktualna sezona


$sch_s = $current_season + 1; 
if (File_Exists("data/schedule/schedule".$sch_s.".txt")) {$schedule_season = $sch_s;} else {$schedule_season = $current_season;}

$start_reg = "31.12.2012"; //zaciatok registracie
$no_new = "no"; //povolenie registracie novych manazerov - yess = prihlasenie len existujucich man,normalna dlzka reg je +9 a kval +11
	$date_reg = explode(".", $start_reg);	
	$start_reg = mktime("1",0,0,$date_reg[1],$date_reg[0],$date_reg[2]);
	$end_reg = mktime("20",0,0,$date_reg[1],$date_reg[0]+14,$date_reg[2]);
	$end_qual = mktime("20",0,0,$date_reg[1],$date_reg[0]+16,$date_reg[2]);


$n5 = "data/schedule/playoff".$current_season.".txt";
if (File_Exists($n5)) 
{$logo_main = "img/stanleycup_logo.jpg";}
else {$logo_main = "img/stanleycup_logo.jpg";}

$footer = "<span class=\"darknote\">This is a <a class=\"darknote\" target=\"_blank\" rel=\"shadowbox;&width=1100;height=600\"  href=\"http://www.hockeyarena.net\">www.hockeyarena.net</a> tournament. visitor #";
$footer2 = " since 20.03.2008. <a class=\"darknote\" href=\"sc.php?id=data/web.html\">web navigation</a>. <a class=\"darknote\" target=\"_blank\" href=\"update/\">&copy;</a> <a target=\"_blank\" class=\"darknote\" rel=\"shadowbox;&width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_manager_info.php&id=35429\">sollu</a>. "; 


if(file_exists("restric.txt")){
    $restrict_file = fopen("restric.txt", "r");
    $resticted_pages = explode("|", fread($restrict_file, filesize("restric.txt")));
} else {$resticted_pages = array("");}

$err_link = "<center><b>requested page is lost <img src=\"img/ico/sad.gif\"><p>we will do our best to find it  <img src=\"img/ico/wink.gif\"><p><a href=\"sc.php?id=news.php\">continue</a></b></center>";



	
?>