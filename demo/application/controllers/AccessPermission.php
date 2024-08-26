<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AccessPermission extends CI_Controller {

public function __construct() {
    parent::__construct();    
    $this->load->model("prime_model", "pm");
    $this->checkPermission();
}

public function index()
    {
    $data['title'] = 'Access Permission';

    $accessLavels = $this->pm->get_data('access_lavels',false);

    foreach ($accessLavels as $key => $value)
        {
        $where = array(
            'accessLavel' => $value['accessLavelId']
                );
        $field = array(
            'page_access_relationship' => 'page_access_relationship.*',
            'pages' => 'pages.pageName'
                );
        $join = array(
            'pages' => 'pages.pageId = page_access_relationship.pageId'
                );
        
        $permission = $this->pm->get_data('page_access_relationship',$where,$field,$join);

        $newInfo[] = array(
            'lavelName'     => $value['lavelName'],
            'accessLavelId' => $value['accessLavelId'],
            'permission'    => $permission
                );
        }

    $data['accessPermissions'] = $newInfo;   

    $data['content'] = $this->load->view('accessPermission/accessPermissions',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function NewPermission($accessLavel)
    {
    $data['title'] = 'Permission Add'; 

    $where = array(
        'status' => 'Active'
            );
    $data['pages'] = $this->pm->get_data('pages',$where);

    $pwhere = array(
        'accessLavel' => $accessLavel
            );
    $relationship = $this->pm->get_data('page_access_relationship',$pwhere); 
    
    if($relationship):  
        foreach ($relationship as $key => $value)
            {
            $existing[] = $value['pageId'];
            }
        $data['existing'] = $existing;
        endif;
    
    $data['accessLavel'] = $accessLavel;
             
    $data['content'] =$this->load->view('accessPermission/NewPermission',$data,true);
    $this->load->view('themes/adminlte', $data);
}

public function editPermission($permission_id = NULL)
    {
    $data['title'] = 'Permission Add';

    if ($permission_id != NULL)
        {
        $table = 'page_access_relationship';
        $where = array(
            'pageAccessRelationId' => $permission_id
                );
        $field = array(
            'page_access_relationship' => 'page_access_relationship.*',
            'pages' => 'pages.pageName'
                );
        $join = array(
            'pages' => 'pages.pageId = page_access_relationship.pageId'
                );

        $permissionAccess = $this->pm->get_data($table,$where,$field,$join);

        $data['permissionAccess'] = $permissionAccess[0];
        
        $lavel = $permissionAccess[0]['accessLavel'];
        $sql = "select * from pages where pages.pageId not in(select pageId from page_access_relationship where page_access_relationship.accessLavel=$lavel)";
        
        $data['pages'] = $this->pm->all_query($sql);
        } 
    else{
            
        }
    
    $data['content'] = $this->load->view('accessPermission/EditPermission',$data,TRUE);
    $this->load->view('themes/adminlte', $data);
}

public function SavePermission()
    {
    $table = 'page_access_relationship';
    $info = $this->input->post();
    
    if ($this->input->post('pageAccessRelationId'))
        {
        $pageAccessRelationId = $info['pageAccessRelationId'];
        unset($info['mysubmit']);
        unset($info['pageAccessRelationId']);
        
        $where = array(
            'pageAccessRelationId' => $pageAccessRelationId
                );
        $update = $this->pm->update_data($table,$info,$where);
        
        if($update)
            {
            $this->session->set_flashdata('msg', 'Successfully Updated Page');
            }
        }
    else
        {
        unset($info['mysubmit']);
        $insert = $this->pm->insert_data($table,$info);
        
        if($insert)
            {
            $this->session->set_flashdata('msg', 'Successfully Inserted Page');
            }
        }
    redirect('AccessPermission');
}



}