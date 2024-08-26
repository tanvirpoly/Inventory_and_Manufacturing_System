<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payment extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("Prime_model",'pm');
}

public function request_api_hosted()
  {
  $info = $this->input->post();
  
  $where = array(
    'uid' => $_SESSION['uid']
        );
  $payment = $this->db->select('*')
                  ->from('user_payments')
                  ->where('uid',$_SESSION['uid'])
                  ->where('pstatus',1)
                  ->order_by('up_id','desc')
                  ->get()
                  ->row();
  $user = $this->pm->get_data('users',$where);
  
  if($payment)
    {
    $pcdate = date('Y-m-d h:i:s',strtotime($payment->pdate));
    }
  else
    {
    $pcdate = date('Y-m-d h:i:s',strtotime($user[0]['regdate']));
    }
    
  if($info['ptime'] == 1)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 1 months'));
    }
  elseif($info['ptime'] == 2)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 3 months'));
    }
  elseif($info['ptime'] == 3)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 6 months'));
    }
  elseif($info['ptime'] == 4)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 1 year'));
    }
  
  $data = array(
    'compid'  => $_SESSION['compid'],
    'package' => $info['utype'],
    'amount'  => $info['amount'], 
    'uid'     => $_SESSION['uid'],
    'ptime'   => $info['ptime'],
    'pstatus' => 0,
    'pdate'   => $pdate,
    'regby'   => $_SESSION['uid']
        );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('user_payments',$data);
  
    //var_dump('Hi');
    $post_data = array();
    $post_data['total_amount'] = $info['amount'];
    $post_data['currency'] = "BDT";
    $post_data['tran_id'] = "SSLC".uniqid();
    $post_data['success_url'] = base_url()."success";
    $post_data['fail_url'] = base_url()."fail";
    $post_data['cancel_url'] = base_url()."cancel";
    $post_data['ipn_url'] = base_url()."ipn";
      # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

      # EMI INFO
      // $post_data['emi_option'] = "1";
      // $post_data['emi_max_inst_option'] = "9";
      // $post_data['emi_selected_inst'] = "9";

      # CUSTOMER INFORMATION
    $post_data['cus_name'] = $_SESSION['name'];
    $post_data['cus_email'] = $_SESSION['email'];
    $post_data['cus_add1'] = $_SESSION['name'];
    $post_data['cus_city'] = $_SESSION['name'];
    $post_data['cus_state'] = $_SESSION['name'];
    $post_data['cus_postcode'] = $_SESSION['name'];
    $post_data['cus_country'] = $_SESSION['name'];
    $post_data['cus_phone'] = $_SESSION['name'];

      # SHIPMENT INFORMATION
    $post_data['ship_name'] = $this->input->post('fname');
    $post_data['ship_add1'] = $this->input->post('add1');
    $post_data['ship_city'] = $this->input->post('state');
    $post_data['ship_state'] = $this->input->post('state');
    $post_data['ship_postcode'] = $this->input->post('postcode');
    $post_data['ship_country'] = $this->input->post('country');

      # OPTIONAL PARAMETERS
    $post_data['value_a'] = "ref001";
    $post_data['value_b'] = "ref002";
    $post_data['value_c'] = "ref003";
    $post_data['value_d'] = "ref004";

    $post_data['product_profile'] = "physical-goods";
    $post_data['shipping_method'] = "YES";
    $post_data['num_of_item'] = "3";
    $post_data['product_name'] = "Computer,Speaker";
    $post_data['product_category'] = "Ecommerce";

    $this->load->library('session');

    $session = array(
      'tran_id'  => $post_data['tran_id'],
      'amount'   => $post_data['total_amount'],
      'currency' => $post_data['currency']
          );
    $this->session->set_userdata('tarndata',$session);

    //echo "<pre>";
    //print_r($session);
    $storeid = "sunshinecombdlive";
    $storepass = "61D2CEAA8AECA83134";
    //var_dump($post_data); var_dump($storeid); var_dump($storepass);
    if($this->sslcommerz->RequestToSSLC($post_data,$storeid,$storepass))
      {
      echo "Pending";
          /***************************************
          # Change your database status to Pending.
          ****************************************/
      }
        
    else{
        $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Payment Successfully !</h4>
        </div>'
            ]; 
    $this->session->set_userdata($sdata);
    
    redirect('uBill');
    }
}

public function easycheckout_endpoint()
  {
  $tran_id = $_REQUEST['order'];
  $jsondata = json_decode($_REQUEST['cart_json'], true);

  $post_data = array();
  $post_data['total_amount'] = $jsondata['amount'];
  $post_data['currency'] = "USD";
  $post_data['tran_id'] = $tran_id;
  $post_data['success_url'] = base_url()."success";
  $post_data['fail_url'] = base_url()."fail";
  $post_data['cancel_url'] = base_url()."cancel";
  $post_data['ipn_url'] = base_url()."ipn";
    # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

    # EMI INFO
    // $post_data['emi_option'] = "1";
    // $post_data['emi_max_inst_option'] = "9";
    // $post_data['emi_selected_inst'] = "9";

    # CUSTOMER INFORMATION
  $post_data['cus_name'] = $jsondata['cus_name'];
  $post_data['cus_email'] = $jsondata['email'];
  $post_data['cus_add1'] = $jsondata['address'];
  $post_data['cus_city'] = $jsondata['state'];
  $post_data['cus_state'] = $jsondata['state'];
  $post_data['cus_postcode'] = $jsondata['amount'];
  $post_data['cus_country'] = $jsondata['zip'];
  $post_data['cus_phone'] = $jsondata['phone'];

    # SHIPMENT INFORMATION
  $post_data['ship_name'] = $jsondata['cus_name'];
  $post_data['ship_add1'] = $jsondata['address'];
  $post_data['ship_city'] = $jsondata['state'];
  $post_data['ship_state'] = $jsondata['state'];
  $post_data['ship_postcode'] = $jsondata['zip'];
  $post_data['ship_country'] = $jsondata['country'];

    # OPTIONAL PARAMETERS
  $post_data['value_a'] = "ref001";
  $post_data['value_b'] = "ref002";
  $post_data['value_c'] = "ref003";
  $post_data['value_d'] = "ref004";

  $post_data['product_profile'] = "physical-goods";
  $post_data['shipping_method'] = "YES";
  $post_data['num_of_item'] = "3";
  $post_data['product_name'] = "Computer,Speaker";
  $post_data['product_category'] = "Ecommerce";

  $this->load->library('session');

  $session = array(
    'tran_id' => $post_data['tran_id'],
    'amount' => $post_data['total_amount'],
    'currency' => $post_data['currency']
        );
  $this->session->set_userdata('tarndata', $session);

    // echo "<pre>";
    // print_r($post_data);
  if($this->sslcommerz->EasyCheckout($post_data, SSLCZ_STORE_ID, SSLCZ_STORE_PASSWD))
    {
    echo "Pending";
      /***************************************
      # Change your database status to Pending.
      ****************************************/
    }
}

public function success_payment()
  {
  $database_order_status = 'Pending'; // Check this from your database here Pending is dummy data,
  $sesdata = $this->session->userdata('tarndata');

  if(($sesdata['tran_id'] == $_POST['tran_id']) && ($sesdata['amount'] == $_POST['currency_amount']) && ($sesdata['currency'] == 'USD'))
    {
    if($this->sslcommerz->ValidateResponse($_POST['currency_amount'], $sesdata['currency'], $_POST))
      {
      if($database_order_status == 'Pending')
        {
          /*****************************************************************************
          # Change your database status to Processing & You can redirect to success page from here
          ******************************************************************************/
        echo "Transaction Successful<br>";
        echo "Processing";
        //echo "<pre>";
        //print_r($_POST);exit;
        }
      else
        {
          /******************************************************************
          # Just redirect to your success page status already changed by IPN.
          ******************************************************************/
        echo "Just redirect to your success page";
        }
      }
    }
}

public function fail_payment()
  {
  $database_order_status = 'Pending'; // Check this from your database here Pending is dummy data,
  if($database_order_status == 'Pending')
    {
      /*****************************************************************************
      # Change your database status to FAILED & You can redirect to failed page from here
      ******************************************************************************/
    //echo "<pre>";
    //print_r($_POST);
    echo "Transaction Faild";
    }
  else
    {
      /******************************************************************
      # Just redirect to your success page status already changed by IPN.
      ******************************************************************/
    echo "Just redirect to your failed page";
    } 
}

public function cancel_payment()
  {
  $database_order_status = 'Pending'; // Check this from your database here Pending is dummy data,
  if($database_order_status == 'Pending')
    {
      /*****************************************************************************
      # Change your database status to CANCELLED & You can redirect to cancelled page from here
      ******************************************************************************/
    //echo "<pre>";
    //print_r($_POST);
    echo "Transaction Canceled";
    }
  else
    {
      /******************************************************************
      # Just redirect to your cancelled page status already changed by IPN.
      ******************************************************************/
    echo "Just redirect to your failed page";
    }
}

public function ipn_listener()
  {
  $database_order_status = 'Pending'; // Check this from your database here Pending is dummy data,
  $store_passwd = SSLCZ_STORE_PASSWD;
  if($ipn = $this->sslcommerz->ipn_request($store_passwd, $_POST))
    {
    if(($ipn['gateway_return']['status'] == 'VALIDATED' || $ipn['gateway_return']['status'] == 'VALID') && $ipn['ipn_result']['hash_validation_status'] == 'SUCCESS')
      {
      if($database_order_status == 'Pending')
        {
        echo $ipn['gateway_return']['status']."<br>";
        echo $ipn['ipn_result']['hash_validation_status']."<br>";
          /*****************************************************************************
          # Check your database order status, if status = 'Pending' then chang status to 'Processing'.
          ******************************************************************************/
        }
      }
    elseif($ipn['gateway_return']['status'] == 'FAILED' && $ipn['ipn_result']['hash_validation_status'] == 'SUCCESS')
      {
      if($database_order_status == 'Pending')
        {
        echo $ipn['gateway_return']['status']."<br>";
        echo $ipn['ipn_result']['hash_validation_status']."<br>";
          /*****************************************************************************
          # Check your database order status, if status = 'Pending' then chang status to 'FAILED'.
          ******************************************************************************/
        }
      }
    elseif ($ipn['gateway_return']['status'] == 'CANCELLED' && $ipn['ipn_result']['hash_validation_status'] == 'SUCCESS') 
      {
      if($database_order_status == 'Pending')
        {
        echo $ipn['gateway_return']['status']."<br>";
        echo $ipn['ipn_result']['hash_validation_status']."<br>";
          /*****************************************************************************
          # Check your database order status, if status = 'Pending' then chang status to 'CANCELLED'.
          ******************************************************************************/
        }
      }
    else
      {
      if($database_order_status == 'Pending')
        {
        echo "Order status not ".$ipn['gateway_return']['status'];
          /*****************************************************************************
          # Check your database order status, if status = 'Pending' then chang status to 'FAILED'.
          ******************************************************************************/
        }
      }
    //echo "<pre>";
    //print_r($ipn);
    }
}





}