<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php

class Basicquery extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Mquery');
        $this->load->library("pagination");
    }

    function Basicquery() {
        parent::CI_Controller();
    }

    function select_descriptive() {
        $this->load->view('descriptive_query_view');
    }
    function select_lowess() {
        $this->load->view('lowess_query_view');
    }
	
    function desorcom(){
	$this->load->view('desorcom');	
    }

    function options() {
        $this->load->view('query_options');
    }
    function select_quality() {
        $this->load->view('quality_query_view');
    }
    function select_quantity() {
        $this->load->view('quantity_query_view');
    }
   
    function quantity_result(){
    $SHORTNAME = $this->input->post('shortname');
	$DATE_FROM = $this->input->post('datefrom');
        $DATE_TO = $this->input->post('dateto');
	$MaxDate = "01/01/2013";
        $MinDate = "01/01/1940";
        if ($DATE_FROM == NULL)
            $DATE_FROM = $MinDate;
        if ($DATE_TO == NULL)
            $DATE_TO = $MaxDate;
    //$prename = array();
    $prename =array("Arlington","Bardwell","Belton","Benbrook","Bridgeport","Buchanan","Canton","Canyon","Choke","Corpus","Cypress","Eagle"
			,"Foss","Georgetown","Granger","Greenbelt","Houston","HubbardCk","Ivie","JoePool","Lewisville","Limestone","Livingston"
			,"LkColoradoCity","LkConroe","LkGranbury","MacKenzie","Medina","Meredith","Navarro","Palestine","Patman","Pines","PssumKingdom","Proctor",
"Rayburn","RayHubbard","Red","Richland-Chamb","Roberts","Somerville","Spence","Stillhouse","Tawakoni","Texana","Thomas","Toledo","Travis","TwinButtes","Waco"
			,"White","Whitney");
	$STORAGEONE="STORAGEONE";
	$STORAGETWO="STORAGETWO";
    if($SHORTNAME>29){
	$query_sql="SELECT * FROM {$STORAGETWO} WHERE SHORTNAME='{$prename[$SHORTNAME]}'AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
     }
	else{
		$query_sql="SELECT * FROM {$STORAGEONE} WHERE SHORTNAME='{$prename[$SHORTNAME]}'AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
	}
		$data['query_storage'] = $this->Mquery->select($query_sql);
		$query_result=$data['query_storage']->result_array();
		$data['num_storage'] =count($query_result);         
		$output = $this->load->view('quantity_query_result', $data, true);
            $this->output->set_output($output);

    }
    function quality_result() {
	$DATE_FROM = $this->input->post('datefrom');
        $DATE_TO = $this->input->post('dateto');
        $SOURCE = $this->input->post('source');
	$MaxDate = "01/01/2013";
        $MinDate = "01/01/1940";
        if ($DATE_FROM == NULL)
            $DATE_FROM = $MinDate;
        if ($DATE_TO == NULL)
            $DATE_TO = $MaxDate;
        $MinDepth = 0.0;
        $MaxDepth = 10000.0;
        $LDEPTH = floatval($this->input->post('ldepth'));
        $HDEPTH = floatval($this->input->post('hdepth'));
        if ($this->input->post('ldepth') == NULL)
            $LDEPTH = $MinDepth;
        if ($this->input->post('hdepth') == NULL)
            $HDEPTH = $MaxDepth;
        if ($LDEPTH >= $HDEPTH) {
            $TEMP = $LDEPTH;
            $LDEPTH = $HDEPTH;
            $HDEPTH = $TEMP;
        }
        $unit = $this->input->post('unit');
        $HDEPTH*=$unit;
        $LDEPTH*=$unit;
        $PARAMETER = $this->input->post('parameter');
        if ($PARAMETER != null) {
            $sql = "SELECT * FROM PARAMETER WHERE CODE={$PARAMETER}";
            $PARADETAIL = $this->Mquery->select($sql);
            $data['PARADETAIL'] = $PARADETAIL;
            $this->session->set_userdata('paradetail', $PARADETAIL);
        }
        $TCEQ = "TCEQ";
        $USGS = "USGS";
        $OTHE = "OTHE";
	$TCEQU = "TCEQU";
        $USGSU = "USGSU";
        if ($SOURCE == 'TCEQ' || $SOURCE == 'USGS' || $SOURCE == 'OTHE'||$SOURCE =='TCEQU'||$SOURCE == 'USGSU')
            $TABLENAME = $SOURCE . $PARAMETER;
        if ($SOURCE == 'ANY') {
            $TABLENAMEOTHE = $OTHE . $PARAMETER;
            $TABLENAMETCEQ = $TCEQ . $PARAMETER;
            $TABLENAMEUSGS = $USGS . $PARAMETER;
	    $TABLENAMETCEQU = $TCEQU . $PARAMETER;
            $TABLENAMEUSGSU = $USGSU . $PARAMETER;
            $sql = "show tables like '{$TABLENAMETCEQ}'";
            $TTCEQ = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEUSGS}'";
            $TUSGS = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEOTHE}'";
            $TOTHE = $this->Mquery->select($sql)->num_rows();
	    $sql = "show tables like '{$TABLENAMETCEQU}'";
            $TTCEQU = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEUSGSU}'";
            $TUSGSU = $this->Mquery->select($sql)->num_rows();
        }
        $SHORTNAME = $this->input->post('reservoir');

        $quer_tceq = null;
        $quer_usgs = null;
        $quer_tcequ = null;
        $quer_usgsu = null;
        $quer_othe = null;
        $data['unitname'] = "Ft";
        if ($SOURCE == 'TCEQ') {
            $quer_tceq = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND
		DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'USGS') {
            $quer_usgs = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'OTHE') {
            $quer_othe = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
	
        } else if($SOURCE == 'USGSU') {
            $quer_usgsu = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        }else if($SOURCE == 'TCEQU') {
            $quer_tcequ = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND
		DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        }
	 else if ($SOURCE == 'ANY') {
            if ($TTCEQ > 0) {
                $quer_tceq = "SELECT * FROM {$TABLENAMETCEQ} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND  DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TUSGS > 0) {
                $quer_usgs = "SELECT * FROM {$TABLENAMEUSGS} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TOTHE > 0) {
                $quer_othe = "SELECT * FROM {$TABLENAMEOTHE} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TTCEQU > 0) {
                $quer_tcequ = "SELECT * FROM {$TABLENAMETCEQU} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND  DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TUSGSU > 0) {
                $quer_usgsu = "SELECT * FROM {$TABLENAMEUSGSU} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } 
        }
        if ($SOURCE != null && $PARAMETER != null && $SHORTNAME != null) {

            //do the query
            if ($SOURCE != 'ANY') {
                if ($quer_tceq != null) {
                    $data['query_tceq'] = $this->Mquery->select($quer_tceq);
                    $query_result = $data['query_tceq']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'tceq');
                    $data['query_usgs']=null;
		    $data['query_usgsu']=null;
		    $data['query_tcequ']=null;
                    $data['query_othe']=null;
                    $data['num_tceq']=count($query_result);
                    $data['num_usgs']=0;
                    $data['num_othe']=0;
                    $data['num_usgsu']=0;
                    $data['num_tcequ']=0;
                }
                if ($quer_usgs != null) {
                    $data['query_usgs'] = $this->Mquery->select($quer_usgs);
                    $query_result = $data['query_usgs']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'usgs');
                    $data['num_tceq']=0;
			$data['num_tcequ']=0;
			$data['num_usgsu']=0;
                    $data['num_othe']=0;
                    $data['num_usgs']=count($query_result);
                    $data['query_tceq']=null;
                    $data['query_othe']=null;
		    $data['query_usgsu']=null;
		    $data['query_tcequ']=null;
                }
                if ($quer_othe != null) {
                    $data['query_othe'] = $this->Mquery->select($quer_othe);
                    $query_result = $data['query_othe']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'othe');
                    $data['num_tceq']=0;
                    $data['num_usgs']=0;
		    $data['num_tcequ']=0;
                    $data['num_usgsu']=0;
                    $data['num_othe']=count($query_result);
                    $data['query_tceq']=null;
                    $data['query_usgs']=null;
		    $data['query_usgsu']=null;
		    $data['query_tcequ']=null;
                }
		                if ($quer_tcequ != null) {
                    $data['query_tcequ'] = $this->Mquery->select($quer_tcequ);
                    $query_result = $data['query_tcequ']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'tcequ');
                    $data['query_usgs']=null;
		    $data['query_usgsu']=null;
		    $data['query_tceq']=null;
                    $data['query_othe']=null;
                    $data['num_tcequ']=count($query_result);
		    $data['num_tceq']=0;
                    $data['num_usgs']=0;
 		    $data['num_usgsu']=0;
                    $data['num_othe']=0;
                }
                if ($quer_usgsu != null) {
                    $data['query_usgsu'] = $this->Mquery->select($quer_usgsu);
                    $query_result = $data['query_usgsu']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'usgsu');
                    $data['num_tceq']=0;
                    $data['num_othe']=0;
		    $data['num_usgs']=0;
		    $data['num_tcequ']=0;
                    $data['num_usgsu']=count($query_result);
                    $data['query_tceq']=null;			
                    $data['query_othe']=null;
		    $data['query_usgs']=null;
		    $data['query_tcequ']=null;
                }
            } else if ($SOURCE == 'ANY') {
                    $data['num_tceq']=0;
                    $data['num_usgs']=0;
	                    $data['num_tcequ']=0;
                    $data['num_usgsu']=0;
                    $data['num_othe']=0;
                    $data['num_othe']=null;
                    $data['query_tceq']=null;
                    $data['query_usgs']=null;
			                    $data['query_tcequ']=null;
                    $data['query_usgsu']=null;
                if ($quer_tceq != null) {
                    $data['query_tceq'] = $this->Mquery->select($quer_tceq);
                    $query_result = $data['query_tceq']->result_array();
                    $this->session->set_userdata('myquery_result_tceq', $query_result);
                    $data['num_tceq']=count($query_result);

                }
                if ($quer_usgs != null) {
                    $data['query_usgs'] = $this->Mquery->select($quer_usgs);
                    $query_result = $data['query_usgs']->result_array();
                    $this->session->set_userdata('myquery_result_usgs', $query_result);
                    $data['num_usgs']=count($query_result);
                }
                if ($quer_othe != null) {
                    $data['query_othe'] = $this->Mquery->select($quer_othe);
                    $query_result = $data['query_othe']->result_array();
                    $this->session->set_userdata('myquery_result_othe', $query_result);
                    $data['num_othe']=count($query_result);
                }
		                if ($quer_tcequ != null) {
                    $data['query_tcequ'] = $this->Mquery->select($quer_tcequ);
                    $query_result = $data['query_tcequ']->result_array();
                    $this->session->set_userdata('myquery_result_tcequ', $query_result);
                    $data['num_tcequ']=count($query_result);

                }
                if ($quer_usgsu != null) {
                    $data['query_usgsu'] = $this->Mquery->select($quer_usgsu);
                    $query_result = $data['query_usgsu']->result_array();
                    $this->session->set_userdata('myquery_result_usgsu', $query_result);
                    $data['num_usgsu']=count($query_result);
                }
                $this->session->set_userdata('sourcetag', 'ALL');
            }

            $data['QPara'] = $PARAMETER;
            $output = $this->load->view('quality_query_result', $data, true);
            $this->output->set_output($output);
        } else {
            $data['query_tceq'] = null;
            $data['query_usgs'] = null;
	    $data['query_tcequ'] = null;
            $data['query_usgsu'] = null;
            $data['query_othe'] = null;
            $data['num_tceq']=0;
            $data['num_usgs']=0;
            $data['num_othe']=0;
            $data['QPara'] = null;
            $output = $this->load->view('quality_query_result', $data, true);
            $this->output->set_output($output);
        }
    }

    function descriptive_result() {
        $this->session->set_userdata('myquery_result_usgs',null);
        $this->session->set_userdata('myquery_result_tceq',null);
        $this->session->set_userdata('myquery_result_othe',null);
	$this->session->set_userdata('myquery_result_usgsu',null);
        $this->session->set_userdata('myquery_result_tcequ',null);
	$DATE_FROM = $this->input->post('datefrom');
        $DATE_TO = $this->input->post('dateto');
        $SOURCE = $this->input->post('source');
	$MaxDate = "01/01/2013";
        $MinDate = "01/01/1940";
        if ($DATE_FROM == NULL)
            $DATE_FROM = $MinDate;
        if ($DATE_TO == NULL)
            $DATE_TO = $MaxDate;
        $MinDepth = 0.0;
        $MaxDepth = 10000.0;
        $LDEPTH = floatval($this->input->post('ldepth'));
        $HDEPTH = floatval($this->input->post('hdepth'));
        if ($this->input->post('ldepth') == NULL)
            $LDEPTH = $MinDepth;
        if ($this->input->post('hdepth') == NULL)
            $HDEPTH = $MaxDepth;
        if ($LDEPTH >= $HDEPTH) {
            $TEMP = $LDEPTH;
            $LDEPTH = $HDEPTH;
            $HDEPTH = $TEMP;
        }
        $unit = $this->input->post('unit');
        $HDEPTH*=$unit;
        $LDEPTH*=$unit;
        $PARAMETER = $this->input->post('parameter');
        if ($PARAMETER != null) {
            $sql = "SELECT * FROM PARAMETER WHERE CODE={$PARAMETER}";
            $PARADETAIL = $this->Mquery->select($sql);
            $data['PARADETAIL'] = $PARADETAIL;
            $this->session->set_userdata('paradetail', $PARADETAIL);
        }
        $TCEQ = "TCEQ";
        $USGS = "USGS";
        $OTHE = "OTHE";
	$TCEQU = "TCEQU";
        $USGSU = "USGSU";
        if ($SOURCE == 'TCEQ' || $SOURCE == 'USGS' || $SOURCE == 'OTHE'||$SOURCE =='TCEQU'||$SOURCE == 'USGSU')
            $TABLENAME = $SOURCE . $PARAMETER;
        if ($SOURCE == 'ANY') {
            $TABLENAMEOTHE = $OTHE . $PARAMETER;
            $TABLENAMETCEQ = $TCEQ . $PARAMETER;
            $TABLENAMEUSGS = $USGS . $PARAMETER;
	    $TABLENAMETCEQU = $TCEQU . $PARAMETER;
            $TABLENAMEUSGSU = $USGSU . $PARAMETER;
            $sql = "show tables like '{$TABLENAMETCEQ}'";
            $TTCEQ = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEUSGS}'";
            $TUSGS = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEOTHE}'";
            $TOTHE = $this->Mquery->select($sql)->num_rows();
	    $sql = "show tables like '{$TABLENAMETCEQU}'";
            $TTCEQU = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEUSGSU}'";
            $TUSGSU = $this->Mquery->select($sql)->num_rows();
        }
        $SHORTNAME = $this->input->post('reservoir');

        $quer_tceq = null;
        $quer_usgs = null;
	$quer_tcequ = null;
        $quer_usgsu = null;
        $quer_othe = null;
        $data['unitname'] = "Ft";
        if ($SOURCE == 'TCEQ') {
            $quer_tceq = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND
		DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'USGS') {
            $quer_usgs = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'OTHE') {
            $quer_othe = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
	
        } else if($SOURCE == 'USGSU') {
            $quer_usgsu = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        }else if($SOURCE == 'TCEQU') {
            $quer_tcequ = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND
		DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        }
	 else if ($SOURCE == 'ANY') {
            if ($TTCEQ > 0) {
                $quer_tceq = "SELECT * FROM {$TABLENAMETCEQ} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND  DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TUSGS > 0) {
                $quer_usgs = "SELECT * FROM {$TABLENAMEUSGS} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TOTHE > 0) {
                $quer_othe = "SELECT * FROM {$TABLENAMEOTHE} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TTCEQU > 0) {
                $quer_tcequ = "SELECT * FROM {$TABLENAMETCEQU} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND  DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TUSGSU > 0) {
                $quer_usgsu = "SELECT * FROM {$TABLENAMEUSGSU} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' AND
                STR_TO_DATE('{$DATE_FROM}','%m/%d/%Y')<=STR_TO_DATE(DATE,'%m/%d/%Y' )AND
                STR_TO_DATE( DATE,  '%m/%d/%Y' )<=STR_TO_DATE('{$DATE_TO}','%m/%d/%Y') order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } 
        }
        if ($SOURCE != null && $PARAMETER != null && $SHORTNAME != null) {

            //do the query
            if ($SOURCE != 'ANY') {
                if ($quer_tceq != null) {
                    $data['query_tceq'] = $this->Mquery->select($quer_tceq);
                    $query_result = $data['query_tceq']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'tceq');
                    $data['query_usgs']=null;
		    $data['query_usgsu']=null;
		    $data['query_tcequ']=null;
                    $data['query_othe']=null;
                    $data['num_tceq']=count($query_result);
                    $data['num_usgs']=0;
                    $data['num_othe']=0;
                    $data['num_usgsu']=0;
                    $data['num_tcequ']=0;
                }
                else if ($quer_usgs != null) {
                    $data['query_usgs'] = $this->Mquery->select($quer_usgs);
                    $query_result = $data['query_usgs']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'usgs');
                    $data['num_tceq']=0;
			$data['num_tcequ']=0;
			$data['num_usgsu']=0;
                    $data['num_othe']=0;
                    $data['num_usgs']=count($query_result);
                    $data['query_tceq']=null;
                    $data['query_othe']=null;
		    $data['query_usgsu']=null;
		    $data['query_tcequ']=null;
                }
                else if ($quer_othe != null) {
                    $data['query_othe'] = $this->Mquery->select($quer_othe);
                    $query_result = $data['query_othe']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'othe');
                    $data['num_tceq']=0;
                    $data['num_usgs']=0;
		    $data['num_tcequ']=0;
                    $data['num_usgsu']=0;
                    $data['num_othe']=count($query_result);
                    $data['query_tceq']=null;
                    $data['query_usgs']=null;
		    $data['query_usgsu']=null;
		    $data['query_tcequ']=null;
                }
		else if ($quer_tcequ != null) {
                    $data['query_tcequ'] = $this->Mquery->select($quer_tcequ);
                    $query_result = $data['query_tcequ']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'tcequ');
                    $data['query_usgs']=null;
		    $data['query_usgsu']=null;
		    $data['query_tceq']=null;
                    $data['query_othe']=null;
                    $data['num_tcequ']=count($query_result);
		    $data['num_tceq']=0;
                    $data['num_usgs']=0;
 		    $data['num_usgsu']=0;
                    $data['num_othe']=0;
                }
                else if ($quer_usgsu != null) {
                    $data['query_usgsu'] = $this->Mquery->select($quer_usgsu);
                    $query_result = $data['query_usgsu']->result_array();
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'usgsu');
                    $data['num_tceq']=0;
                    $data['num_othe']=0;
		    $data['num_usgs']=0;
		    $data['num_tcequ']=0;
                    $data['num_usgsu']=count($query_result);
                    $data['query_tceq']=null;			
                    $data['query_othe']=null;
		    $data['query_usgs']=null;
		    $data['query_tcequ']=null;
                }
            } else if ($SOURCE == 'ANY') {
                    $data['num_tceq']=0;
                    $data['num_usgs']=0;
	            $data['num_tcequ']=0;
                    $data['num_usgsu']=0;
                    $data['num_othe']=0;
                    $data['num_othe']=null;
                    $data['query_tceq']=null;
                    $data['query_usgs']=null;
	            $data['query_tcequ']=null;
                    $data['query_usgsu']=null;
                if ($quer_tceq != null) {
                    $data['query_tceq'] = $this->Mquery->select($quer_tceq);
                    $query_result = $data['query_tceq']->result_array();
                    $this->session->set_userdata('myquery_result_tceq', $query_result);
                    $data['num_tceq']=count($query_result);

                }
                if ($quer_usgs != null) {
                    $data['query_usgs'] = $this->Mquery->select($quer_usgs);
                    $query_result = $data['query_usgs']->result_array();
                    $this->session->set_userdata('myquery_result_usgs', $query_result);
                    $data['num_usgs']=count($query_result);
                }
                if ($quer_othe != null) {
                    $data['query_othe'] = $this->Mquery->select($quer_othe);
                    $query_result = $data['query_othe']->result_array();
                    $this->session->set_userdata('myquery_result_othe', $query_result);
                    $data['num_othe']=count($query_result);
                }
		if ($quer_tcequ != null) {
                    $data['query_tcequ'] = $this->Mquery->select($quer_tcequ);
                    $query_result = $data['query_tcequ']->result_array();
                    $this->session->set_userdata('myquery_result_tcequ', $query_result);
                    $data['num_tcequ']=count($query_result);

                }
                if ($quer_usgsu != null) {
                    $data['query_usgsu'] = $this->Mquery->select($quer_usgsu);
                    $query_result = $data['query_usgsu']->result_array();
                    $this->session->set_userdata('myquery_result_usgsu', $query_result);
                    $data['num_usgsu']=count($query_result);
                }
                $this->session->set_userdata('sourcetag', 'ALL');
            }

            $data['QPara'] = $PARAMETER;
            $output = $this->load->view('descriptive_query_result', $data, true);
            $this->output->set_output($output);
        } else {
            $data['query_tceq'] = null;
            $data['query_usgs'] = null;
	    $data['query_tcequ'] = null;
            $data['query_usgsu'] = null;
            $data['query_othe'] = null;
            $data['num_tceq']=0;
            $data['num_usgs']=0;
            $data['num_othe']=0;
            $data['QPara'] = null;
            $output = $this->load->view('descriptive_query_result', $data, true);
            $this->output->set_output($output);
        }
    }

    
    function lowess_result(){
	$this->session->unset_userdata('myquery_ava');
        $this->session->unset_userdata('myquery_result_usgs');
        $this->session->unset_userdata('myquery_result_tceq');
        $this->session->unset_userdata('myquery_result_othe');
		$this->session->unset_userdata('myquery_result_usgsu');
        $this->session->unset_userdata('myquery_result_tcequ');
        $this->session->unset_userdata('sourcetag');
	$SOURCE = $this->input->post('source');
        $MinDepth = 0.0;
                            
        $MaxDepth = 1000.0;
	$LDEPTH=$MinDepth;
	$HDEPTH=$MaxDepth;

        $PARAMETER = $this->input->post('parameter');
        if ($PARAMETER != null) {
            $sql = "SELECT * FROM PARAMETER WHERE CODE={$PARAMETER}";
            $PARADETAIL = $this->Mquery->select($sql);
            $data['PARADETAIL'] = $PARADETAIL;
            $this->session->set_userdata('paradetail', $PARADETAIL);
        }
        $TCEQ = "TCEQ";
        $USGS = "USGS";
        $OTHE = "OTHE";
	$TCEQU = "TCEQU";
        $USGSU = "USGSU";
        if ($SOURCE == 'TCEQ' || $SOURCE == 'USGS' || $SOURCE == 'OTHE'||$SOURCE =='TCEQU'||$SOURCE == 'USGSU')
            $TABLENAME = $SOURCE . $PARAMETER;
        if ($SOURCE == 'ANY') {
            $TABLENAMEOTHE = $OTHE . $PARAMETER;
            $TABLENAMETCEQ = $TCEQ . $PARAMETER;
            $TABLENAMEUSGS = $USGS . $PARAMETER;
	    $TABLENAMETCEQU = $TCEQU . $PARAMETER;
            $TABLENAMEUSGSU = $USGSU . $PARAMETER;
            $sql = "show tables like '{$TABLENAMETCEQ}'";
            $TTCEQ = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEUSGS}'";
            $TUSGS = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEOTHE}'";
            $TOTHE = $this->Mquery->select($sql)->num_rows();
	    $sql = "show tables like '{$TABLENAMETCEQU}'";
            $TTCEQU = $this->Mquery->select($sql)->num_rows();
            $sql = "show tables like '{$TABLENAMEUSGSU}'";
            $TUSGSU = $this->Mquery->select($sql)->num_rows();
        }
        $SHORTNAME = $this->input->post('reservoir');

        $quer_tceq = null;
        $quer_usgs = null;
        $quer_tcequ = null;
        $quer_usgsu = null;
        $quer_othe = null;
        $data['unitname'] = "Ft";
        if ($SOURCE == 'TCEQ' ) {
            $quer_tceq = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND
		DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'USGS') {
            $quer_usgs = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'OTHE') {
            $quer_othe = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else  if ($SOURCE == 'TCEQU' ) {
            $quer_tcequ = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND
		DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'USGSU') {
            $quer_usgsu = "SELECT * FROM {$TABLENAME} WHERE SHORTNAME='{$SHORTNAME}'AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
        } else if ($SOURCE == 'ANY') {
            if ($TTCEQ > 0) {
                $quer_tceq = "SELECT * FROM {$TABLENAMETCEQ} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND  DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TUSGS > 0) {
                $quer_usgs = "SELECT * FROM {$TABLENAMEUSGS} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TOTHE > 0) {
                $quer_othe = "SELECT * FROM {$TABLENAMEOTHE} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TTCEQU > 0) {
                $quer_tcequ = "SELECT * FROM {$TABLENAMETCEQU} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND  DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            } if ($TUSGSU > 0) {
                $quer_usgsu = "SELECT * FROM {$TABLENAMEUSGSU} WHERE SHORTNAME='{$SHORTNAME}' AND DEPTH<={$HDEPTH} AND
		DEPTH>={$LDEPTH} AND DEPTH<>'NA' order by STR_TO_DATE(DATE,'%m/%d/%Y' )";
            }
        }
	    $data['query_tceq'] = null;
            $data['query_usgs'] = null;
	    $data['query_tcequ'] = null;
            $data['query_usgsu'] = null;
            $data['query_othe'] = null;
            $data['num_tceq']=0;
            $data['num_usgs']=0;
            $data['num_tcequ']=0;
            $data['num_usgsu']=0;
            $data['num_othe']=0;
            $data['QPara'] = null;       
	    $this->session->set_userdata('myquery_result', null);
            $this->session->set_userdata('sourcetag', null);

            //do the query
            if ($SOURCE != 'ANY') {
                if ($quer_tceq != null) {
                    $data['query_tceq'] = $this->Mquery->select($quer_tceq);
                    $query_result = $data['query_tceq']->result_array();
                    if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'tceq');
                    $data['num_tceq']=count($query_result);
                    }
		   else 
			{
			 $data['query_tceq']=null;
			}
                }
                if ($quer_usgs != null) {
                    $data['query_usgs'] = $this->Mquery->select($quer_usgs);
                    $query_result = $data['query_usgs']->result_array();
                    if(count($query_result)>0){
		    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'usgs');
                    $data['num_usgs']=count($query_result);
		    }
                    else
                    {
                        $data['query_usgs']=null;
                    }

                    }
		if ($quer_tcequ != null) {
                    $data['query_tcequ'] = $this->Mquery->select($quer_tcequ);
                    $query_result = $data['query_tcequ']->result_array();
                    if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'tcequ');
                    $data['num_tcequ']=count($query_result);
                    }
		   else 
			{
			 $data['query_tcequ']=null;
			}
                }
                if ($quer_usgsu != null) {
                    $data['query_usgsu'] = $this->Mquery->select($quer_usgsu);
                    $query_result = $data['query_usgsu']->result_array();
                    if(count($query_result)>0){
		    $this->session->set_userdata('myquery_result', $query_result);
                    $this->session->set_userdata('sourcetag', 'usgsu');
                    $data['num_usgsu']=count($query_result);
		    }
                    else
                    {
                        $data['query_usgsu']=null;
                    }

                    }
                if ($quer_othe != null) {
                    $data['query_othe'] = $this->Mquery->select($quer_othe);
                    $query_result = $data['query_othe']->result_array();
                    if(count($query_result)>0){
			$this->session->set_userdata('myquery_result', $query_result);
                        $this->session->set_userdata('sourcetag', 'othe');
                        $data['num_othe']=count($query_result);
                   }
                   else
                   {
                        $data['query_othe']=null;
                   }

		   }
            } else if ($SOURCE == 'ANY') {
		   $this->session->set_userdata('myquery_result_tceq', null);
		   $this->session->set_userdata('myquery_result_usgs', null);
		   $this->session->set_userdata('myquery_result_tcequ', null);
		   $this->session->set_userdata('myquery_result_usgsu', null);
	     	   $this->session->set_userdata('myquery_result_othe', null);
                   if ($quer_tceq != null) {
                    $data['query_tceq'] = $this->Mquery->select($quer_tceq);
                    $query_result = $data['query_tceq']->result_array();
		     if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result_tceq', $query_result);
                    $data['num_tceq']=count($query_result);
		    }
                   else
                        {
                         $data['query_tceq']=null;
                        }

    	            }
                    if ($quer_usgs != null) {
                    $data['query_usgs'] = $this->Mquery->select($quer_usgs);
                    $query_result = $data['query_usgs']->result_array();
		     if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result_usgs', $query_result);
                    $data['num_usgs']=count($query_result);
		    }
                   else
                        {
                         $data['query_usgs']=null;
                        }

                    }
 		   if ($quer_tcequ != null) {
                    $data['query_tcequ'] = $this->Mquery->select($quer_tcequ);
                    $query_result = $data['query_tcequ']->result_array();
		     if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result_tcequ', $query_result);
                    $data['num_tcequ']=count($query_result);
		    }
                   else
                        {
                         $data['query_tcequ']=null;
                        }

    	            }
                    if ($quer_usgsu != null) {
                    $data['query_usgsu'] = $this->Mquery->select($quer_usgsu);
                    $query_result = $data['query_usgsu']->result_array();
		     if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result_usgsu', $query_result);
                    $data['num_usgsu']=count($query_result);
		    }
                   else
                        {
                         $data['query_usgsu']=null;
                        }

                    }
                    if ($quer_othe != null) {
                    $data['query_othe'] = $this->Mquery->select($quer_othe);
                    $query_result = $data['query_othe']->result_array();
		     if(count($query_result)>0){
                    $this->session->set_userdata('myquery_result_othe', $query_result);
                    $data['num_othe']=count($query_result);
		    }
                   else
                        {
                         $data['query_othe']=null;
                        }

                    }
                $this->session->set_userdata('sourcetag', 'ALL');
            }

            $data['QPara'] = $PARAMETER;

	    $output = $this->load->view('lowess_query_result',$data,true);

            $this->output->set_output($output);


}

}
?>
