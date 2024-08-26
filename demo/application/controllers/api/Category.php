<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Category extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load category model
        */
        $this->load->model('api/category_model');
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
	## Get All category Data (Http Get Request)
	*/
	public function categories_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get category model request
		*/
		$categories = $this->category_model->get_category($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $categories];
	    $this->response($response, $status);
	}

	/*
	## Get single category data (Http Get Request)
	*/
	public function category_get($category_id = null)
	{
		$this->verify_request();

		/*
		## Call get single category request
		*/
		$category = $this->category_model->get_single_category($category_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $category];
	    $this->response($response, $status);
	}

	/*
	## Add new category data (Http Post Request)
	*/
	public function category_post()
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

		if($this->post('category_name') == '')
		{
			$error['category_name'] = 'category name not empty';
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
		## Check this category name this company already exists
		*/
		if($this->category_model->check_category_name_duplicate($this->post('company_id'), $this->post('category_name')))
		{
			$error['category_name'] = 'Category name is duplicate try another!';
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
				"categoryName"		=> $this->post('category_name'),
				"status"			=> $this->post('status'),
				"regby"				=> $this->post('created_by')
			);

			$category = $this->category_model->post_category($data);

			if($category)
			{
				$get_category = $this->category_model->recent_category($category);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_category];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Category add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## category update (Http Put/Patch Request)
	*/
	public function category_put($category_id = null)
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

		if($this->put('category_name') == '')
		{
			$error['category_name'] = 'Category name not empty';
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
				"categoryName"		=> $this->put('category_name'),
				"status"			=> $this->put('status'),
				"upby"				=> $this->put('updated_by')
			);

			$category = $this->category_model->put_category($category_id, $data);

			if($category)
			{
				$get_category = $this->category_model->recent_category($category);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_category];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Category add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## category delete (Http Delete Request)
	*/
	public function category_delete($category_id = null)
	{
		$this->verify_request();

		/*
		## Send request category delete with category_id
		*/
		$result = $this->category_model->delete_category($category_id);

		/*
		## Check category delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Category delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$category_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

}
