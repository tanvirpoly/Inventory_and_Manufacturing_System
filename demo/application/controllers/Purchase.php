<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase extends CI_Controller {

public function __construct()
    {
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Purchase';

  $join = array(
    'suppliers' => 'suppliers.supplierID = purchase.supplier'
        );
  $other = array(
    'order_by'=>'purchaseID',
    'join' => 'left'
        );
  $field = array(
    'purchase' => 'purchase.*',
    'suppliers' => 'suppliers.supplierName,suppliers.mobile'
        );    
  if($_SESSION['role'] <= 2)
    {
    $data['purchase'] = $this->pm->get_data('purchase',false,$field,$join,$other);
    }
  else
    {
    $where = array(
      'purchase.regby' => $_SESSION['uid']  
         );
    $data['purchase'] = $this->pm->get_data('purchase',$where,$field,$join,$other);
    }
  $this->load->view('purchase/purchase_list',$data);
}

public function new_purchase() 
  {
  $data['title'] = 'Purchase';

  $where = array(
    'status' => 'Active' 
        );

  //$data['product'] = $this->pm->get_data('products',$where);
  $data['product'] = $this->pm->get_product_data();
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
  //$data['supplier'] = $this->pm->get_data('suppliers',$where);
  $data['category'] = $this->pm->get_data('categories',$where);
  $data['unit'] = $this->pm->get_sma_units_data();

  $this->load->view('purchase/newPurchase',$data);
}

public function get_purchase_supplier()
  {
  if($_SESSION['role'] <= 2)
    {
    $grup = $this->pm->get_data('suppliers',false);
    }
  else
    {
    $where = array(
      'regby' => $_SESSION['uid']  
         );
    $grup = $this->pm->get_data('suppliers',$where);
    }
  
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function get_purchase_product()
  {
  if($_SESSION['role'] <= 2)
    {
    $grup = $this->pm->get_data('products',false);
    }
  else
    {
    $where = array(
      'empid' => $_SESSION['empid']  
         );
    $other = array(
     'order_by' => 'productID',
     'group_by' => 'pid',
     'join'     => 'left' 
        );
    $field = array(
      'products'  => 'products.*',
      'delivery_product' => 'delivery_product.pid',
      'delivery'  => 'delivery.empid'
        );
    $join = array(
      'delivery_product' => 'delivery_product.pid = products.productID',
      'delivery'  => 'delivery.did = delivery_product.did'
        );
    $grup = $this->pm->get_data('delivery_product',$where,$field,$join,$other);
    }
  $someJSON = json_encode($grup);
  echo $someJSON;
}

public function get_Product($id)
    {
    $str = "";

    $where = array(
        'productID' => $id
            );

    $productlist = $this->pm->get_data('products',$where);
    // $stock = $this->pm->get_stock_data($id);
    foreach ($productlist as $value)
        {
        $id = $value['productID'];
        $str .= "<tr>
        <td>".$value['productName']."<input type='hidden' readonly='readonly' name='product_id[]' value='".$value['productID']."'></td>
        <td><input type='text' id='quantity_".$value['productID']."' onkeyup='getTotal(".$id.")' name='quantity[]' value='0'></td>
        <td><input type='text' onkeyup='getTotal(".$id.")' id='tp_".$value['productID']."' name='pprice[]' value='".$value['pprice']."'></td>
        <td><input type='text' class='tPrice' id='totalPrice_" . $value['productID']."' name='total_price[]' value='0.00' readonly ></td>
        <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span></td>
        </tr>";
        }
    echo json_encode($str);
}

public function savedPurchase()
    {
    $info = $this->input->post();

    $query = $this->db->select('challanNo')
                  ->from('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('challanNo','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->challanNo,6)+1;
        }
    else
        {
        $sn = 1;
        }
    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d",$sn);

    $cusid = 'PO-'.$cn.$pc;
    //var_dump($cusid); exit();
    $purchase = array(
        'compid'       => $_SESSION['compid'],
        'challanNo'    => $cusid,
        'purchaseDate' => date('Y-m-d', strtotime($info['date'])),
        'supplier'     => $info['suppliers'],
        'totalPrice'   => $info['totalPrice'],
        'paidAmount'   => $info['Paid'],
        'due'          => $info['totalPrice']-$info['Paid'],
        'sCost'        => $info['sCost'],
        'vCost'        => $info['vCost'],
        'vType'        => $info['vType'],
        'vAmount'      => $info['vAmount'],
        'discount'     => $info['discount'],
        'disType'      => $info['disType'],
        'disAmount'    => $info['disAmount'],
        'accountType'  => $info['accountType'],
        'accountNo'    => $info['accountNo'],
        'terms'        => $info['terms'],
        'note'         => $info['note'],
        'regby'        => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
    $result = $this->pm->insert_data('purchase',$purchase);

    $length = count($info['product_id']);
        
    for ($i = 0; $i < $length; $i++)
        {
        $purchase_product = array(
            'purchaseID' => $result,
            'productID'  => $info['product_id'][$i],
            'quantity'   => $info['quantity'][$i],
            'pprice'     => $info['pprice'][$i],                    
            'totalPrice' => $info['total_price'][$i],
            'regby'      => $_SESSION['uid']
                );
        //var_dump($purchase_product);            
        $result2 = $this->pm->insert_data('purchase_product',$purchase_product); 
        if($_SESSION['role'] <= 2)
          {
          $compid = $_SESSION['compid'];
          $swhere = array(
            'product' => $info['product_id'][$i],
            'compid'  => $_SESSION['compid']
                    );
          }
        else
          {
          $compid = $_SESSION['empid'];
          $swhere = array(
            'product' => $info['product_id'][$i],
            'compid'  => $_SESSION['empid']
                    );
          }
        $stpd = $this->pm->get_data('stock',$swhere);

        $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tquantity = $info['quantity'][$i]+$stpd[0]['totalPices'];
            }
        else{
            $tquantity = $info['quantity'][$i];
            }

        $stock_info = array(
            'compid'     => $compid,
            'product'    => $info['product_id'][$i],
            'totalPices' => $tquantity,
            'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info);    
        $this->pm->insert_data('stock',$stock_info);                 
        }
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Purchase add Successfully !</h4>
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
    redirect('Purchase');
}

public function view_purchase($id)
    {
    $data['title'] = 'Purchase';

    $pwhere = array(
        'purchaseID' => $id
            );
    $pfield = array(
        'purchase_product' => 'purchase_product.*',
        'products' => 'products.productName,products.productcode',
        'sma_units' => 'sma_units.unitName'
            );
    $pjoin = array(
        'products' => 'products.productID = purchase_product.productID',
        'sma_units' => 'sma_units.id = products.unit'
            );
    $pother = array(
        'join' => 'left'
            );

    $data['pproduct'] = $this->pm->get_data('purchase_product',$pwhere,$pfield,$pjoin,$pother);
    // var_dump($data['pproduct']);exit();

    $join = array(
        'suppliers' => 'purchase.supplier = suppliers.supplierID'
            );
    $field = array(
        'purchase' => 'purchase.*',
        'supplier' => 'suppliers.supplierName, suppliers.mobile, suppliers.address, suppliers.sup_id'
            );

    $purchase = $this->pm->get_data('purchase',$pwhere,$field,$join,$pother);
    $data['purchase'] = $purchase[0];
    // var_dump($purchase);exit();

    $sid = $purchase[0]['supplier'];
    //var_dump($cusid); exit();
    $data['csdue'] = $this->pm->supplier_purchases_due_details($id,$sid);
    $data['cvpa'] = $this->pm->supplier_paid_details($sid);
    //var_dump($data['csdue']);var_dump($data['cvpa']); exit();
    $data['company'] = $this->pm->company_details();
    
    $this->load->view('purchase/viewPurchase',$data);
}

public function edit_purchase($id)
    {
    $data['title'] = 'Purchase';

    $pwhere = array(
        'purchaseID' => $id
            );
    $pfield = array(
        'purchase_product' => 'purchase_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $pjoin = array(
        'products' => 'products.productID = purchase_product.productID'
            );
    $pother = array(
        'join' => 'left'
            );

    $data['pproduct'] = $this->pm->get_data('purchase_product',$pwhere,$pfield,$pjoin,$pother);

    $purchase = $this->pm->get_data('purchase',$pwhere);
    $data['purchase'] = $purchase[0];

  $data['product'] = $this->pm->get_product_data();
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
    
    $this->load->view('purchase/editPurchase',$data);
}

public function update_purchase()
    {
    $info = $this->input->post();

    $purchase = array(
        'compid'      => $_SESSION['compid'],
        'purchaseDate'=> date('Y-m-d',strtotime($info['date'])),
        'supplier'    => $info['suppliers'],
        'totalPrice'  => $info['totalPrice'],
        'paidAmount'  => $info['Paid'],
        'due'         => $info['totalPrice']-$info['Paid'],
        'sCost'       => $info['sCost'],
        'vCost'       => $info['vCost'],
        'vType'       => $info['vType'],
        'vAmount'     => $info['vAmount'],
        'discount'    => $info['discount'],
        'disType'     => $info['disType'],
        'disAmount'   => $info['disAmount'],
        'accountType' => $info['accountType'],
        'accountNo'   => $info['accountNo'],
        'terms'       => $info['terms'],
        'note'        => $info['note'],
        'upby'        => $_SESSION['uid']
            );

    $where = array(
        'purchaseID' => $info['purhcase_id']
            );

    $result = $this->pm->update_data('purchase',$purchase,$where);
    
    $pp = $this->pm->get_data('purchase_product',$where);
    $this->pm->delete_data('purchase_product',$where);
    
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
          $tsqnt = $s2tpd[0]['totalPices']-$pp[$i]['quantity'];
          }
        else
          {
          $tsqnt = '-'.$pp[$i]['quantity'];
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
    
    //$this->pm->delete_data('purchase_product',$where);

    $length = count($info['product_id']);
   // var_dump($length); exit();
    for ($i = 0; $i < $length; $i++)
        {
        $purchase_product = array(
            'purchaseID' => $info['purhcase_id'],
            'productID'  => $info['product_id'][$i],
            'quantity'   => $info['quantity'][$i],
            'pprice'     => $info['pprice'][$i],                    
            'totalPrice' => $info['total_price'][$i],
            'regby'      => $_SESSION['uid']
                );
        //var_dump($purchase_product);            
        $this->pm->insert_data('purchase_product',$purchase_product); 
        
        if($_SESSION['role'] <= 2)
          {
          $compid = $_SESSION['compid'];
          $swhere = array(
            'product' => $info['product_id'][$i],
            'compid'  => $_SESSION['compid']
                    );
          }
        else
          {
          $compid = $_SESSION['empid'];
          $swhere = array(
            'product' => $info['product_id'][$i],
            'compid'  => $_SESSION['empid']
                    );
          }

        $stpd = $this->pm->get_data('stock',$swhere);

        $this->pm->delete_data('stock',$swhere);

        if($stpd)
            {
            $tquantity = ($info['quantity'][$i]+$stpd[0]['totalPices']);
            }
        else{
            $tquantity = $info['quantity'][$i];
            }

        $stock_info = array(
            'compid'     => $compid,
            'product'    => $info['product_id'][$i],
            'totalPices' => $tquantity,
            'regby'      => $_SESSION['uid']
                    );
        //var_dump($stock_info); exit();
        $result2 = $this->pm->insert_data('stock',$stock_info);                 
        }
    if($result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Purchase update Successfully !</h4>
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
    redirect('Purchase');
}

public function delete_purchases($id)
    {
    $where = array(
        'purchaseID' => $id
            );

    $result = $this->pm->delete_data('purchase',$where);
    
    $pp = $this->pm->get_data('purchase_product',$where);
    $this->pm->delete_data('purchase_product',$where);
    
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
          $tsqnt = $s2tpd[0]['totalPices']-$pp[$i]['quantity'];
          }
        else
          {
          $tsqnt = '-'.$pp[$i]['quantity'];
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

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Purchase delete Successfully !</h4>
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
    redirect('Purchase');
}

public function purchases_reports()
  {
  $data = ['title' => 'Purchase Reports'];
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
            $supplier = $_GET['dsupplier'];
            $data['sdate'] = $sdate;
            $data['edate'] = $edate;
            $data['report'] = $report;
            //var_dump($employee); exit();
            $data['purchase'] = $this->pm->get_dpurchses_data($sdate,$edate,$supplier);
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
            $supplier = $_GET['msupplier'];
            $data['name'] = $name;
            $data['report'] = $report;

            $data['purchase'] = $this->pm->get_mpurchses_data($month,$year,$supplier);
            }
        else if ($report == 'yearlyReports')
            {
            $year = $_GET['ryear'];
            $supplier = $_GET['ysupplier'];
            $data['year'] = $year;
            $data['report'] = $report;

            $data['purchase'] = $this->pm->get_ypurchses_data($year,$supplier);
            }
        }
    else
        {
        $data['purchase'] = $this->pm->get_purchses_data();
        }

    $this->load->view('purchase/purchase_reports',$data);
}

public function get_purchase_payment()
    {
    $section = $this->pm->get_purchase_payment($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function save_purchase_payment()
    {
    $info = $this->input->post();

    $sale = [
        'pur_id' => $info['purchaseID'],
        'amount' => $info['amount'],            
        'regby'  => $_SESSION['uid']
            ];
    //var_dump($sale); exit();
    $result = $this->pm->insert_data('purchase_payment',$sale);

    $where = array(
        'purchaseID' => $info['purchaseID']
                );

    $data = [
        'paidAmount' => $info['amount']+$info['pamount'],
        'due'        => $info['damount']-$info['amount'],
        'upby'       => $_SESSION['uid']
            ];
       
    $result2 = $this->pm->update_data('purchase',$data,$where);
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i> Purchase Payment add Successfully !</h4>
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
    redirect('Purchase');
}





}