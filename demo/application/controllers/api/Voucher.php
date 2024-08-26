<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Voucher extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load voucher model
        */
        $this->load->model('api/voucher_model');
        $this->load->model("prime_model","pm");
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
	## Get All voucher Data (Http Get Request)
	*/
	public function vouchers_list_get($company_id = null)
	{
		$this->verify_request();

		/*
		## Call get voucher model request
		*/
		$vouchers = $this->voucher_model->get_all_voucher($company_id);
        //var_dump($vouchers); exit();
		$status = parent::HTTP_OK;
	    $response = ['status' => $status, 'data' => $vouchers];
	    $this->response($response, $status);
	}

public function new_voucher_get($company_id = null)
	{
	$this->verify_request();

	/*
	## Call get voucher model request
	*/
	$expense = $this->voucher_model->get_voucher_expense($company_id);

	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $expense];
    $this->response($response, $status);
}

	/*
	## Get single voucher data (Http Get Request)
	*/
public function voucher_get($voucher_id = null)
	{
		$this->verify_request();

		/*
		## Call get single voucher request
		*/
		$voucher = $this->voucher_model->get_single_voucher($voucher_id);
		
		//var_dump($voucher); exit();
        
		if($voucher) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $voucher];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_NOT_FOUND;
	    	$response = ['status' => $status, 'message' => 'ID: '.$voucher_id.' not found!'];
	    	$this->response($response, $status);
		}

	}

public function vaucher_particular_get($voucher_id = null)
	{
	$this->verify_request();

		/*
		## Call get single voucher request
		*/
	$voucher = $this->voucher_model->get_vouchers($voucher_id);
		
		
        
		if($voucher) {
			$status = parent::HTTP_OK;
	    	$response = ['status' => $status, 'data' => $voucher];
	    	$this->response($response, $status);
		} else {
			$status = parent::HTTP_NOT_FOUND;
	    	$response = ['status' => $status, 'message' => 'ID: '.$voucher_id.' not found!'];
	    	$this->response($response, $status);
		}

	}
	

	/*
	## Add new Voucher data (Http Post Request)
	*/

// public function voucher_post()
//   {
//   $this->verify_request();

//   $info = $this->post();

//   $query = $this->db->select('invoice')
//                   ->from('vaucher')
//                   ->limit(1)
//                   ->order_by('invoice','DESC')
//                   ->get()
//                   ->row();
//   if($query)
//     {
//     $sn = substr($query->invoice,5)+1;
//     }
//   else
//     {
//     $sn = 1;
//     }
//   $compid = $info['company_id'];
//   //var_dump($compid); exit();
//   $company = $this->db->select('com_name')
//                       ->from('com_profile')
//                       ->where("compid",$compid)
//                       ->get()
//                       ->row();
//   //var_dump($company); exit();
//   $cn = strtoupper(substr($company->com_name,0,3));
//   $pc = sprintf("%'05d", $sn);

//   $cusid = 'V-'.$cn.$pc;
    
//   if($info['voucher_type'] == "Credit Voucher" || $info['voucher_type'] == "Customer Pay")
//     {
//     $data = array(
//       'compid'        => $info['company_id'],
//       'invoice'       => $cusid,
//       'voucherdate'   => $info['voucher_date'],
//       'customerID'    => $info['customer_id'],
//       'vauchertype'   => $info['voucher_type'],
//       'totalamount'   => $info['total_amount'],
//       'accountType'   => $info['account_type'],
//       'accountNo'     => $info['account_no'],
//       'regby'         => $info['created_by']
//           );
//     }

//   if($info['voucher_type'] == "Debit Voucher")
//     {
//     $data = array(
//       'compid'        => $info['company_id'],
//       'invoice'       => $cusid,
//       'voucherdate'   => $info['voucher_date'],
//       'employee'      => $info['employee_id'],
//       'costType'      => $info['cost_id'],
//       'vauchertype'   => $info['voucher_type'],
//       'totalamount'   => $info['total_amount'],
//       'accountType'   => $info['account_type'],
//       'accountNo'     => $info['account_no'],
//       'regby'         => $info['created_by']
//             );
//     }

//   if($info['voucher_type'] == "Supplier Pay")
//     {
//     $data = array(
//       'compid'        => $info['company_id'],
//       'invoice'       => $cusid,
//       'voucherdate'   => $info['voucher_date'],
//       'supplier'      => $info['supplier_id'],
//       'vauchertype'   => $info['voucher_type'],
//       'totalamount'   => $info['total_amount'],
//       'accountType'   => $info['account_type'],
//       'accountNo'     => $info['account_no'],
//       'regby'         => $info['created_by']
//             );  
//     }
//   $vid = $this->voucher_model->post_voucher($data);
  
//   foreach($voucher['vouchers'] as $row)
// 	    {      
//         $partdata = array(
//             'vuid'         => $vid,
//             'particulars'  => $row['particular'],
//             'amount'       => $row['amount'],
//             'regby'        => $info['created_by']
//                 );
       
//         $voucher = $this->voucher_model->post_voucher_prticuler($partdata); 
// 	    }
//   $length = count($info['amount']);
//     //var_dump($length); exit();
//   for($i = 0; $i < $length; $i++)
//     {
//     $partdata = array(
//       'vuid'        => $vid,
//       'particulars' => $info['particular'][$i],
//       'amount'      => $info['amount'][$i],
//       'regby'       => $info['created_by']
//           );
//     //var_dump($partdata);    
//     $voucher = $this->voucher_model->post_voucher_prticuler($partdata); 
//     }

//   if($voucher)
//     {
//     $status = parent::HTTP_OK;
//     $response = ['status' => $status, 'message' => 'Voucher add Successfull', 'data' => $vid];
//     $this->response($response, $status);
//     }
//   else
//     {
//     $status = parent::HTTP_BAD_REQUEST;
//     $response = ['status' => $status, 'message' => 'Voucher add failed!'];
//     $this->response($response, $status);
//     }
// }

	public function voucher_post()
	{
		/*
		## verify token
		*/
		$this->verify_request();

		/*
		## Define flag variable
		*/
		$voucher = $this->voucher_model->post_voucher($this->post());


		if($voucher)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'message' => 'Voucher add Successfull', 'data' => $voucher];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Voucher add failed!'];
			$this->response($response, $status);
		}
	}

	/*
	## Voucher edit get (Http get Request)
	*/
	public function voucher_edit_get($voucher_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();


		$voucher = $this->voucher_model->get_voucher_edit($voucher_id);

		if($voucher)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'data' => $voucher];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Voucher edit get failed!'];
			$this->response($response, $status);
		}
	}


	/*
	## Voucher update (Http Put Request)
	*/
	public function voucher_put($voucher_id = null)
	{
		/*
		## verify token
		*/
		$this->verify_request();


		$voucher = $this->voucher_model->put_voucher($voucher_id, $this->put());

		if($voucher)
		{
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'data' => $voucher];
			$this->response($response, $status);
		}
		else
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Voucher update failed!'];
			$this->response($response, $status);
		}
	}

	/*
	## Voucher delete (Http Delete Request)
	*/
	public function voucher_delete($voucher_id = null)
	{
		$this->verify_request();

		/*
		## Send request Voucher delete with voucher id
		*/
		$result = $this->voucher_model->delete_voucher($voucher_id);

		/*
		## Check Voucher delete
		## Success OR Fail
		*/

		if($result)
		{
			$status = parent::HTTP_OK;
			$message = 'Voucher delete successfull';
		}
		else
		{
			$status = parent::HTTP_NOT_FOUND;
			$message = 'ID '.$voucher_id.' not found';
		}

	    $response = ['status' => $status, 'message' => $message];
	    $this->response($response, $status);
	}
	

public function profit_loss_report_post($company_id = null)
  {
  $this->verify_request();
  
  $report = $this->post('rType');
        
    if($report == 'dailyReports')
        {
        $sdate = date("Y-m-d", strtotime($this->post('sdate')));
        $edate = date("Y-m-d", strtotime($this->post('edate')));
  
        $report = $report;
        
        $sale = $this->voucher_model->total_dsales_amount($sdate,$edate,$company_id);
        $purchase = $this->voucher_model->total_dpurchases_amount($sdate,$edate,$company_id);
        $empp = $this->voucher_model->total_demp_payments_amount($sdate,$edate,$company_id);
        $return = $this->voucher_model->total_dreturns_amount($sdate,$edate,$company_id);
        $cvoucher = $this->voucher_model->total_dcvoucher_amount($sdate,$edate,$company_id);
        $dvoucher = $this->voucher_model->total_ddvoucher_amount($sdate,$edate,$company_id);
        $svoucher = $this->voucher_model->total_dsvoucher_amount($sdate,$edate,$company_id);
        }
    else
        {
        $sale = $this->voucher_model->total_sales_amount($company_id);
        $purchase = $this->voucher_model->total_purchases_amount($company_id);
        $empp = $this->voucher_model->total_emp_payments_amount($company_id);
        $return = $this->voucher_model->total_returns_amount($company_id);
        $cvoucher = $this->voucher_model->total_cvoucher_amount($company_id);
        $dvoucher = $this->voucher_model->total_dvoucher_amount($company_id);
        $svoucher = $this->voucher_model->total_svoucher_amount($company_id);
        }
  
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'report' => $report,'sale' => $sale,'purchase' => $purchase,'empp' => $empp,'return' => $return,'cvoucher' => $cvoucher,'dvoucher' => $dvoucher,'svoucher' => $svoucher];
  $this->response($response,$status);
}

public function daily_report_get($company_id = null)
  {
  $this->verify_request();
  
    $psale = $this->voucher_model->pre_sales_amount($company_id);
    $ppurchase = $this->voucher_model->pre_purchases_amount($company_id);
    $pempp = $this->voucher_model->pre_emp_payments_amount($company_id);
    $preturn = $this->voucher_model->pre_returns_amount($company_id);
    $pcvoucher = $this->voucher_model->pre_cvoucher_amount($company_id);
    $pdvoucher = $this->voucher_model->pre_dvoucher_amount($company_id);
    $psvoucher = $this->voucher_model->pre_svoucher_amount($company_id);
    
    $pamount = (($psale->total+$pcvoucher->total)-($ppurchase->total+$pdvoucher->total+$pempp->total+$preturn->total+$psvoucher->total));
    
    $sale = $this->voucher_model->today_sales_amount($company_id);
    $purchase = $this->voucher_model->today_purchases_amount($company_id);
    $empp = $this->voucher_model->today_emp_payments_amount($company_id);
    $return = $this->voucher_model->today_returns_amount($company_id);
    $cvoucher = $this->voucher_model->today_cvoucher_amount($company_id);
    $dvoucher = $this->voucher_model->today_dvoucher_amount($company_id);
    $svoucher = $this->voucher_model->today_svoucher_amount($company_id);
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'pamount' => $pamount,'sale' => $sale,'purchase' => $purchase,'empp' => $empp,'return' => $return,'cvoucher' => $cvoucher,'dvoucher' => $dvoucher,'svoucher' => $svoucher];
  $this->response($response,$status);
}

public function voucher_report_post($company_id = null)
  {
  $this->verify_request();
    
  $report = $this->post('rType');
    //var_dump($report); exit();
  if($report == 'dailyReports')
    {
    $sdate = date("Y-m-d", strtotime($this->post('sdate')));
    $edate = date("Y-m-d", strtotime($this->post('edate')));
    $vtype = $this->post('vType');
    
    $order = $this->voucher_model->get_dcost_report_data($sdate,$edate,$company_id,$vtype);
    }
  else
    {
    $order = $this->voucher_model->get_cost_report_data($company_id);
    }
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'order' => $order];
  $this->response($response,$status);
}

public function cash_book_get($company_id = null)
  {
  $this->verify_request();
  
  $cash = $this->voucher_model->cash_book_data($company_id);
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'cash' => $cash];
  $this->response($response,$status);
}

public function cash_book_current_get($cid)
  {
  $this->verify_request();
  
  $total = $this->voucher_model->cash_book_current_data($cid);
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'total' => $total];
  $this->response($response,$status);
}

public function bank_book_get($company_id = null)
  {
  $this->verify_request();
  
  $bank = $this->voucher_model->bank_book_data($company_id);
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'bank' => $bank];
  $this->response($response,$status);
}

public function bank_book_current_get($bid)
  {
  $this->verify_request();
  
  $total = $this->voucher_model->bank_book_current_data($bid);
  //var_dump($psale); exit();
  $status = parent::HTTP_OK;
  $response = ['status' => $status,'total' => $total];
  $this->response($response,$status);
}


}	