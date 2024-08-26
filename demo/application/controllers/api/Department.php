<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Department extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load department model
        */
        $this->load->model('api/department_model');
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
	## Get All department Data (Http Get Request)
	*/
	public function departments_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get department model request
		*/
		$departments = $this->department_model->get_departments($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $departments];
	    $this->response($response, $status);
	}

	/*
	## Get single department data (Http Get Request)
	*/
	public function department_get($department_id = null)
	{
		$this->verify_request();

		/*
		## Call get single department request
		*/
		$department = $this->department_model->get_single_department($department_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $department];
	    $this->response($response, $status);
	}

	/*
	## Add new department data (Http Post Request)
	*/
	public function department_post()
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

		if($this->post('department_name') == '')
		{
			$error['department_name'] = 'Department name not empty';
			$flag = false;
		}


		if($this->post('created_by') == '')
		{
			$error['created_by'] = 'Created by not empty';
			$flag = false;
		}

		/*
		## Check this department name this company already exists
		*/
		if($this->department_model->check_department_name_duplicate($this->post('company_id'), $this->post('department_name')))
		{
			$error['department_name'] = 'Department name is duplicate try another!';
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
				"dept_name"			=> $this->post('department_name'),
				"regby"				=> $this->post('created_by')
			);

			$department = $this->department_model->post_department($data);

			if($department)
			{
				$get_department = $this->department_model->recent_department($department);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_department];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Department add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## department update (Http Put/Patch Request)
	*/
	public function department_put($department_id = null)
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

		if($this->put('department_name') == '')
		{
			$error['department_name'] = 'Department name not empty';
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
				"dept_name"			=> $this->put('department_name'),
				"upby"				=> $this->put('updated_by')
			);

			$department = $this->department_model->put_department($department_id, $data);

			if($department)
			{
				$get_department = $this->department_model->recent_department($department);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_department];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Department add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## department delete (Http Delete Request)
	*/
	public function department_delete($department_id = null)
	{
		$this->verify_request();

		/*
		## Send request department delete with department_id
		*/
		$result = $this->department_model->delete_department($department_id);

		/*
		## Check department delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Department delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$department_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

}
