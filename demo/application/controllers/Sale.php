<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index()
    {
    $data['title'] = 'Sale';
    
    $other = array(
        'join' => 'left',
        'order_by' => 'saleID'
            );
    $field = array(
        'sales' => 'sales.*',
        'customers' => 'customers.customerName,customers.mobile',
        'users' => 'users.name'
        
            );
    $join = array(
        'customers' => 'customers.customerID = sales.customerID',
        'users' => 'users.uid = sales.regby'
            );

  if($_SESSION['role'] <= 2)
    {
    $data['sales'] = $this->pm->get_data('sales',false,$field,$join,$other);
    }
  else
    {
    $where = array(
      'sales.regby' => $_SESSION['uid']  
         );
    $data['sales'] = $this->pm->get_data('sales',$where,$field,$join,$other);
    }

  $this->load->view('sale/sales_list',$data);
}

public function new_sale()
  {
  $data['title'] = 'Sale';
  
  $data['product'] = $this->pm->get_product_data();
  if($_SESSION['role'] <= 2)
    {
    $data['customer'] = $this->pm->get_data('customers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
    $data['customer'] = $this->pm->get_data('customers',$where);
    }
    
  $this->load->view('sale/NewSale',$data);
}

public function get_sale_customer()
  {
  $other = array(
    'order_by' => 'customerID'
        );
  if($_SESSION['role'] <= 2)
    {
    $section = $this->pm->get_data('customers',false,false,false,$other);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
    $section = $this->pm->get_data('customers',$where,false,false,$other);
    }
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function getDetails()
    {
    $join = false;
    $other = false;
    $table = $this->input->post('table');
    $id = $this->input->post('id');
  if($_SESSION['role'] <= 2)
    {
    $where = array(
      'productID' => $id,
      'totalPices >' => 0,
      'stock.compid' => $_SESSION['compid']
            );
    }
  else
    {
    $where = array(
      'productID' => $id,
      'totalPices >' => 0,
      'stock.compid' => $_SESSION['empid']
            );
    }
  $join = array(
    'stock' => 'products.productID = stock.product'
        );
  $other = array(
    'join' => 'left'
        );
    $products = $this->pm->get_data('products',$where,false,$join,$other);
    //var_dump($products); exit();
    $str='';
    foreach($products as $value){
        $id = $value['productID'];
        $tpq = $value['totalPices'];
        $str.="<tr>
        <td>".$value['productName']."<input type='hidden' name='productName[]' value='".$value['productID']."'><input type='hidden' name='productID[]' value='".$value['productID']."'>
        </td>
        <td>".$value['totalPices']."</td>
        <td><input type='text' onkeyup='totalPrice(".$id.")' name='pices[]' id='pices_".$value['productID']."' value='0' max='$tpq' min='1'>
        </td>
        <td><input type='text' onkeyup='totalPrice(".$id.")' name='salePrice[]' id='salePrice_".$value['productID']."' value='".$value['sprice']."'>
        </td>
        <td>
        <input type='text' class='totalPrice'  name='totalPrice[]' readonly id='totalPrice_".$value['productID']."' value='0'>
        </td><td>
        <span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span>
        </td></tr>";
        }
    echo json_encode($str);
}

public function saved_sale()
    {
    $info = $this->input->post();

    $query = $this->db->select('invoice_no')
                  ->from('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('invoice_no','DESC')
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

    $cusid = 'INV-'.$cn.$pc;

   //var_dump($due); exit();
    $sale = array(
        'compid'         => $_SESSION['compid'],
        'invoice_no'     => $cusid,
        'saleDate'       => date('Y-m-d', strtotime($info['date'])),
        'customerID'     => $info['customerID'],
        'totalAmount'    => $info['nAmount'],
        'paidAmount'     => $info['total_paid'],
        'dueamount'      => $info['due'],
        'discount'       => $info['discount'],             
        'discountType'   => $info['disType'],
        'discountAmount' => $info['disAmount'],
        'sCost'          => $info['sCost'],
        'vCost'          => $info['vCost'],
        'vType'          => $info['vType'],             
        'vAmount'        => $info['vAmount'],
        'accountType'    => $info['accountType'],
        'accountNo'      => $info['accountNo'],
        'terms'          => $info['terms'],
        'note'           => $info['note'],             
        'regby'          => $_SESSION['uid']
            );
    //var_dump($sale); exit();
    if(isset($info['productID']))
      {
    $result = $this->pm->insert_data('sales',$sale);
    
    
    $length = count($info['productID']);
    for ($i = 0; $i < $length; $i++)
        {
        $spdata = array(
            'saleID'     => $result,
            'productID'  => $info['productID'][$i],                       
            'quantity'   => $info['pices'][$i],
            'sprice'     => $info['salePrice'][$i],
            'totalPrice' => $info['totalPrice'][$i],
            'regby'      => $_SESSION['uid']
                );

        $this->pm->insert_data('sale_product',$spdata);
        
        if($_SESSION['role'] <= 2)
          {
          $compid = $_SESSION['compid'];
          $swhere = array(
            'product' => $info['productID'][$i],
            'compid'  => $_SESSION['compid']
                    );
          }
        else
          {
          $compid = $_SESSION['empid'];
          $swhere = array(
            'product' => $info['productID'][$i],
            'compid'  => $_SESSION['empid']
                    );
          }

        $stpd = $this->pm->get_data('stock',$swhere);

        $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tquantity = $stpd[0]['totalPices']-$info['pices'][$i];
            }
        else{
            $tquantity = '-'.$info['pices'][$i];
            }

        $stock_info = array(
            'compid'     => $compid,
            'product'    => $info['productID'][$i],
            'totalPices' => $tquantity,
            'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock_info);  
        }
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Product Sale Successfully !</h4>
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
    //redirect('Sale');
    redirect('viewSale/'.$result);
      }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Select Product First !</h4>
            </div>'
                ];
        $this->session->set_userdata($sdata);
        redirect('newSale');
        }
    
}

public function view_invoice($id)
    {
    $data['title'] = 'Sale Invoice';

    $where = array(
        'saleID' => $id
            );
    $other = array(
        'join' => 'left'
            );
    $field = array(
        'sales' => 'sales.*',
        'customers' => 'customers.*'
            );
    $join = array(
        'customers' => 'customers.customerID = sales.customerID'
            );
    $prints = $this->pm->get_data('sales',$where,$field,$join,$other);
    $data['prints'] = $prints[0];

    $pfield = array(
        'sale_product' => 'sale_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $pjoin = array(
        'products' => 'products.productID = sale_product.productID'
            );

    $data['salesp'] = $this->pm->get_data('sale_product',$where,$pfield,$pjoin,$other);

    $cusid = $prints[0]['customerID'];
    //var_dump($cusid); exit();
    $data['csdue'] = $this->pm->customer_sales_due_details($id,$cusid);
    $data['cvpa'] = $this->pm->customer_vaucher_paid_details($cusid);
    $data['cra'] = $this->pm->customer_returns_details($cusid);
    $data['company'] = $this->pm->company_details();
    
    $this->load->view('sale/print_page',$data);
}

public function sale_delivery_chalan($id)
    {
    $data['title'] = 'Sale Invoice';

    $where = array(
        'saleID' => $id
            );
    $other = array(
        'join' => 'left'
            );
    $field = array(
        'sales' => 'sales.*',
        'customers' => 'customers.*'
            );
    $join = array(
        'customers' => 'customers.customerID = sales.customerID'
            );
    $prints = $this->pm->get_data('sales',$where,$field,$join,$other);
    $data['prints'] = $prints[0];

    $pfield = array(
        'sale_product' => 'sale_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $pjoin = array(
        'products' => 'products.productID = sale_product.productID'
            );

    $data['salesp'] = $this->pm->get_data('sale_product',$where,$pfield,$pjoin,$other);
    $cusid = $prints[0]['customerID'];
    //var_dump($cusid); exit();
    $data['company'] = $this->pm->company_details();
    
    $this->load->view('sale/delivery_chalan',$data);
}

public function edit_sale($id)
    {
    $data['title'] = 'Sale';

    $where = array(
        'saleID' => $id
            );

    $prints = $this->pm->get_data('sales',$where);
    $data['sale'] = $prints[0];

    $other = array(
        'join' => 'left'
            );
    $pfield = array(
        'sale_product' => 'sale_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $pjoin = array(
        'products' => 'products.productID = sale_product.productID'
            );

    $data['salesp'] = $this->pm->get_data('sale_product',$where,$pfield,$pjoin,$other);
  
  $data['product'] = $this->pm->get_product_data();
  if($_SESSION['role'] <= 2)
    {
    $data['customer'] = $this->pm->get_data('customers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
    $data['customer'] = $this->pm->get_data('customers',$where);
    }

  $this->load->view('sale/EditSale',$data);
}

public function update_sale()
    {
    $info = $this->input->post();

    $sale = array(
        'compid'         => $_SESSION['compid'],
        'saleDate'       => date('Y-m-d', strtotime($info['date'])),
        'customerID'     => $info['customerID'],
        'totalAmount'    => $info['nAmount'],
        'paidAmount'     => $info['total_paid'],
        'dueamount'      => $info['due'],
        'discount'       => $info['discount'],             
        'discountType'   => $info['disType'],
        'discountAmount' => $info['disAmount'],
        'sCost'          => $info['sCost'],
        'vCost'          => $info['vCost'],
        'vType'          => $info['vType'],             
        'vAmount'        => $info['vAmount'],
        'accountType'    => $info['accountType'],
        'accountNo'      => $info['accountNo'],
        'terms'          => $info['terms'],
        'note'           => $info['note'],             
        'upby'           => $_SESSION['uid']
            );

    $where = array(
        'saleID' => $info['saleID']
            );
    //var_dump($sale); exit();
    $result = $this->pm->update_data('sales',$sale,$where);

    $pp = $this->pm->get_data('sale_product',$where);
    $this->pm->delete_data('sale_product',$where);
    
    $lnth = count($pp);

    for($i = 0; $i < $lnth; $i++)
      {
        if($_SESSION['role'] <= 2)
          {
          $compid = $_SESSION['compid'];
          $sswhere = array(
            'product' => $pp[$i]['productID'],
            'compid'  => $_SESSION['compid']
                    );
          }
        else
          {
          $compid = $_SESSION['empid'];
          $sswhere = array(
            'product' => $pp[$i]['productID'],
            'compid'  => $_SESSION['empid']
                    );
          }

        $s2tpd = $this->pm->get_data('stock',$sswhere);

        $this->pm->delete_data('stock',$sswhere);

        if($s2tpd)
          {
          $tsqnt = $s2tpd[0]['totalPices']+$pp[$i]['quantity'];
          }
        else
          {
          $tsqnt = $pp[$i]['quantity'];
          }

        $stock = array(
          'compid'     => $compid,
          'product'    => $pp[$i]['productID'],
          'totalPices' => $tsqnt,
          'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock);  
        }
        
    $length = count($info['productID']);
    for ($i = 0; $i < $length; $i++)
        {
        $spdata = array(
            'saleID'     => $result,
            'productID'  => $info['productID'][$i],                       
            'quantity'   => $info['pices'][$i],
            'sprice'     => $info['salePrice'][$i],
            'totalPrice' => $info['totalPrice'][$i],
            'regby'      => $_SESSION['uid']
                );

        $this->pm->insert_data('sale_product',$spdata);
        
        if($_SESSION['role'] <= 2)
          {
          $compid = $_SESSION['compid'];
          $swhere = array(
            'product' => $info['productID'][$i],
            'compid'  => $_SESSION['compid']
                    );
          }
        else
          {
          $compid = $_SESSION['empid'];
          $swhere = array(
            'product' => $info['productID'][$i],
            'compid'  => $_SESSION['empid']
                    );
          }

        $stpd = $this->pm->get_data('stock',$swhere);

        $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tquantity = $stpd[0]['totalPices']-$info['pices'][$i];
            }
        else{
            $tquantity = '-'.$info['pices'][$i];
            }

        $stock_info = array(
            'compid'     => $compid,
            'product'    => $info['productID'][$i],
            'totalPices' => $tquantity,
            'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock_info);  
        }

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Sale product update Successfully !</h4>
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
    redirect('Sale');
}

public function delete_sales($id)
    {
    $where = array(
        'saleID' => $id
            );
    //var_dump($sale); exit();
    $result = $this->pm->delete_data('sales',$where);
    $pp = $this->pm->get_data('sale_product',$where);
    $result2 = $this->pm->delete_data('sale_product',$where);
    
    $lnth = count($pp);

    for($i = 0; $i < $lnth; $i++)
      {
        if($_SESSION['role'] <= 2)
          {
          $compid = $_SESSION['compid'];
          $sswhere = array(
            'product' => $pp[$i]['productID'],
            'compid'  => $_SESSION['compid']
                    );
          }
        else
          {
          $compid = $_SESSION['empid'];
          $sswhere = array(
            'product' => $pp[$i]['productID'],
            'compid'  => $_SESSION['empid']
                    );
          }

        $s2tpd = $this->pm->get_data('stock',$sswhere);

        $this->pm->delete_data('stock',$sswhere);

        if($s2tpd)
          {
          $tsqnt = $s2tpd[0]['totalPices']+$pp[$i]['quantity'];
          }
        else
          {
          $tsqnt = $pp[$i]['quantity'];
          }

        $stock = array(
          'compid'     => $compid,
          'product'    => $pp[$i]['productID'],
          'totalPices' => $tsqnt,
          'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock);  
        }
    
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Sale product delete Successfully !</h4>
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
    redirect('Sale');
}

public function all_sales_reports()
    {
    $data['title'] = 'Sales Report';

    $where = array(
        'compid' => $_SESSION['compid'],
            );
    $data['customer'] = $this->pm->get_data('customers',$where);
    $data['employee'] = $this->pm->get_data('users',$where);
    $data['company'] = $this->pm->company_details();

    if(isset($_GET['search']))
        {
        $report = $_GET['reports'];
        
        if($report == 'dailyReports')
            {
            $sdate = date("Y-m-d", strtotime($_GET['sdate']));
            $edate = date("Y-m-d", strtotime($_GET['edate']));
            $customer = $_GET['dcustomer'];
            $employee = $_GET['demployee'];
            $data['sdate'] = $sdate;
            $data['edate'] = $edate;
            $data['report'] = $report;
            //var_dump($employee); exit();
            $data['sales'] = $this->pm->get_dsales_data($sdate,$edate,$customer,$employee);
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
            $customer = $_GET['mcustomer'];
            $employee = $_GET['memployee'];
            $data['name'] = $name;
            $data['report'] = $report;

            $data['sales'] = $this->pm->get_msales_data($month,$year,$customer,$employee);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $customer = $_GET['mcustomer'];
            $employee = $_GET['memployee'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['sales'] = $this->pm->get_ysales_data($year,$customer,$employee);
            }
        }
    else
        {
        $data['sales'] = $this->pm->get_sales_data();
        }

    $this->load->view('sale/all_sales',$data);
}

public function get_sales_payment()
    {
    $section = $this->pm->get_sales_payment($_POST['id']);
    $data = json_encode($section);
    echo $data;
}

public function save_sales_payment()
    {
    $info = $this->input->post();

    $sale = [
        'saleID' => $info['saleID'],
        'amount' => $info['amount'],            
        'regby'  => $_SESSION['uid']
            ];
    //var_dump($sale); exit();
    $result = $this->pm->insert_data('sales_payment',$sale);

    $where = array(
        'saleID' => $info['saleID']
                );

    $data = [
        'paidAmount' => $info['amount']+$info['pamount'],
        'dueamount'  => $info['damount']-$info['amount'],
        'upby'       => $_SESSION['uid']
            ];
       
    $result2 = $this->pm->update_data('sales',$data,$where);
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Sale Payment add Successfully !</h4>
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
    redirect('Sale');
}

public function sales_invoice_reports()
    {
    $data['title'] = 'Sales Report';

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
            //var_dump($employee); exit();
            $data['sales'] = $this->pm->sales_ddata($sdate,$edate);
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

            $data['sales'] = $this->pm->sales_mdata($month,$year);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['sales'] = $this->pm->sales_ydata($year);
            }
        }
    else
        {
        $data['sales'] = $this->pm->sales_adata();
        }
    
    $data['company'] = $this->pm->company_details();

    $this->load->view('sale/sales_ireport',$data);
}

public function sales_due_reports()
    {
    $data['title'] = 'Due Report';


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
            //var_dump($employee); exit();
            $data['sales'] = $this->pm->sales_due_ddata($sdate,$edate);
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

            $data['sales'] = $this->pm->sales_due_mdata($month,$year);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['sales'] = $this->pm->sales_due_ydata($year);
            }
        }
    else
        {
        $data['sales'] = $this->pm->sales_due_adata();
        }
    
    $data['company'] = $this->pm->company_details();

    $this->load->view('sale/sales_dreport',$data);
}

public function top_sale_product_report()
    {
    $data['title'] = 'Top Sale Product';

    $data['sales'] = $this->pm->get_top_sales_product_data();
    
    $data['company'] = $this->pm->company_details();

    $this->load->view('sale/top_sale_product',$data);
}

public function sales_payment_reports()
    {
    $data['title'] = 'Due Payment Report';


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
            //var_dump($employee); exit();
            $data['sales'] = $this->pm->sales_ddue_paypent_ddata($sdate,$edate);
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

            $data['sales'] = $this->pm->sales_mdue_paypent_ddata($month,$year);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['sales'] = $this->pm->sales_ydue_paypent_ddata($year);
            }
        }
    else
        {
        $data['sales'] = $this->pm->sales_due_paypent_ddata();
        }
    
    $data['company'] = $this->pm->company_details();

    $this->load->view('sale/sales_preport',$data);
}

public function sales_vat_reports()
    {
    $data['title'] = 'Sales Report';

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
            //var_dump($employee); exit();
            $data['sales'] = $this->pm->get_sales_dvat_data($sdate,$edate);
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

            $data['sales'] = $this->pm->get_sales_mvat_data($month,$year);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['sales'] = $this->pm->get_sales_yvat_data($year);
            }
        }
    else
        {
        $data['sales'] = $this->pm->get_sales_vat_data();
        }

    $this->load->view('sale/sales_vreports',$data);
}

public function sales_product_reports()
  {
  $data['title'] = 'Sales Product Report';
  
  $data['product'] = $this->pm->get_data('products',false);
  $data['company'] = $this->pm->company_details();

  if(isset($_GET['search']))
    {
    $report = $_GET['reports'];
    
    if($report == 'dailyReports')
        {
        $sdate = date("Y-m-d", strtotime($_GET['sdate']));
        $edate = date("Y-m-d", strtotime($_GET['edate']));
        $pid = $_GET['dproduct'];
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['report'] = $report;
        //var_dump($data); exit();
        $data['sales'] = $this->pm->get_dsales_product_data($sdate,$edate,$pid);
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
        $pid = $_GET['mproduct'];

        $data['sales'] = $this->pm->get_msales_product_data($month,$year,$pid);
        }
    else if ($report == 'yearlyReports')
        {
        $year = $_GET['ryear'];
        $data['year'] = $year;
        $data['report'] = $report;
        $pid = $_GET['yproduct'];

        $data['sales'] = $this->pm->get_ysales_product_data($year,$pid);
        }
    }
  else
    {
    $data['sales'] = $this->pm->get_sales_product_data();
    }

    $this->load->view('sale/sales_product',$data);
}

########### Pos Sales start ##################################

public function pos_sales_info()
  {
  $other = array(
    'limit' => 30
        );
  $where = array(
    'compid' => $_SESSION['compid']
        );
  $data = [
    'title'    => 'Pos Sales',
    'company' => $this->pm->company_details(),
    'products' => $this->pm->get_data('products',$where),
    'sproduct' => $this->pm->get_data('products',$where,false,false,$other)
        ];

  $this->load->view('sale/pos_sales',$data);
}

public function get_pos_sale_details()
  {
  $id = $this->input->post('id');
  //$id = "P-SER00001";
 
  $where = array(
    'productcode' => $id,
    'compid' => $_SESSION['compid']
        );

  $products = $this->pm->get_data('products',$where);
  $str = '';
  
  foreach($products as $value)
    {
    $id = $value['productID'];
    $str.="<tr>
      <td>".$value['productName']."<input type='hidden' name='productID[]' value='".$value['productID']."' required ></td>
      <td><input type='text' class='form-control' onkeyup='getTotal(".$id.")' name='pices[]' id='quantity_".$value['productID']."' value='1' min='1' required ></td>
      <td><input type='text' class='form-control' onkeyup='getTotal(".$id.")' name='salePrice[]' id='tp_".$value['productID']."' value='".$value['sprice']."' required ></td>
      <td><input type='text' class='form-control totalPrice'  name='tPrice[]' id='totalPrice_".$value['productID']."' value='".$value['sprice']."' required readonly ></td>
      <td><span class='item_remove btn btn-danger btn-xs' onclick='deleteProduct(this)' >X</span></td>
      </tr>";
    }
  //var_dump($str); exit();
  echo json_encode($str);
}

public function save_pos_sale()
  {
  $info = $this->input->post();
  
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

    $cusid = 'INV-'.$cn.$pc;

   //var_dump($due); exit();
    $sale = array(
        'compid'         => $_SESSION['compid'],
        'invoice_no'     => $cusid,
        'saleDate'       => date('Y-m-d'),
        'customerID'     => $info['customerID'],
        'totalAmount'    => $info['nAmount'],
        'paidAmount'     => $info['totalprice'],
        'dueamount'      => $info['dAmount'],
        'discount'       => $info['discount'],           
        'discountType'   => $info['disType'],
        'discountAmount' => $info['disAmount'],
        'sCost'          => $info['sCost'],   
        'vCost'          => $info['vCost'],
        'vType'          => $info['vType'],           
        'vAmount'        => $info['vAmount'],
        'accountType'    => $info['accountType'],
        'accountNo'      => $info['accountNo'],
        'status'         => 2,             
        'regby'          => $_SESSION['uid']
            );
            
  $sid = $this->pm->insert_data('sales',$sale);
  //var_dump($pid);exit();

  $pid = $info['productID'];
  //var_dump($prid);exit();
  $length = count($pid);
    //var_dump($length);exit();
  for ($i = 0; $i < $length; $i++)
    {
    $data = array(
      'saleID'     => $sid,
      'productID'  => $info['productID'][$i],                       
      'quantity'   => $info['pices'][$i],
      'sprice'     => $info['salePrice'][$i],
      'totalPrice' => $info['tPrice'][$i],
      'regby'      => $_SESSION['uid']
          );
    //var_dump($data);exit();
    $proid = $info['productID'][$i];

    $this->pm->insert_data('sale_product',$data);

    $pid = $info['productID'][$i];
    $aid = $_SESSION['compid'];

    $swhere = array(
        'product' => $pid,
        'compid' => $aid
                );

    $stpd = $this->pm->get_data('stock',$swhere);

    $this->pm->delete_data('stock',$swhere);

    if($stpd)
        {
        $tquantity = $stpd[0]['totalPices']-($info['pices'][$i]);
        }
    else{
        $tquantity = '-'.($info['pices'][$i]);
        }

    $stock_info = array(
        'compid'     => $_SESSION['compid'],
        'product'    => $info['productID'][$i],
        'totalPices' => $tquantity,
        'regby'      => $_SESSION['uid']
                );
    //var_dump($stock_info);    
    $result = $this->pm->insert_data('stock',$stock_info);  
    }
  if($result)
    {
    redirect('printPSale/'.$sid);
    }
  else
    {
    $sdata = [
      'exception' => '<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> something is error !</h4>
        </div>'
            ];
    
    $this->session->set_userdata($sdata);
    redirect('posSales');
    }
}

public function pos_sales_details($sid)
  {
  $pid = $sid;
  $data = [
    'title'   => 'Sales',
    'company' => $this->pm->company_details(),
    'sales'   => $this->pm->get_salesdata($pid),
    'salesp'  => $this->pm->get_sales_products_data($pid)
      ];
  
  $this->load->view('sale/view_pos_sales',$data);
}

########### Pos Sales End   ##################################





}