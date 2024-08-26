<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Returns extends CI_Controller {

public function __construct(){
    parent::__construct();
    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Returns';

  $other = array(
    'join' => 'left',
    'order_by' => 'rid'
        );
  $field = array(
    'returns' => 'returns.*',
    'customers' => 'customers.customerName,customers.cus_id,customers.mobile'
        );
  $join = array(
    'customers' => 'customers.customerID = returns.customerID'
        );
  if($_SESSION['role'] <= 2)
    {
    $data['return'] = $this->pm->get_data('returns',false,$field,$join,$other);
    }
  else
    {
    $where = array(
      'returns.regby' => $_SESSION['uid']  
         );
    $data['return'] = $this->pm->get_data('returns',$where,$field,$join,$other);
    }

  $this->load->view('return/returns',$data);
}

public function new_return()
  {
  $data['title'] = 'Returns';
    
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

  $this->load->view('return/newReturn',$data);
}

public function returns_by_sales_invoice()
    {
    $id = $this->input->post('returnid');
    $swhere = array(
        'invoice_no' => $id
            );
    $sother = array(
        'order_by' => 'saleID'
            );
    $sales = $this->pm->get_data('sales',$swhere,false,false,$sother);
    if($sales)
        {
        //var_dump($sales); exit();
    $data['returns'] = $sales[0];
    
    $data['title'] = 'Returns';

  $data['product'] = $this->pm->get_product_data();
  if($_SESSION['role'] <= 2)
    {
    $data['customer'] = $this->pm->get_data('customers',false);
    }
  else
    {
    $cwhere = array(
      'regby' => $_SESSION['uid']  
         );
    $data['customer'] = $this->pm->get_data('customers',$cwhere);
    }

    $where = array(
        'saleID' => $sales[0]['saleID']            
            );
    $other = array(
        'join' => 'left'
            );
    $field = array(
        'sale_product' => 'sale_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $join = array(
        'products' => 'products.productID = sale_product.productID'
            );
    $data['rproduct'] = $this->pm->get_data('sale_product',$where,$field,$join,$other);

    $this->load->view('return/newsReturn',$data);
    
        }
    else
        {
        $sdata = [
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> This Invoice ID Can not exit !</h4>
            </div>'
                ];
        $this->session->set_userdata($sdata);
        redirect('newReturn');
        }
}

public function getDetails()
    {
    $join = false;
    $other = false;
    $table = $this->input->post('table');
    $id = $this->input->post('id');
 
    if($table == "products")
        {
        $where = array('productID' => $id);
        }

    $products = $this->pm->get_data($table,$where,false,$join,$other);
    $str='';
    foreach($products as $value){
        $id=$value['productID'];
        $str.="<tr>
        <td>".$value['productName']." ( ".$value['productcode']." )"."<input type='hidden' name='productID[]' value='".$value['productID']."'>
        </td>
        <td><input type='text' onkeyup='totalPrice(".$id.")' name='pices[]' id='pices_".$value['productID']."' value='0'>
        </td>
        <td>".$value['sprice']."<input type='hidden' onkeyup='totalPrice(".$id.")' name='salePrice[]' id='salePrice_".$value['productID']."' value='".$value['sprice']."'>
        </td>
        <td><input type='text' class='totalPrice' name='totalPrice[]' readonly id='totalPrice_".$value['productID']."' value='0'>
        </td>
        <td><input type='button' class='btn btn-danger' value='Remove' onClick='$(this).parent().parent().remove();''></td>
        </tr>";
        }
    echo json_encode($str);
}

public function save_returns()
    {
    $info = $this->input->post();

    $query = $this->db->select('rid')
                  ->from('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->limit(1)
                  ->order_by('rid','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->rid,5)+1;
        }
    else
        {
        $sn = 1;
        }

    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d", $sn);

    $cusid = 'R-'.$cn.$pc;

    if ($info['sctype'] == '%')
        {
        $amount = ($info['totalprice']*$info['scAmount'])/100;
        }
    else
        {
        $amount = $info['scharge'];
        }

    $data = array(
        'returnDate' => date('Y-m-d',strtotime($info['date'])),
        'rid'        => $cusid,
        'compid'     => $_SESSION['compid'],
        'customerID' => $info['customer'],
        'invoice'    => $info['invoice'],
        'totalPrice' => $info['totalprice'],
        'paidAmount' => $info['totalprice']-$amount,
        'scharge'    => $info['scharge'],      
        'sctype'     => $info['sctype'],
        'scAmount'   => $amount,
        'accountType'=> $info['accountType'],
        'accountNo'  => $info['accountNo'], 
        'note'       => $info['note'],          
        'regby'      => $_SESSION['uid']
            );
    //var_dump($sale); exit();
    
    $result = $this->pm->insert_data('returns',$data);
       
    $length = count($info['productID']);

    for ($i = 0;$i < $length;$i++)
        {
        $rpdata = array(
            'rt_id'      => $result,
            'compid'     => $_SESSION['compid'],
            'productID'  => $info['productID'][$i],
            'quantity'   => $info['pices'][$i],
            'salePrice'  => $info['salePrice'][$i],
            'totalPrice' => $info['totalPrice'][$i],
            'regby'      => $_SESSION['uid']
                );

        $result2 = $this->pm->insert_data('returns_product',$rpdata);
        
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
            $tquantity = $info['pices'][$i]+$stpd[0]['totalPices'];
            }
        else{
            $tquantity = $info['pices'][$i];
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
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Products Returns add Successfully !</h4>
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
    redirect('Return');
}

public function view_return($id)
    {
    $data['title'] = 'Return View';

    $other = array(
        'join' => 'left'
            );
    $where = array(
        'returnId' => $id
            );
    $field = array(
        'returns' => 'returns.*',
        'customers' => 'customers.*'
            );
    $join = array(
        'customers' => 'customers.customerID = returns.customerID'
            );

    $returns = $this->pm->get_data('returns',$where,$field,$join,$other);
    $data['returns'] = $returns[0];


    $rwhere = array(
        'rt_id' => $id,            
            );
    $rfield = array(
        'returns_product' => 'returns_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $rjoin = array(
        'products' => 'returns_product.productID = products.productID',
            );

    $data['rproduct']=$this->pm->get_data('returns_product',$rwhere,$rfield,$rjoin,$other);
    $data['company'] = $this->pm->company_details();

    $this->load->view('return/viewReturns',$data);
}

public function edit_returns($id)
    {
    $data['title'] = 'Returns';

    $cwhere = array(
        'compid' => $_SESSION['compid']
            );  

    $data['customer'] = $this->pm->get_data('customers',$cwhere);
    $data['product'] = $this->pm->get_data('products',$cwhere);

    $swhere = array(
        'returnId' => $id
            );
    $sales = $this->pm->get_data('returns',$swhere);
    $data['returns'] = $sales[0];

    $where = array(
        'rt_id' => $id            
            );
    $field = array(
        'returns_product' => 'returns_product.*',
        'products' => 'products.productName,products.productcode'
            );
    $join = array(
        'products'=>'returns_product.productID = products.productID'
            );
    $other = array(
        'join'=>'left'
            );
    $data['rproduct'] = $this->pm->get_data('returns_product',$where,$field,$join,$other);

    $this->load->view('return/editReturn',$data);
}

public function update_returns()
    {
    $info = $this->input->post();

    if ($info['sctype'] == '%')
        {
        $amount = ($info['totalprice']*$info['scAmount'])/100;
        }
    else
        {
        $amount = $info['scharge'];
        }

    $sale = array(
        'returnDate' => date('Y-m-d',strtotime($info['date'])),
        'customerID' => $info['customer'],
        'invoice'    => $info['invoice'],
        'totalPrice' => $info['totalprice'],
        'paidAmount' => $info['totalprice']-$amount,
        'scharge'    => $info['scharge'],      
        'sctype'     => $info['sctype'],
        'scAmount'   => $amount,
        'accountType'=> $info['accountType'],
        'accountNo'  => $info['accountNo'], 
        'note'       => $info['note'],            
        'upby'       => $_SESSION['uid']
            );
    //var_dump($sale); exit();
    $where = array(
        'returnId' => $info['returnId']
            );

    $result = $this->pm->update_data('returns',$sale,$where);
    //$this->pm->delete_data('returns_product',$rwhere);
    $pp = $this->pm->get_data('returns_product',$where);
    $this->pm->delete_data('returns_product',$where);
    
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
       
    $length = count($info['productID']);
        //var_dump($length); exit();
    for($i = 0;$i < $length;$i++)
        {
        $return_product = array(
            'rt_id'      => $info['returnId'],
            'productID'  => $info['productID'][$i],
            'quantity'   => $info['pices'][$i],
            'salePrice'  => $info['salePrice'][$i],
            'totalPrice' => $info['totalPrice'][$i],
            'regby'      => $_SESSION['uid']
                );

        $rp_id = $this->pm->update_data('returns_product',$return_product,$rwhere);
        
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
            $tquantity = $info['pices'][$i]+$stpd[0]['totalPices'];
            }
        else{
            $tquantity = $info['pices'][$i];
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
          'exception' =>'<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Products Returns update Successfully !</h4>
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
    redirect('Return');
}

public function delete_returns($id)
    {
    $where = array(
        'returnId' => $id
            );

    $result = $this->pm->delete_data('returns',$where);

    $rwhere = array(
        'rt_id' => $id
            );
    $pp = $this->pm->get_data('returns_product',$rwhere);
    $result2 =$this->pm->delete_data('returns_product',$rwhere);
    
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
    
    if($result && $result2)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Products Returns delete Successfully !</h4>
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
    redirect('Return');
}





}