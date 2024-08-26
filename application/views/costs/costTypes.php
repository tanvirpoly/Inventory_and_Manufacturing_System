<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Expense Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Expense Type</li>
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
                <h3 class="card-title">Expense Type List</h3>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Expense Type</th>
                      <th style="width: 12%;">Status</th>
                      <th>Created Date</th>
                      <th style="width: 13%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($cost as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value->costName; ?></td>
                      <td><?php echo $value->status; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value->regdate)); ?></td>
                      <td>
                        <?php if($_SESSION['edit_ctype'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-xs cost_edit" data-toggle="modal" data-target=".bs-example-modal-cost_edit" data-id="<?php echo $value->ct_id; ?>" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_ctype'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Cost/cost_type_delete').'/'.$value->ct_id ?>" ><i class="fa fa-trash"></i></a>
                        <?php } ?> 
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="modal fade bs-example-modal-cost_edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Expense Type Information</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="<?php echo base_url('Cost/update_cost_type');?>" method="post">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Expense Type *</label>
                    <input type="text" class="form-control" name="expensetName" id="expensetName" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" >
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <input type="hidden" id="cat_id" name="cat_id" >
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        
        <?php if($_SESSION['new_ctype'] == 1){ ?>
          <div class="col-md-4 col-sm-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Expense Type Information</h3>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Cost/save_expense_type">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Expense Type *</label>
                    <input type="text" class="form-control" name="expensetName" placeholder="Expense Type" required >
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
        $(".cost_edit").click(function(){
          var catid = $(this).data('id');
          //alert(l_id);
          $('input[name="cat_id"]').val(catid);
          });

        $('.cost_edit').click(function(){
          var id = $(this).data('id');
          //alert(id);
          var url = '<?php echo base_url() ?>Cost/get_Cost_Type_data';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              //alert(data);
              var HTML = data["costName"];
              var HTML2 = data["status"];
              //alert(HTML);
              $("#expensetName").val(HTML);
              $("#status").val(HTML2);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>