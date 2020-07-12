<?php

function parseschedule_bet($s, $type, $team, $nick, $continue)
{
    global $current_season, $schedule_season, $password;

    $nick_lower = strtolower($nick);

    include ("data/pass/pass.php");
    $upload_dir = "data/schedule";
    if (!isset($s)) {
        $s = $current_season;
        $team = "all";
    }

    $k = ".txt";
    $g = ($upload_dir . "/playoff" . $current_season . $k);

    if (file_exists($g)) {
        $season_type = "po";
    }
    else {
        $season_type = "reg";
    }

    if (!isset($type)) {
        $type = $season_type;
    }

    if ($type == "po") {
        $n = "playoff";
        $x = "Play-offs";
    }
    if ($type == "reg") {
        $n = "schedule";
        $x = "Regular Season";
    }

    $f2 = $n . $s . $k;


    $z = 1;
    $u = 1;
    $x = 0;
    $f = fopen($upload_dir . "/" . $f2, "r");

    while (!feof($f)) {
        $tmp = explode("|", fgets($f, 2000));
        if (trim($tmp[0]) != "") {
            if (($tmp[10] == "?") && ($u < 3) && (mktime(22, 00, 00, $tmp[6], $tmp[5] - 7, $tmp[7]) <=
                (time())) && (mktime(20, 00, 00, $tmp[6], $tmp[5], $tmp[7]) > (time()))) {
                if (strlen($tmp[5]) < 2) {
                    $tmp[5] = "0" . $tmp[5];
                }
                if (strlen($tmp[6]) < 2) {
                    $tmp[6] = "0" . $tmp[6];
                }
                if ($tmp[12] == 1) {
                    echo "<form name=\"bett\" method=\"post\" action=\"sc.php?id=bo_ticket_confirm.php\">";
                    echo "<br /><table align=\"center\" class=\"overview\">\n<tbody><tr><th align=\"center\">preview</th><th colspan=\"5\" align=\"center\">";
                    if ($type == "po") {echo "$tmp[0] ";}
                    $z = 1;

                    echo "$tmp[5].$tmp[6].$tmp[7]</th><th align=\"center\" width=\"8%\">home<br />wins</th>";
                    if ($type != "po") {echo "<th align=\"center\" width=\"8%\">tie</th>";}
                    else {echo "<th align=\"center\" width=\"8%\">&nbsp;</th>";}
                    echo "<th align=\"center\" width=\"8%\">away<br />wins</th></tr>\n";
                }
                if ($z == 2) {echo "<tr>";$z = 1;}
                else {echo "<tr class=\"even\">";$z++;$x++;}
                echo "<td width=\"5%\" align=\"left\" >&nbsp;<a rel=\"shadowbox;width=800;height=600\" href=\"jquery.php?id=teams_compare.php&amp;team1=$tmp[8]&amp;team2=$tmp[9]\"><img class=\"logo\" title=\"$tmp[1] vs. $tmp[2] match-up history\" src=\"img/s_cal.gif\"></a></td>\n";
                echo "<td valign=\"middle\" width=\"26%\" align=\"right\" >";
                echo "<a class=\"text1\" title=\"$tmp[1]\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[3]\">$tmp[1]</a>";
                echo "</td><td align=\"left\" valign=\"middle\">&nbsp;<a href=\"sc.php?id=teams.php&amp;team=$tmp[8]\"><img class=\"logo\" alt=\"$tmp[1]\" title=\"$tmp[1]\" src=\"img/team_logo/small/$tmp[8].png\" width=\"30px\"></a></td>";
                echo "<td align=\"center\">";
                echo " - </td>";
                echo "<td align=\"right\" valign=\"middle\"><a href=\"sc.php?id=teams.php&amp;team=$tmp[9]\"><img class=\"logo\" alt=\"$tmp[2]\" title=\"$tmp[2]\" src=\"img/team_logo/small/$tmp[9].png\" width=\"30px\"></a>&nbsp;</td>";
                echo "<td valign=\"middle\" width=\"26%\" align=\"left\">";
                echo "<a target=\"_blank\" class=\"text1\" title=\"$tmp[2]\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[4]\">$tmp[2]</a>";
                echo "</td>\n";
                $betfile = "data/betting/" . $current_season . "/" . $tmp[7] . "-" . $tmp[6] . "-" . $tmp[5] . "_" . $nick_lower . ".txt";
                if ($continue == "ok") {
                    if (($team_short[$nick_lower] == $tmp[8]) || ($team_short[$nick_lower] == $tmp[9])) {
                        echo "<td colspan=\"3\" align=\"center\"><span class=\"note\">you cannot bet on your team</span></td>";
                    }
                    else {
                        if (file_exists($betfile)) {
                            $f3 = fopen($betfile, "r");
                            while (!feof($f3)) {
                                $tmp_bet = explode("|", fgets($f3, 2000));
                                if (trim($tmp_bet[0]) != "") {
                                    if (trim($tmp_bet[1]) == trim($tmp[14])) {
                                        if ($tmp_bet[3] == "1") {
                                            $aa1[$tmp[14]] = "1";
                                        }
                                    }
                                }
                            }
                            fclose($f3);
                        }
                        if ($aa1[$tmp[14]] == "1") {
                            echo "<td align=\"center\" class=\"hilight\">";
                            echo "<input type=\"radio\" title=\"$tmp[8] wins\" name=\"match[$tmp[14]]\" checked=\"checked\" ";
                        }
                        else {
                            echo "<td align=\"center\">";
                            echo "<input type=\"radio\" title=\"$tmp[8] wins\" name=\"match[$tmp[14]]\" ";
                        }
                        echo "value=\"$tmp[7];$tmp[6];$tmp[5]|$tmp[14]|$tmp[8]-$tmp[9]|1|\"></input>";
                        echo "</td>";
                        if (file_exists($betfile)) {
                            $f3 = fopen($betfile, "r");
                            while (!feof($f3)) {
                                $tmp_bet = explode("|", fgets($f3, 2000));
                                if (trim($tmp_bet[0]) != "") {
                                    if (trim($tmp_bet[1]) == trim($tmp[14])) {
                                        if ($tmp_bet[3] == "X") {
                                            $aa1[$tmp[14]] = "X";
                                        }
                                    }
                                }
                            }
                            fclose($f3);
                        }
                        if ($type != "po") {
                            if ($aa1[$tmp[14]] == "X") {
                                echo "<td align=\"center\" class=\"hilight\">";
                                echo "<input type=\"radio\" title=\"tie game\" name=\"match[$tmp[14]]\" checked=\"checked\" ";
                            }
                            else {
                                echo "<td align=\"center\">";
                                echo "<input type=\"radio\" title=\"tie game\" name=\"match[$tmp[14]]\" ";
                            }
                            echo "value=\"$tmp[7];$tmp[6];$tmp[5]|$tmp[14]|$tmp[8]-$tmp[9]|X|\"></input>";
                            echo "</td>";
                        }
                        else {
                            echo "<td align=\"center\">&nbsp;</tf>";
                        }
                        if (file_exists($betfile)) {
                            $f3 = fopen($betfile, "r");
                            while (!feof($f3)) {
                                $tmp_bet = explode("|", fgets($f3, 2000));
                                if (trim($tmp_bet[0]) != "") {
                                    if (trim($tmp_bet[1]) == trim($tmp[14])) {
                                        if ($tmp_bet[3] == "2") {
                                            $aa1[$tmp[14]] = "2";
                                        }
                                    }
                                }
                            }
                            fclose($f3);
                        }
                        if ($aa1[$tmp[14]] == "2") {
                            echo "<td align=\"center\" class=\"hilight\">";
                            echo "<input type=\"radio\" title=\"$tmp[9] wins\" name=\"match[$tmp[14]]\" checked=\"checked\" ";
                        }
                        else {
                            echo "<td align=\"center\">";
                            echo "<input type=\"radio\" title=\"$tmp[9] wins\" name=\"match[$tmp[14]]\" ";
                        }
                        echo "value=\"$tmp[7];$tmp[6];$tmp[5]|$tmp[14]|$tmp[8]-$tmp[9]|2|\"></input>";
                        echo "</td>";
                    }
                }
                else {echo "<td colspan=\"3\" align=\"center\"><span class=\"note\">login above</span>";}
                echo "</td>";
                echo "</tr>\n";
                if (($tmp[12] == 2) || ($tmp[0] == "Stanley Cup Finals")) {
                    echo "<input type=\"hidden\" name=\"date[$tmp[7];$tmp[6];$tmp[5]]\" value=\"$tmp[7];$tmp[6];$tmp[5]\"></table>\n";$u++;
                    $allbetfile = "data/betting/" . $current_season . "/" . $tmp[7] . "-" . $tmp[6] . "-" . $tmp[5] . ".txt";
                    if (file_exists($allbetfile)) {
                        echo "<br /><center><span class=\"note\">" . $tmp[7] . "-" . $tmp[6] . "-" . $tmp[5] . " bets:<br />";
                        $f4 = fopen($allbetfile, "r");
                        while (!feof($f4)) {
                            $tmp_all1 = explode("_", fgets($f4, 2000));
                            if (trim($tmp_all1[0]) != "") {
                                $tmp_all = explode(".txt",$tmp_all1[1]);
                                echo $tmp_all[0]. ", ";
                            }
                        }
                        echo "</span></center><br />";
                    }
                }
            }
        }
    }
    if (($x == 0) && ($s == $current_season)) {echo "<center><b><br /><br />no betting open today!<br /><br /></b></center>";
    }
    $nick_lower = strtolower($nick);
    $password_main = $password_main[$nick_lower];

    echo "<br /><table align=\"center\" width=\"95%\"><tr ><td width=\"72%\"></td><td align=\"center\">\n";

    if ($x != 0) {
        if (trim($nick) != "") {
            echo "\n<input type=\"hidden\" name=\"continue\" value=\"yes\">\n\n<input type=\"submit\" class=\"button\" value=\"-- NEXT STEP --\"></td></tr>";
        }
    }
    echo "</table></form>";

}

?>

