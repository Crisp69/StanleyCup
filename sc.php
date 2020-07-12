<?php
include("_setcookie_highlighter.php");
include("login_session.php");
if($id == "logout.php") {include("function_logout.php");parselogout($nick);}
//echo $nick.$password.$login_remember;
include("settings.php");
include("functions.php");
include("header.php");
include ("main_contents.php");
?>
<body>


<?

$include_check = "bXnqwa";
    //blokovanie botov
    $ip_ban ="block/ip_ban.php";
    $ip_check = fopen($ip_ban, "r");
    $contents_ban = fread($ip_check, filesize($ip_ban));
    $IP = $_SERVER['REMOTE_ADDR'];
    $tmp_ip = explode(".",$IP);
    $IP_blok = $tmp_ip[0].".".$tmp_ip[1].".".$tmp_ip[2].".???";
	if((stristr($contents_ban,$IP) !== false) || ($IP_blok == "94.102.59.???") || ($IP_blok == "5.63.151.???") || ($IP_blok == "128.204.195.???") || ($IP_blok == "212.235.106.???") || ($IP_blok == "173.199.119.???") || ($IP_blok == "173.199.115.???") || ($IP_blok == "66.249.78.???") || ($IP_blok == "66.249.76.???") || ($IP_blok == "93.174.94.???") || ($IP_blok == "93.174.93.???") || ($IP_blok == "212.235.107.???")){echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=ban.php\">"; $redirect="chuj";} else {  

echo "<!-- Bad robot trap: Don't go here or your IP will be banned! -->
<a href=\"/block/index.php\"><img src=\"block/pixel.gif\" border=\"0\" alt=\" \" width=\"1\" height=\"1\"/></a>\n<!-- end -->\n\n\n";

echo "<div id=\"page\">";
	echo "<div id=\"p_top\">";
	echo "<div id=\"teamlogo\">";
		parseteamlogolist();
	echo "</div>";
	echo "<div id=\"button\">
		<a href=\"sc.php?id=$default_link\"><img class=\"logo\" src=\"$logo_main\" border=\"0\" alt=\"$page_title\"></a></div>
		<div id=\"season\">
		<b>$current_season. season</b></div>
		<div id=\"winner\">";
		parsewinner();
	echo "</div>";
	// echo "<div id=\"hot\"><span class=\"hot\"><a class=\"hot\" href=\"sc.php?id=news.php&id_news=740\"> !!! Registration for the Stanley Cup (season 35)-NOW!!!!</a></span></div>"; 
	echo "<div id=\"ha\"></div>";
	echo "</div>";
	echo "<div id=\"p_bottom\">";
	echo "<div id=\"main\">
		<table align=\"center\" width=\"940px\">
		<tr>";
        $id = htmlspecialchars($id);
		if (!Isset($id) || ($id == "")) {$id = "news.php";} 
		if((($id == "news.php") && (!isset($id_news))) || (($id == "magazine.php") && (!isset($id_magazine)))) {
			echo "<td width=\"195px\" valign=\"top\" align=\"center\">";
            mainleftcolumn_news();
			echo "</td>";
			
			echo "<td class=\"tdmain\" width=\"530px\" valign=\"top\">"; 
			if($id == "news.php") {include("news.php");} elseif($id == "magazine.php") {include("magazine.php");}
			echo "</td>";
			
			echo "<td width=\"195px\" valign=\"top\" align=\"center\">";
            mainrightcolumn_news();
			echo "</td></tr>";
		}
		elseif (in_array($id, $submenu_pages)) {
            echo "<td class=\"menu_small\">";
            submenu();
            echo "</td>";
            echo "<td width=\"195px\" rowspan=\"3\" valign=\"top\" align=\"center\">";	
            mainrightcolumn();
			echo "</td></tr>";
			echo "<tr><td height=\"3px\"></td></tr><tr><td class=\"tdmain\" rowspan=\"1\" width=\"765px\" valign=\"top\">";
			$filename = $_GET['id'];
			if(Isset($filename) && ($filename !== "") && !in_array($filename, $resticted_pages)) {
				if (File_Exists ($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$filename)) {
				include $filename;}
				else {echo $err_link;}
				}
			else {echo $err_link;}
			echo "</td>";
		}
		else {
			echo "<td class=\"tdmain\" rowspan=\"1\" width=\"765px\" valign=\"top\">";
			$filename = $_GET['id'];
			if(Isset($filename) && ($filename !== "") && !in_array($filename, $resticted_pages)) {
				if (File_Exists ($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$filename)) {
				include $filename;}
				else {echo $err_link;}
				}
			else {echo $err_link;}
			echo "</td>";
            
            echo "<td width=\"195px\" valign=\"top\" align=\"center\">";	
            mainrightcolumn();
			echo "</td></tr>";
		}
	
	
		echo "</tr>
		</table>
		<br />
	</div>

	<div id=\"bottom\">
	<table align=\"center\" width=\"800px\"><tr><td align=\"center\">";
		
		echo $footer.counterDisplay().$footer2;	
		if ($counter) {
			counterAdd();
			}
			echo "</span></td></tr></table>";
    echo "</div>";
    parselogout_main($nick);
	echo "</div>";
    echo "<div id=\"menu\">";
		include ("menu.php");
	echo "</div>";
	
	
echo "</div>";}
include("tracker.php");
?>
</body>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-740523-3");
pageTracker._trackPageview();
} catch(err) {}</script>

</html>

