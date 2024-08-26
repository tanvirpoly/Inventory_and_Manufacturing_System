<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Customer extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load customer model
        */
        $this->load->model('api/customer_model');
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
	## Get All Customer Data (Http Get Request)
	*/
	public function customers_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get customer model request
		*/
		$customers = $this->customer_model->get_customer($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $customers];
	    $this->response($response, $status);
	}

	/*
	## Get single customer data (Http Get Request)
	*/
	public function customer_get($customer_id = null)
	{
		$this->verify_request();

		/*
		## Call get single customer request
		*/
		$customer = $this->customer_model->get_single_customer($customer_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $customer];
	    $this->response($response, $status);
	}

	/*
	## Add new customer data (Http Post Request)
	*/
	public function customer_post()
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

		if($this->post('customer_name') == '')
		{
			$error['customer_name'] = 'Customer name not empty';
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

		if($this->post('status') == '')
		{
			$error['status'] = 'Status not empty';
			$flag = false;
		}

		if($this->post('created_by') == '')
		{
			$error['created_by'] = 'Created by not empty';
			$flag = false;
		}

// 		if($this->customer_model->check_company_name_duplicate($this->post('company_name')))
// 		{
// 			$error['compname'] = 'Company name is duplicate try another!';
// 			$flag = false;
// 		}

// 		if($this->customer_model->check_email_duplicate($this->post('email')))
// 		{
// 			$error['email'] = 'Email Address is duplicate try another!';
// 			$flag = false;
// 		}

		if($this->customer_model->check_mobile_duplicate($this->post('mobile')))
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
				"customerName"		=> $this->post('customer_name'),
				// "compname"			=> $this->post('company_name'),
				"mobile"			=> $this->post('mobile'),
				"email"				=> $this->post('email'),
				"address"			=> $this->post('address'),
				"balance"			=> $this->post('balance'),
				"status"			=> $this->post('status'),
				"regby"				=> $this->post('created_by')
			);

			$customer = $this->customer_model->post_customer($data);

			if($customer)
			{
				$get_customer = $this->customer_model->recent_customer($customer);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_customer];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Customer add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## customer update (Http Put/Patch Request)
	*/
	public function customer_put($customer_id = null)
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

		if($this->put('customer_name') == '')
		{
			$error['customer_name'] = 'Customer name not empty';
			$flag = false;
		}

// 		if($this->put('company_name') == '')
// 		{
// 			$error['company_name'] = 'Company name not empty';
// 			$flag = false;
// 		}

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

		if($this->put('status') == '')
		{
			$error['status'] = 'Status not empty';
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
				"customerName"		=> $this->put('customer_name'),
				// "compname"			=> $this->put('company_name'),
				"mobile"			=> $this->put('mobile'),
				"email"				=> $this->put('email'),
				"address"			=> $this->put('address'),
				"balance"			=> $this->put('balance'),
				"status"			=> $this->put('status'),
				"upby"				=> $this->put('updated_by')
			);

			$customer = $this->customer_model->put_customer($customer_id, $data);

			if($customer)
			{
				$get_customer = $this->customer_model->recent_customer($customer);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_customer];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Customer add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## customer delete (Http Delete Request)
	*/
	public function customer_delete($customer_id = null)
	{
		$this->verify_request();

		/*
		## Send request customer delete with customer_id
		*/
		$result = $this->customer_model->delete_customer($customer_id);

		/*
		## Check customer delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Customer delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$customer_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

public function customer_ledger_post()
  {
  $this->verify_request();
  
    $report = $this->post('rType');
    //var_dump($report); exit();
    if($report == 'dailyReports')
        {
        $sdate = date("Y-m-d", strtotime($this->post('sdate')));
        $edate = date("Y-m-d", strtotime($this->post('edate')));
        $customer = $this->post('dcustomer');
  
        $report = $report;

        $cwhere = array('customerID' => $customer);

        $cust = $this->pm->get_data('customers',$cwhere);
        $sale = $this->pm->sales_dcust_ledger_data($customer,$sdate,$edate);
        $voucher = $this->pm->voucher_dcust_ledger_data($customer,$sdate,$edate);
        $return = $this->pm->return_dcust_ledger_data($customer,$sdate,$edate);
        
        $sa = $this->customer_model->total_dsales_amount($customer,$sdate,$edate);
        $va = $this->customer_model->total_dvoucher_amount($customer,$sdate,$edate);
        $ra = $this->customer_model->total_dreturn_amount($customer,$sdate,$edate);
        
        if($sa)
          {
          $tota = $sa->ta; $tsp = $sa->tp+$sa->td;
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
          
        if($ra)
          {
          $tra = $ra->ta;
          }
        else
          {
          $tra = 0;
          }
        
        $tpaid = $tsp+$tva+$tra;
        $tdue = $tota-$tpaid;
        }
    else if ($report == 'monthlyReports')
        {
        $month = $this->post('month');
        $year = $this->post('year');
        $customer = $this->post('mcustomer');
        $report = $report;

        $cwhere = array('customerID' => $customer);

        $cust = $this->pm->get_data('customers',$cwhere);
        $sale = $this->pm->sales_mcust_ledger_data($customer,$month,$year);
        $voucher = $this->pm->voucher_mcust_ledger_data($customer,$month,$year);
        $return = $this->pm->return_mcust_ledger_data($customer,$month,$year);
        
        $sa = $this->customer_model->total_msales_amount($customer,$month,$year);
        $va = $this->customer_model->total_mvoucher_amount($customer,$month,$year);
        $ra = $this->customer_model->total_mreturn_amount($customer,$month,$year);
        
        if($sa)
          {
          $tota = $sa->ta; $tsp = $sa->tp+$sa->td;
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
          
        if($ra)
          {
          $tra = $ra->ta;
          }
        else
          {
          $tra = 0;
          }
        
        $tpaid = $tsp+$tva+$tra;
        $tdue = $tota-$tpaid;
        }
    else if ($report == 'yearlyReports')
        {
        $year = $this->post('ryear');
        $customer = $this->post('ycustomer');
        $report = $report;

        $cwhere = array('customerID' => $customer);

        $cust = $this->pm->get_data('customers',$cwhere);
        $sale = $this->pm->sales_ycust_ledger_data($customer,$year);
        $voucher = $this->pm->voucher_ycust_ledger_data($customer,$year);
        $return = $this->pm->return_ycust_ledger_data($customer,$year);
        
        $sa = $this->customer_model->total_ysales_amount($customer,$year);
        $va = $this->customer_model->total_yvoucher_amount($customer,$year);
        $ra = $this->customer_model->total_yreturn_amount($customer,$year);
        
        if($sa)
          {
          $tota = $sa->ta; $tsp = $sa->tp+$sa->td;
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
          
        if($ra)
          {
          $tra = $ra->ta;
          }
        else
          {
          $tra = 0;
          }
        
        $tpaid = $tsp+$tva+$tra;
        $tdue = $tota-$tpaid;
        }
    else if ($report == 'allReports')
        {
        $customer = $this->post('customer');
        $report = $report;

        $cwhere = array('customerID' => $customer);

        $cust = $this->pm->get_data('customers',$cwhere);
        $sale = $this->pm->sales_cust_ledger_data($customer);
        $voucher = $this->pm->voucher_cust_ledger_data($customer);
        $return = $this->pm->return_cust_ledger_data($customer);
        
        $sa = $this->customer_model->total_sales_amount($customer);
        $va = $this->customer_model->total_voucher_amount($customer);
        $ra = $this->customer_model->total_return_amount($customer);
        
        if($sa)
          {
          $tota = $sa->ta; $tsp = $sa->tp+$sa->td;
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
          
        if($ra)
          {
          $tra = $ra->ta;
          }
        else
          {
          $tra = 0;
          }
        
        $tpaid = $tsp+$tva+$tra;
        $tdue = $tota-$tpaid;
        }
  //var_dump($cust); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'report' => $report,'cust' => $cust, 'sale' => $sale,'voucher' => $voucher,'return' => $return, 'tota' => $tota,'tpaid' => $tpaid,'tdue' => $tdue];
  //var_dump($data); exit();
  $this->response($response,$status);
}



}
