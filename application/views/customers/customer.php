<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Customer</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Customer List</h3>
              <?php if($_SESSION['new_customer'] == 1){ ?>
              <!--<a class="btn btn-primary" href="<?php echo site_url('Customer/export_action'); ?>" style="float: right;padding-right:20px;"><i class="far fa-file-excel"></i> Export Excel</a>-->
              <button type="button" class="btn btn-primary add_customer" data-toggle="modal" data-target=".bs-example-modal-add_customer" style="float: right;"><i class="fa fa-plus"></i> NEW CUSTOMER</button>
              <!--<button type="button" class="btn btn-success template" data-toggle="modal" data-target=".bs-example-modal-template" style="float: right; margin-right: 10px;"><i class="far fa-file-excel"></i> IMPORT FROM EXCEL</button>-->
              <?php } ?>
            </div>

            <div class="card-body">
              <table id="example" class="table table-responsive table-bordered">
                <thead>
                  <tr>
                    <th style="width: 5%;">Item Serial</th>
                    <th>Image</th>
                    <th>ID</th>
                    <th>CUSTOMER NAME</th>
                    <th>MOBILE</th>
                    <!--<th>Email</th>-->
                    <th>ADDRESS</th>
                    <!--<th>GROUP</th>-->
                    <!--<th>GRANTOR NAME</th>-->
                    <!--<th>GRANTOR MOBILE</th>-->
                    <!-- <th>EMAIL</th> -->
                    <th>Discount (%)</th>
                    <th>PREVIOUS DUE</th>
                    <!-- <th style="width: 8%;">Status </th> -->
                    <th style="width: 10%;">ACTION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i = 0;
                    foreach ($customer as $value){
                    $i++;
                    ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <?php if($value['nidFiles'] == null) { ?>
                        <i class="fa fa-user fa-4x" aria-hidden="true" ></i>
                        <?php } else{ ?> 
                        <img src="<?php echo base_url().'/upload/users/'.$value['nidFiles']; ?>" style="width: 50px; height: 50px;">
                        <?php } ?> 
                      </td>
                    <td><?php echo $value['cus_id']; ?></td>
                    <td><?php echo $value['customerName']; ?></td>
                    <td><?php echo $value['mobile']; ?></td>
                    <!--<td><?php echo $value['email']; ?></td>-->
                    <td><?php echo $value['address']; ?></td>
                    <!--<td><?php echo $value['dept_name']; ?></td>-->
                    <!--<td><?php echo $value['gName']; ?></td>-->
                    <!--<td><?php echo $value['gMobile']; ?></td>-->
                    <td><?php echo number_format($value['custDiscount'], 2); ?></td>
                    <td style="color: red"><?php echo number_format($value['balance'], 2); ?></td>
                    <!-- <td><?php echo $value['status']; ?></td> -->
                    <td>
                      <?php if($_SESSION['edit_customer'] == 1){ ?>
                      <button type="button" class="btn btn-primary btn-sm customer_edit" data-toggle="modal" data-target=".bs-example-modal-customer_edit" data-id="<?php echo $value['customerID']; ?>" id="<?php echo $value['customerID']; ?>" onclick="document.getElementById('customer_edit').style.display='block'"><i class="fa fa-edit"></i></button>
                      <?php } if($_SESSION['delete_customer'] == 1){ ?>
                      <a class="btn btn-danger btn-sm" href="<?php echo site_url('Customer/delete_customer').'/'.$value['customerID']; ?>"><i class="fa fa-trash"></i></a>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade bs-example-modal-add_customer" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Customer Information</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
      </div>
      <form action="<?php echo base_url('Customer/save_customer');?>" method="post">
        <div class="col-md-12 col-sm-12 col-12">
          <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
          <!--  <input type="text" class="form-control" name="cus_id" placeholder="Customer ID">-->
          <!--</div>-->
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" name="customerName" placeholder="Customer Name">
          </div>
          <div class="form-group col-md-12 col-sm-12 col-12">
            <input type="text" class="form-control" name="mobile" placeholder="Mobile Number *"
              onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required>
          </div>
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" name="email" placeholder="E-mail">
          </div>
          <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
          <!--  <input type="text" class="form-control" name="nid" placeholder="NID">-->
          <!--</div>-->
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <label>Image <br><small style="color: red; font-size:10px">( Maximum image size 500kb and png, jpg
                format )</small></label>
            <input type="file" name="userfile">
          </div>
          <div class="form-group col-md-12 col-sm-12 col-12">
            <input type="text" class="form-control" name="address" placeholder="Address">
          </div>
          <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
          <!--  <select name="groupId" class="form-control">-->
          <!--    <option value="">Select Group</option>-->
          <!--    <?php  foreach($department as $value) { ?>-->
          <!--    <option value="<?php echo $value['dpt_id']; ?>"><?php echo $value['dept_name']; ?></option>-->
          <!--    <?php } ?>-->
          <!--  </select>-->
          <!--</div>-->
          <!-- <div class="form-group col-md-12 col-sm-12 col-12">
            <input type="email" class="form-control" name="email" placeholder="example@sunshine.com">
          </div> -->
          <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
          <!--    <input type="text" class="form-control" name="gName" placeholder="Granton Name"  >-->
          <!--</div>-->
          <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
          <!--    <input type="text" class="form-control" name="gMobile" placeholder="Granton Mobile"  >-->
          <!--</div>-->
          
          <div class="form-group col-md-12 col-sm-12 col-12">
            <input type="text" class="form-control" name="balance" placeholder="Previous Due">
          </div>
          <div class="form-group col-md-12 col-sm-12 col-12">
            <input type="text" class="form-control" name="custDiscount" placeholder="Discount % ">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i
              class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-customer_edit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Customer Information</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
      </div>
      <form action="<?php echo base_url('Customer/update_customer');?>" method="post">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="row">
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Contact Number *</label>
              <input type="text" class="form-control" name="mobile" id="mobile" onkeypress="return isNumberKey(event)"
                maxlength="11" minlength="11" required>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-12">
              <label>Customer Name</label>
              <input type="text" class="form-control" name="customerName" id="customerName">
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Address</label>
              <input type="text" class="form-control" name="address" id="address">
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Email</label>
              <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="form-group col-md-6 col-sm-6 col-12">
              <label>Previous Due</label>
              <input type="text" class="form-control" name="balance" id="balance" placeholder="Previous Due">
            </div>
            <div class="form-group col-md-6 col-sm-6 col-12">
              <label>Discount % </label>
              <input type="text" class="form-control" name="custDiscount" id="custDiscount" placeholder="Discount">
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
              <label>Status</label>
              <select class="form-control" name="status" id="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <input type="hidden" id="cus_id" name="cus_id" required >
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-template" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Customer Template</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
      </div>
      <div class="row">
        <div class="form-group col-md-6 col-sm-6 col-12">
          <div style="width: 100%; height: 100px;background: #fff4f4;text-align: center;">
            <a href="<?php echo base_url('assets/templates/customers.xlsx') ?>"
              style="padding:1em;text-align: center;display:inline-block;text-decoration: none !important;margin:0 auto;">New
              template</a>
          </div>
        </div>
        <div class="form-group col-md-6 col-sm-6 col-12">
          <div style="width: 100%; height: 100px;background: #fff4f4;text-align: center;">
            <a href="<?php echo base_url('Customer/export_action') ?>"
              style="padding:1em;text-align: center;display:inline-block;text-decoration: none !important;margin:0 auto;">Exit
              template</a>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-12">
        <form method="post" id="import_form" enctype="multipart/form-data">
          <div class="form-group col-md-12 col-sm-12 col-12">
            <label>Import Template<span style="color: red">*</span></label>
            <input type="file" name="file" id="file" required accept=".xls, .xlsx">
          </div>
          <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px; text-align: center;">
            <input type="submit" name="import" value="Import" class="btn btn-info">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('footer/footer'); ?>

<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.customer_edit', function() {
      var catid = $(this).attr('id');
      $('input[name="cus_id"]').val(catid);
    });
    $(document).on('click', '.customer_edit', function() {
      var id = $(this).attr('id');
      var url = '<?php echo base_url() ?>Customer/get_customer_data';
      $.ajax({
        method: 'POST',
        url: url,
        dataType: 'json',
        data: {
          'id': id
        },
        success: function(data) {
          var HTML = data["customerName"];
          var HTML3 = data["mobile"];
          var HTML4 = data["email"];
          var HTML5 = data["address"];
          var HTML6 = data["balance"];
          var HTML7 = data["status"];
          var HTML8 = data["custDiscount"];
          
          $("#customerName").val(HTML);
          $("#mobile").val(HTML3);
          $("#email").val(HTML4);
          $("#address").val(HTML5);
          $("#balance").val(HTML6);
          $("#status").val(HTML7);
          $("#custDiscount").val(HTML8);
          },
        error: function() {
          alert('error');
        }
      });
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#import_form').on('submit', function(event) {
      event.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Customer/excel_import",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          $('#file').val('');
          load_data();
          alert(data);
        }
      });
    });
  });
</script>