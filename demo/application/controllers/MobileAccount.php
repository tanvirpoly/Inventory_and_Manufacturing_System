<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class MobileAccount extends  CI_Controller {

public function __construct()
  {
  parent::__construct();        
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Mobile Transaction';
  $where = array('compid'=> $_SESSION['compid']);

  $data['maccount'] = $this->pm->get_data('mobileaccount',$where);
      //var_dump($data['maccount']); exit();
  $this->load->view('mobileaccount/mobileAccountList',$data);
}

public function save_mobile_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'     => $_SESSION['compid'],
    'accountName'=> $info['accountName'],
    'accountNo'  => $info['accountNo'],
    'accountOwner'=> $info['accountOwner'],     
    'balance'    => $info['balance'],        
    'regby'      => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  
  $result = $this->pm->insert_data('mobileaccount',$data);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Mobile Account Setting is complete. !</h4>
        </div>'
            ]; 
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4>
        </div>'
            ]; 
    }
  $this->session->set_userdata($sdata);
  redirect('MobileAccount');
}

public function get_mobile_account()
  {
  $grup = $this->pm->get_mobile_transaction($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_mobile_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'     => $_SESSION['compid'],
    'accountName'=> $info['accountName'],
    'accountNo'  => $info['accountNo'],
    'accountOwner'=> $info['accountOwner'],     
    'balance'    => $info['balance'], 
    'status'     => $info['status'],        
    'upby'       => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  $where = array(
    'ma_id' => $info['mobileAccountId']
        );
  
  $result = $this->pm->update_data('mobileaccount',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Mobile Account update is complete. !</h4>
        </div>'
            ]; 
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4>
        </div>'
            ]; 
    }
  $this->session->set_userdata($sdata);
  redirect('MobileAccount');
}

public function mobile_account_delete($id)
  {
  $where = array(
    'ma_id' => $id
        );

  $result = $this->pm->delete_data('mobileaccount',$where);
  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Mobile Account delete is complete. !</h4>
        </div>'
            ]; 
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4>
        </div>'
            ]; 
    }
  $this->session->set_userdata($sdata);
  redirect('MobileAccount');
}

public function mobile_reports()
  {
  $data['title'] = 'Mobile Book';
  $where = array('compid'=> $_SESSION['compid']);

  $data['mobile'] = $this->pm->get_data('mobileaccount',$where);
  $data['company'] = $this->pm->company_details();

  $this->load->view('mobileaccount/mobilereports',$data);
}




   
}