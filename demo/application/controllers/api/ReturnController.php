<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class ReturnController extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load return model
        */
        $this->load->model('api/return_model');
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
	## Get All return Data (Http Get Request)
	*/
	public function returns_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get return model request
		*/
		$returns = $this->return_model->get_return($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $returns];
	    $this->response($response, $status);
	}

	/*
	## Get single return data (Http Get Request)
	*/
	public function return_get($return_id = null)
	{
		$this->verify_request();

		/*
		## Call get single return request
		*/
		$return = $this->return_model->get_single_return($return_id);

		if($return) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $return];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_NOT_FOUND;
	    	$response = ['status' => $status, 'message' => 'ID: '.$return_id.' not found!'];
	    	$this->response($response, $status);
		}

	}

	/*
	## Add new return data (Http Post Request)
	*/
	public function return_post()
	{
		/*
		## verify token
		*/
		$this->verify_request();

		/*
		## Define flag variable
		*/
		$return = $this->return_model->post_return($this->post());


		if($return)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'message' => 'Return add Successfull', 'data' => $return];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Return add failed!'];
			$this->response($response, $status);
		}
	}

	/*
	## Return edit get (Http get Request)
	*/
	public function return_edit_get($return_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();


		$return = $this->return_model->get_return_edit($return_id);

		if($return)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'data' => $return];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Return edit get failed!'];
			$this->response($response, $status);
		}
	}


	/*
	## Return update (Http Put Request)
	*/
	public function return_put($return_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();


		$return = $this->return_model->put_return($return_id, $this->put());

		if($return)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'data' => $return];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Return update failed!'];
			$this->response($response, $status);
		}
	}

	/*
	## Return delete (Http Delete Request)
	*/
	public function return_delete($return_id = null)
	{
		$this->verify_request();

		/*
		## Send request return delete with return id
		*/
		$result = $this->return_model->delete_return($return_id);

		/*
		## Check return delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Return delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$return_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}


}	