<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Income Statement</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Income Statement</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Income Statement Reports</h3>
              </div>

              <div class="card-body">

                <div class="col-sm-12 col-md-12 col-12">
                  <div id="print">
                    <div class="row" id="header" style="display: none" >
                      <?php if($company){ ?>
                      <div class="col-sm-2 col-md-2 col-2" style="margin-top: 30px;">
                        <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>"  style="width: 100%;">
                      </div>
                      <div class="col-sm-10 col-md-10 col-10">
                        <div class="col-sm-12 col-md-12 col-12">
                          <h3><b><?php echo $company->com_name; ?></b></h3>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_address; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_email; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_mobile; ?></b>
                        </div>
                      </div>
                      <?php } ?>
                    </div><br>
                    
                    <div class="col-sm-12 col-md-12 col-12">
                      <table class="table table-bordered" >
                        <tbody>
                          <tr>
                            <td colspan="2"><b>Revenues</b></td>
                          </tr>
                          <tr>
                            <td><b>Sales Amount</b></td>
                            <td style="width: 20%;"><?php echo number_format($sale->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Credit Voucher</b></td>
                            <td style="width: 20%;"><?php echo number_format($cvoucher->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Total Income</b></td>
                            <td style="width: 20%;"><?php echo number_format(($sale->total+$cvoucher->total), 2); ?></td>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr>
                            <td colspan="2"><b>Expenses</b></td>
                          </tr>
                          <tr>
                            <td><b>Sales Purchase</b></td>
                            <td style="width: 20%;"><?php echo number_format($purchase->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Debit Voucher / Expense</b></td>
                            <td style="width: 20%;"><?php echo number_format($dvoucher->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Employee Payments</b></td>
                            <td style="width: 20%;"><?php echo number_format($empp->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Returns Amount</b></td>
                            <td style="width: 20%;"><?php echo number_format($return->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Supplier Pay Amount</b></td>
                            <td style="width: 20%;"><?php echo number_format($svoucher->total, 2); ?></td>
                          </tr>
                          <tr>
                            <td><b>Total Expense</b></td>
                            <td style="width: 20%;"><?php echo number_format(($purchase->total+$dvoucher->total+$empp->total+$return->total+$svoucher->total), 2); ?></td>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr>
                            <th><b>Net Income</b></th>
                            <th><?php echo number_format((($sale->total+$cvoucher->total)-($purchase->total+$dvoucher->total+$empp->total+$return->total+$svoucher->total)), 2); ?></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-12" align="center">
                      <div class="row">
                        <div class="col-md-3 col-sm-3 col-3">
                          <p style="margin-top: 30px;">-----------------------</p>
                          <p>Prepared By</p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                          <p style="margin-top: 30px;">-----------------------</p>
                          <p>Checked By</p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                          <p style="margin-top: 30px;">-----------------------</p>
                          <p>Verified By</p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                          <p style="margin-top: 30px;">-----------------------</p>
                          <p>Authorized By</p>
                        </div>
                      </div>
                    </div>
                  </div><br>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center;margin-top: 20px">
                    <a href="javascript:void(0)" style="width: 100px;" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          });
        });
    </script>