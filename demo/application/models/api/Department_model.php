<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_model extends CI_Model
{
	/*
	## get category data
	*/
	public function get_departments($dept_id)
	{
		$query = $this->db->select('*')
						  ->from('department')
						  ->where('compid', $dept_id)
						  ->order_by('dpt_id', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single category data
	*/
	public function get_single_department($dept_id)
	{
		$query = $this->db->select('*')
						  ->from('department')
						  ->where('dpt_id', $dept_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete category data
	*/
	public function delete_department($dept_id)
	{
		$this->db->delete('department', array('dpt_id'=>$dept_id));

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
	public function post_department($data)
	{
		$result = $this->db->insert('department',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new category
	*/
	public function recent_department($dept_id)
	{
		$data = $this->db->select('*')
						 ->from('department')
						 ->where('dpt_id', $dept_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check category name is already exists
	*/
	public function check_department_name_duplicate($company_id, $dept_name)
	{
		$data = $this->db->select('*')
						 ->from('department')
						 ->where('compid', $company_id)
						 ->where('dept_name', $dept_name)
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
	public function put_department($dept_id, $data)
	{
		$this->db->where('dpt_id', $dept_id);
		$this->db->update('department', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $dept_id;
		else:
		    return false;
		endif;
	}
}