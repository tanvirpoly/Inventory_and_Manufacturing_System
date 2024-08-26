<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Return_model extends CI_Model
{
	public $data = [];
	/*
	## get return data
	*/
	public function get_return($company_id)
	{
		$query = $this->db->select('returns.*, users.compname, users.name, customers.customerName')
						  ->from('returns')
						  ->join('users', 'users.compid = returns.compid', 'left')
						  ->join('customers', 'customers.customerID = returns.customerID', 'left')
						  ->where('returns.compid', $company_id)
						  ->order_by('returns.returnId', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single return data
	*/
	public function get_single_return($return_id)
	{
		$query = $this->db->select('*')
						  ->from('returns')
						  ->where('returnId', $return_id)
						  ->get()
						  ->row();
		if($query) {	  
		$this->data['return_no'] = $query->returnId;
		$this->data['return_date'] = $query->returnDate;
		$this->data['company'] = $this->get_company($query->compid);
		$this->data['customer'] = $this->get_customer($query->customerID);
		$this->data['products'] = $this->get_products($query->returnId);
		$this->data['sub_total'] = $query->totalPrice;
		$this->data['service_charge'] = (string)$query->scAmount;
		$this->data['total_amount'] = number_format($query->totalPrice + $query->scAmount, 2, '.', ',');
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
	public function get_products($return_id)
	{
		$products = $this->db->select('products.productName as product_name,
									   returns_product.salePrice as unit_price,
									   returns_product.quantity,
									   returns_product.totalPrice as sub_total')
							 ->from('returns_product')
							 ->join('products', 'products.productID = returns_product.productID', 'left')
							 ->where('rt_id', $return_id)
							 ->get()
							 ->result_array();
		return $products;
	}

	

	/*
	## return post request
	*/
	public function post_return($return)
	{
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

    $company = $this->db->select('com_name')
                          ->from('com_profile')
                          ->where('compid',$sale['sale']['company_id'])
                          ->get()
                          ->row();
    //var_dump($company); exit();
    $cn = strtoupper(substr($company->com_name,0,3));
    $pc = sprintf("%'05d", $sn);

    $cusid = 'R-'.$cn.$pc;
    
	    $returns = array(
	        'compid'        => $return['return']['company_id'],
	        'rid'           => $cusid,
	        'returnDate'    => $return['return']['return_date'],
	        'customerID'    => $return['return']['customer_id'],
	        'totalPrice'    => $return['return']['total_amount'],
	        'scAmount'      => $return['return']['service_charge'],
	        'accountType'   => $return['return']['account_type'],
	        'accountNo'     => $return['return']['account_no'],
	        'invoice'       => $return['return']['invoice_no'],
	        'note'          => $return['return']['note'],
	        'regby'         => $return['return']['created_by']
	    );

	    $this->db->insert('returns', $returns);
		$result = $this->db->insert_id();

	    foreach($return['return']['products'] as $row)
	    {      
            $returns_product = array(
                'compid'     => $return['return']['company_id'],
                'rt_id'      => $result,
                'productID'  => $row['product_id'],
                'salePrice'  => $row['unit_price'],
                'quantity'   => $row['quantity'],                 
                'totalPrice' => $row['sub_total'],
                'regby'      => $return['return']['created_by']
            );
       
            $this->db->insert('returns_product',$returns_product);  
	    }

	    if ($result) {
	    	return $this->get_single_return($result);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	** Get return edit purposs
	*/
	public function get_return_edit_purposs($return_id)
	{
		$query = $this->db->select('returnId as return_id,returnDate as return_date, compid as company_id, customerID as customer_id, accountType as account_type, accountNo as account_no, totalPrice as total_amount, scAmount as service_charge, note, regby as created_by, regdate as created_at, upby as updated_by, update as updated_at')
						  ->from('returns')
						  ->where('returnId', $return_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	** Get return edit
	*/
	public function get_return_edit($return_id)
	{
		$query = $this->get_return_edit_purposs($return_id);
		$this->data['return'] = $query;
		$this->data['products'] = $this->get_products($query->return_id);
		$this->data['sub_amount'] = (string)$query->total_amount;
		$this->data['service_charge'] = (string)$query->service_charge;
		$this->data['total_amount'] = (string)number_format($query->total_amount + $query->service_charge, 2, '.', ',');

		return $this->data;
	}


	/*
	## Put request Return update
	*/
	public function put_return($return_id, $return)
	{
	   $returns = array(
	        'compid'        => $return['return']['company_id'],
	        'returnDate'    => $return['return']['return_date'],
	        'customerID'    => $return['return']['customer_id'],
	        'totalPrice'    => $return['return']['total_amount'],
	        'scAmount'      => $return['return']['service_charge'],
	        'accountType'   => $return['return']['account_type'],
	        'accountNo'     => $return['return']['account_no'],
	        'invoice'       => $return['return']['invoice_no'],
	        'note'          => $return['return']['note'],
	        'regby'         => $return['return']['updated_by']
	    );

	    $this->db->update('returns', $returns, array('returnId' => $return_id));
		$result = $this->db->affected_rows();

	    $this->db->where(array('rt_id' => $return_id))->delete('returns_product');

	    foreach($return['return']['products'] as $row) {

	         $returns_product = array(
	            'compid'     => $return['return']['company_id'],
                'rt_id'      => $return_id,
                'productID'  => $row['product_id'],
                'salePrice'  => $row['unit_price'],
                'quantity'   => $row['quantity'],                 
                'totalPrice' => $row['sub_total'],
	            'upby'       => $return['return']['updated_by']
	        );

	        $this->db->insert('returns_product', $returns_product);
        }

	    if ($result) {
	    	return $this->get_single_return($return_id);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	** Return Delete
	*/
	public function delete_return($return_id) {

		$this->db->where(array('returnId' => $return_id));
    	$this->db->delete('returns');

    	$this->db->where(array('rt_id' => $return_id));
    	$this->db->delete('returns_product');


    	return $this->db->affected_rows();
	}

}