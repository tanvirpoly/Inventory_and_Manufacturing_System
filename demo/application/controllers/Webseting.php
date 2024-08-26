<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Webseting extends CI_Controller{

public function __construct()
  {
  parent::__construct();       
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}


public function page_setting_list()
  {
  $data['title'] = 'About Us';
  
  $where = [
    'psid' => 1
        ];

  $data['pageSetup'] = $this->pm->get_data('page_setting',$where);

  $this->load->view('webseting/page_setting',$data);
}

public function save_page_setting()
  {
  $info = $this->input->post();

  $data = [
    'pName'    => $info['pName'],
    'pContent' => $info['pContent'],
    'regby'    => $_SESSION['uid']
        ];
    //var_dump($data); exit();
    
  $where = [
    'psid' => 1
        ];

  $aboutus = $this->pm->get_data('page_setting',$where);
  if($aboutus)
    {
    $result = $this->pm->update_data('page_setting',$data,$where);
    }
  else
    {
    $result = $this->pm->insert_data('page_setting',$data);
    }
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Page Setting add Successfully !</h4></div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('pageSetting');
}

public function get_page_setting_data()
  {
  $section = $this->pm->get_page_setting_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_page_setting()
  {
  $info = $this->input->post();

  $where = [
    'psid' => $info['psid']
        ];

  $data = [
    'pName'    => $info['pName'],
    'pContent' => $info['pContent'],
    'status'   => $info['status'],
    'upby'     => $_SESSION['uid']
        ];
    //var_dump($data); exit();
       
  $result = $this->pm->update_data('page_setting',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Page Setting update Successfully !</h4></div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('pageSetting');
}

public function delete_page_setting($id)
  {
  $where = [
    'psid' => $id
        ];
       
  $result = $this->pm->delete_data('page_setting',$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Page Setting delete Successfully !</h4></div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('pageSetting');
}






}