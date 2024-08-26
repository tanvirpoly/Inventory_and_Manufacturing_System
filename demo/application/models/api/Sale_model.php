<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale_model extends CI_Model
{
	public $data = [];
	/*
	## get sale_ data
	*/
	public function get_sale($company_id)
	{
		$query = $this->db->select('sales.*, customers.customerName')
						  ->from('sales')
						  ->join('customers', 'customers.customerID = sales.customerID', 'left')
						  ->where('sales.compid', $company_id)
						  ->order_by('sales.saleID', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single sale_ data
	*/
	public function get_single_sale($sale_id)
	{
		$query = $this->db->select('*')
						  ->from('sales')
						  ->where('saleID', $sale_id)
						  ->get()
						  ->row();
		if($query) {	  
		$this->data['sale_no'] = $query->invoice_no;
		$this->data['note'] = $query->note;
		$this->data['sale_date'] = $query->saleDate;
		$this->data['company'] = $this->get_company($query->compid);
		$this->data['customer'] = $this->get_customer($query->customerID);
		$this->data['products'] = $this->get_products($query->saleID);
		$this->data['total_quantity'] = $this->get_quantity($query->saleID);
		$this->data['total_amount'] = $query->totalAmount;
		$this->data['paid_amount'] = $query->paidAmount;
		$this->data['discount_amount'] = $query->discountAmount;
		$this->data['net_amount'] = ($query->totalAmount - $query->paidAmount)-$query->discountAmount;
		$this->data['previous_due'] = ($this->get_price_previous($query->customerID, $query->saleID) - $this->get_paid_previous($query->customerID, $query->saleID)) - $this->get_discount_previous($query->customerID, $query->saleID);
		$this->data['total_due'] = ( ($this->get_price($query->customerID) - $this->get_paid($query->customerID)) - $this->get_discount($query->customerID));
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
	$company = $this->db->select('com_name as company_name,com_address as com_address,com_email as email,com_mobile as mobile, com_logo as logo')
						 ->from('com_profile')
						 ->where('compid', $compid)
						 ->get()
						 ->row();
	return $company;
}

	/*
	## get supplier data
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
	public function get_products($sale_id)
	{
		$products = $this->db->select('products.productID as product_id,
		                               products.productName as product_name,
									   sale_product.sprice as unit_price,
									   sale_product.quantity,
									   sale_product.totalPrice as sub_total')
							 ->from('sale_product')
							 ->join('products', 'products.productID = sale_product.productID', 'left')
							 ->where('saleID', $sale_id)
							 ->get()
							 ->result_array();
		return $products;
	}

	/*
	## get total quantity
	*/
	public function get_quantity($sale_id)
	{
		$quantity = $this->db->select('sum(quantity) as quantity')
							 ->from('sale_product')
							 ->where('saleID', $sale_id)
							 ->get()
							 ->row();
		return $quantity->quantity;
	}

	/*
	## customer total price amount previous
	*/
	public function get_price_previous($customer_id, $sale_id)
	{
		$price = $this->db->select('sum(totalAmount) as total_price')
							 ->from('sales')
							 ->where('customerID', $customer_id)
							 ->where('saleID !=', $sale_id)
							 ->get()
							 ->row();
		return $price->total_price;
	}

	/*
	## customer total paid amount previous
	*/
	public function get_paid_previous($customer_id, $sale_id)
	{
		$paid = $this->db->select('sum(paidAmount) as total_paid')
							 ->from('sales')
							 ->where('customerID', $customer_id)
							 ->where('saleID !=', $sale_id)
							 ->get()
							 ->row();
		return $paid->total_paid;
	}

	/*
	## customer total discount amount previous
	*/
	public function get_discount_previous($customer_id, $sale_id)
	{
		$paid = $this->db->select('sum(discountAmount) as discount_amount')
							 ->from('sales')
							 ->where('customerID', $customer_id)
							 ->where('saleID !=', $sale_id)
							 ->get()
							 ->row();
		return $paid->discount_amount;
	}

	/*
	## customer total price amount
	*/
	public function get_price($customer_id)
	{
		$price = $this->db->select('sum(totalAmount) as total_price')
							 ->from('sales')
							 ->where('customerID', $customer_id)
							 ->get()
							 ->row();
		return $price->total_price;
	}

	/*
	## customer total paid amount
	*/
	public function get_paid($customer_id)
	{
		$paid = $this->db->select('sum(paidAmount) as total_paid')
							 ->from('sales')
							 ->where('customerID', $customer_id)
							 ->get()
							 ->row();
		return $paid->total_paid;
	}

	/*
	## customer total discount amount
	*/
	public function get_discount($customer_id)
	{
		$paid = $this->db->select('sum(discountAmount) as discount_amount')
							 ->from('sales')
							 ->where('customerID', $customer_id)
							 ->get()
							 ->row();
		return $paid->discount_amount;
	}

	/*
	## sale post request
	*/
	public function post_sale($sale)
	{
		$discount_amount = 0;
		if($sale['sale']['discount_type'] == '%')
        {
        	$discount_amount += ((int)$sale['sale']['total_amount']*(int)$sale['sale']['discount_amount'])/100;
        }
    	else{
        	$discount_amount += $sale['sale']['discount_amount'];
        }
        
        $query = $this->db->select('saleID')
                  ->from('sales')
                  ->limit(1)
                  ->order_by('saleID','DESC')
                  ->get()
                  ->row();
    if($query)
        {
        $sn = $query->saleID+1;
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

    $cusid = 'INV-'.$cn.$pc;

		$sales = array(
			'compid' 		=> $sale['sale']['company_id'],
			'invoice_no' 	=> $cusid,
			'saleDate'  	=> $sale['sale']['sale_data'],
			'customerID' 	=> $sale['sale']['customer_id'],
			'totalAmount' 	=> $sale['sale']['total_amount'],
			'paidAmount' 	=> $sale['sale']['paid_amount'],
			'dueamount' 	=> ($sale['sale']['total_amount']-($sale['sale']['paid_amount']+$sale['sale']['discount_amount'])),
			'discount' 		=> $sale['sale']['discount_amount'],
			'accountType' 	=> $sale['sale']['account_type'],
			'accountNo' 	=> $sale['sale']['account_no'],
			'discountType'	=> $sale['sale']['discount_type'],
			'discountAmount'=> $discount_amount,
			'note' 			=> $sale['sale']['note'],
			'regby' 		=> $sale['sale']['created_by']
		            );

		$this->db->insert('sales', $sales);
		$result = $this->db->insert_id();

	        
	    foreach($sale['products'] as $row)
	    {
	        $sale_product = array(
	                'saleID' => $result,
	                'productID'  => $row['product_id'],
	                'quantity'   => $row['quantity'],
	               // 'squantity'  => $row['quantity'],
	                'sprice'     => $row['unit_price'],                    
	                'totalPrice' => $row['sub_total'],
	                'regby'      => $sale['sale']['created_by']
	        );
	        
	        $sale_product = $this->db->insert('sale_product', $sale_product); 

	        $swhere = array(
	            'product' => $row['product_id'],
	            'compid'  => $sale['sale']['company_id']
	        );

	        $stpd = $this->db->get_where('stock', $swhere)->row();

	        $this->db->where($swhere)->delete('stock');

	        if($stpd)
	        {
	            $tquantity = $stpd->totalPices-$row['quantity'];
	        }
	        else
	        {
	            $tquantity = -$row['quantity'];
	        }

	        $stock_info = array(
	            'compid'     => $sale['sale']['company_id'],
	            'product'    => $row['product_id'],
	            'totalPices' => $tquantity,
	           // 'chalanNo'   => 'S001',
	            'regby'      => $sale['sale']['created_by']
	        );
	 
	        $this->db->insert('stock', $stock_info);                  
	    }

	    if ($result) {
	    	return $this->get_single_sale($result);
	    }
	    else {
	    	return false;
	    }
	}

public function post_cart_save($sales)
  {    
  $this->db->insert('cart_product', $sales);
  $result = $this->db->insert_id();

  return $result;
}

public function get_cart_products($created_by)
  {
  $query = $this->db->select('cart_product.*,products.productName,products.productcode,')
                  ->from('cart_product')
                  ->join('products','products.productID = cart_product.pid','left')
                  ->where('uid',$created_by)
                  ->get()
                  ->result();
  return $query;  
}

public function post_save_pos_sale($sale)
  {
  $this->db->insert('sales', $sales);
  $result = $this->db->insert_id();

  return $result;
}

public function post_save_pos_sale_product($sproduct)
  {
  $this->db->insert('sale_product', $sproduct);
  $result = $this->db->insert_id();

  return $result;
}

public function post_pos_sale($sale)
  {
  //var_dump($sale); exit();
  
  $discount = 0;
  if($sale['sale']['disType'] == '%')
    {
    $discount += ((int)$sale['sale']['tAmount']*(int)$sale['sale']['disAmount'])/100;
    }
  else
    {
    $discount += $sale['sale']['disAmount'];
    }
        
  $query = $this->db->select('saleID')
                ->from('sales')
                ->where('compid',$sale['sale']['company_id'])
                ->limit(1)
                ->order_by('saleID','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->saleID+1;
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

  $cusid = 'INV-'.$cn.$pc;

  $sales = array(
    'compid'         => $sale['sale']['company_id'],
    'invoice_no'     => $cusid,
    'saleDate'       => date('Y-m-d'),
    'customerID'     => $sale['sale']['customer'],
    'totalAmount'    => $sale['sale']['tAmount'],
    'paidAmount'     => $sale['sale']['pAmount'],
    'dueamount'      => ($sale['sale']['tAmount']-($sale['sale']['pAmount']+$discount)),
    'discount'       => $sale['sale']['discount'],
    'discountType'   => $sale['sale']['disType'],
    'discountAmount' => $discount,
    'accountType'    => $sale['sale']['accountType'],
    'accountNo'      => $sale['sale']['accountNo'],
    'note'           => $sale['sale']['note'],
    'regby'          => $sale['sale']['created_by']
              );

  $this->db->insert('sales', $sales);
  $result = $this->db->insert_id();

  foreach($sale['products'] as $row)
    {
    $sproduct = array(
      'saleID'     => $result,
      'productID'  => $row['product_id'],
      'quantity'   => $row['quantity'],
      'sprice'     => $row['unit_price'],                    
      'totalPrice' => $row['sub_total'],
      'regby'      => $sale['sale']['created_by']
          );
          
    $sale_product = $this->db->insert('sale_product',$sproduct); 

    $swhere = array(
      'product' => $row['product_id'],
      'compid'  => $sale['sale']['company_id']
          );

    $stpd = $this->db->get_where('stock',$swhere)->row();

    $this->db->where($swhere)->delete('stock');

    if($stpd)
      {
      $tquantity = $stpd->totalPices-$row['quantity'];
      }
    else
      {
      $tquantity = -$row['quantity'];
      }

    $stock_info = array(
      'compid'     => $sale['sale']['company_id'],
      'product'    => $row['product_id'],
      'totalPices' => $tquantity,
      'regby'      => $sale['sale']['created_by']
          );
   
    $this->db->insert('stock', $stock_info);                  
    }
  $this->db->where(array('uid' => $sale['sale']['created_by']))->delete('cart_product');

  if($result)
    {
    //return $this->get_single_sale($result);
    return $result;
    }
  else
    {
    return false;
    }
}

	/*
	** Get sale edit purposs
	*/
	public function get_sale_edit_purposs($sale_id)
	{
		$query = $this->db->select('saleID as sale_id, compid as company_id, saleDate as sale_date, customerID as customer_id, totalAmount as total_amount, paidAmount as paid_amount, accountType as account_type, accountNo as account_no, discount as discount, discountType as discount_type, discountAmount as discount_amount, note, regby as created_by, regdate as created_at, upby as updated_by, update as updated_at')
						  ->from('sales')
						  ->where('saleID', $sale_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	** Get sale edit
	*/
	public function get_sale_edit($sale_id)
	{
		$query = $this->get_sale_edit_purposs($sale_id);
		$this->data['sale'] = $query;
		$this->data['products'] = $this->get_products($query->sale_id);
		$this->data['total_amount'] = $query->total_amount;
		$this->data['paid_amount'] = $query->paid_amount;
		$this->data['discount_amount'] = $query->total_amount - $query->paid_amount;
		return $this->data;
	}


	/*
	** Get sale_ detail data
	*/
	public function get_sale_detail_data($sale_id)
	{
		$result = $this->db->select('*')
				           ->from('sale_product')
				           ->where('saleID', $sale_id)
				           ->get()
				           ->result_array();
		return $result;
	}


	/*
	## Put request sale_ update
	*/
	public function put_sale($sale_id, $sale)
	{
		
		$discount_amount = 0;
		if($sale['sale']['discount_type'] == '%')
        {
        	$discount_amount += ((int)$sale['sale']['total_amount']*(int)$sale['sale']['discount_amount'])/100;
        }
    	else{
        	$discount_amount += $sale['sale']['discount_amount'];
        }

		$sales = array(
			'compid' 		=> $sale['sale']['company_id'],
			'saleDate'  	=> $sale['sale']['sale_data'],
			'customerID' 	=> $sale['sale']['customer_id'],
			'totalAmount' 	=> $sale['sale']['total_amount'],
			'paidAmount' 	=> $sale['sale']['paid_amount'],
			'discount' 		=> $sale['sale']['discount_amount'],
			'accountType' 	=> $sale['sale']['account_type'],
			'accountNo' 	=> $sale['sale']['account_no'],
			'discountType'	=> $sale['sale']['discount_type'],
			'discountAmount'=> $discount_amount,
			'note' 			=> $sale['sale']['note'],
			'upby' 		=> $sale['sale']['updated_by']
		);


		$this->db->update('sales', $sales, array('saleID' => $sale_id));
		$result = $this->db->affected_rows();

		$pp = $this->get_sale_detail_data($sale_id);

		$old_qty = array();

		foreach($pp as $row2)
		{
			array_push($old_qty, $row2['quantity']);
		}

		$this->db->where(array('saleID' => $sale_id))->delete('sale_product');
	    
   		$i = 0;
	    foreach($sale['products'] as $row)
	    {

	        $sale_product = array(
	                'saleID' 	 => $sale_id,
	                'productID'  => $row['product_id'],
	                'quantity'   => $row['quantity'],
	               // 'squantity'  => $row['quantity'],
	                'sprice'     => $row['unit_price'],                    
	                'totalPrice' => $row['sub_total'],
	                'upby'       => $sale['sale']['updated_by']
	        );
	        
	        $sale_product = $this->db->insert('sale_product', $sale_product); 

	        $swhere = array(
	            'product' => $row['product_id'],
	            'compid'  => $sale['sale']['company_id']
	        );

	        $stpd = $this->db->get_where('stock', $swhere)->row();

	        $this->db->where($swhere)->delete('stock');

	        if($stpd)
	        {
	        	if($pp)
	            {
	                $tquantity = ($row['quantity']+$stpd->totalPices)-$old_qty[$i];
	            }
	            else
	            {
	                $tquantity = $row['quantity']+$stpd->totalPices;
	            }   
	        }
	        else
	        {
	            $tquantity = $row['quantity'];
	        }

	        $stock_info = array(
	            'compid'     => $sale['sale']['company_id'],
	            'product'    => $row['product_id'],
	            'totalPices' => $tquantity,
	           // 'chalanNo'   => 'S001',
	            'regby'      => $sale['sale']['updated_by'],
	            'upby'       => $sale['sale']['updated_by']
	        );
	 
	        $this->db->insert('stock', $stock_info);   $i++;             
		}

	    if ($result) {
	    	return $this->get_single_sale($sale_id);
	    }
	    else {
	    	return false;
	    }
	}

	/*
	**
	*/
	public function delete_sale($sale_id) {

		$this->db->where(array('saleID' => $sale_id));
    	$this->db->delete('sales');

    	$this->db->where(array('saleID' => $sale_id));
    	$this->db->delete('sale_product');


    	return $this->db->affected_rows();
	}
	
public function sales_due_adata($company_id)
  {
  $query = $this->db->select('sales.*,customers.customerName,customers.mobile,')
                  ->from('sales')
                  ->join('customers','customers.customerID = sales.customerID','left')
                  ->where('totalAmount > paidAmount')
                  ->where('sales.compid',$company_id)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_due_ddata($company_id,$sdate,$edate)
  {
    $query = $this->db->select('sales.*,customers.customerName,customers.mobile,')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->where('totalAmount > paidAmount')
                    ->where('sales.compid',$company_id)
                    ->where('saleDate >=',$sdate)
                    ->where('saleDate <=',$edate)
                    ->get()
                    ->result();
  return $query;  
}

public function sales_profit_adata($company_id)
  {
  $data = array();
    $sales = $this->db->select('*')
                    ->where('compid',$company_id)
                    ->from('sales')
                    ->get()
                    ->result_array();

    foreach($sales as $sale)
      {
      $purchases = $this->db->select('products.pprice,sale_product.quantity,sale_product.productID')
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
  return $data;  
}

public function sales_profit_ddata($company_id,$sdate,$edate)
  {
  $data = array();
  $sales = $this->db->select('*')
                    ->where('compid',$company_id)
                    ->from('sales')
                    ->where('saleDate >=',$sdate)
                    ->where('saleDate <=',$edate)
                    ->get()
                    ->result_array();

    foreach($sales as $sale)
      {
      $purchases = $this->db->select('products.pprice,sale_product.quantity,sale_product.productID')
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
  return $data;
}

}