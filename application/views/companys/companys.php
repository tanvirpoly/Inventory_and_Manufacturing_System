<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Company / Warehouse</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Company / Warehouse</li>
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
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Company / Warehouse List</h3>
                <button type="button" class="btn btn-primary newComp" data-toggle="modal" data-target=".bs-example-modal-newComp" style="float: right;" ><i class="fa fa-plus"></i> New Warehouse</button>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped  table-bordered" >
                  <thead>
                    <tr>
                      <th>#SN.</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th style="width: 8%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($companys as $key => $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['com_name']; ?></td>
                      <td><?php echo $value['com_mobile']; ?></td>
                      <td><?php echo $value['com_email']; ?></td>
                      <td><?php echo $value['com_address']; ?></td>       
                      <td>
                        <button type="button" class="btn btn-success btn-xs editComp" data-toggle="modal" data-target=".bs-example-modal-editComp" data-id="<?php echo $value['com_pid']; ?>" onclick="document.getElementById('editComp').style.display='block'" ><i class="fa fa-edit"></i></button>
                        <a class=" btn btn-danger btn-xs" href="<?php echo site_url('Company/delete_company').'/'.$value['com_pid']; ?>" onclick="return confirm('Are you sure you want to delete this Warehouse ?');" ><i class="fa fa-trash"></i></a>
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

    <div id="newComp" class="modal fade bs-example-modal-newComp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Warehouse Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Company/save_company'); ?>" method="POST">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label>Warehouse Name *</label>
                <input type="text" class="form-control" name="com_name" placeholder="Company / Warehouse Name" required >
              </div>
              <div class="form-group">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="com_mobile" placeholder="Contact Number" required >
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="com_email" placeholder="example@gmail.com" >
              </div>
              <div class="form-group">
                <label>Address *</label>
                <input type="text" class="form-control" name="com_address" placeholder="Address" required >
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="editComp" class="modal fade bs-example-modal-editComp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Warehouse Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Company/update_company'); ?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label>Warehouse Name *</label>
                <input type="text" class="form-control" name="com_name" id="com_name" required >
              </div>
              <div class="form-group">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="com_mobile" id="com_mobile" required >
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="com_email" id="com_email" >
              </div>
              <div class="form-group">
                <label>Address *</label>
                <input type="text" class="form-control" name="com_address"  id="com_address" required >
              </div>
            </div>
            <input type="hidden" id="com_pid" name="com_pid" required >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".editComp").click(function(){
          var com_pid = $(this).data('id');
            //alert(l_id);
          $('input[name="com_pid"]').val(com_pid);
          });

        $('.editComp').click(function(){
          var id = $(this).data('id');
          var url = '<?php echo base_url() ?>Company/get_company_data';
                //alert(id); alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
                //alert(data);
              var HTML = data["com_name"];
              var HTML2 = data["com_address"];
              var HTML3 = data["com_mobile"];
              var HTML4 = data["com_email"];
                //alert(HTML);
              $("#com_name").val(HTML);
              $("#com_address").val(HTML2);
              $("#com_mobile").val(HTML3);
              $("#com_email").val(HTML4);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>