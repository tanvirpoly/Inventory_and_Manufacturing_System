<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotation_model extends CI_Model
{
	public $data = [];
	/*
	## get quotation data
	*/
	public function get_quotation($company_id)
	{
		$query = $this->db->select('quotation.*, customers.customerName')
						  ->from('quotation')
						  ->join('customers', 'customers.customerID = quotation.customerID', 'left')
						  ->where('quotation.compid', $company_id)
						  ->order_by('quotation.qutid', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single sale_ data
	*/
	public function get_single_quotation($quotation_id)
	{
		$query = $this->db->select('*')
						  ->from('quotation')
						  ->where('qutid', $quotation_id)
						  ->get()
						  ->row();
		if($query) {	  
		$this->data['quotation_no'] = $query->qutid;
		$this->data['quotation_date'] = $query->quotationDate;
		$this->data['company'] = $this->get_company($query->compid);
		$this->data['customer'] = $this->get_customer($query->customerID);
		$this->data['products'] = $this->get_products($query->qutid);
		$this->data['total_quantity'] = $query->totalQuantity;
		$this->data['total_amount'] = $query->totalPrice;
		return $this->data;
		} else {
			return false;
		}
	}

	/*
	## get company data
	*/
	public function get_company($compid)
	{
		$company = $this->db->select('com_name as company_name,com_email as email,com_mobile as mobile, com_logo as logo')
							 ->from('com_profile')
							 ->where('compid', $compid)
							 ->get()
							 ->row();
		return $company;
	}

	/*
	## get customer data
	*/
	public function get_customer($customer_id)
	{
// 		$customer = $this->db->select('customerID as customer_id, customerName as customer_name, compname as company_name, email, mobile, address')
        $customer = $this->db->select('customerID as customer_id, customerName as customer_name, email, mobile, address')
							 ->from('customers')
							 ->where('customerID', $customer_id)
							 ->get()
							 ->row();
		return $customer;
	}

	/*
	## get products data
	*/
public function get_products($quotation_id)
	{
	$products = $this->db->select('products.productID as product_id,
	                               products.productName as product_name,
								   quotation_product.salePrice as unit_price,
								   quotation_product.quantity,
								   quotation_product.totalPrice as sub_total')
						 ->from('quotation_product')
						 ->join('products', 'products.productID = quotation_product.productID', 'left')
						 ->where_in('qutid', $quotation_id)
						 ->get()
						 ->result();
		return $products;
	}

	

	/*
	## sale post request
	*/
public function post_quotation($quotation)
	{
    $quotations = array(
        'compid'        => $quotation['quotation']['company_id'],
        'quotationDate' => $quotation['quotation']['quotation_date'],
        'customerID'    => $quotation['quotation']['customer_id'],
        'totalQuantity' => $quotation['quotation']['total_quantity'],
        'totalPrice'    => $quotation['quotation']['total_amount'],
        'note'          => $quotation['quotation']['note'],
        'regby'         => $quotation['quotation']['created_by']
	            );

	    $this->db->insert('quotation', $quotations);
		$result = $this->db->insert_id();

	    foreach($quotation['products'] as $row)
	    {      
            $quotation_product = array(
                'qutid'      => $result,
                'productID'  => $row['product_id'],
                'salePrice'  => $row['unit_price'],
                'quantity'   => $row['quantity'],                 
                'totalPrice' => $row['sub_total'],
                'regby'      => $quotation['quotation']['created_by']
            );
       
            $this->db->insert('quotation_product',$quotation_product);  
	    }

	    if ($result) {
	    	return $this->get_single_quotation($result);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	** Get sale edit purposs
	*/
	public function get_sale_edit_purposs($quotation_id)
	{
		$query = $this->db->select('qutid as quotation_id, compid as company_id, quotationDate as quotation_date, customerID as customer_id, totalPrice as total_amount, totalQuantity as total_quantity, note, regby as created_by, regdate as created_at, upby as updated_by, update as updated_at')
						  ->from('quotation')
						  ->where('qutid', $quotation_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	** Get sale edit
	*/
	public function get_quotation_edit($quotation_id)
	{
		$query = $this->get_sale_edit_purposs($quotation_id);
		$this->data['quotation'] = $query;
		$this->data['products'] = $this->get_products($query->quotation_id);
		$this->data['total_amount'] = $query->total_amount;

		return $this->data;
	}


	/*
	** Get sale_ detail data
	*/
	public function get_sale_detail_data($quotation_id)
	{
		$result = $this->db->select('*')
				           ->from('sale_product')
				           ->where('saleID', $quotation_id)
				           ->get()
				           ->result_array();
		return $result;
	}


	/*
	## Put request Quotation update
	*/
	public function put_quotation($quotation_id, $quotation)
	{
	   $quotations = array(
	        'compid'        => $quotation['quotation']['company_id'],
	        'quotationDate' => $quotation['quotation']['quotation_date'],
	        'customerID'    => $quotation['quotation']['customer_id'],
	        'totalQuantity' => $quotation['quotation']['total_quantity'],
	        'totalPrice'    => $quotation['quotation']['total_amount'],
	        'note'          => $quotation['quotation']['note'],
	        'regby'         => $quotation['quotation']['updated_by']
	    );

	    $this->db->update('quotation', $quotations, array('qutid' => $quotation_id));
		$result = $this->db->affected_rows();

	    $this->db->where(array('qutid' => $quotation_id))->delete('quotation_product');

	    foreach($quotation['products'] as $row) {

	         $quotation_product = array(
	            'qutid'      => $quotation_id,
	            'productID'  => $row['product_id'],
	            'salePrice'  => $row['unit_price'],
	            'quantity'   => $row['quantity'],                 
	            'totalPrice' => $row['sub_total'],
	            'regby'      => $quotation['quotation']['updated_by']
	        );

	        $this->db->insert('quotation_product', $quotation_product);
        }

	    if ($result) {
	    	return $this->get_single_quotation($quotation_id);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	** Quotation Delete
	*/
	public function delete_quotation($quotation_id) {

		$this->db->where(array('qutid' => $quotation_id));
    	$this->db->delete('quotation');

    	$this->db->where(array('qutid' => $quotation_id));
    	$this->db->delete('quotation_product');


    	return $this->db->affected_rows();
	}

}