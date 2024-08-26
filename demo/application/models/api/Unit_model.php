<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unit_model extends CI_Model
{
	/*
	## get unit data
	*/
	public function get_unit()
	{
		$query = $this->db->select('*')
						  ->from('sma_units')
						  //->where('compid', $company_id)
						  ->where('compid','All')
						  ->order_by('id', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}
	
public function get_all_unit()
	{
	$query = $this->db->select('*')
					  ->from('sma_units')
					  ->order_by('id', 'DESC')
					  ->get()
					  ->result();
	return $query;
}

	/*
	## get single unit data
	*/
	public function get_single_unit($unit_id)
	{
		$query = $this->db->select('*')
						  ->from('sma_units')
						  ->where('id', $unit_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete unit data
	*/
	public function delete_unit($unit_id)
	{
		$this->db->delete('sma_units', array('id'=>$unit_id));

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
	## unit post request
	*/
	public function post_unit($data)
	{
		$result = $this->db->insert('sma_units',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new unit
	*/
	public function recent_unit($unit_id)
	{
		$data = $this->db->select('*')
						 ->from('sma_units')
						 ->where('id', $unit_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check company name is already exists
	*/
	public function check_unit_code_duplicate($company_id, $unit_code)
	{
		$data = $this->db->select('*')
						 ->from('sma_units')
						 ->where('compid', $company_id)
						 ->where('unitCode', $unit_code)
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
	public function check_unit_name_duplicate($company_id, $unit_name)
	{
		$data = $this->db->select('*')
						 ->from('sma_units')
						 ->where('compid', $company_id)
						 ->where('unitName', $unit_name)
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
	## Put request unit update
	*/
	public function put_unit($unit_id, $data)
	{
		$this->db->where('id', $unit_id);
		$this->db->update('sma_units', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $unit_id;
		else:
		    return false;
		endif;
	}
}