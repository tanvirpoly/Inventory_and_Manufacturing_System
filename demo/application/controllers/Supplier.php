<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends CI_Controller {

function __construct() {
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
    $this->load->library('PHPExcel');
    $this->load->library('excel');
}

public function index()
  {
  $data['title'] = 'Supplier';
  if($_SESSION['role'] <= 2)
    {
    $data['supplier'] = $this->pm->get_data('suppliers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
 
    $data['supplier'] = $this->pm->get_data('suppliers',$where);
    }

  $this->load->view('suppliers/suppliers',$data);
}

public function save_supplier()
    {
    $info = $this->input->post();

    $query = $this->db->select('sup_id')
                  ->from('suppliers')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('sup_id','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->sup_id,5)+1;
        }
    else
        {
        $sn = 1;
        }

    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d", $sn);

    $cusid = 'S-'.$cn.$pc;

    $data = array(
        'compid'       => $_SESSION['compid'],
        'sup_id'       => $cusid,
        'supplierName' => $info['supplierName'],
        'compname'     => $info['compname'],
        'mobile'       => $info['mobile'],
        'email'        => $info['email'],
        'address'      => $info['address'],
        'balance'      => $info['balance'],            
        'regby'        => $_SESSION['uid']
            );

    $result = $this->pm->insert_data('suppliers',$data);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Supplier add Successfully !</h4>
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
    redirect('Supplier');
}

public function get_supplier_data()
    {
    $section = $this->pm->get_supplier_data($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function update_supplier()
    {
    $info = $this->input->post();

    $data = array(
        'compid'       => $_SESSION['compid'],
        'supplierName' => $info['supplierName'],
        'compname'     => $info['compname'],
        'mobile'       => $info['mobile'],
        'email'        => $info['email'],
        'address'      => $info['address'],
        'balance'      => $info['balance'], 
        'status'       => $info['status'],            
        'upby'         => $_SESSION['uid']
            );

    $where = array(
        'supplierID' => $info['sup_id']
            );

    $result = $this->pm->update_data('suppliers',$data,$where);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Supplier update Successfully !</h4>
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
    redirect('Supplier');
}

public function delete_supplier($id)
    {
    $pwhere = array(
        'supplier' => $id
            );
    $purchase = $this->pm->delete_data('purchase',$pwhere);

    if ($purchase)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> All ready purchase from this supplier !</h4>
            </div>'
                ];
        }
    else
        {
        $where = array(
            'supplierID' => $id
                );

        $result = $this->pm->delete_data('suppliers',$where);

        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-check"></i>Supplier delete Successfully !</h4>
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
    $this->session->set_userdata($sdata);
    redirect('Supplier');
}

public function add_supplier()
    {
    $query = $this->db->select('sup_id')
                  ->from('suppliers')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('sup_id','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->sup_id,5)+1;
        }
    else
        {
        $sn = 1;
        }

    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d", $sn);

    $cusid = 'S-'.$cn.$pc;

    $data = array(
        'compid'       => $_SESSION['compid'],
        'sup_id'       => $cusid,
        'supplierName' => $_POST['supplierName'],
        'compname'     => $_POST['compname'],
        'mobile'       => $_POST['mobile'],
        'email'        => $_POST['email'],
        'address'      => $_POST['address'],
        'balance'      => $_POST['balance'],            
        'regby'        => $_SESSION['uid']
            );

    $result = $this->pm->insert_data('suppliers',$data);

    if($result)
        {
        $swhere = array(
            'compid' => $_SESSION['compid']
                );
        $customer = $this->pm->get_data('suppliers',$swhere);

        $append = '<div id="customer_hide"><label>supplier *</label>
                    <select class="form-control chosen" name="suppliers" onchange="myFunction()" id="suppliers" required>
                    <option value="">Select One</option>
                    ';
        foreach($customers as $value)
            {
            $append .= '<option value=" '.$value['supplierID'] .' ">'.$value['supplierName'].'('.$value['sup_id'].')</option>';
            }
        $append .= '</select></div>';
        echo $append;
        }
    else
        {
        echo "Supplier Added Failed!";
        }
}

public function supplier_report()
  {
  $data = ['title' => 'Supplier Reports'];
  if($_SESSION['role'] <= 2)
    {
    $data['supplier'] = $this->pm->get_data('suppliers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
 
    $data['supplier'] = $this->pm->get_data('suppliers',$where);
    }
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
            }
        else if ($report == 'monthlyReports')
            {
            $month = $_GET['month'];
            $data['month'] = $month;
            $year = $_GET['year'];
            $data['year'] = $year;
        
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
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;
            }
        }
    else
        {

        }

    $this->load->view('suppliers/supplier_report',$data);
}

public function supplier_ledger()
  {
  $data = ['title' => 'Supplier Ledger'];
  if($_SESSION['role'] <= 2)
    {
    $data['supplier'] = $this->pm->get_data('suppliers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
 
    $data['supplier'] = $this->pm->get_data('suppliers',$where);
    }
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

            $sid = $_GET['dsupplier'];
            $where = array('supplierID' => $sid);

            $data['supp'] = $this->pm->get_data('suppliers',$where);
            $data['purchase'] = $this->pm->get_dspurchase_data($sdate,$edate,$sid);
            $data['voucher'] = $this->pm->get_dsvoucher_data($sdate,$edate,$sid);
            }
        else if ($report == 'monthlyReports')
            {
            $month = $_GET['month'];
            $data['month'] = $month;
            $year = $_GET['year'];
            $data['year'] = $year;
        
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

            $sid = $_GET['msupplier'];
            $where = array('supplierID' => $sid);

            $data['supp'] = $this->pm->get_data('suppliers',$where);
            $data['purchase'] = $this->pm->get_mspurchase_data($month,$year,$sid);
            $data['voucher'] = $this->pm->get_msvoucher_data($month,$year,$sid);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $sid = $_GET['ysupplier'];
            $where = array('supplierID' => $sid);

            $data['supp'] = $this->pm->get_data('suppliers',$where);
            $data['purchase'] = $this->pm->get_yspurchase_data($year,$sid);
            $data['voucher'] = $this->pm->get_ysvoucher_data($year,$sid);
            }
        }
    else
        {
        $data['purchase'] = '';
        $data['voucher'] = '';
        }
    //var_dump('Hello');
    $this->load->view('suppliers/supplier_ledger',$data);
}

public function export_action()
    {
    $this->load->library("excel");
    $object = new PHPExcel();

    $object->setActiveSheetIndex(0);

    $table_columns = array("Supplier Name","Company Name","Mobile","Email","Address","Balance");

    $column = 0;

    foreach($table_columns as $field)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
        $column++;
        }

    $supplier_data = $this->pm->supplier_fetch_data($_SESSION['compid']);

    $excel_row = 2;

    foreach($supplier_data as $row)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->supplierName);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->compname);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->mobile);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->email);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->address);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5,$excel_row,$row->balance);
        $excel_row++;
        }

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Suppliers Data.xls"');
    if (ob_get_length() > 0) { ob_end_clean(); }
    $object_writer->save('php://output');
}

public function excel_import()
    {
    if(isset($_FILES["file"]["name"]))
        {
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
            {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++)
                {
                $supplierName = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
                $compname = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
                $mobile = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
                $email = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
                $address = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
                $balance = $worksheet->getCellByColumnAndRow(5,$row)->getValue();

                $query = $this->db->select('sup_id')
                              ->from('suppliers')
                              ->where('compid',$_SESSION['compid'])
                              ->limit(1)
                              ->order_by('sup_id','DESC')
                              ->get()
                              ->row();
                if($query)
                    {
                    $sn = substr($query->sup_id,5)+1;
                    }
                else
                    {
                    $sn = 1;
                    }

                $cn = strtoupper(substr($_SESSION['compname'],0,3));
                $pc = sprintf("%'05d", $sn);

                $cusid = 'S-'.$cn.$pc;

                $data[] = array(
                    'compid'       => $_SESSION['compid'],
                    'sup_id'       =>  $cusid,
                    'supplierName' =>  $supplierName,
                    'compname'     =>  $compname,
                    'mobile'       =>  $mobile,
                    'email'        =>  $email,
                    'address'      =>  $address,
                    'balance'      =>  $balance,
                    'regby'        => $_SESSION['uid']
                        );
                }
            }
        $this->pm->insert_supplier_data($data);
        echo 'Data Imported successfully';
        }   
}






}