<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class auth_model extends CI_Model
{
	/*
	## Check user is valid
	*/
	public function check_user_is_valid($email, $password)
	{
	if(is_numeric($email))
	    {
	    $mob= '+88'.$email;
		$data = $this->db->select('*')
						 ->from('users')
						 ->where('mobile', $mob)
						 ->where('password', $password)
						 ->where('status','Active')
						 ->get()
						 ->row();
	    }
	else
	    {
	    $data = $this->db->select('*')
						 ->from('users')
						 ->where('email', $email)
						 ->where('password', $password)
						 ->where('status','Active')
						 ->get()
						 ->row();
	    }
		return $data;
	}

	/*
	## check company is
	*/
	public function check_compname_duplicate($compname)
	{
		$data = $this->db->select('*')
						 ->from('users')
						 ->where('compname', $compname)
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
	## check new user email address is duplicate
	*/
	public function check_email_duplicate($email)
	{
		$data = $this->db->select('*')
						 ->from('users')
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
	## check new user mobile is duplicate 
	*/
	public function check_mobile_duplicate($mobile)
	{
		$data = $this->db->select('*')
						 ->from('users')
						 ->where('mobile', $mobile)
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

public function check_mobile_number($mobile)
	{
	$data = $this->db->select('*')
					 ->from('users')
					 ->where('mobile', $mobile)
					 ->get()
					 ->row();
	if($data)
	{
		return false;
	}
	else
	{
		return true;
	}
}

	/*
	## insert data users tables
	*/
	public function registration($data)
	{
		$result = $this->db->insert('users',$data);
    	return $this->db->insert_id();
	}

	/*
	## Update company id
	*/
	public function setup_company_id($user)
	{
		$compid = date('m').date('d').$user;
		$data = array('compid'=> $compid);

		$this->db->where('uid', $user);
		$this->db->update('users', $data);
	}

	/*
	## get new user
	*/
	public function recent_user($user)
	{
		$data = $this->db->select('*')
						 ->from('users')
						 ->where('uid', $user)
						 ->get()
						 ->row();
		return $data;
	}
	
	public function recent_user_data($mobile)
	{
		$data = $this->db->select('*')
						 ->from('users')
						 ->where('mobile', $mobile)
						 ->get()
						 ->row();
		return $data;
	}

	/*
	## Get company profile for logged user
	*/
	public function get_company_profile($compid)
	{
		$data = $this->db->select('*')
						 ->from('com_profile')
						 ->where('compid', $compid)
						 ->get()
						 ->row();
		return $data;
	}
	
	/*
	## 
	*/
	public function check_email($email)
    {
      return $this->db->select('*')
                        ->from('users')
                        ->where('email',$email)
                        ->get()
                        ->row();
    }
    
    /*
	## Put request Password update
	*/
	public function put_password($user_id, $data)
	{
		$this->db->where('uid', $user_id);
		$this->db->update('users', $data);
		$updated_status = $this->db->affected_rows();

		if($updated_status):
		    return $user_id;
		else:
		    return false;
		endif;
	}
public function update_user_otp_data($odata,$mid)
	{
	    //var_dump($odata);var_dump($mid); exit();
	$this->db->where('mobile',$mid);
	$this->db->update('users',$odata);
}

public function otp_check($mobile,$otp)
	{
	  //var_dump($mobile);var_dump($otp); exit();
	$data = $this->db->select('uid')
					 ->from('users')
					 ->where('mobile', $mobile)
					 ->where('otp', $otp)
					 ->get()
					 ->row();

	return $data;
}

public function new_pasword_setup($info,$uid)
	{
	$this->db->where('uid', $uid);
	$this->db->update('users', $info);
}

public function update_data($table,$data = false,$where = false)
    {
    $this->db->update($table,$data,$where);
    
    return $this->db->affected_rows();
}

public function insert_data($table,$data)
    {
    $this->db->insert($table,$data);
    
    return $this->db->insert_id();
}




}