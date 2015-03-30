<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css" media="all">
            @import "null?\"\{";
            @import "/css/style.css";
        </style>
        <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery_ui/jquery-ui-1.8.custom.js"></script>
        <script type="text/javascript">
            var i;
            var p;
            var TCEQparameter=new Array('Temperature(10)','Specific Conductance(95)','Dissolved Oxygen(300)',
            'pH, unfiltered(400)','Salinity, unfiltered(480)','Total nitrogen, unfiltered(600)','Nitrate plus nitrite, unfiltered(630)',
            'Phosphorus,unfiltered(665)','Phosphorus,filtered(666)','Hardness(900)','Calcium,filtered(915)','Magnesium,filtered(925)',
            'Magnesium, unfiltered(927)','Sodium, unfiltered(929)','Sodium, filtered(930)','Potassium, filtered(935)','Potassium, unfiltered(937)',
            'Chloride, filtered(940)','Sulfate, filtered(945)','Fluoride, filtered(950)','Fluoride, unfiltered(951)');

            var TCEQcode=new Array('00010','00095','00300','00400','00480','00600','00630','00665','00666','00900'
            ,'00915','00925','00927','00929','00930','00935','00937','00940','00945','00950','00951');

            var TCEQreservoir=new Array('Bardwell', 'Baylor', 'Belton', 'Benbrook',
            'Bridgeport', 'Buchanan', 'BuffaloSpr', 'Canyon', 'Childress',
            'Choke', 'Corpus', 'Cypress', 'Diversion', 'Eagle', 'Georgetown',
            'Granger', 'Greenbelt', 'Houston', 'HubbardCk', 'Ivie', 'JoePool',
            'Kemp', 'Lewisville', 'Limestone', 'Livingston', 'LkColorado',
            'LkConroe', 'LkGranbury', 'MacKenzie', 'Medina', 'Meredith',
            'Navarro', 'Palestine', 'Patman', 'Pines', 'PossumKing',
            'Proctor', 'Ransom', 'Rayburn', 'RayHubbard', 'RedBluff',
            'Richland-C', 'Roberts', 'Somerville', 'Spence', 'Stillhouse',
            'Sweetwater', 'Tawakoni', 'Texana', 'Texoma', 'Thomas', 'Toledo',
            'Travis', 'TwinButtes', 'Waco', 'White', 'Whitney');

            var USGSparameter=new Array('Temperature(10)',
            'Specific conductance(95)','Dissolved oxygen(300)','pH(400)','Salinity(480)','Total nitrogen, unfiltered(600)',
            'Total nitrogen, filtered(602)','Nitrate plus nitrite(630)','Phosphorus, unfiltered(665)',
            'Phosphorus, filtered(666)','Carbon, unfiltered(690)','Carbon, suspended sediment(694)',
            'Hardness(900)','Noncarbonate hardness, unfiltered(902)','Noncarbonate hardness, filtered(904)',
            'Calcium, unfiltered(910)','Calcium, filtered(915)','Magnesium, filtered(925)','Magnesium, unfiltered(927)',
            'Sodium, unfiltered(929)','Sodium, filtered(930)','Potassium, filtered(935)','Potassium, unfiltered(937)',
            'Chloride, filtered(940)','Sulfate, filtered(945)','Fluoride, filtered(950)','Fluoride, unfiltered(951)',
            'Total nitrogen, filtered(62854)','Total nitrogen, unfiltered(62855)');

            var USGScode=new Array('00010','00095','00300','00400','00480','00600','00602',
            '00630','00665','00666','00690','00694','00900','00902','00904',
            '00910','00915','00925','00927','00929','00930','00935','00937',
            '00940','00945','00950','00951','62854','62855');

            var USGSreservoir=new Array('BuffaloSpr','Canton','	Foss','HubbardCk',
            'Kemp','Keystone','Livingston','LkArlingto',
            'LkColorado','LkConroe','LkGranbury','Meredith','Moss','PossumKing','Spence',
            'Sweetwater','Texana','Texoma','Thunderbir','Whitney');
            var OTHEparameter=new Array('Temperature(10)','Conductance(95)','Dissolved Oxygen(300)',
            'pH, unfiltered(400)','Salinity, unfiltered(480)',
            'Phosphorus,unfiltered(665)','Hardness(900)','Calcium,filtered(915)','Magnesium, Filtered(925)',
            'Magnesium, unfiltered(927)','Sodium, unfiltered(929)','Potassium, unfiltered(937)');

            var OTHEcode=new Array('00010','00095','00300','00400','00480','00665','00900',
            '00915','00925','00927','00929','00937');

            var OTHEreservoir=new Array('HubbardCk','LkGranbury','Whitney','PossumKingdom',
            'Waco','Somerville','Spence','Thomas','LkColoradoCity',
            'Nasworthy','Travis','Ivie','TwinButtes');
            var TCEQUparameter=new Array('Temperature(10)','Specific Conductance(95)','Dissolved Oxygen(300)',
            'pH, unfiltered(400)','Nitrate plus nitrite, unfiltered(630)',
            'Phosphorus,unfiltered(665)','Hardness(900)',
            'Magnesium, unfiltered(927)',
            'Chloride, filtered(940)','Sulfate, filtered(945)');

            var TCEQUcode=new Array('00010','00095','00300','00400','00630','00665','00900'
            ,'00927','00940','00945');

            var TCEQUreservoir=new Array('Bardwell', 'Belton', 'Benbrook',
            'Bridgeport', 'Buchanan', 'BuffaloSpr', 'Canyon', 
            'Choke', 'Corpus', 'Cypress', 'Diversion', 'Eagle', 'Georgetown',
            'Granger', 'Greenbelt', 'Houston', 'HubbardCk', 'Ivie',  'Lewisville', 'Limestone', 'Livingston', 
            'LkConroe', 'LkGranbury', 'MacKenzie', 'Medina', 'Meredith',
            'Navarro',  'Patman', 'Pines', 'PossumKingdom');
            var USGSUparameter=new Array('Temperature(10)',
            'Specific conductance(95)','Dissolved oxygen(300)',
            'Total nitrogen, filtered(602)','Phosphorus, unfiltered(665)',
            'Phosphorus, filtered(666)',
            'Hardness(900)','Noncarbonate hardness, filtered(904)',
            'Calcium, filtered(915)','Magnesium, filtered(925)',
            'Sodium, filtered(930)','Potassium, filtered(935)',
            'Chloride, filtered(940)','Sulfate, filtered(945)','Fluoride, filtered(950)','Total nitrogen, unfiltered(62855)');

            var USGSUcode=new Array('00010','00095','00300','00602',
           '00665','00666','00900','00904',
            '00915','00925','00930','00935',
            '00940','00945','00950','62855');

            var USGSUreservoir=new Array('HubbardCk','LkConroe','Texana','Texoma');


            var ANYparameter=new Array('Temperature(10)',
            'Specific conductance(95)','Dissolved oxygen(300)','pH(400)','Salinity(480)','Total nitrogen, unfiltered(600)',
            'Total nitrogen, filtered(602)','Nitrate plus nitrite(630)','Phosphorus, unfiltered(665)',
            'Phosphorus, filtered(666)','Carbon, unfiltered(690)','Carbon, suspended sediment(694)',
            'Hardness(900)','Noncarbonate hardness, unfiltered(902)','Noncarbonate hardness, filtered(904)',
            'Calcium, unfiltered(910)','Calcium, filtered(915)','Magnesium, filtered(925)','Magnesium, unfiltered(927)',
            'Sodium, unfiltered(929)','Sodium, filtered(930)','Potassium, filtered(935)','Potassium, unfiltered(937)',
            'Chloride, filtered(940)','Sulfate, filtered(945)','Fluoride, filtered(950)','Fluoride, unfiltered(951)',
            'Total nitrogen, filtered(62854)','Total nitrogen, unfiltered(62855)');
            var ANYreservoir=new Array('BuffaloSpr','Canton','Foss'
            ,'HubbardCk','Kemp','Keystone','Livingston','LkArlingto','LkColorado',
            'LkConroe','LkGranbury','Meredith','Moss','PossumKing','PossumKingdom','Spence'
            ,'Sweetwater','Texana','Texoma','Thunderbir','Whitney','Bardwell','Baylor','Belton','Benbrook'
            ,'Bridgeport','Buchanan','Canyon','Childress','Choke','Corpus','Cypress',
            'Diversion','Eagle','Georgetown','Granger','Greenbelt','Houston','Ivie','JoePool',
            'Lewisville','Limestone','MacKenzie','Medina','Navarro','Palestine','Patman','Pines',
            'Proctor','Ransom','Rayburn','RayHubbard','RedBluff','Richland-C','Roberts','Somerville'
            ,'Stillhouse','Tawakoni','Thomas','Toledo','Travis','TwinButtes','Waco','White');

            var ANYcode=new Array('00010','00095','00300','00400','00480','00600','00602',
            '00630','00665','00666','00690','00694','00900','00902','00904',
            '00910','00915','00925','00927','00929','00930','00935','00937',
            '00940','00945','00950','00951','62854','62855');

            var paratemp=new Array("buffalospar","canton");
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
            function ChangeSource(i){
                var form1 = document.getElementById("form1");
                form1.parameter.options.length=0;
                form1.reservoir.options.length=0;
                switch(i)
                {
                    case 1:
                        for (p=0;p<TCEQparameter.length;p++)
                            form1.parameter.options[p]=new Option(TCEQparameter[p],TCEQcode[p]);
                        for (p=0;p<TCEQreservoir.length;p++)
                            form1.reservoir.options[p]=new Option(TCEQreservoir[p]);
                        break;
                    case 2:
                        for (p=0;p<USGSreservoir.length;p++)
                            form1.reservoir.options[p]=new Option(USGSreservoir[p]);
                        for(p=0;p<USGSparameter.length;p++)
                            form1.parameter.options[p]=new Option(USGSparameter[p],USGScode[p]);
                        break;
                    case 3:
                        for (p=0;p<TCEQUparameter.length;p++)
                            form1.parameter.options[p]=new Option(TCEQUparameter[p],TCEQUcode[p]);
                        for (p=0;p<TCEQUreservoir.length;p++)
                            form1.reservoir.options[p]=new Option(TCEQUreservoir[p]);
                        break;
                    case 4:
                        for (p=0;p<USGSUreservoir.length;p++)
                            form1.reservoir.options[p]=new Option(USGSUreservoir[p]);
                        for(p=0;p<USGSUparameter.length;p++)
                            form1.parameter.options[p]=new Option(USGSUparameter[p],USGSUcode[p]);
                        break;
                    case 5:
                        for (p=0;p<OTHEreservoir.length;p++)
                            form1.reservoir.options[p]=new Option(OTHEreservoir[p]);
                        for(p=0;p<OTHEparameter.length;p++)
                            form1.parameter.options[p]=new Option(OTHEparameter[p],OTHEcode[p]);
                        break;
                    case 6:
                        for (p=0;p<ANYparameter.length;p++)
                            form1.parameter.options[p]=new Option(ANYparameter[p],ANYcode[p]);
                        for (p=0;p<ANYreservoir.length;p++)
                            form1.reservoir.options[p]=new Option(ANYreservoir[p]);
                        break;                        
                }
            }

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
        <?php
        $title = "Texas Reservoir Water Data Database";

        $criteria = array('Variable', 'Source', 'Reservoir', 'Date From', 'Date To', 'Depth Range');
        ?>
        <title><? echo $title ?> </title>
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
            <div id="content" >
                <?php
                $para = $criteria[0];
                $sour = $criteria[1];
                $rese = $criteria[2];
                $datef = $criteria[3];
                $datet = $criteria[4];
                $depth = $criteria[5];

                $attributes = array('id' => 'form1');
                echo form_open('basicquery/lowess_result', $attributes);
                ?>
		<p>Lowess Regression:</p>
                <p>Please load the data first:</p>
                <table align="center">
                    <tr>
                        <td>
                            <? echo $sour ?>
                        </td>
                        <td>  <select name='source' onChange="ChangeSource(form.source.selectedIndex);" width="100%">
                                <option value=""></option>
                                <option value='TCEQ'>TCEQ</option>
                                <option value='USGS'>USGS</option>
                               <option value='TCEQU'>TCEQ_UPDATED</option>
                                <option value='USGSU'>USGS_UPDATED</option>
                                <option value='OTHE'>OTHER</option>
                                <option value='ANY'>ALL</option>
                            </select>
                        </td>

                    <tr>
                        <td><? echo $rese ?>
                        </td>
                        <td><select name='reservoir'>
                            </select >
                        </td>

                    </tr>
                    <tr>
                        <td><? echo $para ?>
                        </td>
                        <td> <select name='parameter' >
                            </select>
                        </td>
                    </tr>
                                       <tr>
                        <td> <input type="submit" class="mybutton" value="GO"></td>


                    </tr>
                </table>
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
