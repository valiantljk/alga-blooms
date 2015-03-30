<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
    
        <style type="text/css" media="all">
            @import "null?\"\{";
            @import "/css/style.css";
        </style>
        
        <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery_ui/jquery-ui-1.8.custom.js"></script>
        <script type="text/javascript">

	    $(document).ready(function() {
                $( "#datepicker" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    nextText: '',
                    prevText: '',
                    yearRange: '1940:2013',
                    defaultDate:'01/01/1940'
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
            #mytable
            {
                font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
                width:100%;
                border-collapse:collapse;
            }
            #mytable td, #mytable th
            {
                font-size:1em;
                border:1px solid #98bf21;
                padding:3px 7px 2px 7px;
            }
            #mytable th
            {
                font-size:1.1em;
                text-align:center
                    padding-top:5px;
                padding-bottom:4px;
                background-color:#ffffff
                    color:#000000;
            }
            #mytable tr.alt td
            {
                color:#000000;
                background-color:#EAF2D3;
            }
            table.ex1{table-layout: fixed}
            select{width:100px}
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
		<div id="content">
        <?php


        $attributes = array('id' => 'form1');
        echo form_open('basicquery/quantity_result', $attributes);
        ?>

            <table border="1" align="center" class="mytable" >
		<tr>
			<td>  <select name='shortname' width="100%">
<option value='0'>Arlington</option> 
<option value='1'>Bardwell</option> 
<option value='2'>Belton</option> 
<option value='3'>Benbrook</option> 
<option value='4'>Bridgeport</option>
<option value='5'>Buchanan</option> 
<option value='6'>Canton</option> 
<option value='7'>Canyon</option> 
<option value='8'>Choke</option> 
<option value='9'>Corpus</option> 
<option value='10'>Cypress</option> 
<option value='11'>Eagle</option> 
<option value='12'>Foss</option> 
<option value='13'>Georgetown</option> 
<option value='14'>Granger</option> 
<option value='15'>Greenbelt</option> 
<option value='16'>Houston</option> 
<option value='17'>HubbardCk</option> 
<option value='18'>Ivie</option> 
<option value='19'>JoePool</option> 
<option value='20'>Lewisville</option>
<option value='21'>Limestone</option> 
<option value='22'>Livingston</option> 
<option value='23'>LkColoradoCity</option> 
<option value='24'>LkConroe</option> 
<option value='25'>LkGranbury</option> 
<option value='26'>MacKenzie</option> 
<option value='27'>Medina</option> 
<option value='28'>Meredith</option>
<option value='29'>Navarro</option> 
<option value='30'>Palestine</option>
<option value='31'>Patman</option>
<option value='32'>Pines</option>
<option value='33'>PossumKingdom</option>
<option value='34'>Proctor</option>
<option value='35'>Rayburn</option>
<option value='36'>RayHubbard</option>
<option value='37'>Red</option>
<option value='38'>Richland-Chamb</option>
<option value='39'>Roberts</option>
<option value='40'>Somerville</option>
<option value='41'>Spence</option>
<option value='42'>Stillhouse</option>
<option value='43'>Tawakoni</option>
<option value='44'>Texana</option>
<option value='45'>Thomas</option>
<option value='46'>Toledo</option>
<option value='47'>Travis</option>
<option value='48'>TwinButtes</option>
<option value='49'>Waco</option>
<option value='50'>White</option>
<option value='51'>Whitney</option>
                            </select>
                        </td>
		</tr>
                <tr>
                    <td align="center"><!--date from-->
                        <input type="text" id="datepicker" name="datefrom" size="12">
                    
            
                        <input type="text" id="datepicker2" name="dateto" size="12">
                    </td>

                </tr>
            </table>
            
            <p  ><input type="submit" class="mybutton" value="GO"></p>

        <? echo form_close(); ?>
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