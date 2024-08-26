<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier Ledger</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Supplier Ledger</li>
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
                <h3 class="card-title">Supplier Ledger</h3>
              </div>

              <div class="card-body">
                <div class="col-md-12 col-sm-12 col-12">
                  <form action="<?php echo base_url() ?>supplierLedger" method="get">
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <b>
                          <input type="radio" name="reports" value="dailyReports" id="daily" required >&nbsp;&nbsp;Daily Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="monthlyReports" id="monthly" required >&nbsp;&nbsp;Monthly Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="yearlyReports" id="yearly" required >&nbsp;&nbsp;Yearly Reports
                        </b>
                      </div>

                      <div class="d-none" id="dreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Start Date *</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('m/d/Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('m/d/Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <div>
                            <select class="form-control select2" name="dsupplier"  required="" id="dsupplier" style="width: 100%;" >
                              <option value="">Select One</option>
                              <?php foreach($supplier as $row){ ?>
                              <option value="<?php echo $row['supplierID']; ?>"><?php echo $row['supplierName'].' ( '.$row['sup_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="mreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Month *</label>
                            <select class="form-control" name="month" id="month" required="" >
                              <option value="">Select Month</option>
                              <option value="01">January</option>
                              <option value="02">February</option>
                              <option value="03">March</option>
                              <option value="04">April</option>
                              <option value="05">May</option>
                              <option value="06">June</option>
                              <option value="07">July</option>
                              <option value="08">August</option>
                              <option value="09">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Year *</label>
                            <?php $d = date("Y"); ?>
                            <select class="form-control" name="year" id="year" required="" >
                              <option value="">Select Year</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <div>
                            <select class="form-control select2" name="msupplier"  required="" id="msupplier" style="width: 100%;" >
                              <option value="">Select One</option>
                              <?php foreach($supplier as $row){ ?>
                              <option value="<?php echo $row['supplierID']; ?>"><?php echo $row['supplierName'].' ( '.$row['sup_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="yreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Year *</label>
                            <select class="form-control" name="ryear" id="ryear" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select Year</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Supplier *</label>
                            <div>
                            <select class="form-control select2" name="ysupplier"  required="" id="ysupplier" style="width: 100%;" >
                              <option value="">Select One</option>
                              <?php foreach($supplier as $row){ ?>
                              <option value="<?php echo $row['supplierID']; ?>"><?php echo $row['supplierName'].' ( '.$row['sup_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>

                <div class="col-md-12 col-sm-12 col-12">
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
                    </div>
                    <div class="col-sm-12 col-md-12 col-12">
                    <?php if(isset($_GET['search'])) { ?>
                      <div class="col-sm-12 col-md-12 col-12">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                          Supplier ID&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $supp[0]['sup_id']; ?>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          Supplier Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $supp[0]['supplierName']; ?>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $supp[0]['address']; ?>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          Contact No&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $supp[0]['mobile']; ?>
                        </div>
                      </div>
                      <?php if ($report == 'dailyReports') { ?>
                      <div class="box-header" style="text-align: center;">
                        <h3 class="box-title"><b>Supplier Ledger Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                      </div>

                      <?php } else if ($report == 'monthlyReports') { ?>
                      <div class="box-header" style="text-align: center;">
                        <h3 class="box-title"><b>Supplier Ledger Reports in : <?php echo $name.' '.$year; ?></b></h3>
                      </div>

                      <?php } else if ($report == 'yearlyReports') { ?>
                      <div class="box-header" style="text-align: center;">
                        <h3 class="box-title"><b>Supplier Ledger Reports in : <?php echo $year; ?></b></h3>
                      </div>
                      <?php } ?>
                    <?php } ?>

                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>#SN.</th>
                            <th>Date</th>
                            <th>Purchase No.</th>
                            <th>Particulars</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($purchase != null) { ?>
                          <?php
                          $i = 0;
                          $tpa = 0;
                          $tap = 0;
                          $td = 0;
                          foreach ($purchase as $result){
                          $i++;
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($result->purchaseDate)); ?></td>
                            <td><?php echo $result->challanNo; ?></td>
                            <td><?php echo 'Purchase'; ?></td>
                            <td><?php echo number_format($result->totalPrice, 2); $tpa += $result->totalPrice; ?></td>
                            <td><?php echo number_format($result->paidAmount, 2); $tap += $result->paidAmount; ?></td>
                            <td>
                              <?php echo number_format($result->due, 2); $td += $result->due; ?>
                            </td>
                          </tr>
                          <?php } ?> 
                          <?php } else{ ?>
                          <?php $i = 0; ?>
                          <?php $tpa = 0; $tap = 0; $td = 0; ?>
                          <?php } ?>

                          <?php if ($voucher != null) { ?>

                          <?php
                          $j = $i;
                          $tvpa = 0;
                          foreach ($voucher as $value) {
                          $j++;
                          ?>
                          <tr class="gradeX">
                            <td><?php echo $j; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($value->voucherdate)); ?></td>
                            <td><?php echo $value->invoice; ?></td>
                            <td><?php echo $value->vauchertype; ?></td>
                            <td><?php echo '00'; ?></td> 
                            <td><?php echo number_format(($value->totalamount), 2); $tvpa += $value->totalamount; ?></td> 
                            <td><?php echo '00'; ?></td>
                          </tr>   
                          <?php } ?>
                          <?php } else{ ?>
                          <?php $j = $i or $j = 0; ?>
                          <?php $tvpa = 0; ?>
                          <?php } ?> 
                        </tbody>
                        <tfoot>
                            <tr>
                          <th colspan="4" style="text-align: right;">Total Amount</th>
                          <th><?php echo number_format($tpa, 2); ?></th>
                          <th><?php echo number_format(($tap+$tvpa), 2); ?></th>
                          <th><?php echo number_format(($tpa-($tap+$tvpa)), 2); ?></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="form-group col-sm-12 col-md-12 col-12" style="text-align: center; margin-top: 20px">
                    <a href="javascript:void(0)" style="width: 100px;" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"> </i>  Print</a>
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

    <script type="text/javascript" >
      $(document).ready(function(){
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          $('#ddate').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#msupplier').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ysupplier').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dsupplier').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#msupplier').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ysupplier').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dsupplier').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#msupplier').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#ysupplier').attr('required','required');
          });
        });
    </script>