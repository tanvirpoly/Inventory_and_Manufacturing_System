<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AccessLavels extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("prime_model","pm");        
        $this->checkPermission(); 
    }

public function index()
    {
    $data['title'] = 'User Role';

    $data['role'] = $this->pm->get_data('access_lavels',false);

    $data['content'] = $this->load->view('accessLavel/accessLavels',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function SaveAccessLavel()
    {
    $info = $this->input->post();

    $urole = array(
        'lavelName'        => $info['lavelName'],
        'lavelDiscription' => $info['lavelDiscription'],
        'status'           => $info['status'],
        'createdBy'        => $this->session->userdata('admin_id')
            );
   
    $result = $this->pm->insert_data('access_lavels',$urole);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>User role add Successfully !</h4>
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
    redirect('AccessLavels');
}

public function get_user_role_data()
    {
    $section = $this->pm->get_user_role_data($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function update_user_role()
    {
    $info = $this->input->post();

    $where = array(
        'accessLavelId' => $info['roleid']
            );

    $urole = array(
        'lavelName'        => $info['lavelName'],
        'lavelDiscription' => $info['lavelDiscription'],
        'status'           => $info['status'],
        'updatedBy'        => $this->session->userdata('admin_id')
            );
   //var_dump($where,$urole); exit();
    $result = $this->pm->update_data('access_lavels',$urole,$where);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>User role update Successfully !</h4>
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
    redirect('AccessLavels');
}

public function delete_user_role($id)
    {
    $uwhere = array(
        'role' => $id
            );
    $auser = $this->pm->get_data('users',$uwhere);
    $data['auser'] = $auser[0];

    if ($auser[0] == null)
        {
        $where = array(
            'accessLavelId' => $id
                );
       
        $result = $this->pm->delete_data('access_lavels',$where);

        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i>User role delete Successfully !</h4>
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
        }
    else
        {
        $sdata = [
            'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> All ready add this user role in user !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('AccessLavels');
}





}
