<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Quotation extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Quotation';

  $other = array(
    'order_by' => 'qutid',
    'join' => 'left'
        );
  $field = array(
    'quotation' => 'quotation.*',
    'customers' => 'customers.*'
        );
  $join = array(
    'customers' => 'customers.customerID = quotation.customerID'
        );
  if($_SESSION['role'] <= 2)
    {
    $data['quotation'] = $this->pm->get_data('quotation',false,$field,$join,$other);
    }
  else
    {
    $where = array(
      'quotation.regby' => $_SESSION['uid']  
         );
    $data['quotation'] = $this->pm->get_data('quotation',$where,$field,$join,$other);
    }
  //var_dump($data['purchase']); exit();
  $this->load->view('quotation/quotationlist',$data);
}

public function new_quotation() 
  {
  $data['title'] = 'Quotation';

  $data['product'] = $this->pm->get_product_data();

  $this->load->view('quotation/newQuotation',$data);
}

public function getProduct($id)
  {
  $where = array(
    'productID' => $id
        );

  $productlist = $this->pm->get_data('products',$where);

  $str = "";
  foreach ($productlist as $value)
    {
    $id = $value['productID'];
    $str .= "<tr>
    <td>".$value['productName']."<input type='hidden' readonly='readonly' name='product_id[]' value='".$value['productID']."'></td>
    <td><input type='text' id='quantity_".$value['productID']."' onkeyup='getTotal(".$id.")' name='quantity[]' value='00'></td>
    <td><input type='text' onkeyup='getTotal(".$id.")' id='tp_".$value['productID']."' name='tp[]' value='".$value['sprice']."'></td>
    <td>
    <input readonly='readonly' type='text' id='totalPrice_".$value['productID']."' name='total_price[]' value='0.00' readonly>
    </td><td>
    <span class='item_remove btn btn-danger btn-xs' onClick='$(this).parent().parent().remove();'>x</span>
    </td></tr>";
    }
  echo json_encode($str);
}

public function save_quotation()
  {
  $info = $this->input->post();

  $query = $this->db->select('qinvoice')
                ->from('quotation')
                ->where('compid',$_SESSION['compid'])
                ->limit(1)
                ->order_by('qinvoice','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = substr($query->qinvoice,5)+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d",$sn);

  $cusid = 'Q-'.$cn.$pc;

  $quotation = array(
    'compid'        => $_SESSION['compid'],
    'qinvoice'      => $cusid,
    'quotationDate' => date('Y-m-d',strtotime($info['date'])),
    'customerID'    => $info['customerID'],
    'totalPrice'    => $info['totalPrice'],
    'totalQuantity' => array_sum($info['quantity']),
    'message'       => $info['message'],
    'terms'         => $info['terms'],
    'note'          => $info['note'],
    'regby'         => $_SESSION['uid']
        );
      //var_dump($quotation); exit();
  $result = $this->pm->insert_data('quotation',$quotation);
        //var_dump($purchase_id); exit();

  if($result)
    {
    $length = count($info['product_id']);
    
    for ($i = 0; $i < $length; $i++)
      {
      $qdata = array(
        'qutid'      => $result,
        'productID'  => $info['product_id'][$i],
        'salePrice'  => $info['tp'][$i],
        'quantity'   => $info['quantity'][$i],                 
        'totalPrice' => $info['total_price'][$i],
        'regby'      => $_SESSION['uid']
            );
      //var_dump($purchase_product);            
      $result2 = $this->pm->insert_data('quotation_product',$qdata);
      }
    }
  if($result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Quotation add Successfully !</h4>
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
  redirect('Quotation');
}

public function view_quotation($id)
  {
  $data['title'] = 'Quotation';

  $where = array(
    'qutid' => $id
        );
  $join = array(
    'products' => 'products.productID = quotation_product.productID'
        );
  $data['pquotation'] = $this->pm->get_data('quotation_product',$where,false,$join);
  
  $field = array(
    'quotation' => 'quotation.*',
    'customers'=>'customers.*'
        );

  $join = array(
    'customers' => 'customers.customerID = quotation.customerID'
        );
  $quotation = $this->pm->get_data('quotation',$where,$field,$join);
  $data['quotation'] = $quotation[0];    
  
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('quotation/viewquotation',$data);
}

public function edit_quotation($id)
  {
  $data['title'] = 'Quotation';

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
    'qutid' => $id
        );
  $join = array(
    'products' => 'products.productID = quotation_product.productID'
        );
  $data['pquotation'] = $this->pm->get_data('quotation_product',$where,false,$join);

  $quotation = $this->pm->get_data('quotation',$where);
  $data['quotation'] = $quotation[0];    
  
  $this->load->view('quotation/editquotation',$data);
}

public function update_Quotation()
  {
  $info = $this->input->post();

  $where = array(
    'qutid' => $info['qutid']
        );

  $quotation = array(
    'compid'        => $_SESSION['compid'],
    'quotationDate' => date('Y-m-d',strtotime($info['date'])),
    'customerID'    => $info['customer'],
    'totalPrice'    => $info['totalPrice'],
    'totalQuantity' => array_sum($info['quantity']),
    'message'       => $info['message'],
    'terms'         => $info['terms'],
    'note'          => $info['note'],
    'upby'          => $_SESSION['uid']
        );

  $result = $this->pm->update_data('quotation',$quotation,$where);

  $this->pm->delete_data('quotation_product',$where);
  
  $length = count($this->input->post('product_id'));

  for($i = 0; $i < $length; $i++)
    {
    $quotation_product = array(
      'qutid'      => $info['qutid'],
      'productID'  => $info['product_id'][$i],
      'salePrice'  => $info['tp'][$i],
      'quantity'   => $info['quantity'][$i],                 
      'totalPrice' => $info['total_price'][$i],
      'regby'      => $_SESSION['uid']
          );
    //var_dump($quotation_product); exit();
    $result2 = $this->pm->insert_data('quotation_product',$quotation_product);
    }
  if($result && $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Quotation update Successfully !</h4>
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
  redirect('Quotation');
}

public function delete_quotation($id)
  {
  $where = array(
      'qutid' => $id
          );

  $result = $this->pm->delete_data('quotation',$where);
  $result2 = $this->pm->delete_data('quotation_product',$where);
  
  if($result && $result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Quotation delete Successfully !</h4>
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
  redirect('Quotation');
}





}