<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Balance Sheet</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Balance Sheet</li>
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
                <h3 class="card-title">Balance Sheet Reports</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>cusLedger" method="get">
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="form-group">
                        <b>
                          <!-- <input type="radio" name="reports" value="ocust" id="ocust" required >&nbsp;&nbsp;Customer All Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="dailyReports" id="daily" required >&nbsp;&nbsp;Daily Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="monthlyReports" id="monthly" required >&nbsp;&nbsp;Monthly Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="yearlyReports" id="yearly" required >&nbsp;&nbsp;Yearly Ledger -->
                        </b>
                      </div>

                      <div class="d-none" id="dreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Start Date *</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('d-m-Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('d-m-Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <div>
                            <select name="dcustomer" class="form-control select2" id="dcustomer" required="" style="width: 100%;">
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['customerID']; ?>" ><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <div>
                            <select name="mcustomer" class="form-control select2" id="mcustomer" required="" style="width: 100%;">
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['customerID']; ?>" ><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="yreports">
                        <div class="row">
                          <div class="form-group col-md-2 col-sm-2 col-12">
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <div>
                            <select name="ycustomer" class="form-control select2" id="ycustomer" required="" style="width: 100%;">
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['customerID']; ?>" ><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="reports">
                        <div class="row">
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <div>
                            <select name="customer" class="form-control select2" id="customer" required="" style="width: 100%;">
                              <option value="">Select One</option>
                              <?php foreach ($customer as $value) { ?>
                              <option value="<?php echo $value['customerID']; ?>" ><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div><hr>

                <div class="box-body">
                  <div id="print">
                      <?php if($company) { ?>
                    <div class="row" id="header" style="display: none" >
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
                    </div>
                    <?php } ?>
                    <?php if(isset($_GET['search'])) { ?>
                    <?php if ($report == 'dailyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Balance Sheet Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'monthlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Balance Sheet Reports in : <?php echo $name.' '.$year; ?></b></h3>
                    </div>
                    <?php } else if ($report == 'yearlyReports') { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Balance Sheet Reports in : <?php echo $year; ?></b></h3>
                    </div>
                    <?php } else { ?>
                    <div class="box-header" style="text-align: center;">
                      <h3 class="box-title"><b>Balance Sheet Reports</b></h3>
                    </div>
                    <?php } }  ?>
                  
                    <div id="table-content">
                      <table id="" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Liabilities</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="gradeX">
                            <td><?php echo 'Credit'; ?></td>
                            <td><?php echo number_format(($debit), 2); ?></td>
                          </tr>
                          <tr class="gradeX">
                            <td><?php echo 'Profit & Loss'; ?></td>
                            <td><?php echo number_format(($profit), 2); ?></td>
                          </tr>
                          <tr class="gradeX">
                            <td><?php echo 'Opening Balance'; ?></td>
                            <td><?php echo '00'; ?></td>
                          </tr>
                          <tr class="gradeX">
                            <td><?php echo 'Select Period'; ?></td>
                            <td><?php echo '00'; ?></td>
                          </tr>
                          <tr class="gradeX">
                            <td><?php echo 'Deference in Opening Balance'; ?></td>
                            <td><?php echo '00'; ?></td>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr class="gradeX">
                            <th><?php echo "Total"; ?></th>
                            <th>
                              <?php $tca = $debit+$profit; ?>
                              <?php echo number_format(($tca), 2); ?>
                            </th>
                          </tr>
                        </tbody>
                      </table>
                      
                      <table id="" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Assets</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="gradeX">
                            <td><?php echo "Cash in Hands"; ?></td>
                            <td><?php echo number_format(($cash), 2); ?></td> 
                          </tr>
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo "Bank"; ?></td>-->
                          <!--  <td><?php echo number_format(($bank), 2); ?></td>-->
                          <!--</tr>-->
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo 'Mobile'; ?></td>-->
                          <!--  <td><?php echo number_format(($mobile), 2); ?></td>-->
                          <!--</tr>-->
                          <tr class="gradeX">
                            <td><?php echo "Debit"; ?></td>
                            <td><?php echo number_format(($credit), 2); ?></td> 
                          </tr>
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo 'Credit'; ?></td>-->
                          <!--  <td><?php echo number_format(($debit), 2); ?></td>-->
                          <!--</tr>-->
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo "Purchase"; ?></td>-->
                          <!--  <td><?php echo number_format(($purchase->ttotal), 2); ?></td>-->
                          <!--</tr>-->
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo 'Purchase Return'; ?></td>-->
                          <!--  <td><?php echo "00"; ?></td>-->
                          <!--</tr>-->
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo "Sales"; ?></td>-->
                          <!--  <td><?php echo number_format(($sale->ttotal), 2); ?></td>-->
                          <!--</tr>-->
                          <!--<tr class="gradeX">-->
                          <!--  <td><?php echo 'Sales Return'; ?></td>-->
                          <!--  <td><?php echo number_format(($rsale), 2); ?></td>-->
                          <!--</tr>-->
                          <tr class="gradeX">
                            <td><?php echo 'Closing Inventory'; ?></td>
                            <td>
                              <?php
                              $tob = 0;
                              foreach ($store as $value) {
                              ?>
                              <?php $tob += $value->totalPices*$value->pprice; ?>
                              <?php } ?> 
                              <?php echo number_format(($tob), 2); ?>
                            </td>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr class="gradeX">
                            <th><?php echo "Total"; ?></th>
                            <th>
                              <?php $tda = $cash+$credit+$tob; ?>
                              <?php echo number_format(($tda), 2); ?>
                            </th>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div><br>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px">
                    <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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

    <script type="text/javascript">
      $(document).ready(function(){
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');
          $('#reports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          $('#dcustomer').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');

          $('#customer').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');
          $('#reports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#mcustomer').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');

          $('#customer').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#reports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#ycustomer').attr('required','required');

          $('#customer').removeAttr('required','required');
          });

        $('#ocust').click(function(){
          $('#yreports').attr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#reports').removeAttr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');

          $('#customer').attr('required','required');
          });
        });
    </script> 