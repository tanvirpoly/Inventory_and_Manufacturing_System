<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model
{
	/*
	# Sales Report
	*/
	public function get_sales($arr) {
		$company_id  = $arr['company_id'];
		$salesmen_id = $arr['salesmen_id'];

		if($company_id != "" AND $salesmen_id == "") {
			$data['salesmen'] = $this->get_employee_name($company_id, 0);
			$data['total_sale_info'] = $this->get_sale_purchase($arr['company_id']);
			$data['sales'] = $this->get_sales_data($arr['company_id']);
		} else {
			$start_date  = date("Y-m-d", strtotime($arr['start_date']));
			$end_date    = date("Y-m-d", strtotime($arr['end_date']));

			if($salesmen_id == "all") {
				$data['salesmen'] = $this->get_employee_name($company_id, 0);
				$data['total_sale_info'] = $this->get_sale_purchase_without_salesmen($company_id, $start_date, $end_date);
				$data['sales'] = $this->get_sales_data_without_salesmen($company_id, $start_date, $end_date);
			} else {
				$data['salesmen'] = $this->get_employee_name($company_id, $salesmen_id);
				$data['total_sale_info'] = $this->get_sale_purchase_with_salesmen($company_id, $salesmen_id, $start_date, $end_date);
				$data['sales'] = $this->get_sales_data_with_salesmen($company_id, $salesmen_id, $start_date, $end_date);
			}
		}

		return $data;
	}

	public function get_sales_data($company_id)
    {
	    $query = $this->db->select('
	                            sales.*,
	                            customers.customerID,
	                            customers.customerName,
	                            users.uid,
	                            users.name')
	                    ->from('sales')
	                    ->join('customers','customers.customerID = sales.customerID','left')
	                    ->join('users','users.uid = sales.regby','left')
	                    ->where('sales.compid',$company_id)
	                    ->get()
	                    ->result();
	    return $query;  
	}

	public function get_sales_data_without_salesmen($company_id , $start_date , $end_date)
    {
	    $query = $this->db->select('
	                            sales.*,
	                            customers.customerID,
	                            customers.customerName,
	                            users.uid,
	                            users.name')
	                    ->from('sales')
	                    ->join('customers','customers.customerID = sales.customerID','left')
	                    ->join('users','users.uid = sales.regby','left')
	                    ->where('sales.compid',$company_id)
	                    ->where('sales.saleDate >=',$start_date)
                    	->where('sales.saleDate <=',$end_date)
	                    ->get()
	                    ->result();
	    return $query;  
	}

	public function get_sales_data_with_salesmen($company_id, $salesmen_id , $start_date , $end_date)
    {
	    $query = $this->db->select('
	                            sales.*,
	                            customers.customerID,
	                            customers.customerName,
	                            users.uid,
	                            users.name')
	                    ->from('sales')
	                    ->join('customers','customers.customerID = sales.customerID','left')
	                    ->join('users','users.uid = sales.regby','left')
	                    ->where('sales.compid', $company_id)
	                    ->where('sales.regby', $salesmen_id)
	                    ->where('sales.saleDate >=',$start_date)
                    	->where('sales.saleDate <=',$end_date)
	                    ->get()
	                    ->result();
	    return $query;  
	}

	public function get_sale_purchase($company_id)
	{
		$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
						  ->where('compid', $company_id)
                          ->group_by('compid')
                          ->from('sales')
                          ->get()
                          ->row();
		return $query;
	}

	public function get_sale_purchase_without_salesmen($company_id , $start_date , $end_date)
	{
		$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
						  ->where('compid', $company_id)
						  ->where('saleDate >=',$start_date)
                    	  ->where('saleDate <=',$end_date)
                          ->from('sales')
                          ->get()
                          ->row();
		return $query;
	}

	public function get_sale_purchase_with_salesmen($company_id, $salesmen_id , $start_date , $end_date)
	{
		$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
						  ->where('compid', $company_id)
						  ->where('regby', $salesmen_id)
	                      ->where('saleDate >=',$start_date)
                    	  ->where('saleDate <=',$end_date)
                          ->group_by('regby')
                          ->from('sales')
                          ->get()
                          ->row();
		return $query;
	}

	public function get_employee_name($company_id, $saleMan)
	{
		$query = $this->db->select('name as employee_name')
						  ->where('compid', $company_id)
						  ->where('uid', $saleMan)
                          ->from('users')
                          ->get()
                          ->row();

		if(isset($query->employee_name))
		{
			return $query->employee_name;
		}else {
			return 'All';
		}
	}

	/*
	# Purchases Report
	*/

	public function get_purchases($arr) {
		$company_id  = $arr['company_id'];
		$supplier_id = $arr['supplier_id'];

		if($company_id != "" AND $supplier_id == "") {
			$data['supplier'] = $this->get_supplier_name($company_id, 0);
			$data['total_purchase_info'] = $this->get_total_purchase($arr['company_id']);
			$data['purchase'] = $this->get_all_purchses_data($arr['company_id']);
		} else {
			$start_date  = date("Y-m-d", strtotime($arr['start_date']));
			$end_date    = date("Y-m-d", strtotime($arr['end_date']));

			if($supplier_id == "all") {
				$data['supplier'] = $this->get_supplier_name($company_id, 0);
				$data['total_purchase_info'] = $this->get_total_search_purchase($company_id, $supplier_id = 'all',  $start_date, $end_date);
				$data['purchase'] = $this->get_search_purchses_data($company_id, $supplier_id = 'all' , $start_date, $end_date);
			} else {
				$data['supplier'] = $this->get_supplier_name($company_id, $supplier_id);
				$data['total_purchase_info'] = $this->get_total_search_purchase($company_id, $supplier_id, $start_date, $end_date);
				$data['purchase'] = $this->get_search_purchses_data($company_id, $supplier_id, $start_date, $end_date);
			}
		}

		return $data;
	}

	public function get_total_purchase($company_id) {
		$query = $this->db->select('sum(totalPrice) as total_amount, sum(paidAmount) as total_paid')
						  ->where('compid', $company_id)
                          ->group_by('compid')
                          ->from('purchase')
                          ->get()
                          ->row();
		return $query;
	}

	public function get_all_purchses_data($company_id)
    {
    	$query = $this->db->select('
                            purchase.*,
                            suppliers.supplierID,
                            suppliers.supplierName')
                    ->from('purchase')
                    ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                    ->where('purchase.compid', $company_id)
                    ->get()
                    ->result();
    	return $query;
	}

	public function get_total_search_purchase($company_id, $supplier_id, $start_date, $end_date) {
		if($supplier_id == 'all') {
			$query = $this->db->select('sum(totalPrice) as total_amount, sum(paidAmount) as total_paid')
						  ->where('purchase.purchaseDate >=',$start_date)
		                  ->where('purchase.purchaseDate <=',$end_date)
						  ->where('compid', $company_id)
                          ->group_by('compid')
                          ->from('purchase')
                          ->get()
                          ->row();
			return $query;

		} else {
			$query = $this->db->select('sum(totalPrice) as total_amount, sum(paidAmount) as total_paid')
						  	->where('purchase.purchaseDate >=',$start_date)
		                	->where('purchase.purchaseDate <=',$end_date)
		                	->where('purchase.supplier',$supplier_id)
		                	->where('purchase.compid',$company_id)
                          	->group_by('compid')
                          	->from('purchase')
                          	->get()
                          	->row();
			return $query;

		}
	}

		public function get_search_purchses_data($company_id, $supplier_id, $start_date, $end_date)
    {
		if ($supplier_id == 'all')
		{
		    $query = $this->db->select('
		                        purchase.*,
		                        suppliers.supplierID,
		                        suppliers.supplierName')
		                ->from('purchase')
		                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
		                ->where('purchase.purchaseDate >=',$start_date)
		                ->where('purchase.purchaseDate <=',$end_date)
		                ->where('purchase.compid',$company_id)
		                ->get()
		                ->result();
		}
		else
		{
		    $query = $this->db->select('
		                        purchase.*,
		                        suppliers.supplierID,
		                        suppliers.supplierName')
		                ->from('purchase')
		                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
		                ->where('purchase.purchaseDate >=',$start_date)
		                ->where('purchase.purchaseDate <=',$end_date)
		                ->where('purchase.supplier',$supplier_id)
		                ->where('purchase.compid',$company_id)
		                ->get()
		                ->result();
		}
			return $query;  
	}

	public function get_supplier_name($company_id, $supplier_id)
	{
		$query = $this->db->select('supplierName as supplier_name')
						  ->where('compid', $company_id)
						  ->where('supplierID', $supplier_id)
                          ->from('suppliers')
                          ->get()
                          ->row();

		if(isset($query->supplier_name))
		{
			return $query->supplier_name;
		}else {
			return 'All';
		}
	}

	// Customer Report
	public function get_customers($company_id,$customer_id) {
		if($customer_id != 'all') {
			$data['customer'] = $this->get_customer_name($company_id, $customer_id);
			$data['get_total_sale_customer'] = $this->get_total_sale_customer_search($company_id, $customer_id);
        	$data['sales'] = $this->get_customer_search_sale($company_id, $customer_id);
		} else {
			$data['customer'] = $this->get_customer_name($company_id, 0);
			$data['get_total_sale_customer'] = $this->get_total_sale_customer($company_id);
			$data['sales'] = $this->get_customer_sale($company_id);
		}
		return $data;
	}

	public function get_total_sale_customer($company_id) {
		$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
						  ->where('compid', $company_id)
                          ->group_by('compid')
                          ->from('sales')
                          ->get()
                          ->row();
		return $query;
	}

	public function get_customer_sale($company_id)
	{
		$sql = "SELECT c.`customerName`, c.`mobile`, sum(s.`totalAmount`) as total_amount, sum(s.`paidAmount`) as total_paid, sum(s.`discountAmount`) as discount_amount, s.`customerID` FROM `customers` as c RIGHT JOIN `sales` as s on c.`customerID` = s.`customerID` WHERE s.`compid` = '$company_id' GROUP by s.`customerID`";

	    $result = $this->db->query($sql);
	    return $result->result();
	}

	public function get_customer_search_sale($company_id, $customer_id)
	{
		$sql = "SELECT c.`customerName`, c.`mobile`, sum(s.`totalAmount`) as total_amount, sum(s.`paidAmount`) as total_paid, sum(s.`discountAmount`) as discount_amount, s.`customerID` FROM `customers` as c RIGHT JOIN `sales` as s on c.`customerID` = s.`customerID` WHERE s.`compid` = $company_id AND s.`customerID` = $customer_id GROUP by s.`customerID`";

	    $result = $this->db->query($sql);
	    return $result->result();
	}

	public function get_total_sale_customer_search($company_id, $customer_id)
	{
		$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
					  ->where('customerID', $customer_id)
					  ->where('compid', $company_id)
                      ->group_by('compid')
                      ->from('sales')
                      ->get()
                      ->row();

		return $query;
	}

	public function get_customer_name($company_id, $customer_id)
	{
		$query = $this->db->select('customerName as customer_name')
						  ->where('compid', $company_id)
						  ->where('customerID', $customer_id)
                          ->from('customers')
                          ->get()
                          ->row();

		if(isset($query->customer_name))
		{
			return $query->customer_name;
		}else {
			return 'All';
		}
	}

	// Customers Get
	public function get_customer_details($company_id, $customer_id) {
		if($customer_id != 'all') {
			$data['customer'] = $this->get_customer_name($company_id, $customer_id);
			$data['get_total_sale_customer'] = $this->get_total_sale_customer_invoice_search($company_id, $customer_id);
        	$data['sales'] = $this->get_customer_search_sale_invoice($company_id, $customer_id);
		} else {
			$data['customer'] = $this->get_customer_name($company_id, 0);
			$data['get_total_sale_customer'] = $this->get_total_sale_customer_invoice_search($company_id, $customer_id);
			$data['sales'] = $this->get_customer_search_sale_invoice($company_id, $customer_id);
		}
		return $data;
	}

	public function get_total_sale_customer_invoice_search($company_id, $customer_id) {
		if($customer_id != 'all') {
			$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
					  ->where('customerID', $customer_id)
					  ->where('compid', $company_id)
                      ->group_by('compid')
                      ->from('sales')
                      ->get()
                      ->row();

		return $query;
		} else {
			$query = $this->db->select('sum(totalAmount) as total_amount, sum(paidAmount) as total_paid, sum(discountAmount) as discount_amount')
					  ->where('compid', $company_id)
                      ->group_by('compid')
                      ->from('sales')
                      ->get()
                      ->row();

		return $query;
		}
	}

	public function get_customer_search_sale_invoice($company_id, $customer_id) {
		if($customer_id == 'all')
		{
			$query = $this->db->select('saleID as sale_id, saleDate as sale_date, totalAmount as amount, paidAmount as paid, discountAmount as discount_amount')
						  ->from('sales')
						  ->where('compid', $company_id)
						  ->get()
						  ->result();
			return $query;
		}
		else
		{
			$query = $this->db->select('saleID as sale_id, saleDate as sale_date, totalAmount as amount, paidAmount as paid, discountAmount as discount_amount')
						  ->from('sales')
						  ->where('customerID', $customer_id)
						  ->where('compid', $company_id)
						  ->get()
						  ->result();
			return $query;
		}
	}

	// SUpplier Report
	public function get_suppliers($company_id, $supplier_id) {
		if($supplier_id != 'all')
	    {
	        $data['supplier_name'] = $this->get_supplier_name($company_id, $supplier_id);
	        $data['get_total_purchase_supplier'] = $this->get_total_purchase_supplier_search($company_id, $supplier_id);
	        $data['purchase'] = $this->get_supplier_search_purchase($company_id, $supplier_id);
	    }
	    else
	    {
	        $data['supplier_name'] = $this->get_supplier_name($company_id, $supplier_id);
	        $data['get_total_purchase_supplier'] = $this->get_total_purchase_supplier_search($company_id, $supplier_id);
	        $data['purchase'] = $this->get_supplier_search_purchase($company_id, $supplier_id);
	    }

	    return $data;
	}

	public function get_total_purchase_supplier_search($company_id, $supplier_id)
	{
		if($supplier_id == 'all')
		{
			$query = $this->db->select('sum(totalPrice) as total_amount, sum(paidAmount) as total_paid')
						  ->where('compid', $company_id)
                          ->group_by('compid')
                          ->from('purchase')
                          ->get()
                          ->row();
		}
		else
		{
			$query = $this->db->select('sum(totalPrice) as total_amount, sum(paidAmount) as total_paid')
						  ->where('supplier', $supplier_id)
						  ->where('compid', $company_id)
                          ->group_by('compid')
                          ->from('purchase')
                          ->get()
                          ->row();
		}

		return $query;
	}

	public function get_supplier_search_purchase($company_id, $supplier_id)
	{
// 		if($supplier_id == 'all')
// 		{
		    //$sql = "SELECT c.`customerName`, c.`mobile`, sum(s.`totalAmount`) as total_amount, sum(s.`paidAmount`) as total_paid, sum(s.`discountAmount`) as discount_amount, s.`customerID` FROM `customers` as c RIGHT JOIN `sales` as s on c.`customerID` = s.`customerID` WHERE s.`compid` = '$company_id' GROUP by s.`customerID`";
			$sql = "SELECT s.`supplierName`, s.`mobile`, s.`compname` as supplierCompany, sum(p.`totalPrice`) as total_amount, sum(p.`paidAmount`) as total_paid, p.`supplier` as supplierID FROM `suppliers` as s RIGHT JOIN `purchase` as p on s.`supplierID` = p.`supplier` WHERE p.`compid` = '$company_id' GROUP by p.`supplier`";
// 		}
// 		else
// 		{
// 			$sql = "SELECT s.`supplierName`, s.`mobile`, s.`compname` as supplierCompany, sum(p.`totalPrice`) as total_amount, sum(p.`paidAmount`) as total_paid, p.`supplier` as supplierID FROM `suppliers` as s RIGHT JOIN `purchase` as p on s.`supplierID` = p.`supplier` WHERE p.`compid` = '$company_id' AND p.`supplier` = '$supplier_id' GROUP by p.`supplier`";
// 		}

	    $result = $this->db->query($sql);
	    return $result->result();
	}

	public function get_supplier_details($company_id, $supplier_id) {
		if($supplier_id != 'all')
	    {
	        $data['supplier_name'] = $this->get_supplier_name($company_id, $supplier_id);
	        $data['get_total_purchase_supplier'] = $this->get_total_purchase_supplier_search($company_id, $supplier_id);
	        $data['purchase'] = $this->specific_supplier_report_search($company_id, $supplier_id);
	    }
	    else
	    {
	        $data['supplier_name'] = $this->get_supplier_name($company_id, $supplier_id);
	        $data['get_total_purchase_supplier'] = $this->get_total_purchase_supplier_search($company_id, $supplier_id);
	        $data['purchase'] = $this->specific_supplier_report_search($company_id, $supplier_id);
	    }

	    return $data;
	}

	public function specific_supplier_report_search($company_id, $supplier_id)
	{
		if($supplier_id == 'all')
		{
			$query = $this->db->select('purchaseID as purchase_no, challanNo as challan_no, purchaseDate as purchase_date, totalPrice as amount, paidAmount as paid')
						  ->from('purchase')
						  ->where('compid', $company_id)
						  ->get()
						  ->result();
			return $query;
		}
		else
		{
			$query = $this->db->select('purchaseID as purchase_no, challanNo as challan_no, purchaseDate as purchase_date, totalPrice as amount, paidAmount as paid')
						  ->from('purchase')
						  ->where('supplier', $supplier_id)
						  ->where('compid', $company_id)
						  ->get()
						  ->result();
			return $query;
		}
	}

	// Stocks Report
	public function get_stocks($company_id) {
		$stocks = array();
		$query = $this->db->select('*')
		                ->from('stock')
		                ->where('compid', $company_id)
		                ->get()
		                ->result_array();
		foreach ($query as $row){
			$data['product_name'] = $this->ge_product_name($row['product']);
			$data['product_code'] = $this->get_product_code($row['product']);
			$data['purchase_quantity'] = $this->get_purchase_quantity($row['product'], $row['compid']);
			$data['sale_quantity'] = $this->get_sales_quantity($row['product'], $row['compid']);
			$data['stock'] = $row['totalPices'];
			array_push($stocks, $data);
		}
		return $stocks;
	}

	public function ge_product_name($product_id) {
		$query = $this->db->select('productName as product_name')
						  ->where('productID', $product_id)
                          ->from('products')
                          ->get()
                          ->row();

		if(isset($query->product_name))
		{
			return $query->product_name;
		}else {
			return 'N/A';
		}
	}

	public function get_product_code($product_id) {
		$query = $this->db->select('productcode as product_code')
						  ->where('productID', $product_id)
                          ->from('products')
                          ->get()
                          ->row();

		if(isset($query->product_code))
		{
			return $query->product_code;
		}else {
			return 'N/A';
		}
	}

	public function get_purchase_quantity($product_id, $company_id) {
		$query = $this->db->select('sum(purchase_product.quantity) as purchase_quantity')
                        ->from('purchase_product')
                        ->join('purchase','purchase.purchaseID = purchase_product.purchaseID','left')
                        ->where('productID',$product_id)
                        ->where('compid',$company_id)
                        ->get()
                        ->row();
        if($query->purchase_quantity) {
        	return $query->purchase_quantity;
        } else {
        	return 0;
        }
	}

	public function get_sales_quantity($product_id, $company_id) {
		$query = $this->db->select('sum(sale_product.quantity) as sale_quantity')
                        ->from('sale_product')
                        ->join('sales','sales.saleID = sale_product.saleID','left')
                        ->where('productID',$product_id)
                        ->where('compid',$company_id)
                        ->get()
                        ->row();
        if($query->sale_quantity) {
        	return $query->sale_quantity;
        } else {
        	return 0;
        }
	}


	// Sale / Purchase Profit / Lose
	public function get_sale_purchase_profit_report($info) {
		$company_id = $info['company_id'];
		$start_date = $info['start_date'];
		$end_date   = $info['end_date'];

		if($start_date != "" AND $end_date != "") {
			$start_date = date("Y-m-d", strtotime($start_date));
	        $end_date = date("Y-m-d", strtotime($end_date));

	        $data['total_sale'] = $this->total_sale_info($company_id, $start_date, $end_date);
	        $data['total_purchase'] = $this->total_purchase_info($company_id, $start_date, $end_date);
	        $data['profit'] = $data['total_sale'] - $data['total_purchase'];
	        $data['sales'] = $this->sale_purchase_profit($company_id, $start_date, $end_date);
		} else {
			$data['total_sale'] = $this->total_sale_info($company_id, $start_date, $end_date);
        	$data['total_purchase'] = $this->total_purchase_info($company_id, $start_date, $end_date);
        	$data['profit'] = $data['total_sale'] - $data['total_purchase'];
        	$data['sales'] = $this->sale_purchase_profit($company_id, $start_date, $end_date);
		}

		return $data;
	}

	public function total_sale_info($company_id, $start_date, $end_date)
	{
		if($start_date != "" AND $end_date != "")
		{
			$query = $this->db->select('sum(totalAmount) as total_amount')
						  	->where('saleDate >=',$start_date)
		                	->where('saleDate <=',$end_date)
		                	->where('compid',$company_id)
                          	->group_by('compid')
                          	->from('sales')
                          	->get()
                          	->row();

			if(isset($query->total_amount)) {
				return $query->total_amount;
			} else {
				return 0;
			}
		}
		else
		{
			$query = $this->db->select('sum(totalAmount) as total_amount')
		                	->where('compid',$company_id)
                          	->group_by('compid')
                          	->from('sales')
                          	->get()
                          	->row();

			if(isset($query->total_amount)) {
				return $query->total_amount;
			} else {
				return 0;
			}
		}
	}

	public function total_purchase_info($company_id, $start_date, $end_date)
	{
		if($start_date != "" AND $end_date != "")
		{
			$query = $this->db->select('sum(totalPrice) as total_amount')
							->where('purchaseDate >=',$start_date)
		                	->where('purchaseDate <=',$end_date)
		                	->where('compid',$company_id)
                          	->group_by('compid')
                          	->from('purchase')
                          	->get()
                          	->row();

			if(isset($query->total_amount)) {
				return $query->total_amount;
			} else {
				return 0;
			}
		}
		else
		{
			$query = $this->db->select('sum(totalPrice) as total_amount')
		                	->where('compid',$company_id)
                          	->group_by('compid')
                          	->from('purchase')
                          	->get()
                          	->row();

			if(isset($query->total_amount)) {
				return $query->total_amount;
			} else {
				return 0;
			}
		}
	}

	public function sale_purchase_profit($company_id, $start_date, $end_date)
	{
		if($start_date != "" AND $end_date != "")
		{

			$data = array();
			$sales = $this->db->select('*')
							  ->where('compid',$company_id)
							  ->where('saleDate >=',$start_date)
		                	  ->where('saleDate <=',$end_date)
	                          ->from('sales')
	                          ->get()
	                          ->result_array();

	        foreach($sales as $sale)
	        {
	        	$purchases = $this->db->select('products.pprice,sale_product.quantity, sale_product.productID')
					        			->from('sale_product')
					                    ->join('products','products.productID = sale_product.productID','left')
					                    ->where('sale_product.saleID =',$sale['saleID'])
					                    ->get()
					                    ->result_array();
				$total_purchase = 0;	                    
			    foreach($purchases as $purchase)
			    {
			    	$total_purchase += $purchase['pprice']*$purchase['quantity'];
			    }

			    $total_profit = $sale['totalAmount'] - $total_purchase;

			    array_push($data, array('invoice_no' => $sale['saleID'],'sale_date' => $sale['saleDate'], 'sale_total' => $sale['totalAmount'], 'purchase_total' => $total_purchase, 'profit' => $total_profit));
	        }
		}
		else
		{
			$data = array();
			$sales = $this->db->select('*')
							  ->where('compid',$company_id)
	                          ->from('sales')
	                          ->get()
	                          ->result_array();

	        foreach($sales as $sale)
	        {
	        	$purchases = $this->db->select('products.pprice,sale_product.quantity, sale_product.productID')
					        			->from('sale_product')
					                    ->join('products','products.productID = sale_product.productID','left')
					                    ->where('sale_product.saleID =',$sale['saleID'])
					                    ->get()
					                    ->result_array();
				$total_purchase = 0;	                    
			    foreach($purchases as $purchase)
			    {
			    	$total_purchase += $purchase['pprice']*$purchase['quantity'];
			    }

			    $total_profit = $sale['totalAmount'] - $total_purchase;

			    array_push($data, array('invoice_no' => $sale['saleID'],'sale_date' => $sale['saleDate'], 'sale_total' => $sale['totalAmount'], 'purchase_total' => $total_purchase, 'profit' => $total_profit));
	        }
		}
		
        return $data;


	}

	// Profit Losss
	public function get_profit_loss_report($info) {

		$company_id = $info['company_id'];

		if($info['start_date'] != "" AND $info['end_date']) {
			$start_date = date("Y-m-d", strtotime($info['start_date']));
            $end_date = date("Y-m-d", strtotime($info['end_date']));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $sale = $this->total_dsales_amount($company_id, $start_date,$end_date);
            $purchase = $this->total_dpurchases_amount($company_id, $start_date,$end_date);
            $cvoucher = $this->total_dcvoucher_amount($company_id, $start_date,$end_date);
            $dvoucher = $this->total_ddvoucher_amount($company_id, $start_date,$end_date);
            $cusvoucher = $this->total_dcusvoucher_amount($company_id, $start_date,$end_date);
            $svoucher = $this->total_dsvoucher_amount($company_id, $start_date,$end_date);
            $data['income'] = array('sale_amount' => $sale, "credit_voucher" => $cvoucher);
            $data['expense'] = array('purchase_amount' => $purchase, 'debit_voucher' => $dvoucher, 'customer_pay' => $cusvoucher, 'supplier_pay' => $svoucher);
            $data['total_income'] = array_sum($data['income']);
            $data['total_expense'] = array_sum($data['expense']);
            $data['net_profit_loss'] = $data['total_income'] - $data['total_expense'];
		} else {
            $sale = $this->total_dsales_amount($company_id, $start_date = "",$end_date = "");
            $purchase = $this->total_dpurchases_amount($company_id, $start_date = "",$end_date = "");
            $cvoucher = $this->total_dcvoucher_amount($company_id, $start_date = "",$end_date = "");
            $dvoucher = $this->total_ddvoucher_amount($company_id, $start_date = "",$end_date = "");
            $cusvoucher = $this->total_dcusvoucher_amount($company_id, $start_date = "",$end_date = "");
            $svoucher = $this->total_dsvoucher_amount($company_id, $start_date = "",$end_date = "");
            $data['income'] = array('sale_amount' => $sale, "credit_voucher" => $cvoucher);
            $data['expense'] = array('purchase_amount' => $purchase, 'debit_voucher' => $dvoucher, 'customer_pay' => $cusvoucher, 'supplier_pay' => $svoucher);
            $data['total_income'] = array_sum($data['income']);
            $data['total_expense'] = array_sum($data['expense']);
            $data['net_profit_loss'] = $data['total_income'] - $data['total_expense'];
		}

		return $data;
	}

	public function total_dsales_amount($company_id, $start_date,$end_date)
    {
    	if($start_date != "" AND $end_date != "") {
	    	$query = $this->db->select("SUM(`paidAmount`) as total")
		                    ->FROM('sales')
		                    ->WHERE('compid',$company_id)
		                    ->where('sales.saleDate >=', $start_date)
		                    ->where('sales.saleDate <=', $end_date)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} else {
	    	$query = $this->db->select("SUM(`paidAmount`) as total")
		                    ->FROM('sales')
		                    ->WHERE('compid',$company_id)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} 
	}

	public function total_dpurchases_amount($company_id, $start_date,$end_date)
    {
    	if($start_date != "" AND $end_date != "") {
	    	$query = $this->db->select("SUM(`paidAmount`) as total")
		                    ->FROM('purchase')
		                    ->WHERE('compid',$company_id)
		                    ->where('purchaseDate >=', $start_date)
		                    ->where('purchaseDate <=', $end_date)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} else {
    	$query = $this->db->select("SUM(`paidAmount`) as total")
	                    ->FROM('purchase')
	                    ->WHERE('compid',$company_id)
	                    ->get()
	                    ->row();
	    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} 
	}

	public function total_dcvoucher_amount($company_id, $start_date,$end_date)
    {
    	if($start_date != "" AND $end_date != "") {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Credit Voucher')
		                    ->where('voucherdate >=', $start_date)
		                    ->where('voucherdate <=', $end_date)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    } 
    	} else {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Credit Voucher')
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    } 
    	}
	}

	public function total_ddvoucher_amount($company_id, $start_date,$end_date)
    {
    	if($start_date != "" AND $end_date != "") {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Debit Voucher')
		                    ->where('voucherdate >=', $start_date)
		                    ->where('voucherdate <=', $end_date)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} else {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Debit Voucher')
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} 
	}

	public function total_dcusvoucher_amount($company_id, $start_date,$end_date)
    {
    	if($start_date != "" AND $end_date != "") {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Customer Pay')
		                    ->where('voucherdate >=', $start_date)
		                    ->where('voucherdate <=', $end_date)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} else {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Customer Pay')
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    }
    	} 
	}

	public function total_dsvoucher_amount($company_id, $start_date,$end_date)
    {
    	if($start_date != "" AND $end_date != "") {
	    	$query = $this->db->select("SUM(`totalamount`) as total")
		                    ->FROM('vaucher')
		                    ->WHERE('compid',$company_id)
		                    ->WHERE('vauchertype','Supplier Pay')
		                    ->where('voucherdate >=', $start_date)
		                    ->where('voucherdate <=', $end_date)
		                    ->get()
		                    ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    } 
    	} else {
		    $query = $this->db->select("SUM(`totalamount`) as total")
					            ->FROM('vaucher')
					            ->WHERE('compid',$company_id)
					            ->WHERE('vauchertype','Supplier Pay')
					            ->get()
					            ->row();
		    if(isset($query->total)) {
		    	return $query->total;
		    } else {
		    	return 0;
		    } 
    	}
	}











}