<script type="text/javascript">

function hide_divs(object) {
document.getElementById(object).style.display = "none";
}
function show_divs(object) {
document.getElementById(object).style.display = "block";
}
</script>


<?
function parsestrength ($hilight, $sort, $div) {
    $upload = "data/teams/teams_details.txt";
    
    echo "<span class=\"note\">(last update: ". date("d M Y h:i a", filemtime("$upload")).")</span><br /><br /><br />";
    $z = 1;
    //team_short|kapacita stadiona|brana|obrana|utok|strelba|nahravka|skusenost|forma|kapitan|asistent|asistent|IS22|age22|IS17|is22\n\n\n";
    parsedivision_select($div, $divs);
    $query = array("cap" => "Stadium Capacity", "goa" => "Goalies Strength", "def" => "Defense Strength", "off" => "Offense Strength", "sho" => "Shooting Strength", "pas" => "Passing Strength", "ai22" => "Average Ability Index of Top 22 Players", "ag22" => "Average Age of Top 22 Players", "ai17" => "Average Ability Index of Top 17 Players", "ag17" => "Average Age of Top 17 Players");
    foreach ($query as $key => $value) {if ($sort == $key) {echo "<center><b>$value</b></center><br/>";}}
    $divs[1] = $div[1];
    $divs[2] = $div[2];
    $divs[3] = $div[3];
    $divs[4] = $div[4];
    $divs[5] = $div[5];
    $divs[6] = $div[6];
    $divs_select = $div[0];
    $link2 = "&divs_select=$divs_select&divs[1]=$divs[1]&divs[2]=$divs[2]&divs[3]=$divs[3]&divs[4]=$divs[4]&divs[5]=$divs[5]&divs[6]=$divs[6]";   
    $link = "<a class=\"note1\" href=\"sc.php?id=teams_addinfo.php&sort=";
    echo "<center><span class=\"note1\"><b>sort by -></b> ";
    $query2 = array("cap" => "Stadium Capacity", "goa" => "Goalies Str", "def" => "Defense Str", "off" => "Offense Str", "sho" => "Shooting Str", "pas" => "Passing Str", "ai22" => "Avg AI Top 22 Players", "ag22" => "Avg Age Top 22 Players", "ai17" => "Avg AI Top 17 Players", "ag17" => "Avg Age Top 17 Players");
    foreach ($query2 as $key => $value) {echo $link.$key.$link2."\">".$value."</a> | ";}
    
    //print_r($div);
    $srts_g = array("cap", "goa", "def", "off", "sho", "pas", "ai22", "ag22", "ai17", "ag17", "none");
    if (!in_array($sort, $srts_g)) {$sort = "none";}

    echo "</center><br />";
    echo "<table width=\"95%\" class=\"sort-table\" align=\"center\">
    <tr>
        <th>rk</th>
        <th colspan=\"2\">team</th>
        <th align=\"center\" title=\"stadium capacity\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=cap$link2\">Stad</a></th>
        <th align=\"center\" title=\"goalie strength\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=goa$link2\">Goal</a></th>
        <th align=\"center\" title=\"defense strength\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=def$link2\">Def</a></th>
        <th align=\"center\" title=\"offense strength\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=off$link2\">Off</a></th>
        <th align=\"center\" title=\"shooting strength\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=sho$link2\">Sho</a></th>
        <th align=\"center\" title=\"passing strength\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=pas$link2\">Pass</a></th>
        <th align=\"center\" title=\"Average Ability Index of Top 22 Players\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=ai22$link2\">AI22</a></th>
        <th align=\"center\" title=\"Average Age of Top 22 Players\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=ag22$link2\">A22</a></th>
        <th align=\"center\" title=\"Average Ability Index of Top 17 Players\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=ai17$link2\">AI17</a></th>
        <th align=\"center\" title=\"Average Age of Top 17 Players\"><a class=\"trhead\" href=\"sc.php?id=teams_addinfo.php&sort=ag17$link2\">A17</a></th>
    </tr><tr>";
    if(File_exists($upload)) {
        $f = fopen($upload,"r");
    	while(!feof($f)) {
    		$tmp_base = explode("|",fgets($f,2000));
    		if (trim($tmp_base[0]) !== "") {
                if (($sort == "") || !isset($sort)) {$sort = "none";}
                $srt[none] = $tmp_base[0];
                $srt[cap] = $tmp_base[1] + 50000;
                $srt[goa] = $tmp_base[2] *10 + 5000;
                $srt[def] = $tmp_base[3] *10 + 5000;
                $srt[off] = $tmp_base[4] *10 + 5000;
                $srt[sho] = $tmp_base[5] *10 + 5000;
                $srt[pas] = $tmp_base[6] *10 + 5000;
                $srt[ai22] = $tmp_base[12] *10 + 5000;
                $srt[ag22] = $tmp_base[13] *10 + 5000;
                $srt[ai17] = $tmp_base[14] *10 + 5000;
                $srt[ag17] = $tmp_base[15] *10 + 5000;
                
                $sort_string = $srt[$sort]."!!".$tmp_base[0]."|".$tmp_base[1]."|".$tmp_base[2]."|".$tmp_base[3]."|".$tmp_base[4]."|".$tmp_base[5]."|".$tmp_base[6]."|".$tmp_base[12]."|".$tmp_base[13]."|".$tmp_base[14]."|".$tmp_base[15]."|".$tmp_base[16]."|";

                $sort_strings[] = $sort_string;
              }
        }
    }Fclose($f);
    $cap = 0; $goa = 0; $def = 0; $off = 0; $sho = 0; $pas = 0; $ai22 = 0; $ag22 = 0; $ai17 = 0; $ag17 = 0; $numb = 0;
    if($sort == "none") {sort($sort_strings);} else {arsort($sort_strings);}
    $i = 1;
    foreach ($sort_strings as $sort_string) {
        $tmp_hlp = explode ("!!", $sort_string);
        $tmp = explode ("|", $tmp_hlp[1]);
            $team_name = $tmp[0];
            if(($div[0] == "all") || ($div[0] != "select")) {
                if(trim($tmp[0]) == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                echo "<td align=\"right\">$i.</td>";
                echo "<td width=\"14px\">";parseteamnamesearch($team_name); echo "</td>";
                echo "<td ";if ($sort == "cap") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[1],0, ".", " ")."</td>";$cap = $cap + $tmp[1];
                echo "<td ";if ($sort == "goa") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[2]</td>";$goa = $goa + $tmp[2];
                echo "<td ";if ($sort == "def") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[3]</td>";$def = $def + $tmp[3];
                echo "<td ";if ($sort == "off") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[4]</td>";$off = $off + $tmp[4];
                echo "<td ";if ($sort == "sho") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[5]</td>";$sho = $sho + $tmp[5];
                echo "<td ";if ($sort == "pas") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[6]</td>";$pas = $pas + $tmp[6];
                echo "<td ";if ($sort == "ai22") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[7],1)."</td>";$ai22 = $ai22 + $tmp[7];
                echo "<td ";if ($sort == "ag22") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[8],1)."</td>";$ag22 = $ag22 + $tmp[8];
                echo "<td ";if ($sort == "ai17") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[9],1)."</td>";$ai17 = $ai17 + $tmp[9];
                echo "<td ";if ($sort == "ag17") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[10],1)."</td>";$ag17 = $ag17 + $tmp[10];
                $numb = $numb + 1;
        
                $i++; 
            }
            if(($div[0] != "all") && in_array($tmp[11], $div)){
                if(trim($tmp[0]) == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                echo "<td align=\"right\">$i.</td>";
                echo "<td width=\"14px\">";parseteamnamesearch($team_name); echo "</td>";
                echo "<td ";if ($sort == "cap") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[1],0, ".", " ")."</td>";$cap = $cap + $tmp[1];
                echo "<td ";if ($sort == "goa") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[2]</td>";$goa = $goa + $tmp[2];
                echo "<td ";if ($sort == "def") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[3]</td>";$def = $def + $tmp[3];
                echo "<td ";if ($sort == "off") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[4]</td>";$off = $off + $tmp[4];
                echo "<td ";if ($sort == "sho") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[5]</td>";$sho = $sho + $tmp[5];
                echo "<td ";if ($sort == "pas") {echo "class=\"sort\" ";} echo " align=\"right\">$tmp[6]</td>";$pas = $pas + $tmp[6];
                echo "<td ";if ($sort == "ai22") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[7],1)."</td>";$ai22 = $ai22 + $tmp[7];
                echo "<td ";if ($sort == "ag22") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[8],1)."</td>";$ag22 = $ag22 + $tmp[8];
                echo "<td ";if ($sort == "ai17") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[9],1)."</td>";$ai17 = $ai17 + $tmp[9];
                echo "<td ";if ($sort == "ag17") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format($tmp[10],1)."</td>";$ag17 = $ag17 + $tmp[10];
                $numb = $numb + 1;
                $i++; 
            }
      }
    echo "</tr>";
    if($numb != 0) {
        echo "<tr class=\"sum\"><td colspan=\"2\"></td><td align=\"left\">average</td>";
        echo "<td align=\"right\">".number_format(($cap / $numb),0, ".", " ")."</td>";             
        echo "<td align=\"right\">".number_format(($goa / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($def / $numb),1)."</td>";                
        echo "<td align=\"right\">".number_format(($off / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($sho / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($pas / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($ai22 / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($ag22 / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($ai17 / $numb),1)."</td>";
        echo "<td align=\"right\">".number_format(($ag17 / $numb),1)."</td>";
        echo "</tr>";}
    echo "</table>";
}

function parsedivision_select($div, $divs) {global $id;
    $divs[1] = $div[1];
    $divs[2] = $div[2];
    $divs[3] = $div[3];
    $divs[4] = $div[4];
    $divs[5] = $div[5];
    $divs[6] = $div[6];
    $divs_select = $div[0];
    
    //print_r($div);
    echo "<form method=\"post\" name=\"selector\" action=\"sc.php?id=$id\">";
    echo "<table align=\"center\" class=\"select\">";
    echo "<tr><td align=\"center\">";
    echo "<input type=\"radio\""; if($divs_select == "all") {echo " checked";} echo " name=\"divs_select\" value=\"all\" id=\"divs_radio_0\" onclick='javasript:hide_divs(\"choose_divs\")'><label for=\"divs_radio_0\" class=\"note\">all divisions</label>&nbsp;";
    echo "<input type=\"radio\""; if($divs_select == "select") {echo " checked";} echo " name=\"divs_select\" value=\"select\" id=\"divs_radio_1\" onclick='javasript:show_divs(\"choose_divs\")'><label for=\"divs_radio_1\" class=\"note\">select divisions</label>";
    echo "</td></tr>";
    echo "<tr><td id=\"choose_divs\" style='display:none'>";
    echo "<input type=\"checkbox\""; if($divs[1] == "atlantic") {echo " checked=\"checked\"";} echo " name=\"divs[1]\" value=\"atlantic\"><span class=\"note\">atlantic</span>";
    echo "<input type=\"checkbox\""; if($divs[2] == "northeast") {echo " checked=\"checked\"";} echo "name=\"divs[2]\" value=\"northeast\"><span class=\"note\">northeast</span>";
    echo "<input type=\"checkbox\""; if($divs[3] == "southeast") {echo " checked=\"checked\"";} echo "name=\"divs[3]\" value=\"southeast\"><span class=\"note\">southeast</span>";
    echo "<input type=\"checkbox\""; if($divs[4] == "central") {echo " checked=\"checked\"";} echo "name=\"divs[4]\" value=\"central\"><span class=\"note\">central</span>";
    echo "<input type=\"checkbox\""; if($divs[5] == "pacific") {echo " checked=\"checked\"";} echo "name=\"divs[5]\" value=\"pacific\"><span class=\"note\">pacific</span>";
    echo "<input type=\"checkbox\""; if($divs[6] == "northwest") {echo " checked=\"checked\"";} echo "name=\"divs[6]\" value=\"northwest\"><span class=\"note\">northwest</span>";
    echo "</td></tr>";
    echo "<tr><td align=\"center\"><input class=\"button\" type=\"submit\" value=\"-- SELECT --\" /></center></td></tr>";
    echo "</table>";
    echo "</form><br />";
    
}


?>

<?
if($include_check == "bXnqwa") {
    
    if(!isset($divs_select)) {$divs_select = "all";}
    $div = array($divs_select, $divs[1], $divs[2], $divs[3], $divs[4], $divs[5], $divs[6]); 
    if(implode($div) == "select") {$divs_select = "all";}
    $div = array($divs_select, $divs[1], $divs[2], $divs[3], $divs[4], $divs[5], $divs[6]);


    echo "<b>: teams strength</b><br />";
    parsestrength($hilight, $sort, $div);echo "<br /><br />";
    echo "<b>: teams captains</b><br /><br />";
    include("teams_function.php");
    parsecaptain($team = "all", $hilight, $div); echo "<br /><br />";

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
