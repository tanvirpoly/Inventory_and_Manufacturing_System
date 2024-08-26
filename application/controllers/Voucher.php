<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Voucher extends CI_Controller {

public function __construct()
    {
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
    $this->load->library('PHPExcel');
    $this->load->library('excel');
}

public function index()
  {
  $data['title'] = 'Voucher';

  $other = array(
    'order_by' => 'vuid'
        );
  if($_SESSION['role'] <= 2)
    {
    $data['vaucher'] = $this->pm->get_data('vaucher',false,false,false,$other);
    }
  else
    {
    $where = array(
      'vaucher.regby' => $_SESSION['uid']  
         );
    $data['vaucher'] = $this->pm->get_data('vaucher',$where,false,false,$other);
    }
    
  $this->load->view('vouchers/voucher',$data);
}

public function new_voucher()
  {
  $data['title'] = 'Voucher';
  if($_SESSION['role'] <= 2)
    {
    $data['customer'] = $this->pm->get_data('customers',false);
    $data['supplier'] = $this->pm->get_data('suppliers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
    $data['customer'] = $this->pm->get_data('customers',$where);
    $data['supplier'] = $this->pm->get_data('suppliers',$where);
    }

  $this->load->view('vouchers/addvoucher',$data);
}

public function getAccountNo()
    {
    $str = '';
    $where = array(
        'status' => 'Active',
        'compid' => $_SESSION['compid']
            );

    $accountType = $this->input->post('id');
    if ($accountType == 'Bank')
        {
        $accounts = $this->pm->get_data('bankaccount',$where);
        if (count($accounts) == 0)
            {
            $str .= "<option value='0'>Please Add Bank account</option>";
            } 
        else 
            {
            foreach ($accounts as $value) {
                $str .= "<option value='".$value['ba_id']."'>".$value['bankName'].' '.$value['branchName'].' '.$value['accountNo'].' '.$value['accountName']."</option>";
            }
        }
        } 
    else if ($accountType == 'Mobile')
        {
        $accounts = $this->pm->get_data('mobileaccount',$where);
        if (count($accounts) == 0) 
            {
            $str .= "<option value='0'>Please Add mobile account</option>";
            } 
        else 
            {
            foreach ($accounts as $value) {
                $str .= "<option value='".$value['ma_id']."'>".$value['accountName'].' '.$value['accountNo']."</option>";
                }
            }
        } 
    else if ($accountType == 'Cash') 
        {
        $accounts = $this->pm->get_data('cash',$where);
        if (count($accounts) == 0) 
            {
            $str .= "<option value='0'>Please Add cash account</option>";
            } 
        else 
            {
            foreach ($accounts as $value) {
                $str .= "<option value='".$value['ca_id']."'>".$value['cashName']."</option>";
                }
            }
        } 
    else 
        {
        $str .= "<option >Please account Type</option>";
        }
    echo json_encode($str);
}

public function get_cost_type()
    {
    // $where = array(
    //     'compid' => $_SESSION['compid']
    //         );
    // $section = $this->pm->get_data('cost_type',$where);
    $section = $this->pm->cost_type_data();
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function save_voucher()
    {
    $info = $this->input->post();

    $query = $this->db->select('invoice')
                  ->from('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('invoice','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->invoice,5)+1;
        }
    else
        {
        $sn = 1;
        }
    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d", $sn);

    $cusid = 'V-'.$cn.$pc;

    $data = array(
        'voucherdate' => date('Y-m-d',strtotime($info['date'])),
        'compid'      => $_SESSION['compid'],
        'empid'       => $_SESSION['empid'],
        'invoice'     => $cusid,
        'customerID'  => $info['customerID'],
        'costType'    => $info['costType'],
        'reference'   => $info['reference'],
        'supplier'    => $info['supplier'],
        'vauchertype' => $info['vaucher'],
        'accountType' => $info['accountType'],
        'accountNo'   => $info['accountNo'],
        'totalamount' => array_sum($info['amount']),
        'regby'       => $_SESSION['uid']
            );
    
    $result = $this->pm->insert_data('vaucher',$data);
    //var_dump($vid); exit();
    $length = count($info['amount']);
    //var_dump($length); exit();
    for($i = 0; $i < $length; $i++)
        {
        $partdata = array(
            'vuid'        => $result,
            'particulars' => $info['particular'][$i],
            'amount'      => $info['amount'][$i],
            'regby'       => $_SESSION['uid']
                );
        //var_dump($partdata);    
        $result2 = $this->pm->insert_data('vaucher_particular',$partdata); 
        }

    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Voucher Add Successfully !</h4>
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
    redirect('Voucher');
}

public function voucher_details($id)
    {
    $data['title'] = 'Voucher';

    $where = array(
        'vuid' => $id
            );
    $other = array(
        'join' => 'left'
            );
    $field = array(
        'vaucher' => 'vaucher.*',
        'customers' => 'customers.cus_id,customers.customerName,customers.mobile as cm,customers.address as cad',
        'users' => 'users.empid,users.name,users.mobile as um',
        'suppliers' => 'suppliers.sup_id,suppliers.supplierName,suppliers.mobile as sm,suppliers.address as sad',
        'cost_type' => 'cost_type.costName'
            );
    $join = array(
        'customers' => 'customers.customerID = vaucher.customerID',
        'users' => 'users.empid = vaucher.empid',
        'suppliers' => 'suppliers.supplierID = vaucher.supplier',
        'cost_type' => 'cost_type.ct_id = vaucher.costType'
            );

    $voucher = $this->pm->get_data('vaucher',$where,$field,$join,$other);
    $data['voucher'] = $voucher[0];
    //var_dump($data['voucher']);
    $vwhere = array(
        'vuid' => $id
            );

    $data['voucherp'] = $this->pm->get_data('vaucher_particular',$vwhere);
    $data['company'] = $this->pm->company_details();

    $this->load->view('vouchers/viewvoucher',$data);
}

public function voucher_edit($id)
  {
  $data['title'] = 'Voucher';

  if($_SESSION['role'] <= 2)
    {
    $data['customer'] = $this->pm->get_data('customers',false);
    $data['supplier'] = $this->pm->get_data('suppliers',false);
    }
  else
    {
    $cwhere = array(
      'regby' => $_SESSION['uid']  
         );
    $data['customer'] = $this->pm->get_data('customers',$cwhere);
    $data['supplier'] = $this->pm->get_data('suppliers',$cwhere);
    }
  $data['costType'] = $this->pm->cost_type_data();

    $where = array(
        'vuid' => $id
            );
    $other = array(
        'join' => 'left'
            );
    $field = array(
        'vaucher' => 'vaucher.*',
        'customers' => 'customers.cus_id,customers.customerName,customers.mobile,customers.address',
        'employees' => 'employees.emp_id,employees.employeeName,employees.phone',
        'suppliers' => 'suppliers.sup_id,suppliers.supplierName,suppliers.mobile,suppliers.address',
        'cost_type' => 'cost_type.costName'
            );
    $join = array(
        'customers' => 'customers.customerID = vaucher.customerID',
        'employees' => 'employees.employeeID = vaucher.empid',
        'suppliers' => 'suppliers.supplierID = vaucher.supplier',
        'cost_type' => 'cost_type.ct_id = vaucher.costType'
            );

    $voucher = $this->pm->get_data('vaucher',$where,$field,$join,$other);
    $data['voucher'] = $voucher[0];

    $vwhere = array(
        'vuid' => $id
            );

    $data['voucherp'] = $this->pm->get_data('vaucher_particular',$vwhere);

    $this->load->view('vouchers/editvoucher',$data);
}

public function update_voucher()
    {
    $info = $this->input->post();

    $where = array(
        'vuid' => $info['vuid']
            );
    
    if($info['vauchertype'] == 'Credit Voucher')
        {
        $cust = $info['customerID'];
        $ct = 0;
        $sup = 0;
        $ref = 0;
        }
    else if($info['vauchertype'] == 'Debit Voucher')
        {
        $cust = 0;
        $ct = $info['costType'];
        $sup = 0;
        $ref = $info['reference'];
        }
    else if($info['vauchertype'] == 'Supplier Pay')
        {
        $cust = 0;
        $ct = 0;
        $sup = $info['supplier'];
        $ref = 0;
        }
    else
        {
        $cust = 0;
        $ct = 0;
        $sup = 0;
        $ref = 0;
        }
    
    $data = array(
        'voucherdate' => date('Y-m-d',strtotime($info['date'])),
        'customerID'  => $cust,
        'empid'       => $_SESSION['empid'],
        'costType'    => $ct,
        'supplier'    => $sup,
        'reference'   => $ref,
        'vauchertype' => $info['vauchertype'],
        'totalamount' => array_sum($info['amount']),
        'accountType' => $info['accountType'],
        'accountNo'   => $info['accountNo'],
        'upby'        => $_SESSION['uid']
            );
    
    $result = $this->pm->update_data('vaucher',$data,$where);
    //var_dump($vid); exit();
    $this->pm->delete_data('vaucher_particular',$where);

    $length = count($info['amount']);
    //var_dump($length); exit();
    for ($i = 0; $i < $length; $i++)
        {
        $partdata = array(
            'vuid'        => $info['vuid'],
            'particulars' => $info['particular'][$i],
            'amount'      => $info['amount'][$i],
            'upby'        => $_SESSION['uid']
                );
        //var_dump($partdata);    
        $result2 = $this->pm->insert_data('vaucher_particular',$partdata);
        }

    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Voucher update Successfully !</h4>
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
    redirect('Voucher');
}

public function voucher_delete($id)
    {
    $where = array(
        'vuid' => $id
            );
    
    $result = $this->pm->delete_data('vaucher',$where);
    //var_dump($vid); exit();
    $this->pm->delete_data('vaucher_particular',$where);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Voucher delete Successfully !</h4>
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
    redirect('Voucher');
}

public function profit_loss()
    {
    $data['title'] = 'Profit Loss';
    $data['company'] = $this->pm->company_details();

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

            $data['sale'] = $this->pm->total_dsales_amount($sdate,$edate);
            $data['purchase'] = $this->pm->total_dpurchases_amount($sdate,$edate);
            $data['empp'] = $this->pm->total_demp_payments_amount($sdate,$edate);
            $data['return'] = $this->pm->total_dreturns_amount($sdate,$edate);
            $data['cvoucher'] = $this->pm->total_dcvoucher_amount($sdate,$edate);
            $data['dvoucher'] = $this->pm->total_ddvoucher_amount($sdate,$edate);
            $data['svoucher'] = $this->pm->total_dsvoucher_amount($sdate,$edate);
            }
        else if ($report == 'monthlyReports')
            {
            $month = $_GET['month'];
            $data['month'] = $month;
            $year = $_GET['year'];
            $data['year'] = $year;
            //var_dump($data['month']); exit();
            if($month == 01)
                {
                $name = 'January';
                }
            elseif ($month == 02)
                {
                $name = 'February';
                }
            elseif ($month == 03)
                {
                $name = 'March';
                }
            elseif ($month == 04)
                {
                $name = 'April';
                }
            elseif ($month == 05)
                {
                $name = 'May';
                }
            elseif ($month == 06)
                {
                $name = 'June';
                }
            elseif ($month == 07)
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

            $data['sale'] = $this->pm->total_msales_amount($month,$year);
            $data['purchase'] = $this->pm->total_mpurchases_amount($month,$year);
            $data['empp'] = $this->pm->total_memp_payments_amount($month,$year);
            $data['return'] = $this->pm->total_mreturns_amount($month,$year);
            $data['cvoucher'] = $this->pm->total_mcvoucher_amount($month,$year);
            $data['dvoucher'] = $this->pm->total_mdvoucher_amount($month,$year);
            $data['svoucher'] = $this->pm->total_msvoucher_amount($month,$year);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['sale'] = $this->pm->total_ysales_amount($year);
            $data['purchase'] = $this->pm->total_ypurchases_amount($year);
            $data['empp'] = $this->pm->total_yemp_payments_amount($year);
            $data['return'] = $this->pm->total_yreturns_amount($year);
            $data['cvoucher'] = $this->pm->total_ycvoucher_amount($year);
            $data['dvoucher'] = $this->pm->total_ydvoucher_amount($year);
            $data['svoucher'] = $this->pm->total_ysvoucher_amount($year);
            }
        }
    else
        {
        $data['sale'] = $this->pm->total_sales_amount();
        $data['purchase'] = $this->pm->total_purchases_amount();
        $data['empp'] = $this->pm->total_emp_payments_amount();
        $data['return'] = $this->pm->total_returns_amount();
        $data['cvoucher'] = $this->pm->total_cvoucher_amount();
        $data['dvoucher'] = $this->pm->total_dvoucher_amount();
        $data['svoucher'] = $this->pm->total_svoucher_amount();
        }

    $this->load->view('vouchers/profit_loss',$data);
}

public function sale_purchase_profit_report()
    {
    $data['title'] = 'Sale Purchase Report';
    $data['company'] = $this->pm->company_details();

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

            $data['salep'] = $this->pm->total_dsales_product($sdate,$edate);
            }
        else if ($report == 'monthlyReports')
            {
            $month = $_GET['month'];
            $data['month'] = $month;
            $year = $_GET['year'];
            $data['year'] = $year;
            //var_dump($data['month']); exit();
            if($month == 01)
                {
                $name = 'January';
                }
            elseif ($month == 02)
                {
                $name = 'February';
                }
            elseif ($month == 03)
                {
                $name = 'March';
                }
            elseif ($month == 04)
                {
                $name = 'April';
                }
            elseif ($month == 05)
                {
                $name = 'May';
                }
            elseif ($month == 06)
                {
                $name = 'June';
                }
            elseif ($month == 07)
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

            $data['salep'] = $this->pm->total_msales_product($month,$year);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['salep'] = $this->pm->total_ysales_product($year);
            }
        }
    else
        {
        $data['salep'] = $this->pm->total_sales_product();
        }

    $this->load->view('vouchers/sale_purchase_profit_report',$data);
}

public function voucher_report()
  {
  $data = ['title' => 'Voucher Report'];
  $data['company'] = $this->pm->company_details();

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

      $data['voucher'] = $this->pm->get_dall_voucher_data($sdate,$edate,$vtype);
      }
    else if($report == 'monthlyReports')
      {
      $month = $_GET['month'];
      $data['month'] = $month;
      $year = $_GET['year'];
      $data['year'] = $year;
            //var_dump($data['month']); exit();
      if($month == 01)
        {
        $name = 'January';
        }
      else if($month == 02)
        {
        $name = 'February';
        }
      else if($month == 03)
        {
        $name = 'March';
        }
      else if($month == 04)
        {
        $name = 'April';
        }
      else if($month == 05)
        {
        $name = 'May';
        }
      else if($month == 06)
        {
        $name = 'June';
        }
      else if($month == 07)
        {
        $name = 'July';
        }
      else if($month == 8)
        {
        $name = 'August';
        }
      else if($month == 9)
        {
        $name = 'September';
        }
      else if($month == 10)
        {
        $name = 'October';
        }
      else if($month == 11)
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

      $data['voucher'] = $this->pm->get_mall_voucher_data($month,$year,$vtype);
      }
    else if($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;

      $vtype = $_GET['yvtype'];

      $data['voucher'] = $this->pm->get_yall_voucher_data($year,$vtype);
      }
    }
  else
    {
    $data['voucher'] = $this->pm->get_voucher_data();
    }

  $this->load->view('vouchers/voucher_reports',$data);
}

public function voucher_export_action()
    {
    $this->load->library("excel");
    $object = new PHPExcel();

    $object->setActiveSheetIndex(0);

    $table_columns = array("Date","Voucher No.","Voucher Type","Employee ID","Reference","Credit","Debit");

    $column = 0;

    foreach($table_columns as $field)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
        $column++;
        }

    $voucher = $this->pm->get_voucher_data();
    //var_dump($voucher); exit();
    $excel_row = 2;

    foreach($voucher as $row)
        {
        if($row->vauchertype == 'Credit Voucher')
            { 
            $cva = $row->totalamount;
            } 
        else
            {
            $cva = 00;
            }
        if($row->vauchertype != 'Credit Voucher')
            { 
            $dva = $row->totalamount;
            } 
        else
            {
            $dva = 00;
            }
        $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,date('d-m-Y',strtotime($row->voucherdate)));
        $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->invoice);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->vauchertype);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->regby);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->reference);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5,$excel_row,$cva);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6,$excel_row,$dva);
        $excel_row++;
        }
    //var_dump($object); exit();
    $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel2007');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="voucher.xls"');
    ob_end_clean();
    $object_writer->save('php://output');
}

public function daily_report()
    {
    $data['title'] = 'Daily Report';

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
    $data['company'] = $this->pm->company_details();

    $this->load->view('vouchers/daily_report',$data);
}

public function user_notice()
    {
    $data['title'] = 'Notice';
    $where = array(
        'userrole' => 2
            );
    $data['users'] = $this->pm->get_data('users',$where);
    $data['notice'] = $this->pm->get_data('notice',false);

    $this->load->view('vouchers/user_notice',$data);
}

public function save_user_notice()
    {
    $info = $this->input->post();

    $config['upload_path'] = './upload/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
    $config['max_size'] = 0;
    $config['max_width'] = 0;
    $config['max_height'] = 0;

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('user_photo'))
        {
        $img = $this->upload->data('file_name');
        }
    else
        {
        $img = '';
        }

    $data = array(
        'ntype'   => $info['user'],
        'subject' => $info['subject'],
        'message' => $info['message'],
        'image'   => $img,
        'regby'   => $_SESSION['uid']
            );
    
    $result = $this->pm->insert_data('notice',$data);
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Notice add Successfully !</h4>
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
    redirect('notice');
}

public function get_user_notice_data()
  {
  $grup = $this->pm->get_user_notice_data($_POST['id']);
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function update_user_notice()
    {
    $info = $this->input->post();

    $where = array(
        'nid' => $info['nid']
            );

    $config['upload_path'] = './upload/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
    $config['max_size'] = 0;
    $config['max_width'] = 0;
    $config['max_height'] = 0;

    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    $nimg = $this->pm->get_data('notice',$where);

    if ($this->upload->do_upload('user_photo'))
        {
        $img = $this->upload->data('file_name');
        }
    else
        {
        if($nimg)
            {
            $img = $nimg[0]['image'];
            }
        else
            {
            $img = '';
            }
        
        }

    $data = array(
        'ntype'   => $info['user'],
        'subject' => $info['subject'],
        'message' => $info['message'],
        'image'   => $img,
        'status'  => $info['status'],
        'regby'   => $_SESSION['uid']
            );
    
    $result = $this->pm->update_data('notice',$data,$where);
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Notice Update Successfully !</h4>
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
    redirect('notice');
}

public function daily_sms_report()
    {
    $where = array(
        'userrole' => 2
            );
    $users = $this->pm->get_data('users',$where);

    foreach ($users as $value)
        {
        $cid = $value['compid'];
        
        $sale = $this->pm->today_sales($cid);
        $purchase = $this->pm->today_purchases($cid);
        $cvoucher = $this->pm->today_cvouchers($cid);
        $dvoucher = $this->pm->today_dvouchers($cid);
        $svoucher = $this->pm->today_svouchers($cid);
        $empp = $this->pm->today_emp_payments($cid);
        $return = $this->pm->today_returns($cid);

        $date = date("d/m/Y");
        $tsa = number_format($sale->total, 2);
        $tpa = number_format($purchase->total, 2);
        $tcva = number_format($cvoucher->total, 2);
        $tdva = number_format($dvoucher->total, 2);
        $tsva = number_format($svoucher->total, 2);
        $tepa = number_format($empp->total, 2);
        $tra = number_format($return->total, 2);
        $tca = number_format((($sale->ptotal+$cvoucher->total)-($purchase->ptotal+$dvoucher->total+$svoucher->total+$empp->total+$return->total)), 2);

        $msg = "Reports in ".$date."\nSales : ".$tsa."\nPurchase : ".$tpa."\nCash Collect : ".$tcva."\nExpense : ".$tdva."\nSupplier Pay : ".$tsva."\nReturn : ".$tra."\nCash in Hand : ".$tca."\n\nThank You\nSunshine IT";
        //var_dump($msg); exit();
        $to = $value['mobile'];
        //$token = "44515996325214391599632521";
        $message = urlencode($msg);
        //$url = "http://sms.iglweb.com/api/v1/send?api_key=44515996325214391599632521&contacts=$to&senderid=8801844532630&msg=$message";
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
        
        //var_dump($smsresult); exit();
        }
        
        
        
}


function test_sms()
    {
    

        $msg = "Reports sms";
        $to = '8801313010188';
        //$token = "44515996325214391599632521";
        $message = urlencode($msg);
        //$url = "http://sms.iglweb.com/api/v1/send?api_key=44516045544714651604554471&contacts=$to&senderid=8801844532630&msg=$message";
        $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
        $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
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
        var_dump($smsresult);
             
}

public function query_check()
    {
    $where = array(
        'userrole' => 2
            );
    $users = $this->pm->get_data('users',$where);

    echo '<pre>';
    print_r($users);
    exit;
    
    foreach ($users as $value)
        {
        $cid = $value['compid'];
        
        $sale = $this->pm->today_sales($cid);
        $purchase = $this->pm->today_purchases($cid);
        $cvoucher = $this->pm->today_cvouchers($cid);
        $dvoucher = $this->pm->today_dvouchers($cid);
        $svoucher = $this->pm->today_svouchers($cid);
        $empp = $this->pm->today_emp_payments($cid);
        $return = $this->pm->today_returns($cid);

        $date = date("d/m/Y");
        $tsa = number_format($sale->total, 2);
        $tpa = number_format($purchase->total, 2);
        $tcva = number_format($cvoucher->total, 2);
        $tdva = number_format($dvoucher->total, 2);
        $tsva = number_format($svoucher->total, 2);
        $tepa = number_format($empp->total, 2);
        $tra = number_format($return->total, 2);
        $tca = number_format((($sale->ptotal+$cvoucher->total)-($purchase->ptotal+$dvoucher->total+$svoucher->total+$empp->total+$return->total)), 2);

        $msg = "Reports in ".$date."\nSales : ".$tsa."\nPurchase : ".$tpa."\nCash Collect : ".$tcva."\nExpense : ".$tdva."\nSupplier Pay : ".$tsva."\nReturn : ".$tra."\nCash in Hand : ".$tca."\n\nThank You\nSunshine IT";
        //var_dump($msg); exit();
        $to = $value['mobile'];
        //$token = "44515996325214391599632521";
        $message = urlencode($msg);
        //$url = "http://sms.iglweb.com/api/v1/send?api_key=44515996325214391599632521&contacts=$to&senderid=8801844532630&msg=$message";
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
        
        //var_dump($smsresult); exit();
        }
}

public function user_payment_list()
    {
    $data['title'] = 'Payment';
    
    $other = array(
        'join' => 'left',
        'order_by' => 'up_id'
            );
    $field = array(
        'user_payments' => 'user_payments.*',
        'users' => 'users.name,users.compname,users.email,users.mobile,users.compid'
            );
    $join = array(
        'users' => 'users.uid = user_payments.uid'
            );

    $data['users'] = $this->pm->get_data('user_payments',false,$field,$join,$other);
    
    $where = array(
        'userrole' => 2
            );
            
    $data['pusers'] = $this->pm->get_data('users',$where);

    //var_dump($data['users']); exit();
    $this->load->view('vouchers/user_payment',$data);
}

public function user_payment_active($id)
  {
  $data = array(
    'pstatus' => 1,      
    'upby'   => $_SESSION['uid']
        );

  $where = array(
    'up_id' => $id
        );
      
  $result = $this->pm->update_data('user_payments',$data,$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> User Payment Active Successfully !</h4>
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
  redirect('uPayment');
}

public function user_bill_list()
    {
    $data['title'] = 'Bill';
    
    $where = array(
        'user_payments.uid' => $_SESSION['uid']
            );
    $other = array(
        'join' => 'left',
        'order_by' => 'up_id'
            );

    $data['upayment'] = $this->pm->get_data('user_payments',$where,false,false,$other);

    //var_dump($data['users']); exit();
    $this->load->view('vouchers/user_bill',$data);
}

public function user_bill_payment()
    {
    $data['title'] = 'Bill Pay';

    //var_dump($data['users']); exit();
    $this->load->view('vouchers/pay_user_bill',$data);
}

public function save_bill_payment()
  {
  $info = $this->input->post();
  
  $where = array(
    'uid' => $_SESSION['uid']
        );
  $payment = $this->db->select('*')
                  ->from('user_payments')
                  ->where('uid',$_SESSION['uid'])
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
      'compid'  => $_SESSION['compid'],
      'package' => $info['utype'],
      'amount'  => $info['amount'], 
      'uid'     => $_SESSION['uid'],
      'ptime'   => $info['ptime'],
      'pstatus' => 0,
      'pdate'   => $pdate,
      'regby'   => $_SESSION['uid']
          );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('user_payments',$data);
  
  if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Bill payment add Successfully !</h4>
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
  redirect('uBill');
}

public function save_user_payment()
  {
  $info = $this->input->post();
  
  $where = array(
    'uid' => $info['uid'],
        );
  $payment = $this->db->select('*')
                  ->from('user_payments')
                  ->where('uid',$info['uid'])
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
    $trdate = date('Y-m-d h:i:s',strtotime($user[0]['regdate']));
    $pcdate = date('Y-m-d h:i:s',strtotime($trdate. ' + 30 days'));
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
      'compid'  => $user[0]['compid'],
      'package' => $info['utype'],
      'amount'  => $info['amount'], 
      'uid'     => $info['uid'],
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
          <h4><i class="icon fa fa-check"></i> Bill payment add Successfully !</h4>
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
  redirect('uPayment');
}

public function income_statement_reports()
  {
  $data['title'] = 'Income Statement';
  $data['company'] = $this->pm->company_details();

  $data['sale'] = $this->pm->total_sales_amount();
  $data['purchase'] = $this->pm->total_purchases_amount();
  $data['empp'] = $this->pm->total_emp_payments_amount();
  $data['return'] = $this->pm->total_returns_amount();
  $data['cvoucher'] = $this->pm->total_cvoucher_amount();
  $data['dvoucher'] = $this->pm->total_dvoucher_amount();
  $data['svoucher'] = $this->pm->total_svoucher_amount();

  $this->load->view('vouchers/income_statement',$data);
}




}