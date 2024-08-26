<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Auth
extends REST_Controller
{
    public function __construct() {

        parent::__construct();

        /*
        ## Load these helper to create JWT tokens
        */
        $this->load->helper(['jwt', 'authorization']); 

        /*
        ## Load auth model
        */
        $this->load->model('api/auth_model');
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
	## Login Request
	*/
    public function login_post()
	{
		/*
		# Receipt post request
		*/
        $email = $this->post('email');
        $password = $this->post('password');

        /*
        # Check if valid user
        */
        $user = $this->auth_model->check_user_is_valid($email, $password);

        if ($user) {
            
            /*
            # Create a token from the user data and send it as reponse
            */
            $token = AUTHORIZATION::generateToken(['email' => $email]);
            /*
            # Prepare the response
            */
            $status = parent::HTTP_OK;
            $response = ['status' => $status, 'token' => $token, 'data' => $user];
            $this->response($response, $status);
        }
        else {
            $this->response(['msg' => 'Invalid email or password!'], parent::HTTP_NOT_FOUND);
        }
	}

public function mobile_varificattion_post()
	{
	$flag = true;
	
	if($this->post('mobile') == '')
		{
		$error['mobile'] = 'Mobile field is required!';
		$flag = false;
		}
		
    $mobile = '+88'.$this->post('mobile');
    //var_dump($mobile); exit();
    
	if($this->auth_model->check_mobile_duplicate($mobile))
		{
		$error['mobile'] = 'Mobile number is duplicate try another!';
		$flag = false;
		}
	$user = $this->auth_model->check_mobile_number($mobile);
    //var_dump($user); exit();

	if($user)
	    {
	    $digits = 6;
       // $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $otp = $this->post('otp_code');
        $msg = $otp.' is your otp code for verify Account. Expires in 10 minites. Sunshine it';
        
        $mob = '+88'.$this->post('mobile');
        //$token = "44515996325214391599632521";
        $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
        $message = urlencode($msg);
        $to = urlencode($mob);
        //$url = "http://sms.iglweb.com/api/v1/send?api_key=44516045544714651604554471&contacts=$to&senderid=8801844532630&msg=$message";
        $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=NONSUNSHINEIT&sms=$message&msisdn=$to&csms_id=1";
        //var_dump($url);exit();
        $data = array(
            'to'      => "$to",
            'message' => "$message",
            'token'   =>"$token"
              );
              
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
            //var_dump($smsresult); exit();
        $udata = array(
            'otp'  => $otp,
            'mobile' => $mob
              );
        //var_dump($udata); exit();

        $uwhere = array(
            'mobile' => $mob,
            'otp' => $otp
              );

       // $result2 = $this->auth_model->insert_data('users',$udata);

        $status = parent::HTTP_OK;
	    $response = ['status' => $status, 'message' => 'Mobile Verification Successfully!.'];
	    $this->response($response, $status);
        }
	else
		{
		$status = parent::HTTP_BAD_REQUEST;
		$response = ['status' => $status, 'message' => 'Verification failed!'];
		$this->response($response, $status);
	    }
}

public function conform_mobile_otp_post()
  {
  $mobile = '+88'.$this->post('mobile');
  $otp = $this->post('otp');
    //var_dump($mobile);var_dump($otp); exit();
      $udata = array(
            'otp'  => $otp,
            'mobile' => $mobile
              );
    $result2 = $this->auth_model->insert_data('users',$udata);
  $user = $this->auth_model->otp_check($mobile,$otp);
  
  //var_dump($user); exit();

  if($user)
    {
    $urdata = array(
        'status'  => 'Active'
            );
    //var_dump($udata); exit();

    $urwhere = array(
        'mobile' => $mobile
          );

	$this->auth_model->update_data('users',$urdata,$urwhere);
	
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $user, 'message' => 'Registration Your Account'];
    $this->response($response, $status);
    }
  else
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'message' => 'Somethings is Wrong!'];
    $this->response($response, $status);
    }     
}

	/*
	## Registration Request
	*/
	public function registration_post()
	{
		$flag = true;

		if($this->post('name') == '')
		{
			$error['name'] = 'Name field is required!';
			$flag = false;
		}

		if($this->post('compname') == '')
		{
			$error['compname'] = 'Company field is required!';
			$flag = false;
		}

		if($this->auth_model->check_compname_duplicate($this->post('compname')))
		{
			$error['compname'] = 'Company name is duplicate try another!';
			$flag = false;
		}

        // 		if($this->post('email') == '')
        // 		{
        // 			$error['email'] = 'Email field is required!';
        // 			$flag = false;
        // 		}
        
        // 		if($this->auth_model->check_email_duplicate($this->post('email')))
        // 		{
        // 			$error['email'] = 'Email Address is duplicate try another!';
        // 			$flag = false;
        // 		}
		
		if($this->post('mobile') == '')
		{
			$error['mobile'] = 'Mobile field is required!';
			$flag = false;
		}

// 		if($this->auth_model->check_mobile_duplicate($this->post('mobile')))
// 		{
// 			$error['mobile'] = 'Mobile number is duplicate try another!';
// 			$flag = false;
// 		}

		if($this->post('password') == 'password')
		{
			$error['password'] = 'Pssword field is required!';
			$flag = false;
		}

		if ($flag == false)
		{
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Registration failed!', 'error' => $error];
			$this->response($response, $status);
		}
		else
		{
		$mobile = '+88'.$this->post('mobile');
		
		$query = $this->db->select('compid')
                  ->from('users')
                  ->where('mobile',$mobile)
                  ->get()
                  ->row();
        if($query)
            {
            $sn = substr($query->compid,7)+1;
            }
        else
            {
            $sn = 1;
            }
        //var_dump($sn); exit();
        $cn = strtoupper(substr($this->post('compname'),0,2));
        $pc = sprintf("%'05d",$sn);

        $empid = 'SUN-'.$cn.'-'.$pc;
        
// 		$data['compid'] = $empid;
// 		$data['name'] = $this->post('name');
// 		$data['compname'] = $this->post('compname');
// 		$data['email'] = $this->post('email');
// 		$data['mobile'] = '+88'.$this->post('mobile');
// 		$data['password'] = $this->post('password');
// 		$data['regby'] = $this->post('regby');
		//$data['status'] = $this->post('status');
		
		$urdata = array(
            'compid'  => $empid,
            'name'  => $this->post('name'),
            'compname'  => $this->post('compname'),
            'email'  => $this->post('email'),
            'password'  => $this->post('password'),
            'regby'  => $this->post('regby')
              );
        //var_dump($udata); exit();

        $urwhere = array(
            'mobile' => $mobile
              );

		$user = $this->auth_model->update_data('users',$urdata,$urwhere);
		
		$cdata = array(
            'com_name'   => $this->post('compname'),
            'compid'     => $empid,
            'com_mobile' => $mobile,
            'com_email'  => $this->post('email')
                );

        $this->auth_model->insert_data('com_profile',$cdata);
		
		$pdata = [
            'utype'        => 2,
            'compid'       => $empid,
            'regby'        => $user,
            'dashboard'    => 1,
            'product'      => 1,
            'purchase'     => 1,
            'sales'        => 1,
            'return'       => 1,
            'quotation'    => 1,
            'voucher'      => 1,
            'users'        => 1,
            'report'       => 1,
            'setting'      => 1,
            'access_setup' => 1,
            'help_support' => 1,
            'Employee_payment' => 1
                            ];

        $fdata = [
            'utype'                 => 2,
            'compid'                => $empid,
            'regby'                 => $user,
            'add_product'           => 1,
            'view_product'          => 1,
            'edit_product'          => 1,
            'delete_product'        => 1,
            'store_product'         => 1,
            'import_product'        => 1,
            'new_purchase'          => 1,
            'edit_purchase'         => 1,
            'view_purchase'         => 1,
            'delete_purchase'       => 1,
            'new_sale'              => 1,
            'view_sale'             => 1,
            'edit_sale'             => 1,
            'delete_sale'           => 1,
            'new_return'            => 1,
            'view_return'           => 1,
            'edit_return'           => 1,
            'delete_return'         => 1,
            'new_quotation'         => 1,
            'view_quotation'        => 1,
            'edit_quotation'        => 1,
            'delete_quotation'      => 1,
            'new_voucher'           => 1,
            'view_voucher'          => 1,
            'edit_voucher'          => 1,
            'delete_voucher'        => 1,
            'customer'              => 1,
            'supplier'              => 1,
            'employee'              => 1,
            'user'                  => 1,
            'sales_report'          => 1,
            'purchase_report'       => 1,
            'profit_loss_report'    => 1,
            'sales_purchase_report' => 1,
            'customer_report'       => 1,
            'customer_ledger'       => 1,
            'supplier_report'       => 1,
            'supplier_ledger'       => 1,
            'stock_report'          => 1,
            'voucher_report'        => 1,
            'daily_report'          => 1,
            'cash_book'             => 1,
            'bank_book'             => 1,
            'mobile_book'           => 1,
            'category'              => 1,
            'unit'                  => 1,
            'expense_type'          => 1,
            'department'            => 1,
            'bank_account'          => 1,
            'mobile_account'        => 1,
            'notice'                => 1,
            'user_type'             => 1,
            'newPayment'            => 1
                    ];

        $this->auth_model->insert_data('tbl_user_m_permission',$pdata);
        $this->auth_model->insert_data('tbl_user_p_permission',$pdata);
        $this->auth_model->insert_data('tbl_user_f_permission',$fdata);

		if($user)
		    {
			$get_data = $this->auth_model->recent_user_data($mobile);
			
            $status = parent::HTTP_OK;
		    $response = ['status' => $status, 'message' => 'User Register Successfully!.', 'data' => $get_data];
		    $this->response($response, $status);
			}
		else
		    {
			$status = parent::HTTP_BAD_REQUEST;
			$response = ['status' => $status, 'message' => 'Registration failed!'];
			$this->response($response, $status);
			}
		}
	}
	
	/*
	## User logout
	*/
    public function logout_post()
	{
	    /*
	    ## delete all session
	    */
  		session_destroy();
	    /*
	    ## Send the return data as reponse
	    */
	    $status = parent::HTTP_OK;
	    $response = ['status' => $status, 'message' => 'logout successfully'];
	    $this->response($response, $status);
	}

	/*
	## get company profile
	*/
	public function profile_post()
	{
		$this->verify_request();
		/*
		## Attempt database model
		*/
		$data = $this->auth_model->get_company_profile($this->post('compid'));

		$status = parent::HTTP_OK;
		$response = ['status' => $status, 'data' => $data];
		$this->response($response, $status);
	}
	
	/*
	## Password Reset
	*/
public function password_reset_post()
  {
  $mobile = '+88'.$this->post('email');
  $user = $this->auth_model->check_mobile_duplicate($mobile);
      //var_dump($user); exit();
      
  if(!$user)
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'error' => 'This mobile Number is not exit!'];
    $this->response($response, $status); 
    }
  else
    {
    $digits = 6;
    $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $msg = $otp.' is your otp code for verify. Expires in 10 minites. Sunshine it';
    
    $mid = '+88'.$this->post('email');
    //$mid = '+88'.$mobile;
    //$token = "44515996325214391599632521";
    $token = urlencode("4cc079b5-c2a5-4cdc-ac07-1ee0fe8e6b5d");
    $message = urlencode($msg);
    $to = urlencode($mid);
            //$url = "http://sms.iglweb.com/api/v1/send?api_key=44516045544714651604554471&contacts=$to&senderid=8801844532630&msg=$message";
    $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=NONSUNSHINEIT&sms=$message&msisdn=$to&csms_id=1";
          //var_dump($url); //exit();
    $data = array(
      'to'      => "$to",
      'message' => "$message",
      'token'   =>"$token"
        );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);
    
    $odata = array(
        'otp'  => $otp
          );
    //var_dump($udata); var_dump($mid); exit();
    $this->auth_model->update_user_otp_data($odata,$mid);
            
    if($smsresult)
      {
      $status = parent::HTTP_OK;
      $response = ['status' => $status, 'data' => $mid, 'message' => 'Check Your mobile!'];
      $this->response($response, $status); 
      }
    else
      {
      $status = parent::HTTP_BAD_REQUEST;
      $response = ['status' => $status, 'message' => 'Somethings is Wrong!'];
      $this->response($response, $status);
      }
    }
}

public function conform_otp_post()
  {
  $mobile = $this->post('mobile');
  $otp = $this->post('otp');
    //var_dump($mobile);var_dump($otp); exit();
  $user = $this->auth_model->otp_check($mobile,$otp);

  if($user)
    {
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'data' => $user, 'message' => 'Setup New Password'];
    $this->response($response, $status);
    }
  else
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'message' => 'Somethings is Wrong!'];
    $this->response($response, $status);
    }     
}

public function new_pasword_post()
  {
  $npassword = $this->post('npassword');
  $cpassword = $this->post('cpassword');
  $uid = $this->post('uid');

  if($npassword == $cpassword)
    {
    $info = [
      'password' => $npassword
          ];
    $user = $this->auth_model->new_pasword_setup($info,$uid);
    // var_dump($user); exit();
    // if($user)
    //   {
      $status = parent::HTTP_OK;
      $response = ['status' => $status, 'data' => $npassword, 'message' => 'New Password Setup Successfully'];
      $this->response($response, $status);
    //   }
    // else
    //   {
    //   $status = parent::HTTP_BAD_REQUEST;
    //   $response = ['status' => $status, 'message' => 'Wrong!'];
    //   $this->response($response, $status);
    //   }   
    }
  else
    {
    $status = parent::HTTP_BAD_REQUEST;
    $response = ['status' => $status, 'message' => 'Somethings is Wrong!'];
    $this->response($response, $status);
    }     
}
	
	/*
	## Set New Password
	*/
	public function new_password_set_post($user_id = null) {
	    $password = $this->post('password');
	    $confirm_password = $this->post('confirm_password');
	    
	    if($password != $confirm_password) {
	        $status = parent::HTTP_BAD_REQUEST;
	        $response = ['status' => $status, 'message' => 'Password does not match!'];
		    $this->response($response, $status);
	    } else {
	        $data = array("password"	=> $password);

			$user = $this->auth_model->put_password($user_id, $data);

			if($user)
			{
			    $get_data = $this->auth_model->recent_user($user_id);
			    
			    
			     ## Email Send
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
            
                //$mail->isSMTP();
                $mail->Host     = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'example@gmail.com';
                $mail->Password = 'Pasword';
                $mail->SMTPSecure = 'ssl';
                $mail->Port     = 465;
                
                $to = $get_data->email;
                $password = $get_data->password;
                $username = $get_data->email;
                //var_dump($password);var_dump($username); exit();
                $mail->setFrom('example@gmail.com','SAAS User Register');
                $mail->addReplyTo('example@gmail.com','SAAS User Register');
                $mail->addAddress($to);
                $mail->Subject = 'Password Reset Successfully';
                $mail->isHTML(true);
                $mailContent = "<p>
                              <h3>Hi !</h3>
                              <h4>Reset your Sunshine Account Password.</h4>
                              <p>We have received a request to reset your Sunshine account password associated with this email address. If you have not placed this request, you can safely ignore this email and we assure you that your account is completely secure.</p>
                              <p>If you do need to change your Sunshine Password, you can use the link given below.</p>
                              <b>New Password Setup : http://sunshine.com.bd/app/passwordSetup .</b>
                              <p>Please contact <b style='color: green;'>support@sunshine.com.bd</b> for any queries regarding this.</p><br>
                              <h5>Cheers</h5>
                              <h6>Sunshine Team</h6>
                              <h6><b style='color: green;'>www.sunshine.com.bd</b></h6>
                              </p>";
                $mail->Body = $mailContent;
                
                if($mail->send()) {
                    $status = parent::HTTP_OK;
				    $response = ['status' => $status, 'message' => 'Password Reset Successfull'];
				    $this->response($response, $status);
                } else{
                   $status = parent::HTTP_BAD_REQUEST;
    	           $response = ['status' => $status, 'message' => 'Somethings is Wrong!'];
    		       $this->response($response, $status);
                }
			    
			}
			else
			{
				$status = parent::HTTP_BAD_REQUEST;
				$response = ['status' => $status, 'message' => 'Password Reset Failed!'];
				$this->response($response, $status);
			}
	    }
	}

}
/* End of file Api.php */ 