<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noaccess extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("prime_model",'pm');       
    }

   public function index() {
        $data['page_name'] = 'No Access';
        $data['output']=$this->load->view('noAccess', $data,true);
        $this->load->view('themes/blank',$data);
    }

  
}
