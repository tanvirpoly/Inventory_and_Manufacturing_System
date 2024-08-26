<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Package extends CI_Controller {

public function __construct()
    {
    parent::__construct();

    $this->load->model("prime_model","pm");
    $this->checkPermission();
}

public function index()
    {
    $data['title'] = 'Package';

    $data['package'] = $this->pm->get_data('package',false);
//var_dump($data['purchase']); exit();
    $data['content'] = $this->load->view('package/package_list',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function new_package() 
    {
    $data['title'] = 'Package';

    $data['product'] = $this->pm->get_data('products',false);

    $data['content'] = $this->load->view('package/newpackage',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function getProductOnSupplier($id)
    {
    $where = array(
        'productID' => $id
            );

    $productlist = $this->pm->get_data('products',$where);

    $str = "";
    foreach ($productlist as $value) {
        $id = $value['productID'];
        $str .= "<tr>
        <td>".$value['productName']."<input type='hidden' readonly='readonly' name='product_id[]' value='".$value['productID']."'></td>
        <td><input type='text' id='quantity_".$value['productID']."' onkeyup='getTotal(".$id.")' name='quantity[]' value='00'></td>
        <td>".$value['sprice']."<input type='hidden' onkeyup='getTotal(".$id.")' id='tp_".$value['productID']."' name='tp[]' value='".$value['sprice']."'></td>
        <td><input readonly='readonly' type='text' id='totalPrice_".$value['productID']."' name='total_price[]' value='0.00' readonly></td>
        <td><input type='button' class='btn btn-danger' value='remove' onClick='$(this).parent().parent().remove();''></td>";
    }
    echo json_encode($str);
}

public function save_package()
    {
    $info = $this->input->post();

    $package = array(
        'packdate'     => date('Y-m-d',strtotime($info['date'])),
        'package_name' => $info['packname'],
        'tprice'       => $info['totalPrice'],
        'sprice'       => $info['salePrice'],
        'tquantity'    => array_sum($info['quantity']),
        'note'         => $info['note'],
        'regby'        => $this->session->userdata('admin_id')
            );
//var_dump($quotation); exit();
    $result = $this->pm->insert_data('package',$package);
//var_dump($purchase_id); exit();

    if ($result)
        {
        $length = count($this->input->post('product_id'));
        
        for ($i = 0; $i < $length; $i++)
            {
            if($this->input->post('quantity')[$i] > 0):
            
            $package_products = array(
                'packid'     => $result,
                'productid'  => $this->input->post('product_id')[$i],
                'price'      => $this->input->post('tp')[$i],
                'quantity'   => $this->input->post('quantity')[$i],                 
                'totalPrice' => $this->input->post('total_price')[$i],
                'regby'      => $this->session->userdata('admin_id')
                    );
    //var_dump($purchase_product);            
            $qut_product_id = $this->pm->insert_data('package_products',$package_products);             
            endif;
            }
        }
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Package add Successfully !</h4>
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
    redirect('Package');
}

public function view_Package($id)
    {
    $data['title'] = 'Package';

    $where = array(
        'packid' => $id
            );
    $join = array(
        'products' => 'products.productID = package_products.productid'
            );
    $data['packagep'] = $this->pm->get_data('package_products',$where,false,$join);
    
    $quotation = $this->pm->get_data('package',$where);
    $data['package'] = $quotation[0];    
    
    $data['company'] = $this->pm->company_details();
    
    $data['content'] = $this->load->view('package/viewpackage',$data,TRUE);
    $this->load->view('themes/adminlte',$data);
}

public function edit_Package($id)
    {
    $data['title'] = 'Package';

    $data['product'] = $this->pm->get_data('products',false);

    $where = array(
        'packid' => $id
            );
    $join = array(
        'products' => 'products.productID = package_products.productid'
            );
    $data['packagep'] = $this->pm->get_data('package_products',$where,false,$join);
    
    $quotation = $this->pm->get_data('package',$where);
    $data['package'] = $quotation[0];  
    
    $data['content'] = $this->load->view('package/editpackage',$data,TRUE);
    $this->load->view('themes/adminlte', $data);
}

public function update_Quotation()
    {
    $info = $this->input->post();

    $where = array(
        'packid' => $info['packid']
            );

    $package = array(
        'packdate'     => date('Y-m-d',strtotime($info['date'])),
        'package_name' => $info['packname'],
        'tprice'       => $info['totalPrice'],
        'sprice'       => $info['salePrice'],
        'tquantity'    => array_sum($info['quantity']),
        'note'         => $info['note'],
        'upby'         => $this->session->userdata('admin_id')
            );

    $result = $this->pm->update_data('package',$package,$where);

    $this->pm->delete_data('package_products',$where);
    
    $length = count($this->input->post('product_id'));

    for ($i = 0; $i < $length; $i++) {

         $package_products = array(
            'packid'     => $info['packid'],
            'productid'  => $this->input->post('product_id')[$i],
            'price'      => $this->input->post('tp')[$i],
            'quantity'   => $this->input->post('quantity')[$i],                 
            'totalPrice' => $this->input->post('total_price')[$i],
            'regby'      => $this->session->userdata('admin_id')
                );
    //var_dump($quotation_product); exit();
        $qp = $this->pm->insert_data('package_products',$package_products);
        }
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Package update Successfully !</h4>
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
    redirect('Package');
}

public function delete_Package($id)
    {
    $where = array(
        'packid' => $id
            );

    $result = $this->pm->delete_data('package',$where);
    $this->pm->delete_data('package_products',$where);
    
    if($result)
        {
        $sdata = [
          'exception' =>'<div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-check"></i>Package delete Successfully !</h4>
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
    redirect('Package');
}






  



}