<?php
include("settings.php");
include("functions.php");
include("header.php");
?>


<?
		$ip_ban ="ip_ban.php";
		$ip_check = fopen($ip_ban, "r");
		$contents_ban = fread($ip_check, filesize($ip_ban));
		$IP = $_SERVER['REMOTE_ADDR'];
		$tmp_ip = explode(".",$IP);
		$IP_blok = $tmp_ip[0].".".$tmp_ip[1].".".$tmp_ip[2].".???";
		if((stristr($contents_ban,$IP) !== false) || ($IP_blok == "94.102.59.???") || ($IP_blok == "212.235.106.???")){echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=ban.php\">"; $redirect="chuj";} else {  

echo "<div id=\"page\">";


	echo "<div id=\"button\">
		<a href=\"sc.php?id=$default\"><img class=\"logo\" src=\"$logo_main\" border=\"0\" alt=\"$page_title\"></a><br />
		<b>$current_season. season</b>

	
	</div>
	
	<div id=\"teamlogo\">";
		parseteamlogolist();
	echo "</div>			
	<div id=\"players\">";
		
		include("rotate_script.php");	
		
	echo "</div>		
	
	<div id=\"ha\"></div>
	<div id=\"menu\">";
		include ("menu.php");
	echo "</div>	

	<div id=\"main\">
	
	
	<table align=\"center\" width=\"850px\">
	<!--<tr>
	<td colspan=\"3\"></a><center><a class=\"mag_title_new\" href=\"sc.php?id=news.php&id_news=149\">Register for Stanley Cup 17 now!</a><p></center>
	</td></tr>-->
	<tr>
	<td rowspan=\"2\" class=\"tdmain\" width=\"650px\" valign=\"top\">";
	$filename = $_GET['id'] ;
	
	if(Isset($filename) && ($filename !== "")) {
		if (File_Exists ($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$filename)) {
		include $filename;}
		else {
		include ($default);
			}
		}
		else {include ($default);}
	
	echo "</td>	

	<td rowspan=\"2\" >&nbsp;</td>";
	include ("right_column.php");

	echo "</tr>
	</table>
	<br />
	</div>

	<div id=\"bottom\">
	<table align=\"center\" width=\"800px\"><tr><td align=\"center\">";
		
		echo $bottomCaption;
		echo $footer;
		echo "<span class=\"note\"> visitor #".counterDisplay()." since 20.03.2008. <a class=\"note\" href=\"sc.php?id=data/web.html\">web navigation</a></span>. <a class=\"note\" target=\"_blank\" href=\"admin/\">&copy;</a> <a target=\"_blank\" class=\"note\" rel=\"shadowbox;&width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_manager_info.php&id=35429\">sollu</a>. ";	
		if ($counter) {
			counterAdd();
			}
			echo "</td></tr></table>";
			
			
	echo "</div>
</div>";}
include("tracker.php");
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-740523-3");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>

