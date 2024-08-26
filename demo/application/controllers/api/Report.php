<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Report extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load report model
        */
        $this->load->model('api/report_model');
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

	// Sales Report
	public function sales_post() {
		// Check Authrize 
		$this->verify_request();
		
		$sales = $this->report_model->get_sales($data = $this->post());
		
		if($sales) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $sales];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Sales Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Purchase Report
	public function purchases_post() {
		// Check Authrize 
		$this->verify_request();
		
		$purchases = $this->report_model->get_purchases($data = $this->post());
		
		if($purchases) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $purchases];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Purchases Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Customer Report
	public function customers_post() {
		// Check Authrize 
		$this->verify_request();

		$company_id = $this->post('company_id');
		$customer_id = $this->post('customer_id');
		
		$customers = $this->report_model->get_customers($company_id, $customer_id);
		
		if($customers) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $customers];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Customer Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Customer Invoice Report
	public function customer_invoice_post() {
		// Check Authrize 
		$this->verify_request();

		$company_id = $this->post('company_id');
		$customer_id = $this->post('customer_id');
		
		$customers = $this->report_model->get_customer_details($company_id, $customer_id);
		
		if($customers) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $customers];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Customer Invoice Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Supplier Report
	public function suppliers_post() {
		// Check Authrize 
		$this->verify_request();

		$company_id = $this->post('company_id');
		$supplier_id = $this->post('supplier_id');
		
		$suppliers = $this->report_model->get_suppliers($company_id, $supplier_id);
		
		if($suppliers) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $suppliers];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Supplier Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Supplier Invoice Report
	public function supplier_invoice_post() {
		// Check Authrize 
		$this->verify_request();

		$company_id = $this->post('company_id');
		$supplier_id = $this->post('supplier_id');
		
		$suppliers = $this->report_model->get_supplier_details($company_id, $supplier_id);
		
		if($suppliers) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $suppliers];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Supplier Invoice Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Stock Report
	public function stocks_get($company_id = null) {
		// Check Authrize 
		$this->verify_request();
		
		$stocks = $this->report_model->get_stocks($company_id);
		
		if($stocks) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $stocks];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Stock Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Sale / Purchase profit Report
	public function sale_purchase_profit_report_post() {
		// Check Authrize 
		$this->verify_request();
		
		$profits = $this->report_model->get_sale_purchase_profit_report($this->post());
		
		if($profits) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $profits];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Profit Data falied!'];
	    	$this->response($response, $status);
		}
	}

	// Profit / loss Report
	public function profit_loss_post() {
		// Check Authrize 
		$this->verify_request();
		
		$profit_loss = $this->report_model->get_profit_loss_report($this->post());
		
		if($profit_loss) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $profit_loss];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_BAD_REQUEST;
	    	$response = ['status' => $status, 'message' => 'Profit / Loss Data falied!'];
	    	$this->response($response, $status);
		}
	}
}