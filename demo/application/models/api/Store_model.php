<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store_model extends CI_Model
{
	/*
	## get customer data
	*/
public function get_store_data($compid)
	{
	$query = $this->db->select('*')
					  ->from('store')
					  ->where('compid',$compid)
					  ->get()
					  ->row();
	return $query;
}

public function post_store($data,$sid)
	{
	if($sid)
	    {
	    $this->db->where('sid',$sid);
    	$this->db->update('store',$data);
    	$updated_status = $this->db->affected_rows();
    
    	if($updated_status):
    	    return $customer_id;
    	else:
    	    return false;
    	endif;
	    }
	else
	    {
	    $result = $this->db->insert('store',$data);
        return $this->db->insert_id();
	    }
}






}