<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Supplier Report</li>
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
                <h3 class="card-title">Supplier Report</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>supplierReport" method="get">
                    
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
                          <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus"></i>&nbsp;Search</button>
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
                          <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus"></i>&nbsp;Search</button>
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
                          <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>

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
                  <?php if(isset($_GET['search'])) { ?>
                    <?php if ($report == 'dailyReports') { ?>
                      <div class="box-header" style="text-align: center;">
                        <h3 class="box-title"><b>Supplier Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                      </div>
                    <?php } else if ($report == 'monthlyReports') { ?>
                      <div class="box-header" style="text-align: center;">
                        <h3 class="box-title"><b>Supplier Reports in : <?php echo $name.' '.$year; ?></b></h3>
                      </div>
                    <?php } else if ($report == 'yearlyReports') { ?>
                      <div class="box-header" style="text-align: center;">
                        <h3 class="box-title"><b>Supplier Reports in : <?php echo $year; ?></b></h3>
                      </div>
                    <?php } ?>
                  <?php } ?>    
                  <table id="example" class="table table-responsive table-bordered" >
                    <thead>
                      <tr>
                        <th style="width: 5%;">#SN.</th>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 13%;">ID</th>
                        <th style="width: 15%;">Mobile</th>
                        <th style="width: 12%;">Opening</th>
                        <th style="width: 10%;">Purchases</th>
                        <th style="width: 10%;">Paid</th>
                        <th style="width: 10%;">Payment</th>
                        <th style="width: 10%;">Due</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      $toa = 0;
                      $ta = 0;
                      $tpa = 0;
                      $pat = 0;
                      $tda = 0;
                      foreach ($supplier as $row){
                      $i++;

                      $id = $row['supplierID'];

                      if(isset($_GET['search']))
                        {
                        $report = $_GET['reports'];
                        $data['report'] = $report;
                          //var_dump($data['report']); exit();
                        if($report == 'dailyReports')
                          {
                          $tpur = $this->db->select("SUM(totalPrice) as total,SUM(paidAmount) as ptotal,SUM(due) as dtotal")
                                            ->FROM('purchase')
                                            ->WHERE('supplier',$id)
                                            ->where('purchaseDate >=',$sdate)
                                            ->where('purchaseDate <=',$edate)
                                            ->get()
                                            ->row();

                          $tvpaid = $this->db->select("SUM(totalamount) as total")
                                              ->FROM('vaucher')
                                              ->WHERE('supplier',$id)
                                              ->where('voucherdate >=', $sdate)
                                              ->where('voucherdate <=', $edate)
                                              ->get()
                                              ->row();
                          }
                        else if($report == 'monthlyReports')
                          {
                          $tpur = $this->db->select("SUM(totalPrice) as total,SUM(paidAmount) as ptotal,SUM(due) as dtotal")
                                            ->FROM('purchase')
                                            ->WHERE('supplier',$id)
                                            ->where('MONTH(purchaseDate)',$month)
                                            ->where('YEAR(purchaseDate)',$year)
                                            ->get()
                                            ->row();

                          $tvpaid = $this->db->select("SUM(totalamount) as total")
                                            ->FROM('vaucher')
                                            ->WHERE('supplier',$id)
                                            ->where('MONTH(voucherdate)',$month)
                                            ->where('YEAR(voucherdate)',$year)
                                            ->get()
                                            ->row();
                          }
                        elseif($report == 'yearlyReports')
                          {
                          $tpur = $this->db->select("SUM(totalPrice) as total,SUM(paidAmount) as ptotal,SUM(due) as dtotal")
                                            ->FROM('purchase')
                                            ->WHERE('supplier',$id)
                                            ->where('YEAR(purchaseDate)',$year)
                                            ->get()
                                            ->row();

                          $tvpaid = $this->db->select("SUM(totalamount) as total")
                                            ->FROM('vaucher')
                                            ->WHERE('supplier',$id)
                                            ->where('YEAR(voucherdate)',$year)
                                            ->get()
                                            ->row();
                          }
                        }
                      else
                        {
                        $tpur = $this->db->select("SUM(totalPrice) as total,SUM(paidAmount) as ptotal,SUM(due) as dtotal")
                                          ->FROM('purchase')
                                          ->WHERE('supplier',$id)
                                          ->get()
                                          ->row();

                        $tvpaid = $this->db->select("SUM(totalamount) as total")
                                            ->FROM('vaucher')
                                            ->WHERE('supplier',$id)
                                            ->get()
                                            ->row();
                        }
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['supplierName']; ?></td>
                        <td><?php echo $row['sup_id']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo number_format($row['balance'], 2); $toa += $row['balance']; ?></td>
                        <td><?php echo number_format($tpur->total, 2); $ta += $tpur->total; ?></td>
                        <td><?php echo number_format($tpur->ptotal, 2); $tpa += $tpur->ptotal; ?></td>
                        <td><?php echo number_format($tvpaid->total, 2); $pat += $tvpaid->total; ?></td>
                        <td><?php echo number_format((($row['balance']+$tpur->dtotal)-$tvpaid->total), 2); $tda += (($row['balance']+$tpur->dtotal)-$tvpaid->total); ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4" style="text-align: right;">Total Amount</th>
                        <th><?php echo number_format($toa, 2); ?></th>
                        <th><?php echo number_format($ta, 2); ?></th>
                        <th><?php echo number_format($tpa, 2); ?></th>
                        <th><?php echo number_format($pat, 2); ?></th>
                        <th><?php echo number_format($tda, 2); ?></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px">
                  <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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