<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Supplier extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load supplier model
        */
        $this->load->model('api/supplier_model');
        $this->load->model("prime_model","pm");
    }

    private function verify_request()
	{
	    /*
	    ## Get all the headers
	    */
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
	public function suppliers_get($company_id = null)
	{
		$this->verify_request();

		/*
		## call get supplier model request
		*/
		$suppliers = $this->supplier_model->get_supplier($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $suppliers];
	    $this->response($response, $status);
	}

	/*
	## Get single supplier data (Http Get Request)
	*/
	public function supplier_get($supplier_id = null)
	{
		$this->verify_request();

		/*
		## call single supplier model request
		*/
		$supplier = $this->supplier_model->get_single_supplier($supplier_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $supplier];
	    $this->response($response, $status);
	}

	/*
	## Add new supplier data (Http Post Request)
	*/
	public function supplier_post()
	{
		/*
		## verify token
		*/
		$this->verify_request();

		/*
		## Define flag variable
		*/
		$flag = true;

		if($this->post('company_id') == '')
		{
			$error['company_id'] = 'Company id not empty';
			$flag = false;
		}

		if($this->post('supplier_name') == '')
		{
			$error['supplier_name'] = 'Supplier name not empty';
			$flag = false;
		}

// 		if($this->post('company_name') == '')
// 		{
// 			$error['company_name'] = 'Company name not empty';
// 			$flag = false;
// 		}

		if($this->post('mobile') == '')
		{
			$error['mobile'] = 'Mobile not empty';
			$flag = false;
		}

// 		if($this->post('email') == '')
// 		{
// 			$error['email'] = 'Email not empty';
// 			$flag = false;
// 		}

// 		if($this->post('address') == '')
// 		{
// 			$error['address'] = 'Address not empty';
// 			$flag = false;
// 		}

		if($this->post('created_by') == '')
		{
			$error['created_by'] = 'Created by not empty';
			$flag = false;
		}

// 		if($this->supplier_model->check_company_name_duplicate($this->post('company_name')))
// 		{
// 			$error['compname'] = 'Company name is duplicate try another!';
// 			$flag = false;
// 		}

// 		if($this->supplier_model->check_email_duplicate($this->post('email')))
// 		{
// 			$error['email'] = 'Email Address is duplicate try another!';
// 			$flag = false;
// 		}

		if($this->supplier_model->check_mobile_duplicate($this->post('mobile')))
		{
			$error['mobile'] = 'Mobile number is duplicate try another!';
			$flag = false;
		}

		if($flag == false) /* ## Flag variable false */
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'error' => $error];
			$this->response($response, $status);
		}
		else /* ## Flag variable true */
		{
			$data = array(
				"compid"			=> $this->post('company_id'),
				"supplierName"		=> $this->post('supplier_name'),
				"compname"			=> $this->post('company_name'),
				"mobile"			=> $this->post('mobile'),
				"email"				=> $this->post('email'),
				"address"			=> $this->post('address'),
				"balance"			=> $this->post('balance'),
				"regby"				=> $this->post('created_by')
			);

			$supplier = $this->supplier_model->post_supplier($data);

			if($supplier)
			{
				$get_supplier = $this->supplier_model->recent_supplier($supplier);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_supplier];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Supplier add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## supplier update (Http Put/Patch Request)
	*/
	public function supplier_put($supplier_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();

		/*
		## Define flag variable
		*/
		$flag = true;

		if($this->put('company_id') == '')
		{
			$error['company_id'] = 'Company id not empty';
			$flag = false;
		}

		if($this->put('supplier_name') == '')
		{
			$error['supplier_name'] = 'Supplier name not empty';
			$flag = false;
		}

		if($this->put('company_name') == '')
		{
			$error['company_name'] = 'Company name not empty';
			$flag = false;
		}

		if($this->put('mobile') == '')
		{
			$error['mobile'] = 'Mobile not empty';
			$flag = false;
		}

		if($this->put('email') == '')
		{
			$error['email'] = 'Email not empty';
			$flag = false;
		}

		if($this->put('address') == '')
		{
			$error['address'] = 'Address not empty';
			$flag = false;
		}

		if($this->put('updated_by') == '')
		{
			$error['updated_by'] = 'Updated by not empty';
			$flag = false;
		}

		if($flag == false) /* ## Flag variable false */
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'error' => $error];
			$this->response($response, $status);
		}
		else /* ## Flag variable true */
		{
			$data = array(
				"compid"			=> $this->put('company_id'),
				"supplierName"		=> $this->put('supplier_name'),
				"compname"			=> $this->put('company_name'),
				"mobile"			=> $this->put('mobile'),
				"email"				=> $this->put('email'),
				"address"			=> $this->put('address'),
				"balance"			=> $this->put('balance'),
				"upby"				=> $this->put('updated_by')
			);

			$supplier = $this->supplier_model->put_supplier($supplier_id, $data);

			if($supplier)
			{
				$get_supplier = $this->supplier_model->recent_supplier($supplier);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_supplier];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Supplier add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## supplier delete (Http Delete Request)
	*/
	public function supplier_delete($supplier_id = null)
	{
		$this->verify_request();

		/*
		## Send request customer delete with customer_id
		*/
		$result = $this->supplier_model->delete_supplier($supplier_id);

		/*
		## Check supplier delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Supplier delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$supplier_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}
	
public function supplier_purchase_post($supid)
  {
  $this->verify_request();
  
  $report = $this->post('rType');
  if($report == 'dailyReports')
    {
    $sdate = date("Y-m-d", strtotime($this->post('sdate')));
    $edate = date("Y-m-d", strtotime($this->post('edate')));

    $purchese = $this->supplier_model->get_supplier_dpurchase($sdate,$edate,$supid);
    $voucher = $this->supplier_model->get_supplier_dvoucher($sdate,$edate,$supid);
    }
  else
    {
    $purchese = $this->supplier_model->get_supplier_dpurchase($sdate,$edate,$supid);
    $voucher = $this->supplier_model->get_supplier_dvoucher($sdate,$edate,$supid);
    }
    
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'purchese' => $purchese,'voucher' => $voucher];
  $this->response($response,$status);
}

public function supplier_ledger_post()
  {
  $this->verify_request();
  
  $report = $this->post('rType');
    //var_dump($report); exit();
    
  if($report == 'dailyReports')
    {
    $sdate = date("Y-m-d", strtotime($this->post('sdate')));
    $edate = date("Y-m-d", strtotime($this->post('edate')));
    $sid = $this->post('dsupplier');

    $cwhere = array('supplierID' => $sid);

    $supplier = $this->pm->get_data('suppliers',$cwhere);
    //var_dump($cwhere); var_dump($supp); exit();
    $purchase = $this->pm->get_dspurchase_data($sdate,$edate,$sid);
    $voucher = $this->pm->get_dsvoucher_data($sdate,$edate,$sid);
    
    $pa = $this->supplier_model->total_dpurchase_amount($sdate,$edate,$sid);
    $va = $this->supplier_model->total_dvoucher_amount($sdate,$edate,$sid);
    
    if($pa)
      {
      $tota = $pa->ta; $tsp = $pa->tp;
      }
    else
      {
      $tota = 0; $tsp = 0;
      }
      
    if($va)
      {
      $tva = $va->ta;
      }
    else
      {
      $tva = 0;
      }
    
    $tpaid = $tsp+$tva;
    $tdue = $tota-$tpaid;
    }
  else
    {
    $supplier = '';
    $purchase = '';
    $voucher = '';
    $tota = '';
    $tpaid = '';
    $tdue = '';
    }
  
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'supp' => $supplier,'purchase' => $purchase,'voucher' => $voucher,'tota' => $tota,'tpaid' => $tpaid,'tdue' => $tdue];
  $this->response($response,$status);
}



}
