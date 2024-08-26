<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Order extends REST_Controller
{

public function __construct() {

    parent::__construct();

    $this->load->helper(['jwt', 'authorization']); 

    $this->load->model("prime_model","pm");
    $this->load->model('api/voucher_model');
}

private function verify_request()
	{
	    $headers = $this->input->request_headers();
	    /*
	    ## Extract the token
	    */
	    $token = $headers['Authorization'];
	    /*
	    ## Use try-catch
	    ## JWT library throws exception if the token is not valid
	    */
	    try {
	        /*
	        ## Validate the token
	        ## Successfull validation will return the decoded user data else returns false
	        */
	        $data = AUTHORIZATION::validateToken($token);
	        if ($data === false) {
	            $status = parent::HTTP_UNAUTHORIZED;
	            $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
	            $this->response($response, $status);
	            exit();
	        } else {
	            return $data;
	        }
	    } catch (Exception $e) {
	        /*
	        ## Token is invalid
	        ## Send the unathorized access message
	        */
	        $status = parent::HTTP_UNAUTHORIZED;
	        $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
	        $this->response($response, $status);
	    }
	}

	/*
	## Get All supplier Data (Http Get Request)
	*/
public function orders_get()
	{
	$this->verify_request();

	$suppliers = $this->pm->get_data('order',false);

	$status = parent::HTTP_OK;
	$response = ['status' => $status, 'data' => $suppliers];
	$this->response($response, $status);
}

public function order_reports_post($company_id)
  {
  $this->verify_request();
  
  $report = $this->post('rType');
        
    if($report == 'dailyReports')
        {
        $sdate = date("Y-m-d", strtotime($this->post('sdate')));
        $edate = date("Y-m-d", strtotime($this->post('edate')));
        
        $order = $this->voucher_model->user_dorder_ledger($sdate,$edate,$company_id);
        }
    else
        {
        $order = $this->voucher_model->user_aorder_ledger($company_id);
        }
  
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'order' => $order];
  $this->response($response,$status);
}



}
