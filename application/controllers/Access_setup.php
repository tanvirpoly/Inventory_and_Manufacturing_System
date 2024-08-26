<?php 
defined ('BASEPATH') OR exit('no direct script access allowed');
class Access_setup extends CI_Controller

##############################################################################
{   	/* Code Start From Here */
##############################################################################

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

	#############################################################
	#				/* Pages start*/							#
	#############################################################
						

public function user_access_setup()
  {
  $data = ['title' => 'Access Setup'];

  $where = array('compid'=> $_SESSION['compid']);
  $data['user'] = $this->pm->get_data('access_lavels',$where);
  
  $this->load->view('user_role/user_access_setup',$data);
}

public function view_uaccess_setup($id)
  {
  $data = ['title' => 'Access Setup'];

  $where = array('utype'=> $id);
  $data['master'] = $this->pm->get_data('tbl_user_m_permission',$where);
  $data['page'] = $this->pm->get_data('tbl_user_p_permission',$where);
  $data['function'] = $this->pm->get_data('tbl_user_f_permission',$where);

  $awhere = array('ax_id'=> $id);
  $data['user'] = $this->pm->get_data('access_lavels',$awhere);
  
  $this->load->view('user_role/view_uaccess_setup',$data);
}

public function edit_uaccess_setup($id)
  {
  $data = ['title' => 'Access Setup'];

  $where = array('utype'=> $id);
  $data['master'] = $this->pm->get_data('tbl_user_m_permission',$where);
  $data['page'] = $this->pm->get_data('tbl_user_p_permission',$where);
  $data['function'] = $this->pm->get_data('tbl_user_f_permission',$where);

  $awhere = array('ax_id'=> $id);
  $data['user'] = $this->pm->get_data('access_lavels',$awhere);
  
  $this->load->view('user_role/edit_uaccess_setup',$data);
}

public function setup_user_access($id)
  {
  $info = $this->input->post();

  $where = array(
    'utype' => $id
        );

  if(isset($info['product']) == 1)
    {
    $product = 1;
    }
  else
    {
    $product = 0;
    }
  if(isset($info['purchase']) == 1)
    {
    $purchase = 1;
    }
  else
    {
    $purchase = 0;
    }
  if(isset($info['sales']) == 1)
    {
    $sales = 1;
    }
  else
    {
    $sales = 0;
    }
  if(isset($info['return']) == 1)
    {
    $return = 1;
    }
  else
    {
    $return = 0;
    }
  if(isset($info['quotation']) == 1)
    {
    $quotation = 1;
    }
  else
    {
    $quotation = 0;
    }
  if(isset($info['recipes']) == 1)
    {
    $recipes = 1;
    }
  else
    {
    $recipes = 0;
    }
  if(isset($info['manufacturers']) == 1)
    {
    $manufacturers = 1;
    }
  else
    {
    $manufacturers = 0;
    }
  if(isset($info['deliverys']) == 1)
    {
    $deliverys = 1;
    }
  else
    {
    $deliverys = 0;
    }
  if(isset($info['voucher']) == 1)
    {
    $voucher = 1;
    }
  else
    {
    $voucher = 0;
    }
  if(isset($info['emp_payment']) == 1)
    {
    $emp_payment = 1;
    }
  else
    {
    $emp_payment = 0;
    }
  if(isset($info['balance_transfer']) == 1)
    {
    $balance_transfer = 1;
    }
  else
    {
    $balance_transfer = 0;
    }
  if(isset($info['users']) == 1)
    {
    $users = 1;
    }
  else
    {
    $users = 0;
    }
  if(isset($info['report']) == 1)
    {
    $report = 1;
    }
  else
    {
    $report = 0;
    }
  if(isset($info['setting']) == 1)
    {
    $setting = 1;
    }
  else
    {
    $setting = 0;
    }
  if(isset($info['access_setup']) == '1')
    {
    $access_setup = 1;
    }
  else
    {
    $access_setup = 0;
    }
  
  $mdata = [
    'dashboard'        => 1,
    'product'          => $product,
    'purchase'         => $purchase,
    'sales'            => $sales,
    'return'           => $return,
    'quotation'        => $quotation,
    'recipes'          => $recipes,
    'manufacturers'    => $manufacturers,
    'deliverys'        => $deliverys,
    'voucher'          => $voucher,
    'emp_payment'      => $emp_payment,
    'balance_transfer' => $balance_transfer,
    'users'            => $users,
    'report'           => $report,
    'setting'          => $setting,
    'access_setup'     => $access_setup,
    'upby'             => $_SESSION['uid']
            ];
  //var_dump($where); var_dump($data); exit();
  $result = $this->pm->update_data('tbl_user_m_permission',$mdata,$where);
  
  if(isset($info['product_list']) == 1)
    {
    $product_list = 1;
    }
  else
    {
    $product_list = 0;
    }
  if(isset($info['purchase_list']) == 1)
    {
    $purchase_list = 1;
    }
  else
    {
    $purchase_list = 0;
    }
  if(isset($info['sales_list']) == 1)
    {
    $sales_list = 1;
    }
  else
    {
    $sales_list = 0;
    }
  if(isset($info['return_list']) == 1)
    {
    $return_list = 1;
    }
  else
    {
    $return_list = 0;
    }
  if(isset($info['quotation_list']) == 1)
    {
    $quotation_list = 1;
    }
  else
    {
    $quotation_list = 0;
    }
  if(isset($info['recipe_list']) == 1)
    {
    $recipe_list = 1;
    }
  else
    {
    $recipe_list = 0;
    }
  if(isset($info['manufacturer_list']) == 1)
    {
    $manufacturer_list = 1;
    }
  else
    {
    $manufacturer_list = 0;
    }
  if(isset($info['delivery_list']) == 1)
    {
    $delivery_list = 1;
    }
  else
    {
    $delivery_list = 0;
    }
  if(isset($info['voucher_list']) == 1)
    {
    $voucher_list = 1;
    }
  else
    {
    $voucher_list = 0;
    }
  if(isset($info['salary_list']) == 1)
    {
    $salary_list = 1;
    }
  else
    {
    $salary_list = 0;
    }
  if(isset($info['transfer_list']) == 1)
    {
    $transfer_list = 1;
    }
  else
    {
    $transfer_list = 0;
    }
  if(isset($info['customer']) == 1)
    {
    $customer = 1;
    }
  else
    {
    $customer = 0;
    }
  if(isset($info['supplier']) == 1)
    {
    $supplier = 1;
    }
  else
    {
    $supplier = 0;
    }
  if(isset($info['employee']) == 1)
    {
    $employee = 1;
    }
  else
    {
    $employee = 0;
    }
  if(isset($info['user']) == '1')
    {
    $user = 1;
    }
  else
    {
    $user = 0;
    }
  if(isset($info['sale_report']) == 1)
    {
    $sale_report = 1;
    }
  else
    {
    $sale_report = 0;
    }
  if(isset($info['purchase_report']) == 1)
    {
    $purchase_report = 1;
    }
  else
    {
    $purchase_report = 0;
    }
  if(isset($info['profit_report']) == 1)
    {
    $profit_report = 1;
    }
  else
    {
    $profit_report = 0;
    }
  if(isset($info['customer_report']) == 1)
    {
    $customer_report = 1;
    }
  else
    {
    $customer_report = 0;
    }
  if(isset($info['customer_ledger']) == 1)
    {
    $customer_ledger = 1;
    }
  else
    {
    $customer_ledger = 0;
    }
  if(isset($info['supplier_report']) == 1)
    {
    $supplier_report = 1;
    }
  else
    {
    $supplier_report = 0;
    }
  if(isset($info['supplier_ledger']) == 1)
    {
    $supplier_ledger = 1;
    }
  else
    {
    $supplier_ledger = 0;
    }
  if(isset($info['stock_report']) == 1)
    {
    $stock_report = 1;
    }
  else
    {
    $stock_report = 0;
    }
  if(isset($info['voucher_report']) == 1)
    {
    $voucher_report = 1;
    }
  else
    {
    $voucher_report = 0;
    }
  if(isset($info['daily_report']) == 1)
    {
    $daily_report = 1;
    }
  else
    {
    $daily_report = 0;
    }
  if(isset($info['cashbook']) == 1)
    {
    $cashbook = 1;
    }
  else
    {
    $cashbook = 0;
    }
  if(isset($info['bankbook']) == 1)
    {
    $bankbook = 1;
    }
  else
    {
    $bankbook = 0;
    }
  if(isset($info['mobilebook']) == 1)
    {
    $mobilebook = 1;
    }
  else
    {
    $mobilebook = 0;
    }
  if(isset($info['total_product']) == 1)
    {
    $total_product = 1;
    }
  else
    {
    $total_product = 0;
    }
  if(isset($info['order_report']) == '1')
    {
    $order_report = 1;
    }
  else
    {
    $order_report = 0;
    }
  if(isset($info['sprofit_report']) == 1)
    {
    $sprofit_report = 1;
    }
  else
    {
    $sprofit_report = 0;
    }
  if(isset($info['due_report']) == 1)
    {
    $due_report = 1;
    }
  else
    {
    $due_report = 0;
    }
  if(isset($info['bsale_report']) == 1)
    {
    $bsale_report = 1;
    }
  else
    {
    $bsale_report = 0;
    }
  if(isset($info['stock_alert']) == 1)
    {
    $stock_alert = 1;
    }
  else
    {
    $stock_alert = 0;
    }
  if(isset($info['bank_transction']) == 1)
    {
    $bank_transction = 1;
    }
  else
    {
    $bank_transction = 0;
    }
  if(isset($info['expense_report']) == 1)
    {
    $expense_report = 1;
    }
  else
    {
    $expense_report = 0;
    }
  if(isset($info['duep_report']) == 1)
    {
    $duep_report = 1;
    }
  else
    {
    $duep_report = 0;
    }
  if(isset($info['vat_report']) == 1)
    {
    $vat_report = 1;
    }
  else
    {
    $vat_report = 0;
    }
  if(isset($info['sproduct_report']) == 1)
    {
    $sproduct_report = 1;
    }
  else
    {
    $sproduct_report = 0;
    }
  if(isset($info['dproduct_report']) == 1)
    {
    $dproduct_report = 1;
    }
  else
    {
    $dproduct_report = 0;
    }
  if(isset($info['trail_balance']) == 1)
    {
    $trail_balance = 1;
    }
  else
    {
    $trail_balance = 0;
    }
  if(isset($info['balance_sheet']) == 1)
    {
    $balance_sheet = 1;
    }
  else
    {
    $balance_sheet = 0;
    }
  if(isset($info['cash_flow']) == 1)
    {
    $cash_flow = 1;
    }
  else
    {
    $cash_flow = 0;
    }
  if(isset($info['income_statement']) == 1)
    {
    $income_statement = 1;
    }
  else
    {
    $income_statement = 0;
    }
  if(isset($info['category']) == '1')
    {
    $category = 1;
    }
  else
    {
    $category = 0;
    }
  if(isset($info['unit']) == 1)
    {
    $unit = 1;
    }
  else
    {
    $unit = 0;
    }
  if(isset($info['cost_type']) == 1)
    {
    $cost_type = 1;
    }
  else
    {
    $cost_type = 0;
    }
  if(isset($info['department']) == 1)
    {
    $department = 1;
    }
  else
    {
    $department = 0;
    }
  if(isset($info['bank_account']) == 1)
    {
    $bank_account = 1;
    }
  else
    {
    $bank_account = 0;
    }
  if(isset($info['mobile_account']) == 1)
    {
    $mobile_account = 1;
    }
  else
    {
    $mobile_account = 0;
    }
  if(isset($info['user_type']) == 1)
    {
    $user_type = 1;
    }
  else
    {
    $user_type = 0;
    }
  if(isset($info['online_store']) == 1)
    {
    $online_store = 1;
    }
  else
    {
    $online_store = 0;
    }
  if(isset($info['about_us']) == 1)
    {
    $about_us = 1;
    }
  else
    {
    $about_us = 0;
    }
  if(isset($info['company_setup']) == 1)
    {
    $company_setup = 1;
    }
  else
    {
    $company_setup = 0;
    }
  if(isset($info['accessetup']) == 1)
    {
    $accessetup = 1;
    }
  else
    {
    $accessetup = 0;
    }
  
  $pdata = [
    'dashboard'         => 1,
    'product_list'      => $product_list,
    'purchase_list'     => $purchase_list,
    'sales_list'        => $sales_list,
    'return_list'       => $return_list,
    'quotation_list'    => $quotation_list,
    'recipe_list'       => $recipe_list,
    'manufacturer_list' => $manufacturer_list,
    'delivery_list'     => $delivery_list,
    'voucher_list'      => $voucher_list,
    'salary_list'       => $salary_list,
    'transfer_list'     => $transfer_list,
    'customer'          => $customer,
    'supplier'          => $supplier,
    'employee'          => $employee,
    'user'              => $user,
    'sale_report'       => $sale_report,
    'purchase_report'   => $purchase_report,
    'profit_report'     => $profit_report,
    'customer_report'   => $customer_report,
    'customer_ledger'   => $customer_ledger,
    'supplier_report'   => $supplier_report,
    'supplier_ledger'   => $supplier_ledger,
    'stock_report'      => $stock_report,
    'voucher_report'    => $voucher_report,
    'daily_report'      => $daily_report,
    'cashbook'          => $cashbook,
    'bankbook'          => $bankbook,
    'mobilebook'        => $mobilebook,
    'total_product'     => $total_product,
    'order_report'      => $order_report,
    'sprofit_report'    => $sprofit_report,
    'due_report'        => $due_report,
    'bsale_report'      => $bsale_report,
    'stock_alert'       => $stock_alert,
    'bank_transction'   => $bank_transction,
    'expense_report'    => $expense_report,
    'duep_report'       => $duep_report,
    'vat_report'        => $vat_report,
    'sproduct_report'   => $sproduct_report,
    'dproduct_report'   => $dproduct_report,
    'trail_balance'     => $trail_balance,
    'balance_sheet'     => $balance_sheet,
    'cash_flow'         => $cash_flow,
    'income_statement'  => $income_statement,
    'category'          => $category,
    'unit'              => $unit,
    'cost_type'         => $cost_type,
    'department'        => $department,
    'bank_account'      => $bank_account,
    'mobile_account'    => $mobile_account,
    'user_type'         => $user_type,
    'online_store'      => $online_store,
    'about_us'          => $about_us,
    'company_setup'     => $company_setup,
    'accessetup'        => $accessetup,
    'upby'              => $_SESSION['uid']
            ];
            
  $result2 = $this->pm->update_data('tbl_user_p_permission',$pdata,$where);

  if(isset($info['new_product']) == 1)
    {
    $new_product = 1;
    }
  else
    {
    $new_product = 0;
    }
  if(isset($info['store_product']) == 1)
    {
    $store_product = 1;
    }
  else
    {
    $store_product = 0;
    }
  if(isset($info['edit_product']) == 1)
    {
    $edit_product = 1;
    }
  else
    {
    $edit_product = 0;
    }
  if(isset($info['delete_product']) == 1)
    {
    $delete_product = 1;
    }
  else
    {
    $delete_product = 0;
    }
  if(isset($info['import_product']) == 1)
    {
    $import_product = 1;
    }
  else
    {
    $import_product = 0;
    }
  if(isset($info['new_purchase']) == 1)
    {
    $new_purchase = 1;
    }
  else
    {
    $new_purchase = 0;
    }
  if(isset($info['edit_purchase']) == 1)
    {
    $edit_purchase = 1;
    }
  else
    {
    $edit_purchase = 0;
    }
  if(isset($info['delete_purchase']) == 1)
    {
    $delete_purchase = 1;
    }
  else
    {
    $delete_purchase = 0;
    }
  if(isset($info['new_sale']) == 1)
    {
    $new_sale = 1;
    }
  else
    {
    $new_sale = 0;
    }
  if(isset($info['edit_sale']) == 1)
    {
    $edit_sale = 1;
    }
  else
    {
    $edit_sale = 0;
    }
  if(isset($info['delete_sale']) == 1)
    {
    $delete_sale = 1;
    }
  else
    {
    $delete_sale = 0;
    }
  if(isset($info['new_return']) == 1)
    {
    $new_return = 1;
    }
  else
    {
    $new_return = 0;
    }
  if(isset($info['edit_return']) == 1)
    {
    $edit_return = 1;
    }
  else
    {
    $edit_return = 0;
    }
  if(isset($info['delete_return']) == 1)
    {
    $delete_return = 1;
    }
  else
    {
    $delete_return = 0;
    }
  if(isset($info['new_quotation']) == '1')
    {
    $new_quotation = 1;
    }
  else
    {
    $new_quotation = 0;
    }
  if(isset($info['edit_quotation']) == 1)
    {
    $edit_quotation = 1;
    }
  else
    {
    $edit_quotation = 0;
    }
  if(isset($info['delete_quotation']) == 1)
    {
    $delete_quotation = 1;
    }
  else
    {
    $delete_quotation = 0;
    }
  if(isset($info['new_recipe']) == 1)
    {
    $new_recipe = 1;
    }
  else
    {
    $new_recipe = 0;
    }
  if(isset($info['edit_recipe']) == 1)
    {
    $edit_recipe = 1;
    }
  else
    {
    $edit_recipe = 0;
    }
  if(isset($info['delete_recipe']) == 1)
    {
    $delete_recipe = 1;
    }
  else
    {
    $delete_recipe = 0;
    }
  if(isset($info['new_manufacturer']) == 1)
    {
    $new_manufacturer = 1;
    }
  else
    {
    $new_manufacturer = 0;
    }
  if(isset($info['edit_manufacturer']) == 1)
    {
    $edit_manufacturer = 1;
    }
  else
    {
    $edit_manufacturer = 0;
    }
  if(isset($info['delete_manufacturer']) == 1)
    {
    $delete_manufacturer = 1;
    }
  else
    {
    $delete_manufacturer = 0;
    }
  if(isset($info['new_voucher']) == 1)
    {
    $new_voucher = 1;
    }
  else
    {
    $new_voucher = 0;
    }
  if(isset($info['edit_voucher']) == 1)
    {
    $edit_voucher = 1;
    }
  else
    {
    $edit_voucher = 0;
    }
  if(isset($info['delete_voucher']) == 1)
    {
    $delete_voucher = 1;
    }
  else
    {
    $delete_voucher = 0;
    }
  if(isset($info['new_delivery']) == 1)
    {
    $new_delivery = 1;
    }
  else
    {
    $new_delivery = 0;
    }
  if(isset($info['edit_delivery']) == 1)
    {
    $edit_delivery = 1;
    }
  else
    {
    $edit_delivery = 0;
    }
  if(isset($info['delete_delivery']) == 1)
    {
    $delete_delivery = 1;
    }
  else
    {
    $delete_delivery = 0;
    }
  if(isset($info['new_salary']) == '1')
    {
    $new_salary = 1;
    }
  else
    {
    $new_salary = 0;
    }
  if(isset($info['edit_salary']) == 1)
    {
    $edit_salary = 1;
    }
  else
    {
    $edit_salary = 0;
    }
  if(isset($info['delete_salary']) == 1)
    {
    $delete_salary = 1;
    }
  else
    {
    $delete_salary = 0;
    }
  if(isset($info['new_btransfer']) == 1)
    {
    $new_btransfer = 1;
    }
  else
    {
    $new_btransfer = 0;
    }
  if(isset($info['edit_btransfer']) == 1)
    {
    $edit_btransfer = 1;
    }
  else
    {
    $edit_btransfer = 0;
    }
  if(isset($info['delete_btransfer']) == 1)
    {
    $delete_btransfer = 1;
    }
  else
    {
    $delete_btransfer = 0;
    }
  if(isset($info['new_customer']) == 1)
    {
    $new_customer = 1;
    }
  else
    {
    $new_customer = 0;
    }
  if(isset($info['edit_customer']) == 1)
    {
    $edit_customer = 1;
    }
  else
    {
    $edit_customer = 0;
    }
  if(isset($info['delete_customer']) == 1)
    {
    $delete_customer = 1;
    }
  else
    {
    $delete_customer = 0;
    }
  if(isset($info['new_supplier']) == 1)
    {
    $new_supplier = 1;
    }
  else
    {
    $new_supplier = 0;
    }
  if(isset($info['edit_supplier']) == 1)
    {
    $edit_supplier = 1;
    }
  else
    {
    $edit_supplier = 0;
    }
  if(isset($info['delete_supplier']) == 1)
    {
    $delete_supplier = 1;
    }
  else
    {
    $delete_supplier = 0;
    }
  if(isset($info['new_employee']) == 1)
    {
    $new_employee = 1;
    }
  else
    {
    $new_employee = 0;
    }
  if(isset($info['edit_employee']) == 1)
    {
    $edit_employee = 1;
    }
  else
    {
    $edit_employee = 0;
    }
  if(isset($info['delete_employee']) == 1)
    {
    $delete_employee = 1;
    }
  else
    {
    $delete_employee = 0;
    }
  if(isset($info['new_user']) == '1')
    {
    $new_user = 1;
    }
  else
    {
    $new_user = 0;
    }
  if(isset($info['edit_user']) == 1)
    {
    $edit_user = 1;
    }
  else
    {
    $edit_user = 0;
    }
  if(isset($info['delete_user']) == 1)
    {
    $delete_user = 1;
    }
  else
    {
    $delete_user = 0;
    }
  if(isset($info['new_category']) == 1)
    {
    $new_category = 1;
    }
  else
    {
    $new_category = 0;
    }
  if(isset($info['edit_category']) == 1)
    {
    $edit_category = 1;
    }
  else
    {
    $edit_category = 0;
    }
  if(isset($info['delete_category']) == 1)
    {
    $delete_category = 1;
    }
  else
    {
    $delete_category = 0;
    }
  if(isset($info['new_unit']) == 1)
    {
    $new_unit = 1;
    }
  else
    {
    $new_unit = 0;
    }
  if(isset($info['edit_unit']) == 1)
    {
    $edit_unit = 1;
    }
  else
    {
    $edit_unit = 0;
    }
  if(isset($info['delete_unit']) == 1)
    {
    $delete_unit = 1;
    }
  else
    {
    $delete_unit = 0;
    }
  if(isset($info['new_ctype']) == 1)
    {
    $new_ctype = 1;
    }
  else
    {
    $new_ctype = 0;
    }
  if(isset($info['edit_ctype']) == 1)
    {
    $edit_ctype = 1;
    }
  else
    {
    $edit_ctype = 0;
    }
  if(isset($info['delete_ctype']) == 1)
    {
    $delete_ctype = 1;
    }
  else
    {
    $delete_ctype = 0;
    }
  if(isset($info['new_department']) == 1)
    {
    $new_department = 1;
    }
  else
    {
    $new_department = 0;
    }
  if(isset($info['edit_department']) == 1)
    {
    $edit_department = 1;
    }
  else
    {
    $edit_department = 0;
    }
  if(isset($info['delete_department']) == 1)
    {
    $delete_department = 1;
    }
  else
    {
    $delete_department = 0;
    }
  if(isset($info['new_baccount']) == 1)
    {
    $new_baccount = 1;
    }
  else
    {
    $new_baccount = 0;
    }
  if(isset($info['edit_baccount']) == 1)
    {
    $edit_baccount = 1;
    }
  else
    {
    $edit_baccount = 0;
    }
  if(isset($info['delete_baccount']) == 1)
    {
    $delete_baccount = 1;
    }
  else
    {
    $delete_baccount = 0;
    }
  if(isset($info['new_maccount']) == 1)
    {
    $new_maccount = 1;
    }
  else
    {
    $new_maccount = 0;
    }
  if(isset($info['edit_maccount']) == 1)
    {
    $edit_maccount = 1;
    }
  else
    {
    $edit_maccount = 0;
    }
  if(isset($info['delete_maccount']) == 1)
    {
    $delete_maccount = 1;
    }
  else
    {
    $delete_maccount = 0;
    }
  if(isset($info['new_utype']) == 1)
    {
    $new_utype = 1;
    }
  else
    {
    $new_utype = 0;
    }
  if(isset($info['edit_utype']) == '1')
    {
    $edit_utype = 1;
    }
  else
    {
    $edit_utype = 0;
    }
  if(isset($info['delete_utype']) == 1)
    {
    $delete_utype = 1;
    }
  else
    {
    $delete_utype = 0;
    }
  

  $fdata = [
    'new_product'         => $new_product,
    'store_product'       => $store_product,
    'edit_product'        => $edit_product,
    'delete_product'      => $delete_product,
    'import_product'      => $import_product,
    'new_purchase'        => $new_purchase,
    'edit_purchase'       => $edit_purchase,
    'delete_purchase'     => $delete_purchase,
    'new_sale'            => $new_sale,
    'edit_sale'           => $edit_sale,
    'delete_sale'         => $delete_sale,
    'new_return'          => $new_return,
    'edit_return'         => $edit_return,
    'delete_return'       => $delete_return,
    'new_quotation'       => $new_quotation,
    'edit_quotation'      => $edit_quotation,
    'delete_quotation'    => $delete_quotation,
    'new_recipe'          => $new_recipe,
    'edit_recipe'         => $edit_recipe,
    'delete_recipe'       => $delete_recipe,
    'new_manufacturer'    => $new_manufacturer,
    'edit_manufacturer'   => $edit_manufacturer,
    'delete_manufacturer' => $delete_manufacturer,
    'new_voucher'         => $new_voucher,
    'edit_voucher'        => $edit_voucher,
    'delete_voucher'      => $delete_voucher,
    'new_delivery'        => $new_delivery,
    'edit_delivery'       => $edit_delivery,
    'delete_delivery'     => $delete_delivery,
    'new_salary'          => $new_salary,
    'edit_salary'         => $edit_salary,
    'delete_salary'       => $delete_salary,
    'new_btransfer'       => $new_btransfer,
    'edit_btransfer'      => $edit_btransfer,
    'delete_btransfer'    => $delete_btransfer,
    'new_customer'        => $new_customer,
    'edit_customer'       => $edit_customer,
    'delete_customer'     => $delete_customer,
    'new_supplier'        => $new_supplier,
    'edit_supplier'       => $edit_supplier,
    'delete_supplier'     => $delete_supplier,
    'new_employee'        => $new_employee,
    'edit_employee'       => $edit_employee,
    'delete_employee'     => $delete_employee,
    'new_user'            => $new_user,
    'edit_user'           => $edit_user,
    'delete_user'         => $delete_user,
    'new_category'        => $new_category,
    'edit_category'       => $edit_category,
    'delete_category'     => $delete_category,
    'new_unit'            => $new_unit,
    'edit_unit'           => $edit_unit,
    'delete_unit'         => $delete_unit,
    'new_ctype'           => $new_ctype,
    'edit_ctype'          => $edit_ctype,
    'delete_ctype'        => $delete_ctype,
    'new_department'      => $new_department,
    'edit_department'     => $edit_department,
    'delete_department'   => $delete_department,
    'new_baccount'        => $new_baccount,
    'edit_baccount'       => $edit_baccount,
    'delete_baccount'     => $delete_baccount,
    'new_maccount'        => $new_maccount,
    'edit_maccount'       => $edit_maccount,
    'delete_maccount'     => $delete_maccount,
    'new_utype'           => $new_utype,
    'edit_utype'          => $edit_utype,
    'delete_utype'        => $delete_utype,
    'upby'                => $_SESSION['uid']
            ];
    //var_dump($data2); exit();
  $result3 = $this->pm->update_data('tbl_user_f_permission',$fdata,$where);

  if($result && $result && $result3)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> User Page and Function Access add Successfully !</h4>
      </div>'
          ];    
    }
  else
    {
    $sdata=[
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4>
      </div>'
          ];
    }

  $this->session->set_userdata($sdata);
  redirect('userAccess');
}




	#########################################################
	#				/* Pages End */							#
	#########################################################


############################################################################
}   	/* Code Ends Here */
############################################################################