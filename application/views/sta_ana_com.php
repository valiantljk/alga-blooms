<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <style type="text/css" media="all">
            @import "null?\"\{";
            @import "/css/style.css";
        </style>
        <script src="/js/myjquery.js"></script>
        <script type="text/javascript" src="/js/myjquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="/js/myjquery-ui.css">
        <script type="text/javascript">
            $(function() {
                $('.date-picker').datepicker( {
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'dd/mm/yy',
                    yearRange: '1940:2013',
                    defaultDate:'01/01/1940',
                    onClose: function(dateText, inst) {
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1));
                    },
                    beforeShow : function(input, inst) {
                        if ((datestr = $(this).val()).length > 0) {
                            year = datestr.substring(datestr.length-4, datestr.length);
                            month = jQuery.inArray(datestr.substring(0, datestr.length-5), $(this).datepicker('option', 'monthNames'));
                            $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
                            $(this).datepicker('setDate', new Date(year, month, 1));
                        }
                    }
                });
            });
        </script>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type = "text/javascript">
            function makeBox() {
                var a = "f:<input type = 'text' name = 'const_f' value='0.5' id = 'box1' size='3'>"
                if (document.getElementById("intermethod").value==2) {
                    document.getElementById("inputBox").innerHTML = a;
                }
                else {
                    document.getElementById("inputBox").innerHTML = "";
                }
            }
        </script>

        <!--<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery_ui/jquery-ui-1.8.custom.js"></script>
        -->
        <link type="text/css" href="css/smoothness/jquery-ui-1.8.21.custom.css" rel="Stylesheet" />
        <script type="text/javascript" src="/newjs/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="/newjs/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function() {

                $( "#datepicker1" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    nextText: '',
                    prevText: '',
                    yearRange: '1940:2013',
                    defaultDate:'01/01/1940',
                    onClose: function(dateText, inst) {
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1));
                    }
                });
                            
            });
            $(document).ready(function() {
                $( "#datepicker2" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    nextText: '',
                    prevText: '',
                    yearRange: '1940:2013',
                    defaultDate:'01/01/1940'
                });
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });

        </script>
        <style type="text/css">
            input.mybutton {
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #bdf0cd), color-stop(1, #dfdfdf) );
                background:-moz-linear-gradient( center top, #bdf0cd 5%, #dfdfdf 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#bdf0cd', endColorstr='#dfdfdf');
                background-color:#bdf0cd;
                -moz-border-radius:9px;
                -webkit-border-radius:9px;
                border-radius:9px;
                display:inline-block;
                color:#000000;
                font-family:Arial;
                font-size:17px;
                font-weight:bold;
                padding:6px 11px;
                text-decoration:none;
            }input.mybutton:hover {
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #bdf0cd) );
                background:-moz-linear-gradient( center top, #dfdfdf 5%, #bdf0cd 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#bdf0cd');
                background-color:#dfdfdf;
            }input.mybutton:active {
                position:relative;
                top:1px;
            }
            a.mybutton {
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #bdf0cd), color-stop(1, #dfdfdf) );
                background:-moz-linear-gradient( center top, #bdf0cd 5%, #dfdfdf 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#bdf0cd', endColorstr='#dfdfdf');
                background-color:#bdf0cd;
                -moz-border-radius:9px;
                -webkit-border-radius:9px;
                border-radius:9px;
                display:inline-block;
                color:#000000;
                font-family:Arial;
                font-size:17px;
                font-weight:bold;
                padding:6px 11px;
                text-decoration:none;
            }a.mybutton:hover {
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #bdf0cd) );
                background:-moz-linear-gradient( center top, #dfdfdf 5%, #bdf0cd 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#bdf0cd');
                background-color:#dfdfdf;
            }a.mybutton:active {
                position:relative;
                top:1px;
            }
            /* This imageless css button was generated by CSSButtonGenerator.com */

            .ui-datepicker-calendar {
                display: none;
            }
            .ui-widget {
                font-family: Verdana,Arial,sans-serif;
                font-size: 0.7em;
            }

        </style>
    </head>

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
    $attributes = array('id' => 'form2');
    echo form_open('statistics/com_analysis', $attributes);
    ?>
    <table align="center">
        <tr>
            <td>Simplify Data with Lowess:</td>
        </tr>
        <tr>
            
            <td>Date From</td>
            <td><input type="text" id="startdate" class="date-picker" name="datefrom" size="10" value="20/01/1940"/></td>
        </tr>
        <tr>
            <td>Date To</td>
            <td><input type="text" id="startdate" class="date-picker" name="dateto" size="10" value="07/23/2012"></td>
        </tr>
        <tr>
            <td>Smoother</td>
            <td><input type="text" name="f" size="6" value="2/3"></td>
        </tr>
        <tr>
            <td>Iterations</td>
            <td><input type="text" name="iter" size="6" value="15"></td>
        </tr>

        <tr><td>Estimation Depth</td>
            <td><input type="text" name="vdepth" size="6" value="0">
                <select name="ftom">
                    <option value="1">Feet</option>
                    <option value="3.28">Meter</option>
                </select>
            </td>
        </tr>
        <tr><td>Interpolation</td>
            <td>
                <select name='method' id="intermethod" onchange="makeBox()" >
                    <option value='1' >Linear</option>
                    <option value='2'>Constant</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div id = "inputBox"></div><td>
        </tr>
        <tr><td align="center"><input type="submit" class="mybutton" value="Go"></td>
            
        </tr>
        <?php echo form_close() ?>
    </table>
            </div>
            <div id="footer">
<script language="javascript" type="text/javascript" src="js/dates.js"></script>
<p>
<a href="mailto:jaln.liu@ttu.edu">Contact the webmaster</a><br />
	&copy;<script language="javascript" type="text/javascript">document.write(printYear());</script> <a href="http://www.ttu.edu">Texas Tech University</a> | All Rights Reserved |
	<script language="javascript" type="text/javascript">document.write("Last Updated: " + modDate());</script>
</p>            </div>
        </div>
</html>
