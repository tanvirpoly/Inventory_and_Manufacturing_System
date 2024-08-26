<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Quotation extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load sale model
        */
        $this->load->model('api/quotation_model');
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
	## Get All sale Data (Http Get Request)
	*/
	public function quotations_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get sale model request
		*/
		$sales = $this->quotation_model->get_quotation($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $sales];
	    $this->response($response, $status);
	}

	/*
	## Get single sale data (Http Get Request)
	*/
	public function quotation_get($quotation_id = null)
	{
		$this->verify_request();

		/*
		## Call get single sale request
		*/
		$sale = $this->quotation_model->get_single_quotation($quotation_id);

		if($sale) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $sale];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_NOT_FOUND;
	    	$response = ['status' => $status, 'message' => 'ID: '.$sale_id.' not found!'];
	    	$this->response($response, $status);
		}

	}

	/*
	## Add new quotation data (Http Post Request)
	*/
	public function quotation_post()
	{
		/*
		## verify token
		*/
		$this->verify_request();

		/*
		## Define flag variable
		*/
		$quotation = $this->quotation_model->post_quotation($this->post());


		if($quotation)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'message' => 'Quotation add Successfull', 'data' => $quotation];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Quotation add failed!'];
			$this->response($response, $status);
		}
	}

	/*
	## Quotation edit get (Http get Request)
	*/
	public function quotation_edit_get($quotation_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();


		$quotation = $this->quotation_model->get_quotation_edit($quotation_id);

		if($quotation)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'data' => $quotation];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Quotation edit get failed!'];
			$this->response($response, $status);
		}
	}


	/*
	## quotation update (Http Put Request)
	*/
	public function quotation_put($quotation_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();


		$quotation = $this->quotation_model->put_quotation($quotation_id, $this->put());

		if($quotation)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'data' => $quotation];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Quotation update failed!'];
			$this->response($response, $status);
		}
	}

	/*
	## Quotation delete (Http Delete Request)
	*/
	public function quotation_delete($quotation_id = null)
	{
		$this->verify_request();

		/*
		## Send request Quotation delete with category id
		*/
		$result = $this->quotation_model->delete_quotation($quotation_id);

		/*
		## Check Quotation delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Quotation delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$quotation_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}


}	