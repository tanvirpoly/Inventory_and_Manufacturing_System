<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class User extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
  $this->load->library('email');
}

public function user_notice_lists()
  {
  $data['title'] = 'Notice';
  $data['notice'] = $this->pm->get_user_notice();

  //var_dump($data['users']); exit();
  $this->load->view('users/notice_list',$data);
}

public function user_role()
  {
  $data['title'] = 'User Role';

  $where = array(
    'compid' => $_SESSION['compid']
        );

  $data['role'] = $this->pm->get_data('access_lavels',$where);

  $this->load->view('users/user_role',$data);
}

public function save_accesslavel()
  {
  $info = $this->input->post();

  $urole = array(
    'compid'    => $_SESSION['compid'],
    'lavelName' => $info['lavelName'],
    'regby'     => $_SESSION['uid']
        );
 
  $result = $this->pm->insert_data('access_lavels',$urole);
  
  $pdata = [
    'utype'        => $result,
    'compid'       => $_SESSION['compid'],
    'regby'        => $_SESSION['uid'],
    'dashboard'    => 1
        ];

  $fdata = [
    'utype'        => $result,
    'compid'       => $_SESSION['compid'],
    'regby'        => $_SESSION['uid']
        ];

  $this->pm->insert_data('tbl_user_m_permission',$pdata);
  $this->pm->insert_data('tbl_user_p_permission',$pdata);
  $this->pm->insert_data('tbl_user_f_permission',$fdata);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User role add Successfully !</h4>
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
  redirect('uRole');
}

public function get_user_role_data()
  {
  $section = $this->pm->get_user_role_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_user_role()
  {
  $info = $this->input->post();

  $where = array(
    'ax_id' => $info['roleid']
        );

  $urole = array(
    'compid'    => $_SESSION['compid'],
    'lavelName' => $info['lavelName'],
    'status'    => $info['status'],
    'upby'      => $_SESSION['uid']
        );
  //var_dump($where,$urole); exit();
  $result = $this->pm->update_data('access_lavels',$urole,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User role update Successfully !</h4>
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
  redirect('uRole');
}

public function delete_user_role($id)
  {
  $uwhere = array(
      'userrole' => $id
          );
  $auser = $this->pm->get_data('users',$uwhere);

  if($auser[0] == null)
    {
    $where = array(
      'ax_id' => $id
          );
   
    $result = $this->pm->delete_data('access_lavels',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> User role delete Successfully !</h4>
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
    }
  else
    {
    $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> All ready add this user role in user !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('uRole');
}

public function user_list()
  {
  $data['title'] = 'User';
  
  $field = array(
    'users' => 'users.uid,users.name,users.email,users.mobile,users.status',
    'access_lavels' => 'lavelName'
        );
  $join = array(
    'access_lavels' => 'access_lavels.ax_id = users.userrole'
        );
  $other = array(
    'order_by' => 'uid',
    'join' => 'left'
        );
    $where = array(
    'users.compid' => $_SESSION['compid'],
    'users.userrole >' => 2
        );

  $data['users'] = $this->pm->get_data('users',$where,$field,$join,$other);

  $awhere = array(
    'status' => 'Active',
    'compid' => $_SESSION['compid']
        );
  $data['userrole'] = $this->pm->get_data('access_lavels',$awhere);
  $data['emp'] = $this->pm->get_employee();
  //var_dump($data['emp']); exit();
  $this->load->view('users/users',$data);
}

public function save_user()
  {
  $info = $this->input->post(); 

  $where = array(
    'employeeID' => $info['emp']
        );
  $emp = $this->pm->get_data('employees',$where);
  
  $mwhere = array(
    'mobile' => '+88'.$emp[0]['phone']
        );
    //var_dump($mwhere); exit();
  $mdata = $this->pm->get_data('users',$mwhere);
  
  if($mdata)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Your mobile number all ready Used. Change your mobile number from update emaployee ! </h4>
            </div>'
            ];

        $this->session->set_userdata($sdata);
        redirect('User');
        }
    else
        {

  $data = array(
    'compid'   => $_SESSION['compid'],
    'compname' => $_SESSION['compname'],
    'empid'    => $info['emp'],
    'name'     => $emp[0]['employeeName'],
    'email'    => $emp[0]['email'],
    'mobile'   => '+88'.$emp[0]['phone'],
    'password' => $info['password'],
    'userrole' => $info['utype'],      
    'regby'    => $_SESSION['uid']
        );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('users',$data);
  
    $mob = $emp[0]['phone'];
    $pass = $info['password'];
    
    $msg = "Welcome To Sunshine. Your software is ready tos use \nURL: https://sunshine.com.bd/app/"."\nID : ".$mob."\nPass : ".$pass."\nThank You\nSunshine IT";
        //var_dump($msg); exit();
    $to = $emp[0]['phone'];
    //$token = "44515996325214391599632521";
    $message = urlencode($msg);
    //$url = "http://sms.iglweb.com/api/v1/send?api_key=44516045544714651604554471&contacts=$to&senderid=8801844532630&msg=$message";
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
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User add Successfully !</h4>
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
  redirect('User');
        }
}

public function get_user_data()
  {
  $grup = $this->pm->get_user_data($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_User()
  {
  $info = $this->input->post(); 

  $sdata = array(
    'userrole' => $info['utype'],
    'status'   => $info['status'],      
    'upby'     => $_SESSION['uid']
        );

  $where = array(
    'uid' => $info['user_id']
        );
      
  $result = $this->pm->update_data('users',$sdata,$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User update Successfully !</h4>
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
  redirect('User');
}

public function delete_user($id)
  {
  $where = array(
      'uid' => $id
          );
      
  $result = $this->pm->delete_data('users',$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User delete Successfully !</h4>
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
  redirect('User');
}

public function help_support()
  {
  $data['title'] = 'Help & Support';

  $where = array(
    'compid' => $_SESSION['compid']
        );
  $data['help'] = $this->pm->get_data('help_support',$where);

  $this->load->view('users/help_support',$data);
}

public function save_help_support_msg()
  {
  $info = $this->input->post(); 
  
  $query = $this->db->select('hs_id')
                  ->from('help_support')
                  ->limit(1)
                  ->order_by('hs_id','DESC')
                  ->get()
                  ->row();
    //var_dump($query);
  if($query)
      {
      $sn = $query->hs_id+1;
      }
  else
      {
      $sn = 1;
      }
    //var_dump($sn); exit();
  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d", $sn);

  $cusid = 'HS-'.$cn.$pc; 

  $data = array(
    's_id'    => $cusid,
    'compid'  => $_SESSION['compid'],
    'subject' => $info['subject'],
    'message' => $info['message'],      
    'regby'   => $_SESSION['uid']
        );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('help_support',$data);
  
  $where = array(
    'compid' => $_SESSION['compid'],
    'uid' => $_SESSION['uid']
        );
        
  $user = $this->pm->get_data('users',$where);
  $empemail = $user[0]['email'];
  
  $fpe = $this->pm->check_email($empemail);
  //var_dump($fpe); //exit();
  if($fpe)
    {
    $config = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.gmail.com',
      'smtp_port' => 465,
      'smtp_user' => 'example@gmail.com', // change it to yours
      'smtp_pass' => '123456', // change it to yours
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE
        );

    $to = $fpe->email;
    $subject = $info['subject'];
    $message = $info['message'];

    //var_dump($message); exit();
    $this->load->library('email',$config);
    $this->email->set_newline("\r\n");
    $this->email->from('example@gmail.com'); // change it to yours
    $this->email->to('example@gmail.com');// change it to yours
    $this->email->subject($subject);
    $this->email->message($message);
        
    $this->email->send();
    }
    
  $empmobile = $user[0]['mobile'];
  
  if($empmobile)
    {
    $msg = "User Name : ".$user[0]['name']."\nCompany : ".$user[0]['compname']."\nMobile : ".$user[0]['mobile']."\n\nOpen a Token";
        //var_dump($msg); exit();
        
    $mob = "01714044180";
    //$token = "44515996325214391599632521";
    //$token = urlencode("4cc079b5-c2a5-4cdc-ac07-1ee0fe8e6b5d");
    $message = urlencode($msg);
    $to = urlencode($mob);
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
    }
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Help & Support Send Successfully !</h4>
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
  redirect('helpSupport');
}

public function reply_help_support_msg()
  {
  $info = $this->input->post(); 
  
    date_default_timezone_set('Asia/Dhaka');
    $date = date('d/m/Y h:i:s a', time());
    //var_dump($date); exit();
  $data = array(
    'hp_id' => $info['hs_id'],
    'reply' => $info['message'],      
    'regby' => $_SESSION['uid'],
    'regdate' => $date
        );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('help_support_reply',$data);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Help & Support Reply Successfully !</h4>
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
  redirect('helpSupport');
}

public function delete_help_message($id)
  {
  $where = array(
    'hs_id' => $id
        );

  $rwhere = array(
    'hp_id' => $id
        );
  //var_dump($data); exit();
  $result = $this->pm->delete_data('help_support',$where);
  $result2 = $this->pm->delete_data('help_support_reply',$rwhere);
  if($result && $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Help & Support message delete Successfully !</h4>
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
  redirect('helpSupport');
}

// public function get_help_reply_data()
//   {
//   $grup = $this->pm->get_help_reply_data($_POST['id']);
//   $someJSON = json_encode($grup);
//   echo $someJSON;
// }

public function get_help_reply_data()
  {
  $id = $this->input->post('id');

  $where = array(
    'hp_id' => $id
        );
  $field = array(
    'help_support_reply' => 'help_support_reply.reply,help_support_reply.regdate',
    'users' => 'users.name'
        );
  $join = array(
    'users' => 'users.uid = help_support_reply.regby'
        );
  $other = array(
    'join' => 'left'
        );
  $products = $this->pm->get_data('help_support_reply',$where,$field,$join,$other);
  $str='';
  foreach($products as $value){
    $rdate = Date($value['regdate']);
    $str.="<tr><td>".$value['reply'].'<br><b>'.$value['name'].'<b>'.' '.$rdate."</td></tr>";
    }
  echo json_encode($str);
}

public function help_Asupport()
  {
  $data['title'] = 'Help & Support';
    $other = array(
       'order_by' => 'hs_id',
       'join'     => 'left' 
            );
    $field = array(
        'help_support' => 'help_support.*',
        'users' => 'users.compname,users.mobile,users.email'
            );
    $join = array(
        'users' => 'users.uid = help_support.regby'
            );
  $data['help'] = $this->pm->get_data('help_support',false,$field,$join,$other);

  $this->load->view('users/help_asupport',$data);
}

public function reply_help_Asupport_msg()
  {
  $info = $this->input->post(); 
  
    date_default_timezone_set('Asia/Dhaka');
    $date = date('d/m/Y h:i:s', time());
    //var_dump($date); exit();

  $data = array(
    'hp_id' => $info['hs_id'],
    'reply' => $info['message'],      
    'regby' => $_SESSION['uid'],
    'regdate' => $date
        );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('help_support_reply',$data);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Help & Support Reply Successfully !</h4>
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
  redirect('helpASupport');
}

public function delete_Ahelp_message($id)
  {
  $where = array(
    'hs_id' => $id
        );

  $rwhere = array(
    'hp_id' => $id
        );
  //var_dump($data); exit();
  $result = $this->pm->delete_data('help_support',$where);
  $result2 = $this->pm->delete_data('help_support_reply',$rwhere);
  if($result && $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Help & Support message delete Successfully !</h4>
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
  redirect('helpASupport');
}

public function all_user_lists()
  {
  $data['title'] = 'User List';
  $where = array(
    'userrole' => 2
        );
  $data['users'] = $this->pm->get_data('users',$where);

  $this->load->view('users/user_list',$data);
}

public function save_user_payment()
  {
  $info = $this->input->post();
  
  $where = array(
      'uid' => $info['user_id']
          );
  $payment = $this->db->select('*')
                      ->from('user_payments')
                      ->where('uid',$info['user_id'])
                      ->where('pstatus',1)
                      ->order_by('up_id','desc')
                      ->get()
                      ->row();
  $user = $this->pm->get_data('users',$where);
  
  if($payment)
    {
    $pcdate = date('Y-m-d h:i:s',strtotime($payment->pdate));
    }
  else
    {
    $pcdate = date('Y-m-d h:i:s',strtotime($user[0]['regdate']));
    }
    
  if($info['ptime'] == 1)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 1 months'));
    }
  elseif($info['ptime'] == 2)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 3 months'));
    }
  elseif($info['ptime'] == 3)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 6 months'));
    }
  elseif($info['ptime'] == 4)
    {
    $pdate = date('Y-m-d h:i:s',strtotime($pcdate. ' + 1 year'));
    }
  
  $data = array(
      'package' => $info['utype'],
      'amount'  => $info['amount'], 
      'uid'     => $info['user_id'],
      'ptime'   => $info['ptime'],
      'pstatus' => 1,
      'pdate'   => $pdate,
      'regby'   => $_SESSION['uid']
          );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('user_payments',$data);
  
  if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
          <h4><i class="icon fa fa-check"></i>User payment add Successfully !</h4>
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
  redirect('userList');
}

public function inactive_users($id)
  {
  $sdata = array(
    'status' => 'Inactive',      
    'upby'   => $_SESSION['uid']
        );

  $where = array(
    'compid' => $id
        );
      
  $result = $this->pm->update_data('users',$sdata,$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i>User Inactive Successfully !</h4>
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
  redirect('userList');
}

public function active_users($id)
  {
  $sdata = array(
    'status' => 'Active',      
    'upby'   => $_SESSION['uid']
        );

  $where = array(
    'compid' => $id
        );
      
  $result = $this->pm->update_data('users',$sdata,$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i>User Active Successfully !</h4>
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
  redirect('userList');
}

public function delete_all_user_info($id)
  {
  $where = array(
    'compid' => $id
        );

  //var_dump($data); exit();
  $result = $this->pm->delete_data('users',$where);
  $this->pm->delete_data('access_lavels',$where);
  $this->pm->delete_data('bankaccount',$where);
  $this->pm->delete_data('cash',$where);
  $this->pm->delete_data('categories',$where);
  $this->pm->delete_data('com_profile',$where);
  $this->pm->delete_data('cost_type',$where);
  $this->pm->delete_data('customers',$where);
  $this->pm->delete_data('department',$where);
  $this->pm->delete_data('employees',$where);
  $this->pm->delete_data('employee_payment',$where);
  $this->pm->delete_data('help_support',$where);
  $this->pm->delete_data('mobileaccount',$where);
  $this->pm->delete_data('order',$where);
  $this->pm->delete_data('products',$where);
  $this->pm->delete_data('purchase',$where);
  $this->pm->delete_data('quotation',$where);
  $this->pm->delete_data('returns',$where);
  $this->pm->delete_data('returns_product',$where);
  $this->pm->delete_data('sales',$where);
  $this->pm->delete_data('service_info',$where);
  $this->pm->delete_data('service_sale',$where);
  $this->pm->delete_data('sma_units',$where);
  $this->pm->delete_data('stock',$where);
  $this->pm->delete_data('stock_store',$where);
  $this->pm->delete_data('store',$where);
  $this->pm->delete_data('suppliers',$where);
  $this->pm->delete_data('tbl_user_f_permission',$where);
  $this->pm->delete_data('tbl_user_m_permission',$where);
  $this->pm->delete_data('tbl_user_p_permission',$where);
  $this->pm->delete_data('transfer_account',$where);
  $this->pm->delete_data('user_payments',$where);
  $this->pm->delete_data('vaucher',$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User All information delete Successfully !</h4>
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
  redirect('userList');
}






}