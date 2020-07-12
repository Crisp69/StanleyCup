<SCRIPT LANGUAGE="JavaScript"><!--
function check(formular)
{
	
	if (formular.nick_comment.value=="")
    {
        alert("Tipe your nick!");
        formular.nick_comment.focus();
        return false;
    }
    else if (formular.text_comment.value=="")
    {
        alert("Tipe Your Comment!");
        formular.text_comment.focus();
        return false;
    }
	else if (formular.antispam.value=="")
    {
        alert("Calculate Antispam!");
        formular.antispam.focus();
        return false;
    }
	else 
        return true;
}


// -->
</SCRIPT>
<script type="text/javascript" src="js/jquery.autogrow.js"></script>

<?php

function isBot() {
	$bots = array("Indy", "Blaiz", "Java", "libwww-perl", "Python", "OutfoxBot", "User-Agent", "PycURL", "AlphaServer", "T8Abot", "Syntryx", "WinHttp", "WebBandit", "nicebot");
	$isBot = false;
	
	foreach ($bots as $bot)
	if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false)
		$isBot = true;

	if (empty($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] == " ")
		$isBot = true;
	
	return $isBot;
}

if($include_check == "bXnqwa") {

	if (isBot()) {
		exit("Bots not allowed.</p>");}
		else {
				echo "
				<br />
				<table class=\"awards\" width=\"70%\" align=\"center\"><tr><td align=\"center\" colspan=\"2\"><b>ADD YOUR COMMENT</b><p></td></tr>
				<script type=\"text/javascript\"><!--
				document.write(\"<form name='comment_form' method='post' action='sc.php?id=magazine_comment_add.php' onSubmit='return check(this)'>\")//--></script>
				<tr><td align=\"right\">
				<script type=\"text/javascript\"><!--
				document.write(\"HA nick:&nbsp;</td><td><input type='text' class='list' name='nick_comment' value='$nick_comment' size='30' />\")//--></script>
				</td></tr><tr><script type=\"text/javascript\"><!--
				document.write(\"<td align='right'>text:&nbsp;</td><td><textarea type='text' class='list expand60-1000' name='text_comment' cols='47'  />$text_comment</textarea>\")//--></script><noscript><td align='center' colspan='2'><span class='mag_title_new'>You have to enable JavaScript to add comments!</span></noscript>
				</td></tr><tr><td align=\"center\" colspan=\"2\">
				<img src='img/ico/smile.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **01 ';\">
				<img src='img/ico/wink.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **02 ';\">
				<img src='img/ico/laugh.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **03 ';\">
				<img src='img/ico/lol.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **04 ';\">
				<img src='img/ico/sad.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **05 ';\">
				<img src='img/ico/spam.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **07 ';\">
				<img src='img/ico/censored.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **08 ';\">
				<img src='img/ico/hate.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **09 ';\">
				<img src='img/ico/love.gif' onClick=\"document.comment_form['text_comment'].value=document.comment_form['text_comment'].value+' **10 ';\">
				";
                
				echo "</td></tr>
				<tr><td align=\"center\" colspan=\"2\">";
				$aa = rand(1,5);
				$bb = rand(1,5);
				$cc = $aa + $bb;
				echo "<script type=\"text/javascript\"><!--
				document.write(\"count: $aa plus $bb =&nbsp;<input type='text' class='list' name='dd' size='2' />&nbsp;\")//--></script>
				<input type=\"hidden\" name=\"d\" value=\"$cc\">
				<input type=\"hidden\" name=\"id_magazine\" value=\"$id_magazine\">";
				echo "<script type=\"text/javascript\"><!--
				document.write(\"<input type='submit' class='date' value='-- SUBMIT --' />\")//--></script>
				</form>";
				echo "</td></tr><tr></tr></table>";
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
