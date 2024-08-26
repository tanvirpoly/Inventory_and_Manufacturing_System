<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
	/*
	## get supplier data
	*/
	public function get_supplier($company_id)
	{
		$query = $this->db->select('*')
						  ->from('suppliers')
						  ->where('compid', $company_id)
						  ->order_by('supplierID', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single supplier data
	*/
	public function get_single_supplier($supplier_id)
	{
		$query = $this->db->select('*')
						  ->from('suppliers')
						  ->where('supplierID', $supplier_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete supplier data
	*/
	public function delete_supplier($supplier_id)
	{
		$this->db->delete('suppliers', array('supplierID'=>$supplier_id));

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
	## Supplier post request
	*/
	public function post_supplier($data)
	{
		$result = $this->db->insert('suppliers',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new supplier
	*/
	public function recent_supplier($supplier_id)
	{
		$data = $this->db->select('*')
						 ->from('suppliers')
						 ->where('supplierID', $supplier_id)
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
						 ->from('suppliers')
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
						 ->from('suppliers')
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
						 ->from('suppliers')
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
	## Put request update supplier
	*/
	public function put_supplier($supplier_id, $data)
	{
		$this->db->where('supplierID', $supplier_id);
		$this->db->update('suppliers', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $supplier_id;
		else:
		    return false;
		endif;
	}

public function total_purchase_amount($sid)
  {
  $query = $this->db->select("SUM(totalPrice) as ta,SUM(paidAmount) as tp")
                  ->FROM('purchase')
                  ->where('supplier',$sid)
                  ->get()
                  ->row();
  return $query;  
}

public function total_voucher_amount($sid)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('supplier',$sid)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dpurchase_amount($sdate,$edate,$sid)
  {
  $query = $this->db->select("SUM(totalPrice) as ta,SUM(paidAmount) as tp")
                  ->FROM('purchase')
                  ->where('supplier', $sid)
                  ->where('purchaseDate >=', $sdate)
                  ->where('purchaseDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dvoucher_amount($sdate,$edate,$sid)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('supplier', $sid)
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mpurchase_amount($month,$year,$sid)
  {
  $query = $this->db->select("SUM(totalPrice) as ta,SUM(paidAmount) as tp")
                  ->FROM('purchase')
                  ->where('supplier', $sid)
                  ->where('MONTH(purchaseDate)',$month)
                  ->where('YEAR(purchaseDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mvoucher_amount($month,$year,$sid)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('supplier', $sid)
                  ->where('MONTH(voucherdate)',$month)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ypurchase_amount($year,$sid)
  {
  $query = $this->db->select("SUM(totalPrice) as ta,SUM(paidAmount) as tp")
                  ->FROM('purchase')
                  ->where('supplier', $sid)
                  ->where('YEAR(purchaseDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_yvoucher_amount($year,$sid)
  {
  $query = $this->db->select("SUM(totalamount) as ta")
                  ->FROM('vaucher')
                  ->where('supplier', $sid)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function get_supplier_purchase($supid)
	{
	$query = $this->db->select('SUM(purchase.totalPrice) as totalpurchase,SUM(purchase.paidAmount) as paid')
						  ->from('purchase')
						  ->where('supplier',$supid)
						  ->get()
						  ->row();
	return $query;
}

public function get_supplier_voucher($supid)
	{
	$query = $this->db->select('SUM(vaucher.totalamount) as payment')
						  ->from('vaucher')
						  ->where('supplier',$supid)
						  ->get()
						  ->row();
	return $query;
}

public function get_supplier_dpurchase($sdate,$edate,$supid)
	{
	$query = $this->db->select('SUM(purchase.totalPrice) as totalpurchase,SUM(purchase.paidAmount) as paid')
						  ->from('purchase')
						  ->where('purchaseDate >=', $sdate)
                          ->where('purchaseDate <=', $edate)
						  ->where('supplier',$supid)
						  ->get()
						  ->row();
	return $query;
}

public function get_supplier_dvoucher($sdate,$edate,$supid)
	{
	$query = $this->db->select('SUM(vaucher.totalamount) as payment')
						  ->from('vaucher')
						  ->where('voucherdate >=', $sdate)
                          ->where('voucherdate <=', $edate)
                          ->where('supplier',$supid)
						  ->get()
						  ->row();
	return $query;
}


}