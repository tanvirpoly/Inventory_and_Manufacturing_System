<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Product extends CI_Controller{

public function __construct(){
  parent::__construct();       
  $this->load->model("prime_model",'pm');            
  $this->checkPermission();   
  $this->load->library('PHPExcel');
  $this->load->library('excel');
  $this->load->library('zend');
  $this->zend->load('Zend/Barcode'); 
}

public function index()
  {
  $data['title'] = 'Product'; 
  if(isset($_GET['search']))
    {
    $pType = $_GET['pType'];
    $data['product'] = $this->pm->get_all_product_data($pType);
    }
  else
    {
    $data['product'] = $this->pm->get_product_data();
    }
  $this->load->view('products/product',$data);
}

public function new_product()
  {
  $data['title'] = 'Product';

  $data['customer'] = $this->pm->get_data('customers',false);
  $data['product'] = $this->pm->get_data('products',false);
  $data['category'] = $this->pm->get_data('categories',false);
  $data['unit'] = $this->pm->get_sma_units_data();

  $this->load->view('products/new_product',$data);
}

public function save_product()
  {
  $info = $this->input->post();
    //var_dump('hello'); exit();
  $config['upload_path'] = './upload/product/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload', $config);
  $this->upload->initialize($config);
  if($this->upload->do_upload('userfile'))
    {
    $img = $this->upload->data('file_name');
    }
  else
    {
    $img = '';
    }

  if($info['categoryID'] == 'newCategory')
    {
    $cdata = [
      'compid'       => $_SESSION['compid'],
      'categoryName' => $info['newCategory'],
      'regby'        => $_SESSION['uid']
            ];
       
    $catdata = $this->pm->insert_data('categories',$cdata);

    $catid = $catdata;
    }
  else
    {
    $catid = $info['categoryID'];
    }

  if($info['units'] == 'newUnit')
    {
    $udata = [
      'compid'   => $_SESSION['compid'],
      'unitName' => $info['newUnit'],
      'regby'    => $_SESSION['uid']
            ];
   
    $utdata = $this->pm->insert_data('sma_units',$udata);

    $utid = $utdata;
    }
  else
    {
    $utid = $info['units'];
    }

  $query = $this->db->select('productID')
                ->from('products')
                ->where('compid',$_SESSION['compid'])
                ->limit(1)
                ->order_by('productID','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->productID+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d",$sn);

  $cusid = 'P-'.$cn.$pc;
    //var_dump($cusid); exit();
  $info = [
    'compid'      => $_SESSION['compid'],
    'productcode' => $cusid,
    'productName' => $info['productName'],
    'pType'       => $info['pType'],
    'categoryID'  => $catid,
    'unit'        => $utid,
    'pprice'      => $info['pprice'],
    'sprice'      => $info['sprice'],
    // 'details'     => $info['details'],
    // 'specifict'   => $info['specification'],
    'image'       => $img,
    // 'spstatus'    => $info['spstatus'],
    'regby'       => $_SESSION['uid']
        ];
    //var_dump($productID); exit();
  $result = $this->pm->insert_data('products',$info);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product add Successfully !</h4>
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
  redirect('Product');
}

public function view_product($id)
  {
  $data['title'] = 'Product'; 

  $where = array(
    'productID' => $id  
          );
  $other = array(
    'join' => 'left' 
          );
  $field = array(
    'products'  => 'products.*',
    'categories' => 'categories.categoryName',
    'sma_units'  => 'sma_units.unitName'
          );
  $join = array(
    'categories' => 'categories.categoryID = products.categoryID',
    'sma_units'  => 'sma_units.id = products.unit'
          );

  $product = $this->pm->get_data('products',$where,$field,$join,$other);
  $data['product'] = $product[0];

  $this->load->view('products/productView',$data);
}

public function edit_products($id)
  {
  $data['title'] = 'Product';

  $where = array(
    'status' => 'Active',
    'compid' => $_SESSION['compid']
          );
  $data['category'] = $this->pm->get_data('categories',$where);
  $data['unit'] = $this->pm->get_sma_units_data();

  $pwhere = array(
    'productID' => $id
        );

  $product = $this->pm->get_data('products',$pwhere);
  $data['product'] = $product[0];
    //var_dump($data['unit']);
  $this->load->view('products/edit_product',$data);
}

public function update_product()
  {
  $info = $this->input->post();
  $pid = $info['productid'];
    //var_dump($pid); exit();
  $config['upload_path'] = './upload/product/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload',$config);
  $this->upload->initialize($config);
  if($this->upload->do_upload('userfile'))
    {
    $img = $this->upload->data('file_name');
    }
  else
    {
    $pimg = $this->db->select('image')->from('products')->where('productID',$pid)->get()->row();
    if($pimg)
      {
      $img = $pimg->image;
      }
    else
      {
      $img = '';
      }
    }  

  $info = [
    'productName'=> $info['productName'],
    'pType'      => $info['pType'],
    'categoryID' => $info['categoryID'],
    'unit'       => $info['units'],
    'pprice'     => $info['pprice'],
    'sprice'     => $info['sprice'],
    // 'details'    => $info['details'],
    // 'specifict'  => $info['specification'],
    'image'      => $img,
    // 'spstatus'   => $info['spstatus'],
    'upby'       => $_SESSION['uid']
        ];
    //var_dump($info); exit();
  $where = array(
    'productID' => $pid
          );
    //var_dump($where); exit();
  $result = $this->pm->update_data('products',$info,$where);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i>Product update Successfully !</h4>
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
  redirect('Product');
}

public function delete_products($pid)
  {
  $pswhere = array(
    'product' => $pid,
    'totalPices >' => 0
        );
  $stock = $this->pm->get_data('stock',$pswhere);
  if($stock)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> You can not delete this Product. This product has Stock!</h4></div>'
              ];
    }
  else
    {
    $where = array(
      'productID' => $pid
          );
    //var_dump($where); exit();
    $result = $this->pm->delete_data('products',$where);
    $swhere = array(
      'product' => $pid
          );
    $this->pm->delete_data('stock',$swhere);
    
    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product delete Successfully !</h4></div>'
              ];  
      }
    else
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
              ];
      }
    }
  $this->session->set_userdata($sdata);
  redirect('Product');
}

public function product_reports()
  {
  $data['title'] = 'Stock Report'; 

  $other = array(
    'join' => 'left'         
          );
  $where = array(
    'stock.compid' => $_SESSION['compid']    
          );
  $field = array(
    'stock' => 'stock.*',
    'products' => 'products.productName,products.productcode,products.pprice'
          );
  $join = array(
    'products' => 'products.productID = stock.product'
          );

    //$data['stock'] = $this->pm->get_data('stock',$where,$field,$join,$other);
  $data['stock'] = $this->pm->get_stock_product();
  $data['company'] = $this->pm->company_details();
    //var_dump($data['products']); exit();
  $this->load->view('products/product_report',$data);
}

public function raw_product_reports()
  {
  $data['title'] = 'Raw Stock Report'; 
  $pType = 'Raw Material';
    
  $other = array(
    'join' => 'left'         
          );
  $where = array(
    'stock.compid' => $_SESSION['compid'] ,
    'products.pType' => 1
          );
  $field = array(
    'stock' => 'stock.*',
    'products' => 'products.productName,products.productcode,products.pprice, products.pType'
          );
  $join = array(
    'products' => 'products.productID = stock.product'
          );
    //$data['stock'] = $this->pm->get_data('stock',$where,$field,$join,$other);
  $data['stock'] = $this->pm->get_raw_stock_product();
  $data['company'] = $this->pm->company_details();
    //var_dump($data['products']); exit();
  $this->load->view('products/product_raw_report',$data);
}

public function finish_product_reports()
  {
  $data['title'] = 'Finish Stock Report'; 
  $pType = 'Finish Good';
    
  $other = array(
    'join' => 'left'         
          );
  $where = array(
    'products.pType' => 2
          );
  $field = array(
    'stock' => 'stock.*',
    'products' => 'products.productName,products.productcode,products.pprice, products.pType'
          );
  $join = array(
    'products' => 'products.productID = stock.product'
          );

    //$data['stock'] = $this->pm->get_data('stock',$where,$field,$join,$other);
  $data['stock'] = $this->pm->get_finish_stock_product();
  $data['company'] = $this->pm->company_details();
    //var_dump($data['products']); exit();
  $this->load->view('products/product_finish_report',$data);
}

public function save_product_store()
  {
  $info = $this->input->post();

  $swhere = array(
    'product' => $info['product'],
    'compid' => $_SESSION['compid']
            );

  $stpd = $this->pm->get_data('stock',$swhere);
  $this->pm->delete_data('stock',$swhere);

  if($stpd)
    {
    $tquantity = $stpd[0]['totalPices']+$info['quantity'];
    }
  else
    {
    $tquantity = $info['quantity'];
    }

  $info = [
    'compid'     => $_SESSION['compid'],
    'product'    => $info['product'],
    'totalPices' => $tquantity,
    'regby'      => $_SESSION['uid']
        ];
    //var_dump($productID); exit();
  $result = $this->pm->insert_data('stock',$info);
  
  $sinfo = [
    'compid'     => $_SESSION['compid'],
    'product'    => $info['product'],
    'totalPices' => $info['quantity'],
    'regby'      => $_SESSION['uid']
          ];
    //var_dump($productID); exit();
  $this->pm->insert_data('stock_store',$sinfo);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Product Store Successfully !</h4>
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
  redirect('Product');
}

public function export_action()
  {
  $this->load->library("excel");
  $object = new PHPExcel();

  $object->setActiveSheetIndex(0);

  $table_columns = array("Product Name", "Product Code", "Category id", "Units", "Purchase Price", "Sale Price");

  $column = 0;

  foreach($table_columns as $field)
    {
    $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
    $column++;
    }

  $product_data = $this->pm->product_fetch_data();
    //print_r($product_data); exit();
  $excel_row = 2;

  foreach($product_data as $row)
    {
    $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->productName);
    $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->productcode);
    $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->categoryID);
    $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->unit);
    $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->pprice);
    $object->getActiveSheet()->setCellValueByColumnAndRow(5,$excel_row,$row->sprice);
    $excel_row++;
    }

    //$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
  $object->getActiveSheet()->setTitle('products');

    //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
  $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

  header("Last-Modified: ".gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Products.xls"');
  if(ob_get_length()){ ob_end_clean(); }
    //ob_end_clean();
    //ob_end_flush();
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
        $productName = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
        $ptype = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $category = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $units = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $pprice = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $sprice = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

        $query = $this->db->select('productID')
                      ->from('products')
                      ->where('compid',$_SESSION['compid'])
                      ->limit(1)
                      ->order_by('productID','DESC')
                      ->get()
                      ->row();
        if($query)
          {
          $sn = $query->productID+1;
          }
        else
          {
          $sn = 1;
          }

        $cn = strtoupper(substr($_SESSION['compname'],0,3));
        $pc = sprintf("%'05d",$sn);

        $cusid = 'P-'.$cn.$pc;

        $data = array(
          'compid'      => $_SESSION['compid'],
          'productName' => $productName,
          'productcode' => $cusid,
          'pType'       => $ptype,
          'categoryID'  => $category,
          'unit'        => $units,
          'pprice'      => $pprice,
          'sprice'      => $sprice,
          'regby'       => $_SESSION['uid']
              );
        $this->pm->insert_data('products',$data);
        }
      }
    //$result = $this->pm->insert_product_data($data);
    
    $sdata = [
        'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product import Successfully !</h4></div>'
              ];  
    }   
  $this->session->set_userdata($sdata);
  redirect('Product');
}

public function add_product()
  {
  $query = $this->db->select('productID')
                ->from('products')
                ->where('compid',$_SESSION['compid'])
                ->limit(1)
                ->order_by('productID','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->productID+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d", $sn);

  $cusid = 'P-'.$cn.$pc;

  $data = array(
    'compid'      => $_SESSION['compid'],
    'productName' => $_POST['productName'],
    'productcode' => $cusid,
    'categoryID'  => $_POST['categoryID'],
    'unit'        => $_POST['unit'],
    'pprice'      => $_POST['pprice'],
    'sprice'      => $_POST['sprice'],            
    'regby'       => $_SESSION['uid']
            );

  $result = $this->pm->insert_data('products',$data);

  if($result)
    {
    $swhere = array(
      'compid' => $_SESSION['compid']
            );
    $products = $this->pm->get_data('products',$swhere);

    $append = '<div id="customer_hide"><label>Product *</label><select class="form-control chosen" name="products" onchange="myFunction()" id="products" required><option value="">Select One</option>';
    foreach($products as $value)
      {
      $append .= '<option value=" '.$value['productID'] .' ">'.$value['productName'].'('.$value['productcode'].')</option>';
      }
    $append .= '</select></div>';
    echo $append;
    }
  else
    {
    echo "Product Added Failed!";
    }
}

public function low_product_stock_reports()
  {
  $data['title'] = 'Stock Report'; 

  $other = array(
    'join' => 'left'         
          );
  $where = array(
    'stock.compid' => $_SESSION['compid'],
    'stock.totalPices <' => 1
          );
  $field = array(
    'stock' => 'stock.*',
    'products' => 'products.productName,products.productcode,products.pprice'
          );
  $join = array(
    'products' => 'products.productID = stock.product'
          );

  $data['stock'] = $this->pm->get_data('stock',$where,$field,$join,$other);
  $data['company'] = $this->pm->company_details();
    //var_dump($data['products']); exit();
  $this->load->view('products/low_product_stock',$data);
}

public function create_product_barcode($id)
  {
  $data['title'] = 'Product';

  if(isset($_GET['search']))
    {
    $nopack = $_GET['nopack'];
    $data['nopack'] = $nopack;
    $data['product'] = $id;

    $where = array(
      'productID' => $id
          );

    $data['product'] = $this->pm->get_data('products',$where);
    }
  else
    {
    $where = array(
      'productID' => $id
          );

    $data['product'] = $this->pm->get_data('products',$where);
    }
    //var_dump($data['products']); exit();
  $this->load->view('products/product_barcode',$data);
}




}