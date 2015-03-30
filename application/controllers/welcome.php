<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Mquery');
    }

    function welcome() {
        parent::CI_Controller();
    }

    public function document() {
        $this->load->view('documentation');
    }

    public function userguide() {
        $this->load->view('userguide');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
