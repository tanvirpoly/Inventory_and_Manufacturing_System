<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Department</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Department</li>
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
          <div class="col-md-8 col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Department List</h3>
              </div>

              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Department</th>
                      <th style="width: 12%;">Status</th>
                      <th>Created Date</th>
                      <th style="width: 13%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($dept as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['dept_name']; ?></td>  
                      <td><?php echo $value['status']; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['regdate'])); ?></td>     
                      <td>
                        <?php if($value['dpt_id'] > 0){ ?>
                        <?php if($_SESSION['edit_department'] == 1){ ?>
                        <button type="button" class="btn btn-primary btn-xs dept_edit" data-toggle="modal" data-target=".bs-example-modal-sm" data-id="<?php echo $value['dpt_id']; ?>" onclick="document.getElementById('dept_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_department'] == 1){ ?>
                        <!--<a class=" btn btn-danger btn-xs" href="<?php echo site_url('employee/delete_dept').'/'.$value['dpt_id'] ?>" ><i class="fa fa-trash"></i></a>-->
                        <?php } } ?>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content" >
                <div class="modal-header">
                  <h5 class="modal-title">Department Information</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                </div>
                <form action="<?php echo base_url('Employee/update_dept');?>" method="post">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Department Name *</label>
                    <input type="text" class="form-control" name="department" id="department" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" >
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <input type="hidden" id="dept_id" name="dept_id" >
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        
        <?php if($_SESSION['new_department'] == 1){ ?>
          <div class="col-md-4 col-sm-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Department Information</h3>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Employee/save_department") ?>">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Department Name</label>
                    <input type="text" name="department" class="form-control" placeholder="Department Name" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" >
                    <button type="submit" class="form-control btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".dept_edit").click(function(){
          var catid = $(this).data('id');
          //alert(l_id);
          $('input[name="dept_id"]').val(catid);
          });

        $('.dept_edit').click(function(){
          var id = $(this).data('id');
            //alert(id);
          var url = '<?php echo base_url() ?>Employee/get_dept_data';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              //alert(data);
              var HTML = data["dept_name"];
              var HTML2 = data["status"];
            //alert(HTML);
              $("#department").val(HTML);
              $("#status").val(HTML2);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>