<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Supplier</li>
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
                <h3 class="card-title">Supplier List</h3>
                <?php if($_SESSION['new_supplier'] == '1'){ ?>
                <button type="button" class="btn btn-primary add_supplier" data-toggle="modal" data-target=".bs-example-modal-add_supplier" style="float: right;" ><i class="fa fa-plus"></i> New Supplier</button>
                <button type="button" class="btn btn-success template" data-toggle="modal" data-target=".bs-example-modal-template" style="float: right; margin-right: 10px;" ><i class="far fa-file-excel"></i> Import</button>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr style="text-transform:uppercase; text-align:center;">
                      <th style="width: 5%;">SN</th>
                      <th style="width: 15%;">ID</th>
                      <th style="width: 12%;">NAME</th>
                      <th style="width: 15%;">COMPANY</th>
                      <th style="width: 10%;">MOBILE</th>
                      <th style="width: 10%;">EMAIL</th>
                      <th style="width: 15%;">ADDRESS</th>
                      <th style="width: 10%;">BALANCE</th>
                      <!-- <th style="width: 10%;">Status</th> -->
                      <th style="width: 8%;">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($supplier as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['sup_id']; ?></td>
                      <td><?php echo $value['supplierName']; ?></td>
                      <td><?php echo $value['compname']; ?></td>
                      <td><?php echo $value['mobile']; ?></td>
                      <td><?php echo $value['email']; ?></td>
                      <td><?php echo $value['address']; ?></td>
                      <td><?php echo number_format($value['balance'],2); ?></td>
                      <!-- <td><?php echo $value['status']; ?></td> -->
                      <td>
                        <?php if($_SESSION['edit_supplier'] == '1') { ?>
                        <button type="button" class="btn btn-success btn-xs supplier_edit" data-toggle="modal" data-target=".bs-example-modal-supplier_edit" data-id="<?php echo $value['supplierID'];?>" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_supplier'] == '1') { ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Supplier/delete_supplier').'/'.$value['supplierID']; ?>" ><i class="fa fa-trash"></i></a>
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

    <div class="modal fade bs-example-modal-add_supplier" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Add New Supplier</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form autocomplete="off" action="<?php echo base_url('Supplier/save_supplier');?>" method="post">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <input type="text" class="form-control" name="supplierName" placeholder="Supplier Name *" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" required minlength="11" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <input type="text" class="form-control" name="compname" placeholder="Supplier Company" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <input type="email" class="form-control" name="email" placeholder="example@sunshine.com" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="address" placeholder="Address" >
              </div>
              <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
              <!--  <input type="text" class="form-control" name="balance" placeholder="Opening Balance" >-->
              <!--</div>-->
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-supplier_edit" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Update Supplier Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Supplier/update_supplier');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Name *</label>
                  <input type="text" class="form-control" name="supplierName" id="supplierName" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="mobile" id="mobile" onkeypress="return isNumberKey(event)" maxlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Supplier Company</label>
                  <input type="text" class="form-control" name="compname" id="compname" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" id="email" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" id="address">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Opening Balance</label>
                  <input type="text" class="form-control" name="balance" id="balance" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Status</label>
                  <select class="form-control" name="status" id="status" >
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <input type="hidden" id="sup_id" name="sup_id" >
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-template" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title">Supplier template</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="row">
            <div class="form-group col-md-12 col-sm-12 col-12">
              <div style="width: 100%; height: 100px; background: #fff4f4;text-align: center;">
                <a href="<?php echo base_url('assets/templates/suppliers.xlsx'); ?>" style="padding:1em; text-align: center; display:inline-block; text-decoration: none !important; margin:0 auto;">New template</a>
              </div>
            </div>
            <!--<div class="form-group col-md-6 col-sm-6 col-12">-->
            <!--  <div style="width: 100%;height: 100px;background: #fff4f4;text-align: center;">-->
            <!--    <a href="<?php echo base_url('Supplier/export_action') ?>" style="padding:1em;text-align: center;display:inline-block;text-decoration: none !important;margin:0 auto;">Exists  template</a>-->
            <!--  </div>-->
            <!--</div>-->
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <form method="post" id="import_form" enctype="multipart/form-data">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Import Template<span style="color: red;">*</span></label>
                <input type="file" name="file" id="file" required accept=".xls, .xlsx" >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top: 25px; text-align: center;">
                <input type="submit" name="import" value="Import" class="btn btn-info" >
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
      $(document).ready(function(){
        $(".supplier_edit").click(function(){
          var catid = $(this).data('id');
          //alert(l_id);
          $('input[name="sup_id"]').val(catid);
          });

        $('.supplier_edit').click(function() {
          var id = $(this).data('id');
          //alert(id);
          var url = '<?php echo base_url() ?>Supplier/get_supplier_data';
          //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
            //alert(data);
            var HTML = data["supplierName"];
            var HTML2 = data["compname"];
            var HTML3 = data["mobile"];
            var HTML4 = data["email"];
            var HTML5 = data["address"];
            var HTML6 = data["balance"];
            var HTML7 = data["status"];
            //alert(HTML);
            $("#supplierName").val(HTML);
            $("#compname").val(HTML2);
            $("#mobile").val(HTML3);
            $("#email").val(HTML4);
            $("#address").val(HTML5);
            $("#balance").val(HTML6);
            $("#status").val(HTML7);
            },
          error:function(){
            alert('error');
            }
          });
        });
      });
    </script>

    <script type="text/javascript" >
      $(document).ready(function(){
        $('#import_form').on('submit',function(event){
          event.preventDefault();
          $.ajax({
            url:"<?php echo base_url(); ?>Supplier/excel_import",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
              $('#file').val('');
              load_data();
              alert(data);
              }
            });
          });
        });
    </script>