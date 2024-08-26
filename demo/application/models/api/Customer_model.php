<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_model extends CI_Model
{
	/*
	## get customer data
	*/
	public function get_customer($company_id)
	{
		$query = $this->db->select('*')
						  ->from('customers')
						  ->where('compid', $company_id)
						  ->order_by('customerID', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single customer data
	*/
	public function get_single_customer($customer_id)
	{
		$query = $this->db->select('*')
						  ->from('customers')
						  ->where('customerID', $customer_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete customer data
	*/
	public function delete_customer($customer_id)
	{
		$this->db->delete('customers', array('customerID'=>$customer_id));

		if (!$this->db->affected_rows())
		{
		    return false;
		}
		else
		{
		    return true;
		}
	}

	/*
	## Customer post request
	*/
	public function post_customer($data)
	{
		$result = $this->db->insert('customers',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new customer
	*/
	public function recent_customer($customer_id)
	{
		$data = $this->db->select('*')
						 ->from('customers')
						 ->where('customerID', $customer_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check company name is already exists
	*/
	public function check_company_name_duplicate($company_name)
	{
		$data = $this->db->select('*')
						 ->from('customers')
						 ->where('compname', $company_name)
						 ->get()
						 ->row();
		if($data)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	## Check email  is already exists
	*/
	public function check_email_duplicate($email)
	{
		$data = $this->db->select('*')
						 ->from('customers')
						 ->where('email', $email)
						 ->get()
						 ->row();
		if($data)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	## Check mobile is already exists
	*/
	public function check_mobile_duplicate($mobile)
	{
		$data = $this->db->select('*')
						 ->from('customers')
						 ->where('mobile', $mobile)
						 ->get()
						 ->row();
		if($data)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	## Put request customer update
	*/
	public function put_customer($customer_id, $data)
	{
		$this->db->where('customerID', $customer_id);
		$this->db->update('customers', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $customer_id;
		else:
		    return false;
		endif;
	}

public function total_dsales_amount($customer,$sdate,$edate)
  {
  $query = $this->db->select("SUM(totalAmount) as ta,SUM(paidAmount) as tp,SUM(discountAmount) as td")
                  ->FROM('sales')
                  ->where('customerID', $customer)
                  ->where('saleDate >=', $sdate)
                  ->where('saleDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dvoucher_amount($customer,$sdate,$edate)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('customerID', $customer)
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dreturn_amount($customer,$sdate,$edate)
  {
  $query = $this->db->select("SUM(paidAmount) as ta")
                  ->FROM('returns')
                  ->where('customerID', $customer)
                  ->where('returnDate >=', $sdate)
                  ->where('returnDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_msales_amount($customer,$month,$year)
  {
  $query = $this->db->select("SUM(totalAmount) as ta,SUM(paidAmount) as tp,SUM(discountAmount) as td")
                  ->FROM('sales')
                  ->where('customerID', $customer)
                  ->where('MONTH(saleDate)',$month)
                  ->where('YEAR(saleDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mvoucher_amount($customer,$month,$year)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('customerID', $customer)
                  ->where('MONTH(voucherdate)',$month)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mreturn_amount($customer,$month,$year)
  {
  $query = $this->db->select("SUM(paidAmount) as ta")
                  ->FROM('returns')
                  ->where('customerID', $customer)
                  ->where('MONTH(returnDate)',$month)
                  ->where('YEAR(returnDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ysales_amount($customer,$year)
  {
  $query = $this->db->select("SUM(totalAmount) as ta,SUM(paidAmount) as tp,SUM(discountAmount) as td")
                  ->FROM('sales')
                  ->where('customerID', $customer)
                  ->where('YEAR(saleDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_yvoucher_amount($customer,$year)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('customerID', $customer)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_yreturn_amount($customer,$year)
  {
  $query = $this->db->select("SUM(paidAmount) as ta")
                  ->FROM('returns')
                  ->where('customerID', $customer)
                  ->where('YEAR(returnDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_sales_amount($customer)
  {
  $query = $this->db->select("SUM(totalAmount) as ta,SUM(paidAmount) as tp,SUM(discountAmount) as td")
                  ->FROM('sales')
                  ->where('customerID', $customer)
                  ->get()
                  ->row();
  return $query;  
}

public function total_voucher_amount($customer)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('customerID', $customer)
                  ->get()
                  ->row();
  return $query;  
}

public function total_return_amount($customer)
  {
  $query = $this->db->select("SUM(paidAmount) as ta")
                  ->FROM('returns')
                  ->where('customerID', $customer)
                  ->get()
                  ->row();
  return $query;  
}






}