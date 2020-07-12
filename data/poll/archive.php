<?
$path =  __FILE__;
$path = preg_replace( "'\\\archive\.php'", "", $path);
$path = preg_replace( "'/archive\.php'", "", $path);
include($path."/poll_config.php");
?>
<?
$dir = dir($path."/archivedata"); //Create a directory object to the current directory
$polls = array();
$i = 0;
while($dir_entry = $dir->read()){
	if(strstr($dir_entry,"archived")){
		$polls[$i] = $dir_entry;
		$i++;
	}
}
if($i == 0){
	echo "<b>No Archived Polls</b>";
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
	$pollfile = $path."/archivedata/".$polls[$pollid];
	
	$delete = array("archived_",".txt");
	$pollid_date = str_replace($delete, "", $polls[$pollid]);
	$data = explode("_", $pollid_date);
	$date = date("D j\<\s\u\p\>S\<\/\s\u\p\> F", $data[1]);
	$pollnumb = $data[0]+1;
	
	include($pollfile);
?>

<?
printNextPrev($pollid);
}

function printNextPrev($pollid){
	global $path;
	$nextpoll = $pollid + 1;
	$prevpoll = $pollid - 1;
	$dir = dir($path."/archivedata"); //Create a directory object to the current directory
	$polls = array();
	$i = 0;
	while($dir_entry = $dir->read()){
		if(strstr($dir_entry,"archived")){
			$polls[$i] = $dir_entry;
			$i++;
		}
	}
	if(!empty($polls[$prevpoll])) echo "<small><A HREF=\"sc.php?id=data/poll/archive.php&showpoll=$prevpoll\"><< Prev</A>&nbsp;&nbsp;</small>";
	if(!empty($polls[$nextpoll])) echo "<small><A HREF=\"sc.php?id=data/poll/archive.php&showpoll=$nextpoll\">Next >></A></small>";
}
?>

<form name="form1">
			<br>
			<textarea name="text" cols="70" rows="30">

<table class="table" border="0" cellpadding="5" cellspacing="0" width="100%">
  <tr>
    <td colspan="4" valign="top" width="99%"><span class="date"><b>Poll: <? echo "$pollnumb"; ?></b></span></td></tr>
<tr>
    <td colspan="4" valign="top" width="99%"><span class="headline"><? echo stripslashes($ask); ?></span></td>
  </tr>
  <tr>
    <td width="10%" nowrap><span class="note">Archived On</span></td>
    <td width="40%"><span class="note"><? echo $date; ?></span></td>
    <td width="10%" nowrap><span class="note">Total Votes:</span></td>
    <td width="40%"><span class="note"><? echo $total; ?></span></td>
  </tr>
  <tr>
    <td width="100%" colspan="4">
      <table class="table" border="0" cellpadding="5" cellspacing="0" width="100%">
	  <?for($i=0;$i<count($a);$i++){
			$a[$i] = stripslashes($a[$i]);
			if($a[$i] != "" && $v[$i] != ""){ 
				$percentage = (round(($v[$i] / $total) * 100, 1));
		?>
        <tr>
          <td width="1%" nowrap></td>
          <td width="1%" nowrap><b><? echo $a[$i]; ?>:</b></td>
          <td width="1%" nowrap><? echo $v[$i]; ?> vote<? if($v[$i] != 1) echo "s"; ?> (<? echo $percentage; ?>%)</td>
          <td width="97%">
            <table border="0" cellpadding="0" cellspacing="0" width="<? echo (round(($v[$i] / $total) * 80, 0)); ?>" height="<? echo $poll_bar_height; ?>">
              <tr>
                <td bgcolor="#C0C0C0"></td>
              </tr>
            </table>
          </td>
        </tr>
		<?}
		}
		?>
      </table>
    </td>
  </tr>
</table>
<br></textarea>
			<br>


