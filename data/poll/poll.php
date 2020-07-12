<?
$path =  __FILE__;
$path = preg_replace( "'\\\poll\.php'", "", $path);
$path = preg_replace( "'/poll\.php'", "", $path);
include($path."/poll_config.php");


$dir = dir($path."/polldata"); //Create a directory object to the current directory
$polls = array();
$ids = array();
$delete = array("poll_",".txt");
$i = 0;
while($dir_entry = $dir->read()){
	if(strstr($dir_entry,"poll")){
		$polls[$i] = $dir_entry;
		$ida = str_replace($delete, "", $dir_entry);
		$ids[$i] = $ida;
		$i++;
	}
}

if($i == 0){
	echo "<br /><span class=\"date\"><b>".$nopoll."</b></span>";
}
else{
	if($random_display){
		srand((double)microtime()*1000000); 
		$pollid = rand(0,count($polls)-1);
	}
	else{		
		if(isset($_GET['showpoll'])){
			$pollid = $_GET['showpoll'];
			if(empty($polls[$pollid])) $pollid = 0;
		}
		else{
			if(!isset($_POST['pollid'])) $pollid = 0;
			else $pollid = intval($_POST['pollid']);
		}
	}	
	$pollfile = $path."/polldata/".$polls[$pollid];
	$ipfile = $path."/polldata/ips_".$ids[$pollid].".php";
	include($pollfile);

	if(isset($_POST['vote'])){
		include("submit_vote.php");
		submitVote($_POST['vote']);
	}
	else{  // check that they have voted or not
		$ip = fopen($ipfile, "r");
		$contents = fread($ip, filesize($ipfile));
		$uip = $_SERVER['REMOTE_ADDR'];
		// start html code returning results.....................................
	
		if(stristr($contents,$uip) !== false){  
		   $ask = stripslashes($ask);
		   echo "<div class=\"polltext\">$ask</div><p>";
		   if(isset($_GET['voted'])) echo "<span class=\"date\"><b>Thank you for your vote</b></span>";
		   else echo "<span class=\"date\"><b>$voted_already</b></span>";
		   echo "<br /><span class=\"date\">so far: $total ";
			if($total == "1") echo "Vote<br /></span>";
			else echo "Votes<br /></span>";
			echo "<table width=\"95%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
			for($i=0;$i<count($a);$i++){
				$a[$i] = stripslashes($a[$i]);
				if($a[$i] != "" && $v[$i] != ""){ 
					$percentage = (round(($v[$i] / $total) * 100, 1));
			
				   	echo "<tr class=\"up\">\n";
					echo "<td>\n";
					echo "<span class=\"date\"><b>$a[$i]</b></span><br />";
					echo "<img alt=\"$a[$i] - $v[$i] votes ($percentage%)\" title=\"$a[$i] - $v[$i] votes ($percentage%)\" src=\"$imgurl\" height=\"".$poll_bar_height."\" width=";
					echo (round(($v[$i] / $total) * 80, 0)); 
					echo ">";
					echo "<span class=\"date\">&nbsp;".$percentage."% ($v[$i])</span><br />";
					echo "</td>\n";
					echo "</tr>\n";					
				}
			}
			echo "</table>"; 
			if(!$random_display) printNextPoll($pollid);
			echo "<br />&nbsp;<a class=\"date\" HREF=\"sc.php?id=data/pollarchive.html\"><b>$view_archive<b></a>";
		}
		else{
			$ask = stripslashes($ask);
			echo "<div class=\"polltext\">$ask</div><p>\n\n";
			echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."\">\n\n";
			echo "<table width=\"95%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
			for($i = 0;$i< count($a);$i++){
				$a[$i] = stripslashes($a[$i]);
				if($a[$i] != ""){
					echo "  <tr class=\"up\">\n";
					echo "    <td valign=\"top\" width=\"1%\">\n";
					echo "      <span class=\"note\"><input type=\"radio\" name=\"vote\" value=\"$a[$i]\">\n</span>";
					echo "    </td>\n";
					echo "    <td>";
					echo "<span class=\"date\"><b>$a[$i]</b></span>";
					echo "</td>\n";
					echo "  </tr>\n";
				}
			}
			echo "</table>\n\n";
			echo "<p><input type=\"hidden\" name=\"pollid\" value=\"$pollid\">\n";
			echo "<input type=\"hidden\" name=\"pollpid\" value=\"$ids[$pollid]\">\n";
			echo "<input type=\"submit\" class=\"date\" value=\"$vote_button_text\">\n";
			echo "</form>\n\n<br />";
			if(!$random_display) printNextPoll($pollid);
			echo "<hr class=\"hrstar\">&nbsp;<a class=\"date\" HREF=\"sc.php?id=data/pollarchive.html\"><b>$view_archive<b></a>";
		}
	}
}
	// Please, please, please keep this line intact to spread the word about the FREE CJ Dynamic Poll - Thank you : )


function printNextPoll($pollid){
	global $path;
	$nextpoll = $pollid + 1;
	$prevpoll = $pollid - 1;
	$dir = dir($path."/polldata"); //Create a directory object to the current directory
	$polls = array();
	$i = 0;
	while($dir_entry = $dir->read()){
		if(strstr($dir_entry,"poll")){
			$polls[$i] = $dir_entry;
			$i++;
		}
	}
	if(!empty($polls[$prevpoll])) echo "<span=\"note\"><A HREF=\"".$_SERVER['PHP_SELF']."?showpoll=$prevpoll\"><< Prev</A>&nbsp;&nbsp;</span>";
	if(!empty($polls[$nextpoll])) echo "<span=\"note\"><A HREF=\"".$_SERVER['PHP_SELF']."?showpoll=$nextpoll\">Next >></A></span>";
}
?>