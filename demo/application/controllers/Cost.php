<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Cost extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Expense Type';

//   $where = array(
//     'compid' => $_SESSION['compid']
//         );

//   $data['cost'] = $this->pm->get_data('cost_type',$where);
  $data['cost'] = $this->pm->cost_type_data();
    //var_dump($data['cost']); exit();
  $this->load->view('costs/costTypes',$data);
}

public function save_expense_type()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'costName' => $info['expensetName'],         
    'regby'    => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('cost_type',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Expense Type add Successfully !</h4>
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
  redirect('Expense');
}

public function get_Cost_Type_data()
  {
  $section = $this->pm->get_cost_type_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_cost_type()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'costName' => $info['expensetName'],
    'status'   => $info['status'],             
    'upby'     => $_SESSION['uid']
        );

  $where = array(
    'ct_id' => $info['cat_id']
        );

  $result = $this->pm->update_data('cost_type',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Expense Type update Successfully !</h4>
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
  redirect('Expense');
}

public function cost_type_delete($id)
  {
  $where = array(
    'costType' => $id
        );
  $empu = $this->pm->get_data('vaucher',$where);

  if(!$empu)
    {
    $cwhere = array(
      'ct_id' => $id
          );

    $result = $this->pm->delete_data('cost_type',$cwhere);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Expense Type delete Successfully !</h4>
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
        <h4><i class="icon fa fa-ban"></i> All ready add this Expense Type !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('Expense');
}

public function add_cost_type()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'costName' => $info['costName'],         
    'regby'    => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('cost_type',$data);

  if($result)
    {
    $where = array(
        'compid' => $_SESSION['compid']
            );
    $customers = $this->pm->get_data('cost_type',$where);
    $append = '<div id="customer_hide"><label>Cost Type *</label>
                <select class="form-control chosen" name="customerID" onchange="myFunction()" id="customerID" required>
                <option value="">Select One</option>
                ';
    foreach($customers as $value)
      {
      $append .= '<option value=" '.$value['ct_id'] .' ">'.$value['costName'].'</option>';
      }
    $append .= '</select></div>';
    echo $append;
    }
  else
    {
    echo "Cost Type Added Failed!";
    }
}

public function save_company_profile()
  {
  $info = $this->input->post();
      //var_dump('hello'); exit();
  $config['upload_path'] = './upload/company/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload',$config);
  $this->upload->initialize($config);
  
  $store = $this->db->select('compid,com_logo,com_simg')
                  ->from('com_profile')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
                    
  if ($this->upload->do_upload('userfile'))
    {
    $limg = $this->upload->data('file_name');
    }
  else
    {
    if($store)
      {
      $limg = $store->com_logo;
      }
    else
      {
      $limg = '';
      }
    } 

  if ($this->upload->do_upload('signaturefile'))
    {
    $simg = $this->upload->data('file_name');
    }
  else
    {
    if($store)
      {
      $simg = $store->com_simg;
      }
    else
      {
      $simg = '';
      }
    }  

  $info = [
    'com_name'    => $info['com_name'],
    'com_mobile'  => $info['com_mobile'],
    'com_address' => $info['com_address'],
    'com_email'   => $info['com_email'],
    'com_logo'    => $limg,
    'com_simg'    => $simg,
    'regby'       => $_SESSION['uid']
          ];
        //var_dump($info); exit();
    
//   if ($store)
//     {
//     $where = array(
//       'compid' => $_SESSION['compid']
//           );

//     $result = $this->pm->update_data('com_profile',$info,$where);
//     }
//   else
//     {
//     $result = $this->pm->insert_data('com_profile',$info);
//     }
    $where = array(
      'com_pid' => 1
          );

    $result = $this->pm->update_data('com_profile',$info,$where);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Company Profile Setting Successfully !</h4>
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
  redirect('Dashboard');
}

public function expense_report_list()
  {
  $data['title'] = 'Expense Report';
  $data['cost'] = $this->pm->get_data('cost_type',false);

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
        
    if($report == 'dailyReports')
      {
      $sdate = date("Y-m-d", strtotime($_GET['sdate']));
      $edate = date("Y-m-d", strtotime($_GET['edate']));
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['report'] = $report;
      $vtype = $_GET['dvtype'];
      
      $data['expense'] = $this->pm->get_dcost_report_data($sdate,$edate,$vtype);
      }
    else if ($report == 'monthlyReports')
      {
      $month = $_GET['month'];
      $data['month'] = $month;
      $year = $_GET['year'];
      $data['year'] = $year;
            //var_dump($data['month']); exit();
      if($month == 1)
        {
        $name = 'January';
        }
      elseif ($month == 2)
        {
        $name = 'February';
        }
      elseif ($month == 3)
        {
        $name = 'March';
        }
      elseif ($month == 4)
        {
        $name = 'April';
        }
      elseif ($month == 5)
        {
        $name = 'May';
        }
      elseif ($month == 6)
        {
        $name = 'June';
        }
      elseif ($month == 7)
        {
        $name = 'July';
        }
      elseif ($month == 8)
        {
        $name = 'August';
        }
      elseif ($month == 9)
        {
        $name = 'September';
        }
      elseif ($month == 10)
        {
        $name = 'October';
        }
      elseif ($month == 11)
        {
        $name = 'November';
        }
      else
        {
        $name = 'December';
        }

      $data['name'] = $name;
      $data['report'] = $report;
      $vtype = $_GET['mvtype'];
      
      $data['expense'] = $this->pm->get_mcost_report_data($month,$year,$vtype);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;
      $vtype = $_GET['yvtype'];
      
      $data['expense'] = $this->pm->get_ycost_report_data($year,$vtype);
      }
    }
  else
    {
    $data['expense'] = $this->pm->get_cost_report_data();
    }
    
  $this->load->view('costs/cost_report',$data);
}





}