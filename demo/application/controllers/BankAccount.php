<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class BankAccount extends  CI_Controller {

public function __construct()
  {
  parent::__construct(); 
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Bank Account';    

  $where = array('compid'=> $_SESSION['compid']);

  $data['bank'] = $this->pm->get_data('bankaccount',$where);

  $this->load->view('bankaccount/bankAccountList',$data);
}

public function save_bank_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'     => $_SESSION['compid'],
    'accountName'=> $info['accountName'],
    'accountNo'  => $info['accountNo'],
    'bankName'   => $info['bankName'],
    'branchName' => $info['branchName'],      
    'balance'    => $info['balance'],        
    'regby'      => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  
  $result = $this->pm->insert_data('bankaccount',$data);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Bank Account Setting is complete. !</h4>
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
  redirect('BankAccount');
}

public function get_bank_account()
  {
  $grup = $this->pm->get_bank_account($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_bank_account()
  {
  $info = $this->input->post();

  $data = array(
    'compid'     => $_SESSION['compid'],
    'accountName'=> $info['accountName'],
    'accountNo'  => $info['accountNo'],
    'bankName'   => $info['bankName'],
    'branchName' => $info['branchName'],      
    'balance'    => $info['balance'],        
    'upby'       => $_SESSION['uid']
        );
  //var_dump($sale); exit();
  $where = [
    'ba_id' => $info['bankAccountId']
          ]; 
  $result = $this->pm->update_data('bankaccount',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-primary alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Bank Account update is complete. !</h4>
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
  redirect('BankAccount');
}

public function bank_account_delete($id)
  {
  $where = array(
    'ba_id' => $id
          );

  $result = $this->pm->delete_data('bankaccount',$where);
  
  if($result)
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Bank Account delete is complete. !</h4>
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
  redirect('BankAccount');
}

public function mobile_reports()
  {
  $data['title'] = 'Bank Book';
  $where = array('compid'=> $_SESSION['compid']);
  
  $data['bank'] = $this->pm->get_data('bankaccount',$where);
  $data['company'] = $this->pm->company_details();

  $this->load->view('bankaccount/bankreports',$data);
}

public function bank_transation_reports()
  {
  $data = ['title' => 'Bank Report'];

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
        
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
      
      $data['pruchase'] = $this->pm->get_bank_dpurchase_data($sdate,$edate);
      $data['sale'] = $this->pm->get_bank_dsale_data($sdate,$edate);
      $data['sreturn'] = $this->pm->get_bank_dsreturn_data($sdate,$edate);
      //$data['preturn'] = $this->pm->get_bank_dpreturn_data($sdate,$edate);
      $data['voucher'] = $this->pm->get_bank_dvoucher_data($sdate,$edate);
      }
    else if ($report == 'monthlyReports')
      {
      $month = $_GET['month'];
      $data['month'] = $month;
      $year = $_GET['year'];
      $data['year'] = $year;
            //var_dump($data['month']); exit();
      if($month == 1)
        {
        $name = 'January';
        }
      elseif ($month == 2)
        {
        $name = 'February';
        }
      elseif ($month == 3)
        {
        $name = 'March';
        }
      elseif ($month == 4)
        {
        $name = 'April';
        }
      elseif ($month == 5)
        {
        $name = 'May';
        }
      elseif ($month == 6)
        {
        $name = 'June';
        }
      elseif ($month == 7)
        {
        $name = 'July';
        }
      elseif ($month == 8)
        {
        $name = 'August';
        }
      elseif ($month == 9)
        {
        $name = 'September';
        }
      elseif ($month == 10)
        {
        $name = 'October';
        }
      elseif ($month == 11)
        {
        $name = 'November';
        }
      else
        {
        $name = 'December';
        }

      $data['name'] = $name;
      $data['report'] = $report;
      
      $data['pruchase'] = $this->pm->get_bank_mpurchase_data($month,$year);
      $data['sale'] = $this->pm->get_bank_msale_data($month,$year);
      $data['sreturn'] = $this->pm->get_bank_msreturn_data($month,$year);
      //$data['preturn'] = $this->pm->get_bank_mpreturn_data($month,$year);
      $data['voucher'] = $this->pm->get_bank_mvoucher_data($month,$year);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;
      
      $data['pruchase'] = $this->pm->get_bank_ypurchase_data($year);
      $data['sale'] = $this->pm->get_bank_ysale_data($year);
      $data['sreturn'] = $this->pm->get_bank_ysreturn_data($year);
      //$data['preturn'] = $this->pm->get_bank_ypreturn_data($year);
      $data['voucher'] = $this->pm->get_bank_yvoucher_data($year);
      }
    }
  else
    {
    $data['pruchase'] = $this->pm->get_bank_purchase_data();
    $data['sale'] = $this->pm->get_bank_sale_data();
    $data['sreturn'] = $this->pm->get_bank_sreturn_data();
    //$data['preturn'] = $this->pm->get_bank_preturn_data();
    $data['voucher'] = $this->pm->get_bank_voucher_data();
    }

  $this->load->view('bankaccount/bank_treport',$data);
}






}