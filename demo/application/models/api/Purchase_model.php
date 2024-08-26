<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_model extends CI_Model
{
	public $data = [];
	/*
	## get purchase data
	*/
public function get_purchase($company_id)
  {
  $query = $this->db->select('purchase.*,suppliers.supplierName')
				  ->from('purchase')
				  ->join('suppliers', 'suppliers.supplierID = purchase.supplier', 'left')
				  ->where('purchase.compid',$company_id)
				  ->order_by('purchase.purchaseID','DESC')
				  ->get()
				  ->result();
  return $query;
}

public function get_dpurchase($company_id,$sdate,$edate)
  {
  $query = $this->db->select('purchase.*,suppliers.supplierName')
				  ->from('purchase')
				  ->join('suppliers', 'suppliers.supplierID = purchase.supplier', 'left')
				  ->where('purchase.compid',$company_id)
				  ->where('purchase.purchaseDate >=',$sdate)
                  ->where('purchase.purchaseDate <=',$edate)
				  //->order_by('purchase.purchaseID','DESC')
				  ->get()
				  ->result();
  return $query;
}

public function get_mpurchase($company_id,$month,$year)
  {
  $query = $this->db->select('purchase.*,suppliers.supplierName')
				  ->from('purchase')
				  ->join('suppliers', 'suppliers.supplierID = purchase.supplier', 'left')
				  ->where('purchase.compid',$company_id)
				  ->where('MONTH(purchaseDate)',$month)
                  ->where('YEAR(purchaseDate)',$year)
				  ->order_by('purchase.purchaseID','DESC')
				  ->get()
				  ->result();
  return $query;
}

public function get_ypurchase($company_id,$year)
  {
  $query = $this->db->select('purchase.*,suppliers.supplierName')
				  ->from('purchase')
				  ->join('suppliers', 'suppliers.supplierID = purchase.supplier', 'left')
				  ->where('purchase.compid',$company_id)
                  ->where('YEAR(purchaseDate)',$year)
				  ->order_by('purchase.purchaseID','DESC')
				  ->get()
				  ->result();
  return $query;
}

	/*
	## get single purchase data
	*/
	public function get_single_purchase($purchase_id)
	{
		$query = $this->db->select('*')
						  ->from('purchase')
						  ->where('purchaseID', $purchase_id)
						  ->get()
						  ->row();
		if($query){	  
			$this->data['purchase_no'] = $query->purchaseID;
			$this->data['challanNo'] = $query->challanNo;
			$this->data['purchase_date'] = $query->purchaseDate;
			$this->data['company'] = $this->get_company($query->compid);
			$this->data['supplier'] = $this->get_supplier($query->supplier);
			$this->data['products'] = $this->get_products($query->purchaseID);
			$this->data['total_quantity'] = $this->get_quantity($query->purchaseID);
			$this->data['total_amount'] = $query->totalPrice;
			$this->data['paid_amount'] = $query->paidAmount;
				$this->data['note'] = $query->note;
			$this->data['net_amount'] = $query->totalPrice - $query->paidAmount;
			$this->data['previous_due'] = ($this->get_price_previous($query->supplier, $query->purchaseID) - $this->get_paid_previous($query->supplier, $query->purchaseID));
			$this->data['total_due'] = $this->get_price($query->supplier) - $this->get_paid($query->supplier);
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
		$company = $this->db->select('com_name as company_name,com_email as email,com_mobile as mobile,com_address as address, com_logo as logo')
							 ->from('com_profile')
							 ->where('compid', $compid)
							 ->get()
							 ->row();
		return $company;
	}

	/*
	## get supplier data
	*/
	public function get_supplier($supplier)
	{
		$supplier = $this->db->select('supplierID as supplier_id, supplierName as supplier_name,compname as company_name,email,mobile,address')
							 ->from('suppliers')
							 ->where('supplierID', $supplier)
							 ->get()
							 ->row();
		return $supplier;
	}

	/*
	## get products data
	*/
	public function get_products($purchase_id)
	{
		$products = $this->db->select('products.productID as product_id,
		                               products.productName as product_name,
									   purchase_product.pprice as unit_price,
									   purchase_product.quantity,
									   purchase_product.totalPrice as sub_total')
							 ->from('purchase_product')
							 ->join('products', 'products.productID = purchase_product.productID', 'left')
							 ->where('purchaseID', $purchase_id)
							 ->get()
							 ->result_array();
		return $products;
	}

	/*
	## get total quantity
	*/
	public function get_quantity($purchase_id)
	{
		$quantity = $this->db->select('sum(quantity) as quantity')
							 ->from('purchase_product')
							 ->where('purchaseID', $purchase_id)
							 ->get()
							 ->row();
		return $quantity->quantity;
	}

	/*
	## customer total price amount previous
	*/
	public function get_price_previous($supplier_id, $purchase_id)
	{
		$price = $this->db->select('sum(totalPrice) as total_price')
							 ->from('purchase')
							 ->where('supplier', $purchase_id)
							 ->where('purchaseID !=', $purchase_id)
							 ->get()
							 ->row();
		return $price->total_price;
	}

	/*
	## customer total paid amount previous
	*/
	public function get_paid_previous($supplier_id, $purchase_id)
	{
		$paid = $this->db->select('sum(paidAmount) as total_paid')
							 ->from('purchase')
							 ->where('supplier', $purchase_id)
							 ->where('purchaseID !=', $purchase_id)
							 ->get()
							 ->row();
		return $paid->total_paid;
	}

	/*
	## supplier total price amount
	*/
	public function get_price($supplier_id)
	{
		$price = $this->db->select('sum(totalPrice) as total_price')
							 ->from('purchase')
							 ->where('supplier', $supplier_id)
							 ->get()
							 ->row();
		return $price->total_price;
	}
	/*
	## supplier total paid amount
	*/
	public function get_paid($supplier_id)
	{
		$paid = $this->db->select('sum(paidAmount) as total_paid')
							 ->from('purchase')
							 ->where('supplier', $supplier_id)
							 ->get()
							 ->row();
		return $paid->total_paid;
	}

	/*
	## purchase post request
	*/
public function post_purchase($purchase)
	{
	$query = $this->db->select('challanNo')
                  ->from('purchase')
                  ->where('regby',$purchase['purchase']['created_by'])
                  ->limit(1)
                  ->order_by('challanNo','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = substr($query->challanNo,6)+1;
        }
    else
        {
        $sn = 1;
        }
        
    $cn = strtoupper(substr($query->challanNo,3,3));
    
    $pc = sprintf("%'05d",$sn);

    $cusid = 'PO-'.$cn.$pc;
    
	$purchases = array(
		'compid' 		=> $purchase['purchase']['company_id'],
		'purchaseDate'  => $purchase['purchase']['purchase_data'],
 		'challanNo'     => $cusid,
		'supplier' 		=> $purchase['purchase']['supplier_id'],
		'totalPrice' 	=> $purchase['purchase']['total_price'],
		'paidAmount' 	=> $purchase['purchase']['paid_total'],
		'accountType' 	=> $purchase['purchase']['account_type'],
		'accountNo' 	=> $purchase['purchase']['account_no'],
		'note' 			=> $purchase['purchase']['note'],
		'regby' 		=> $purchase['purchase']['created_by']
		    );

		$this->db->insert('purchase', $purchases);
		$result = $this->db->insert_id();

	        
	    foreach($purchase['products'] as $row)
	    {
	        $purchase_product = array(
	                'purchaseID' => $result,
	                'productID'  => $row['product_id'],
	                'quantity'   => $row['quantity'],
	                'pprice'     => $row['unit_price'],                    
	                'totalPrice' => $row['sub_total'],
	                'regby'      => $purchase['purchase']['created_by']
	        );
	        
	        $purchase_product = $this->db->insert('purchase_product', $purchase_product); 

	        $swhere = array(
	            'product' => $row['product_id'],
	            'compid'  => $purchase['purchase']['company_id']
	        );

	        $stpd = $this->db->get_where('stock', $swhere)->row();

	        $this->db->where($swhere)->delete('stock');

	        if($stpd)
	        {
	            $tquantity = $row['quantity']+$stpd->totalPices;
	        }
	        else
	        {
	            $tquantity = $row['quantity'];
	        }

	        $stock_info = array(
	            'compid'     => $purchase['purchase']['company_id'],
	            'product'    => $row['product_id'],
	            'totalPices' => $tquantity,
	            //'chalanNo'   => $purchase['purchase']['challan_no'],
	            'regby'      => $purchase['purchase']['created_by']
	        );
	 
	        $this->db->insert('stock', $stock_info);                  
	    }

	    if ($result) {
	    	return $this->get_single_purchase($result);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	** Get purchase edit purposs
	*/
	public function get_purchase_edit_purposs($purchase_id)
	{
		$query = $this->db->select('purchaseID as purchase_id, compid as company_id, purchaseDate as purchase_date, challanNo as challan_no, supplier as supplier_no, totalPrice as total_price, paidAmount as total_paid, accountType as account_type, accountNo as account_no, note, regby as created_by, regdate as created_at, upby as updated_by, update as updated_at')
						  ->from('purchase')
						  ->where('purchaseID', $purchase_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	** Get purchase edit
	*/
	public function get_purchase_edit($purchase_id)
	{
		$query = $this->get_purchase_edit_purposs($purchase_id);
		$this->data['purchase'] = $query;
		$this->data['products'] = $this->get_products($query->purchase_id);
		$this->data['total_amount'] = $query->total_price;
		$this->data['paid_amount'] = $query->total_paid;
		$this->data['due_amount'] = $query->total_price - $query->total_paid;

		return $this->data;
	}


	/*
	** Get purchase detail data
	*/
	public function get_purchase_detail_data($purchase_id)
	{
		$result = $this->db->select('*')
				           ->from('purchase_product')
				           ->where('purchaseID', $purchase_id)
				           ->get()
				           ->result_array();
		return $result;
	}


	/*
	## Put request purchase update
	*/
	public function put_purchase($purchase_id, $purchase)
	{
		
		$purchases = array(
			'compid' 		=> $purchase['purchase']['company_id'],
			'purchaseDate'  => $purchase['purchase']['purchase_data'],
// 			'challanNo'     => $purchase['purchase']['challan_no'],
			'supplier' 		=> $purchase['purchase']['supplier_id'],
			'totalPrice' 	=> $purchase['purchase']['total_price'],
			'paidAmount' 	=> $purchase['purchase']['paid_total'],
			'accountType' 	=> $purchase['purchase']['account_type'],
			'accountNo' 	=> $purchase['purchase']['account_no'],
			'note' 			=> $purchase['purchase']['note'],
			'regby' 		=> $purchase['purchase']['updated_by'],
			'upby' 		    => $purchase['purchase']['updated_by']
		);

		$this->db->update('purchase', $purchases, array('purchaseID' => $purchase_id));
		$result = $this->db->affected_rows();

		$pp = $this->get_purchase_detail_data($purchase_id);

		$old_qty = array();

		foreach($pp as $row2)
		{
			array_push($old_qty, $row2['quantity']);
		}

		$this->db->where(array('purchaseID' => $purchase_id))->delete('purchase_product');
	    
   		$i = 0;
	    foreach($purchase['products'] as $row)
	    {

	        $purchase_product = array(
	                'purchaseID' => $purchase_id,
	                'productID'  => $row['product_id'],
	                'quantity'   => $row['quantity'],
	                'pprice'     => $row['unit_price'],                    
	                'totalPrice' => $row['sub_total'],
	                'upby'       => $purchase['purchase']['updated_by']
	        );
	        
	        $purchase_product = $this->db->insert('purchase_product', $purchase_product); 

	        $swhere = array(
	            'product' => $row['product_id'],
	            'compid'  => $purchase['purchase']['company_id']
	        );

	        $stpd = $this->db->get_where('stock', $swhere)->row();

	        $this->db->where($swhere)->delete('stock');

	        if($stpd)
	        {
	        	if($pp)
	            {
	                $tquantity = ((int)$row['quantity']+(int)$stpd->totalPices)-(int)$old_qty[$i];
	            }
	            else
	            {
	                $tquantity = (int)$row['quantity']+(int)$stpd->totalPices;
	            }   
	        }
	        else
	        {
	            $tquantity = $row['quantity'];
	        }

	        $stock_info = array(
	            'compid'     => $purchase['purchase']['company_id'],
	            'product'    => $row['product_id'],
	            'totalPices' => $tquantity,
	           // 'chalanNo'   => $purchase['purchase']['challan_no'],
	            'regby'      => $purchase['purchase']['updated_by'],
	            'upby'       => $purchase['purchase']['updated_by']
	        );
	 
	        $this->db->insert('stock', $stock_info);
	        $i++;             
		}

	    if ($result) {
	    	return $this->get_single_purchase($purchase_id);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	**
	*/
	public function delete_purchase($purchase_id) {

		$this->db->where(array('purchaseID' => $purchase_id));
    	$this->db->delete('purchase');

    	$this->db->where(array('purchaseID' => $purchase_id));
    	$this->db->delete('purchase_product');


    	return $this->db->affected_rows();
	}

}