<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense_model extends CI_Model
{
	/*
	## get category data
	*/
	public function get_expenses($company_id)
	{
		$query = $this->db->select('*')
						  ->from('cost_type')
						  ->where('compid', $company_id)
						  //->order_by('costTypeId', 'DESC')
						  ->get()
						  ->result();
		return $query;
	}

	/*
	## get single category data
	*/
	public function get_single_expense($expense_id)
	{
		$query = $this->db->select('*')
						  ->from('cost_type')
						  ->where('costTypeId', $expense_id)
						  ->get()
						  ->row();
		return $query;
	}

	/*
	## requesting database delete category data
	*/
	public function delete_expense($expense_id)
	{
		$this->db->delete('cost_type', array('costTypeId'=>$expense_id));

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
	public function post_expense($data)
	{
		$result = $this->db->insert('cost_type',$data);
    	return $this->db->insert_id();
	}

	/*
	## get new category
	*/
	public function recent_expense($expense_id)
	{
		$data = $this->db->select('*')
						 ->from('cost_type')
						 ->where('ct_id', $expense_id)
						 ->get()
						 ->row();
		return $data;
	}


	/*
	## Check category name is already exists
	*/
	public function check_expense_name_duplicate($company_id, $expense_name)
	{
		$data = $this->db->select('*')
						 ->from('cost_type')
						 ->where('compid', $company_id)
						 ->where('costName', $expense_name)
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
	public function put_expense($expense_id, $data)
	{
		$this->db->where('costTypeId', $expense_id);
		$this->db->update('cost_type', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $expense_id;
		else:
		    return false;
		endif;
	}
	
public function get_cost_report_data($company_id)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.vauchertype','Debit Voucher')
                ->where('vaucher.compid',$company_id)
                ->get()
                ->result();
  return $query; 
}

public function get_dcost_report_data($company_id,$sdate,$edate)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.vauchertype','Debit Voucher')
                ->where('DATE(voucherdate) >=',$sdate)
                ->where('DATE(voucherdate) <=',$edate)
                // ->where('vaucher.costType',$vtype)
                ->where('vaucher.compid',$company_id)
                ->get()
                ->result();
  return $query; 
}
}