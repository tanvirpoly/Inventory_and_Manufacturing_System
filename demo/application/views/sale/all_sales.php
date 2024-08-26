<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <!--<section class="content-header">-->
    <!--  <div class="container-fluid">-->
    <!--    <div class="row mb-2">-->
    <!--      <div class="col-sm-6">-->
    <!--        <h1>Sale Reports</h1>-->
    <!--      </div>-->
    <!--      <div class="col-sm-6">-->
    <!--        <ol class="breadcrumb float-sm-right">-->
    <!--          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>-->
    <!--          <li class="breadcrumb-item active">Sale Reports</li>-->
    <!--        </ol>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">SALE REPORT</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>saleReport" method="get">
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
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('d-m-Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('d-m-Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <select class="form-control" name="dcustomer" id="dcustomer" required="" >
                              <option value="All">All</option>
                              <?php foreach($customer as $value){ ?>
                              <option value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Outlet *</label>
                            <select class="form-control" name="demployee" id="demployee" required="" >
                              <option value="All">All</option>
                              <?php foreach($employee as $value){ ?>
                              <option value="<?php echo $value['uid']; ?>"><?php echo $value['name'].' ( '.$value['empid'].' )'; ?></option>
                              <?php } ?>
                            </select>
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
                              <?php $d = date("Y"); ?>
                            <option value="">Select Year</option>
                            <?php for ($x = 2020; $x <= $d; $x++) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                            <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <select class="form-control" name="mcustomer" id="mcustomer" required="" >
                              <option value="All">All</option>
                              <?php foreach($customer as $value){ ?>
                              <option value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Outlet *</label>
                            <select class="form-control" name="memployee" id="memployee" required="" >
                              <option value="All">All</option>
                              <?php foreach($employee as $value){ ?>
                              <option value="<?php echo $value['uid']; ?>"><?php echo $value['name'].' ( '.$value['empid'].' )'; ?></option>
                              <?php } ?>
                            </select>
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
                              <?php $d = date("Y"); ?>
                            <option value="">Select Year</option>
                            <?php for ($x = 2020; $x <= $d; $x++) { ?>
                            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                            <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Customer *</label>
                            <select class="form-control" name="ycustomer" id="ycustomer" required="" >
                              <option value="All">All</option>
                              <?php foreach($customer as $value){ ?>
                              <option value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Outlet *</label>
                            <select class="form-control" name="yemployee" id="yemployee" required="" >
                              <option value="All">All</option>
                              <?php foreach($employee as $value){ ?>
                              <option value="<?php echo $value['uid']; ?>"><?php echo $value['name'].' ( '.$value['empid'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-xs-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

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
                      <table id="example" class="table table-bordered" >
                        <thead>
                          <tr>
                            <th style="width: 5%;">SN</th>
                            <th style="width: 15%;">INVOICE</th>
                            <th style="width: 15%;">DATE</th>
                            <!--<th style="width: 12%;">Sales Man</th>-->
                            <th style="width: 17%;">CUSTOMER</th>
                            <th style="width: 10%;">TOTAL</th>
                            <th style="width: 10%;">PAID</th>
                            <th style="width: 10%;">DISCOUNT</th>
                            <th style="width: 10%;">DUE</th>
                            <th style="width: 8%;">OPTION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          $ts = 0;
                          $tp = 0;
                          $td = 0;
                          $tda = 0;
                          foreach ($sales as $sale){
                          $i++;
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $sale->invoice_no; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($sale->regdate)); ?></td>
                            <!--<td><?php echo $sale->name; ?></td>-->
                            <td><?php echo $sale->customerName; ?></td>
                            <td><?php echo number_format($sale->totalAmount, 2); $ts += $sale->totalAmount; ?></td>
                            <td><?php echo number_format($sale->paidAmount, 2); $tp += $sale->paidAmount; ?></td>
                            <td><?php echo number_format($sale->discountAmount, 2); $td += $sale->discountAmount; ?></td>
                            <td style="color: red;"><?php echo number_format($sale->dueamount, 2); $tda += $sale->dueamount; ?></td>
                            <td>
                              <a target="_blank" class="btn btn-info btn-xs" href="<?php echo site_url('viewSale').'/'.$sale->saleID ?>"><i class="fas fa-eye"></i>
                              </a>
                            </td> 
                          </tr> 
                          <?php } ?>
                        </tbody>
                        <tbody>
                          <tr>
                            <td colspan="4" align="right"><b>TOTAL</b></td>
                            <td><b><?php echo number_format($ts, 2); ?></b></td>
                            <td><b><?php echo number_format($tp, 2); ?></b></td>
                            <td><b><?php echo number_format($td, 2); ?></b></td>
                            <td><b style="color: red;"><?php echo number_format($tda, 2); ?></b></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row no-print" >
                      <div class="col-12" style="text-align: center;">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      </div>
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
      $(document).ready(function() {
        $('#daily').click(function(){
          $('#dreports').removeAttr('class','d-none');
          $('#mreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').attr('required','required');
          $('#edate').attr('required','required');
          $('#dcustomer').attr('required','required');
          $('#demployee').attr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          $('#memployee').removeAttr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');
          $('#yemployee').removeAttr('required','required');
          });

        $('#monthly').click(function(){
          $('#mreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#yreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          $('#demployee').removeAttr('required','required');
          
          $('#month').attr('required','required');
          $('#year').attr('required','required');
          $('#mcustomer').attr('required','required');
          $('#memployee').attr('required','required');
          
          $('#ryear').removeAttr('required','required');
          $('#ycustomer').removeAttr('required','required');
          $('#yemployee').removeAttr('required','required');
          });

        $('#yearly').click(function(){
          $('#yreports').removeAttr('class','d-none');
          $('#dreports').attr('class','d-none');
          $('#mreports').attr('class','d-none');

          $('#sdate').removeAttr('required','required');
          $('#edate').removeAttr('required','required');
          $('#dcustomer').removeAttr('required','required');
          $('#demployee').removeAttr('required','required');
          
          $('#month').removeAttr('required','required');
          $('#year').removeAttr('required','required');
          $('#mcustomer').removeAttr('required','required');
          $('#memployee').removeAttr('required','required');
          
          $('#ryear').attr('required','required');
          $('#ycustomer').attr('required','required');
          $('#yemployee').attr('required','required');
          });
        });
    </script>