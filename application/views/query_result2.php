<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery_ui/jquery-ui-1.8.custom.js"></script>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title></title>
    </head>
    
    
    
        <style type="text/css" media="all">
            @import "null?\"\{";
            @import "/css/style.css";
        </style>
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
			<div id="content">
        <?
        /*
          if($query1!=null):
          echo "$query1->num_rows";
          endif; */
        if ($query != null):
            if ($PARADETAIL != NULL) {

            }
            if ($query->num_rows() > 0):
                $num_result = $query->num_rows();
                echo "<table border=2 align=center>";
                echo "<tr>";
                echo "<th align=center colspan=6 >QUERY CRITERIA</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Source</th>";
                echo "<th>Code</th>";
                echo "<th>Variable</th>";
                echo "<th>Variable Detail</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td  align='center'>$QSource</td>";
                foreach ($PARADETAIL->result_array() as $row):

                    for ($num_row_item = 0; $num_row_item < count($row); $num_row_item++) {
                        $row_array = array_values($row);
                        if($num_row_item!=2)
                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                        $units=$row_array[2];

                    }

                endforeach;
                echo "</tr>";
                echo "<tr>";

                echo "<th>Reservoir</th>";
                echo "<th>Depth Range (Feet)</th>";
                echo "<th>Date Range</th>";
                echo "<th>Number of Observations</th>";

                echo "</tr>";
                echo "<tr>";
                echo "<td  align='center'>$QRese </td>";
                echo "<td  align='center'>$QDepf-$QDept</td>";
                echo "<td  align='center'>$QDatf-$QDatt</td>";
                echo "<td  align='center'>$num_result</td>";
                echo "</tr>";


                echo "</table>";
                echo"<p align=center></p>";
                echo "<table border=1 align=center>";
                echo "<tr>";
                //fetch a single row:
                $column_names = $query->row_array();
                for ($key_number = 0; $key_number < count($column_names); $key_number++) {
                    //get the column names of this single row;
                    $array_key = array_keys($column_names);
                    //output the column names:
                    if ($key_number == 6)
                        echo "<th  align='center'>Variable</th>";
                    else if ($key_number==5)
                        echo "<th  align='center'>$array_key[$key_number] ($unitname)</th>";
                    else if ($key_number==7)
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
                $item_num=1;
                foreach ($query->result_array() as $row):
                    echo "<tr>";

                    for ($num_row_item = 0; $num_row_item < count($row)-2; $num_row_item++) {
                        if($num_row_item==0)
                        {
                            echo "<td  align='center'>$item_num</td>";
                        }
                        else
                        {
                        $row_array = array_values($row);
                        echo "<td  align='center'>$row_array[$num_row_item]</td>";
                        }
                    }
                    echo "</tr>";
                     $item_num++;
                endforeach;
                echo "</table>";
            endif;

        else:
            echo "no data";
        endif;


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
