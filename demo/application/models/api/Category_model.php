<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_Model
{
	/*
	## get category data
	*/
	public function get_category($company_id)
	{
		$query = $this->db->select('*')
						  ->from('categories')
						  ->where('compid', $company_id)
						  ->order_by('categoryID', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single category data
	*/
	public function get_single_category($category_id)
	{
		$query = $this->db->select('*')
						  ->from('categories')
						  ->where('categoryID', $category_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete category data
	*/
	public function delete_category($category_id)
	{
		$this->db->delete('categories', array('categoryID'=>$category_id));

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
	## category post request
	*/
	public function post_category($data)
	{
		$result = $this->db->insert('categories',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new category
	*/
	public function recent_category($category_id)
	{
		$data = $this->db->select('*')
						 ->from('categories')
						 ->where('categoryID', $category_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check category name is already exists
	*/
	public function check_category_name_duplicate($company_id, $category_name)
	{
		$data = $this->db->select('*')
						 ->from('categories')
						 ->where('compid', $company_id)
						 ->where('categoryName', $category_name)
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
	## Put request category update
	*/
	public function put_category($category_id, $data)
	{
		$this->db->where('categoryID', $category_id);
		$this->db->update('categories', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $category_id;
		else:
		    return false;
		endif;
	}
}