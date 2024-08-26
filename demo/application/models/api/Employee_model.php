<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends CI_Model
{
	/*
	## get customer data
	*/
	public function get_employee($company_id)
	{
		$query = $this->db->select('*')
						  ->from('employees')
						  ->where('compid', $company_id)
						  ->order_by('employeeID', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single customer data
	*/
	public function get_single_employee($employee_id)
	{
		$query = $this->db->select('*')
						  ->from('employees')
						  ->where('employeeID', $employee_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete customer data
	*/
	public function delete_employee($employee_id)
	{
		$this->db->delete('employees', array('employeeID'=>$employee_id));

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
	public function post_employee($data)
	{
		$result = $this->db->insert('employees',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new customer
	*/
	public function recent_employee($employee_id)
	{
		$data = $this->db->select('*')
						 ->from('employees')
						 ->where('employeeID', $employee_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check email  is already exists
	*/
	public function check_email_duplicate($email)
	{
		$data = $this->db->select('*')
						 ->from('employees')
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
						 ->from('employees')
						 ->where('phone', $mobile)
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
	public function put_employee($employee_id, $data)
	{
		$this->db->where('employeeID', $employee_id);
		$this->db->update('employees', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $employee_id;
		else:
		    return false;
		endif;
	}
}