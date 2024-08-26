<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Store extends REST_Controller
  {
public function __construct(){

  parent::__construct();

  $this->load->helper(['jwt','authorization']);
  $this->load->model('api/Store_model');
}

private function verify_request()
  {
  $headers = $this->input->request_headers();
  $token = $headers['Authorization'];
    
  try
    {
    $data = AUTHORIZATION::validateToken($token);
    if ($data === false)
      {
      $status = parent::HTTP_UNAUTHORIZED;
      $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
      $this->response($response, $status);
      exit();
      }
    else
      {
      return $data;
      }
    }
  catch(Exception $e)
    {
    $status = parent::HTTP_UNAUTHORIZED;
    $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
    $this->response($response, $status);
    }
}

public function store_data_get($compid)
  {
  $this->verify_request();

  $store = $this->Store_model->get_store_data($compid);
  
  $storeName = 'https://sunshine.com.bd/app/store/'.$store->sid.'/'.$store->sName;

  $status = parent::HTTP_OK;
  $response = ['status' => $status,'data' => $store,'storeLink' => $storeName];
  $this->response($response,$status);
}

public function save_store_data_post()
  {
  $this->verify_request();

  $flag = true;

  if($this->post('sName') == '')
    {
    $error['sName'] = 'Store Name not empty';
    $flag = false;
    }

  if($this->post('sMobile') == '')
    {
    $error['sMobile'] = 'Store Mobile not empty';
    $flag = false;
    }

  if($this->post('sAddress') == '')
    {
    $error['sAddress'] = 'Store Address not empty';
    $flag = false;
    }

  if($flag == false)
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'error' => $error];
    $this->response($response, $status);
    }
  else
    {
    $store = $this->db->select('sid,compid,sbImage')->from('store')->where('compid',$this->post('compid'))->get()->row();

    $data = array(
      "compid"     => $this->post('compid'),
      "sName"      => $this->post('sName'),
      "sMobile"    => $this->post('sMobile'),
      "sEmail"     => $this->post('sEmail'),
      "sAddress"   => $this->post('sAddress'),
      "sdCharge"   => $this->post('sdCharge'),
      "sFacebook"  => $this->post('sFacebook'),
      "sGoogle"    => $this->post('sGoogle'),
      "sTwitter"   => $this->post('sTwitter'),
      "sInstagram" => $this->post('sInstagram'),
      "sbImage"    => $this->post('sbImage'),
      "regby"      => $this->post('uid')
          );

    $sid = $store->sid;
    $compid = $this->post('compid');
    
    $customer = $this->Store_model->post_store($data,$sid);

    if($customer)
      {
      $get_store = $this->Store_model->get_store_data($compid);
      $status = parent::HTTP_OK;
      $response = ['status' => $status, 'data' => $get_store,'message' => 'Store add Successfuly!'];
      $this->response($response, $status);
      }
    else
      {
      $status = parent::HTTP_BAD_REQUEST;
      $response = ['status' => $status, 'message' => 'Store add failed!'];
      $this->response($response, $status);
      }
    }
}




}