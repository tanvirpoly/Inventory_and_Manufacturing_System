<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Profile extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load profile model
        */
        $this->load->model('api/profile_model');

        /*
        ## Load upload library
        */
        $this->load->library('upload');
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
	    
	    $token = $headers;
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
	## Get All profile Data (Http Get Request)
	*/
	public function profile_get($company_id = null)
	{
// 		$this->verify_request();

		/*
		## Call get profile model request
		*/
		$profiles = $this->profile_model->get_profile($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $profiles];
	    $this->response($response, $status);
	}


	/*
	## Add new profile data (Http Post Request)
	*/
	public function profile_post()
	{
		/*
		## verify token
		*/
// 		$this->verify_request();

		/*
		## Define flag variable
		*/
		$flag = true;

		if($this->post('company_id') == '')
		{
			$error['company_id'] = 'Company id not empty';
			$flag = false;
		}

		if($this->post('company_name') == '')
		{
			$error['company_name'] = 'Company name not empty';
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



		if($this->post('created_by') == '')
		{
			$error['created_by'] = 'Created by not empty';
			$flag = false;
		}

		/*
		## Check this profile name this company already exists
		*/
		if($this->profile_model->check_company_name_duplicate($this->post('company_id'), $this->post('company_name')))
		{
			$error['company_name'] = 'Company name is duplicate try another!';
			$flag = false;
		}

		/*
		## Check this Email this company already exists
		*/
		if($this->profile_model->check_email_duplicate($this->post('company_id'), $this->post('email')))
		{
			$error['email'] = 'Email is duplicate try another!';
			$flag = false;
		}

		/*
		## Check this mobile this company already exists
		*/
		if($this->profile_model->check_mobile_duplicate($this->post('company_id'), $this->post('mobile')))
		{
			$error['mobile'] = 'Company name is duplicate try another!';
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
			// Company Logo
			$upload_company_logo = 'upload/company/';
	        $path_company_logo = $_FILES['company_logo']['name'];
	        $ext_company_logo = pathinfo($path_company_logo, PATHINFO_EXTENSION);
	        $company_logo = time() . rand() . '.' . $ext_company_logo;
	        $uploadfile_company_logo = $upload_company_logo . $company_logo;
	        if ($_FILES["company_logo"]["name"]) {
	            if (move_uploaded_file($_FILES["company_logo"]["tmp_name"],$uploadfile_company_logo)) {
	            $company_logo =  $company_logo;
	        }else{
	            $company_logo = '';
	        }
	        }else {
	            $company_logo = '';
	        }

	        // Invoice Background Logo
			$upload_invoice_background_logo = 'upload/company/';
	        $path_invoice_background_logo = $_FILES['invoice_background_logo']['name'];
	        $ext_invoice_background_logo = pathinfo($path_invoice_background_logo, PATHINFO_EXTENSION);
	        $invoice_background_logo = time() . rand() . '.' . $ext_invoice_background_logo;
	        $uploadfile_invoice_background_logo = $upload_invoice_background_logo . $invoice_background_logo;
	        if ($_FILES["invoice_background_logo"]["name"]) {
	            if (move_uploaded_file($_FILES["invoice_background_logo"]["tmp_name"],$uploadfile_invoice_background_logo)) {
	            $invoice_background_logo =  $invoice_background_logo;
	        }else{
	            $invoice_background_logo = '';
	        }
	        }else {
	            $invoice_background_logo = '';
	        }

	        // Authorize Signature
			$upload_authorize_signature = 'upload/company/';
	        $path_authorize_signature = $_FILES['authorize_signature']['name'];
	        $ext_authorize_signature = pathinfo($path_authorize_signature, PATHINFO_EXTENSION);
	        $authorize_signature = time() . rand() . '.' . $ext_authorize_signature;
	        $uploadfile_authorize_signature = $upload_authorize_signature . $authorize_signature;
	        if ($_FILES["authorize_signature"]["name"]) {
	            if (move_uploaded_file($_FILES["authorize_signature"]["tmp_name"],$uploadfile_authorize_signature)) {
	            $authorize_signature =  $authorize_signature;
	        }else{
	            $authorize_signature = '';
	        }
	        }else {
	            $authorize_signature = '';
	        }

			$data = array(
				"compid"			=> $this->post('company_id'),
				"com_name"			=> $this->post('company_name'),
				"com_address"		=> $this->post('address'),
				"com_mobile"		=> $this->post('mobile'),
				"com_email"			=> $this->post('email'),
				"com_web"			=> $this->post('website'),
				"com_balance"		=> $this->post('balance'),
				"com_logo"			=> $company_logo,
				"com_bimg"			=> $invoice_background_logo,
				"com_simg"			=> $authorize_signature,
				"regby"				=> $this->post('created_by')
			);

			$profile = $this->profile_model->post_profile($data);

			if($profile)
			{
				$get_profile = $this->profile_model->recent_profile($profile);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_profile];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Profile add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## profile update (Http Put/Patch Request)
	*/
	public function profile_update_post($company_id = null)
	{
		/*
		## verify token
		*/
// 		$this->verify_request();

		/*
		## Define flag variable
		*/
		$flag = true;

		if($this->post('company_id') == '')
		{
			$error['company_id'] = 'Company id not empty';
			$flag = false;
		}

		if($this->post('company_name') == '')
		{
			$error['company_name'] = 'Company name not empty';
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



		if($flag == false) /* ## Flag variable false */
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'error' => $error];
			$this->response($response, $status);
		}
		else /* ## Flag variable true */
		{
			$get_profile = $this->profile_model->recent_profile($company_id);

			// Company Logo
			$upload_company_logo = 'upload/company/';
	        $path_company_logo = $_FILES['company_logo']['name'];
	        $ext_company_logo = pathinfo($path_company_logo, PATHINFO_EXTENSION);
	        $company_logo = time() . rand() . '.' . $ext_company_logo;
	        $uploadfile_company_logo = $upload_company_logo . $company_logo;
	        if ($_FILES["company_logo"]["name"]) {
	            if (move_uploaded_file($_FILES["company_logo"]["tmp_name"],$uploadfile_company_logo)) {
	            $company_logo =  $company_logo;
				$path = 'upload/profile/'.$get_profile->com_logo;
				unlink($path);
	        }else{
	            $company_logo = $get_profile->com_logo;
	        }
	        }else {
	            $company_logo = $get_profile->com_logo;
	        }

	        // Invoice Background Logo
			$upload_invoice_background_logo = 'upload/company/';
	        $path_invoice_background_logo = $_FILES['invoice_background_logo']['name'];
	        $ext_invoice_background_logo = pathinfo($path_invoice_background_logo, PATHINFO_EXTENSION);
	        $invoice_background_logo = time() . rand() . '.' . $ext_invoice_background_logo;
	        $uploadfile_invoice_background_logo = $upload_invoice_background_logo . $invoice_background_logo;
	        if ($_FILES["invoice_background_logo"]["name"]) {
	            if (move_uploaded_file($_FILES["invoice_background_logo"]["tmp_name"],$uploadfile_invoice_background_logo)) {
	            $invoice_background_logo =  $invoice_background_logo;

				$path = 'upload/profile/'.$get_profile->com_bimg;
				unlink($path);
	        }else{
	            $invoice_background_logo = $get_profile->com_bimg;
	        }
	        }else {
	            $invoice_background_logo = $get_profile->com_bimg;
	        }

	        // Authorize Signature
			$upload_authorize_signature = 'upload/company/';
	        $path_authorize_signature = $_FILES['authorize_signature']['name'];
	        $ext_authorize_signature = pathinfo($path_authorize_signature, PATHINFO_EXTENSION);
	        $authorize_signature = time() . rand() . '.' . $ext_authorize_signature;
	        $uploadfile_authorize_signature = $upload_authorize_signature . $authorize_signature;
	        if ($_FILES["authorize_signature"]["name"]) {
	            if (move_uploaded_file($_FILES["authorize_signature"]["tmp_name"],$uploadfile_authorize_signature)) {
	            $authorize_signature =  $authorize_signature;

				$path = 'upload/profile/'.$get_profile->com_simg;
				unlink($path);
	        }else{
	            $authorize_signature = $get_profile->com_simg;
	        }
	        }else {
	            $authorize_signature = $get_profile->com_simg;
	        }

			$data = array(
				"compid"			=> $this->post('company_id'),
				"com_name"			=> $this->post('company_name'),
				"com_address"		=> $this->post('address'),
				"com_mobile"		=> $this->post('mobile'),
				"com_email"			=> $this->post('email'),
				"com_web"			=> $this->post('website'),
				"com_balance"		=> $this->post('balance'),
				"com_logo"			=> $company_logo,
				"com_bimg"			=> $invoice_background_logo,
				"com_simg"			=> $authorize_signature
			);

			$profile = $this->profile_model->put_profile($company_id, $data);

			if($profile)
			{
				$get_profile = $this->profile_model->recent_profile($profile);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_profile];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Store profile update failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## profile delete (Http Delete Request)
	*/
	public function profile_delete($company_id = null)
	{
		$this->verify_request();

		/*
		## Get profiles
		*/
		$profile = $this->profile_model->recent_profile($company_id);

		$path1 = 'upload/company/'.$profile->com_logo;
		$path2 = 'upload/company/'.$profile->com_bimg;
		$path3 = 'upload/company/'.$profile->com_simg;

		/*
		## Delete file
		*/
		unlink($path1);
		unlink($path2);
		unlink($path3);

		/*
		## Send request profile delete with profile_id
		*/
		$result = $this->profile_model->delete_profile($company_id);

		/*
		## Check profile delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Store profile delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$company_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}

}
