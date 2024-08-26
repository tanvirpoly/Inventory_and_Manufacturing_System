<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Order extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}


public function sale_Order($id)
  {
  $data['title'] = 'Order';

  $cwhere = array(
    'compid' => $_SESSION['compid']
        );
  $data['customer'] = $this->pm->get_data('customers',$cwhere);
  $data['product'] = $this->pm->get_data('products',$cwhere);

  $where = array(
    'oid' => $id
        );
  $join = array(
    'products' => 'products.productID = order_product.product'
        );
  $data['pquotation'] = $this->pm->get_data('order_product',$where,false,$join);

  $quotation = $this->pm->get_data('order',$where);
  $data['quotation'] = $quotation[0];    
  
  $this->load->view('order/sale_order',$data);
}

public function savle_sale_Order()
  {
  $info = $this->input->post();

  $where = array(
    'oid' => $info['oid']
        );

  $order = array(
    'status' => 2,
    'upby'   => $_SESSION['uid']
        );

  $this->pm->update_data('order',$order,$where);

  $query = $this->db->select('invoice_no')
                  ->from('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('saleID','DESC')
                  ->get()
                  ->row();
  if($query)
    {
    $sn = substr($query->invoice_no,7)+1;
    }
  else
    {
    $sn = 1;
    }
  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d", $sn);

  //$cusid = 'INV-'.$cn.$pc;
  $cusid = $pc;

  $quotation = array(
    'compid'      => $_SESSION['compid'],
    'invoice_no'  => $cusid,
    'saleDate'    => date('Y-m-d',strtotime($info['date'])),
    'customerID'  => $info['customerID'],
    'totalAmount' => $info['totalPrice'],
    'paidAmount'  => 0,
    'scost'       => $info['shiping_cost'],
    'dOption'     => $info['dOption'],
    'accountType' => 'Cash',
    'accountNo'   => 1,
    'note'        => $info['note'],
    'sstatus'     => 'Online Sell',
    'regby'       => $_SESSION['uid']
        );
      //var_dump($quotation); exit();
  $result = $this->pm->insert_data('sales',$quotation);
        //var_dump($purchase_id); exit();
  if($result)
    {
    $length = count($info['product_id']);
    
    for($i = 0; $i < $length; $i++)
      {
      $qdata = array(
        'saleID'     => $result,
        'productID'  => $info['product_id'][$i],
        'sprice'     => $info['tp'][$i],
        'quantity'   => $info['quantity'][$i],                 
        'totalPrice' => $info['total_price'][$i],
        'regby'      => $_SESSION['uid']
            );
      //var_dump($purchase_product);            
      $result2 = $this->pm->insert_data('sale_product',$qdata);

      $pid = $info['product_id'][$i];
      $aid = $_SESSION['compid'];

      $swhere = array(
        'product' => $pid,
        'compid' => $aid
                );

      $stpd = $this->pm->get_data('stock',$swhere);

      $this->pm->delete_data('stock',$swhere);

      if($stpd)
        {
        $tquantity = $stpd[0]['totalPices']-$info['quantity'][$i];
        }
      else
        {
        $tquantity = '-'.$info['quantity'][$i];
        }

      $stock_info = array(
        'compid'     => $_SESSION['compid'],
        'product'    => $pid,
        'totalPices' => $tquantity,
        'regby'      => $_SESSION['uid']
                );
      //var_dump($stock_info);    
      $this->pm->insert_data('stock',$stock_info);  
      }
    }
  if($result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Order sale add Successfully !</h4>
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
  redirect('Order');
}

public function order_ledger_report()
  {
  $data['title'] = 'Order Report';
  $data['customer'] = $this->pm->get_data('users',false);
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

      $data['sale'] = $this->pm->user_dorder_ledger($sdate,$edate);
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

      $data['sale'] = $this->pm->user_morder_ledger($month,$year);
      }
    else if ($report == 'yearlyReports')
      {
      $year = $_GET['ryear'];
      $data['year'] = $year;
      $data['report'] = $report;

      $data['sale'] = $this->pm->user_yorder_ledger($year);
      }
    }
  else
    {
    $data['sale'] = $this->pm->user_aorder_ledger();
    }

  $this->load->view('order/order_report',$data);
}










}