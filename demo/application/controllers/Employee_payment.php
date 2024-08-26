<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_payment extends CI_Controller{

public function __construct()
    {
    parent::__construct();       
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index()
    {
    $data['title'] = 'Employee Payments';

    $where = array(
        'employee_payment.compid' => $_SESSION['compid']
            );
    $field = array(
        'employee_payment' => 'employee_payment.*',
        'employees' => 'employees.employeeName'
            );
    $join = array(
        'employees' => 'employee_payment.empid = employees.employeeID'
            );
    $other = array(
        'order_by' => 'empPid',
        'join' => 'left'
            );
    
    $data['employees'] = $this->pm->get_data('employee_payment',$where,$field,$join,$other);

    $this->load->view('employeePayment/infos',$data);
}

public function AddInfo()
    {
    $data['title'] = 'Employee Payment';
    $where = array(
        'compid' => $_SESSION['compid']
            );
    $data['employee'] = $this->pm->get_data('employees',$where);

    $this->load->view('employeePayment/new_payment',$data);
}

public function get_emp_salary()
    {
    $section = $this->pm->get_salary_emp($_POST['id'],$_POST['id2'],$_POST['id3']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function Saveinfo()
    {        
    $info = $this->input->post();

    $emps = array(
        'empid'       => $info['empid'],
        'compid'      => $_SESSION['compid'],
        'month'       => $info['month'],
        'year'        => $info['year'],
        'salary'      => $info['pAmount'],
        'accountType' => $info['accountType'],
        'accountNo'   => $info['accountNo'],
        'note'        => $info['note'],
        'regby'       => $_SESSION['uid']
                );
        //var_dump($emps); exit();
    $result = $this->pm->insert_data('employee_payment',$emps);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Employee Payments add Successfully !</h4>
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
    redirect('empPayment');
}

public function emp_payment_details($id)
    {
    $data['title'] = 'Employee Payment';

    $data['company'] = $this->pm->company_details();

    $where = array(
        'empPid' => $id
            );
    $field = array(
        'employee_payment' => 'employee_payment.*',
        'employees' => 'employees.employeeName,employees.empaddress,employees.phone,employees.email'
            );
    $join = array(
        'employees' => 'employees.employeeID = employee_payment.empid'
            );
    $other = array(
        'join' => 'left'
            );
    $collection = $this->pm->get_data('employee_payment',$where,$field,$join,$other);
    $data['empp'] = $collection[0];

    $this->load->view('employeePayment/emppDetails',$data);
}







}