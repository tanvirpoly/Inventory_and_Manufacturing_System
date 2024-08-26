<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Expense extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load expense model
        */
        $this->load->model('api/expense_model');
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
	## Get All expense Data (Http Get Request)
	*/
	public function expenses_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get expense model request
		*/
		$expenses = $this->expense_model->get_expenses($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $expenses];
	    $this->response($response, $status);
	}

	/*
	## Get single expense data (Http Get Request)
	*/
	public function expense_get($expense_id = null)
	{
		$this->verify_request();

		/*
		## Call get single expense request
		*/
		$expense = $this->expense_model->get_single_expense($expense_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $expense];
	    $this->response($response, $status);
	}

	/*
	## Add new expense data (Http Post Request)
	*/
	public function expense_post()
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

		if($this->post('expense_name') == '')
		{
			$error['expense_name'] = 'Expense name not empty';
			$flag = false;
		}

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

		/*
		## Check this expense name this company already exists
		*/
		if($this->expense_model->check_expense_name_duplicate($this->post('company_id'), $this->post('expense_name')))
		{
			$error['expense_name'] = 'expense name is duplicate try another!';
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
				"costName"			=> $this->post('expense_name'),
				"status"			=> $this->post('status'),
				"regby"				=> $this->post('created_by')
			);

			$expense = $this->expense_model->post_expense($data);

			if($expense)
			{
				$get_expense = $this->expense_model->recent_expense($expense);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_expense];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Expense add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## expense update (Http Put/Patch Request)
	*/
	public function expense_put($expense_id = null)
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

		if($this->put('expense_name') == '')
		{
			$error['expense_name'] = 'Expense name not empty';
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
				"costName"			=> $this->put('expense_name'),
				"status"			=> $this->put('status'),
				"upby"				=> $this->put('updated_by')
			);

			$expense = $this->expense_model->put_expense($expense_id, $data);

			if($expense)
			{
				$get_expense = $this->expense_model->recent_expense($expense);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_expense];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Expense add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## expense delete (Http Delete Request)
	*/
public function expense_delete($expense_id = null)
	{
		$this->verify_request();

		/*
		## Send request expense delete with expense_id
		*/
		$result = $this->expense_model->delete_expense($expense_id);

		/*
		## Check expense delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Expense delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$expense_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

public function expense_report_post($company_id = null)
  {
  $this->verify_request();
  
  $report = $this->post('rType');
  //var_dump($report); exit();
  if($report == "dailyReports")
    {
    $sdate = date("Y-m-d", strtotime($this->post('sdate')));
    $edate = date("Y-m-d", strtotime($this->post('edate')));
   // $vtype = $this->post('costType');
    //var_dump($sdate); var_dump($edate); exit();
    $purchase = $this->expense_model->get_dcost_report_data($company_id,$sdate,$edate);
    }
  else
    {
    $purchase = $this->expense_model->get_cost_report_data($company_id);
    }
  
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'expense' => $purchase];
  $this->response($response,$status);
}

}
