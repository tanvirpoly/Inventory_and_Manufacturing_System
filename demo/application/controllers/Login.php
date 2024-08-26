<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

public function __construct()
    {
    parent::__construct();
    $this->load->model("prime_model",'pm');
    $this->load->library('email');
}

        ################################################
        #   /* Pages  start*/                          #
        ################################################

public function index()
  {
  $data['title'] = 'Sign In';
        
  $this->load->view('login',$data);
}

public function loginProcess()
  {
  $info = $this->input->post();

  $uname = $info['username'];
  if(is_numeric($uname))
    {     
    $where = array(
      'mobile'   => '+88'.$info['username'],
      'status'   => 'Active',
      'password' => $info['password']
            );
    }
  else
    {
    $where = array(
      'email'    => $info['username'],
      'status'   => 'Active',
      'password' => $info['password']
            );
    }
    // var_dump($where); //exit();
  $user_data = $this->pm->get_data('users',$where);
    //var_dump($user_data); exit();
  if($user_data)
    {
    $udata = [
      'uid'      => $user_data[0]['uid'],
      'name'     => $user_data[0]['name'],
      'compname' => $user_data[0]['compname'],
      'email'    => $user_data[0]['email'],
      'role'     => $user_data[0]['userrole'],
      'compid'   => $user_data[0]['compid'],
      'empid'    => $user_data[0]['empid']
            ];
        //var_dump($udata); //exit();
    $this->session->set_userdata($udata);
        
    $pwhere = array(
      'utype'  => $user_data[0]['userrole'],
      'compid' => $user_data[0]['compid']
            );

    $master = $this->pm->get_data('tbl_user_m_permission',$pwhere);
    $page = $this->pm->get_data('tbl_user_p_permission',$pwhere);
    $function = $this->pm->get_data('tbl_user_f_permission',$pwhere);
        //var_dump($pwhere); var_dump($page); var_dump($function); //exit();
    if($page)
      {
      $mdata = [
        'dashboard'    => $master[0]['dashboard'],
        'product'      => $master[0]['product'],
        'purchase'     => $master[0]['purchase'],
        'sales'        => $master[0]['sales'],
        'return'       => $master[0]['return'],
        'quotation'    => $master[0]['quotation'],
        'voucher'      => $master[0]['voucher'],
        'users'        => $master[0]['users'],
        'report'       => $master[0]['report'],
        'setting'      => $master[0]['setting'],
        'recipes'      => $master[0]['recipes'],
        'access_setup' => $master[0]['access_setup'],
        'manufacturers' => $master[0]['manufacturers'],
        'deliverys'    => $master[0]['deliverys'],
        'emp_payment'  => $master[0]['emp_payment'],
        'balance_transfer' => $master[0]['balance_transfer']
                        ];
                        
      $pdata = [
        'dashboard'         => $page[0]['dashboard'],
        'product_list'      => $page[0]['product_list'],
        'purchase_list'     => $page[0]['purchase_list'],
        'sales_list'        => $page[0]['sales_list'],
        'return_list'       => $page[0]['return_list'],
        'quotation_list'    => $page[0]['quotation_list'],
        'recipe_list'       => $page[0]['recipe_list'],
        'manufacturer_list' => $page[0]['manufacturer_list'],
        'delivery_list'     => $page[0]['delivery_list'],
        'voucher_list'      => $page[0]['voucher_list'],
        'salary_list'       => $page[0]['salary_list'],
        'transfer_list'     => $page[0]['transfer_list'],
        'customer'          => $page[0]['customer'],
        'supplier'          => $page[0]['supplier'],
        'employee'          => $page[0]['employee'],
        'user'              => $page[0]['user'],
        'sale_report'       => $page[0]['sale_report'],
        'purchase_report'   => $page[0]['purchase_report'],
        'profit_report'     => $page[0]['profit_report'],
        'customer_report'   => $page[0]['customer_report'],
        'customer_ledger'   => $page[0]['customer_ledger'],
        'supplier_report'   => $page[0]['supplier_report'],
        'supplier_ledger'   => $page[0]['supplier_ledger'],
        'stock_report'      => $page[0]['stock_report'],
        'voucher_report'    => $page[0]['voucher_report'],
        'daily_report'      => $page[0]['daily_report'],
        'cashbook'          => $page[0]['cashbook'],
        'bankbook'          => $page[0]['bankbook'],
        'mobilebook'        => $page[0]['mobilebook'],
        'total_product'     => $page[0]['total_product'],
        'order_report'      => $page[0]['order_report'],
        'sprofit_report'    => $page[0]['sprofit_report'],
        'due_report'        => $page[0]['due_report'],
        'bsale_report'      => $page[0]['bsale_report'],
        'stock_alert'       => $page[0]['stock_alert'],
        'bank_transction'   => $page[0]['bank_transction'],
        'expense_report'    => $page[0]['expense_report'],
        'duep_report'       => $page[0]['duep_report'],
        'vat_report'        => $page[0]['vat_report'],
        'sproduct_report'   => $page[0]['sproduct_report'],
        'dproduct_report'   => $page[0]['dproduct_report'],
        'trail_balance'     => $page[0]['trail_balance'],
        'balance_sheet'     => $page[0]['balance_sheet'],
        'cash_flow'         => $page[0]['cash_flow'],
        'income_statement'  => $page[0]['income_statement'],
        'category'          => $page[0]['category'],
        'unit'              => $page[0]['unit'],
        'cost_type'         => $page[0]['cost_type'],
        'department'        => $page[0]['department'],
        'bank_account'      => $page[0]['bank_account'],
        'mobile_account'    => $page[0]['mobile_account'],
        'user_type'         => $page[0]['user_type'],
        'online_store'      => $page[0]['online_store'],
        'about_us'          => $page[0]['about_us'],
        'company_setup'     => $page[0]['company_setup'],
        'accessetup'        => $page[0]['accessetup']
                        ];

      $fdata = [
        'new_product'         => $function[0]['new_product'],
        'store_product'       => $function[0]['store_product'],
        'edit_product'        => $function[0]['edit_product'],
        'delete_product'      => $function[0]['delete_product'],
        'import_product'      => $function[0]['import_product'],
        'new_purchase'        => $function[0]['new_purchase'],
        'edit_purchase'       => $function[0]['edit_purchase'],
        'delete_purchase'     => $function[0]['delete_purchase'],
        'new_sale'            => $function[0]['new_sale'],
        'edit_sale'           => $function[0]['edit_sale'],
        'delete_sale'         => $function[0]['delete_sale'],
        'new_return'          => $function[0]['new_return'],
        'edit_return'         => $function[0]['edit_return'],
        'delete_return'       => $function[0]['delete_return'],
        'new_quotation'       => $function[0]['new_quotation'],
        'edit_quotation'      => $function[0]['edit_quotation'],
        'delete_quotation'    => $function[0]['delete_quotation'],
        'new_recipe'          => $function[0]['new_recipe'],
        'edit_recipe'         => $function[0]['edit_recipe'],
        'delete_recipe'       => $function[0]['delete_recipe'],
        'new_manufacturer'    => $function[0]['new_manufacturer'],
        'edit_manufacturer'   => $function[0]['edit_manufacturer'],
        'delete_manufacturer' => $function[0]['delete_manufacturer'],
        'new_voucher'         => $function[0]['new_voucher'],
        'edit_voucher'        => $function[0]['edit_voucher'],
        'delete_voucher'      => $function[0]['delete_voucher'],
        'new_delivery'        => $function[0]['new_delivery'],
        'edit_delivery'       => $function[0]['edit_delivery'],
        'delete_delivery'     => $function[0]['delete_delivery'],
        'new_salary'          => $function[0]['new_salary'],
        'edit_salary'         => $function[0]['edit_salary'],
        'delete_salary'       => $function[0]['delete_salary'],
        'new_btransfer'       => $function[0]['new_btransfer'],
        'edit_btransfer'      => $function[0]['edit_btransfer'],
        'delete_btransfer'    => $function[0]['delete_btransfer'],
        'new_customer'        => $function[0]['new_customer'],
        'edit_customer'       => $function[0]['edit_customer'],
        'delete_customer'     => $function[0]['delete_customer'],
        'new_supplier'        => $function[0]['new_supplier'],
        'edit_supplier'       => $function[0]['edit_supplier'],
        'delete_supplier'     => $function[0]['delete_supplier'],
        'new_employee'        => $function[0]['new_employee'],
        'edit_employee'       => $function[0]['edit_employee'],
        'delete_employee'     => $function[0]['delete_employee'],
        'new_user'            => $function[0]['new_user'],
        'edit_user'           => $function[0]['edit_user'],
        'delete_user'         => $function[0]['delete_user'],
        'new_category'        => $function[0]['new_category'],
        'edit_category'       => $function[0]['edit_category'],
        'delete_category'     => $function[0]['delete_category'],
        'new_unit'            => $function[0]['new_unit'],
        'edit_unit'           => $function[0]['edit_unit'],
        'delete_unit'         => $function[0]['delete_unit'],
        'new_ctype'           => $function[0]['new_ctype'],
        'edit_ctype'          => $function[0]['edit_ctype'],
        'delete_ctype'        => $function[0]['delete_ctype'],
        'new_department'      => $function[0]['new_department'],
        'edit_department'     => $function[0]['edit_department'],
        'delete_department'   => $function[0]['delete_department'],
        'new_baccount'        => $function[0]['new_baccount'],
        'edit_baccount'       => $function[0]['edit_baccount'],
        'delete_baccount'     => $function[0]['delete_baccount'],
        'new_maccount'        => $function[0]['new_maccount'],
        'edit_maccount'       => $function[0]['edit_maccount'],
        'delete_maccount'     => $function[0]['delete_maccount'],
        'new_utype'           => $function[0]['new_utype'],
        'edit_utype'          => $function[0]['edit_utype'],
        'delete_utype'        => $function[0]['delete_utype']
                ];
        //var_dump($pdata); var_dump($fdata); exit();
      $this->session->set_userdata($mdata);
      $this->session->set_userdata($pdata);
      $this->session->set_userdata($fdata);
      }
    redirect('Dashboard');
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Invalid Login id or Password !</h4>
        </div>'
            ];

    $this->session->set_userdata($sdata);
    redirect('Login');
    }
}

public function register_account()
    {
    $data['title'] = 'Sign Up';
        
    $this->load->view('register',$data);
}

public function check_user_email()
  {
  $grup = $this->pm->check_user_email($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function save_register()
  {
  $info = $this->input->post();

  $ewhere = array(
    'email' => $info['email']
        );
  $edata = $this->pm->get_data('users',$ewhere);

  $mwhere = array(
    'mobile' => '+88'.$info['mobile']
        );
    //var_dump($mwhere); exit();
  $mdata = $this->pm->get_data('users',$mwhere);
  if($edata && $edata[0]['email'])
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> This email all ready Used !</h4>
        </div>'
        ];

    $this->session->set_userdata($sdata);
    redirect('signUp');
    }
  else if($mdata)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> This mobile number all ready Used !</h4>
        </div>'
        ];

    $this->session->set_userdata($sdata);
    redirect('signUp');
    }
  else
    {
    $digits = 6;
    $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $msg = $otp.' is your otp code for verify Account. Expires in 10 minites. Sunshine it';
    
    $mob = '+88'.$info['mobile'];

    $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
    $message = urlencode($msg);
    $to = urlencode($mob);
    $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
            
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
        
    $udata = array(
      'name'     => $info['name'],
      'otp'      => $otp,
      'compname' => $info['name'],
      'email'    => $info['email'],
      'mobile'   => '+88'.$info['mobile'],
      'password' => $info['password']
          );

    $this->session->set_userdata($udata);

    if($smsresult)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
          <h4><i class="icon fa fa-check"></i>User Register Successfully!. Enter OTP code, for verify your account.</h4>
          </div>'
          ];

      $this->session->set_userdata($sdata);
      redirect('OTP');
      }
    else
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Somethings is Wrong !</h4>
          </div>'
          ];

      $this->session->set_userdata($sdata);
      redirect('signUp');
      }
    }
}

// public function save_register()
//     {
//     $info = $this->input->post();

//     $ewhere = array(
//         'email' => $info['email']
//             );
//     $edata = $this->pm->get_data('users',$ewhere);

//     $mwhere = array(
//         'mobile' => '+88'.$info['mobile']
//             );
//     //var_dump($mwhere); exit();
//     $mdata = $this->pm->get_data('users',$mwhere);
//     if($edata && $edata[0]['email'])
//         {
//         $sdata = [
//           'exception' =>'<div class="alert alert-danger alert-dismissible">
//             <h4><i class="icon fa fa-ban"></i> This email all ready Used !</h4>
//             </div>'
//             ];

//         $this->session->set_userdata($sdata);
//         redirect('signUp');
//         }
//     else if($mdata)
//         {
//         $sdata = [
//           'exception' =>'<div class="alert alert-danger alert-dismissible">
//             <h4><i class="icon fa fa-ban"></i> This mobile number all ready Used !</h4>
//             </div>'
//             ];

//         $this->session->set_userdata($sdata);
//         redirect('signUp');
//         }
//     else
//         {
//         $query = $this->db->select('compid')
//                   ->from('users')
//                   ->limit(1)
//                   ->order_by('compid','DESC')
//                   ->get()
//                   ->row();
//         if($query)
//             {
//             $sn = substr($query->compid,7)+1;
//             }
//         else
//             {
//             $sn = 1;
//             }
//         //var_dump($sn); exit();
//         $cn = strtoupper(substr($info['name'],0,2));
//         $pc = sprintf("%'05d",$sn);

//         $empid = 'SUN-'.$cn.'-'.$pc;
        
//         $data = array(
//             'name'     => $info['name'],
//             'compid'   => $empid,
//             'compname' => $info['name'],
//             'email'    => $info['email'],
//             'mobile'   => '+88'.$info['mobile'],
//             'password' => $info['password']
//                 );

//         $result = $this->pm->insert_data('users',$data);

//         $udata = [
//             'uid'      => $result,
//             'name'     => $info['name'],
//             'compname' => $info['name'],
//             'email'    => $info['email'],
//             'role'     => 2,
//             'compid'   => $empid
//                 ];
//         //var_dump($sdata); exit();
//         $this->session->set_userdata($udata);
        
//         $cdata = array(
//             'com_name'   => $info['name'],
//             'compid'     => $empid,
//             'com_mobile' => '+88'.$info['mobile'],
//             'com_email'  => $info['email']
//                 );

//         $result = $this->pm->insert_data('com_profile',$cdata);
        
//         $pdata = [
//             'utype'        => 2,
//             'compid'       => $empid,
//             'regby'        => $result,
//             'dashboard'    => 1,
//             'product'      => 1,
//             'purchase'     => 1,
//             'sales'        => 1,
//             'return'       => 1,
//             'quotation'    => 1,
//             'voucher'      => 1,
//             'users'        => 1,
//             'report'       => 1,
//             'setting'      => 1,
//             'access_setup' => 1,
//             'help_support' => 1,
//             'Employee_payment' => 1
//                             ];

//         $fdata = [
//             'utype'                 => 2,
//             'compid'                => $empid,
//             'regby'                 => $result,
//             'add_product'           => 1,
//             'view_product'          => 1,
//             'edit_product'          => 1,
//             'delete_product'        => 1,
//             'store_product'         => 1,
//             'import_product'        => 1,
//             'new_purchase'          => 1,
//             'edit_purchase'         => 1,
//             'view_purchase'         => 1,
//             'delete_purchase'       => 1,
//             'new_sale'              => 1,
//             'view_sale'             => 1,
//             'edit_sale'             => 1,
//             'delete_sale'           => 1,
//             'new_return'            => 1,
//             'view_return'           => 1,
//             'edit_return'           => 1,
//             'delete_return'         => 1,
//             'new_quotation'         => 1,
//             'view_quotation'        => 1,
//             'edit_quotation'        => 1,
//             'delete_quotation'      => 1,
//             'new_voucher'           => 1,
//             'view_voucher'          => 1,
//             'edit_voucher'          => 1,
//             'delete_voucher'        => 1,
//             'customer'              => 1,
//             'supplier'              => 1,
//             'employee'              => 1,
//             'user'                  => 1,
//             'sales_report'          => 1,
//             'purchase_report'       => 1,
//             'profit_loss_report'    => 1,
//             'sales_purchase_report' => 1,
//             'customer_report'       => 1,
//             'customer_ledger'       => 1,
//             'supplier_report'       => 1,
//             'supplier_ledger'       => 1,
//             'stock_report'          => 1,
//             'voucher_report'        => 1,
//             'daily_report'          => 1,
//             'cash_book'             => 1,
//             'bank_book'             => 1,
//             'mobile_book'           => 1,
//             'category'              => 1,
//             'unit'                  => 1,
//             'expense_type'          => 1,
//             'department'            => 1,
//             'bank_account'          => 1,
//             'mobile_account'        => 1,
//             'notice'                => 1,
//             'user_type'             => 1,
//             'newPayment'            => 1
//                     ];

//         $this->pm->insert_data('tbl_user_m_permission',$pdata);
//         $this->pm->insert_data('tbl_user_p_permission',$pdata);
//         $this->pm->insert_data('tbl_user_f_permission',$fdata);
        
//         $cash = array(
//             'compid'   => $empid,
//             'cashName' => 'Cash in Hand',
//             'regby'    => $result
//                 );

//         $this->pm->insert_data('cash',$cash);

//         if($result)
//             {
//             $digits = 6;
//             $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
//             $msg = $otp.' is your otp code for verify Account. Expires in 10 minites. Sunshine it';
            
//             $mob = '+88'.$info['mobile'];
//             //$token = "44515996325214391599632521";
//             $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
//             $message = urlencode($msg);
//             $to = urlencode($mob);
//             $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
            
//             //$url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=NONSUNSHINEIT&sms=$message&msisdn=$to&csms_id=1";
//             //var_dump($url);exit();
//             $data = array(
//                 'to'      => "$to",
//                 'message' => "$message",
//                 'token'   =>"$token"
//                   );
                  
//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL,$url);
//             curl_setopt($ch, CURLOPT_ENCODING, '');
//             curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             $smsresult = curl_exec($ch);
//             //var_dump($smsresult); exit();
//             $udata = array(
//                 'otp'  => $otp,
//                 'uid' => $_SESSION['uid']
//                   );
//             //var_dump($udata); exit();

//             $uwhere = array(
//                 'mobile' => $mob,
//                 'uid' => $_SESSION['uid']
//                   );

//             $result2 = $this->pm->update_data('users',$udata,$uwhere);

//             if($result2)
//                 {
//                 $msg2 =  'User account id & password is https://sunshine.com.bd/app/ User: '.$info['mobile'].'Pass: '.$info['password'].' Sunshine It';
//                 //var_dump($msg2);
//                 $mob2 = '+8801714044180';
//                 //$token = "44515996325214391599632521";
//                 //$token2 = urlencode("4cc079b5-c2a5-4cdc-ac07-1ee0fe8e6b5d");
//                 $message2 = urlencode($msg2);
//                 $to2 = urlencode($mob2);
//                 $token2 = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
//                 $url2 = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token2&sid=SUNSHINEAPPOTP&sms=$msg2&msisdn=$to2&csms_id=1";
//                 //$url2 = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token2&sid=NONSUNSHINEIT&sms=$message2&msisdn=$to2&csms_id=1";
            
//               //var_dump($url); //exit();
//                 $mdata = array(
//                     'to'      => "$to2",
//                     'message' => "$message2",
//                     'token'   =>"$token2"
//                       );
                      
//                 $ch = curl_init();
//                 curl_setopt($ch, CURLOPT_URL,$url2);
//                 curl_setopt($ch, CURLOPT_ENCODING, '');
//                 curl_setopt($ch, CURLOPT_POSTFIELDS,$mdata);
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                 $smsresult = curl_exec($ch);
                
//                 //var_dump($smsresult);exit();
            
//                 $sdata = [
//                   'exception' =>'<div class="alert alert-success alert-dismissible">
//                     <h4><i class="icon fa fa-check"></i>User Register Successfully!. Enter OTP code, for verify your account.</h4>
//                     </div>'
//                     ];

//                 $this->session->set_userdata($sdata);
//                 redirect('OTP');
//                 }
//             else
//                 {
//                 $sdata = [
//                   'exception' =>'<div class="alert alert-success alert-dismissible">
//                     <h4><i class="icon fa fa-check"></i>Somethings is Wrong !</h4>
//                     </div>'
//                     ];

//                 $this->session->set_userdata($sdata);
//                 redirect('signUp');
//                 }
//             }
//         else
//             {
//             $sdata = [
//               'exception' =>'<div class="alert alert-danger alert-dismissible">
//                 <h4><i class="icon fa fa-ban"></i> Failed !</h4>
//                 </div>'
//                     ];

//             $this->session->set_userdata($sdata);
//             redirect('signUp');
//             }
//         }
// }

public function otp_checked()
    {
    $data['title'] = 'Account Verify';
        
    $this->load->view('otp_checked',$data);
}

public function save_otp_check()
  {
  $info = $this->input->post();
  $ewhere = array(
    'email' => $_SESSION['email']
        );
  $edata = $this->pm->get_data('users',$ewhere);

  $mwhere = array(
    'mobile' => $_SESSION['mobile']
        );
    //var_dump($mwhere); exit();
  $mdata = $this->pm->get_data('users',$mwhere);
  if($edata && $edata[0]['email'])
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> This email all ready Used !</h4>
        </div>'
        ];

    $this->session->set_userdata($sdata);
    redirect('OTP');
    }
  else if($mdata)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> This mobile number all ready Used !</h4>
        </div>'
        ];

    $this->session->set_userdata($sdata);
    redirect('OTP');
    }
  else if($info['otp'] == isset($_SESSION['otp']))
    {
    $query = $this->db->select('uid')
                  ->from('users')
                  ->limit(1)
                  ->order_by('uid','DESC')
                  ->get()
                  ->row();
    if($query)
      {
      $sn = $query->uid+1;
      }
    else
      {
      $sn = 1;
      }
        //var_dump($sn); exit();
    $cn = strtoupper(substr($_SESSION['name'],0,2));
    $pc = sprintf("%'05d",$sn);

    $empid = 'SUN-'.$cn.'-'.$pc;
        
    $data = array(
      'name'     => $_SESSION['name'],
      'compid'   => $empid,
      'compname' => $_SESSION['name'],
      'email'    => $_SESSION['email'],
      'mobile'   => $_SESSION['mobile'],
      'password' => $_SESSION['password'],
      'status'   => 'Active',
          );
    
    $result = $this->pm->insert_data('users',$data);

    $cdata = array(
      'com_name'   => $_SESSION['name'],
      'compid'     => $empid,
      'com_mobile' => $_SESSION['mobile'],
      'com_email'  => $_SESSION['email']
          );

    $this->pm->insert_data('com_profile',$cdata);
    
    $pdata = [
        'utype'        => 2,
        'compid'       => $empid,
        'regby'        => $result,
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
        'regby'                 => $result,
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

    $this->pm->insert_data('tbl_user_m_permission',$pdata);
    $this->pm->insert_data('tbl_user_p_permission',$pdata);
    $this->pm->insert_data('tbl_user_f_permission',$fdata);

    $cash = array(
      'compid'   => $empid,
      'cashName' => 'Cash in Hand',
      'regby'    => $result
          );

    $this->pm->insert_data('cash',$cash);
    
    $mob = $_SESSION['mobile'];
    $pass = $_SESSION['password'];
    $this->session->sess_destroy();
    
    $msg = "Welcome To Sunshine. Your software is ready tos use \nURL: https://sunshine.com.bd/app/"."\nID : ".$mob."\nPass : ".$pass."\nThank You\nSunshine IT";
        //var_dump($msg); exit();
    $message = urlencode($msg);
    $to = urlencode($mob);
    $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
    $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
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
    
    $ms2g = "New User : ".$_SESSION['name']."\nMobile : ".$mob;
        //var_dump($msg); exit();
    $mess2age = urlencode($ms2g);
    $to2 = '+8801714044180';;
    $token2 = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
    $url2 = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
          //var_dump($url); //exit();
    $data2 = array(
      'to'      => "$to2",
      'message' => "$mess2age",
      'token'   =>"$token2"
        );
                  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url2);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    
    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
          <h4><i class="icon fa fa-check"></i>Account Verify Successfully !</h4>
          </div>'
              ];  

      $this->session->set_userdata($sdata);
      redirect('Login');
      }
    else
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-ban"></i> Failed !</h4>
          </div>'
              ];

      $this->session->set_userdata($sdata);
      redirect('OTP');
      }
    }
  else
    {
    $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-ban"></i> OTP can not Match !</h4>
          </div>'
              ];

      $this->session->set_userdata($sdata);
      redirect('OTP');
    }
}

// public function save_otp_check()
//     {
//     $info = $this->input->post();

//     $where = array(
//         'otp' => $info['otp'],
//         'uid' => $_SESSION['uid']
//             );

//     $data = array(
//         'status' => 'Active',
//         'upby'   => $_SESSION['uid']
//             );
//         //var_dump($where); exit();
//     $result = $this->pm->update_data('users',$data,$where);
    
//     $users = $this->pm->get_data('users',$where);
    
//     $mob = $users[0]['mobile'];
//     $snmob = substr($mob,3);
//     $pass = $users[0]['password'];
    
//     $msg = "Welcome To Sunshine. Your software is ready tos use \nURL: https://sunshine.com.bd/app/"."\nID : ".$snmob."\nPass : ".$pass."\nThank You\nSunshine IT";
//         //var_dump($msg); exit();
//     //$token = "44515996325214391599632521";
//     //$token = urlencode("4cc079b5-c2a5-4cdc-ac07-1ee0fe8e6b5d");
//     $message = urlencode($msg);
//     $to = urlencode($mob);
//     $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
//     $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
//     //$url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=NONSUNSHINEIT&sms=$message&msisdn=$to&csms_id=1";
//           //var_dump($url); //exit();
//     $data = array(
//         'to'      => "$to",
//         'message' => "$message",
//         'token'   =>"$token"
//           );
                  
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL,$url);
//     curl_setopt($ch, CURLOPT_ENCODING, '');
//     curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $smsresult = curl_exec($ch);

//     if($result)
//         {
//         $sdata = [
//           'exception' =>'<div class="alert alert-success alert-dismissible">
//             <h4><i class="icon fa fa-check"></i>Account Verify Successfully !</h4>
//             </div>'
//                 ];  

//         $this->session->set_userdata($sdata);
//         redirect('Login');
//         }
//     else
//         {
//         $sdata = [
//           'exception' =>'<div class="alert alert-danger alert-dismissible">
//             <h4><i class="icon fa fa-ban"></i> Failed !</h4>
//             </div>'
//                 ];

//         $this->session->set_userdata($sdata);
//         redirect('OTP');
//         }
// }

public function forget_password()
    {
    $data['title'] = 'Forget Password';
        
    $this->load->view('forget_password',$data);
}

public function check_forget_password_email()
  {
  $this->load->library('email');

  $empemail = $this->input->post('username');
  
  if(is_numeric($empemail))
    {
    $mid = '+88'.$this->input->post('username');
    $fpe = $this->pm->check_mobile_number($mid);
    // var_dump($fpe); var_dump($mid); exit();
    
    if($fpe)
        {
        $prdata = [
            'useruid' => $fpe->uid
                ];
        
        $this->session->set_userdata($prdata);
        
        $digits = 6;
        $otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $msg = $otp.' is your otp code for verify. Expires in 10 minites. SunshineApp';
        
        //$token = "44515996325214391599632521";
        //$token = urlencode("4cc079b5-c2a5-4cdc-ac07-1ee0fe8e6b5d");
        $message = urlencode($msg);
        $to = urlencode($mid);
        $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
        $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
        //$url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=NONSUNSHINEIT&sms=$message&msisdn=$to&csms_id=1";
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
    	
    	//var_dump($smsresult); exit();
        
        $udata = array(
            'otp'  => $otp,
            'upby' => $_SESSION['useruid']
              );

        $uwhere = array(
            'mobile' => $mid,
            'uid'    => $_SESSION['useruid']
              );

        $result = $this->pm->update_data('users',$udata,$uwhere);
            
        if($result)
            {
            $sdata = [
                'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i> Enter Your OTP code !</h4>
                </div>'
                    ];
    
            $this->session->set_userdata($sdata);
            redirect('otpPassword');
            }
        else
            {
            $sdata = [
                'exception' =>'<div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Somethings is Wrong !</h4>
                </div>'
                    ];
        
            $this->session->set_userdata($sdata);
            redirect('forgetPassword');
            }
        }
      else
        {
        $sdata = [
            'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> This mobile is not exit !</h4>
            </div>'
                ];
    
        $this->session->set_userdata($sdata);
        redirect('forgetPassword');
        }
    }
    else
      {
      $fpe = $this->pm->check_email($empemail);
      
      $prdata = [
        'useruid' => $fpe->uid
            ];
    
        $this->session->set_userdata($prdata);
        //var_dump($fpe); exit();
      if($fpe)
        {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://sunshine.com.bd', 
            'smtp_port' => 465,
            'smtp_user' => 'example@gmail.com',
            'smtp_pass' => 'password',
            'smtp_crypto' => 'ssl',
            'mailtype' => 'text',
            'smtp_timeout' => '4', 
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
                );

        $to = $fpe->email;

        $message = "Reset your SunshineApp account password.We received a request to reset your SunshineApp account password. Please use the following one-time password to verify yourself. then click the link given below to confirm your identity and reset your password. The link is valid for 6 hours till 15 Jan 2022";
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from('example@gmail.com'); // change it to yours
        $this->email->to($to);// change it to yours
        $this->email->subject('Forget Password');
        $this->email->message($message);
        //var_dump($this->email->send()); exit();
        if($this->email->send())
            {
            $sdata = [
                'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i>Check Your email !</h4>
                </div>'
                        ];  
    
            $this->session->set_userdata($sdata);
            redirect('Login');
            }
        else
            {
            $sdata = [
                'exception' =>'<div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Somethings is Wrong !</h4>
                </div>'
                    ];
    
            $this->session->set_userdata($sdata);
            redirect('forgetPassword');
            }
        }
      else
        {
        $sdata = [
            'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> This email id is not exit !</h4>
            </div>'
                ];
    
        $this->session->set_userdata($sdata);
        redirect('forgetPassword');
        }
    }
}

public function otp_password()
    {
    $data['title'] = 'Forget Password';
        
    $this->load->view('otp_password',$data);
}

public function check_otp()
    {
    $info = $this->input->post();

    $where = array(
        'otp' => $info['otp'],
        'uid' => $_SESSION['useruid']
            );
    
    $result = $this->pm->get_data('users',$where);
   // var_dump($result); exit();

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Password Setup !</h4>
            </div>'
                ];  

        $this->session->set_userdata($sdata);
        redirect('passwordSetup');
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];

        $this->session->set_userdata($sdata);
        redirect('forgetPassword');
        }
}

public function logout()
    {
    $this->session->sess_destroy();
    redirect('Login');
}

public function account_verify()
    {
    $where = [
        'email' => $_SESSION['useremail']
            ];

    $info = [
        'status' => 'Active',
        'upby'   => $_SESSION['uid']
            ];
       
    $result = $this->pm->update_data('users',$info,$where);
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>User verify Successfully !</h4>
            </div>'
                ];  
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Failed !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('Login');
}

public function password_setup()
    {
    $data['title'] = 'Password Setup';
        
    $this->load->view('pass_setup',$data);
}

public function save_passord_setup()
    {
    $info = $this->input->post();

    $npassword = $info['npassword'];
    $cpassword = $info['cpassword'];

    if($npassword == $cpassword)
        {
        $info = [
            'password' => $info['npassword'],
            'upby'     => $_SESSION['useruid']
                ];
        
        $where = array(
            'uid' => $_SESSION['useruid']
                );
        //var_dump($where); exit();
        $result = $this->pm->update_data('users',$info,$where);

        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i>New Password Setup Successfully !</h4>
                </div>'
                    ];  

            $this->session->set_userdata($sdata);
            //$this->session->unset_userdata($prdata);
            redirect('Login');
            }
        else
            {
            $sdata = [
              'exception' =>'<div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Failed !</h4>
                </div>'
                    ];

            $this->session->set_userdata($sdata);
            redirect('passwordSetup');
            }
        }
    else
        {
        $sdata = [
            'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Password can not match !</h4>
            </div>'
                ];

        $this->session->set_userdata($sdata);
        redirect('passwordSetup');
        }
}



        ################################################
        #   /* Pages  end*/                            #
        ################################################
}