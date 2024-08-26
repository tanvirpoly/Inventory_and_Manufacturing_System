<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_model extends CI_Model
{
	/*
	## get product data
	*/
	public function get_profile($company_id)
	{
		$query = $this->db->select('*')
						  ->from('com_profile')
						  ->where('compid', $company_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete product data
	*/
	public function delete_profile($company_id)
	{
		$this->db->delete('com_profile', array('compid'=>$company_id));

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
	public function post_profile($data)
	{
		$result = $this->db->insert('com_profile',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new product
	*/
	public function recent_profile($company_id)
	{
		$data = $this->db->select('*')
						 ->from('com_profile')
						 ->where('compid', $company_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check product name is already exists
	*/
	public function check_profile_name_duplicate($company_id, $product_name)
	{
		$data = $this->db->select('*')
						 ->from('com_profile')
						 ->where('compid', $company_id)
						 ->where('com_name', $product_name)
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
	public function check_company_name_duplicate($company_id, $company_name)
	{
		$data = $this->db->select('*')
						 ->from('com_profile')
						 ->where('compid', $company_id)
						 ->where('com_name', $company_name)
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
	public function check_email_duplicate($company_id, $email)
	{
		$data = $this->db->select('*')
						 ->from('com_profile')
						 ->where('compid', $company_id)
						 ->where('com_email', $email)
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
	public function check_mobile_duplicate($company_id, $mobile)
	{
		$data = $this->db->select('*')
						 ->from('com_profile')
						 ->where('compid', $company_id)
						 ->where('com_email', $mobile)
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
	public function put_profile($company, $data)
	{
		$this->db->where('compid', $company);
		$this->db->update('com_profile', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $company;
		else:
		    return false;
		endif;
	}
}