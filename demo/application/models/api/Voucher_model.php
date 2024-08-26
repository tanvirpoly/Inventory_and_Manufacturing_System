<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Voucher_model extends CI_Model
{
	public $data = [];
	/*
	## get voucher data
	*/
	public function get_all_voucher($company_id)
	{
// 		$query = $this->db->select('vaucher.*, customers.customerName, employees.employeeName, suppliers.supplierName')
        $query = $this->db->select('vaucher.*, customers.customerName, suppliers.supplierName')
						  ->from('vaucher')
						  ->join('customers', 'customers.customerID = vaucher.customerID', 'left')
						  //->join('employees', 'employees.employeeID = vaucher.employee', 'left')
						  ->join('suppliers', 'suppliers.supplierID = vaucher.supplier', 'left')
						  ->where('vaucher.compid', $company_id)
						  ->order_by('vaucher.vuid', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

public function get_voucher_expense($company_id)
  {
  $query = $this->db->select("*")
                  ->FROM('cost_type')
                  ->where('compid',$company_id)
                  ->or_where('compid','All')
                  ->get()
                  ->result();
  return $query;  
}

	/*
	## get single voucher data
	*/
	public function get_single_voucher($voucher_id)
	{
		
		$query = $this->db->select('
		                        vaucher.*,
		                        com_profile.*,
		                        customers.cus_id,
		                        customers.customerName,
		                        customers.mobile as cMobile,
		                        customers.address as cAddress,
		                        suppliers.sup_id,
		                        suppliers.supplierName,
		                        suppliers.mobile as sMobile,
		                        suppliers.address as sAddress,
		                        cost_type.costName,
		                        users.empid,
		                        users.name,
		                        users.mobile as uMobile')
						  ->from('vaucher')
						  ->join('com_profile','com_profile.compid = vaucher.compid','left')
						  ->join('customers','customers.customerID = vaucher.customerID','left')
						  ->join('suppliers','suppliers.supplierID = vaucher.supplier','left')
						  ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
						  ->join('users','users.uid = vaucher.regby','left')
						  ->where('vuid', $voucher_id)
						  ->get()
						  ->row();
        
		if($query) {
// 			$this->data['voucher_no'] = $query->vuid;
// 			$this->data['voucher_date'] = $query->voucherdate;
// 			$this->data['voucher_type'] = $query->vauchertype;
// 			$this->data['company'] = $this->get_company($query->compid);

// 			if($query->vauchertype == "Credit Voucher" || $query->vauchertype == "Customer Pay") {
// 				$this->data['customer'] = $this->get_customer($query->customerID);
// 			} 

// 			if($query->vauchertype == "Debit Voucher") {
// 				// $this->data['employee'] = $this->get_employee($query->employee);
// 				// $this->data['cost_type'] = $this->get_cost_type($query->costType);
// 			}
			
// 			if($query->vauchertype == "Supplier Pay") {
// 				$this->data['supplier'] = $this->get_supplier($query->supplier);
// 			}

// 			$this->data['vouchers'] = $this->get_vouchers($query->vuid);
// 			$this->data['total_amount'] = $query->totalamount;
			//return $this->data;
			return $query;
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
	## get employee data
	*/
	public function get_employee($employee_id)
	{
		$customer = $this->db->select('employeeID as employee_id, employeeName as employee_name, empaddress	 as employee_address, email, phone as mobile')
							 ->from('employees')
							 ->where('employeeID', $employee_id)
							 ->get()
							 ->row();
		return $customer;
	}

	/*
	## get supplier data
	*/
	public function get_supplier($supplier_id)
	{
		$customer = $this->db->select('supplierID as supplier_id, supplierName as supplier_name, compname as company_name, email, mobile, address')
							 ->from('suppliers')
							 ->where('supplierID', $supplier_id)
							 ->get()
							 ->row();
		return $customer;
	}

	/*
	## get vouchers data
	*/
	public function get_vouchers($voucher_id)
	{
		$vauchers = $this->db->select('vaucher_particular.particulars as particular,
									   vaucher_particular.amount as amount')
							 ->from('vaucher_particular')
							 ->where('vuid', $voucher_id)
							 ->get()
							 ->result_array();
		return $vauchers;
	}

	/*
	## get cost type name
	*/
	public function get_cost_type($cost_id)
	{
		$cost = $this->db->select('costName')
							 ->from('cost_type')
							 ->where('costTypeId', $cost_id)
							 ->get()
							 ->row();
		if($cost) {
			return $cost->costName;
		} else {
			return "";
		}
	}

	

	/*
	## voucher post request
	*/

// public function post_voucher($data)
// 	{

// 	$this->db->insert('vaucher', $vouchers);
//     $result = $this->db->insert_id();

// 	if($result)
// 	    {
// 	    return $result;
// 	    }
// 	else
// 	    {
// 	    return false;
// 	    }
// }

// public function post_voucher_prticuler($partdata)
// 	{

// 	$this->db->insert('vaucher_particular', $partdata);
//     $result = $this->db->insert_id();

// 	if($result)
// 	    {
// 	    return true;
// 	    }
// 	else
// 	    {
// 	    return false;
// 	    }
// }
	
public function post_voucher($voucher)
	{
	    //var_dump($voucher); exit();
	$query = $this->db->select('vuid')
                  ->from('vaucher')
                  ->limit(1)
                  ->order_by('vuid','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = $query->vuid+1;
        }
    else
        {
        $sn = 1;
        }
    $company = $this->db->select('com_name')
                          ->from('com_profile')
                          ->where('compid',$voucher['voucher']['company_id'])
                          ->get()
                          ->row();
    //var_dump($company); exit();
    $cn = strtoupper(substr($company->com_name,0,3));
    $pc = sprintf("%'05d",$sn);

    $cusid = 'V-'.$cn.$pc;
    
	$data = array(
        'compid'        => $voucher['voucher']['company_id'],
        'invoice' 	    => $cusid,
        'voucherdate'   => $voucher['voucher']['voucher_date'],
        'customerID'    => $voucher['voucher']['customer_id'],
        'empid'         => $voucher['voucher']['employee_id'],
	    'costType'      => $voucher['voucher']['cost_id'],
	    'supplier'      => $voucher['voucher']['supplier_id'],
        'vauchertype'   => $voucher['voucher']['voucher_type'],
        'totalamount'   => $voucher['voucher']['total_amount'],
        'accountType'   => $voucher['voucher']['account_type'],
        'accountNo'     => $voucher['voucher']['account_no'],
        'regby'         => $voucher['voucher']['created_by']
	    	);
	    	
	    	//var_dump($data); exit();

	    $this->db->insert('vaucher',$data);
		$voucher_id = $this->db->insert_id();
        //var_dump($voucher_id); exit();
	    foreach($voucher['voucher']['vouchers'] as $row)
	        {      
            $vaucher_particular = array(
                'vuid'         => $voucher_id,
                'particulars'  => $row['particular'],
                'amount'       => $row['amount'],
                'regby'        => $voucher['voucher']['created_by']
            );
       
            $this->db->insert('vaucher_particular',$vaucher_particular);  
	    }

	    if($voucher_id){
	        //var_dump($result); exit();
	    	return $this->get_single_voucher($voucher_id);
	    }
	    else {
	    	return false;
	    }
	}
	


	/*
	** Get voucher edit purposs
	*/
	public function get_voucher_edit_purposs($voucher_id)
	{
		$query = $this->db->select('*')
						  ->from('vaucher')
						  ->where('vuid', $voucher_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	** Get voucher edit
	*/
	public function get_voucher_edit($voucher_id)
	{
		$query = $this->get_voucher_edit_purposs($voucher_id);
		$this->data['voucher'] = $query;
		$this->data['vouchers'] = $this->get_vaucher_particular($voucher_id);
		$this->data['total_amount'] = $query->totalamount;

		return $this->data;
	}

	/*
	## get vaucher particular data
	*/
	public function get_vaucher_particular($voucher_id)
	{
		$vaucher_particular = $this->db->select('particulars, amount')
							 ->from('vaucher_particular')
							 ->where('vuid', $voucher_id)
							 ->get()
							 ->result_array();
		return $vaucher_particular;
	}


	/*
	** Get voucher detail data
	*/
	public function get_voucher_detail_data($voucher_id)
	{
		$result = $this->db->select('*')
				           ->from('voucher')
				           ->where('vuid', $voucher_id)
				           ->get()
				           ->result_array();
		return $result;
	}


	/*
	## Put request Voucher update
	*/
	public function put_voucher($voucher_id, $voucher)
	{
	   		if($voucher['voucher']['voucher_type'] == "Credit Voucher" || $voucher['voucher']['voucher_type'] == "Customer Pay")
		{
			$vouchers = array(
	        'compid'        => $voucher['voucher']['company_id'],
	        'voucherdate'   => $voucher['voucher']['voucher_date'],
	        'customerID'    => $voucher['voucher']['customer_id'],
	        'vauchertype'   => $voucher['voucher']['voucher_type'],
	        'totalamount'   => $voucher['voucher']['total_amount'],
	        'accountType'   => $voucher['voucher']['account_type'],
	        'accountNo'     => $voucher['voucher']['account_no'],
	        'upby'          => $voucher['voucher']['updated_by']
	    	);
		}

		if($voucher['voucher']['voucher_type'] == "Debit Voucher")
		{
			$vouchers = array(
	        'compid'        => $voucher['voucher']['company_id'],
	        'voucherdate'   => $voucher['voucher']['voucher_date'],
	        'employee'      => $voucher['voucher']['employee_id'],
	        'costType'      => $voucher['voucher']['cost_id'],
	        'vauchertype'   => $voucher['voucher']['voucher_type'],
	        'totalamount'   => $voucher['voucher']['total_amount'],
	        'accountType'   => $voucher['voucher']['account_type'],
	        'accountNo'     => $voucher['voucher']['account_no'],
	        'upby'          => $voucher['voucher']['updated_by']
	    	);
		}

		if($voucher['voucher']['voucher_type'] == "Supplier Pay")
		{
			$vouchers = array(
	        'compid'        => $voucher['voucher']['company_id'],
	        'voucherdate'   => $voucher['voucher']['voucher_date'],
	        'supplier'      => $voucher['voucher']['supplier_id'],
	        'vauchertype'   => $voucher['voucher']['voucher_type'],
	        'totalamount'   => $voucher['voucher']['total_amount'],
	        'accountType'   => $voucher['voucher']['account_type'],
	        'accountNo'     => $voucher['voucher']['account_no'],
	        'upby'          => $voucher['voucher']['updated_by']
	    	);	
		}

	    $this->db->update('vaucher', $vouchers, array('vuid' => $voucher_id));
		$result = $this->db->affected_rows();

	    $this->db->where(array('vuid' => $voucher_id))->delete('vaucher_particular');

	    foreach($voucher['voucher']['vouchers'] as $row) {

	         $vaucher_particular = array(
	            'vuid'         => $voucher_id,
                'particulars'  => $row['particular'],
                'amount'       => $row['amount'],
	            'regby'        => $voucher['voucher']['updated_by']
	        );

	        $this->db->insert('vaucher_particular', $vaucher_particular);
        }

	    if ($result) {
	    	return $this->get_single_voucher($voucher_id);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	** Voucher Delete
	*/
	public function delete_voucher($voucher_id) {

		$this->db->where(array('vuid' => $voucher_id));
    	$this->db->delete('vaucher');

    	$this->db->where(array('vuid' => $voucher_id));
    	$this->db->delete('vaucher_particular');


    	return $this->db->affected_rows();
	}
	
public function today_sales_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$company_id)
                  ->where('saleDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_purchases_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$company_id)
                  ->where('purchaseDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_emp_payments_amount($company_id)
  {
  $d = date('d');
  $m = date('m');
  $y = date('Y');
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$company_id)
                  ->where('DAY(regdate)',$d)
                  ->where('MONTH(regdate)',$m)
                  ->where('YEAR(regdate)',$y)
                  ->get()
                  ->row();
  return $query;  
}

public function today_returns_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$company_id)
                  ->where('returnDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_cvoucher_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_dvoucher_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_svoucher_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_sales_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$company_id)
                  ->where('saleDate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_purchases_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$company_id)
                  ->where('purchaseDate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_emp_payments_amount($company_id)
  {
  $d = date('d');
  $m = date('m');
  $y = date('Y');
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$company_id)
                  ->where('DAY(regdate) <',$d)
                  ->where('MONTH(regdate) <=',$m)
                  ->where('YEAR(regdate) <=',$y)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_returns_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$company_id)
                  ->where('returnDate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_cvoucher_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_dvoucher_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_svoucher_amount($company_id)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate <',$date)
                  ->get()
                  ->row();
  return $query;  
}


public function total_sales_amount($company_id)
  {
  $query = $this->db->select("SUM(paidAmount) as total,SUM(totalAmount) as ttotal")
                  ->FROM('sales')
                  ->where('compid',$company_id)
                  ->get()
                  ->row();
  return $query;  
}

public function total_purchases_amount($company_id)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total,SUM(`totalPrice`) as ttotal")
                  ->FROM('purchase')
                  ->where('compid',$company_id)
                  ->get()
                  ->row();
  return $query;  
}

public function total_emp_payments_amount($company_id)
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$company_id)
                  ->get()
                  ->row();
  return $query;  
}

public function total_returns_amount($company_id)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$company_id)
                  ->get()
                  ->row();
  return $query;  
}

public function total_cvoucher_amount($company_id)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Credit Voucher')
                  ->get()
                  ->row();
  return $query;  
}

public function total_dvoucher_amount($company_id)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Debit Voucher')
                  ->get()
                  ->row();
  return $query;  
}

public function total_svoucher_amount($company_id)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$company_id)
                  ->WHERE('vauchertype','Supplier Pay')
                  ->get()
                  ->row();
  return $query;  
}

public function total_dsales_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->WHERE('compid',$company_id)
                  ->where('sales.saleDate >=', $sdate)
                  ->where('sales.saleDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dpurchases_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->WHERE('compid',$company_id)
                  ->where('purchaseDate >=', $sdate)
                  ->where('purchaseDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_demp_payments_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->WHERE('compid',$company_id)
                  ->where('regdate >=', $sdate)
                  ->where('regdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dreturns_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->WHERE('compid',$company_id)
                  ->where('returnDate >=', $sdate)
                  ->where('returnDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dcvoucher_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$company_id)
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ddvoucher_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$company_id)
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dsvoucher_amount($sdate,$edate,$company_id)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$company_id)
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function user_dorder_ledger($sdate,$edate,$company_id)
  {
  $query = $this->db->select('*')
                ->from('order')
                ->where('Date(regdate) >=',$sdate)
                ->where('Date(regdate) <=',$edate)
                ->where('compid',$company_id)
                ->get()
                ->result();
  return $query;  
}
public function user_aorder_ledger($company_id)
  {
  $query = $this->db->select('*')
                ->from('order')
                ->where('compid',$company_id)
                ->get()
                ->result();
  return $query;  
}

public function get_cost_report_data($company_id)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.compid',$company_id)
                ->get()
                ->result();
  return $query; 
}

public function get_dcost_report_data($sdate,$edate,$company_id,$vtype)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('voucherdate >=',$sdate)
                ->where('voucherdate <=',$edate)
                ->where('vaucher.vauchertype',$vtype)
                ->where('vaucher.compid',$company_id)
                ->get()
                ->result();
  return $query; 
}

public function cash_book_data($company_id)
  {
  $query = $this->db->select("*")
                  ->FROM('cash')
                  ->where('compid',$company_id)
                  ->get()
                  ->result();
  return $query;  
}

public function cash_book_current_data($cid)
  {
  $cash = $this->db->select("*")
                  ->FROM('cash')
                  ->where('ca_id',$cid)
                  ->get()
                  ->row();
  if($cash)
    {
    $tca = $cash->balance;
    }
  else
    {
    $tca = 0;
    }
  $sa = $this->db->select('SUM(paidAmount) as total')
                ->from('sales')
                ->where('accountType','Cash')
                ->where('accountNo',$cid)
                ->get()
                ->row();
    //var_dump($sa); //exit();
  if($sa == null)
    {
    $saa = 0;
    }
  else
    {
    $saa = $sa->total;
    }

  $pa = $this->db->select("SUM(paidAmount) as total")
                ->from('purchase')
                ->where('accountType','Cash')
                ->where('accountNo',$cid)
                ->get()
                ->row();
    //var_dump($pa);// exit();
  if($pa == null)
    {
    $paa = 0;
    }
  else
    {
    $paa = $pa->total;
    }

  $va = $this->db->select("SUM(totalamount) as total")
                ->from('vaucher')
                ->where('accountType','Cash')
                ->where('vauchertype','Credit Voucher')
                ->where('accountNo',$cid)
                ->get()
                ->row();
    //var_dump($va); //exit();
  if($va == null)
    {
    $vaa = 0;
    }
  else
    {
    $vaa = $va->total;
    }

  $va2 = $this->db->select("SUM(totalamount) as total")
                ->from('vaucher')
                ->where('accountType','Cash')
                ->where_not_in('vauchertype','Credit Voucher')
                ->where('accountNo',$cid)
                ->get()
                ->row();
    //var_dump($va2); //exit();
  if($va2 == null)
    {
    $vaa2 = 0;
    }
  else
    {
    $vaa2 = $va2->total;
    }
  $tva = $vaa-$vaa2;

  $temp = $this->db->select("SUM(salary) as total")
                ->from('employee_payment')
                ->where('accountType','Cash')
                ->where('accountNo',$cid)
                ->get()
                ->row();
    //var_dump($temp); //exit();
    if($temp == null){
        $tempa = 0;
        }
    else{
        $tempa = $temp->total;
        }

    $tr = $this->db->select("SUM(paidAmount) as total")
                ->from('returns')
                ->where('accountType','Cash')
                ->where('accountNo',$cid)
                ->get()
                ->row();
    //var_dump($tr); //exit();
    if($tr == null){
        $tra = 0;
        }
    else{
        $tra = $tr->total;
        }
    
    $tfbt = $this->db->select("SUM(amount) as total")
                ->from('transfer_account')
                ->where('facType','Cash')
                ->where('facAcno',$cid)
                ->get()
                ->row();
    //var_dump($pa); //exit();
    if($tfbt)
      {
      $tfbta = $tfbt->total;
      }
    else
      {
      $tfbta = 0;
      }
    
    $ttbt = $this->db->select("SUM(amount) as total")
                ->from('transfer_account')
                ->where('sacType','Cash')
                ->where('sacAcno',$cid)
                ->get()
                ->row();
    //var_dump($pa); //exit();
    if($ttbt)
      {
      $ttbta = $ttbt->total;
      }
    else
      {
      $ttbta = 0;
      }
  $query = (($tca+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta));
  
  return $query;  
}

public function bank_book_data($company_id)
  {
  $query = $this->db->select("*")
                  ->FROM('bankaccount')
                  ->where('compid',$company_id)
                  ->get()
                  ->result();
  return $query;  
}

public function bank_book_current_data($bid)
  {
  $cash = $this->db->select("*")
                  ->FROM('bankaccount')
                  ->where('ba_id',$bid)
                  ->get()
                  ->row();
    if($cash)
        {
        $tca = $cash->balance;
        }
    else{
        $tca = 0;
        }
  $sa = $this->db->select('SUM(paidAmount) as total')
                ->from('sales')
                ->where('accountType','Bank')
                ->where('accountNo',$bid)
                ->get()
                ->row();
    //var_dump($sa); //exit();
    if($sa == null){
        $saa = 0;
        }
    else{
        $saa = $sa->total;
        }

    $pa = $this->db->select("SUM(paidAmount) as total")
                ->from('purchase')
                ->where('accountType','Bank')
                ->where('accountNo',$bid)
                ->get()
                ->row();
    //var_dump($pa);// exit();
    if($pa == null){
        $paa = 0;
        }
    else{
        $paa = $pa->total;
        }

    $va = $this->db->select("SUM(totalamount) as total")
                ->from('vaucher')
                ->where('accountType','Bank')
                ->where('vauchertype','Credit Voucher')
                ->where('accountNo',$bid)
                ->get()
                ->row();
    //var_dump($va); //exit();
    if($va == null){
        $vaa = 0;
        }
    else{
        $vaa = $va->total;
        }

    $va2 = $this->db->select("SUM(totalamount) as total")
                ->from('vaucher')
                ->where('accountType','Bank')
                ->where_not_in('vauchertype','Credit Voucher')
                ->where('accountNo',$bid)
                ->get()
                ->row();
    //var_dump($va2); //exit();
    if($va2 == null){
        $vaa2 = 0;
        }
    else{
        $vaa2 = $va2->total;
        }
    $tva = $vaa-$vaa2;

    $temp = $this->db->select("SUM(salary) as total")
                ->from('employee_payment')
                ->where('accountType','Bank')
                ->where('accountNo',$bid)
                ->get()
                ->row();
    //var_dump($temp); //exit();
    if($temp == null){
        $tempa = 0;
        }
    else{
        $tempa = $temp->total;
        }

    $tr = $this->db->select("SUM(paidAmount) as total")
                ->from('returns')
                ->where('accountType','Bank')
                ->where('accountNo',$bid)
                ->get()
                ->row();
    //var_dump($tr); //exit();
    if($tr == null){
        $tra = 0;
        }
    else{
        $tra = $tr->total;
        }
    
    $tfbt = $this->db->select("SUM(amount) as total")
                ->from('transfer_account')
                ->where('facType','Bank')
                ->where('facAcno',$bid)
                ->get()
                ->row();
    //var_dump($pa); //exit();
    if($tfbt)
      {
      $tfbta = $tfbt->total;
      }
    else
      {
      $tfbta = 0;
      }
    
    $ttbt = $this->db->select("SUM(amount) as total")
                ->from('transfer_account')
                ->where('sacType','Bank')
                ->where('sacAcno',$bid)
                ->get()
                ->row();
    //var_dump($pa); //exit();
    if($ttbt)
      {
      $ttbta = $ttbt->total;
      }
    else
      {
      $ttbta = 0;
      }
  $query = (($tca+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta));
  
  return $query;  
}

}