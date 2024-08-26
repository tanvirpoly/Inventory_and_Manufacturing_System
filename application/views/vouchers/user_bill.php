<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Bill</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">My Bill</li>
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
                <h3 class="card-title">My Bill List</h3>
                <a class="btn btn-success btn-sm" href="<?php echo site_url(); ?>payBill" style="float: right" ><i class="fa fa-plus"></i> Pay Bill</a>
                <!--<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-example-modal-euser" style="float: right"  ><i class="fa fa-plus"></i> Pay Bill</button>-->
              </div>

              <div class="card-body">
                <table class="table table-responsive table-bordered" style="margin-bottom: 30px;" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Payment Date</th>
                      <th>Expire Date</th>
                      <th>Package</th>
                      <th>Payment</th>
                      <th style="width: 5%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $cdate = date('Y-m-d h:i:s');
                    $where = array(
                      'uid' => $_SESSION['uid']
                            );
            
                    $users = $this->pm->get_data('users',$where);
                    $payment = $this->db->select('*')
                                      ->from('user_payments')
                                      ->where('uid',$_SESSION['uid'])
                                      ->where('pstatus',1)
                                      ->order_by('up_id','desc')
                                      ->get()
                                      ->row();
                    ?>
                    
                    <?php if($payment && $payment->pdate < $cdate){
                    $j = 1;
                    
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $j; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($payment->regdate)); ?></td>
                      <td><?php echo date('d-m-Y', strtotime($payment->pdate)); ?></td>
                      <td><?php echo $payment->package; ?></td>
                      <td><?php echo number_format($payment->amount, 2); ?></td>
                      <td>
                        <!--<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-example-modal-e2user"  ><i class="fa fa-plus"></i></button>-->
                      </td>
                    </tr>
                    <?php }elseif(!$payment && $users){
                    $j = 1;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $j; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($users[0]['regdate'])); ?></td>
                      <td><?php echo date('d-m-Y', strtotime($users[0]['regdate'])); ?></td>
                      <td><?php echo 'N/A'; ?></td>
                      <td><?php echo '00'; ?></td>
                      <td>
                        <!--<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-example-modal-e3user" ><i class="fa fa-plus"></i></button>-->
                      </td>
                    </tr>
                    <?php }else{ 
                    $j = 0;
                    ?>
                    <?php } ?>
                  </tbody>
                </table>
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Payment Date</th>
                      <th>Expire Date</th>
                      <th>Package</th>
                      <th>Payment</th>
                      <th style="width: 5%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = $j;
                    foreach ($upayment as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['regdate'])); ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['pdate'])); ?></td>
                      <td><?php echo $value['package']; ?></td>
                      <td><?php echo number_format($value['amount'], 2); ?></td>
                      <td>
                        <?php if($value['pstatus'] == 1){ ?>
                          <?php echo 'Paid'; ?>
                        <?php }else{ ?>
                          <?php echo 'Processing'; ?>
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
          <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>requestapih">
            <div class="col-md-12 col-sm-12 col-xs-12">
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
                  <!--<option value="">Select One</option>-->
                  <!--<option value="1">One Month</option>-->
                  <!--<option value="2">Three Months</option>-->
                  <!--<option value="3">Six Months</option>-->
                  <option value="4">One Year</option>
                </select>
              </div>
              <div class="form-group">
                <label>Amount *</label>
                <input type="text" class="form-control" name="amount" id="pAmount"  placeholder="Amount" required readonly >
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit & Pay now</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-e2user" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Bill Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Voucher/save_bill_payment');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label class="">Select Package *</label>
                <select class="form-control" name="utype" required >
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
                <input type="text" class="form-control" name="amount" placeholder="Amount" required >
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
    
    <div class="modal fade bs-example-modal-e3user" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Bill Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Voucher/save_bill_payment');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label class="">Select Package *</label>
                <select class="form-control" name="utype" required >
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
                <input type="text" class="form-control" name="amount" placeholder="Amount" required >
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
    
    <script type="text/JavaScript">
        // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function(){
        'use strict';

        window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
              form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>