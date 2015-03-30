<html>
    <head>

        <style type="text/css" media="all">
            @import "null?\"\{";
            @import "/css/style.css";
        </style>
        <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery_ui/jquery-ui-1.8.custom.js"></script>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title></title>
    </head>

    <body>

        <div id="container">
            <div id="masthead"><!-- BEGINNING OF LOGO AND UPPER NAVIGATION REGION: MASTHEAD -->
                <a href="http://www.ttu.edu/" id="homelink" title="Return to TTU Home" name="top"></a>

                <span style=" color: white;position:relative;left:90px;top:30px;">USGS Texas Cooperative Fish and Wildlife Research Unit </span><br/>
                <span style=" color: white;position:relative;left:90px;top:40px;">Texas Reservoir Water Quality Portal  </span>

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

            <div id="content">
                <?
                if ($query_tceq == null && $query_usgs == null && $query_othe == null&&$query_tcequ == null && $query_usgsu == null) {

                    echo "no data";
                } else {
                    
/*
                    echo "</a><br>";
                    echo "<center>";

                    if ($num_tceq>0&&$num_usgs>0&&$num_othe>0) {
                        echo "Three Sources are Available: <b>TCEQ, USGS and OTHER</b>";
                    } 
                    else if ($num_tceq>0&&$num_usgs>0) {
                        echo "Two Sources are Available: <b>TCEQ and USGS</b>";
                    } 
                    else if ($num_usgs>0&&$num_othe>0) {
                        echo "Two Sources are Available: <b>USGS and OTHER</b>";
                    } 
                    else if ($num_tceq>0&&$num_othe>0) {
                        echo "Two Sources are Available: <b>TCEQ and OTHER</b>";
                    } 
                    else if ($num_tceq>0) {
                        echo "Only One Source is Selected/Available: <b>TCEQ</b>";
                    } 
                    else if ($num_usgs>0) {
                        echo "Only One Source is Selected/Available: <b>USGS</b>";
                    } 
                    else if ($num_othe>0) {
                        echo "Only One Source is Selected/Available: <b>OTHER</b>";
                    }*/
                    //echo "</center>";
                    if ($num_tceq > 0) {
                        if ($PARADETAIL != NULL) {
                            $row = $PARADETAIL->result_array();
                            $row_array = array_values($row[0]);
                            $units = $row_array[2];
                            $name = $row_array[1];

                            $this->session->set_userdata('paraname', $name);
                            $this->session->set_userdata('paraunit', $units);
                        }
                        $temp_array = array_values($query_tceq->result_array());
                        //for($i=0)
                        echo "<center>";
                        echo "<b>" . "Source: TCEQ" . "</b><br/>";
                        echo "Number of Results: <b>" . count($query_tceq->result_array()) . " </b>";
                        echo "Period of Record: <b>";
                        echo substr($temp_array[0]["DATE"], -4) . "--" . substr($temp_array[count($temp_array) - 1]["DATE"], -4);
                        echo "</b>";
                        echo "</center>";
                        echo "<table border=1 align=center>";
                        echo "<tr>";
                        //fetch a single row:
                        $column_names = $query_tceq->row_array();
                        for ($key_number = 0; $key_number < count($column_names); $key_number++) {
                            //get the column names of this single row;
                            $array_key = array_keys($column_names);
                            //output the column names:
                            if ($key_number == 6)
                                echo "<th  align='center'>Variable</th>";
                            else if ($key_number == 5)
                                echo "<th  align='center'>$array_key[$key_number] ($unitname)</th>";
                            else if ($key_number == 7)
                                echo "<th align='center'>$units</th>";
                            else if ($key_number == 8)
                                break;
                            else if ($key_number == 9)
                                break;
                            else
                                echo "<th  align='center'>$array_key[$key_number]</th>";
                        }

                        echo "</tr>";
                        //output all the query result:
                        $item_num = 1;
                        foreach ($query_tceq->result_array() as $row):
                            echo "<tr>";

                            for ($num_row_item = 0; $num_row_item < count($row) - 2; $num_row_item++) {
                                if ($num_row_item == 0) {
                                    echo "<td  align='center'>$item_num</td>";
                                } else {
                                    if ($num_row_item != 5 && $num_row_item != 7) {
                                        $row_array = array_values($row);
                                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                                    } else {
                                        $row_array = array_values($row);
                                        echo "<td align='center'>";
                                        printf("%.02f", $row_array[$num_row_item]);
                                        echo "</td>";
                                    }
                                }
                            }
                            echo "</tr>";
                            $item_num++;
                        endforeach;
                        echo "</table>";
                    }
                    if ($num_usgs > 0) {
                        if ($PARADETAIL != NULL) {
                            $row = $PARADETAIL->result_array();
                            $row_array = array_values($row[0]);
                            $units = $row_array[2];
                            $name = $row_array[1];

                            $this->session->set_userdata('paraname', $name);
                            $this->session->set_userdata('paraunit', $units);
                        }
                        $temp_array = array_values($query_usgs->result_array());
                        //for($i=0)
                        echo "<center>";
                        echo "<b>" . "Source: USGS" . "</b><br/>";
                        echo "Number of Results: <b>" . count($query_usgs->result_array()) . " </b>";
                        echo "Period of Record: <b>";
                        echo substr($temp_array[0]["DATE"], -4) . "--" . substr($temp_array[count($temp_array) - 1]["DATE"], -4);
                        echo "</b>";
                        echo "</center>";
                        echo "<table border=1 align=center>";
                        echo "<tr>";
                        //fetch a single row:
                        $column_names = $query_usgs->row_array();
                        for ($key_number = 0; $key_number < count($column_names); $key_number++) {
                            //get the column names of this single row;
                            $array_key = array_keys($column_names);
                            //output the column names:
                            if ($key_number == 6)
                                echo "<th  align='center'>Variable</th>";
                            else if ($key_number == 5)
                                echo "<th  align='center'>$array_key[$key_number] ($unitname)</th>";
                            else if ($key_number == 7)
                                echo "<th align='center'>$units</th>";
                            else if ($key_number == 8)
                                break;
                            else if ($key_number == 9)
                                break;
                            else
                                echo "<th  align='center'>$array_key[$key_number]</th>";
                        }

                        echo "</tr>";
                        //output all the query result:
                        $item_num = 1;
                        foreach ($query_usgs->result_array() as $row):
                            echo "<tr>";
                            for ($num_row_item = 0; $num_row_item < count($row) - 2; $num_row_item++) {
                                if ($num_row_item == 0) {
                                    echo "<td  align='center'>$item_num</td>";
                                } else {
                                    if ($num_row_item != 5 && $num_row_item != 7) {
                                        $row_array = array_values($row);
                                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                                    } else {
                                        $row_array = array_values($row);
                                        echo "<td align='center'>";
                                        printf("%.02f", $row_array[$num_row_item]);
                                        echo "</td>";
                                    }
                                }
                            }
                            echo "</tr>";
                            $item_num++;
                        endforeach;
                        echo "</table>";
                    }
if ($num_tcequ > 0) {
                        if ($PARADETAIL != NULL) {
                            $row = $PARADETAIL->result_array();
                            $row_array = array_values($row[0]);
                            $units = $row_array[2];
                            $name = $row_array[1];

                            $this->session->set_userdata('paraname', $name);
                            $this->session->set_userdata('paraunit', $units);
                        }
                        $temp_array = array_values($query_tcequ->result_array());
                        //for($i=0)
                        echo "<center>";
                        echo "<b>" . "Source: UPDATED TCEQ" . "</b><br/>";
                        echo "Number of Results: <b>" . count($query_tcequ->result_array()) . " </b>";
                        echo "Period of Record: <b>";
                        echo substr($temp_array[0]["DATE"], -4) . "--" . substr($temp_array[count($temp_array) - 1]["DATE"], -4);
                        echo "</b>";
                        echo "</center>";
                        echo "<table border=1 align=center>";
                        echo "<tr>";
                        //fetch a single row:
                        $column_names = $query_tcequ->row_array();
                        for ($key_number = 0; $key_number < count($column_names); $key_number++) {
                            //get the column names of this single row;
                            $array_key = array_keys($column_names);
                            //output the column names:
                            if ($key_number == 6)
                                echo "<th  align='center'>Variable</th>";
                            else if ($key_number == 5)
                                echo "<th  align='center'>$array_key[$key_number] ($unitname)</th>";
                            else if ($key_number == 7)
                                echo "<th align='center'>$units</th>";
                            else if ($key_number == 8)
                                break;
                            else if ($key_number == 9)
                                break;
                            else
                                echo "<th  align='center'>$array_key[$key_number]</th>";
                        }

                        echo "</tr>";
                        //output all the query result:
                        $item_num = 1;
                        foreach ($query_tcequ->result_array() as $row):
                            echo "<tr>";

                            for ($num_row_item = 0; $num_row_item < count($row) - 2; $num_row_item++) {
                                if ($num_row_item == 0) {
                                    echo "<td  align='center'>$item_num</td>";
                                } else {
                                    if ($num_row_item != 5 && $num_row_item != 7) {
                                        $row_array = array_values($row);
                                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                                    } else {
                                        $row_array = array_values($row);
                                        echo "<td align='center'>";
                                        printf("%.02f", $row_array[$num_row_item]);
                                        echo "</td>";
                                    }
                                }
                            }
                            echo "</tr>";
                            $item_num++;
                        endforeach;
                        echo "</table>";
                    }
                    if ($num_usgsu > 0) {
                        if ($PARADETAIL != NULL) {
                            $row = $PARADETAIL->result_array();
                            $row_array = array_values($row[0]);
                            $units = $row_array[2];
                            $name = $row_array[1];

                            $this->session->set_userdata('paraname', $name);
                            $this->session->set_userdata('paraunit', $units);
                        }
                        $temp_array = array_values($query_usgsu->result_array());
                        //for($i=0)
                        echo "<center>";
                        echo "<b>" . "Source: UPDATED USGS" . "</b><br/>";
                        echo "Number of Results: <b>" . count($query_usgsu->result_array()) . " </b>";
                        echo "Period of Record: <b>";
                        echo substr($temp_array[0]["DATE"], -4) . "--" . substr($temp_array[count($temp_array) - 1]["DATE"], -4);
                        echo "</b>";
                        echo "</center>";
                        echo "<table border=1 align=center>";
                        echo "<tr>";
                        //fetch a single row:
                        $column_names = $query_usgsu->row_array();
                        for ($key_number = 0; $key_number < count($column_names); $key_number++) {
                            //get the column names of this single row;
                            $array_key = array_keys($column_names);
                            //output the column names:
                            if ($key_number == 6)
                                echo "<th  align='center'>Variable</th>";
                            else if ($key_number == 5)
                                echo "<th  align='center'>$array_key[$key_number] ($unitname)</th>";
                            else if ($key_number == 7)
                                echo "<th align='center'>$units</th>";
                            else if ($key_number == 8)
                                break;
                            else if ($key_number == 9)
                                break;
                            else
                                echo "<th  align='center'>$array_key[$key_number]</th>";
                        }

                        echo "</tr>";
                        //output all the query result:
                        $item_num = 1;
                        foreach ($query_usgsu->result_array() as $row):
                            echo "<tr>";
                            for ($num_row_item = 0; $num_row_item < count($row) - 2; $num_row_item++) {
                                if ($num_row_item == 0) {
                                    echo "<td  align='center'>$item_num</td>";
                                } else {
                                    if ($num_row_item != 5 && $num_row_item != 7) {
                                        $row_array = array_values($row);
                                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                                    } else {
                                        $row_array = array_values($row);
                                        echo "<td align='center'>";
                                        printf("%.02f", $row_array[$num_row_item]);
                                        echo "</td>";
                                    }
                                }
                            }
                            echo "</tr>";
                            $item_num++;
                        endforeach;
                        echo "</table>";
                    }
                    if ($num_othe > 0) {
                        if ($PARADETAIL != NULL) {
                            $row = $PARADETAIL->result_array();
                            $row_array = array_values($row[0]);
                            $units = $row_array[2];
                            $name = $row_array[1];

                            $this->session->set_userdata('paraname', $name);
                            $this->session->set_userdata('paraunit', $units);
                        }
                        $temp_array = array_values($query_othe->result_array());
                        //for($i=0)
                        echo "<center>";
                        echo "<b>" . "Source: OTHER" . "</b><br/>";
                        echo "Number of Results: <b>" . count($query_tceq->result_array()) . " </b></li>";
                        echo "<li>Period of Record: <b>";
                        echo substr($temp_array[0]["DATE"], -4) . "--" . substr($temp_array[count($temp_array) - 1]["DATE"], -4);
                        echo "</b>";
                        echo "</center>";
                        echo "<table border=1 align=center>";
                        echo "<tr>";
                        //fetch a single row:
                        $column_names = $query_othe->row_array();
                        for ($key_number = 0; $key_number < count($column_names); $key_number++) {
                            //get the column names of this single row;
                            $array_key = array_keys($column_names);
                            //output the column names:
                            if ($key_number == 6)
                                echo "<th  align='center'>Variable</th>";
                            else if ($key_number == 5)
                                echo "<th  align='center'>$array_key[$key_number] ($unitname)</th>";
                            else if ($key_number == 7)
                                echo "<th align='center'>$units</th>";
                            else if ($key_number == 8)
                                break;
                            else if ($key_number == 9)
                                break;
                            else
                                echo "<th  align='center'>$array_key[$key_number]</th>";
                        }

                        echo "</tr>";
                        //output all the query result:
                        $item_num = 1;
                        foreach ($query_othe->result_array() as $row):
                            echo "<tr>";

                            for ($num_row_item = 0; $num_row_item < count($row) - 2; $num_row_item++) {
                                if ($num_row_item == 0) {
                                    echo "<td  align='center'>$item_num</td>";
                                } else {
                                    if ($num_row_item != 5 && $num_row_item != 7) {
                                        $row_array = array_values($row);
                                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                                    } else {
                                        $row_array = array_values($row);
                                        echo "<td align='center'>";
                                        printf("%.02f", $row_array[$num_row_item]);
                                        echo "</td>";
                                    }
                                }
                            }
                            echo "</tr>";
                            $item_num++;
                        endforeach;
                        echo "</table>";
                    }
                }
                ?>

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
