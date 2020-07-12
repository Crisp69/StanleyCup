<?php
if($include_check == "bXnqwa") {
    $dir = "img/pic";
    $dh = opendir($dir);
    while (false !== ($filename = readdir($dh))) {
    if($filename == "Thumbs.db" || is_dir($filename)){
    }else{
    $files[] = $filename;
    }
    }
    closedir($dh);
    
    $nooffildi = count($files);
    $nooffiles = ($nooffildi-1);
    srand((double)microtime()*123486948);
    $randnum = rand(0,$nooffiles);
    
    echo "<a rel=\"shadowbox[icegirls];options={displayCounter:'false',continuous:true,animSequence:'sync'};title=ice girls\" href=\"$dir/$files[$randnum]\"><IMG class='logo' align='center' width='185px' SRC='$dir/$files[$randnum]' ALT='picture not loaded' title='STANLEY CUP ICE GIRLS' BORDER='0'></a>";
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>