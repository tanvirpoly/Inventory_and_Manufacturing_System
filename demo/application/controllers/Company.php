<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends  CI_Controller {

public function __construct()
    {
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index()
    {              
    $data['title'] = 'Company / Warehouse';
    $other = array(
        'order_by' => 'companyID'           
            );            
    $data['companys'] = $this->pm->get_data('companys',false,false,false,$other);
    
    $data['content'] = $this->load->view('companys/companys',$data,TRUE);
    $this->load->view('themes/adminlte', $data);
}

public function SaveCompany()
    {
    $info = $this->input->post(); 

    $cdata = array(
        'companyName'    => $info['companyName'],
        'companycode'    => $info['companycode'],
        'companyPhone'   => $info['companyPhone'],
        'companyEmail'   => $info['companyEmail'],
        'companyAddress' => $info['companyAddress'],    
        'regby'          => $this->session->userdata('admin_id')
            );

    $result = $this->pm->insert_data('companys',$cdata);
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Company add Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Company');
}

public function get_company_data()
    {
    $section = $this->pm->get_company_data($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function update_company()
    {
    $info = $this->input->post();

    $cdata = array(
        'companyName'    => $info['companyName'],
        'companycode'    => $info['companycode'],
        'companyPhone'   => $info['companyPhone'],
        'companyEmail'   => $info['companyEmail'],
        'companyAddress' => $info['companyAddress'],      
        'upby'           => $this->session->userdata('admin_id')
            );

    $where = array(
        'companyID' => $info['comp_id']
            );
    
    $result = $this->pm->update_data('companys',$cdata,$where);             
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Company update Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Company');
}

public function delete_Company($id)
    {
    $where = array(
        'companyID' => $id
            );
    
    $result = $this->pm->delete_data('companys',$where);             
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Company delete Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Company');
}





}