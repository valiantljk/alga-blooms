<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>

        <style type="text/css" media="all">
            @import "null?\"\{";
            @import "/css/style.css";
        </style>

    </head>
    <body>

        <div id="container">
            <div id="masthead"><!-- BEGINNING OF LOGO AND UPPER NAVIGATION REGION: MASTHEAD -->
                <a href="http://www.ttu.edu/" id="homelink" title="Return to TTU Home" name="top"></a>

                <span style=" color: white;position:relative;left:90px;top:30px;">USGS Texas Cooperative Fish and Wildlife Research Unit </span><br/>
                <span style=" color: white;position:relative;left:90px;top:40px;">Texas Reservoir Water Data Portal  </span>

            </div>
            <div id="sideBar">
                <ul><li>
                        <a href="/">Welcome</a>
                    </li>
                    <li><a href="../../index.php/basicquery/options">Raw Data</a></li>
                    <li><a href="../../index.php/welcome/userguide">Userguide</a></li>
                    <li><a href="../../index.php/welcome/document">Documents</a></li>
                    <li><a href="../../index.php/basicquery/desorcom">Processing/Analysis</a></li>
                </ul>
            </div>
            <div id="content" align="center">
                <a href="../../index.php/statistics/sta_gra_des">
                    <img src="/image/graph.png"/>
                </a>
                <?php
                echo "The descriptive statistics include Mean Median Min Max Variance" . "<br>";
                echo "<ul><li>";
                echo "<b>Mean</b></li>" . "<li>";
                echo "Number of Results: ";
                echo "<b>" . count($sta_mean) . "</b></li>";
                echo "<li>";
		if(count($sta_mean)>0){
                echo "Period of Record: <b>";
                echo substr($sta_mean[0]["start_time"], -4);
                echo "--";
                echo substr($sta_mean[count($sta_mean) - 1]["start_time"], -4);
                echo "</b></li>";
                echo "</ul>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th align='center'>Id</th>";
                echo "<th align='center'>Date</th>";
                if ($by != 3) {
                    echo "<th align='center'>Data Density</th>";
                    echo "<th align='center'>Mean</th>";

                    echo "</tr>";
                    for ($number = 0; $number < count($sta_mean); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($by == 2) {
                            $date_year = substr($sta_mean[$number]["start_time"], -4);
                            echo $date_year;
                        } else if ($by == 1) {
                            $temp2 = $sta_mean[$number]["start_time"];
                            $first = strrpos($temp2, '/', -6);
                            $last = strrpos($temp2, '/');
                            $firstmonth = substr($temp2, 0, $first);
                            $firstyear = substr($temp2, -4);
                            $dateof = $firstmonth . "/" . $firstyear;
                            echo $dateof;
                        }

                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_mean[$number]["density"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["value"] != null)
                            printf("%.02f", $sta_mean[$number]["value"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<th align='center'>Winter</th>";
                    echo "<th align='center'>Spring</th>";
                    echo "<th align='center'>Summer</th>";
                    echo "<th align='center'>Fall</th>";
                    echo "</tr>";
                    for ($number = 0; $number < count($sta_mean); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_mean[$number]["start_time"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["winter"] != null)
                            printf("%.02f", $sta_mean[$number]["winter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["spring"] != null)
                            printf("%.02f", $sta_mean[$number]["spring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["summer"] != null)
                            printf("%.02f", $sta_mean[$number]["summer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["fall"] != null)
                            printf("%.02f", $sta_mean[$number]["fall"]);
                        echo "</td>";

                        echo "</tr>";
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["winter"] != null)
                            printf("%.0f", $sta_mean[$number]["dwinter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["spring"] != null)
                            printf("%.0f", $sta_mean[$number]["dspring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["summer"] != null)
                            printf("%.0f", $sta_mean[$number]["dsummer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_mean[$number]["fall"] != null)
                            printf("%.0f", $sta_mean[$number]["dfall"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                }
                echo "</table>";}
                ?>
                <!output the median!>
<?
                echo "<br>";
                echo "<ul><li>";
                echo "<b>Median</b></li>" . "<li>";
                echo "Number of Results: ";
                echo "<b>" . count($sta_median) . "</b></li>";
                echo "<li>";
		if(count($sta_median)>0){
                echo "Period of Record: <b>";
                echo substr($sta_median[0]["start_time"], -4);
                echo "--";
                echo substr($sta_median[count($sta_median) - 1]["start_time"], -4);
                echo "</b></li>";
                echo "</ul>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th align='center'>Id</th>";
                echo "<th align='center'>Date</th>";
                if ($by != 3) {
                    echo "<th align='center'>Data Density</th>";
                    echo "<th align='center'>Median</th>";

                    echo "</tr>";
                    for ($number = 0; $number < count($sta_median); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($by == 2) {
                            $date_year = substr($sta_median[$number]["start_time"], -4);
                            echo $date_year;
                        } else if ($by == 1) {
                            $temp2 = $sta_median[$number]["start_time"];
                            $first = strrpos($temp2, '/', -6);
                            $last = strrpos($temp2, '/');
                            $firstmonth = substr($temp2, 0, $first);
                            $firstyear = substr($temp2, -4);
                            $dateof = $firstmonth . "/" . $firstyear;
                            echo $dateof;
                        }

                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_median[$number]["density"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["value"] != null)
                            printf("%.02f", $sta_median[$number]["value"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<th align='center'>Winter</th>";
                    echo "<th align='center'>Spring</th>";
                    echo "<th align='center'>Summer</th>";
                    echo "<th align='center'>Fall</th>";
                    echo "</tr>";
                    for ($number = 0; $number < count($sta_median); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_median[$number]["start_time"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["winter"] != null)
                            printf("%.02f", $sta_median[$number]["winter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["spring"] != null)
                            printf("%.02f", $sta_median[$number]["spring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["summer"] != null)
                            printf("%.02f", $sta_median[$number]["summer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["fall"] != null)
                            printf("%.02f", $sta_median[$number]["fall"]);
                        echo "</td>";

                        echo "</tr>";
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["winter"] != null)
                            printf("%.0f", $sta_median[$number]["dwinter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["spring"] != null)
                            printf("%.0f", $sta_median[$number]["dspring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["summer"] != null)
                            printf("%.0f", $sta_median[$number]["dsummer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_median[$number]["fall"] != null)
                            printf("%.0f", $sta_median[$number]["dfall"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                }
                echo "</table>";}
?>
                <!output the max!>
<?
                echo "<br>";
                echo "<ul><li>";
                echo "<b>Max</b></li>" . "<li>";
                echo "Number of Results: ";
                echo "<b>" . count($sta_max) . "</b></li>";
                echo "<li>";
		if(count($sta_max)>0){
                echo "Period of Record: <b>";
                echo substr($sta_max[0]["start_time"], -4);
                echo "--";
                echo substr($sta_max[count($sta_max) - 1]["start_time"], -4);
                echo "</b></li>";
                echo "</ul>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th align='center'>Id</th>";
                echo "<th align='center'>Date</th>";
                if ($by != 3) {
                    echo "<th align='center'>Data Density</th>";
                    echo "<th align='center'>Max</th>";

                    echo "</tr>";
                    for ($number = 0; $number < count($sta_max); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($by == 2) {
                            $date_year = substr($sta_max[$number]["start_time"], -4);
                            echo $date_year;
                        } else if ($by == 1) {
                            $temp2 = $sta_max[$number]["start_time"];
                            $first = strrpos($temp2, '/', -6);
                            $last = strrpos($temp2, '/');
                            $firstmonth = substr($temp2, 0, $first);
                            $firstyear = substr($temp2, -4);
                            $dateof = $firstmonth . "/" . $firstyear;
                            echo $dateof;
                        }

                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_max[$number]["density"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["value"] != null)
                            printf("%.02f", $sta_max[$number]["value"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<th align='center'>Winter</th>";
                    echo "<th align='center'>Spring</th>";
                    echo "<th align='center'>Summer</th>";
                    echo "<th align='center'>Fall</th>";
                    echo "</tr>";
                    for ($number = 0; $number < count($sta_max); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_max[$number]["start_time"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["winter"] != null)
                            printf("%.02f", $sta_max[$number]["winter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["spring"] != null)
                            printf("%.02f", $sta_max[$number]["spring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["summer"] != null)
                            printf("%.02f", $sta_max[$number]["summer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["fall"] != null)
                            printf("%.02f", $sta_max[$number]["fall"]);
                        echo "</td>";

                        echo "</tr>";
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["winter"] != null)
                            printf("%.0f", $sta_max[$number]["dwinter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["spring"] != null)
                            printf("%.0f", $sta_max[$number]["dspring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["summer"] != null)
                            printf("%.0f", $sta_max[$number]["dsummer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_max[$number]["fall"] != null)
                            printf("%.0f", $sta_max[$number]["dfall"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                }
                echo "</table>";}
?>
                <!output the min!>
<?
                echo "<br>";
                echo "<ul><li>";
                echo "<b>Min</b></li>" . "<li>";
                echo "Number of Results: ";
                echo "<b>" . count($sta_min) . "</b></li>";
                echo "<li>";
		if(count($sta_min)>0){
                echo "Period of Record: <b>";
                echo substr($sta_min[0]["start_time"], -4);
                echo "--";
                echo substr($sta_min[count($sta_min) - 1]["start_time"], -4);
                echo "</b></li>";
                echo "</ul>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th align='center'>Id</th>";
                echo "<th align='center'>Date</th>";
                if ($by != 3) {
                    echo "<th align='center'>Data Density</th>";
                    echo "<th align='center'>Min</th>";

                    echo "</tr>";
                    for ($number = 0; $number < count($sta_min); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($by == 2) {
                            $date_year = substr($sta_min[$number]["start_time"], -4);
                            echo $date_year;
                        } else if ($by == 1) {
                            $temp2 = $sta_min[$number]["start_time"];
                            $first = strrpos($temp2, '/', -6);
                            $last = strrpos($temp2, '/');
                            $firstmonth = substr($temp2, 0, $first);
                            $firstyear = substr($temp2, -4);
                            $dateof = $firstmonth . "/" . $firstyear;
                            echo $dateof;
                        }

                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_min[$number]["density"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["value"] != null)
                            printf("%.02f", $sta_min[$number]["value"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<th align='center'>Winter</th>";
                    echo "<th align='center'>Spring</th>";
                    echo "<th align='center'>Summer</th>";
                    echo "<th align='center'>Fall</th>";
                    echo "</tr>";
                    for ($number = 0; $number < count($sta_min); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_min[$number]["start_time"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["winter"] != null)
                            printf("%.02f", $sta_min[$number]["winter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["spring"] != null)
                            printf("%.02f", $sta_min[$number]["spring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["summer"] != null)
                            printf("%.02f", $sta_min[$number]["summer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["fall"] != null)
                            printf("%.02f", $sta_min[$number]["fall"]);
                        echo "</td>";

                        echo "</tr>";
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["winter"] != null)
                            printf("%.0f", $sta_min[$number]["dwinter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["spring"] != null)
                            printf("%.0f", $sta_min[$number]["dspring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["summer"] != null)
                            printf("%.0f", $sta_min[$number]["dsummer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_min[$number]["fall"] != null)
                            printf("%.0f", $sta_min[$number]["dfall"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                }
                echo "</table>";}
?>
                <!output the variance!>
<?
                echo "<br>";
                echo "<ul><li>";
                echo "<b>Variance</b></li>" . "<li>";
                echo "Number of Results: ";
                echo "<b>" . count($sta_variance) . "</b></li>";
                echo "<li>";
		if(count($sta_variance)>0){
                echo "Period of Record: <b>";
                echo substr($sta_variance[0]["start_time"], -4);
                echo "--";
                echo substr($sta_variance[count($sta_variance) - 1]["start_time"], -4);
                echo "</b></li>";
                echo "</ul>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th align='center'>Id</th>";
                echo "<th align='center'>Date</th>";
                if ($by != 3) {
                    echo "<th align='center'>Data Density</th>";
                    echo "<th align='center'>Variance</th>";

                    echo "</tr>";
                    for ($number = 0; $number < count($sta_variance); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($by == 2) {
                            $date_year = substr($sta_variance[$number]["start_time"], -4);
                            echo $date_year;
                        } else if ($by == 1) {
                            $temp2 = $sta_variance[$number]["start_time"];
                            $first = strrpos($temp2, '/', -6);
                            $last = strrpos($temp2, '/');
                            $firstmonth = substr($temp2, 0, $first);
                            $firstyear = substr($temp2, -4);
                            $dateof = $firstmonth . "/" . $firstyear;
                            echo $dateof;
                        }

                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_variance[$number]["density"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["value"] != null)
                            printf("%.02f", $sta_variance[$number]["value"]);
                        else {
                            echo "0";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<th align='center'>Winter</th>";
                    echo "<th align='center'>Spring</th>";
                    echo "<th align='center'>Summer</th>";
                    echo "<th align='center'>Fall</th>";
                    echo "</tr>";
                    for ($number = 0; $number < count($sta_variance); $number++) {
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo $number + 1;
                        echo "</td>";
                        echo "<td align='center'>";
                        echo $sta_variance[$number]["start_time"];
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["winter"] != null)
                            printf("%.02f", $sta_variance[$number]["winter"]);
                        else {
                            echo "0";
                        }
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["spring"] != null)
                            printf("%.02f", $sta_variance[$number]["spring"]);
                        else {
                            echo "0";
                        }
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["summer"] != null)
                            printf("%.02f", $sta_variance[$number]["summer"]);
                        else {
                            echo "0";
                        }
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["fall"] != null)
                            printf("%.02f", $sta_variance[$number]["fall"]);
                        else {
                            echo "0";
                        }
                        echo "</td>";

                        echo "</tr>";
                        echo "<tr>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        echo "";
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["winter"] != null)
                            printf("%.0f", $sta_variance[$number]["dwinter"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["spring"] != null)
                            printf("%.0f", $sta_variance[$number]["dspring"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["summer"] != null)
                            printf("%.0f", $sta_variance[$number]["dsummer"]);
                        echo "</td>";
                        echo "<td align='center'>";
                        if ($sta_variance[$number]["fall"] != null)
                            printf("%.0f", $sta_variance[$number]["dfall"]);
                        echo "</td>";

                        echo "</tr>";
                    }
                }
                echo "</table>";}
?>
            </div>
            <div id="footer">
                <script language="javascript" type="text/javascript" src="js/dates.js"></script>
                <p>
                    <a href="mailto:jaln.liu@ttu.edu">Contact the webmaster</a><br />
                    &copy;<script language="javascript" type="text/javascript">document.write(printYear());</script> <a href="http://www.ttu.edu">Texas Tech University</a> | All Rights Reserved |
                    <script language="javascript" type="text/javascript">document.write("Last Updated: " + modDate());</script>
                </p>            </div>
        </div>
    </body>
</html>

