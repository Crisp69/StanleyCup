<?php

if($include_check == "bXnqwa") {

    	$nick1_comment = trim($nick_comment);
    	$text_comment = Str_Replace("\\\"", "\"", $text_comment);
        $text_comment = Str_Replace("\'", "'", $text_comment);
        
    	if (!IsSet($id_magazine)) {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=magazine.php\">";}
    	elseif (!IsSet($nick_comment) || !IsSet($text_comment)) {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=magazine.php&id_magazine=$id_magazine\">";}
    	 else {
    	
    	if ($dd == $d) {
    	include("data/pass/pass.php");
    	$nick1_comment = strtolower($nick1_comment);
    	if ($password_main[$nick1_comment] && $mag[$nick1_comment] == "on") {echo "<center>Your nick is password protected, tipe your password below (same as you use for magazine):<p>
    	<form name=\"pass\" method=\"post\" ><input type=\"password\" class=\"list\" name=\"password\"";
    	if ($password !== "") {echo "value=\"$password\"";}
    	echo " size=\"20\" />
    	<input type=\"hidden\" name=\"id_magazine\" value=\"$id_magazine\">
    	<input type=\"hidden\" name=\"nick_comment\" value=\"$nick_comment\"><br />
    	<textarea type='text' class='list' name='text_comment' cols='47' rows='4' />$text_comment</textarea><br />
    	<input type=\"submit\" class=\"date\" value=\"-- SUBMIT --\" /></form>
    	<p><a href=\"sc.php?id=lost_pass.php\" target=\"_blank\">lost password?</a>
    	
    	</center>"; if ($password_main[$nick1_comment] == $password) {$ok = "ok";}}
    	else {$ok = "ok";}
    	
    	
    	if ($ok == "ok") {
    		
    	$text_comment = trim($text_comment);
    	$text_comment = HTMLSpecialChars($text_comment);
    	$text_comment = Str_Replace("\n"," <br /> ", $text_comment);
    
    	$znak = 30;		//dlouha slova delit po .. znacich
    $slovo = Split("[[:blank:]]+", $text_comment);		//rozdeleni textu na slova
    	for($y=0;$y<Count($slovo);$y++):
    		$slovo[$y] = Trim($slovo[$y]);			//odstraneni mezer na konci slova
    		if (Strlen($slovo[$y])<=$znak):			//nebudeme delit
    			if (EregI("^(www\..+\..{2,3})$", $slovo[$y])):		//jedna se odkaz typu www......
    				$odkaz = EregI_Replace("^(www\..+\..{2,3})$", "<a href=http://\\1>\\1</a> ", $slovo[$y]);
    			elseif (EregI("^(http://.+\..{2,3})$", $slovo[$y]))://jedna se odkaz typu http://.......
    				$odkaz = EregI_Replace("^(http://.+\..{2,3})$", "<a href=\\1>\\1</a> ", $slovo[$y]);
    			else:
    				$odkaz = $slovo[$y] . " ";						//jedna se o normalni slovo
    			endif;
    			$celek .= $odkaz;					//spojime vsechny slova opet dohromady
    		else:
    			$delit = Ceil(StrLen($slovo[$y])/$znak);	//delime dlouhe slovo
    			for($z=0;$z<$delit;$z++):
    			$cast = Substr($slovo[$y], $z*$znak, $znak);
    			$celek .= $cast . " - ";					//na konec jednotlivych casti pridame pomlcku
    			endfor;
    		endif;
    	endfor;
    	
    	$text_comment = Str_Replace("&lt;b&gt;", "<b>", $celek);
    	$text_comment = Str_Replace("&lt;/b&gt;", "</b>", $text_comment);
    	
    	$text_comment = Str_Replace("&lt;i&gt;", "<i>", $text_comment);
    	$text_comment = Str_Replace("&lt;/i&gt;", "</i>", $text_comment);
    	
    	$text_comment = Str_Replace("&lt;u&gt;", "<u>", $text_comment);
    	$text_comment = Str_Replace("&lt;/u&gt;", "</u>", $text_comment);
    	$text_comment = Str_Replace("&lt;BR&gt; &lt;BR&gt;", "<p>", $text_comment);
    	$text_comment = Str_Replace("\'", "'", $text_comment);
    	$text_comment = Str_Replace("|", ",", $text_comment);
        
    	
    	$text_comment = Str_Replace(":)", " <img src=\"img/ico/smile.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(":-)", " <img src=\"img/ico/smile.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**01", " <img src=\"img/ico/smile.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**02", " <img src=\"img/ico/wink.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(";)", " <img src=\"img/ico/wink.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(";-)", " <img src=\"img/ico/wink.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(":D", " <img src=\"img/ico/laugh.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(":-D", " <img src=\"img/ico/laugh.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**03", " <img src=\"img/ico/laugh.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**04", " <img src=\"img/ico/lol.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(":(", " <img src=\"img/ico/sad.gif\"> ", $text_comment);
    	$text_comment = Str_Replace(":-(", " <img src=\"img/ico/sad.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**05", " <img src=\"img/ico/sad.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**07", " <img src=\"img/ico/spam.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**08", " <img src=\"img/ico/censored.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**09", " <img src=\"img/ico/hate.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("**10", " <img src=\"img/ico/love.gif\"> ", $text_comment);
    	$text_comment = Str_Replace("HA", " <img src=\"img/ico/HA.gif\"> ", $text_comment);
    	
    	$IP = $_SERVER['REMOTE_ADDR'];
    	$time = time();
    	$date_input = date("H:i:s d.m.Y", $time);
    				
    		$file = "data/magazine/comments/$id_magazine.txt";
    
    		$write = StripSlashes(trim($date_input) ."|" . $nick_comment ."|". $text_comment ."|". $IP ."\n");
    			if ((File_Exists($file)) && (Count(File($file))!==0)) {
    				$fp = FOpen ($file, "r");
    				$data = FRead ($fp, FileSize($file));
    				FClose($fp); }
    		
    				$fp = FOpen ($file, "w");
    				FWrite ($fp, $write.$data);
    				FClose ($fp); 
    				
    				echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=magazine.php&id_magazine=$id_magazine\">";
    	
        	}
    	} 
    	else {echo "<center>Calculate <b>Antispam</b> correctly!</center>"; include("magazine_comment_form.php");} 
    
    }

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>