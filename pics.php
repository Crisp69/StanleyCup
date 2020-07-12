<?php
function parseimg() {
	$upload_dir = "img/pic";
	$dir_handle = opendir($upload_dir);
	echo "<p><div class=\"text\">ice-girls</div><span class=\"note\">click the image for full size</span><p>";
	
	if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir/$file";
		if ((is_file($upload_files)) && ($file!==".htaccess") && ($file!=="Thumbs.db")) {
			$upload_name_sort[] = $file;
		}
	}
	sort($upload_name_sort);
	foreach ($upload_name_sort as $file) echo "
	<a rel=\"shadowbox[icegirls];options={displayCounter:'false',continuous:true,animSequence:'sync'};title=ice girls\" href=\"$upload_dir/$file\"><img class=\"logo\" width=\"100px\" alt=\"loading...\" title=\"SC icegirls\" src=\"$upload_dir/$file\"></a>";
	}
	closedir($dir_handle);
	echo "<br />";
}

function parseimg2() {
	$upload_dir = "img/pic3";
	$dir_handle = opendir($upload_dir);
	echo "<p><center><div class=\"text\">players pics</div><span class=\"note\">click the image for full size</span><p>";
	if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir/$file";
		if ((is_file($upload_files)) && ($file!==".htaccess") && ($file!=="Thumbs.db")) {
			$upload_name_sort[] = $file;
		}
	}
	sort($upload_name_sort);
	foreach ($upload_name_sort as $file) echo "
	<a rel=\"shadowbox[players];options={displayCounter:'false',continuous:true,animSequence:'sync'};title=players pics\" href=\"$upload_dir/$file\"><img class=\"logo\" width=\"100px\" alt=\"loading...\" title=\"SC icegirls\" src=\"$upload_dir/$file\"></a>";
	}
	closedir($dir_handle);
	echo "<br />";
}

function parseimg3() {
	$upload_dir = "img/team_logo/pics";
	$dir_handle = opendir($upload_dir);
	echo "<p><center><div class=\"text\">team pics</div><span class=\"note\">click the image for full size</span><p>";
	if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir/$file";
		if ((is_file($upload_files)) && ($file!==".htaccess") && ($file!=="Thumbs.db")) {
			$upload_name_sort[] = $file;
		}
	}
	sort($upload_name_sort);
	foreach ($upload_name_sort as $file) echo "
	<a rel=\"shadowbox[logos];options={displayCounter:'false',continuous:true,animSequence:'sync'};title=team logos\" href=\"$upload_dir/$file\"><img class=\"logo\" width=\"100px\" alt=\"loading...\" title=\"SC icegirls\" src=\"$upload_dir/$file\"></a>";
	}
	closedir($dir_handle);
	echo "<br />";
}

function parseimg4() {
	$upload_dir = "img/winners/star";
	$upload_dir_large = "img/winners";
	$dir_handle = opendir($upload_dir);
	echo "<p><center><div class=\"text\">jerseys</div><span class=\"note\">click the image for full size</span><p>";
	if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir/$file";
		if ((is_file($upload_files)) && ($file!==".htaccess") && ($file!=="Thumbs.db")) {
			$upload_name_sort[] = $file;
		}
	}
	sort($upload_name_sort);
	foreach ($upload_name_sort as $file) echo "
	<a rel=\"shadowbox[jerseys];options={displayCounter:'false',continuous:true,animSequence:'sync'};title=jerseys\" href=\"$upload_dir_large/$file\"><img class=\"logo\" width=\"100px\" alt=\"loading...\" title=\"SC icegirls\" src=\"$upload_dir/$file\"></a>";
	}
	closedir($dir_handle);
	echo "<br />";
}
?>

<?
if($include_check == "bXnqwa") {
    echo "<div class=\"text\"><b>: Stanley Cup picture gallery</b></div><p></p><center>";
    parseimg();
    parseimg2();
    parseimg3();
    parseimg4();
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
?>