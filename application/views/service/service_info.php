<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Service</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Service Information List</h3>
                <button type="button" class="btn btn-primary nService" data-toggle="modal" data-target=".bs-example-modal-nService" style="float: right; margin-left: 10px;" ><i class="fa fa-plus"></i>&nbsp;New Service</button>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Code</th>
                      <th>Service Name</th>
                      <th>Price</th>
                      <th>Details</th>
                      <!--<th>Status</th>-->
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($service as $value) {
                    $id = $value['siid'];
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['siCode']; ?></td>
                      <td><?php echo $value['siName']; ?></td>
                      <td><?php echo number_format($value['siPrice'], 2); ?></td>
                      <td><?php echo $value['siDetails']; ?></td>
                      <!--<td><?php echo $value['status']; ?></td>-->
                      <td>
                        <button type="button" class="btn btn-success btn-sm eService" data-toggle="modal" data-target=".bs-example-modal-eService" data-id="<?php echo $id; ?>" id="<?php echo $id; ?>" onclick="document.getElementById('eService').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url('Service/delete_service_info').'/'.$id; ?>" onclick="return confirm('Are you sure you want to delete this Service ?');" ><i class="fa fa-trash"></i></a>
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
    </div>
  </div>

    <div class="modal fade bs-example-modal-nService" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Service Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form method="POST" action="<?php echo base_url() ?>Service/save_service_info" >
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Service Name *</label>
              <input type="text" class="form-control" name="sName" placeholder="Service Name" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Service Charge *</label>
              <input type="text" class="form-control" name="sPrice" placeholder="Amount" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Service Details</label>
              <textarea class="form-control" name="sDetails" placeholder="Service Details Information" rows="5"></textarea>
            </div>
            <div class="modal-footer form-group">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-eService" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Service Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form method="POST" action="<?php echo base_url() ?>Service/update_service_info" >
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Service Name *</label>
              <input type="text" class="form-control" name="sName" id="sName" placeholder="Service Name" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Service Charge *</label>
              <input type="text" class="form-control" name="sPrice" id="sPrice" placeholder="Amount" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Service Details</label>
              <textarea class="form-control" name="sDetails" id="sDetails" placeholder="Service Details Information" rows="5"></textarea>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-12">
              <label>Status</label>
              <select class="form-control" name="status" id="status" >
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <input type="hidden" id="siid" name="siid" required >
            <div class="modal-footer form-group">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.eService',function(){
          var catid = $(this).attr("id");
            //alert(l_id);
          $('input[name="siid"]').val(catid);
          });

        $(document).on('click','.eService',function(){
          var id = $(this).attr("id");
          var url = '<?php echo base_url() ?>Service/get_service_info_data';
            //alert(url);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
              //alert(data);
              var HTML = data["siName"];
              var HTML2 = data["siPrice"];
              var HTML3 = data["siDetails"];
              var HTML4 = data["status"];
              //alert(HTML);
              $("#sName").val(HTML);
              $("#sPrice").val(HTML2);
              $("#sDetails").val(HTML3);
              $("#status").val(HTML4);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>