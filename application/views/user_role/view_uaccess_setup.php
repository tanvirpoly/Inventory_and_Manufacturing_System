<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Access Setup</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Access Setup</li>
            </ol>
          </div>
        </div>
      </div>
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Access Setup Information</h3>
              </div>

              <div class="card-body">
        	    <div class="row">
                  <div class="col-md-12 col-sm-12 col-12">
                    <table>
                      <tbody>
                        <tr>
                          <td>User Type</td>
                          <td>: <?= $user[0]['lavelName']; ?></td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>: <?= $user[0]['status']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12 col-sm-12 col-12">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Master</th>
                          <th>Page</th>
                          <th>Function</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <ul style="list-style-type:none;">
                              <li>
                                <b>
                                  <?php if($master[0]['dashboard'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Dashboard
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Products
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['purchase'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Purchases
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['sales'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Sales
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['return'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Returns
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['quotation'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Quotations
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['recipes'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Recipes
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['manufacturers'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Manufacturers
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['deliverys'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Deliverys
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['voucher'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Vouchers
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['emp_payment'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Salarys
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['balance_transfer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Balance Transfers
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['users'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Users
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Reports
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['setting'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Setting
                              </li>
                              <li>
                                <b>
                                  <?php if($master[0]['access_setup'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Access Setup
                              </li>
                            </ul>
                          </td>

                          <td>
                            <ul style="list-style-type:none;">
                              <li>
                                <b>
                                  <?php if($page[0]['dashboard'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Dashboard
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['product_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Products
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['purchase_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Purchases
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['sales_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Sales
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['return_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Returns
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['quotation_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Quotations
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['recipe_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Recipes
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['manufacturer_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Manufacturers
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['delivery_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Deliverys
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['voucher_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Vouchers
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['salary_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Salary
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['transfer_list'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Balance Transfer
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Customers
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Suppliers
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Employees
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b>Users
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['sale_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Sales Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['purchase_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Purchases Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['profit_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Profit / Loss Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['customer_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Customers Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['customer_ledger'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Customer Ledger
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['supplier_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Suppliers Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['supplier_ledger'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Supplier Ledger
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['stock_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Stock Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['voucher_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Vouchers Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['daily_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Daily Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['cashbook'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Cash Book
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['bankbook'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Bank Book
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['mobilebook'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Mobile Book
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['total_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Total Product
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['order_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Order Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['sprofit_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Sale Profit Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['due_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b>Due Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['bsale_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Best Sales Product
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['stock_alert'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Stock Alert
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['bank_transction'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Bank Transction Reports
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['expense_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Expense Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['duep_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Due Payment Reports
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['vat_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Vat Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['sproduct_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Sale Profit Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['dproduct_report'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delivery Product Report
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['trail_balance'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Trail Balance
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['balance_sheet'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Balance Sheet
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['cash_flow'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Cash Flow
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['income_statement'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Income Statement
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Category
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['cost_type'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Expense Type
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['department'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Department
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['bank_account'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Bank Account
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['mobile_account'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Mobile Account
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['user_type'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> User Type
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['online_store'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Online Store
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['about_us'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> About US
                              </li>
                              <li>
                                <b>
                                  <?php if($page[0]['company_setup'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Company Profile
                              </li>
                            </ul>
                          </td>

                          <td>
                            <ul style="list-style-type:none;">
                              <li>
                                <b>
                                  <?php if($function[0]['new_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['store_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Store Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['import_product'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Import Product
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_purchase'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Purchase
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_purchase'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Purchase
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_purchase'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Purchase
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_sale'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Sale
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_sale'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Sale
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_sale'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Sale
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_return'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                    <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Return
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_return'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Return
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_return'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Return
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_return'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Quotation
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_quotation'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Quotation
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_quotation'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Quotation
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_recipe'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Recipe
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_recipe'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Recipe
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_recipe'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Recipe
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_manufacturer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Manufacturer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_manufacturer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Manufacturer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_manufacturer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Manufacturer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_voucher'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Voucher
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_voucher'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Voucher
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_voucher'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Voucher
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_delivery'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Delivery
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_delivery'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Delivery
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_delivery'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Delivery
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_salary'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Salary
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_salary'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Salary
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_salary'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Salary
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_btransfer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Balance Transfer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_btransfer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Balance Transfer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_btransfer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Balance Transfer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_customer'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Customer
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_supplier'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Supplier
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_employee'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Employee
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New User
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit User
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_user'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete User
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Category
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Category
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_category'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Category
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_unit'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Unit
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_ctype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Expense Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_ctype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Expense Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_ctype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Expense Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_department'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Department
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_department'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Department
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_department'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Department
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_baccount'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Bank Account
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_baccount'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Bank Account
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_baccount'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Bank Account
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_maccount'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New Mobile Account
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_maccount'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit Mobile Account
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_maccount'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete Mobile Account
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['new_utype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> New User Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['edit_utype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Edit User Type
                              </li>
                              <li>
                                <b>
                                  <?php if($function[0]['delete_utype'] == '1'){ ?>
                                  <i class="fas fa-check" style="color:green;"> </i>
                                  <?php }else{ ?>
                                  <i class="fas fa-times" style="color:red;"> </i>
                                  <?php } ?>
                                </b> Delete User Type
                              </li>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  	</section>
  </div>


<?php $this->load->view('footer/footer');?>