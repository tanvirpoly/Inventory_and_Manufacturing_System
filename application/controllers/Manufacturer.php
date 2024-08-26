<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Manufacturer extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
  $this->load->library('zend');
  $this->zend->load('Zend/Barcode'); 
}

public function index()
  {
  $data['title'] = 'Manufacturer';

  $other = array(
    'order_by' => 'mid'
          ); 
  $data['manufacturer'] = $this->pm->get_data('manufacturer',false,false,false,$other);

  $this->load->view('manufacturer/manufacturer_list',$data);
}

public function new_manufacturer() 
  {
  $data['title'] = 'Manufacturer';

  $where = array(
    'pType' => 1
        );
  $uwhere = array(
    'pType' => 2
        );
  $data['rproduct'] = $this->pm->get_data('products',$where);
  $data['fproduct'] = $this->pm->get_data('products',$uwhere);

  $this->load->view('manufacturer/new_manufacturer',$data);
}

public function get_Manufacturer_Product($id)
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
    <td>".$value['productName']."<input type='hidden' name='mproduct[]' value='".$value['productID']."' required ></td>
    <td>".$sqnt."<input type='hidden' name='stock[]' value='".$sqnt."' required ></td>
    <td><input type='text' class='form-control' name='mquantity[]' value='0' required ></td>
    <td>".$value['unitName']."</td>
    <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span></td>
    </tr>";
    }
  echo json_encode($str);
}

public function get_Finish_Product()
  {
  $pcode = $this->input->post('pcode');
  $batch = 'NB-'.sprintf("%'05d",$pcode);
  
  $id = $this->input->post('id');
  $str = "";
  
  $other = array(
    'join' => 'left'
          );
  $where = array(
    'productID' => $id
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
    $id = $value['productID'];
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
    $str .= "<tr>
    <td>".$value['productName']."<input type='hidden' name='fproduct[]' value='".$value['productID']."' required ></td>
    <td>".$sqnt."</td>
    <td>".$batch."<input type='hidden' name='batch[]' value='".$batch."' required ></td>
    <td><input type='text' class='form-control' name='fquantity[]' value='0' required ></td>
    <td>".$value['unitName']."</td>
    <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span></td>
    </tr>";
    }
  echo json_encode($str);
}

public function save_manufacturer()
  {
  $info = $this->input->post();
  
  $lnth = count($info['mproduct']);
        
  for($j = 0; $j < $lnth; $j++)
    {
    if($info['mquantity'][$j] > $info['stock'][$j])
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Manufacturer Quantity is greater than Stock !</h4>
        </div>'
            ];
      $this->session->set_userdata($sdata);
      redirect('newManufacturer');
      }
    }

  $purchase = array(
    'compid' => $_SESSION['compid'],
    'mType'  => 1,
    'mDate'  => date('Y-m-d', strtotime($info['date'])),
    'notes'  => $info['note'],
    'regby'  => $_SESSION['uid']
            );
        //var_dump($purchase); exit();
  $result = $this->pm->insert_data('manufacturer',$purchase);

  $length = count($info['mproduct']);
        
  for($i = 0; $i < $length; $i++)
    {
    $mproduct = array(
      'mid'      => $result,
      'pid'      => $info['mproduct'][$i],
      'quantity' => $info['mquantity'][$i],
      'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('manufact_product',$mproduct); 

    $swhere = array(
      'product' => $info['mproduct'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tquantity = $stpd[0]['totalPices']-$info['mquantity'][$i];
      }
    else
      {
      $tquantity = '-'.$info['mquantity'][$i];
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['mproduct'][$i],
      'totalPices' => $tquantity,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock_info);                 
    }
    
  $lngth = count($info['fproduct']);
        
  for($i = 0; $i < $lngth; $i++)
    {
    $fproduct = array(
      'mid'      => $result,
      'pid'      => $info['fproduct'][$i],
      'batch'    => $info['batch'][$i],
      'quantity' => $info['fquantity'][$i],
      'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);    
        
    $result2 = $this->pm->insert_data('manufact_cproduct', $fproduct); 

    $swhere = array(
      'product' => $info['fproduct'][$i],
      'batch'   => $info['batch'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $stpd[0]['totalPices']+$info['fquantity'][$i];
      }
    else
      {
      $tqnt = $info['fquantity'][$i];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['fproduct'][$i],
      'batch'      => $info['batch'][$i],
      'totalPices' => $tqnt,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock', $stock);                 
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Manufacturer Successfully !</h4>
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
  redirect('Manufacturer');
  
}

public function view_manufacturer($id)
  {
  $data['title'] = 'Manufacturer';
  
  $other = array(
    'join' => 'left'
        );
  $where = array(
    'mid' => $id
        );
  $pfield = array(
    'manufact_product' => 'manufact_product.*',
    'products' => 'products.productName,products.productcode,products.pprice',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.productID = manufact_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['mproduct'] = $this->pm->get_data('manufact_product',$where,$pfield,$pjoin,$other);
  $ffield = array(
    'manufact_cproduct' => 'manufact_cproduct.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $fjoin = array(
    'products' => 'products.productID = manufact_cproduct.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['fproduct'] = $this->pm->get_data('manufact_cproduct',$where,$ffield,$fjoin,$other);
    // var_dump($data['pproduct']);exit();

  $purchase = $this->pm->get_data('manufacturer',$where);
  $data['manufacturer'] = $purchase[0];
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('manufacturer/view_manufacturer',$data);
}

public function edit_manufacturer($id)
  {
  $data['title'] = 'Manufacturer';

  $other = array(
    'join' => 'left'
        );
  $where = array(
    'mid' => $id
        );
  $pfield = array(
    'manufact_product' => 'manufact_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.productID = manufact_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['mproduct'] = $this->pm->get_data('manufact_product',$where,$pfield,$pjoin,$other);
  $ffield = array(
    'manufact_cproduct' => 'manufact_cproduct.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $fjoin = array(
    'products' => 'products.productID = manufact_cproduct.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['pproduct'] = $this->pm->get_data('manufact_cproduct',$where,$ffield,$fjoin,$other);
    // var_dump($data['pproduct']);exit();

  $purchase = $this->pm->get_data('manufacturer',$where);
  $data['manufacturer'] = $purchase[0];

  $swhere = array(
    'pType' => 1
        );
  $uwhere = array(
    'pType' => 2
        );
  $data['rproduct'] = $this->pm->get_data('products',$swhere);
  $data['fproduct'] = $this->pm->get_data('products',$uwhere);
    
  $this->load->view('manufacturer/edit_manufacturer',$data);
}

public function update_manufacturer()
  {
  $info = $this->input->post();
  
  $purchase = array(
    'compid' => $_SESSION['compid'],
    'mDate'  => date('Y-m-d', strtotime($info['date'])),
    'notes'  => $info['note'],
    'regby'  => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
  $where = array(
    'mid' => $info['mid']
        );
  $result = $this->pm->update_data('manufacturer',$purchase,$where);
  $mp = $this->pm->get_data('manufact_product',$where);
  $this->pm->delete_data('manufact_product',$where);
  $fp = $this->pm->get_data('manufact_cproduct',$where);
  $this->pm->delete_data('manufact_cproduct',$where);

  $lnth = count($mp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'product' => $mp[$i]['pid']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    //$this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']+$mp[$i]['quantity'];
      }
    else
      {
      $tsqnt = $mp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $mp[$i]['pid'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);
    
    $mbproduct = array(
      'mid'       => $info['mid'],
      'pid'       => $mp[$i]['pid'],
      'quantity'  => $mp[$i]['quantity'],
      'regby'     => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $this->pm->insert_data('manufact_product_backup',$mbproduct); 
    }
    
  $ln2th = count($fp);

  for($i = 0; $i < $ln2th; $i++)
    {
    $sswhere = array(
      'product' => $fp[$i]['pid'],
      'batch'   => $fp[$i]['batch']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    //$this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']-$fp[$i]['quantity'];
      }
    else
      {
      $tsqnt = '-'.$fp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $fp[$i]['pid'],
      'batch'      => $fp[$i]['batch'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);  
    }
    
  $length = count($info['mproduct']);
        
  for($i = 0; $i < $length; $i++)
    {
    $pqunatity = $this->db->select('quantity')->from('manufact_product_backup')->where('mid',$info['mid'])->where('pid',$info['mproduct'][$i])->order_by('mpbid','DESC')->limit(1)->get()->row();
        
    $mproduct = array(
      'mid'       => $info['mid'],
      'pid'       => $info['mproduct'][$i],
      'pquantity' => $pqunatity->quantity,
      'quantity'  => $info['mquantity'][$i],
      'regby'     => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('manufact_product',$mproduct); 

    $swhere = array(
      'product' => $info['mproduct'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tquantity = $stpd[0]['totalPices']-$info['mquantity'][$i];
      }
    else
      {
      $tquantity = '-'.$info['mquantity'][$i];
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['mproduct'][$i],
      'totalPices' => $tquantity,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock_info);                 
    }
    
  $lngth = count($info['fproduct']);
        
  for($i = 0; $i < $lngth; $i++)
    {
    $fproduct = array(
      'mid'      => $info['mid'],
      'pid'      => $info['fproduct'][$i],
      'batch'    => $info['batch'][$i],
      'quantity' => $info['fquantity'][$i],
      'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result3 = $this->pm->insert_data('manufact_cproduct',$fproduct); 

    $swhere = array(
      'product' => $info['fproduct'][$i],
      'batch'   => $info['batch'][$i],
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $stpd[0]['totalPices']+$info['fquantity'][$i];
      }
    else
      {
      $tqnt = $info['fquantity'][$i];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['fproduct'][$i],
      'batch'      => $info['batch'][$i],
      'totalPices' => $tqnt,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock', $stock);                 
    }
    
  if($result || $result2 || $result3)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Manufacturer update Successfully !</h4>
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
  redirect('Manufacturer');
}

public function approve_manufacturer($id)
  {
  $purchase = array(
    'status' => 1,
    'regby'  => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
  $where = array(
    'mid' => $id
        );
  $result = $this->pm->update_data('manufacturer',$purchase,$where);
  $mp = $this->pm->get_data('manufact_product',$where);
  $fp = $this->pm->get_data('manufact_cproduct',$where);
  
  $lnth = count($mp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'product' => $mp[$i]['pid']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']-$mp[$i]['quantity'];
      }
    else
      {
      $tsqnt = '-'.$mp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $mp[$i]['pid'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);
    }
    
  $ln2th = count($fp);

  for($i = 0; $i < $ln2th; $i++)
    {
    $sswhere = array(
      'product' => $fp[$i]['pid'],
      'batch'   => $fp[$i]['batch']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    $this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']+$fp[$i]['quantity'];
      }
    else
      {
      $tsqnt = $fp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $fp[$i]['pid'],
      'batch'      => $fp[$i]['batch'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    $this->pm->insert_data('stock',$stock);  
    }
    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Manufacturer Approve Successfully !</h4>
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
  redirect('Manufacturer');
}

public function delete_Manufacturer($id)
  {
  $where = array(
    'mid' => $id
        );

  $result = $this->pm->delete_data('manufacturer',$where);
    
  $mp = $this->pm->get_data('manufact_product',$where);
  $this->pm->delete_data('manufact_product',$where);
  $this->pm->delete_data('manufact_product_backup',$where);
  $fp = $this->pm->get_data('manufact_cproduct',$where);
  $this->pm->delete_data('manufact_cproduct',$where);
  
  $lnth = count($mp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'product' => $mp[$i]['pid']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    //$this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']+$mp[$i]['quantity'];
      }
    else
      {
      $tsqnt = $mp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $mp[$i]['pid'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);  
    }
    
  $ln2th = count($fp);

  for($i = 0; $i < $ln2th; $i++)
    {
    $sswhere = array(
      'product' => $fp[$i]['pid'],
      'batch'   => $fp[$i]['batch']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    //$this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']-$fp[$i]['quantity'];
      }
    else
      {
      $tsqnt = '-'.$fp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $fp[$i]['pid'],
      'batch'      => $fp[$i]['batch'],
      'expDate'    => $fp[$i]['expDate'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);  
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Manufacturer delete Successfully !</h4>
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
  redirect('Manufacturer');
}

public function recipe_list()
  {
  $data['title'] = 'Recipe';

  $other = array(
    'order_by' => 'rid',
    'join' => 'left'
          );
  $field = array(
    'recipe' => 'recipe.*',
    'products' => 'products.productName,products.productcode'
        );
  $join = array(
    'products' => 'products.productID = recipe.pid'
        );
  $data['recipe'] = $this->pm->get_data('recipe',false,$field,$join,$other);

  $this->load->view('manufacturer/recipe_list',$data);
}

public function new_recipe() 
  {
  $data['title'] = 'Recipe';

  $data['product'] = $this->pm->get_data('products',false);

  $this->load->view('manufacturer/new_recipe',$data);
}

public function save_recipe()
  {
  $info = $this->input->post();

  $purchase = array(
    'pid'    => $info['product'],
    'rNotes' => $info['rNotes'],
    'regby'  => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
  $result = $this->pm->insert_data('recipe',$purchase);

  $length = count($info['mproduct']);
        
  for($i = 0; $i < $length; $i++)
    {
    $mproduct = array(
      'rid'      => $result,
      'pid'      => $info['mproduct'][$i],
      'quantity' => $info['mquantity'][$i],
      'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('recipe_product',$mproduct); 
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Recipe Successfully !</h4>
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
  redirect('recipeList');
}

public function view_recipe($id)
  {
  $data['title'] = 'Recipe';
  
  $other = array(
    'join' => 'left'
        );
  $where = array(
    'rid' => $id
        );
  $pfield = array(
    'recipe_product' => 'recipe_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.productID = recipe_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['mproduct'] = $this->pm->get_data('recipe_product',$where,$pfield,$pjoin,$other);
  $field = array(
    'recipe' => 'recipe.*',
    'products' => 'products.productName'
        );
  $join = array(
    'products' => 'products.productID = recipe.pid'
        );
  
  $purchase = $this->pm->get_data('recipe',$where,$field,$join,$other);
  $data['recipe'] = $purchase[0];
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('manufacturer/view_recipe',$data);
}

public function edit_recipe($id)
  {
  $data['title'] = 'Recipe';
  
  $other = array(
    'join' => 'left'
        );
  $where = array(
    'rid' => $id
        );
  $pfield = array(
    'recipe_product' => 'recipe_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.productID = recipe_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['mproduct'] = $this->pm->get_data('recipe_product',$where,$pfield,$pjoin,$other);
  
  $purchase = $this->pm->get_data('recipe',$where);
  $data['recipe'] = $purchase[0];
  $data['product'] = $this->pm->get_data('products',false);
  
  $this->load->view('manufacturer/edit_recipe',$data);
}

public function update_recipe()
  {
  $info = $this->input->post();
  $where = array(
    'rid' => $info['rid']
        );
  $purchase = array(
    'pid'    => $info['product'],
    'rNotes' => $info['rNotes'],
    'upby'   => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
  $result = $this->pm->update_data('recipe',$purchase,$where);
  $this->pm->delete_data('recipe_product',$where);
  
  $length = count($info['mproduct']);
        
  for($i = 0; $i < $length; $i++)
    {
    $mproduct = array(
      'rid'       => $info['rid'],
      'pid'       => $info['mproduct'][$i],
      'quantity'  => $info['mquantity'][$i],
      'pquantity' => $info['pquantity'][$i],
      'regby'     => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('recipe_product',$mproduct); 
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Recipe Update Successfully !</h4>
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
  redirect('recipeList');
}

public function delete_recipe($id)
  {
  $where = array(
    'rid' => $id
        );
       // var_dump($purchase); exit();
  $result = $this->pm->delete_data('recipe',$where);
  $this->pm->delete_data('recipe_product',$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Recipe Delete Successfully !</h4>
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
  redirect('recipeList');
}

public function new_recipe_manufacturer() 
  {
  $data['title'] = 'Manufacturer';

  $other = array(
    'join' => 'left'
          );
  $field = array(
    'recipe' => 'recipe.*',
    'products' => 'products.productName,products.productcode'
        );
  $join = array(
    'products' => 'products.productID = recipe.pid'
        );
  $data['product'] = $this->pm->get_data('recipe',false,$field,$join,$other);
  
  $this->load->view('manufacturer/new_recipe_manufacturer',$data);
}

public function get_Recipe_Product()
  {
  $id = $this->input->post('id');
  
  $str = "";
  
  $rwhere = array(
    'pid' => $id
        );

  $recipe = $this->pm->get_data('recipe',$rwhere);
  
  $other = array(
    'join' => 'left'
          );
  $where = array(
    'rid' => $recipe[0]['rid']
        );
  $field = array(
    'recipe_product' => 'recipe_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $join = array(
    'products' => 'products.productID = recipe_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $productlist = $this->pm->get_data('recipe_product',$where,$field,$join,$other);
    // $stock = $this->pm->get_stock_data($id);
  foreach($productlist as $value)
    {
    $id = $value['pid'];
    $stock = $this->db->select('totalPices')
              ->from('stock')
              ->where('product',$id)
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
    $str .= "<tr>
    <td>".$value['productName']."<input type='hidden' name='fproduct[]' value='".$value['pid']."' required ></td>
    <td>".$sqnt."<input type='hidden' name='stock[]' value='".$sqnt."' required ></td>
    <td><input type='text' class='form-control' name='fquantity[]' value='".$value['quantity']."' required readonly ></td>
    <td>".$value['unitName']."</td>
    </tr>";
    }
  echo json_encode($str);
}

public function get_Manufacturer_Details()
  {
  $tmq = $this->input->post('tmq');
  $id = $this->input->post('id');
 
  $str = "";
  
  $rwhere = array(
    'pid' => $id
        );
  $recipe = $this->pm->get_data('recipe',$rwhere);
  
  $other = array(
    'join' => 'left'
          );
  $where = array(
    'rid' => $recipe[0]['rid']
        );
  $field = array(
    'recipe_product' => 'recipe_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $join = array(
    'products' => 'products.productID = recipe_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $productlist = $this->pm->get_data('recipe_product',$where,$field,$join,$other);
    // $stock = $this->pm->get_stock_data($id);
  foreach($productlist as $value)
    {
    $id = $value['pid'];
    $tqnt = $value['quantity']*$tmq;
    
    $stock = $this->db->select('totalPices')
              ->from('stock')
              ->where('product',$id)
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
      
    $str .= "<tr>
    <td>".$value['productName']."<input type='hidden' name='fproduct[]' value='".$value['pid']."' required ></td>
    <td>".$sqnt."<input type='hidden' name='stock[]' value='".$sqnt."' required ></td>
    <td><input type='text' class='form-control' name='fquantity[]' value='".$tqnt."' required readonly ></td>
    <td>".$value['unitName']."</td>
    </tr>";
    }
  echo json_encode($str);
}

public function save_recipe_manufacturer()
  {
  $info = $this->input->post();
  
  $lnth = count($info['fproduct']);
        
  for($j = 0; $j < $lnth; $j++)
    {
    if($info['fquantity'][$j] > $info['stock'][$j])
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Manufacturer Quantity is greater than Stock !</h4>
        </div>'
            ];
      $this->session->set_userdata($sdata);
      redirect('newMRecipe');
      }
    }

  $purchase = array(
    'compid' => $_SESSION['compid'],
    'mType'  => 2,
    'mDate'  => date('Y-m-d', strtotime($info['date'])),
    'notes'  => $info['note'],
    'regby'  => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
  $result = $this->pm->insert_data('manufacturer',$purchase);

  $mproduct = array(
    'mid'      => $result,
    'pid'      => $info['mproduct'],
    'batch'    => $info['batch'],
    'mDay'     => $info['mDay'],
    'quantity' => $info['mquantity'],
    'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
  $fresult = $this->pm->insert_data('manufact_cproduct',$mproduct); 

  $swhere = array(
    'product' => $info['mproduct'],
    'batch'    => $info['batch'],
              );

  $stpd = $this->pm->get_data('stock',$swhere);
  //$this->pm->delete_data('stock',$swhere);

  if($stpd)
    {
    $tquantity = $stpd[0]['totalPices']+$info['mquantity'];
    }
  else
    {
    $tquantity = $info['mquantity'];
    }

  $stock_info = array(
    'compid'     => $_SESSION['compid'],
    'product'    => $info['mproduct'],
    'batch'      => $info['batch'],
    'expDate'    => date('Y-m-d',strtotime($info['date']. ' + '.$info['mDay'].' days')),
    'totalPices' => $tquantity,
    'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
  //$this->pm->insert_data('stock',$stock_info);                 
    
  $lngth = count($info['fproduct']);
        
  for($i = 0; $i < $lngth; $i++)
    {
    $fproduct = array(
      'mid'      => $result,
      'pid'      => $info['fproduct'][$i],
      'quantity' => $info['fquantity'][$i],
      'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $rresult = $this->pm->insert_data('manufact_product',$fproduct); 

    $swhere = array(
      'product' => $info['fproduct'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $stpd[0]['totalPices']-$info['fquantity'][$i];
      }
    else
      {
      $tqnt = '-'.$info['fquantity'][$i];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['fproduct'][$i],
      'totalPices' => $tqnt,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);                 
    }

  if($result || $fresult || $rresult)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Manufacturer Successfully !</h4>
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
  redirect('Manufacturer');
}

public function edit_recipe_manufacturer($id)
  {
  $data['title'] = 'Manufacturer';

  $other = array(
    'join' => 'left'
        );
  $where = array(
    'mid' => $id
        );
  $pfield = array(
    'manufact_product' => 'manufact_product.*',
    'products' => 'products.productName,products.productcode',
    'sma_units' => 'sma_units.unitName'
        );
  $pjoin = array(
    'products' => 'products.productID = manufact_product.pid',
    'sma_units' => 'sma_units.id = products.unit'
        );
  
  $data['mproduct'] = $this->pm->get_data('manufact_product',$where,$pfield,$pjoin,$other);
  
  $pproduct = $this->pm->get_data('manufact_cproduct',$where);
  $data['pproduct'] = $pproduct[0];
    // var_dump($data['pproduct']);exit();

  $purchase = $this->pm->get_data('manufacturer',$where);
  $data['manufacturer'] = $purchase[0];

  $ffield = array(
    'recipe' => 'recipe.*',
    'products' => 'products.productName,products.productcode'
        );
  $fjoin = array(
    'products' => 'products.productID = recipe.pid'
        );
  $data['product'] = $this->pm->get_data('recipe',false,$ffield,$fjoin,$other);
    
  $this->load->view('manufacturer/edit_rmanufacturer',$data);
}

public function update_recipe_manufacturer()
  {
  $info = $this->input->post();
  
  $purchase = array(
    'compid' => $_SESSION['compid'],
    'mDate'  => date('Y-m-d', strtotime($info['date'])),
    'notes'  => $info['note'],
    'regby'  => $_SESSION['uid']
            );
       // var_dump($purchase); exit();
  $where = array(
    'mid' => $info['mid']
        );
  $result = $this->pm->update_data('manufacturer',$purchase,$where);
  $mp = $this->pm->get_data('manufact_product',$where);
  $this->pm->delete_data('manufact_product',$where);
  $fp = $this->pm->get_data('manufact_cproduct',$where);
  $this->pm->delete_data('manufact_cproduct',$where);

  $lnth = count($mp);

  for($i = 0; $i < $lnth; $i++)
    {
    $sswhere = array(
      'product' => $mp[$i]['pid']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    //$this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']+$mp[$i]['quantity'];
      }
    else
      {
      $tsqnt = $mp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $mp[$i]['pid'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);  
    }
    
  $ln2th = count($fp);

  for($i = 0; $i < $ln2th; $i++)
    {
    $sswhere = array(
      'product' => $fp[$i]['pid'],
      'batch'   => $fp[$i]['batch']
            );

    $s2tpd = $this->pm->get_data('stock',$sswhere);

    //$this->pm->delete_data('stock',$sswhere);

    if($s2tpd)
      {
      $tsqnt = $s2tpd[0]['totalPices']-$fp[$i]['quantity'];
      }
    else
      {
      $tsqnt = '-'.$fp[$i]['quantity'];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $fp[$i]['pid'],
      'batch'      => $fp[$i]['batch'],
      'expDate'    => $fp[$i]['expDate'],
      'totalPices' => $tsqnt,
      'regby'      => $_SESSION['uid']
                );
        //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);  
    }
    
    $mproduct = array(
      'mid'      => $info['mid'],
      'pid'      => $info['mproduct'],
      'batch'    => $info['batch'],
      'mDay'     => $info['mDay'],
      'quantity' => $info['mquantity'],
      'regby'    => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result3 = $this->pm->insert_data('manufact_cproduct',$mproduct); 

    $swhere = array(
      'product' => $info['mproduct'],
      'batch'    => $info['batch'],
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tquantity = $stpd[0]['totalPices']-$info['mquantity'][$i];
      }
    else
      {
      $tquantity = '-'.$info['mquantity'][$i];
      }

    $stock_info = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['mproduct'],
      'batch'      => $info['batch'],
      'expDate'    => date('Y-m-d',strtotime($info['date']. ' + '.$info['mDay'].' days')),
      'totalPices' => $tquantity,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock_info);
    
  $lngth = count($info['fproduct']);
        
  for($i = 0; $i < $lngth; $i++)
    {
    $fproduct = array(
      'mid'       => $info['mid'],
      'pid'       => $info['fproduct'][$i],
      'quantity'  => $info['fquantity'][$i],
      'pquantity' => $info['pquantity'][$i],
      'regby'     => $_SESSION['uid']
            );
        //var_dump($purchase_product);            
    $result2 = $this->pm->insert_data('manufact_product',$fproduct); 

    $swhere = array(
      'product' => $info['fproduct'][$i]
              );

    $stpd = $this->pm->get_data('stock',$swhere);
    //$this->pm->delete_data('stock',$swhere);

    if($stpd)
      {
      $tqnt = $stpd[0]['totalPices']+$info['fquantity'][$i];
      }
    else
      {
      $tqnt = $info['fquantity'][$i];
      }

    $stock = array(
      'compid'     => $_SESSION['compid'],
      'product'    => $info['fproduct'][$i],
      'totalPices' => $tqnt,
      'regby'      => $_SESSION['uid']
              );
      //var_dump($stock_info);    
    //$this->pm->insert_data('stock',$stock);                 
    }
    
  if($result || $result2 || $result3)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Manufacturer update Successfully !</h4>
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
  redirect('Manufacturer');
}

public function manu_department()
    {
    $data['title'] = 'Manufacture Department';

    $where = array(
        'compid' => $_SESSION['compid']
            );

    $data['dept'] = $this->pm->get_data('mdepartment',false);

    $this->load->view('manufacturer/manu_dept',$data);
}

public function save_manu_department()
    {       
    $info = $this->input->post();
           
    $data = array(
        'compid'    => $_SESSION['compid'],
        'mdName' => $info['mdName'],
        'regby'     => $_SESSION['uid']
            );
    
    $result = $this->pm->insert_data('mdepartment',$data);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Manufacture department added Successfully !</h4>
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
    redirect('mDept');
}

public function get_manu_dept_data()
    {
    $section = $this->pm->get_manu_dept_data($_POST['id']);
    $someJSON = json_encode($section);
    echo $someJSON;
}

public function update_manu_dept()
    {       
    $info = $this->input->post();
           
    $data = array(
        'compid'    => $_SESSION['compid'],
        'mdName' => $info['mdName'],
        'status'    => $info['status'],
        'upby'      => $_SESSION['uid']
            );

    $where = array(
        'md_id' => $info['md_id']
            );

    $result = $this->pm->update_data('mdepartment',$data,$where);

    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Manufacture Department updated Successfully !</h4>
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
    redirect('mDept');
}

public function delete_manu_dept($md_id)
    {
    $where = array(
        'dept' => $md_id
            );
    $mwhere = array(
        'md_id' => $md_id
            );

    $empd = $this->pm->get_data('products',$where);

    if ($empd[0] == null)
        {
        $result = $this->pm->delete_data('mdepartment',$mwhere);

        if($result)
            {
            $sdata = [
              'exception' =>'<div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i>Manufacture department deleted Successfully !</h4>
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
            <h4><i class="icon fa fa-ban"></i> Already added this department in products !</h4>
            </div>'
                ];
        }
    $this->session->set_userdata($sdata);
    redirect('mDept');
}

public function manufacturer_lavel($id)
  {
  $data['title'] = 'Product';
  
  $where = array(
    'mcpid' => $id
        );
  $other = array(
    'join' => 'left'         
          );
  $field = array(
    'manufact_cproduct' => 'manufact_cproduct.*',
    'products' => 'products.productName,products.productcode,products.sprice',
    'manufacturer' => 'manufacturer.mDate'
          );
  $join = array(
    'products' => 'products.productID = manufact_cproduct.pid',
    'manufacturer' => 'manufacturer.mid = manufact_cproduct.mid'
          );

  $manufacturer = $this->pm->get_data('manufact_cproduct',$where,$field,$join,$other);
  $data['manufacturer'] = $manufacturer[0];
    //var_dump($data['products']); exit();
  $this->load->view('manufacturer/product_barcode',$data);
}





}