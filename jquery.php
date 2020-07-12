<?
include("_setcookie_highlighter.php");
include("login_session.php");
if($id == "logout.php") {include("function_logout.php");parselogout($nick);}
include("settings.php");
include("functions.php");
include("header.php");
?>

<br />
<br />

<?
echo "<div id=\"jquerypage\">";
$err_link = "<center><b>requested page is lost <img src=\"img/ico/sad.gif\"><p>we will do our best to find it  <img src=\"img/ico/wink.gif\"></b></center>";
$include_check = "bXnqwa";
		$ip_ban ="block/ip_ban.php";
		$ip_check = fopen($ip_ban, "r");
		$contents_ban = fread($ip_check, filesize($ip_ban));
		$IP = $_SERVER['REMOTE_ADDR'];
		$tmp_ip = explode(".",$IP);
		$IP_blok = $tmp_ip[0].".".$tmp_ip[1].".".$tmp_ip[2].".???";
		if((stristr($contents_ban,$IP) !== false) || ($IP_blok == "94.102.59.???") || ($IP_blok == "212.235.106.???") || ($IP_blok == "93.174.94.???") || ($IP_blok == "93.174.93.???") || ($IP_blok == "212.235.107.???")){echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=ban.php\">"; $redirect="chuj";} else {  

echo "<!-- Bad robot trap: Don't go here or your IP will be banned! -->
<a href=\"/block/index.php\"><img src=\"block/pixel.gif\" border=\"0\" alt=\" \" width=\"1\" height=\"1\"/></a>\n<!-- end -->\n\n\n";

$filename = $_GET['id'] ;
	if(Isset($filename) && ($filename !== "")) {
		if (File_Exists ($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$filename)) {
		include $filename;}
        else {echo $err_link;} 
        }
    else {echo $err_link;} 
}
include("tracker.php");
echo "</div>";
?>