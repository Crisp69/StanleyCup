<?
if($include_check == "bXnqwa") {
    
    $playoff_file = "data/schedule/playoff".$s.".txt";
    if (file_exists($playoff_file)) {
    //include ("data/schedule/playoff".$s."_tree.txt");
    
    	$c=1;$d=1;$e=1;$g=1;
    	$f = fopen($playoff_file,"r");
    	while(!feof($f)) {
    		$tmp = explode("|",fgets($f,2000));
    		if (trim($tmp[0]) != "") {
    			if ($tmp[0] == "Conference Quarterfinals") {$cqf = 1;
    				if($c == 1) {$eq1[team]=$tmp[8]; $eq1[id]=$tmp[3]; $eq8[team]=$tmp[9]; $eq8[id]=$tmp[4]; $eq1[1]=$tmp[10]; $eq8[1]=$tmp[11];}
    				if($c == 9) {$eq1[2]=$tmp[11]; $eq8[2]=$tmp[10];}
    				if($c == 2) {$eq2[team]=$tmp[8]; $eq2[id]=$tmp[3]; $eq7[team]=$tmp[9]; $eq7[id]=$tmp[4]; $eq2[1]=$tmp[10]; $eq7[1]=$tmp[11];}
    				if($c == 10) {$eq2[2]=$tmp[11]; $eq7[2]=$tmp[10];}
    				if($c == 3) {$eq3[team]=$tmp[8]; $eq3[id]=$tmp[3]; $eq6[team]=$tmp[9]; $eq6[id]=$tmp[4]; $eq3[1]=$tmp[10]; $eq6[1]=$tmp[11];}
    				if($c == 11) {$eq3[2]=$tmp[11]; $eq6[2]=$tmp[10];}
    				if($c == 4) {$eq4[team]=$tmp[8]; $eq4[id]=$tmp[3]; $eq5[team]=$tmp[9]; $eq5[id]=$tmp[4]; $eq4[1]=$tmp[10]; $eq5[1]=$tmp[11];}
    				if($c == 12) {$eq4[2]=$tmp[11]; $eq5[2]=$tmp[10];}
    				
    				if($c == 5) {$wq1[team]=$tmp[8]; $wq1[id]=$tmp[3]; $wq8[team]=$tmp[9]; $wq8[id]=$tmp[4]; $wq1[1]=$tmp[10]; $wq8[1]=$tmp[11];}
    				if($c == 13) {$wq1[2]=$tmp[11]; $wq8[2]=$tmp[10];}
    				if($c == 6) {$wq2[team]=$tmp[8]; $wq2[id]=$tmp[3]; $wq7[team]=$tmp[9]; $wq7[id]=$tmp[4]; $wq2[1]=$tmp[10]; $wq7[1]=$tmp[11];}
    				if($c == 14) {$wq2[2]=$tmp[11]; $wq7[2]=$tmp[10];}
    				if($c == 7) {$wq3[team]=$tmp[8]; $wq3[id]=$tmp[3]; $wq6[team]=$tmp[9]; $wq6[id]=$tmp[4]; $wq3[1]=$tmp[10]; $wq6[1]=$tmp[11];}
    				if($c == 15) {$wq3[2]=$tmp[11]; $wq6[2]=$tmp[10];}
    				if($c == 8) {$wq4[team]=$tmp[8]; $wq4[id]=$tmp[3]; $wq5[team]=$tmp[9]; $wq5[id]=$tmp[4]; $wq4[1]=$tmp[10]; $wq5[1]=$tmp[11];}
    				if($c == 16) {$wq4[2]=$tmp[11]; $wq5[2]=$tmp[10];}
    				$c++;
    			}
    			if ($tmp[0] == "Conference Semifinals") {$csf = 1;
    				if($d == 1) {$es1[team]=$tmp[8]; $es1[id]=$tmp[3]; $es4[team]=$tmp[9]; $es4[id]=$tmp[4]; $es1[1]=$tmp[10]; $es4[1]=$tmp[11];}
    				if($d == 5) {$es1[2]=$tmp[11]; $es4[2]=$tmp[10];}
    				if($d == 2) {$es2[team]=$tmp[8]; $es2[id]=$tmp[3]; $es3[team]=$tmp[9]; $es3[id]=$tmp[4]; $es2[1]=$tmp[10]; $es3[1]=$tmp[11];}
    				if($d == 6) {$es2[2]=$tmp[11]; $es3[2]=$tmp[10];}
    				
    				if($d == 3) {$ws1[team]=$tmp[8]; $ws1[id]=$tmp[3]; $ws4[team]=$tmp[9]; $ws4[id]=$tmp[4]; $ws1[1]=$tmp[10]; $ws4[1]=$tmp[11];}
    				if($d == 7) {$ws1[2]=$tmp[11]; $ws4[2]=$tmp[10];}
    				if($d == 4) {$ws2[team]=$tmp[8]; $ws2[id]=$tmp[3]; $ws3[team]=$tmp[9]; $ws3[id]=$tmp[4]; $ws2[1]=$tmp[10]; $ws3[1]=$tmp[11];}
    				if($d == 8) {$ws2[2]=$tmp[11]; $ws3[2]=$tmp[10];}
    				$d++;
    			}
    			if ($tmp[0] == "Conference Finals") {$cf = 1;
    				if($e == 1) {$ef1[team]=$tmp[8]; $ef1[id]=$tmp[3]; $ef2[team]=$tmp[9]; $ef2[id]=$tmp[4]; $ef1[1]=$tmp[10]; $ef2[1]=$tmp[11];}
    				if($e == 3) {$ef1[2]=$tmp[11]; $ef2[2]=$tmp[10];}
    				
    				if($e == 2) {$wf1[team]=$tmp[8]; $wf1[id]=$tmp[3]; $wf2[team]=$tmp[9]; $wf2[id]=$tmp[4]; $wf1[1]=$tmp[10]; $wf2[1]=$tmp[11];}
    				if($e == 4) {$wf1[2]=$tmp[11]; $wf2[2]=$tmp[10];}
    				$e++;
    			}
    			if ($tmp[0] == "Stanley Cup Finals") {$scf = 1;
    				if($g == 1) {$sc1[team]=$tmp[8]; $sc1[id]=$tmp[3]; $sc2[team]=$tmp[9]; $sc2[id]=$tmp[4]; $sc1[1]=$tmp[10]; $sc2[1]=$tmp[11];}
    				if($g == 2) {$sc1[2]=$tmp[11]; $sc2[2]=$tmp[10];}
    				$g++;
    			}
    			if ($cqf !== 1) {$eq1[team]="q";$eq2[team]="q";$eq3[team]="q";$eq4[team]="q";$eq5[team]="q";$eq6[team]="q";$eq7[team]="q";$eq8[team]="q";$wq1[team]="q";$wq2[team]="q";$wq3[team]="q";$wq4[team]="q";$wq5[team]="q";$wq6[team]="q";$wq7[team]="q";$wq8[team]="q";}
    			if ($csf !== 1) {$es1[team]="q";$es2[team]="q";$es3[team]="q";$es4[team]="q";$ws1[team]="q";$ws2[team]="q";$ws3[team]="q";$ws4[team]="q";}
    			if ($cf !== 1) {$ef1[team]="q";$ef2[team]="q";$wf1[team]="q";$wf2[team]="q";}
    			if ($scf !== 1) {$sc1[team]="q";$sc2[team]="q";}			
    		} 
    	}
    
    
    
    
    echo "
    <table align=\"center\" width=\"97%\" >
    <tr>
    	<td colspan=\"6\" align=\"center\" valign=\"middle\"><img width=\"55%\" alt=\"conf\" title=\"Eastern\" src=\"img/eastern.png\"><p></td>
    	<td colspan=\"8\" rowspan=\"4\" align=\"center\" valign=\"top\"><img width=\"75%\" alt=\"SC playoff tree\" title=\"$s. season\" src=\"img/sc_po_tree.jpg\"><br />$s. season</td>
    	<td colspan=\"6\" align=\"center\" valign=\"middle\"><img width=\"55%\" alt=\"conf\" title=\"Western\" src=\"img/western.png\"><p></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq1[team]\" src=\"img/team_logo/large/$eq1[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq1[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq1[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq1[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq1[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq1[team]\" src=\"img/team_logo/large/$wq1[team].gif\"></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq8[team]\" src=\"img/team_logo/large/$eq8[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq8[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq8[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq8[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq8[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq8[team]\" src=\"img/team_logo/large/$wq8[team].gif\"></td>
    </tr>
    <tr>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$es1[team]\" src=\"img/team_logo/large/$es1[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$es1[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$es1[2]</td>
    
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ws1[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ws1[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$ws1[team]\" src=\"img/team_logo/large/$ws1[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    </tr>
    <tr>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$es4[team]\" src=\"img/team_logo/large/$es4[team].gif\"></td>
    	<td class=\"tree\" align=\"center\">$es4[1]</td>
    	<td class=\"tree\" align=\"center\">$es4[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" align=\"center\">$ws4[2]</td>
    	<td class=\"tree\" align=\"center\">$ws4[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$ws4[team]\" src=\"img/team_logo/large/$ws4[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq2[team]\" src=\"img/team_logo/large/$eq2[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq2[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq2[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>	
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq2[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq2[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq2[team]\" src=\"img/team_logo/large/$wq2[team].gif\"></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq7[team]\" src=\"img/team_logo/large/$eq7[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq7[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq7[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$ef1[team]\" src=\"img/team_logo/large/$ef1[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ef1[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ef1[2]</td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wf1[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wf1[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wf1[team]\" src=\"img/team_logo/large/$wf1[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq7[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq7[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq7[team]\" src=\"img/team_logo/large/$wq7[team].gif\"></td>
    </tr>
    <tr></tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq3[team]\" src=\"img/team_logo/large/$eq3[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq3[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq3[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$ef2[team]\" src=\"img/team_logo/large/$ef2[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ef2[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ef2[2]</td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wf2[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wf2[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wf2[team]\" src=\"img/team_logo/large/$wf2[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq3[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq3[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq3[team]\" src=\"img/team_logo/large/$wq3[team].gif\"></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq6[team]\" src=\"img/team_logo/large/$eq6[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq6[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq6[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$sc1[team]\" src=\"img/team_logo/large/$sc1[team].gif\"></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$sc2[team]\" src=\"img/team_logo/large/$sc2[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq6[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq6[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq6[team]\" src=\"img/team_logo/large/$wq6[team].gif\"></td>
    </tr>
    <tr>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$es2[team]\" src=\"img/team_logo/large/$es2[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$es2[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$es2[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td colspan=\"2\" class=\"tree\">$sc1[1] : $sc2[1] - $sc1[2] : $sc2[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ws2[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ws2[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$ws2[team]\" src=\"img/team_logo/large/$ws2[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    </tr>
    <tr>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$es3[team]\" src=\"img/team_logo/large/$es3[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$es3[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$es3[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ws3[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$ws3[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$ws3[team]\"  src=\"img/team_logo/large/$ws3[team].gif\"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq4[team]\"  src=\"img/team_logo/large/$eq4[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq4[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq4[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq4[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq4[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq4[team]\"  src=\"img/team_logo/large/$wq4[team].gif\"></td>
    </tr>
    <tr>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$eq5[team]\" src=\"img/team_logo/large/$eq5[team].gif\"></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq5[1]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$eq5[2]</td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq5[2]</td>
    	<td class=\"tree\" width=\"3%\" align=\"center\">$wq5[1]</td>
    	<td class=\"tree\" width=\"8%\" align=\"center\"><img width=\"35px\" height=\"25px\" alt=\"$wq5[team]\" src=\"img/team_logo/large/$wq5[team].gif\"></td>
    </tr>
    
    </table><br />";
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
