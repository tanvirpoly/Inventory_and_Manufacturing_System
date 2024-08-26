<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends CI_Controller {

public function __construct()
    {
    parent::__construct();       
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}


public function emp_department()
    {
    $data['title'] = 'Department';

    $where = array(
        'compid' => $_SESSION['compid']
            );

    $data['dept'] = $this->pm->get_data('department',$where);

    $this->load->view('employees/department',$data);
}

public function save_department()
    {       
    $info = $this->input->post();
           
    $data = array(
        'compid'    => $_SESSION['compid'],
        'dept_name' => $info['department'],
        'regby'     => $_SESSION['uid']
            );
    
    $result = $this->pm->insert_data('department',$data);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Staff department add Successfully !</h4>
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
    redirect('Department');
}

public function get_dept_data()
    {
    $section = $this->pm->get_dept_data($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function update_dept()
    {       
    $info = $this->input->post();
           
    $data = array(
        'compid'    => $_SESSION['compid'],
        'dept_name' => $info['department'],
        'status'    => $info['status'],
        'upby'      => $_SESSION['uid']
            );

    $where = array(
        'dpt_id' => $info['dept_id']
            );

    $result = $this->pm->update_data('department',$data,$where);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Staff Department update Successfully !</h4>
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
    redirect('Department');
}

public function delete_dept($dpt_id)
    {
    $where = array(
        'dpt_id' => $dpt_id
            );

    $empd = $this->pm->get_data('employees',$where);

    if ($empd[0] == null)
        {
        $result = $this->pm->delete_data('department',$where);

        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i>Staff department delete Successfully !</h4>
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
            <h4><i class="icon fa fa-ban"></i> All ready add this department in employees !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Department');
}

public function employee_info()
    {
    $data['title'] = 'Staff / Employee';

    $where = array(
        'compid' => $_SESSION['compid']
            );

    $data['employee'] = $this->pm->get_data('employees',$where);
    $data['dept'] = $this->pm->get_data('department',$where);
    
    $this->load->view('employees/employees',$data);
}

public function save_employee()
    {       
    $info = $this->input->post();

    $query = $this->db->select('emp_id')
                  ->from('employees')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('employeeID','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->emp_id,5)+1;
        }
    else
        {
        $sn = 1;
        }

    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d",$sn);

    $cusid = 'E-'.$cn.$pc;

    $employee = array(
        'compid'      => $_SESSION['compid'],
        'emp_id'      => $cusid,
        'employeeName'=> $info['employeeName'],
        'dpt_id'      => $info['dpt_id'],
        'empaddress'  => $info['empaddress'],
        'phone'       => $info['phone'],
        'email'       => $info['email'],
        'joiningDate' => date('Y-m-d', strtotime($info['joiningDate'])),
        'salary'      => $info['salary'],
        'nid'         => $info['nid'],
        'regby'       => $_SESSION['uid']
                );

    $result = $this->pm->insert_data('employees',$employee);
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Staff / Employee add Successfully !</h4>
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
    redirect('Employee');
}

public function get_emp_data()
    {
    $section = $this->pm->get_emp_data($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function update_Employee()
    {       
    $info = $this->input->post();

    $employee = array(
        'compid'       => $_SESSION['compid'],
        'employeeName' => $info['employeeName'],
        'dpt_id'       => $info['dpt_id'],
        'empaddress'   => $info['empaddress'],
        'phone'        => $info['phone'],
        'email'        => $info['email'],
        'joiningDate'  => date('Y-m-d', strtotime($info['joiningDate'])),
        'salary'       => $info['salary'],
        'nid'          => $info['nid'],
        'status'       => $info['status'],
        'upby'         => $_SESSION['uid']
                );
    //var_dump($employee); exit();
    $where = array(
        'employeeID' => $info['emp_id']
            );

    $result = $this->pm->update_data('employees',$employee,$where);
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Staff update Successfully !</h4>
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
    redirect('Employee');
}

public function delete_Employee($id)
    {
    $where = array(
        'employeeID' => $id
            );

    $result = $this->pm->delete_data('employees',$where);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Staff / Employee delete Successfully !</h4>
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
    redirect('Employee');
}









}