<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Payment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">User Payment</li>
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
                <h3 class="card-title">User Payment List</h3>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-example-modal-euser" style="float: right"  ><i class="fa fa-plus"></i> Pay Bill</button>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Date</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Package</th>
                      <th>Payment</th>
                      <th style="width: 5%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($users as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['regdate'])); ?></td>
                      <td><?php echo $value['compid']; ?></td>
                      <td><?php echo $value['name']; ?></td>
                      <td><?php echo $value['mobile']; ?></td>
                      <td><?php echo $value['package']; ?></td>
                      <td><?php echo number_format($value['amount'], 2); ?></td>
                      <td>
                        <?php if($value['pstatus'] == 1){ ?>
                          <?php echo 'Paid'; ?>
                        <?php }else{ ?>
                          <a href="<?php echo site_url('Voucher/user_payment_active').'/'.$value['up_id'] ?>" type="button" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to active this payment ?');" ><i class="fa fa-check" ></i></a>
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
  
  
    <div class="modal fade bs-example-modal-euser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Bill Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>Voucher/save_user_payment">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label class="">Select User *</label>
                <div>
                <select class="form-control select2" name="uid" required style="width: 100%;" >
                  <option value="">Select One</option>
                  <?php foreach($pusers as $value){ ?>
                  <option value="<?php echo $value['uid']; ?>"><?php echo $value['name'].' ( '.$value['mobile'].' )'; ?></option>
                  <?php } ;?>
                </select>
                </div>
              </div>
              <div class="form-group">
                <label class="">Select Package *</label>
                <select class="form-control" name="utype" id="uType" required >
                  <option value="">Select One</option>
                  <option value="Basic">Basic</option>
                  <option value="Standard">Standard</option>
                  <option value="Premium">Premium</option>
                </select>
              </div>
              <div class="form-group">
                <label class="">Select Package Time*</label>
                <select class="form-control" name="ptime" required >
                  <option value="">Select One</option>
                  <option value="1">One Month</option>
                  <option value="2">Three Months</option>
                  <option value="3">Six Months</option>
                  <option value="4">One Year</option>
                </select>
              </div>
              <div class="form-group">
                <label>Amount *</label>
                <input type="text" class="form-control" name="amount" id="pAmount"  placeholder="Amount" required >
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

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#uType').change(function(){ 
          var id = $('#uType').val();
          if(id == 'Basic')
            {
            var tpa = 4999;
            }
          else if(id == 'Standard')
            {
            var tpa = 9999;
            }
          else if(id == 'Premium')
            {
            var tpa = 19999;
            }
          else
            {
            var tpa = 0;
            }
          $('#pAmount').val(parseFloat(tpa).toFixed(2));
          });
        });
    </script>