<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>
  
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transfer Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Transfer Account</li>
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
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Transfer Account</h3>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-newBank" style="float: right;" ><i class="fa fa-plus"></i> Balance Transfer</button>
            </div>

            <div class="card-body">
              <div class="col-md-12 col-sm-12 col-12">
                <table id="example" class="table table-bordered table-striped" >
                  <thead>
                    <tr style="text-transform:uppercase; text-align:center;">
                      <th style="width: 5%;">SN.</th>
                      <th>Date</th>
                      <th>Sending Account</th>
                      <th>Receiving Account</th>
                      <th>Transfer Amount</th>
                      <th>Note</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($cash as $value){
                    $i++;
                    $ac = $value['facType'];

                    if($ac == 'Bank')
                      {
                      $where = array(
                        'ba_id' => $value['facAcno']
                            );
                      $account = $this->pm->get_data('bankaccount',$where);
                      if(count($account) == 0)
                        {
                        $str = "N/A";
                        }
                      else
                        {
                        $str = $account[0]['bankName'].' '.$account[0]['branchName'].' '.$account[0]['accountNo'].' '.$account[0]['accountName'];
                        }
                      }
                    else if($ac == 'Mobile')
                      {
                      $where = array(
                        'ma_id' => $value['facAcno']
                            );

                      $account = $this->pm->get_data('mobileaccount',$where);
                      if(count($account) == 0)
                        {
                        $str = "N/A";
                        }
                      else
                        {
                        $str = $account[0]['accountName'].' '.$account[0]['accountNo'];
                        }
                      }
                    else if($ac == 'Cash')
                      {
                      $where = array(
                        'ca_id' => $value['facAcno']
                            );

                      $account = $this->pm->get_data('cash',$where);
                      if(count($account) == 0)
                        {
                        $str = "N/A";
                        }
                      else
                        {
                        $str = $account[0]['cashName'];
                        }
                      }

                    $a2c = $value['sacType'];

                    if($a2c == 'Bank')
                      {
                      $where = array(
                        'ba_id' => $value['facAcno']
                            );
                      $account = $this->pm->get_data('bankaccount',$where);
                      if(count($account) == 0)
                        {
                        $s2tr = "N/A";
                        }
                      else
                        {
                        $s2tr = $account[0]['bankName'].' '.$account[0]['branchName'].' '.$account[0]['accountNo'].' '.$account[0]['accountName'];
                        }
                      }
                    else if($a2c == 'Mobile')
                      {
                      $where = array(
                        'ma_id' => $value['facAcno']
                            );

                      $account = $this->pm->get_data('mobileaccount',$where);
                      if(count($account) == 0)
                        {
                        $s2tr = "N/A";
                        }
                      else
                        {
                        $s2tr = $account[0]['accountName'].' '.$account[0]['accountNo'];
                        }
                      }
                    else if($a2c == 'Cash')
                      {
                      $where = array(
                        'ca_id' => $value['facAcno']
                            );

                      $account = $this->pm->get_data('cash',$where);
                      if(count($account) == 0)
                        {
                        $s2tr = "N/A";
                        }
                      else
                        {
                        $s2tr = $account[0]['cashName'];
                        }
                      }
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['regdate'])) ?></td>
                      <td><?php echo $value['facType'].' :- '.$str; ?></td>
                      <td><?php echo $value['sacType'].' :- '.$s2tr; ?></td>
                      <td><?php echo number_format($value['amount'], 2); ?></td>
                      <td><?php echo $value['note']; ?></td>
                      <td>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url('CashAccount/delete_balance_transfer').'/'.$value['ta_id'] ?>" onclick="return confirm('Are you sure you want to delete this Balance Transfer ?');" ><i class="fa fa-trash"></i></a>
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

    <div class="modal fade bs-example-modal-newBank" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" >New Balance Transfer</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
          </div>
          <form action="<?php base_url() ?>CashAccount/save_transfer_account" method="post" >
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label>Sending Account *</label>
                <select class="form-control" name="accountType" id="accountType" required >
                  <option value="">Select One</option>
                  <option value="Cash">Cash</option>
                  <option value="Bank">Bank</option>
                  <option value="Mobile">Mobile</option>
                </select>
              </div>
              <div class="form-group">
                <label>Sending Account Number *</label>
                <select class="form-control" name="accountNo" id="accountNo" required >
                  <option value="">Select Account No.</option>
                </select>
              </div>
              <div class="form-group">
                <label>Receiving Account *</label>
                <select class="form-control" name="account2Type" id="account2Type" required >
                  <option value="">Select One</option>
                  <option value="Cash">Cash</option>
                  <option value="Bank">Bank</option>
                  <option value="Mobile">Mobile</option>
                </select>
              </div>
              <div class="form-group">
                <label>Receiving Account Number *</label>
                <select class="form-control" name="account2No" id="account2No" required >
                  <option value="">Select Account No.</option>
                </select>
              </div>
              <div class="form-group">
                <label>Transfer Amount</label>
                <input type="text" class="form-control" name="amount" placeholder="Amount" required >
              </div>
              <div class="form-group">
                <label>Note</label>
                <input type="text" class="form-control" name="note" placeholder="If have any note">
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

  </div>
<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $('#accountType').on('change',function(){
        var value = $(this).val();
        //alert(value);
        $('#accountNo').empty();
        getAccountNo(value,'#accountNo');
        });

      function getAccountNo(value,place)
        {
        $(place).empty();
        if(value != ''){
          $.ajax({
            url: '<?php echo site_url()?>Voucher/getAccountNo',
            async: false,
            dataType: "json",
            data: 'id=' + value,
            type: "POST",
            success: function (data){
              $(place).append(data);
              $(place).trigger("chosen:updated");
              }
            });
          }
        else
          {
          customAlert('Select Account Type',"error",true);
          }
        }
    </script>

    <script type="text/javascript">
      $('#account2Type').on('change',function(){
        var value = $(this).val();
        //alert(value);
        $('#account2No').empty();
        getAccountNo(value,'#account2No');
        });

      function getAccountNo(value,place)
        {
        $(place).empty();
        if(value != ''){
          $.ajax({
            url: '<?php echo site_url()?>Voucher/getAccountNo',
            async: false,
            dataType: "json",
            data: 'id=' + value,
            type: "POST",
            success: function (data){
              $(place).append(data);
              $(place).trigger("chosen:updated");
              }
            });
          }
        else
          {
          customAlert('Select Account Type',"error",true);
          }
        }
    </script>