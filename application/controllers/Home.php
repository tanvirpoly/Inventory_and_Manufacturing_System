<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Home extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model",'pm');       
  $this->checkPermission();
}

        ################################################
        #   /* Pages  start*/                          #
        ################################################

public function index()
  {
  $data['title'] = 'Dashboard';

  $data['sale'] = $this->pm->today_sales_amount();
  $data['purchase'] = $this->pm->today_purchases_amount();
  $data['cvoucher'] = $this->pm->today_cvoucher_amount();
  $data['dvoucher'] = $this->pm->today_dvoucher_amount();
  $data['svoucher'] = $this->pm->today_svoucher_amount();

  $data['user'] = $this->pm->count_all_user();
  $data['auser'] = $this->pm->count_all_active_user();
  $data['iuser'] = $this->pm->count_all_inactive_user();
  $data['tuser'] = $this->pm->count_all_today_user();
  $data['muser'] = $this->pm->count_all_month_user();
    
  $this->load->view('home',$data);
}

public function setting_pages()
  {
  $data['title'] = 'Setting';

  $data['category'] = $this->pm->total_category();
  $data['unit'] = $this->pm->total_unit();
  $data['expense'] = $this->pm->total_expense_type();
  $data['dept'] = $this->pm->total_depertment();
  $data['mdept'] = $this->pm->manu_department();
  $data['cash'] = $this->pm->total_cash_account();
  $data['bank'] = $this->pm->total_bank_account();
  $data['mobile'] = $this->pm->total_mobile_account();
  $data['notice'] = $this->pm->total_notice();
  $data['utype'] = $this->pm->total_user_type();
  $data['warehouse'] = $this->pm->count_all('com_profile');
  
  $this->load->view('setting_pages',$data);
}

public function user_setting_pages()
  {
  $data['title'] = 'User';

  $data['customer'] = $this->pm->total_customer();
  $data['supplier'] = $this->pm->total_supplier();
  $data['employee'] = $this->pm->total_employee();
  $data['user'] = $this->pm->total_user();
  
  $this->load->view('user_setting',$data);
}

public function user_reports_pages()
  {
  $data['title'] = 'User Reports';

  $data['sale'] = $this->pm->total_sale();
  $data['purchase'] = $this->pm->total_purchase();
  $data['psale'] = $this->pm->total_sales_amount();
  $data['ppurchase'] = $this->pm->total_purchases_amount();
  $data['pempp'] = $this->pm->total_emp_payments_amount();
  $data['preturn'] = $this->pm->total_returns_amount();
  $data['pcvoucher'] = $this->pm->total_cvoucher_amount();
  $data['pdvoucher'] = $this->pm->total_dvoucher_amount();
  $data['psvoucher'] = $this->pm->total_svoucher_amount();
  $data['customer'] = $this->pm->total_customer();
  $data['supplier'] = $this->pm->total_supplier();
  $data['stock'] = $this->pm->total_stock();
  $data['rstock'] = $this->pm->total_rawstock();
  $data['fstock'] = $this->pm->total_finishstock();
  $data['voucher'] = $this->pm->total_voucher();
  
  $data['psale'] = $this->pm->pre_sales_amount();
  $data['ppurchase'] = $this->pm->pre_purchases_amount();
  $data['pcvoucher'] = $this->pm->pre_cvoucher_amount();
  $data['pdvoucher'] = $this->pm->pre_dvoucher_amount();
  $data['psvoucher'] = $this->pm->pre_svoucher_amount();
  $data['pempp'] = $this->pm->pre_emp_payments_amount();
  $data['preturn'] = $this->pm->pre_returns_amount();

  $data['csale'] = $this->pm->today_sales_amount();
  $data['cpurchase'] = $this->pm->today_purchases_amount();
  $data['ccvoucher'] = $this->pm->today_cvoucher_amount();
  $data['cdvoucher'] = $this->pm->today_dvoucher_amount();
  $data['csvoucher'] = $this->pm->today_svoucher_amount();
  $data['cempp'] = $this->pm->today_emp_payments_amount();
  $data['creturn'] = $this->pm->today_returns_amount();
  
  $data['ksale'] = $this->pm->cash_sales_amount();
  $data['kpurchase'] = $this->pm->cash_purchases_amount();
  $data['kcvoucher'] = $this->pm->cash_cvoucher_amount();
  $data['kdvoucher'] = $this->pm->cash_dvoucher_amount();
  $data['ksvoucher'] = $this->pm->cash_svoucher_amount();
  $data['kempp'] = $this->pm->cash_emp_payments_amount();
  $data['kreturn'] = $this->pm->cash_returns_amount();

  $data['bsale'] = $this->pm->bank_sales_amount();
  $data['bpurchase'] = $this->pm->bank_purchases_amount();
  $data['bcvoucher'] = $this->pm->bank_cvoucher_amount();
  $data['bdvoucher'] = $this->pm->bank_dvoucher_amount();
  $data['bsvoucher'] = $this->pm->bank_svoucher_amount();
  $data['bempp'] = $this->pm->bank_emp_payments_amount();
  $data['breturn'] = $this->pm->bank_returns_amount();

  $data['msale'] = $this->pm->mobile_sales_amount();
  $data['mpurchase'] = $this->pm->mobile_purchases_amount();
  $data['mcvoucher'] = $this->pm->mobile_cvoucher_amount();
  $data['mdvoucher'] = $this->pm->mobile_dvoucher_amount();
  $data['msvoucher'] = $this->pm->mobile_svoucher_amount();
  $data['mempp'] = $this->pm->mobile_emp_payments_amount();
  $data['mreturn'] = $this->pm->mobile_returns_amount();
  
  $data['product'] = $this->pm->total_products();
  
  $this->load->view('report_settings',$data);
}

public function profile() 
  {
  $data['title'] = 'User Profile';
  
  $data['company'] = $this->pm->company_details();

  $data['user'] = $this->pm->get_profile_data();
  
  $this->load->view('profile',$data);
}

public function profile_update()
  {
  $config['upload_path'] = './upload/users/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload', $config);
  $this->upload->initialize($config);
  if($this->upload->do_upload('user_photo'))
    {
    $img = $this->upload->data('file_name');
    }
  else
    {
    $img = '';
    }

  $data = array('photo' =>  $img);
  $where = array('uid' => $this->input->post('uid'));
  $result = $this->pm->update_data('users',$data,$where);

  redirect('myProfile');
}

public function company_profile()
  {
  $data['title'] = 'Profile';
  
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('company_profile',$data);
}

public function account_setting()
  {
  $data['title'] = 'Account Setting';
    
  $this->load->view('accountSetting',$data);
}

public function save_account_setting()
  {
  $cpassword = $this->input->post('cpassword');
  $password  = $this->input->post('password');
  $npassword = $this->input->post('npassword');

  if ($password == $npassword)
    {
    $cpc = $this->pm->current_password_check($cpassword);
    //var_dump($fpe); exit();
    if($cpc)
      {
      $empdata = [
        'password' => $password,
        'upby'     => $_SESSION['uid']
            ];

      $where = [
        'compid' => $_SESSION['compid'],
        'uid'    => $_SESSION['uid']
            ];   
            
      $result = $this->pm->update_data('users',$empdata,$where);

      if($result)
        {
        $sdata = [
          'exception' => '<div class="alert alert-primary alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Account Setting is complete. !</h4>
            </div>'
                ]; 

        $this->session->set_userdata($sdata);
        redirect('Home');
         }
      else
        {
        $sdata = [
          'exception' => '<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Some things is worng. Check !</h4>
            </div>'
                ]; 

        $this->session->set_userdata($sdata);
        redirect('aSetting');
        }
      }
    else
      {
      $sdata = [
        'exception' => '<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Can not mass previous Password !</h4>
          </div>'
              ]; 

      $this->session->set_userdata($sdata);
      redirect('aSetting');
      }
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Confirm Your Password !</h4>
        </div>'
            ]; 

    $this->session->set_userdata($sdata);
    redirect('aSetting');
    }
}


        ################################################
        #   /* Pages  end*/                            #
        ################################################
}