 <!--  <style type="text/css">
    .page {
      page-break-after:always;
      position: relative;
      }
  </style> -->

  <div class="content-wrapper" style="min-height: 1126px;">    
    <section class="content-header">
      <h1>Transactions List</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="box">
          <div class="box-body">
            <form action="<?php echo base_url() ?>AccountBalance/transactions_list" method="get">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <b>
                    <input type="radio" name="reports" value="dailyReports" id="daily" required >&nbsp;&nbsp;Daily Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="reports" value="monthlyReports" id="monthly" required >&nbsp;&nbsp;Monthly Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="reports" value="yearlyReports" id="yearly" required >&nbsp;&nbsp;Yearly Reports
                  </b>
                </div>
                <div class="hidden" id="dreports">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Start Date *</label>
                      <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('d-m-Y') ?>" id="sdate" required="" >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>End Date *</label>
                      <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('d-m-Y') ?>" id="edate" required="" >
                    </div>
                    <div class="form-group col-md-1 col-sm-1 col-xs-12">
                      <button type="submit" name="search" class="btn btn-info" style="margin-top: 25px;"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Search</button>
                    </div>
                  </div>
                </div>

                <div class="hidden" id="mreports">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
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
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Year *</label>
                      <select class="form-control" name="year" id="year" required="" >
                        <option value="">Select Year</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                      </select>
                    </div>
                    <div class="form-group col-md-1 col-sm-1 col-xs-12">
                      <button type="submit" name="search" class="btn btn-info" style="margin-top: 25px;"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Search</button>
                    </div>
                  </div>
                </div>
                <div class="hidden" id="yreports">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Year *</label>
                      <select class="form-control" name="ryear" id="ryear" required="" >
                        <option value="">Select Year</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                      </select>
                    </div>
                    <div class="form-group col-md-1 col-sm-1 col-xs-12">
                      <button type="submit" name="search" class="btn btn-info" style="margin-top: 25px;"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Search</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div><hr>

          <div class="box-body">
            <div id="print">
              <div class="col-sm-12 col-md-12 col-xs-12">
                <?php if(isset($_GET['search'])) { ?>
                  <?php if ($report == 'dailyReports') { ?>
                  <div class="box-header" style="text-align: center;">
                    <h3 class="box-title"><b>Transaction Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                  </div>

                  <?php } else if ($report == 'monthlyReports') { ?>
                  <div class="box-header" style="text-align: center;">
                    <h3 class="box-title"><b>Transaction Reports in : <?php echo $name.' '.$year; ?></b></h3>
                  </div>

                  <?php } else if ($report == 'yearlyReports') { ?>
                  <div class="box-header" style="text-align: center;">
                    <h3 class="box-title"><b>Transaction Reports in : <?php echo $year; ?></b></h3>
                  </div>
                  <?php } ?>
                <?php } ?>
                <table id="datatable" class="table-responsive table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>DATE</th>
                      <th>TRANSACTION TYPE</th>
                      <th>ACCOUNT TYPE </th>
                      <th>CREADIT AMOUNT</th>
                      <th>DEBIT AMOUNT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($sale != null) { ?>

                    <?php
                    $i = 0;
                    $ts = 0;
                    foreach ($sale as $key => $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value->saleDate)); ?></td>
                      <td><?php echo 'Sales'; ?></td>
                      <td><?php echo $value->accountType; ?></td>
                      <td><?php echo number_format(($value->paidAmount), 2); $ts += $value->paidAmount; ?></td> 
                      <td><?php echo "00"; ?></td>
                    </tr>   
                    <?php } ?> 
                    <?php } else{ ?>
                    <?php $i = 0; $ts = 0; ?>
                    <?php } ?> 

                    <?php if ($purchase != null) { ?>

                    <?php
                    $j = $i;
                    $tp = 0;
                    foreach ($purchase as $key => $value) {
                    $j++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $j; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value->purchaseDate)); ?></td>
                      <td><?php echo 'Purchase'; ?></td>
                      <td><?php echo $value->accountType; ?></td>
                      <td><?php echo "00"; ?></td> 
                      <td><?php echo number_format(($value->paidAmount), 2); $tp += $value->paidAmount; ?></td>
                    </tr>   
                    <?php } ?>
                    <?php } else{ ?>
                    <?php $j = $i or $j = 0; $tp = 0; ?>
                    <?php } ?> 

                    <?php if ($empp != null) { ?>

                    <?php
                    $k = $j;
                    $tep = 0;
                    foreach ($empp as $key => $value) {
                    $k++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $k; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value->regdate)); ?></td>
                      <td><?php echo 'Employee Payments'; ?></td>
                      <td><?php echo $value->accountType; ?></td>
                      <td><?php echo "00"; ?></td> 
                      <td><?php echo number_format(($value->salary), 2); $tep += $value->salary; ?></td>
                    </tr>   
                    <?php } ?>
                    <?php } else{ ?>
                    <?php $k = $j or $k = $i or $k = 0; $tep = 0; ?>
                    <?php } ?> 

                    <?php if ($return != null) { ?>

                    <?php
                    $l = $k;
                    $tr = 0;
                    foreach ($return as $key => $value) {
                    $l++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $l; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value->returnDate)); ?></td>
                      <td><?php echo 'Returns'; ?></td>
                      <td><?php echo $value->accountType; ?></td>
                      <td><?php echo "00"; ?></td> 
                      <td><?php echo number_format(($value->totalPrice-$value->scAmount), 2); $tr += ($value->totalPrice-$value->scAmount); ?></td>
                    </tr>   
                    <?php } ?> 
                    <?php } else{ ?>
                    <?php $l = $i or $l = $j or $l = $k or $l = 0; $tr = 0; ?>
                    <?php } ?> 

                    <?php if ($voucher != null) { ?>

                    <?php
                    $m = $l;
                    $tcv = 0;
                    $tdv = 0;
                    foreach ($voucher as $key => $value) {
                    $m++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $m; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value->voucherdate)); ?></td>
                      <td><?php echo 'Voucher'; ?></td>
                      <td><?php echo $value->accountType; ?></td>
                      <td>
                        <?php if($value->vauchertype == 'Credit Voucher') { ?>
                        <?php echo number_format(($value->totalamount), 2); $tcv += $value->totalamount; ?>
                        <?php } else { ?>
                        <?php echo "00"; ?>
                        <?php } ?>
                      </td> 
                      <td>
                        <?php if($value->vauchertype != 'Credit Voucher') { ?>
                        <?php echo number_format(($value->totalamount), 2); $tdv += $value->totalamount; ?>
                        <?php } else{ ?>
                        <?php echo "00"; ?>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php } ?> 
                    <?php } else{ ?>
                    <?php $m = $l or $m = $i or $m = $j or $m = $k or $m = 0; $tdv = 0; ?>
                    <?php } ?> 

                    <?php if ($damage != null) { ?>

                    <?php
                    $n = $m;
                    $tda = 0;
                    foreach ($damage as $key => $value) {
                    $n++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $n; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value->damagedate)); ?></td>
                      <td><?php echo 'Damages'; ?></td>
                      <td><?php echo $value->accountType; ?></td>
                      <td>
                        <?php echo "00"; ?>
                      </td> 
                      <td>
                        <?php echo number_format(($value->totalPrice-$value->scAmount), 2); $tda += ($value->totalPrice-$value->scAmount); ?>
                      </td>
                    </tr>
                    <?php } ?>
                    <?php } else{ ?>
                    <?php $tda = 0; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4"></th>
                      <th><?php echo number_format($ts+$tcv, 2); ?></th>
                      <th><?php echo number_format($tp+$tep+$tr+$tdv+$tda, 2); ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-xs-12" style="text-align: center;">
              <a href="javascript:void(0)" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


    <script>
      $(document).ready(function() {
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','hidden');
          $('#mreports').attr('class','hidden');
          $('#yreports').attr('class','hidden');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','hidden');
          $('#dreports').attr('class','hidden');
          $('#yreports').attr('class','hidden');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','hidden');
          $('#dreports').attr('class','hidden');
          $('#mreports').attr('class','hidden');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          });
        });
    </script>