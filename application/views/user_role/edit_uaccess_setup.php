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
                <h3 class="card-title">User Permission Setup Information</h3>
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
                    <div class="box-header">
                      <h3 class="box-title">List of Pages And Functions</h3>
                    </div>
                    <div class="box-body">
                      <form action="<?= base_url().'Access_setup/setup_user_access/'.$user[0]['ax_id']; ?>" method="post">
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="product" value="1" <?php if($master[0]['product'] == '1'){ ?>checked<?php } ?>> Products
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="product_list" value="1" <?php if($page[0]['product_list'] == '1'){ ?>checked<?php } ?>> Products</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_product" value="1" <?php if($function[0]['new_product'] == '1'){ ?>checked<?php } ?>> New Product</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="store_product" value="1" <?php if($function[0]['store_product'] == '1'){ ?>checked<?php } ?>> Store Product</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_product" value="1" <?php if($function[0]['edit_product'] == '1'){ ?>checked<?php } ?>> Edit Product</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_product" value="1" <?php if($function[0]['delete_product'] == '1'){ ?>checked<?php } ?>> Delete Product</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="import_product" value="1" <?php if($function[0]['import_product'] == '1'){ ?>checked<?php } ?>> Import Product</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="purchase" value="1" <?php if($master[0]['purchase'] == '1'){ ?>checked<?php } ?>> Purchases
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="purchase_list" value="1" <?php if($page[0]['purchase_list'] == '1'){ ?>checked<?php } ?>> Purchases</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_purchase" value="1" <?php if($function[0]['new_purchase'] == '1'){ ?>checked<?php } ?>> New Purchase</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_purchase" value="1" <?php if($function[0]['edit_purchase'] == '1'){ ?>checked<?php } ?>> Edit Purchase</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_purchase" value="1" <?php if($function[0]['delete_purchase'] == '1'){ ?>checked<?php } ?>> Delete Purchase</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="sales" value="1" <?php if($master[0]['sales'] == '1'){ ?>checked<?php } ?>> Sales
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="sales_list" value="1" <?php if($page[0]['sales_list'] == '1'){ ?>checked<?php } ?>> Sales</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_sale" value="1" <?php if($function[0]['new_sale'] == '1'){ ?>checked<?php } ?>> New Sale</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_sale" value="1" <?php if($function[0]['edit_sale'] == '1'){ ?>checked<?php } ?>> Edit Sale</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_sale" value="1" <?php if($function[0]['delete_sale'] == '1'){ ?>checked<?php } ?>> Delete Sale</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="return" value="1" <?php if($master[0]['return'] == '1'){ ?>checked<?php } ?>> Returns
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="return_list" value="1" <?php if($page[0]['return_list'] == '1'){ ?>checked<?php } ?>> Return</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_return" value="1" <?php if($function[0]['new_return'] == '1'){ ?>checked<?php } ?>> New Return</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_return" value="1" <?php if($function[0]['edit_return'] == '1'){ ?>checked<?php } ?>> Edit Return</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_return" value="1" <?php if($function[0]['delete_return'] == '1'){ ?>checked<?php } ?>> Delete Return</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="quotation" value="1" <?php if($master[0]['quotation'] == '1'){ ?>checked<?php } ?>> Quotation
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="quotation_list" value="1" <?php if($page[0]['quotation_list'] == '1'){ ?>checked<?php } ?>> Quotation</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_quotation" value="1" <?php if($function[0]['new_quotation'] == '1'){ ?>checked<?php } ?>> New Quotation</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_quotation" value="1" <?php if($function[0]['edit_quotation'] == '1'){ ?>checked<?php } ?>> Edit Quotation</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_quotation" value="1" <?php if($function[0]['delete_quotation'] == '1'){ ?>checked<?php } ?>> Delete Quotation</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="recipes" value="1" <?php if($master[0]['recipes'] == '1'){ ?>checked<?php } ?>> Recipes
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="recipe_list" value="1" <?php if($page[0]['recipe_list'] == '1'){ ?>checked<?php } ?>> Recipes</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_recipe" value="1" <?php if($function[0]['new_recipe'] == '1'){ ?>checked<?php } ?>> New Recipe</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_recipe" value="1" <?php if($function[0]['edit_recipe'] == '1'){ ?>checked<?php } ?>> Edit Recipe</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_recipe" value="1" <?php if($function[0]['delete_recipe'] == '1'){ ?>checked<?php } ?>> Delete Recipe</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="manufacturers" value="1" <?php if($master[0]['manufacturers'] == '1'){ ?>checked<?php } ?>> Manufacturers
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="manufacturer_list" value="1" <?php if($page[0]['manufacturer_list'] == '1'){ ?>checked<?php } ?>> Manufacturer</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_manufacturer" value="1" <?php if($function[0]['new_manufacturer'] == '1'){ ?>checked<?php } ?>> New Manufacturer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_manufacturer" value="1" <?php if($function[0]['edit_manufacturer'] == '1'){ ?>checked<?php } ?>> Edit Manufacturer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_manufacturer" value="1" <?php if($function[0]['delete_manufacturer'] == '1'){ ?>checked<?php } ?>> Delete Manufacturer</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="deliverys" value="1" <?php if($master[0]['deliverys'] == '1'){ ?>checked<?php } ?>> Deliverys
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="delivery_list" value="1" <?php if($page[0]['delivery_list'] == '1'){ ?>checked<?php } ?>> Deliverys</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_delivery" value="1" <?php if($function[0]['new_delivery'] == '1'){ ?>checked<?php } ?>> New Delivery</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_delivery" value="1" <?php if($function[0]['edit_delivery'] == '1'){ ?>checked<?php } ?>> Edit Delivery</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_delivery" value="1" <?php if($function[0]['delete_delivery'] == '1'){ ?>checked<?php } ?>> Delete Delivery</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="voucher" value="1" <?php if($master[0]['voucher'] == '1'){ ?>checked<?php } ?>> Voucher
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="voucher_list" value="1" <?php if($page[0]['voucher_list'] == '1'){ ?>checked<?php } ?>> Voucher</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_voucher" value="1" <?php if($function[0]['new_voucher'] == '1'){ ?>checked<?php } ?>> New Voucher</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_voucher" value="1" <?php if($function[0]['edit_voucher'] == '1'){ ?>checked<?php } ?>> Edit Voucher</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_voucher" value="1" <?php if($function[0]['delete_voucher'] == '1'){ ?>checked<?php } ?>> Delete Voucher</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="emp_payment" value="1" <?php if($master[0]['emp_payment'] == '1'){ ?>checked<?php } ?>> Sallary
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="salary_list" value="1" <?php if($page[0]['salary_list'] == '1'){ ?>checked<?php } ?>> Sallary</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_salary" value="1" <?php if($function[0]['new_salary'] == '1'){ ?>checked<?php } ?>> New Sallary</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_salary" value="1" <?php if($function[0]['edit_salary'] == '1'){ ?>checked<?php } ?>> Edit Sallary</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_salary" value="1" <?php if($function[0]['delete_salary'] == '1'){ ?>checked<?php } ?>> Delete Sallary</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="balance_transfer" value="1" <?php if($master[0]['balance_transfer'] == '1'){ ?>checked<?php } ?>> Balance Transfer
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="transfer_list" value="1" <?php if($page[0]['transfer_list'] == '1'){ ?>checked<?php } ?>> Balance Transfer</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_btransfer" value="1" <?php if($function[0]['new_btransfer'] == '1'){ ?>checked<?php } ?>> New Balance Transfer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_btransfer" value="1" <?php if($function[0]['edit_btransfer'] == '1'){ ?>checked<?php } ?>> Edit Balance Transfer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_btransfer" value="1" <?php if($function[0]['delete_btransfer'] == '1'){ ?>checked<?php } ?>> Delete Balance Transfer</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="users" value="1" <?php if($master[0]['users'] == '1'){ ?>checked<?php } ?>> Users
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="customer" value="1" <?php if($page[0]['customer'] == '1'){ ?>checked<?php } ?>> Customer</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_customer" value="1" <?php if($function[0]['new_customer'] == '1'){ ?>checked<?php } ?>> New Customer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_customer" value="1" <?php if($function[0]['edit_customer'] == '1'){ ?>checked<?php } ?>> Edit Customer</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_customer" value="1" <?php if($function[0]['delete_customer'] == '1'){ ?>checked<?php } ?>> Delete Customer</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="supplier" value="1" <?php if($page[0]['supplier'] == '1'){ ?>checked<?php } ?>> Supplier</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_supplier" value="1" <?php if($function[0]['new_supplier'] == '1'){ ?>checked<?php } ?>> New Supplier</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_supplier" value="1" <?php if($function[0]['edit_supplier'] == '1'){ ?>checked<?php } ?>> Edit Supplier</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_supplier" value="1" <?php if($function[0]['delete_supplier'] == '1'){ ?>checked<?php } ?>> Delete Supplier</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="employee" value="1" <?php if($page[0]['employee'] == '1'){ ?>checked<?php } ?>> Employee</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_employee" value="1" <?php if($function[0]['new_employee'] == '1'){ ?>checked<?php } ?>> New Employee</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_employee" value="1" <?php if($function[0]['edit_employee'] == '1'){ ?>checked<?php } ?>> Edit Employee</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_employee" value="1" <?php if($function[0]['delete_employee'] == '1'){ ?>checked<?php } ?>> Delete Employee</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="user" value="1" <?php if($page[0]['user'] == '1'){ ?>checked<?php } ?>> User</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_user" value="1" <?php if($function[0]['new_user'] == '1'){ ?>checked<?php } ?>> New User</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_user" value="1" <?php if($function[0]['edit_user'] == '1'){ ?>checked<?php } ?>> Edit User</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_user" value="1" <?php if($function[0]['delete_user'] == '1'){ ?>checked<?php } ?>> Delete User</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="report" value="1" <?php if($master[0]['report'] == '1'){ ?>checked<?php } ?>> Reports
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 70%;">Page</th>
                                      <th style="width: 30%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="sale_report" value="1" <?php if($page[0]['sale_report'] == '1'){ ?>checked<?php } ?>> Sales Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="purchase_report" value="1" <?php if($page[0]['purchase_report'] == '1'){ ?>checked<?php } ?>> Purchases Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="profit_report" value="1" <?php if($page[0]['profit_report'] == '1'){ ?>checked<?php } ?>> Profit / Loss Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="customer_report" value="1" <?php if($page[0]['customer_report'] == '1'){ ?>checked<?php } ?>> Customers Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="customer_ledger" value="1" <?php if($page[0]['customer_ledger'] == '1'){ ?>checked<?php } ?>> Customer Ledger</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="supplier_report" value="1" <?php if($page[0]['supplier_report'] == '1'){ ?>checked<?php } ?>> Suppliers Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="supplier_ledger" value="1" <?php if($page[0]['supplier_ledger'] == '1'){ ?>checked<?php } ?>> Supplier Ledger</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="stock_report" value="1" <?php if($page[0]['stock_report'] == '1'){ ?>checked<?php } ?>> Stock Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="voucher_report" value="1" <?php if($page[0]['voucher_report'] == '1'){ ?>checked<?php } ?>> Voucher Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="daily_report" value="1" <?php if($page[0]['daily_report'] == '1'){ ?>checked<?php } ?>> Daily Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="cashbook" value="1" <?php if($page[0]['cashbook'] == '1'){ ?>checked<?php } ?>> Cash Book</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="bankbook" value="1" <?php if($page[0]['bankbook'] == '1'){ ?>checked<?php } ?>> Bank Book</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="mobilebook" value="1" <?php if($page[0]['mobilebook'] == '1'){ ?>checked<?php } ?>> Mobile Book</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="total_product" value="1" <?php if($page[0]['total_product'] == '1'){ ?>checked<?php } ?>> Total Product</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="order_report" value="1" <?php if($page[0]['order_report'] == '1'){ ?>checked<?php } ?>> Order Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="sprofit_report" value="1" <?php if($page[0]['sprofit_report'] == '1'){ ?>checked<?php } ?>> Profit Report ( Sale Wise )</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="due_report" value="1" <?php if($page[0]['due_report'] == '1'){ ?>checked<?php } ?>> Due Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="bsale_report" value="1" <?php if($page[0]['bsale_report'] == '1'){ ?>checked<?php } ?>> Best Sale Product</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="stock_alert" value="1" <?php if($page[0]['stock_alert'] == '1'){ ?>checked<?php } ?>> Stock Alert</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="bank_transction" value="1" <?php if($page[0]['bank_transction'] == '1'){ ?>checked<?php } ?>> Bank Transction Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="expense_report" value="1" <?php if($page[0]['expense_report'] == '1'){ ?>checked<?php } ?>> Expense Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="duep_report" value="1" <?php if($page[0]['duep_report'] == '1'){ ?>checked<?php } ?>> Due Payment Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="vat_report" value="1" <?php if($page[0]['vat_report'] == '1'){ ?>checked<?php } ?>> Vat Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="sproduct_report" value="1" <?php if($page[0]['sproduct_report'] == '1'){ ?>checked<?php } ?>> Product Wise Sale Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="dproduct_report" value="1" <?php if($page[0]['dproduct_report'] == '1'){ ?>checked<?php } ?>> Delivery Product Report</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="trail_balance" value="1" <?php if($page[0]['trail_balance'] == '1'){ ?>checked<?php } ?>> Trail Balance</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="balance_sheet" value="1" <?php if($page[0]['balance_sheet'] == '1'){ ?>checked<?php } ?>> Balance Sheet</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="cash_flow" value="1" <?php if($page[0]['cash_flow'] == '1'){ ?>checked<?php } ?>> Cash Flow</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="income_statement" value="1" <?php if($page[0]['income_statement'] == '1'){ ?>checked<?php } ?>> Income Statement</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="setting" value="1" <?php if($master[0]['setting'] == '1'){ ?>checked<?php } ?>> Setting
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 40%;">Page</th>
                                      <th style="width: 60%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="category" value="1" <?php if($page[0]['category'] == '1'){ ?>checked<?php } ?>> Category</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_category" value="1" <?php if($function[0]['new_category'] == '1'){ ?>checked<?php } ?>> New Category</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_category" value="1" <?php if($function[0]['edit_category'] == '1'){ ?>checked<?php } ?>> Edit Category</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_category" value="1" <?php if($function[0]['delete_category'] == '1'){ ?>checked<?php } ?>> Delete Category</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="unit" value="1" <?php if($page[0]['unit'] == '1'){ ?>checked<?php } ?>> Unit</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_unit" value="1" <?php if($function[0]['new_unit'] == '1'){ ?>checked<?php } ?>> New Unit</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_unit" value="1" <?php if($function[0]['edit_unit'] == '1'){ ?>checked<?php } ?>> Edit Unit</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_unit" value="1" <?php if($function[0]['delete_unit'] == '1'){ ?>checked<?php } ?>> Delete Unit</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="cost_type" value="1" <?php if($page[0]['cost_type'] == '1'){ ?>checked<?php } ?>> Expese Type</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_ctype" value="1" <?php if($function[0]['new_ctype'] == '1'){ ?>checked<?php } ?>> New Expese Type</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_ctype" value="1" <?php if($function[0]['edit_ctype'] == '1'){ ?>checked<?php } ?>> Edit Expese Type</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_ctype" value="1" <?php if($function[0]['delete_ctype'] == '1'){ ?>checked<?php } ?>> Delete Expese Type</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="department" value="1" <?php if($page[0]['department'] == '1'){ ?>checked<?php } ?>> Department</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_department" value="1" <?php if($function[0]['new_department'] == '1'){ ?>checked<?php } ?>> New Department</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_department" value="1" <?php if($function[0]['edit_department'] == '1'){ ?>checked<?php } ?>> Edit Department</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_department" value="1" <?php if($function[0]['delete_department'] == '1'){ ?>checked<?php } ?>> Delete Department</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="bank_account" value="1" <?php if($page[0]['bank_account'] == '1'){ ?>checked<?php } ?>> Bank Account</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_baccount" value="1" <?php if($function[0]['new_baccount'] == '1'){ ?>checked<?php } ?>> New Bank Account</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_baccount" value="1" <?php if($function[0]['edit_baccount'] == '1'){ ?>checked<?php } ?>> Edit Bank Account</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_baccount" value="1" <?php if($function[0]['delete_baccount'] == '1'){ ?>checked<?php } ?>> Delete Bank Account</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="mobile_account" value="1" <?php if($page[0]['mobile_account'] == '1'){ ?>checked<?php } ?>> Mobile Account</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_maccount" value="1" <?php if($function[0]['new_maccount'] == '1'){ ?>checked<?php } ?>> New Mobile Account</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_maccount" value="1" <?php if($function[0]['edit_maccount'] == '1'){ ?>checked<?php } ?>> Edit Mobile Account</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_maccount" value="1" <?php if($function[0]['delete_maccount'] == '1'){ ?>checked<?php } ?>> Delete Mobile Account</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="user_type" value="1" <?php if($page[0]['user_type'] == '1'){ ?>checked<?php } ?>> User Type</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="new_utype" value="1" <?php if($function[0]['new_utype'] == '1'){ ?>checked<?php } ?>> New User Type</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="edit_utype" value="1" <?php if($function[0]['edit_utype'] == '1'){ ?>checked<?php } ?>> Edit User Type</label>
                                            </div>
                                          </li>
                                          <li>
                                            <div class="checkbox">
                                              <label><input type="checkbox" name="delete_utype" value="1" <?php if($function[0]['delete_utype'] == '1'){ ?>checked<?php } ?>> Delete User Type</label>
                                            </div>
                                          </li>
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="online_store" value="1" <?php if($page[0]['online_store'] == '1'){ ?>checked<?php } ?>> Online Store</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="about_us" value="1" <?php if($page[0]['about_us'] == '1'){ ?>checked<?php } ?>> About Us</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          
                                        </ul>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="company_setup" value="1" <?php if($page[0]['company_setup'] == '1'){ ?>checked<?php } ?>> Company Profile</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;">
                                          
                                        </ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4 col-sm-4 col-12">
                            <h5 style="background-color: #007bff; color: #fff; padding-left: 20px; border-radius: 10px;padding: 10px;">
                              <input type="checkbox" name="access_setup" value="1" <?php if($master[0]['access_setup'] == '1'){ ?>checked<?php } ?>> Access Setup
                            </h5>
                            <div class="page_box" >
                              <div class="col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th style="width: 50%;">Page</th>
                                      <th style="width: 50%;">Function</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="accessetup" value="1" <?php if($page[0]['accessetup'] == '1'){ ?>checked<?php } ?>> Access Setup</label>
                                        </div>
                                      </td>
                                      <td>
                                        <ul style="list-style-type: none; margin-left: -40px;"></ul>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>

						</div>
	              		<div class="col-md-12 col-sm-12 col-12" style="text-align: center;">
                    	  <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                          <a href="<?php echo site_url('userAccess') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
                    	</div>
                      </form>
                    </div>
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