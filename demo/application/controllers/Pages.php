<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller{

public function __construct()
    {
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index(){
    $data['title'] = 'Pages';

    $data['pages'] = $this->pm->get_data('pages',false);

    $data['content'] = $this->load->view('pages/pages',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function AddPage($id = null)
    {
    $data['title'] = 'Pages';

    if($id != null)
        {           
        $awhere = array(
            'pageId' => $id
                );

        $pages = $this->pm->get_data('pages',$awhere);
        $data['page'] = $pages[0];           
        }
    else
        {    
        }

    $data['content'] = $this->load->view('pages/addPage',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function SavePage()
    {
    $table = 'pages';
    $info = $this->input->post();

    if($this->input->post('pageId'))
        {
        $pageId = $info['pageId'];

        //unset($info['mysubmit']);
        unset($info['pageId']); 

        $where = array(
            'pageId' => $pageId
                );

        $update = $this->pm->update_data($table,$info,$where);
        
        if($update)
            {
            $this->session->set_flashdata('msg','Successfully Updated Page');
            }
        }
    else
        {
        //unset($info['mysubmit']);

        $insert = $this->pm->insert_data($table,$info);

        if($insert)
            {
            $this->session->set_flashdata('msg','Successfully Inserted Page');
            }
        }
   redirect('Pages');
}





}