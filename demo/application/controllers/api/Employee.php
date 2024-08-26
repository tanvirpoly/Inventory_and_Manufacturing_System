<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Employee extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load employee model
        */
        $this->load->model('api/employee_model');
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
	## Get All employee Data (Http Get Request)
	*/
	public function employees_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get employee model request
		*/
		$employees = $this->employee_model->get_employee($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $employees];
	    $this->response($response, $status);
	}

	/*
	## Get single employee data (Http Get Request)
	*/
	public function employee_get($employee_id = null)
	{
		$this->verify_request();

		/*
		## Call get single employee request
		*/
		$employee = $this->employee_model->get_single_employee($employee_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $employee];
	    $this->response($response, $status);
	}

	/*
	## Add new employee data (Http Post Request)
	*/
	public function employee_post()
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

		if($this->post('department_id') == '')
		{
			$error['department_id'] = 'Department id not empty';
			$flag = false;
		}


		if($this->post('employee_name') == '')
		{
			$error['employee_name'] = 'Employee name not empty';
			$flag = false;
		}

		if($this->post('address') == '')
		{
			$error['address'] = 'Address not empty';
			$flag = false;
		}

		if($this->post('mobile') == '')
		{
			$error['mobile'] = 'Mobile not empty';
			$flag = false;
		}

		if($this->post('email') == '')
		{
			$error['email'] = 'Email not empty';
			$flag = false;
		}

		if($this->post('joining_date') == '')
		{
			$error['joining_date'] = 'Joining date not empty';
			$flag = false;
		}

		if($this->post('salary') == '')
		{
			$error['salary'] = 'Salary not empty';
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


		if($this->employee_model->check_email_duplicate($this->post('email')))
		{
			$error['email'] = 'Email Address is duplicate try another!';
			$flag = false;
		}

		if($this->employee_model->check_mobile_duplicate($this->post('mobile')))
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
				"dpt_id"			=> $this->post('department_id'),
				"employeeName"		=> $this->post('employee_name'),
				"empaddress"		=> $this->post('address'),
				"phone"				=> $this->post('mobile'),
				"email"				=> $this->post('email'),
				"joiningDate"		=> $this->post('joining_date'),
				"salary"			=> $this->post('salary'),
				"nid"				=> $this->post('nid'),
				"status"			=> $this->post('status'),
				"regby"				=> $this->post('created_by')
			);

			$employee = $this->employee_model->post_employee($data);

			if($employee)
			{
				$get_employee = $this->employee_model->recent_employee($employee);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_employee];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'employee add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## employee update (Http Put/Patch Request)
	*/
	public function employee_put($employee_id = null)
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

		if($this->put('department_id') == '')
		{
			$error['department_id'] = 'Department id not empty';
			$flag = false;
		}


		if($this->put('employee_name') == '')
		{
			$error['employee_name'] = 'Employee name not empty';
			$flag = false;
		}

		if($this->put('address') == '')
		{
			$error['address'] = 'Address not empty';
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

		if($this->put('joining_date') == '')
		{
			$error['joining_date'] = 'Joining date not empty';
			$flag = false;
		}

		if($this->put('salary') == '')
		{
			$error['salary'] = 'Salary not empty';
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
				"dpt_id"			=> $this->put('department_id'),
				"employeeName"		=> $this->put('employee_name'),
				"empaddress"		=> $this->put('address'),
				"phone"				=> $this->put('mobile'),
				"email"				=> $this->put('email'),
				"joiningDate"		=> $this->put('joining_date'),
				"salary"			=> $this->put('salary'),
				"nid"				=> $this->put('nid'),
				"status"			=> $this->put('status'),
				"upby"				=> $this->put('updated_by')
			);

			$employee = $this->employee_model->put_employee($employee_id, $data);

			if($employee)
			{
				$get_employee = $this->employee_model->recent_employee($employee);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_employee];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'employee add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## employee delete (Http Delete Request)
	*/
	public function employee_delete($employee_id = null)
	{
		$this->verify_request();

		/*
		## Send request employee delete with employee_id
		*/
		$result = $this->employee_model->delete_employee($employee_id);

		/*
		## Check employee delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'employee delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$employee_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

}
