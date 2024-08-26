<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Unit extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load unit model
        */
        $this->load->model('api/unit_model');
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
	## Get All unit Data (Http Get Request)
	*/
	public function units_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get unit model request
		*/
		$units = $this->unit_model->get_unit();
        //var_dump($units); exit();
		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $units];
	    $this->response($response, $status);
	}

public function all_units_get()
	{
	$this->verify_request();

	$units = $this->unit_model->get_all_unit();
    //var_dump($units); exit();
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $units];
    $this->response($response, $status);
}

	/*
	## Get single unit data (Http Get Request)
	*/
	public function unit_get($unit_id = null)
	{
		$this->verify_request();

		/*
		## Call get single unit request
		*/
		$unit = $this->unit_model->get_single_unit($unit_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $unit];
	    $this->response($response, $status);
	}

	/*
	## Add new unit data (Http Post Request)
	*/
	public function unit_post()
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

// 		if($this->post('unit_code') == '')
// 		{
// 			$error['unit_code'] = 'Unit code not empty';
// 			$flag = false;
// 		}

		if($this->post('unit_name') == '')
		{
			$error['unit_name'] = 'Unit name not empty';
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

// 		if($this->unit_model->check_unit_code_duplicate($this->post('company_id'), $this->post('unit_code')))
// 		{
// 			$error['unit_code'] = 'Unit code is duplicate try another!';
// 			$flag = false;
// 		}

		if($this->unit_model->check_unit_name_duplicate($this->post('company_id'), $this->post('unit_name')))
		{
			$error['unit_name'] = 'Unit Name is duplicate try another!';
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
				// "unitCode"			=> $this->post('unit_code'),
				"unitName"			=> $this->post('unit_name'),
				"status"			=> $this->post('status'),
				"regby"				=> $this->post('created_by')
			);

			$unit = $this->unit_model->post_unit($data);

			if($unit)
			{
				$get_unit = $this->unit_model->recent_unit($unit);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_unit];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Unit add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## unit update (Http Put/Patch Request)
	*/
	public function unit_put($unit_id = null)
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

// 		if($this->put('unit_code') == '')
// 		{
// 			$error['unit_code'] = 'Unit code not empty';
// 			$flag = false;
// 		}

		if($this->put('unit_name') == '')
		{
			$error['unit_name'] = 'Company name not empty';
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
				// "unitCode"			=> $this->put('unit_code'),
				"unitName"			=> $this->put('unit_name'),
				"status"			=> $this->put('status'),
				"regby"				=> $this->put('created_by')
			);

			$unit = $this->unit_model->put_unit($unit_id, $data);

			if($unit)
			{
				$get_unit = $this->unit_model->recent_unit($unit);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_unit];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Unit update failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## unit delete (Http Delete Request)
	*/
	public function unit_delete($unit_id = null)
	{
		$this->verify_request();

		/*
		## Send request unit delete with unit_id
		*/
		$result = $this->unit_model->delete_unit($unit_id);

		/*
		## Check unit delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Unit delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$unit_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

}
