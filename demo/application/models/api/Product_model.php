<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model
{
	/*
	## get product data
	*/
	public function get_products($company_id)
	{
// 		$query = $this->db->select('*')
// 						  ->from('products')
// 						  ->where('compid', $company_id)
// 						  ->order_by('productID', 'DESC')
// 						  ->get()
// 						  ->result();
        $this->db->select('*');
        $this->db->from('products')->where('products.compid', $company_id);

        $this->db->join('stock', 'stock.product = products.productID', 'left');
        
            // "stockID": "218",
            // "product": "11393",
            // "chalanNo": "2020002001",
            // "totalPices": "10",
            // "created_by": null
            
            
        $query = $this->db->get()->result();
		return $query;
	}

	/*
	## get single product data
	*/
	public function get_single_product($product_id)
	{
// 		$query = $this->db->select('*')
// 						  ->from('products')
// 						  ->where('productID', $product_id)
// 						  ->get()
// 						  ->row();
        $this->db->select('*');
        $this->db->from('products')->where('products.productID', $product_id);

        $this->db->join('categories', 'categories.categoryID = products.categoryID');
        // $this->db->join('sma_units', 'sma_units.id = products.units');
        $query = $this->db->get()->row();
		return $query;
	}

	/*
	## requesting database delete product data
	*/
	public function delete_product($product_id)
	{
		$this->db->delete('products', array('productID'=>$product_id));

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
	## product post request
	*/
	public function post_product($data)
	{
		$result = $this->db->insert('products',$data);
    	return $this->db->insert_id();
	}
	
	public function post_stock_product($stock_data)
	{
		$result = $this->db->insert('stock',$stock_data);
    	return $this->db->insert_id();
	}

	/*
	## get new product
	*/
	public function recent_product($product_id)
	{
		$data = $this->db->select('products.*,stock.totalPices')
						 ->from('products')
						 ->join('stock','stock.product = products.productID','left')
						 ->where('productID', $product_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check product name is already exists
	*/
	public function check_product_name_duplicate($company_id, $product_name)
	{
		$data = $this->db->select('*')
						 ->from('products')
						 ->where('compid', $company_id)
						 ->where('productName', $product_name)
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
	## Check product name is already exists
	*/
	public function check_product_code_duplicate($company_id, $product_code)
	{
		$data = $this->db->select('*')
						 ->from('products')
						 ->where('compid', $company_id)
						 ->where('productcode', $product_code)
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
	## Put request product update
	*/
	public function put_product($product_id, $data)
	{
		$this->db->where('productID', $product_id);
		$this->db->update('products', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $product_id;
		else:
		    return false;
		endif;
	}

public function get_top_sales_product_data($company_id)
    {
    $query = $this->db->select('sales.compid,products.productName,products.productcode,SUM(sale_product.quantity) as total')
                    ->from('sale_product')
                    ->join('products','products.productID = sale_product.productID','left')
                    ->join('sales','sales.saleID = sale_product.saleID','left')
                    ->where('sales.compid',$company_id)
                    ->group_by('sale_product.productID')
                    ->order_by('total','DESC')
                    ->get()
                    ->result();

  return $query;  
}
}