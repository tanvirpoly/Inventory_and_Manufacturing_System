<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">User Role</li>
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
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Role</h3>
              </div>

              <div class="card-body">
                <table class="table table-responsive table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width: 10%;">#SN.</th>
                      <th style="width: 40%;">User Role</th>
                      <th style="width: 30%;">Status</th>
                      <th style="width: 20%;">Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($role as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">      
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['lavelName']; ?></td>
                      <td><?php echo $value['status']; ?></td>
                      <td>
                        <?php if($_SESSION['edit_utype'] == '1') { ?>
                        <button type="button" class="btn btn-primary btn-xs urole_edit" data-toggle="modal" data-target=".bs-example-modal-sm" data-id="<?php echo $value['ax_id']; ?>" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_utype'] == '1') { ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('User/delete_user_role').'/'.$value['ax_id']?>" ><i class="fa fa-trash"></i></a>
                        <?php }  ?>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php if($_SESSION['new_utype'] == '1') { ?>
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Role Information</h3>
              </div>
              <div class="card-body">
                <form method="post" action="<?php echo base_url() ?>User/save_accesslavel">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>User Role Name *</label>
                    <input type="text" class="form-control" name="lavelName" required placeholder="Role Name" >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <button type="submit" class="form-control btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php }  ?>
        </div>

        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" >User Role Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              <form action="<?php echo base_url('User/update_user_role');?>" method="post">
                <div class="col-md-12 col-sm-12 col-12">
                  <div class="row">
                    <div class="form-group col-md-12 col-sm-12 col-12">
                      <label>Role Name *</label>
                      <input type="text" class="form-control" name="lavelName" id="lavelName" required >
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12">
                      <label>Status</label>
                      <select class="form-control" name="status" id="status" >
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                    </div>
                  </div>
                  <input type="hidden" id="catid" name="roleid" >
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".urole_edit").click(function(){
          var catid = $(this).data('id');
          //alert(l_id);
          $('input[name="roleid"]').val(catid);
          });

        $('.urole_edit').click(function(){
          var id = $(this).data('id');
          //alert(id);
          var url = '<?php echo base_url() ?>User/get_user_role_data';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              //alert(data);
              var HTML = data["lavelName"];
              var HTML3 = data["status"];
              //alert(HTML);
              $("#lavelName").val(HTML);
              $("#status").val(HTML3);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>