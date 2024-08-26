<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Product extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load product model
        */
        $this->load->model('api/product_model');
        $this->load->model("prime_model",'pm');

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
	   // return $headers;
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
	## Get All product Data (Http Get Request)
	*/
	public function products_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get product model request
		*/
		$categories = $this->product_model->get_products($company_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $categories];
	    $this->response($response, $status);
	}

	/*
	## Get single product data (Http Get Request)
	*/
	public function product_get($product_id = null)
	{
		$this->verify_request();

		/*
		## Call get single product request
		*/
		$product = $this->product_model->get_single_product($product_id);

		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $product];
	    $this->response($response, $status);
	}

	/*
	## Add new product data (Http Post Request)
	*/
	public function product_post()
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

		if($this->post('product_name') == '')
		{
			$error['product_name'] = 'Product name not empty';
			$flag = false;
		}

		if($this->post('category_id') == '')
		{
			$error['category_id'] = 'Categirt not empty';
			$flag = false;
		}

		if($this->post('unit_id') == '')
		{
			$error['unit_id'] = 'Unit not empty';
			$flag = false;
		}

		if($this->post('purchase_price') == '')
		{
			$error['purchase_price'] = 'Purchase price not empty';
			$flag = false;
		}

		if($this->post('sale_price') == '')
		{
			$error['sale_price'] = 'Sale price not empty';
			$flag = false;
		}

// 		if($this->post('product_detail') == '')
// 		{
// 			$error['product_detail'] = 'Product detail not empty';
// 			$flag = false;
// 		}

		if($this->post('created_by') == '')
		{
			$error['created_by'] = 'Created by not empty';
			$flag = false;
		}

		/*
		## Check this product name this company already exists
		*/
		if($this->product_model->check_product_name_duplicate($this->post('company_id'), $this->post('product_name')))
		{
			$error['product_name'] = 'Product name is duplicate try another!';
			$flag = false;
		}

		/*
		## Check this product name this company already exists
		*/
		if($this->product_model->check_product_code_duplicate($this->post('company_id'), $this->post('product_code')))
		{
			$error['product_code'] = 'Product code is duplicate try another!';
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
// 			$uploaddir = 'upload/product/';
// 	        $path = $_FILES['photo']['name'];
// 	        $ext = pathinfo($path, PATHINFO_EXTENSION);
// 	        $photo = time() . rand() . '.' . $ext;
// 	        $uploadfile = $uploaddir . $photo;
// 	        if ($_FILES["photo"]["name"]) {
// 	            if (move_uploaded_file($_FILES["photo"]["tmp_name"],$uploadfile)) {
// 	            $photo =  $photo;
// 	        }else{
// 	            $photo = 'default_product_image.png';
// 	        }
// 	        }else {
// 	            $photo = 'default_product_image.png';
// 	        }
            $query = $this->db->select('productcode')
                  ->from('products')
                  ->where('compid',$this->post('company_id'))
                  ->limit(1)
                  ->order_by('productcode','DESC')
                  ->get()
                  ->row();
            if($query)
                {
                $sn = substr($query->productcode,5)+1;
                }
            else
                {
                $sn = 1;
                }
                
            $compname = $this->post('compname');
            
            $cn = strtoupper(substr($compname,0,3));
            $pc = sprintf("%'05d",$sn);
        
            $cusid = 'P-'.$cn.$pc;
    
			$data = array(
				"compid"			=> $this->post('company_id'),
				"productName"		=> $this->post('product_name'),
				"productcode"		=> $cusid,
				"categoryID"		=> $this->post('category_id'),
				"unit"				=> $this->post('unit_id'),
				"pprice"			=> $this->post('purchase_price'),
				"sprice"			=> $this->post('sale_price'),
				//"pdetails"			=> $this->post('product_detail'),
				// "image"				=> $photo,
				"regby"				=> $this->post('created_by')
			);

			$product = $this->product_model->post_product($data);
			
			$stock = $this->post('stock');
			
			if($stock)
			    {
			    $stock_data = array(
    				"compid"	 => $this->post('company_id'),
    				"product"	 => $product,
    				"totalPices" => $stock,
    				"regby"		 => $this->post('created_by')
			            );
			
				$this->product_model->post_stock_product($stock_data);
			    }

			if($product)
			{
				$get_product = $this->product_model->recent_product($product);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_product];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Product add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## product update (Http Put/Patch Request)
	*/
	public function product_update_post($product_id = null)
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

		if($this->post('product_name') == '')
		{
			$error['product_name'] = 'Product name not empty';
			$flag = false;
		}

		if($this->post('product_code') == '')
		{
			$error['product_code'] = 'Product code not empty';
			$flag = false;
		}

		if($this->post('category_id') == '')
		{
			$error['category_id'] = 'Category not empty';
			$flag = false;
		}

		if($this->post('unit_id') == '')
		{
			$error['unit_id'] = 'Unit not empty';
			$flag = false;
		}

		if($this->post('purchase_price') == '')
		{
			$error['purchase_price'] = 'Purchase price not empty';
			$flag = false;
		}

		if($this->post('sale_price') == '')
		{
			$error['sale_price'] = 'Sale price not empty';
			$flag = false;
		}

		if($this->post('product_detail') == '')
		{
			$error['product_detail'] = 'Product detail not empty';
			$flag = false;
		}

		if($this->post('updated_by') == '')
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

			$uploaddir = 'upload/product/';
	        $path = $_FILES['photo']['name'];
	        $ext = pathinfo($path, PATHINFO_EXTENSION);
	        $photo = time() . rand() . '.' . $ext;
	        $uploadfile = $uploaddir . $photo;

	        if ($_FILES["photo"]["name"]) {

	            if (move_uploaded_file($_FILES["photo"]["tmp_name"],$uploadfile)) {

	            	$data = array(
						"compid"			=> $this->post('company_id'),
						"productName"		=> $this->post('product_name'),
						"productcode"		=> $this->post('product_code'),
						"categoryID"		=> $this->post('category_id'),
						"units"				=> $this->post('unit_id'),
						"pprice"			=> $this->post('purchase_price'),
						"sprice"			=> $this->post('sale_price'),
						"pdetails"			=> $this->post('product_detail'),
						"image"				=> $photo,
						"upby"				=> $this->post('updated_by')
					);

					$get_product = $this->product_model->recent_product($product_id);
					$path = 'upload/product/'.$get_product->image;
					unlink($path);
	        	}
	        }
	        else{
				$data = array(
					"compid"			=> $this->post('company_id'),
					"productName"		=> $this->post('product_name'),
					"productcode"		=> $this->post('product_code'),
					"categoryID"		=> $this->post('category_id'),
					"units"				=> $this->post('unit_id'),
					"pprice"			=> $this->post('purchase_price'),
					"sprice"			=> $this->post('sale_price'),
					"pdetails"			=> $this->post('product_detail'),
					"upby"				=> $this->post('updated_by')
				);
			}

			$product = $this->product_model->put_product($product_id, $data);

			if($product)
			{
				$get_product = $this->product_model->recent_product($product);
				$status = parent::HTTP_OK;
				$response = ['status' => $status, 'data' => $get_product];
				$this->response($response, $status);
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Product add failed!'];
				$this->response($response, $status);
			}
		}
	}

	/*
	## product delete (Http Delete Request)
	*/
	public function product_delete($product_id = null)
	{
		$this->verify_request();

		/*
		## Get Products
		*/
		$product = $this->product_model->recent_product($product_id);

		$path = 'upload/product/'.$product->image;
		/*
		## Delete file
		*/
// 		unlink($path);

		/*
		## Send request product delete with product_id
		*/
		$result = $this->product_model->delete_product($product_id);

		/*
		## Check product delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'product delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$product_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}
	
public function low_product_stock_reports_get($company_id = null)
    {
    $other = array(
       'join' => 'left'         
            );
    $where = array(
       'stock.compid' => $company_id,
       'stock.totalPices <' => 1
            );
    $field = array(
        'stock' => 'stock.*',
        'products' => 'products.productName,products.productcode,products.pprice'
            );
    $join = array(
        'products' => 'products.productID = stock.product'
            );

    $stock = $this->pm->get_data('stock',$where,$field,$join,$other);
    $status = parent::HTTP_OK;
	$response = ['status' => $status, 'stock' => $stock];
	$this->response($response, $status);
}

public function top_sale_product_reports_get($company_id = null)
    {
    $product = $this->product_model->get_top_sales_product_data($company_id);
    
    $status = parent::HTTP_OK;
	$response = ['status' => $status, 'product' => $product];
	$this->response($response, $status);
}

}
