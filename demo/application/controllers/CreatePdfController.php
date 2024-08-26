<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CreatePdfController extends CI_Controller
{
	public function fetch_sales_details($id) {


    $where = array(
        'saleID' => $id
            );
    $other = array(
        'join' => 'left'
            );
    $field = array(
        'sales' => 'sales.*',
        'customers' => 'customers.*',
        'users' => 'users.name'
            );
    $join = array(
        'users' => 'users.uid = sales.regby',
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

    $data['csdue'] = $this->pm->customer_sales_due_details($id,$cusid);
    $data['cvpa'] = $this->pm->customer_vaucher_paid_details($cusid);
    $data['cpa'] = $this->pm->customer_vaucher_pay_details($cusid);
    $data['cra'] = $this->pm->customer_returns_details($cusid);
    $data['cda'] = $this->pm->customer_damages_details($cusid);
    $data['company'] = $this->pm->company_details();

    return $data;
}

}