<?php
class Query extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Mquery');
    }

    function Query() {
        parent::CI_Controller();
    }

    function index() {
        $this->load->helper(array('form', 'url'));
        $this->load->view('homepage');
    }

    function select() {
        $this->load-view('welcome_message');
    }

    function save2() {
        global $data;
        $data['query'] = unserialize($this->input->post('save_result'));
        //$output = $this->load->view('test_query_view', $data, true);
        $this->load->view('save_view', $data);
        //$this->output->set_output($output);
    }

    function test() {
        $this->load->view('welcome_message');
    }

    function statistics() {
        $this->load->view('statistics_view', $data);
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 *  $data['title'] = "Texas Reservoir Water Quality Database";
  $data['head'] = "Query Section";
  //$data['criteria'] = array('Variable', 'source', 'reservoir',
  //     'Date From', 'Date To', 'Depth');
  $data['criteria'] = array('Variable', 'Source', 'Reservoir',
  'Date From', 'Date To', 'Depth');
  $data['reservoir'] = array('Bardwell', 'Baylor', 'Belton', 'Benbrook',
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

  //$data['query'] = array();
  $data['test'] = "1";
 */
?>
