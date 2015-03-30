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
                <a href="../../index.php/statistics/sta_gra_com">
                    <img src="/image/graph.png"/>
                </a>
                <?php
                echo "<ul>";
                echo "<li>Lowess Result: ";
                echo "Number of Results: ";
                echo "<b>" . count($monthly_lowess) . "</b>" . "</li>";
                echo "<li>";
                echo "Period of Record: <b>";
                echo substr($monthly_lowess[0]["start_time"], -4);
                echo "--";
                echo substr($monthly_lowess[count($monthly_lowess) - 1]["start_time"], -4);
                echo "</b></li>";
                echo "</ul>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th align='center'>Id</th>";
                echo "<th align='center'>Date</th>";
                echo "<th align='center'>Depth</th>";
                echo "<th align='center'>Lowess</th>";
                echo "<th align='center'>Density</th>";
                echo "</tr>";
                for ($number = 0; $number < count($monthly_lowess); $number++) {
                    echo "<tr>";
                    echo "<td align='center'>";
                    echo $number + 1;
                    echo "</td>";
                    echo "<td align='center'>";
                    $temp2 = $monthly_lowess[$number]["start_time"];
                    $first = strrpos($temp2, '/', -6);
                    $last = strrpos($temp2, '/');
                    $firstmonth = substr($temp2, 0, $first);
                    $firstyear = substr($temp2, -4);
                    $dateof = $firstmonth . "/" . $firstyear;
                    echo $dateof;
                    echo "</td>";
                    echo "<td align='center'>";
                    echo $vdepth;
                    echo "</td>";
                    echo "<td align='center'>";
                    printf("%.02f", $monthly_lowess[$number]["lowessapproxi"]);
                    echo "</td>";
                    echo "</td>";
                    echo "<td align='center'>";
                    echo count($monthly_lowess[$number]["lowess"]);
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br/><br/>";
                if ($this->session->userdata('sourcetag') != 'ALL') {
                    echo "<li>";
                    echo "Lowess Regression vs Origianl Data";
                    echo "</li>";
                    echo "<table border='1'>";
                    echo "<tr>";
                    echo "<th align='center'>Id</th>";
                    echo "<th align='center'>Date</th>";
                    echo "<th align='center'>Depth</th>";
                    echo "<th align='center'>Lowess</th>";
                    echo "<th align='center'>Original</th>";
                    echo "</tr>";
                    $record = 0;
                    for ($number = 0; $number < count($monthly_lowess); $number++) {

                        for ($numin = 0; $numin < count($monthly_lowess[$number]["depth"]); $numin++) {
                            echo "<tr>";
                            if ($numin == 0) {
                                echo "<td align='center'>";
                                echo $number + 1;
                                echo "</td>";
                                echo "<td align='center'>";
                                echo $monthly_lowess[$number]["start_time"];
                                echo "</td>";
                            } else {
                                echo "<td align='center'>";
                                echo "</td>";
                                echo "<td align='center'>";
                                echo "</td>";
                            }
                            echo "<td align='center'>";
                            printf("%.02f", $monthly_lowess[$number]["depth"][$numin]);
                            echo "</td>";
                            echo "<td align='center'>";
                            if ($monthly_lowess[$number]["lowess"] != null)
                                printf("%.02f", $monthly_lowess[$number]["lowess"][$numin]);
                            echo "</td>";
                            echo "<td align='center'>";
                            if ($original[$record] != null)
                                printf("%.02f", $original[$record]);
                            $record++;
                            echo "</td>";
                            echo "</tr>";
                        }
                    }

                    echo "</table>";
                }
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

