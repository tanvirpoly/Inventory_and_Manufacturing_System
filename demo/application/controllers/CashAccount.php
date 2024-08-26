<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class CashAccount extends  CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function cash_reports()
  {
  $data['title'] = 'Cash Book';
  $where = array('compid'=> $_SESSION['compid']);
  $data['cash'] = $this->pm->get_data('cash',$where);
  $data['company'] = $this->pm->company_details();

  $this->load->view('cashaccount/cashreports',$data);
}

public function transfer_account_list()
  {
  $data['title'] = 'Transfer Account';
  $where = array('compid'=> $_SESSION['compid']);
  $data['cash'] = $this->pm->get_data('transfer_account',$where);
  
  $this->load->view('cashaccount/transfer_account',$data);
}

public function save_transfer_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'  => $_SESSION['compid'],
    'facType' => $info['accountType'],
    'facAcno' => $info['accountNo'],
    'sacType' => $info['account2Type'],
    'sacAcno' => $info['account2No'],
    'amount'  => $info['amount'],
    'note'    => $info['note'],
    'regby'   => $_SESSION['uid']
        );
  
  $result = $this->pm->insert_data('transfer_account',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Successfully Add transfer Account !</h4>
        </div>'
            ];
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Something is error !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('transAccount');
}

public function delete_balance_transfer($id)
  {
  $where = array(
    'ta_id' => $id
        );
  
  $result = $this->pm->delete_data('transfer_account',$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Successfully delete transfer Account !</h4>
        </div>'
            ];
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Something is error !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('transAccount');
}




 
}