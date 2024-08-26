<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Purchase extends REST_Controller
  {
  public function __construct(){

    parent::__construct();

        /*## Load these helper to create JWT tokens*/
    $this->load->helper(['jwt', 'authorization']); 

        /*## Load purchase model*/
    $this->load->model('api/purchase_model');
    }

private function verify_request()
  {
      /* ## Get all the headers */
  $headers = $this->input->request_headers();
      /*## Extract the token*/
  $token = $headers['Authorization'];
      /*## Use try-catch## JWT library throws exception if the token is not valid*/
  try{
      /*## Validate the token## Successfull validation will return the decoded user data else returns false*/
    $data = AUTHORIZATION::validateToken($token);
    if($data === false)
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
  catch (Exception $e){
      /*## Token is invalid## Send the unathorized access message*/
    $status = parent::HTTP_UNAUTHORIZED;
    $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
    $this->response($response, $status);
    }
}

  /*
  ## Get All purchase Data (Http Get Request)
  */
public function purchases_get($company_id = null)
  {
  $this->verify_request();

    /*## Call get purchase model request*/
  $purchases = $this->purchase_model->get_purchase($company_id);

  $status = parent::HTTP_OK;
  $response = ['status' => $status, 'data' => $purchases];
  $this->response($response, $status);
}

  /*
  ## Get single purchase data (Http Get Request)
  */
public function purchase_get($purchase_id = null)
  {
  $this->verify_request();

    /*## Call get single purchase request*/
  $purchase = $this->purchase_model->get_single_purchase($purchase_id);
  if($purchase)
    {
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $purchase];
    $this->response($response, $status);
    }
  else
    {
    $status = parent::HTTP_NOT_FOUND;
    $response = ['status' => $status, 'message' => 'ID: '.$purchase_id.' not found!'];
    $this->response($response, $status);
    }
}

  /*
  ## Add new purchase data (Http Post Request)
  */
public function purchase_post()
  {
    /*## verify token*/
  $this->verify_request();

    /*## Define flag variable*/
  $purchase = $this->purchase_model->post_purchase($this->post());

  if($purchase)
    {
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $purchase];
    $this->response($response, $status);
    }
  else
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'message' => 'Purchase add failed!'];
    $this->response($response, $status);
    }
}

  /*
  ## Purchase edit get (Http get Request)
  */
public function purchase_edit_get($purchase_id = null)
  {
    /*## verify token*/
  $this->verify_request();

  $purchase = $this->purchase_model->get_purchase_edit($purchase_id);

  if($purchase)
    {
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $purchase];
    $this->response($response, $status);
    }
  else
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'message' => 'Purchase edit get failed!'];
    $this->response($response, $status);
    }
}

  /*
  ## Purchase update (Http Put Request)
  */
public function purchase_put($purchase_id = null)
  {
    /*## verify token*/
  $this->verify_request();

  if($purchase_id == null)
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'message' => 'Purchase id not failed!'];
    $this->response($response, $status);
    }
  else
    {
    $purchase = $this->purchase_model->put_purchase($purchase_id, $this->put());

    if($purchase)
      {
      $status = parent::HTTP_OK;
      $response = ['status' => $status, 'data' => $purchase];
      $this->response($response, $status);
      }
    else
      {
      $status = parent::HTTP_BAD_REQUEST;
      $response = ['status' => $status, 'message' => 'Purchase add failed!'];
      $this->response($response, $status);
      }
    }
}

  /*
  ## Purchase delete (Http Delete Request)
  */
public function purchase_delete($purchase_id = null)
  {
  $this->verify_request();
    /*## Send request purchase delete with purchase_id*/
  $result = $this->purchase_model->delete_purchase($purchase_id);
    /*## Check purchase delete## Success OR Fail*/

  if($result)
    {
    $status = parent::HTTP_OK;
    $message = 'Purchase delete successfull';
    }
  else
    {
    $status = parent::HTTP_NOT_FOUND;
    $message = 'ID '.$purchase_id.' not found';
    }

  $response = ['status' => $status, 'message' => $message];
  $this->response($response, $status);
}

public function purchase_report_post($company_id = null)
  {
  $this->verify_request();
  
  $report = $this->post('rType');
  //var_dump($report); exit();
  if($report == "dailyReports")
    {
    $sdate = date("Y-m-d", strtotime($this->post('sdate')));
    $edate = date("Y-m-d", strtotime($this->post('edate')));
    //var_dump($sdate); var_dump($edate); exit();
    $purchase = $this->purchase_model->get_dpurchase($company_id,$sdate,$edate);
    }
  else
    {
    $purchase = $this->purchase_model->get_purchase($company_id);
    }
  
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'purchase' => $purchase];
  $this->response($response,$status);
}



}