<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Delivery extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}


public function index()
  {
  $data['title'] = 'Delivery';
  
  $other = array(
    'order_by' => 'did',
    'join' => 'left'
          );
  $join = array(
    'employees' => 'employees.employeeID = delivery.empid'
          );
  $field = array(
    'delivery' => 'delivery.*',
    'employees' => 'employees.employeeName,employees.phone'
          ); 
  $data['delivery'] = $this->pm->get_data('delivery',false,$field,$join,$other);

  $this->load->view('delivery/delivery_list',$data);
}

public function new_delivery()
  {
  $data['title'] = 'Delivery';
  $pType = 'Finish Good';
  $swhere = array(
    'dpt_id' => 1
        );
  $where = array(
    'pType' => 2
        );
  $data['employee'] = $this->pm->get_data('employees',$swhere);
  $data['product'] = $this->pm->get_data('products',$where);
  
  $this->load->view('delivery/new_delivery',$data);
}

public function get_delivery_product($id)
  {
  $str = "";

  $where = array(
    'productID' => $id
        );
  $other = array(
    'join' => 'left'
          );
  $field = array(
    'products' => 'products.*',
    'sma_units' => 'sma_units.unitName'
        );
  $join = array(
    'sma_units' => 'sma_units.id = products.unit'
        );
  $productlist = $this->pm->get_data('products',$where,$field,$join,$other);
    // $stock = $this->pm->get_stock_data($id);
  foreach($productlist as $value)
    {
    $stock = $this->db->select('totalPices')
              ->from('stock')
              ->where('product',$value['productID'])
              ->get()
              ->row();
    if($stock)
      {
      $sqnt = $stock->totalPices;
      }
    else
      {
      $sqnt = 0;
      }
    $id = $value['productID'];
    $str .= "<tr>
    <td>".$value['productName']."<input type='hidden' name='product[]' value='".$value['productID']."' required ></td>
    <td>".$sqnt."</td>
    <td><input type='text' class='form-control' name='quantity[]' value='0' required ></td>
    <td>".$value['unitName']."</td>
    <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span></td></tr>";
    }
  echo json_encode($str);
}

public function save_delivery()
  {
  $info = $this->input->post();

  $delivery = array(
    'compid' => $_SESSION['compid'],
    'dDate'  => date('Y-m-d',strtotime($info['date'])),
    'empid'  => $info['employee'],
    'notes'  => $info['note'],
    'regby'  => $_SESSION['uid']
        );
      //var_dump($quotation); exit();
  $result = $this->pm->insert_data('delivery',$delivery);
        //var_dump($purchase_id); exit();
  if($result)
    {
    $length = count($info['product']);
    
    for($i = 0; $i < $length; $i++)
      {
      $qdata = array(
        'did'      => $result,
        'pid'      => $info['product'][$i],
        'quantity' => $info['quantity'][$i],   
        'regby'    => $_SESSION['uid']
            );
      //var_dump($purchase_product);            
      $result2 = $this->pm->insert_data('delivery_product',$qdata);
      
      $swhere = array(
        'product' => $info['product'][$i],
        'compid'  => $info['employee']
                    );

      $stpd = $this->pm->get_data('stock',$swhere);
      $this->pm->delete_data('stock',$swhere);

      if($stpd)
        {
        $tquantity = ($info['quantity'][$i]+$stpd[0]['totalPices']);
        }
      else
        {
        $tquantity = $info['quantity'][$i];
        }

      $stock = array(
        'compid'     => $info['employee'],
        'product'    => $info['product'][$i],
        'totalPices' => $tquantity,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$stock);    
      
      $sswhere = array(
        'product' => $info['product'][$i],
        'compid'  => $_SESSION['compid']
                    );

      $sdtpd = $this->pm->get_data('stock',$sswhere);
      $this->pm->delete_data('stock',$sswhere);

      if($sdtpd)
        {
        $tqnt = ($sdtpd[0]['totalPices']-$info['quantity'][$i]);
        }
      else
        {
        $tqnt = '-'.$info['quantity'][$i];
        }

      $sstock = array(
        'compid'     => $_SESSION['compid'],
        'product'    => $info['product'][$i],
        'totalPices' => $tqnt,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$sstock); 
      }
    }
  if($result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Delivery Successfully !</h4>
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
  redirect('delivery');
}

public function view_delivery($id)
  {
  $data['title'] = 'Delivery';

  $where = array(
    'did' => $id
        );
  $other = array(
    'join' => 'left'
          );
  $join = array(
    'employees' => 'employees.employeeID = delivery.empid'
          );
  $field = array(
    'delivery' => 'delivery.*',
    'employees' => 'employees.employeeName,employees.phone'
          ); 
  $quotation = $this->pm->get_data('delivery',$where,$field,$join,$other);
  $data['delivery'] = $quotation[0];
  
  $pfield = array(
    'delivery_product' => 'delivery_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
            );
  $pjoin = array(
    'products' => 'products.productID = delivery_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
            );

  $data['pproduct'] = $this->pm->get_data('delivery_product',$where,$pfield,$pjoin,$other);
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('delivery/view_delivery',$data);
}

public function edit_delivery($id)
  {
  $data['title'] = 'Delivery';

  $where = array(
    'did' => $id
        );
  $quotation = $this->pm->get_data('delivery',$where);
  $data['delivery'] = $quotation[0];
  
  $other = array(
    'join' => 'left'
          );
  $pfield = array(
    'delivery_product' => 'delivery_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
            );
  $pjoin = array(
    'products' => 'products.productID = delivery_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
            );

  $data['pproduct'] = $this->pm->get_data('delivery_product',$where,$pfield,$pjoin,$other);
  $swhere = array(
    'dpt_id' => 1
        );
  $pwhere = array(
    'pType' => 2
        );
  $data['employee'] = $this->pm->get_data('employees',$swhere);
  $data['product'] = $this->pm->get_data('products',$pwhere);
  
  $this->load->view('delivery/edit_delivery',$data);
}

public function update_delivery()
  {
  $info = $this->input->post();

  $deliverydata = array(
    'compid' => $_SESSION['compid'],
    'dDate'  => date('Y-m-d',strtotime($info['date'])),
    'empid'  => $info['employee'],
    'notes'  => $info['note'],
    'upby'   => $_SESSION['uid']
        );
  $where = array(
    'did' => $info['did']
            );
      //var_dump($quotation); exit();
  $delivery = $this->pm->get_data('delivery',$where);
  $result = $this->pm->update_data('delivery',$deliverydata, $where);
  $pp = $this->pm->get_data('delivery_product',$where);
  $this->pm->delete_data('delivery_product',$where);
        //var_dump($purchase_id); exit();
    $lnth = count($pp);
    for($i = 0; $i < $lnth; $i++)
      {
      $swhere = array(
        'product' => $pp[$i]['pid'],
        'compid'  => $_SESSION['compid']
                    );

      $stpd = $this->pm->get_data('stock',$swhere);
      $this->pm->delete_data('stock',$swhere);

      if($stpd)
        {
        $tquantity = ($pp[$i]['quantity']+$stpd[0]['totalPices']);
        }
      else
        {
        $tquantity = $pp[$i]['quantity'];
        }

      $stock = array(
        'compid'     => $_SESSION['compid'],
        'product'    => $pp[$i]['pid'],
        'totalPices' => $tquantity,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$stock);    
      
      $sswhere = array(
        'product' => $pp[$i]['pid'],
        'compid'  => $delivery[0]['empid']
                    );

      $sdtpd = $this->pm->get_data('stock',$sswhere);
      $this->pm->delete_data('stock',$sswhere);

      if($sdtpd)
        {
        $tqnt = ($sdtpd[0]['totalPices']-$pp[$i]['quantity']);
        }
      else
        {
        $tqnt = '-'.$pp[$i]['quantity'];
        }

      $sstock = array(
        'compid'     => $delivery[0]['empid'],
        'product'    => $pp[$i]['pid'],
        'totalPices' => $tqnt,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$sstock);
      }
        
        
    $length = count($info['product']);
    
    for($i = 0; $i < $length; $i++)
      {
      $qdata = array(
        'did'      => $info['did'],
        'pid'      => $info['product'][$i],
        'quantity' => $info['quantity'][$i],   
        'regby'    => $_SESSION['uid']
            );
      //var_dump($purchase_product);            
      $result2 = $this->pm->insert_data('delivery_product',$qdata);
    
      $swhere = array(
        'product' => $info['product'][$i],
        'compid'  => $info['employee']
                    );

      $stpd = $this->pm->get_data('stock',$swhere);
      $this->pm->delete_data('stock',$swhere);

      if($stpd)
        {
        $tquantity = ($info['quantity'][$i]+$stpd[0]['totalPices']);
        }
      else
        {
        $tquantity = $info['quantity'][$i];
        }

      $stock = array(
        'compid'     => $info['employee'],
        'product'    => $info['product'][$i],
        'totalPices' => $tquantity,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$stock);    
      
      $sswhere = array(
        'product' => $info['product'][$i],
        'compid'  => $_SESSION['compid']
                    );

      $sdtpd = $this->pm->get_data('stock',$sswhere);
      $this->pm->delete_data('stock',$sswhere);

      if($sdtpd)
        {
        $tqnt = ($sdtpd[0]['totalPices']-$info['quantity'][$i]);
        }
      else
        {
        $tqnt = '-'.$info['quantity'][$i];
        }

      $sstock = array(
        'compid'     => $_SESSION['compid'],
        'product'    => $info['product'][$i],
        'totalPices' => $tqnt,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$sstock);
    }
  if($result || $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Delivery update Successfully !</h4>
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
  redirect('delivery');
}

public function delete_delivery($id)
  {
  $where = array(
    'did' => $id
            );
      //var_dump($quotation); exit();
  $delivery = $this->pm->get_data('delivery',$where);
  $result = $this->pm->delete_data('delivery',$where);
  $pp = $this->pm->get_data('delivery_product',$where);
  $this->pm->delete_data('delivery_product',$where);
  
    $lnth = count($pp);
    for($i = 0; $i < $lnth; $i++)
      {
      $swhere = array(
        'product' => $pp[$i]['pid'],
        'compid'  => $_SESSION['compid']
                    );

      $stpd = $this->pm->get_data('stock',$swhere);
      $this->pm->delete_data('stock',$swhere);

      if($stpd)
        {
        $tquantity = ($pp[$i]['quantity']+$stpd[0]['totalPices']);
        }
      else
        {
        $tquantity = $pp[$i]['quantity'];
        }

      $stock = array(
        'compid'     => $_SESSION['compid'],
        'product'    => $pp[$i]['pid'],
        'totalPices' => $tquantity,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$stock);    
      
      $sswhere = array(
        'product' => $pp[$i]['pid'],
        'compid'  => $delivery[0]['empid']
                    );

      $sdtpd = $this->pm->get_data('stock',$sswhere);
      $this->pm->delete_data('stock',$sswhere);

      if($sdtpd)
        {
        $tqnt = ($sdtpd[0]['totalPices']-$pp[$i]['quantity']);
        }
      else
        {
        $tqnt = '-'.$pp[$i]['quantity'];
        }

      $sstock = array(
        'compid'     => $delivery[0]['empid'],
        'product'    => $pp[$i]['pid'],
        'totalPices' => $tqnt,
        'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info); exit();
      $this->pm->insert_data('stock',$sstock);
      }
        
  if($result || $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Delivery delete Successfully !</h4>
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
  redirect('delivery');
}

public function delivery_product_reports()
  {
  $data['title'] = 'Delivery Product Report';
  
  $data['users'] = $this->pm->get_data('users',false);
  $data['employee'] = $this->pm->get_data('employees',false);
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
        $uid = $_GET['duser'];
        $emp = $_GET['demployee'];
        //var_dump($data); exit();
        $data['sales'] = $this->pm->get_ddelivery_product_data($sdate,$edate,$uid,$emp);
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
        $uid = $_GET['muser'];
        $emp = $_GET['memployee'];

        $data['sales'] = $this->pm->get_mdelivery_product_data($month,$year,$uid,$emp);
        }
    else if ($report == 'yearlyReports')
        {
        $year = $_GET['ryear'];
        $data['year'] = $year;
        $data['report'] = $report;
        $uid = $_GET['yuser'];
        $emp = $_GET['yemployee'];

        $data['sales'] = $this->pm->get_ydelivery_product_data($year,$uid,$emp);
        }
    }
  else
    {
    $data['sales'] = $this->pm->get_delivery_product_data();
    }

    $this->load->view('delivery/delivery_product',$data);
}






}