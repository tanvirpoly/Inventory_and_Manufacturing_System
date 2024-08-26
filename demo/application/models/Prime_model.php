<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prime_model extends CI_Model {

public function get_data($table,$where = false,$fields = false,$join_table = false,$other = false)
  {
  if ($fields != false)
    {
    foreach ($fields as $coll => $value)
      {
      $this->db->select($value);
      }
    }

  $this->db->from($table);

  if($join_table != false)
    {
    if(is_array($other) && array_key_exists('join',$other))
      {
      foreach($join_table as $coll => $value)
        {
        $this->db->join($coll, $value, $other['join']);
        }
      }
    else
      {
      foreach($join_table as $coll => $value)
        {
        $this->db->join($coll, $value);
        }
      }
    }

  if($where != false)
    {
    $this->db->where($where);
    }

  if($other != false)
    {
    if(array_key_exists('or_where', $other))
      {
      $this->db->or_where($other['or_where']);
      }
    if(array_key_exists('order_by', $other))
      {
      $this->db->order_by($other['order_by'], 'desc');
      }
    if(array_key_exists('group_by', $other))
      {
      $this->db->group_by($other['group_by']);
      }
    if(array_key_exists('limit', $other))
      {
      if(array_key_exists('offset', $other))
        {
        $this->db->limit($other['limit'], $other['offset']);
        }
      else
        {
        $this->db->limit($other['limit']);
        }
      }

    if(array_key_exists('like', $other))
      {
      foreach ($other['like'] as $key => $value)
        {
        $this->db->like($key, $value);
        }
      }
    if(array_key_exists('or_like', $other))
      {
      foreach ($other['or_like'] as $key => $value)
        {
        $this->db->or_like($key, $value);
        }
      }
    }
  $query = $this->db->get();

  $result = $query->result_array();

  return $result;
}

public function insert_data($table,$data)
  {
  $this->db->insert($table,$data);
  
  return $this->db->insert_id();
}

public function update_data($table,$data = false,$where = false)
  {
  $this->db->update($table,$data,$where);

  return $this->db->affected_rows();
}

public function delete_data($table, $where)
  {
  $this->db->where($where);
  $this->db->delete($table);
  
  return $this->db->affected_rows();
}

public function count_all($tbl)
  {
  return $this->db->count_all($tbl);
}

public function all_query($sql)
  {
  return $result = $this->db->query($sql)->result_array();
}

public function check_user_email($id)
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('email',$id)
                ->get();

  $count_row = $query->num_rows();

  if($count_row == 0)
    {
    return 1;
    }
  else
    {
    return 0;
    }
}

public function get_category_data($id)
  {
  $query = $this->db->select('*')
                ->from('categories')
                ->where('categoryID',$id)
                ->get()
                ->row();
  return $query;
}

public function get_unit_data($id)
  {
  $query = $this->db->select('*')
                ->from('sma_units')
                ->where('id',$id)
                ->get()
                ->row();
  return $query;
}

public function get_cost_type_data($id)
  {
  $query = $this->db->select("*")
                  ->from('cost_type')
                  ->where('ct_id',$id)
                  ->get()
                  ->row();

  return $query;  
}

public function get_dept_data($id)
  {
  $query = $this->db->select('*')
                  ->from('department')
                  ->where('dpt_id',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_bank_account($id)
  {
  $query = $this->db->select('*')
                ->from('bankaccount')
                ->where('ba_id',$id)
                ->get()
                ->row();
  return $query;
}

public function get_mobile_transaction($id)
  {
  $query = $this->db->select('*')
                ->from('mobileaccount')
                ->where('ma_id',$id)
                ->get()
                ->row();
  return $query;
}

public function get_user_notice()
  {
  $query = $this->db->select('*')
                    ->from('notice')
                    ->or_where('ntype','All')
                    ->or_where('ntype',$_SESSION['uid'])
                    ->order_by('nid','DESC')
                    ->get()
                    ->result();
  return $query;
}

public function get_user_role_data($id)
  {
  $query = $this->db->select('*')
                ->from('access_lavels')
                ->where('ax_id',$id)
                ->get()
                ->row();
  return $query;
}

public function get_customer_data($id)
  {
  $query = $this->db->select('*')
                  ->from('customers')
                  ->where('customerID',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_supplier_data($id)
  {
  $query = $this->db->select('*')
                  ->from('suppliers')
                  ->where('supplierID',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_emp_data($id)
  {
  $query = $this->db->select('*')
                  ->from('employees')
                  ->where('employeeID',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function get_employee()
  {
  $emp = $this->db->select('empid')
        ->from('users')
        ->where('compid',$_SESSION['compid'])
        ->get()
        ->result_array();
    //var_dump($emp); exit();
  $emp_id = array_map (function($value){
  return $value['empid'];
  },$emp);
    //var_dump($emp_id); exit();
  if($emp_id == NULL)
      {
      $empid = 0;
      }
  else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
  return $this->db->select('employeeID,employeeName')
              ->from('employees')
              ->where_not_in('employeeID',$empid)
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->result();
}

public function get_user_data($id)
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('uid',$id)
                ->get()
                ->row();
  return $query;
}

public function company_details()
  {
  $query = $this->db->select('*')
              ->from('com_profile')
              ->where('com_pid',1)
              ->get()
              ->row();
  return $query;  
}

public function supplier_purchases_due_details($id,$sid)
  {
  $query = $this->db->select("SUM(`due`) as total")
                  ->FROM('purchase')
                  ->where_not_in('purchaseID',$id)
                  ->where('supplier',$sid)
                  ->get()
                  ->row();
  return $query;  
}

public function supplier_paid_details($sid)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('supplier',$sid)
                  ->get()
                  ->row();
  return $query;  
}

public function customer_sales_due_details($id,$cusid)
  {
  $query = $this->db->select("SUM(`dueamount`) as total")
                  ->FROM('sales')
                  ->where_not_in('saleID',$id)
                  ->WHERE('customerID',$cusid)
                  ->get()
                  ->row();
  return $query;  
}

public function customer_vaucher_paid_details($cusid)
  {
  $query = $this->db->select('SUM(`totalamount`) as total')
                  ->from('vaucher')
                  ->where('customerID',$cusid)
                  ->where('vauchertype','Credit Voucher')
                  ->get()
                  ->row();
  return $query; 
}

public function customer_returns_details($cusid)
  {
  $query = $this->db->select('SUM(`paidAmount`) as total')
                  ->from('returns')
                  ->where('customerID',$cusid)
                  ->get()
                  ->row();
  return $query; 
}

public function get_profile_data()
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('uid',$_SESSION['uid'])
                ->get()
                ->row();
  return $query;
}

public function current_password_check($cpassword)
  {
  return $this->db->select('*')
                ->from('users')
                ->where('password',$cpassword)
                ->get()
                ->row();
}

public function get_sales_data()
  {
  $query = $this->db->select('
                          sales.*,
                          customers.cus_id,
                          customers.customerName,
                          users.empid,
                          users.name')
                  ->from('sales')
                  ->join('customers','customers.customerID = sales.customerID','left')
                  ->join('users','users.uid = sales.regby','left')
                  ->where('sales.compid',$_SESSION['compid'])
                  ->get()
                  ->result();
  return $query;  
}

public function get_dsales_data($sdate,$edate,$customer,$employee)
  {
  if ($customer == 'All' && $employee == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->where('sales.compid',$_SESSION['compid'])
                    ->get()
                    ->result();
    }
  else if ($customer == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->where('sales.regby',$employee)
                    ->get()
                    ->result();
    }
  else if ($employee == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->where('sales.customerID',$customer)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->where('sales.customerID',$customer)
                    ->where('sales.regby',$employee)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_msales_data($month,$year,$customer,$employee)
  {
  if ($customer == 'All' && $employee == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.compid',$_SESSION['compid'])
                    ->get()
                    ->result();
    }
  else if ($customer == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.regby',$employee)
                    ->get()
                    ->result();
    }
  else if ($employee == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.customerID',$customer)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.customerID',$customer)
                    ->where('sales.regby',$employee)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_ysales_data($year,$customer,$employee)
  {
  if($customer == 'All' && $employee == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.compid',$_SESSION['compid'])
                    ->get()
                    ->result();
    }
  else if($customer == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.regby',$employee)
                    ->get()
                    ->result();
    }
  else if ($employee == 'All')
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.customerID',$customer)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('
                            sales.*,
                            customers.cus_id,
                            customers.customerName,
                            users.empid,
                            users.name')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->join('users','users.uid = sales.regby','left')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sales.customerID',$customer)
                    ->where('sales.regby',$employee)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_purchses_data()
  {
  if($_SESSION['role'] <= 2)
    {
    $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->get()
                  ->result();
    }
  else
    {
    $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('purchase.regby',$_SESSION['uid'])
                  ->get()
                  ->result();
    }
  return $query;
}

public function get_dpurchses_data($sdate,$edate,$supplier)
  {
  if($_SESSION['role'] <= 2)
    {
    if($supplier == 'All')
      {
      $query = $this->db->select('
                        purchase.*,
                        suppliers.sup_id,
                        suppliers.supplierName')
                ->from('purchase')
                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                ->where('purchase.purchaseDate >=',$sdate)
                ->where('purchase.purchaseDate <=',$edate)
                ->get()
                ->result();
      }
    else
      {
      $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('purchase.purchaseDate >=',$sdate)
                  ->where('purchase.purchaseDate <=',$edate)
                  ->where('purchase.supplier',$supplier)
                  ->get()
                  ->result();
      }
    }
  else
    {
    if($supplier == 'All')
      {
      $query = $this->db->select('
                        purchase.*,
                        suppliers.sup_id,
                        suppliers.supplierName')
                ->from('purchase')
                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                ->where('purchase.purchaseDate >=',$sdate)
                ->where('purchase.purchaseDate <=',$edate)
                ->where('purchase.regby',$_SESSION['uid'])
                ->get()
                ->result();
      }
    else
      {
      $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('purchase.purchaseDate >=',$sdate)
                  ->where('purchase.purchaseDate <=',$edate)
                  ->where('purchase.supplier',$supplier)
                  ->where('purchase.regby',$_SESSION['uid'])
                  ->get()
                  ->result();
      }
    }
  return $query;  
}

public function get_mpurchses_data($month,$year,$supplier)
  {
  if($_SESSION['role'] <= 2)
    {
    if($supplier == 'All')
      {
      $query = $this->db->select('
                        purchase.*,
                        suppliers.sup_id,
                        suppliers.supplierName')
                ->from('purchase')
                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                ->where('MONTH(purchaseDate)',$month)
                ->where('YEAR(purchaseDate)',$year)
                ->get()
                ->result();
      }
    else
      {
      $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('MONTH(purchaseDate)',$month)
                  ->where('YEAR(purchaseDate)',$year)
                  ->where('purchase.supplier',$supplier)
                  ->get()
                  ->result();
      }
    }
  else
    {
    if($supplier == 'All')
      {
      $query = $this->db->select('
                        purchase.*,
                        suppliers.sup_id,
                        suppliers.supplierName')
                ->from('purchase')
                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                ->where('MONTH(purchaseDate)',$month)
                ->where('YEAR(purchaseDate)',$year)
                ->where('purchase.regby',$_SESSION['uid'])
                ->get()
                ->result();
      }
    else
      {
      $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('MONTH(purchaseDate)',$month)
                  ->where('YEAR(purchaseDate)',$year)
                  ->where('purchase.supplier',$supplier)
                  ->where('purchase.regby',$_SESSION['uid'])
                  ->get()
                  ->result();
      }
    }
    
  return $query;  
}

public function get_ypurchses_data($year,$supplier)
  {
   if($_SESSION['role'] <= 2)
    {
    if($supplier == 'All')
      {
      $query = $this->db->select('
                        purchase.*,
                        suppliers.sup_id,
                        suppliers.supplierName')
                ->from('purchase')
                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                ->where('YEAR(purchaseDate)',$year)
                ->get()
                ->result();
      }
    else
      {
      $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('YEAR(purchaseDate)',$year)
                  ->where('purchase.supplier',$supplier)
                  ->get()
                  ->result();
      }
    }
  else
    {
    if($supplier == 'All')
      {
      $query = $this->db->select('
                        purchase.*,
                        suppliers.sup_id,
                        suppliers.supplierName')
                ->from('purchase')
                ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                ->where('YEAR(purchaseDate)',$year)
                ->where('purchase.regby',$_SESSION['uid'])
                ->get()
                ->result();
      }
    else
      {
      $query = $this->db->select('
                          purchase.*,
                          suppliers.sup_id,
                          suppliers.supplierName')
                  ->from('purchase')
                  ->join('suppliers','suppliers.supplierID = purchase.supplier','left')
                  ->where('YEAR(purchaseDate)',$year)
                  ->where('purchase.supplier',$supplier)
                  ->where('purchase.regby',$_SESSION['uid'])
                  ->get()
                  ->result();
      }
    }
  return $query;  
}

public function total_sales_amount()
  {
  $query = $this->db->select("SUM(paidAmount) as total,SUM(totalAmount) as ttotal")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
  return $query;  
}

public function total_purchases_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total,SUM(`totalPrice`) as ttotal")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
  return $query;  
}

public function total_emp_payments_amount()
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
  return $query;  
}

public function total_returns_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
  return $query;  
}

public function total_cvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->get()
                  ->row();
  return $query;  
}

public function total_dvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->get()
                  ->row();
  return $query;  
}

public function total_svoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->get()
                  ->row();
  return $query;  
}

public function total_dsales_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('sales.saleDate >=', $sdate)
                  ->where('sales.saleDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dpurchases_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('purchaseDate >=', $sdate)
                  ->where('purchaseDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_demp_payments_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('regdate >=', $sdate)
                  ->where('regdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dreturns_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('returnDate >=', $sdate)
                  ->where('returnDate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dcvoucher_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ddvoucher_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_dsvoucher_amount($sdate,$edate)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->get()
                  ->row();
  return $query;  
}

public function total_msales_amount($month,$year)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('MONTH(sales.regdate)',$month)
                  ->where('YEAR(sales.regdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mpurchases_amount($month,$year)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('MONTH(purchaseDate)',$month)
                  ->where('YEAR(purchaseDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_memp_payments_amount($month,$year)
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('MONTH(regdate)',$month)
                  ->where('YEAR(regdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mreturns_amount($month,$year)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('MONTH(returnDate)',$month)
                  ->where('YEAR(returnDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mcvoucher_amount($month,$year)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('MONTH(voucherdate)',$month)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_mdvoucher_amount($month,$year)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('MONTH(voucherdate)',$month)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_msvoucher_amount($month,$year)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('MONTH(voucherdate)',$month)
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ysales_amount($year)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('YEAR(sales.regdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ypurchases_amount($year)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('YEAR(purchaseDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_yemp_payments_amount($year)
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('YEAR(regdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_yreturns_amount($year)
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->where('YEAR(returnDate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ycvoucher_amount($year)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ydvoucher_amount($year)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function total_ysvoucher_amount($year)
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->WHERE('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('YEAR(voucherdate)',$year)
                  ->get()
                  ->row();
  return $query;  
}

public function check_email($empemail)
  {
  return $this->db->select('*')
                    ->from('users')
                    ->where('email',$empemail)
                    ->get()
                    ->row();
}

public function check_mobile_number($mid)
  {
  return $this->db->select('*')
                    ->from('users')
                    ->where('mobile',$mid)
                    ->get()
                    ->row();
}

public function sales_cust_ledger_data($customer)
  {
  $query = $this->db->select("*")
                  ->FROM('sales')
                  ->WHERE('customerID',$customer)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_cust_ledger_data($customer)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('customerID',$customer)
                  ->where('vauchertype','Credit Voucher')
                  ->get()
                  ->result();
  return $query;  
}

public function return_cust_ledger_data($customer)
  {
  $query = $this->db->select("*")
                  ->FROM('returns')
                  ->WHERE('customerID',$customer)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_dcust_ledger_data($customer,$sdate,$edate)
  {
  $query = $this->db->select("*")
                  ->FROM('sales')
                  ->WHERE('customerID',$customer)
                  ->where('saleDate >=', $sdate)
                  ->where('saleDate <=', $edate)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_dcust_ledger_data($customer,$sdate,$edate)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('customerID',$customer)
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->where('vauchertype','Credit Voucher')
                  ->get()
                  ->result();
  return $query;  
}

public function return_dcust_ledger_data($customer,$sdate,$edate)
  {
  $query = $this->db->select("*")
                  ->FROM('returns')
                  ->WHERE('customerID',$customer)
                  ->where('returnDate >=', $sdate)
                  ->where('returnDate <=', $edate)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_mcust_ledger_data($customer,$month,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('sales')
                  ->WHERE('customerID',$customer)
                  ->where('MONTH(saleDate)',$month)
                  ->where('YEAR(saleDate)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_mcust_ledger_data($customer,$month,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('customerID',$customer)
                  ->where('MONTH(voucherdate)',$month)
                  ->where('YEAR(voucherdate)',$year)
                  ->where('vauchertype','Credit Voucher')
                  ->get()
                  ->result();
  return $query;  
}

public function return_mcust_ledger_data($customer,$month,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('returns')
                  ->WHERE('customerID',$customer)
                  ->where('MONTH(returnDate)',$month)
                  ->where('YEAR(returnDate)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function sales_ycust_ledger_data($customer,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('sales')
                  ->WHERE('customerID',$customer)
                  ->where('YEAR(saleDate)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function voucher_ycust_ledger_data($customer,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('vaucher')
                  ->WHERE('customerID',$customer)
                  ->where('YEAR(voucherdate)',$year)
                  ->where('vauchertype','Credit Voucher')
                  ->get()
                  ->result();
  return $query;  
}

public function return_ycust_ledger_data($customer,$year)
  {
  $query = $this->db->select("*")
                  ->FROM('returns')
                  ->WHERE('customerID',$customer)
                  ->where('YEAR(returnDate)',$year)
                  ->get()
                  ->result();
  return $query;  
}

public function get_voucher_data()
  {
  if($_SESSION['role'] <= 2)
    {
    $query = $this->db->select("*")
                  ->from('vaucher')
                  ->get()
                  ->result();
    }
  else
    {
    $query = $this->db->select("*")
                  ->from('vaucher')
                  ->where('regby',$_SESSION['uid'])
                  ->get()
                  ->result();
    }
  return $query;  
}

public function get_dall_voucher_data($sdate,$edate,$vtype)
  {
  if($_SESSION['role'] <= 2)
    {
  if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->where('vauchertype',$vtype)
                    ->get()
                    ->result();
    }
    }
  else
    {
    if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->where('regby',$_SESSION['uid'])
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('voucherdate >=', $sdate)
                    ->where('voucherdate <=', $edate)
                    ->where('vauchertype',$vtype)
                    ->where('regby',$_SESSION['uid'])
                    ->get()
                    ->result();
    }
    }
  return $query;  
}

public function get_mall_voucher_data($month,$year,$vtype)
  {
  if($_SESSION['role'] <= 2)
    {
    if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->where('vauchertype',$vtype)
                    ->get()
                    ->result();
    }
    }
  else
    {
    if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->where('regby',$_SESSION['uid'])
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    ->where('vauchertype',$vtype)
                    ->where('regby',$_SESSION['uid'])
                    ->get()
                    ->result();
    }
    }
  
  return $query;  
}

public function get_yall_voucher_data($year,$vtype)
  {
  if($_SESSION['role'] <= 2)
    {
    if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('YEAR(voucherdate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('YEAR(voucherdate)',$year)
                    ->where('vauchertype',$vtype)
                    ->get()
                    ->result();
    }
    }
  else
    {
    if($vtype == 'All')
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('YEAR(voucherdate)',$year)
                    ->where('regby',$_SESSION['uid'])
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("*")
                    ->from('vaucher')
                    ->where('YEAR(voucherdate)',$year)
                    ->where('vauchertype',$vtype)
                    ->where('regby',$_SESSION['uid'])
                    ->get()
                    ->result();
    }
    }
  return $query;  
}

public function today_sales_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->where('saleDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_purchases_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->where('purchaseDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_emp_payments_amount()
  {
  $d = date('d');
  $m = date('m');
  $y = date('Y');
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$_SESSION['compid'])
                  ->where('DAY(regdate)',$d)
                  ->where('MONTH(regdate)',$m)
                  ->where('YEAR(regdate)',$y)
                  ->get()
                  ->row();
  return $query;  
}

public function today_returns_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->where('returnDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_cvoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_dvoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_svoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_sales_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->where('saleDate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_purchases_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->where('purchaseDate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_emp_payments_amount()
  {
  $d = date('d');
  $m = date('m');
  $y = date('Y');
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$_SESSION['compid'])
                  ->where('DAY(regdate) <',$d)
                  ->where('MONTH(regdate) <=',$m)
                  ->where('YEAR(regdate) <=',$y)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_returns_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->where('returnDate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_cvoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_dvoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function pre_svoucher_amount()
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate <',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function get_dspurchase_data($sdate,$edate,$sid)
  {
  $query = $this->db->select('*')
                  ->from('purchase')
                  ->where('purchaseDate >=', $sdate)
                  ->where('purchaseDate <=', $edate)
                  ->where('supplier',$sid)
                  ->get()
                  ->result();

  return $query;  
}

public function get_dsvoucher_data($sdate,$edate,$sid)
  {
  $query = $this->db->select('*')
                  ->from('vaucher')
                  ->where('voucherdate >=', $sdate)
                  ->where('voucherdate <=', $edate)
                  ->where('supplier',$sid)
                  ->where_not_in('vauchertype','Credit Voucher')
                  ->get()
                  ->result();

  return $query;  
}

public function get_mspurchase_data($month,$year,$sid)
  {
  $query = $this->db->select('*')
                  ->from('purchase')
                  ->where('MONTH(purchaseDate)',$month)
                  ->where('YEAR(purchaseDate)',$year)
                  ->where('supplier',$sid)
                  ->get()
                  ->result();

  return $query;  
}

public function get_msvoucher_data($month,$year,$sid)
  {
  $query = $this->db->select('*')
              ->from('vaucher')
              ->where('MONTH(voucherdate)',$month)
              ->where('YEAR(voucherdate)',$year)
              ->where('supplier',$sid)
              ->where_not_in('vauchertype','Credit Voucher')
              ->get()
              ->result();

  return $query;  
}

public function get_yspurchase_data($year,$sid)
  {
  $query = $this->db->select('*')
              ->from('purchase')
              ->where('YEAR(purchaseDate)',$year)
              ->where('supplier',$sid)
              ->get()
              ->result();

  return $query;  
}

public function get_ysvoucher_data($year,$sid)
  {
  $query = $this->db->select('*')
              ->from('vaucher')
              ->where('YEAR(voucherdate)',$year)
              ->where('supplier',$sid)
              ->where_not_in('vauchertype','Credit Voucher')
              ->get()
              ->result();

  return $query;  
}

public function total_category()
  {
  $query = $this->db->select('*')
                ->from('categories')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_unit()
  {
  $query = $this->db->select('*')
                ->from('sma_units')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_expense_type()
  {
  $query = $this->db->select('*')
                ->from('cost_type')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_depertment()
  {
  $query = $this->db->select('*')
                ->from('department')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_bank_account()
  {
  $query = $this->db->select('*')
                ->from('bankaccount')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_mobile_account()
  {
  $query = $this->db->select('*')
                ->from('mobileaccount')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_notice()
  {
  $query = $this->db->select('*')
                ->from('notice')
                ->or_where('ntype','All')
                ->or_where('ntype',$_SESSION['uid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_user_type()
  {
  $query = $this->db->select('*')
                ->from('access_lavels')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function product_fetch_data()
  {
  $this->db->order_by("productID","DESC");
  $this->db->where('compid',$_SESSION['compid']);
  $query = $this->db->get("products");
  
  return $query->result();
}

public function insert_product_data($data)
  {
  $this->db->insert_batch('products',$data);
}

public function get_purchase_payment($id)
  {
  $query = $this->db->select('paidAmount,due')
              ->from('purchase')
              ->where('purchaseID',$id)
              ->get()
              ->row();
  return $query; 
}

public function get_sales_payment($id)
  {
  $query = $this->db->select('paidAmount,dueamount')
              ->from('sales')
              ->where('saleID',$id)
              ->get()
              ->row();
  return $query; 
}

public function total_customer()
  {
  $query = $this->db->select('*')
                ->from('customers')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_supplier()
  {
  $query = $this->db->select('*')
                ->from('suppliers')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_employee()
  {
  $query = $this->db->select('*')
                ->from('employees')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_user()
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('compid',$_SESSION['compid'])
                ->get();

  $count_row = $query->num_rows();

  return $count_row;
}

public function total_products()
  {
  $query = $this->db->select('*')
                ->from('products')
                ->where('compid',$_SESSION['compid'])
                ->get();

    $count_row = $query->num_rows();

  return $count_row;
}

public function total_sale()
  {
  $query = $this->db->select("SUM(`totalAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
  return $query;  
}

public function total_purchase()
  {
  $query = $this->db->select("SUM(`totalPrice`) as total")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
  return $query;  
}

public function total_stock()
  {
  $query = $this->db->select('SUM(`totalPices`) as total')
                ->from('stock')
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->row();
  return $query;
}

public function total_rawstock()
  {
  $pType = 'Raw Material';
        
  $query = $this->db->select('SUM(stock.totalPices) as total,products.pType')
                ->from('stock')
                ->join('products','products.productID = stock.product','left')
                ->where('pType',$pType)
                ->get()
                ->row();
  return $query;
}

public function total_finishstock()
  {
  $pType = 'Finish Good';
  $query = $this->db->select('SUM(stock.totalPices) as total,products.pType')
                ->from('stock')
                ->join('products','products.productID = stock.product','left')
                ->where('pType',$pType)
                ->get()
                ->row();
  return $query;
}

public function total_voucher()
    {
    $query = $this->db->select("SUM(`totalamount`) as total")
                    ->FROM('vaucher')
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->row();
    return $query;  
}

public function get_stock_data($id)
  {
  $query = $this->db->select('totalPices')
                ->from('stock')
                ->where('product',$id)
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->row();
  return $query;
}

public function customer_fetch_data($compid)
  {
  $this->db->where('compid',$compid);
  $query = $this->db->get("customers");
  return $query->result();
}

public function insert_customer_data($data)
  {
  $this->db->insert_batch('customers',$data);
}

public function supplier_fetch_data($compid)
  {
  $this->db->order_by("supplierID","DESC");
  $this->db->where('compid',$compid);
  $query = $this->db->get("suppliers");
  return $query->result();
}

public function insert_supplier_data($data)
  {
  $this->db->insert_batch('suppliers',$data);
}

public function count_all_user()
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('userrole',2)
                ->get();

  $count_row = $query->num_rows();
  return $count_row;
}

public function count_all_active_user()
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('userrole',2)
                ->where('status','Active')
                ->get();

  $count_row = $query->num_rows();
  return $count_row;
}

public function count_all_inactive_user()
  {
  $query = $this->db->select('*')
                ->from('users')
                ->where('userrole',2)
                ->where('status','Inactive')
                ->get();

  $count_row = $query->num_rows();
  return $count_row;
}

public function count_all_today_user()
  {
  $d = date('d'); $m = date('m'); $y = date('Y');

  $query = $this->db->select('*')
                ->from('users')
                ->where('userrole',2)
                ->where('DAY(regdate)',$d)
                ->where('MONTH(regdate)',$m)
                ->where('YEAR(regdate)',$y)
                ->get();

  $count_row = $query->num_rows();
  return $count_row;
}

public function count_all_month_user()
  {
  $m = date('m'); $y = date('Y');

  $query = $this->db->select('*')
                ->from('users')
                ->where('userrole',2)
                ->where('MONTH(regdate)',$m)
                ->where('YEAR(regdate)',$y)
                ->get();

  $count_row = $query->num_rows();
  return $count_row;
}

public function graph_data_point()
  {
  $date_arr = $this->getLastNDays(7, 'Y-m-d');
  $dataPoints = array();

  for($i = 0; $i < 7; $i++)
    {
    array_push($dataPoints, array("y" => $this->get_today_sale(preg_replace('/[^A-Za-z0-9\-]/','',$date_arr[$i])),"label" => preg_replace('/[^A-Za-z0-9\-]/','',$date_arr[$i])));
    }

    return $dataPoints;
}

public function get_today_sale($date)
  {
  $query = $this->db->select("SUM(`totalAmount`) as total")
                  ->FROM('sales')
                  ->where('saleDate',$date)
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();

  if($query->total)
    {
    return $query->total;
    }
  else
    {
    $dt = 0;
    return $dt;
    }
}

public function getLastNDays($days, $format = 'd-m')
  {
  $m = date("m"); $de= date("d"); $y= date("Y");
  $dateArray = array();
  for($i=0; $i<=$days-1; $i++)
    {
    $dateArray[] = '"'.date($format, mktime(0,0,0,$m,($de-$i),$y)).'"'; 
    }
  return array_reverse($dateArray);
}

public function get_page_and_function()
  {
  $query = $this->db->select('
              tbl_page_functions.pfunc_id,
              tbl_page_functions.pageid,
              tbl_page_functions.fcname,
              tbl_pages.pageid,
              tbl_pages.master_page,
              tbl_pages.cname,
              tbl_master_page_title.master_id,
              tbl_master_page_title.c_master_title')
            ->from('tbl_pages')
            ->join('tbl_master_page_title','tbl_master_page_title.master_id = tbl_pages.master_page','left')
            ->join('tbl_page_functions','tbl_page_functions.pageid = tbl_pages.pageid','left')
            ->get()
            ->result();
  return $query;
}

public function saveNewMaster_data($data)
  {
  $column = $data['master_title'] ;
  $table = 'tbl_user_m_permission';

  $fields = array(
    'preferences' => array('type' => 'INT','constraint' => 5 )
      );

  $fields2 = array(
    'preferences' => array(
      'name' => $column ,
      'type' => 'INT',
      'constraint' => 5
        ),
      );
    // $add = mysql_query("ALTER TABLE $table ADD $column INT( 1 ) NOT NULL");
  $this->load->dbforge();
  $this->dbforge->add_column('tbl_user_m_permission',$fields);

  $this->load->dbforge();
  $add = $this->dbforge->modify_column('tbl_user_m_permission',$fields2);
  // var_dump($add); exit();
  return $this->db->insert('tbl_master_page_title', $data); 
}

public function saveNewPage_data($data)
  {
  $column = $data['pagename'] ;
  $table = 'tbl_user_p_permission';

  $fields = array(
    'preferences' => array('type' => 'INT','constraint' => 5 )
      );

  $fields2 = array(
    'preferences' => array(
      'name' => $column,
      'type' => 'INT',
      'constraint' => 5
        ),
      );
    // $add = mysql_query("ALTER TABLE $table ADD $column INT( 1 ) NOT NULL");
  $this->load->dbforge();
  $this->dbforge->add_column('tbl_user_p_permission',$fields);

  $this->load->dbforge();
  $add = $this->dbforge->modify_column('tbl_user_p_permission',$fields2);
    // var_dump($add); exit();
  return $this->db->insert('tbl_pages', $data); 
}

public function saveNewPageFunction_data($data)
  {
  $column = $data['pfunc_name'] ;
  $table = 'tbl_user_f_permission';

  $fields = array(
    'preferences' => array('type' => 'INT','constraint' => 5 )
      );

  $fields2 = array(
    'preferences' => array(
      'name' => $column,
      'type' => 'INT',
      'constraint' => 5
        ),
      );
    // $add = mysql_query("ALTER TABLE $table ADD $column INT( 1 ) NOT NULL");
  $this->load->dbforge();
  $this->dbforge->add_column('tbl_user_f_permission',$fields);

  $this->load->dbforge();
  $add = $this->dbforge->modify_column('tbl_user_f_permission', $fields2);
    // var_dump($add); exit();
  return $this->db->insert('tbl_page_functions',$data); 
}

public function get_page_data_by_master($id)
  {
  $query = $this->db->select('*')
            ->from('tbl_pages')
            ->where('master_page',$id)
            ->get()
            ->result();
  return $query;
}

public function get_user_permission_data()
  {
  $emp = $this->db->select('compid')
                ->from('tbl_user_m_permission')
                ->get()
                ->result_array();
  //var_dump($emp); exit();
  $emp_id = array_map (function($value){
    return $value['compid'];
    },$emp);

  if ($emp_id == null) {
    $emp_id = 0;
    }

  $emps = $this->db->select('compid,name,compname')
                ->from('users')
                ->where_not_in('compid',$emp_id)
                ->where('userrole',2)
                ->get()
                ->result();
  return $emps;
}

public function total_sales_product()
  {
  $query = $this->db->select("
                        SUM(sale_product.quantity) as tq,
                        SUM(sale_product.totalPrice) as ta,
                        sale_product.productID,
                        sales.compid")
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID','left')
                    ->group_by('productID')
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();
  return $query;
}

public function total_dsales_product($sdate,$edate)
  {
  $query = $this->db->select("
                        SUM(sale_product.quantity) as tq,
                        SUM(sale_product.totalPrice) as ta,
                        sale_product.productID,
                        sales.compid")
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID','left')
                    ->where('compid',$_SESSION['compid'])
                    ->where('saleDate >=', $sdate)
                    ->where('saleDate <=', $edate)
                    ->group_by('productID')
                    ->get()
                    ->result();
  return $query;
}

public function total_msales_product($month,$year)
  {
  $query = $this->db->select("
                        SUM(sale_product.quantity) as tq,
                        SUM(sale_product.totalPrice) as ta,
                        sale_product.productID,
                        sales.compid")
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID','left')
                    ->where('compid',$_SESSION['compid'])
                    ->where('MONTH(sale_product.regdate)',$month)
                    ->where('YEAR(sale_product.regdate)',$year)
                    ->group_by('productID')
                    ->get()
                    ->result();
  return $query;
}

public function total_ysales_product($year)
  {
  $query = $this->db->select("
                        SUM(sale_product.quantity) as tq,
                        SUM(sale_product.totalPrice) as ta,
                        sale_product.productID,
                        sales.compid")
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID','left')
                    ->where('compid',$_SESSION['compid'])
                    ->where('YEAR(sale_product.regdate)',$year)
                    ->group_by('productID')
                    ->get()
                    ->result();
  return $query;
}

public function get_help_reply_data($id)
  {
  $query = $this->db->select("help_support_reply.reply,users.name")
                    ->from('help_support_reply')
                    ->join('users','users.uid = help_support_reply.regby','left')
                    ->where('hp_id',$id)
                    ->get()
                    ->result();
  return $query;
}

public function get_user_notice_data($id)
  {
  $query = $this->db->select('*')
                  ->from('notice')
                  ->where('nid',$id)
                  ->get()
                  ->row();
  return $query; 
}

public function today_sales($cid)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalAmount`) as total,SUM(`paidAmount`) as ptotal")
                  ->FROM('sales')
                  ->where('compid',$cid)
                  ->where('saleDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_purchases($cid)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalPrice`) as total,SUM(`paidAmount`) as ptotal")
                  ->FROM('purchase')
                  ->where('compid',$cid)
                  ->where('purchaseDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_emp_payments($cid)
  {
  $d = date('d');
  $m = date('m');
  $y = date('Y');
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$cid)
                  ->where('DAY(regdate)',$d)
                  ->where('MONTH(regdate)',$m)
                  ->where('YEAR(regdate)',$y)
                  ->get()
                  ->row();
  return $query;  
}

public function today_returns($cid)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$cid)
                  ->where('returnDate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_cvouchers($cid)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$cid)
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_dvouchers($cid)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$cid)
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function today_svouchers($cid)
  {
  $date = date('Y-m-d');
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$cid)
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('voucherdate',$date)
                  ->get()
                  ->row();
  return $query;  
}

public function cash_sales_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function cash_purchases_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function cash_cvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function cash_dvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function cash_svoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function cash_emp_payments_amount()
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function cash_returns_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_sales_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_purchases_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_cvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_dvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_svoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_emp_payments_amount()
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function bank_returns_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Bank')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_sales_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_purchases_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_cvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Credit Voucher')
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_dvoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Debit Voucher')
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_svoucher_amount()
  {
  $query = $this->db->select("SUM(`totalamount`) as total")
                  ->FROM('vaucher')
                  ->where('compid',$_SESSION['compid'])
                  ->WHERE('vauchertype','Supplier Pay')
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_emp_payments_amount()
  {
  $query = $this->db->select("SUM(`salary`) as total")
                  ->FROM('employee_payment')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function mobile_returns_amount()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total")
                  ->FROM('returns')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Mobile')
                  ->get()
                  ->row();
  return $query;  
}

public function cost_type_data()
  {
  $query = $this->db->select("*")
                  ->FROM('cost_type')
                  ->where('compid',$_SESSION['compid'])
                  ->or_where('compid','All')
                  ->get()
                  ->result();
  return $query;  
}

public function get_sma_units_data()
  {
  $query = $this->db->select("*")
                  ->FROM('sma_units')
                  ->get()
                  ->result();
  return $query;  
}

public function get_salary_emp($id,$id2,$id3)
  {
  $emp = $this->db->select('empid')
                ->from('employee_payment')
                ->where('month',$id)
                ->where('year',$id2)
                ->where('empid',$id3)
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->row();
  //var_dump($emp); exit();
//   $emp_id = array_map (function($value)
//     {
//     return $value['empid'];
//     },$emp);

  if($emp)
    {
    $empid = $emp->empid;
    }
  else
    {
    $empid = $id3;
    }

  $emps = $this->db->select('
                    employees.employeeID,
                    employees.employeeName,
                    employees.joiningDate,
                    employees.salary,
                    department.dept_name,
                    SUM(employee_payment.salary) as total')
                ->from('employees')
                ->join('department','department.dpt_id = employees.dpt_id','left')
                ->join('employee_payment','employee_payment.empid = employees.employeeID','left')
                ->where('employees.employeeID',$empid)
                ->where('employees.compid',$_SESSION['compid'])
                ->get()
                ->row();
  return $emps;
}

public function get_page_setting_data($id)
  {
  $emps = $this->db->select('*')
                ->from('page_setting')
                ->where('psid',$id)
                ->get()
                ->row();
  return $emps;
}

public function get_service_info_data($id)
  {
  $query = $this->db->select('*')
                ->from('service_info')
                ->where('siid',$id)
                ->get()
                ->row();
  return $query;
}



public function user_dorder_ledger($sdate,$edate)
  {
    $query = $this->db->select('*')
                ->from('order')
                ->where('Date(regdate) >=',$sdate)
                ->where('Date(regdate) <=',$edate)
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query;  
}

public function user_morder_ledger($month,$year)
  {
    $query = $this->db->select('*')
                ->from('order')
                ->where('MONTH(regdate)',$month)
                ->where('YEAR(regdate)',$year)
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query;  
}

public function user_yorder_ledger($year)
  {
    $query = $this->db->select('*')
                ->from('order')
                ->where('YEAR(regdate)',$year)
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query;  
}

public function user_aorder_ledger()
  {
  $query = $this->db->select('*')
                ->from('order')
                ->where('compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query;  
}

public function sales_adata()
  {
  $query = $this->db->select('*')
                  ->from('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->result();
  return $query;  
}

public function sales_ddata($sdate,$edate)
  {
    $query = $this->db->select('*')
                    ->from('sales')
                    ->where('saleDate >=',$sdate)
                    ->where('saleDate <=',$edate)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();
  return $query;  
}

public function sales_mdata($month,$year)
  {
    $query = $this->db->select('*')
                    ->from('sales')
                    ->where('MONTH(saleDate)',$month)
                    ->where('YEAR(saleDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();
  return $query;  
}

public function sales_ydata($year)
  {
    $query = $this->db->select('*')
                    ->from('sales')
                    ->where('YEAR(saleDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function sales_due_adata()
  {
  $query = $this->db->select('sales.*,customers.customerName,customers.mobile,')
                  ->from('sales')
                  ->join('customers','customers.customerID = sales.customerID','left')
                  ->where('totalAmount > paidAmount')
                  ->where('sales.compid',$_SESSION['compid'])
                  ->get()
                  ->result();
  return $query;  
}

public function sales_due_ddata($sdate,$edate)
  {
    $query = $this->db->select('sales.*,customers.customerName,customers.mobile,')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->where('totalAmount > paidAmount')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('saleDate >=',$sdate)
                    ->where('saleDate <=',$edate)
                    ->get()
                    ->result();
  return $query;  
}

public function sales_due_mdata($month,$year)
  {
    $query = $this->db->select('sales.*,customers.customerName,customers.mobile,')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->where('totalAmount > paidAmount')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('MONTH(saleDate)',$month)
                    ->where('YEAR(saleDate)',$year)
                    ->get()
                    ->result();
  return $query;  
}

public function sales_due_ydata($year)
  {
    $query = $this->db->select('sales.*,customers.customerName,customers.mobile,')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID','left')
                    ->where('totalAmount > paidAmount')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('YEAR(saleDate)',$year)
                    ->get()
                    ->result();

  return $query;  
}

public function get_top_sales_product_data()
    {
    $query = $this->db->select('sales.compid,products.productName,products.productcode,SUM(sale_product.quantity) as total')
                    ->from('sale_product')
                    ->join('products','products.productID = sale_product.productID','left')
                    ->join('sales','sales.saleID = sale_product.saleID','left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->group_by('sale_product.productID')
                    ->order_by('total','DESC')
                    ->get()
                    ->result();

  return $query;  
}




public function get_cost_report_data()
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.vauchertype','Debit Voucher')
                ->where('vaucher.compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query; 
}

public function get_dcost_report_data($sdate,$edate,$vtype)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.vauchertype','Debit Voucher')
                ->where('DATE(voucherdate) >=',$sdate)
                ->where('DATE(voucherdate) <=',$edate)
                ->where('vaucher.costType',$vtype)
                ->where('vaucher.compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query; 
}

public function get_mcost_report_data($month,$year,$vtype)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.vauchertype','Debit Voucher')
                ->where('MONTH(vaucher.voucherdate)',$month)
                ->where('YEAR(vaucher.voucherdate)',$year)
                ->where('vaucher.costType',$vtype)
                ->where('vaucher.compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query; 
}

public function get_ycost_report_data($year,$vtype)
  {
  $query = $this->db->select('vaucher.*,cost_type.costName')
                ->from('vaucher')
                ->join('cost_type','cost_type.ct_id = vaucher.costType','left')
                ->where('vaucher.vauchertype','Debit Voucher')
                ->where('YEAR(vaucher.voucherdate)',$year)
                ->where('vaucher.costType',$vtype)
                ->where('vaucher.compid',$_SESSION['compid'])
                ->get()
                ->result();
  return $query; 
}

public function get_bank_purchase_data()
  {
  $query = $this->db->select('*')
                    ->from('purchase')
                    ->where('accountType','Bank')
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_sale_data()
  {
  $query = $this->db->select('*')
                    ->from('sales')
                    ->where('accountType','Bank')
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_sreturn_data()
  {
  $query = $this->db->select('*')
                    ->from('returns')
                    ->where('accountType','Bank')
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_preturn_data()
  {
  $query = $this->db->select('*')
                    ->from('preturns')
                    ->where('accountType','Bank')
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_voucher_data()
  {
  $query = $this->db->select('*')
                    ->from('vaucher')
                    ->where('accountType','Bank')
                    //->where('status',1)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_dpurchase_data($sdate,$edate)
  {
  $query = $this->db->select('*')
                    ->from('purchase')
                    ->where('accountType','Bank')
                    ->where('purchaseDate >=',$sdate)
                    ->where('purchaseDate <=',$edate)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_dsale_data($sdate,$edate)
  {
  $query = $this->db->select('*')
                    ->from('sales')
                    ->where('accountType','Bank')
                    ->where('saleDate >=',$sdate)
                    ->where('saleDate <=',$edate)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_dsreturn_data($sdate,$edate)
  {
  $query = $this->db->select('*')
                    ->from('returns')
                    ->where('accountType','Bank')
                    ->where('returnDate >=',$sdate)
                    ->where('returnDate <=',$edate)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_dpreturn_data($sdate,$edate)
  {
  $query = $this->db->select('*')
                    ->from('preturns')
                    ->where('accountType','Bank')
                    ->where('prDate >=',$sdate)
                    ->where('prDate <=',$edate)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_dvoucher_data($sdate,$edate)
  {
  $query = $this->db->select('*')
                    ->from('vaucher')
                    ->where('accountType','Bank')
                    ->where('voucherdate >=',$sdate)
                    ->where('voucherdate <=',$edate)
                    //->where('status',1)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_mpurchase_data($month,$year)
  {
  $query = $this->db->select('*')
                    ->from('purchase')
                    ->where('accountType','Bank')
                    ->where('MONTH(purchaseDate)',$month)
                    ->where('YEAR(purchaseDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_msale_data($month,$year)
  {
  $query = $this->db->select('*')
                    ->from('sales')
                    ->where('accountType','Bank')
                    ->where('MONTH(saleDate)',$month)
                    ->where('YEAR(saleDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_msreturn_data($month,$year)
  {
  $query = $this->db->select('*')
                    ->from('returns')
                    ->where('accountType','Bank')
                    ->where('MONTH(returnDate)',$month)
                    ->where('YEAR(returnDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_mpreturn_data($month,$year)
  {
  $query = $this->db->select('*')
                    ->from('preturns')
                    ->where('accountType','Bank')
                    ->where('MONTH(prDate)',$month)
                    ->where('YEAR(prDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_mvoucher_data($month,$year)
  {
  $query = $this->db->select('*')
                    ->from('vaucher')
                    ->where('accountType','Bank')
                    ->where('MONTH(voucherdate)',$month)
                    ->where('YEAR(voucherdate)',$year)
                    //->where('status',1)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_ypurchase_data($year)
  {
  $query = $this->db->select('*')
                    ->from('purchase')
                    ->where('accountType','Bank')
                    ->where('YEAR(purchaseDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_ysale_data($year)
  {
  $query = $this->db->select('*')
                    ->from('sales')
                    ->where('accountType','Bank')
                    ->where('YEAR(saleDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_ysreturn_data($year)
  {
  $query = $this->db->select('*')
                    ->from('returns')
                    ->where('accountType','Bank')
                    ->where('YEAR(returnDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_ypreturn_data($year)
  {
  $query = $this->db->select('*')
                    ->from('preturns')
                    ->where('accountType','Bank')
                    ->where('YEAR(prDate)',$year)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function get_bank_yvoucher_data($year)
  {
  $query = $this->db->select('*')
                    ->from('vaucher')
                    ->where('accountType','Bank')
                    ->where('YEAR(voucherdate)',$year)
                    //->where('status',1)
                    ->where('compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function sales_due_paypent_ddata()
  {
  $query = $this->db->select('sales_payment.*,sales.invoice_no,customers.customerName,customers.mobile')
                    ->from('sales_payment')
                    ->join('sales','sales.saleID = sales_payment.saleID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->get()
                    ->result();

  return $query;  
}

public function sales_ddue_paypent_ddata($sdate,$edate)
  {
  $query = $this->db->select('sales_payment.*,sales.invoice_no,customers.customerName,customers.mobile')
                    ->from('sales_payment')
                    ->join('sales','sales.saleID = sales_payment.saleID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('DATE(sales_payment.regdate) >=',$sdate)
                    ->where('DATE(sales_payment.regdate) <=',$edate)
                    ->get()
                    ->result();

  return $query;  
}

public function sales_mdue_paypent_ddata($month,$year)
  {
  $query = $this->db->select('sales_payment.*,sales.invoice_no,customers.customerName,customers.mobile')
                    ->from('sales_payment')
                    ->join('sales','sales.saleID = sales_payment.saleID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('MONTH(sales_payment.regdate)',$month)
                    ->where('YEAR(sales_payment.regdate)',$year)
                    ->get()
                    ->result();

  return $query;  
}

public function sales_ydue_paypent_ddata($year)
  {
  $query = $this->db->select('sales_payment.*,sales.invoice_no,customers.customerName,customers.mobile')
                    ->from('sales_payment')
                    ->join('sales','sales.saleID = sales_payment.saleID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('YEAR(sales_payment.regdate)',$year)
                    ->get()
                    ->result();

  return $query;  
}

public function get_sales_vat_data()
  {
  $query = $this->db->select('sales.*,customers.customerName,customers.mobile')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('sCost > 0')
                    ->get()
                    ->result();

  return $query;  
}

public function get_sales_dvat_data($sdate,$edate)
  {
  $query = $this->db->select('sales.*,customers.customerName,customers.mobile')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('sCost > 0')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->get()
                    ->result();

  return $query;  
}

public function get_sales_mvat_data($month,$year)
  {
  $query = $this->db->select('sales.*,customers.customerName,customers.mobile')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('sCost > 0')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->get()
                    ->result();

  return $query;  
}

public function get_sales_yvat_data($year)
  {
  $query = $this->db->select('sales.*,customers.customerName,customers.mobile')
                    ->from('sales')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.compid',$_SESSION['compid'])
                    ->where('sCost > 0')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->get()
                    ->result();

  return $query;  
}

public function get_stock_product()
  {
  if($_SESSION['role'] <= 2)
    {
    $emp = $this->db->select('productID')
            ->from('products')
            ->get()
            ->result_array();
        //var_dump($emp); exit();
    $emp_id = array_map (function($value){
    return $value['productID'];
    },$emp);
    //var_dump($emp_id); exit();
    if($emp_id == NULL)
      {
      $empid = 0;
      }
    else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
  
    return $this->db->select('stock.*,products.productName,products.productcode,products.pprice')
              ->from('stock')
              ->join('products','products.productID = stock.product','left')
              ->where_in('product',$empid)
              ->get()
              ->result();
    }
  else
    {
    $emp = $this->db->select('delivery_product.pid,delivery.empid')
            ->from('delivery_product')
            ->join('delivery','delivery.did = delivery_product.did','left')
            ->where_in('empid',$_SESSION['empid'])
            ->group_by('delivery_product.pid')
            ->get()
            ->result_array();
        //var_dump($emp); exit();
    $emp_id = array_map (function($value){
    return $value['pid'];
    },$emp);
    //var_dump($emp_id); exit();
    if($emp_id == NULL)
      {
      $empid = 0;
      }
    else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
  
    return $this->db->select('stock.*,products.productName,products.productcode,products.pprice')
              ->from('stock')
              ->join('products','products.productID = stock.product','left')
              ->where_in('product',$empid)
              ->where_in('stock.compid',$_SESSION['empid'])
              ->get()
              ->result();
    }
}

public function get_raw_stock_product()
  {
  if($_SESSION['role'] <= 2)
    {
    $emp = $this->db->select('productID')
        ->from('products')
        ->where('pType',1)
        ->get()
        ->result_array();
    //var_dump($emp); exit();
    $emp_id = array_map (function($value){
    return $value['productID'];
    },$emp);
    //var_dump($emp_id); exit();
    if($emp_id == NULL)
      {
      $empid = 0;
      }
    else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
    return $this->db->select('stock.*,products.productName,products.productcode,products.pprice')
              ->from('stock')
              ->join('products','products.productID = stock.product','left')
              ->where_in('product',$empid)
              ->get()
              ->result();
    }
  else
    {
    $emp = $this->db->select('delivery_product.pid,delivery.empid')
            ->from('delivery_product')
            ->join('delivery','delivery.did = delivery_product.did','left')
            ->where_in('empid',$_SESSION['empid'])
            ->get()
            ->result_array();
        //var_dump($emp); exit();
    $emp_id = array_map (function($value){
    return $value['pid'];
    },$emp);
    //var_dump($emp_id); exit();
    if($emp_id == NULL)
      {
      $empid = 0;
      }
    else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
  
    return $this->db->select('stock.*,products.productName,products.productcode,products.pprice')
              ->from('stock')
              ->join('products','products.productID = stock.product','left')
              ->where_in('product',$empid)
              ->where('products.pType',1)
              ->where_in('stock.compid',$_SESSION['empid'])
              ->get()
              ->result();
    }
}

public function get_finish_stock_product()
  {
  if($_SESSION['role'] <= 2)
    {
    $emp = $this->db->select('productID')
        ->from('products')
        ->where('pType',2)
        ->get()
        ->result_array();
    //var_dump($emp); exit();
    $emp_id = array_map (function($value){
    return $value['productID'];
    },$emp);
    //var_dump($emp_id); exit();
    if($emp_id == NULL)
      {
      $empid = 0;
      }
    else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
    return $this->db->select('stock.*,products.productName,products.productcode,products.pprice')
              ->from('stock')
              ->join('products','products.productID = stock.product','left')
              ->where_in('product',$empid)
              ->get()
              ->result();
    }
  else
    {
    $emp = $this->db->select('delivery_product.pid,delivery.empid')
            ->from('delivery_product')
            ->join('delivery','delivery.did = delivery_product.did','left')
            ->where_in('empid',$_SESSION['empid'])
            ->get()
            ->result_array();
        //var_dump($emp); exit();
    $emp_id = array_map (function($value){
    return $value['pid'];
    },$emp);
    //var_dump($emp_id); exit();
    if($emp_id == NULL)
      {
      $empid = 0;
      }
    else{
      $empid = $emp_id;
      }
    //var_dump($empid); exit();
  
    return $this->db->select('stock.*,products.productName,products.productcode,products.pprice')
              ->from('stock')
              ->join('products','products.productID = stock.product','left')
              ->where_in('product',$empid)
              ->where('products.pType',2)
              ->where_in('stock.compid',$_SESSION['empid'])
              ->get()
              ->result();
    }
}

public function get_salesdata($sid)
  {
  return $this->db->select('
                    sales.*,
                    customers.*')
                ->from('sales')
                ->join('customers','customers.customerID = sales.customerID','left')
                //->join('employees','employees.empid = sales.employee','left')
                ->where('saleID',$sid)
                ->get()
                ->row();
}

public function get_sales_products_data($sid)
  {
  return $this->db->select('sale_product.*,products.productID,products.productName')
                ->from('sale_product')
                ->join('products','products.productID = sale_product.productID','left')
                ->where('saleID',$sid)
                ->get()
                ->result();
}

public function total_cash()
  {
  $sa = $this->db->select('
                    SUM(totalAmount) as total,
                    SUM(paidAmount) as ptotal,
                    SUM(discountAmount) as dtotal,
                    SUM(sCost) as stotal,
                    SUM(vAmount) as vtotal')
              ->from('sales')
              ->where('accountType','Cash')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
                                        //var_dump($sa); //exit();
  if($sa)
    {
    //$saa = $sa->total-($sa->ptotal+$sa->dtotal+$sa->stotal+$sa->vtotal);
    $saa = $sa->ptotal;
    }
  else
    {
    $saa = 0;
    }
            
  $pa = $this->db->select("
                      SUM(totalPrice) as total,
                      SUM(paidAmount) as ptotal,
                      SUM(disAmount) as dtotal,
                      SUM(sCost) as stotal,
                      SUM(vAmount) as vtotal")
              ->from('purchase')
              ->where('accountType','Cash')
              ->where('compid',$_SESSION['compid'])
              //->where('purchaseDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($pa);// exit();
  if($pa)
    {
    //$paa = $pa->total-($pa->ptotal+$pa->dtotal+$pa->stotal+$pa->vtotal);
    $paa = $pa->ptotal;
    }
  else
    {
    $paa = 0;
    }
            
  $va = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Cash')
              ->where('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va); //exit();
  if($va)
    {
    $vaa = $va->total;
    }
  else
    {
    $vaa = 0;
    }
            
  $va2 = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Cash')
              ->where_not_in('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va2); //exit();
  if($va2)
    {
    $vaa2 = $va2->total;
    }
  else{
    $vaa2 = 0;
    }
  $tva = $vaa-$vaa2;
            
  $temp = $this->db->select("SUM(salary) as total")
              ->from('employee_payment')
              ->where('accountType','Cash')
              ->where('compid',$_SESSION['compid'])
              //->where('regdate',date("Y-m-d"))
              ->get()
              ->row();
  //var_dump($temp); //exit();
  if($temp)
    {
    $tempa = $temp->total;
    }
  else
    {
    $tempa = 0;
    }
            
  $tr = $this->db->select("SUM(totalPrice) as total,SUM(scAmount) as sctotal")
              ->from('returns')
              ->where('accountType','Cash')
              ->where('compid',$_SESSION['compid'])
              //->where('returnDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total-$tr->sctotal;
    }
  else
    {
    $tra = 0;
    }
                                        
  $tfbt = $this->db->select("SUM(amount) as total")
              ->from('transfer_account')
              ->where('facType','Cash')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($pa); //exit();
  if($tfbt)
    {
    $tfbta = $tfbt->total;
    }
  else
    {
    $tfbta = 0;
    }
                                        
  $ttbt = $this->db->select("SUM(amount) as total")
              ->from('transfer_account')
              ->where('sacType','Cash')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($pa); //exit();
  if($ttbt)
    {
    $ttbta = $ttbt->total;
    }
  else
    {
    $ttbta = 0;
    }

  $cop = $this->db->select("SUM(balance) as total")
              ->from('cash')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($pa); //exit();
  if($cop)
    {
    $copa = $cop->total;
    }
  else
    {
    $copa = 0;
    }

  $query = (($copa+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta));

  return $query;
}

public function total_bank()
  {
  $sa = $this->db->select('
                    SUM(totalAmount) as total,
                    SUM(paidAmount) as ptotal,
                    SUM(discountAmount) as dtotal,
                    SUM(sCost) as stotal,
                    SUM(vAmount) as vtotal')
              ->from('sales')
              ->where('accountType','Bank')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
                                        //var_dump($sa); //exit();
  if($sa)
    {
    $saa = $sa->ptotal;
    }
  else
    {
    $saa = 0;
    }
            
  $pa = $this->db->select("
                      SUM(totalPrice) as total,
                      SUM(paidAmount) as ptotal,
                      SUM(disAmount) as dtotal,
                      SUM(sCost) as stotal,
                      SUM(vAmount) as vtotal")
              ->from('purchase')
              ->where('accountType','Bank')
              ->where('compid',$_SESSION['compid'])
              //->where('purchaseDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($pa);// exit();
  if($pa)
    {
    $paa = $pa->ptotal;
    }
  else
    {
    $paa = 0;
    }
            
  $va = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Bank')
              ->where('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va); //exit();
  if($va)
    {
    $vaa = $va->total;
    }
  else
    {
    $vaa = 0;
    }
            
  $va2 = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Bank')
              ->where_not_in('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va2); //exit();
  if($va2)
    {
    $vaa2 = $va2->total;
    }
  else{
    $vaa2 = 0;
    }
  $tva = $vaa-$vaa2;
            
  $temp = $this->db->select("SUM(salary) as total")
              ->from('employee_payment')
              ->where('accountType','Bank')
              ->where('compid',$_SESSION['compid'])
              //->where('regdate',date("Y-m-d"))
              ->get()
              ->row();
  //var_dump($temp); //exit();
  if($temp)
    {
    $tempa = $temp->total;
    }
  else
    {
    $tempa = 0;
    }
            
  $tr = $this->db->select("SUM(totalPrice) as total,SUM(scAmount) as sctotal")
              ->from('returns')
              ->where('accountType','Bank')
              ->where('compid',$_SESSION['compid'])
              //->where('returnDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total-$tr->sctotal;
    }
  else
    {
    $tra = 0;
    }
                                        
  $tfbt = $this->db->select("SUM(amount) as total")
              ->from('transfer_account')
              ->where('facType','Bank')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($pa); //exit();
  if($tfbt)
    {
    $tfbta = $tfbt->total;
    }
  else
    {
    $tfbta = 0;
    }
                                        
  $ttbt = $this->db->select("SUM(amount) as total")
              ->from('transfer_account')
              ->where('sacType','Bank')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($pa); //exit();
  if($ttbt)
    {
    $ttbta = $ttbt->total;
    }
  else
    {
    $ttbta = 0;
    }

  $cop = $this->db->select("SUM(balance) as total")
              ->from('bankaccount')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($pa); //exit();
  if($cop)
    {
    $copa = $cop->total;
    }
  else
    {
    $copa = 0;
    }

  $query = (($copa+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta));
  
  return $query;
}

public function total_mobile()
  {
  $sa = $this->db->select('
                    SUM(totalAmount) as total,
                    SUM(paidAmount) as ptotal,
                    SUM(discountAmount) as dtotal,
                    SUM(sCost) as stotal,
                    SUM(vAmount) as vtotal')
              ->from('sales')
              ->where('accountType','Mobile')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
                                        //var_dump($sa); //exit();
  if($sa)
    {
    $saa = $sa->ptotal;
    }
  else
    {
    $saa = 0;
    }
            
  $pa = $this->db->select("
                      SUM(totalPrice) as total,
                      SUM(paidAmount) as ptotal,
                      SUM(disAmount) as dtotal,
                      SUM(sCost) as stotal,
                      SUM(vAmount) as vtotal")
              ->from('purchase')
              ->where('accountType','Mobile')
              ->where('compid',$_SESSION['compid'])
              //->where('purchaseDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($pa);// exit();
  if($pa)
    {
    $paa = $pa->ptotal;
    }
  else
    {
    $paa = 0;
    }
            
  $va = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Mobile')
              ->where('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va); //exit();
  if($va)
    {
    $vaa = $va->total;
    }
  else
    {
    $vaa = 0;
    }
            
  $va2 = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Mobile')
              ->where_not_in('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va2); //exit();
  if($va2)
    {
    $vaa2 = $va2->total;
    }
  else{
    $vaa2 = 0;
    }
  $tva = $vaa-$vaa2;
            
  $temp = $this->db->select("SUM(salary) as total")
              ->from('employee_payment')
              ->where('accountType','Mobile')
              ->where('compid',$_SESSION['compid'])
              //->where('regdate',date("Y-m-d"))
              ->get()
              ->row();
  //var_dump($temp); //exit();
  if($temp)
    {
    $tempa = $temp->total;
    }
  else
    {
    $tempa = 0;
    }
            
  $tr = $this->db->select("SUM(totalPrice) as total,SUM(scAmount) as sctotal")
              ->from('returns')
              ->where('accountType','Mobile')
              ->where('compid',$_SESSION['compid'])
              //->where('returnDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total-$tr->sctotal;
    }
  else
    {
    $tra = 0;
    }
                                        
  $tfbt = $this->db->select("SUM(amount) as total")
              ->from('transfer_account')
              ->where('facType','Mobile')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($pa); //exit();
  if($tfbt)
    {
    $tfbta = $tfbt->total;
    }
  else
    {
    $tfbta = 0;
    }
                                        
  $ttbt = $this->db->select("SUM(amount) as total")
              ->from('transfer_account')
              ->where('sacType','Mobile')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($pa); //exit();
  if($ttbt)
    {
    $ttbta = $ttbt->total;
    }
  else
    {
    $ttbta = 0;
    }

  $cop = $this->db->select("SUM(balance) as total")
              ->from('mobileaccount')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($pa); //exit();
  if($cop)
    {
    $copa = $cop->total;
    }
  else
    {
    $copa = 0;
    }

  $query = (($copa+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta));
  
  return $query;
}

public function total_credit()
  {
  $sa = $this->db->select('
                    SUM(totalAmount) as total,
                    SUM(paidAmount) as ptotal,
                    SUM(discountAmount) as dtotal,
                    SUM(sCost) as stotal,
                    SUM(vAmount) as vtotal')
              ->from('sales')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
                                        //var_dump($sa); //exit();
  if($sa)
    {
    $saa = $sa->total-($sa->ptotal+$sa->dtotal+$sa->stotal+$sa->vtotal);
    }
  else
    {
    $saa = 0;
    }
            
  
            
  $va = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Cash')
              ->where('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($va); //exit();
  if($va)
    {
    $vaa = $va->total;
    }
  else
    {
    $vaa = 0;
    }
            
  $tr = $this->db->select("SUM(paidAmount) as total")
              ->from('returns')
              ->where('compid',$_SESSION['compid'])
              //->where('returnDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total;
    }
  else
    {
    $tra = 0;
    }

  $query = (($saa)-($vaa+$tra));

  return $query;
}

public function total_debit()
  {      
  $pa = $this->db->select("
                      SUM(totalPrice) as total,
                      SUM(paidAmount) as ptotal,
                      SUM(disAmount) as dtotal,
                      SUM(sCost) as stotal,
                      SUM(vAmount) as vtotal")
              ->from('purchase')
              ->where('accountType','Bank')
              ->where('compid',$_SESSION['compid'])
              //->where('purchaseDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($pa);// exit();
  if($pa)
    {
    $paa = $pa->total-($pa->ptotal+$pa->dtotal+$pa->stotal+$pa->vtotal);
    }
  else
    {
    $paa = 0;
    }
            
  $va2 = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Bank')
              ->where_not_in('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              //->where('voucherdate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($va2); //exit();
  if($va2)
    {
    $vaa2 = $va2->total;
    }
  else
    {
    $vaa2 = 0;
    }
            

  $query = ($paa-$vaa2);
  
  return $query;
}

public function total_rsales_amount()
  {      
  $tr = $this->db->select("SUM(totalPrice) as total")
              ->from('returns')
              ->where('compid',$_SESSION['compid'])
              //->where('returnDate',date("Y-m-d"))
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total;
    }
  else
    {
    $tra = 0;
    }

  $query = $tra;

  return $query;
}

public function total_cash_credit()
  {
  $sa = $this->db->select('
                    SUM(totalAmount) as total,
                    SUM(paidAmount) as ptotal,
                    SUM(discountAmount) as dtotal,
                    SUM(sCost) as stotal,
                    SUM(vAmount) as vtotal')
              ->from('sales')
              ->where('compid',$_SESSION['compid'])
              ->where('accountType','Cash')
              ->get()
              ->row();
                                        //var_dump($sa); //exit();
  if($sa)
    {
    $saa = $sa->total-($sa->ptotal+$sa->dtotal+$sa->stotal+$sa->vtotal);
    }
  else
    {
    $saa = 0;
    }
            
  
            
  $va = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Cash')
              ->where('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              ->where('accountType','Cash')
              ->get()
              ->row();
    //var_dump($va); //exit();
  if($va)
    {
    $vaa = $va->total;
    }
  else
    {
    $vaa = 0;
    }
            
  $tr = $this->db->select("SUM(paidAmount) as total")
              ->from('returns')
              ->where('compid',$_SESSION['compid'])
              ->where('accountType','Cash')
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total;
    }
  else
    {
    $tra = 0;
    }

  $query = (($saa)-($vaa+$tra));

  return $query;
}

public function total_cash_debit()
  {      
  $pa = $this->db->select("
                      SUM(totalPrice) as total,
                      SUM(paidAmount) as ptotal,
                      SUM(disAmount) as dtotal,
                      SUM(sCost) as stotal,
                      SUM(vAmount) as vtotal")
              ->from('purchase')
              ->where('accountType','Bank')
              ->where('compid',$_SESSION['compid'])
              ->where('accountType','Cash')
              ->get()
              ->row();
    //var_dump($pa);// exit();
  if($pa)
    {
    $paa = $pa->total-($pa->ptotal+$pa->dtotal+$pa->stotal+$pa->vtotal);
    }
  else
    {
    $paa = 0;
    }
            
  $va2 = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('accountType','Bank')
              ->where_not_in('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              ->where('accountType','Cash')
              ->get()
              ->row();
    //var_dump($va2); //exit();
  if($va2)
    {
    $vaa2 = $va2->total;
    }
  else
    {
    $vaa2 = 0;
    }
            

  $query = ($paa-$vaa2);
  
  return $query;
}

public function total_cash_rsales_amount()
  {      
  $tr = $this->db->select("SUM(totalPrice) as total")
              ->from('returns')
              ->where('compid',$_SESSION['compid'])
              ->where('accountType','Cash')
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total;
    }
  else
    {
    $tra = 0;
    }

  $query = $tra;

  return $query;
}

public function total_cash_sales()
  {
  $query = $this->db->select("SUM(paidAmount) as total,SUM(totalAmount) as ttotal")
                  ->FROM('sales')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function total_cash_purchases()
  {
  $query = $this->db->select("SUM(`paidAmount`) as total,SUM(`totalPrice`) as ttotal")
                  ->FROM('purchase')
                  ->where('compid',$_SESSION['compid'])
                  ->where('accountType','Cash')
                  ->get()
                  ->row();
  return $query;  
}

public function total_store_amount()
  {
  $query = $this->db->select("stock_store.*,products.pprice")
                  ->FROM('stock_store')
                  ->join('products','products.productID = stock_store.product','left')
                  ->where('stock_store.compid',$_SESSION['compid'])
                  ->get()
                  ->result();
  return $query;  
}

public function total_stock_amount()
  {
  $query = $this->db->select("stock.*,products.pprice")
                  ->FROM('stock')
                  ->join('products','products.productID = stock.product','left')
                  ->where('stock.compid',$_SESSION['compid'])
                  ->get()
                  ->result();
  return $query;  
}

public function total_profit_amount()
  {
  $sa = $this->db->select('
                    SUM(totalAmount) as total,
                    SUM(paidAmount) as ptotal,
                    SUM(discountAmount) as dtotal,
                    SUM(sCost) as stotal,
                    SUM(vAmount) as vtotal')
              ->from('sales')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
                                        //var_dump($sa); //exit();
  if($sa)
    {
    //$saa = $sa->total-($sa->ptotal+$sa->dtotal+$sa->stotal+$sa->vtotal);
    $saa = $sa->ptotal;
    }
  else
    {
    $saa = 0;
    }
            
  $pa = $this->db->select("
                      SUM(totalPrice) as total,
                      SUM(paidAmount) as ptotal,
                      SUM(disAmount) as dtotal,
                      SUM(sCost) as stotal,
                      SUM(vAmount) as vtotal")
              ->from('purchase')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($pa);// exit();
  if($pa)
    {
    //$paa = $pa->total-($pa->ptotal+$pa->dtotal+$pa->stotal+$pa->vtotal);
    $paa = $pa->ptotal;
    }
  else
    {
    $paa = 0;
    }
            
  $va = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($va); //exit();
  if($va)
    {
    $vaa = $va->total;
    }
  else
    {
    $vaa = 0;
    }
            
  $va2 = $this->db->select("SUM(totalamount) as total")
              ->from('vaucher')
              ->where_not_in('vauchertype','Credit Voucher')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($va2); //exit();
  if($va2)
    {
    $vaa2 = $va2->total;
    }
  else{
    $vaa2 = 0;
    }
  $tva = $vaa-$vaa2;
            
  $temp = $this->db->select("SUM(salary) as total")
              ->from('employee_payment')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
  //var_dump($temp); //exit();
  if($temp)
    {
    $tempa = $temp->total;
    }
  else
    {
    $tempa = 0;
    }
            
  $tr = $this->db->select("SUM(paidAmount) as total,SUM(scAmount) as sctotal")
              ->from('returns')
              ->where('compid',$_SESSION['compid'])
              ->get()
              ->row();
    //var_dump($tr); //exit();
  if($tr)
    {
    $tra = $tr->total;
    }
  else
    {
    $tra = 0;
    }

  $query1 = (($saa+$tva));
  $query2 = (($paa+$tempa+$tra));
  $query = (($saa+$tva)-($paa+$tempa+$tra));
  //var_dump($query1); var_dump($query2); exit();
  return $query;
}


public function update_stock_product($pid,$taqnt)
	{
// 	$data = array('totalPices'=> $taqnt);

// 	$this->db->where('product', $pid);
// 	$this->db->where('compid', $_SESSION['compid']);
// 	$this->db->update('stock', $data);
}

public function get_product_data()
  {
  if($_SESSION['role'] <= 2)
    {
    $query = $this->db->select("products.*,categories.categoryName,sma_units.unitName")
                      ->from('products')
                      ->join('categories','categories.categoryID = products.categoryID','left')
                      ->join('sma_units','sma_units.id = products.unit','left')
                      ->order_by('productID','DESC')
                      ->get()
                      ->result();
    }
  else
    {
    $query = $this->db->select("delivery_product.pid,delivery.empid,products.*,categories.categoryName,sma_units.unitName")
                      ->from('delivery_product')
                      ->join('products','products.productID = delivery_product.pid','left')
                      ->join('delivery','delivery.did = delivery_product.did','left')
                      ->join('categories','categories.categoryID = products.categoryID','left')
                      ->join('sma_units','sma_units.id = products.unit','left')
                      ->where('empid',$_SESSION['empid'])
                      ->group_by('delivery_product.pid')
                      ->order_by('productID','DESC')
                      ->get()
                      ->result();
    }
  return $query;  
}


public function get_all_product_data($pType)
  {
  if($_SESSION['role'] <= 2)
    {
    $query = $this->db->select("products.*,categories.categoryName,sma_units.unitName")
                    ->from('products')
                    ->join('categories','categories.categoryID = products.categoryID','left')
                    ->join('sma_units','sma_units.id = products.unit','left')
                    ->where('pType',$pType)
                    ->order_by('productID','DESC')
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select("delivery_product.pid,delivery.empid,products.*,categories.categoryName,sma_units.unitName")
                  ->from('delivery_product')
                  ->join('products','products.productID = delivery_product.pid','left')
                  ->join('delivery','delivery.did = delivery_product.did','left')
                  ->join('categories','categories.categoryID = products.categoryID','left')
                  ->join('sma_units','sma_units.id = products.unit','left')
                  ->where('pType',$pType)
                  ->where('empid',$_SESSION['empid'])
                  ->group_by('delivery_product.pid')
                  ->order_by('productID','DESC')
                  ->get()
                  ->result();
    }
  return $query;  
}


public function get_sales_product_data()
  {
  $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->get()
                    ->result();

  return $query;  
}

public function get_dsales_product_data($sdate,$edate,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('sales.saleDate >=',$sdate)
                    ->where('sales.saleDate <=',$edate)
                    ->where('sale_product.productID',$pid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_msales_product_data($month,$year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('MONTH(sales.saleDate)',$month)
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sale_product.productID',$pid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_ysales_product_data($year,$pid)
  {
  if($pid == 'All')
    {
    $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('sale_product.*,sales.invoice_no,sales.saleDate,products.productName,products.productcode,customers.customerName,customers.mobile')
                    ->from('sale_product')
                    ->join('sales','sales.saleID = sale_product.saleID', 'left')
                    ->join('products','products.productID = sale_product.productID', 'left')
                    ->join('customers','customers.customerID = sales.customerID', 'left')
                    ->where('YEAR(sales.saleDate)',$year)
                    ->where('sale_product.productID',$pid)
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_delivery_product_data()
  {
  $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();

  return $query;  
}

public function get_ddelivery_product_data($sdate,$edate,$uid,$emp)
  {
  if($uid == 'All' && $emp == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('delivery.dDate >=',$sdate)
                    ->where('delivery.dDate <=',$edate)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else if($emp == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('delivery.dDate >=',$sdate)
                    ->where('delivery.dDate <=',$edate)
                    ->where('delivery_product.regby',$uid)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else if($uid == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('delivery.dDate >=',$sdate)
                    ->where('delivery.dDate <=',$edate)
                    ->where('delivery.empid',$emp)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('delivery.dDate >=',$sdate)
                    ->where('delivery.dDate <=',$edate)
                    ->where('delivery_product.regby',$uid)
                    ->where('delivery.empid',$emp)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }

  return $query;  
}

public function get_mdelivery_product_data($month,$year,$uid,$emp)
  {
  if($uid == 'All' && $emp == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('MONTH(delivery.dDate)',$month)
                    ->where('YEAR(delivery.dDate)',$year)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else if($emp == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('MONTH(delivery.dDate)',$month)
                    ->where('YEAR(delivery.dDate)',$year)
                    ->where('delivery_product.regby',$uid)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else if($uid == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('MONTH(delivery.dDate)',$month)
                    ->where('YEAR(delivery.dDate)',$year)
                    ->where('delivery.empid',$emp)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('MONTH(delivery.dDate)',$month)
                    ->where('YEAR(delivery.dDate)',$year)
                    ->where('delivery_product.regby',$uid)
                    ->where('delivery.empid',$emp)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  return $query;  
}

public function get_ydelivery_product_data($year,$uid,$emp)
  {
  if($uid == 'All' && $emp == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('YEAR(delivery.dDate)',$year)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else if($emp == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('YEAR(delivery.dDate)',$year)
                    ->where('delivery_product.regby',$uid)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else if($uid == 'All')
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('YEAR(delivery.dDate)',$year)
                    ->where('delivery.empid',$emp)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  else
    {
    $query = $this->db->select('delivery_product.*,delivery.*,products.productName,products.productcode, users.name,employees.employeeName')
                    ->from('delivery_product')
                    ->join('delivery','delivery.did = delivery_product.did', 'left')
                    ->join('products','products.productID = delivery_product.pid', 'left')
                    ->join('users','users.uid = delivery_product.regby', 'left')
                    ->join('employees','employees.employeeID = delivery.empid', 'left')
                    ->where('YEAR(delivery.dDate)',$year)
                    ->where('delivery_product.regby',$uid)
                    ->where('delivery.empid',$emp)
                    ->group_by('delivery_product.did')
                    ->get()
                    ->result();
    }
  return $query;  
}
public function company_profile_details()
  {
  $query = $this->db->select('*')
              ->from('com_profile')
              ->where('com_pid',1)
              ->get()
              ->row();
  return $query;  
}



}