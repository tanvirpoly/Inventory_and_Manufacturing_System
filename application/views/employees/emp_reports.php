  <div class="content-wrapper">
    <section class="content-header" style="background: #f2f2f2;padding-bottom: 10px">
      <h1>SalesMan / Employee Report</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="box">
          <div class="box-body">
            <form action="<?php echo base_url() ?>Employee/sales_Man_Report" method="get">
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
                  <h3 class="box-title"><b>Employee / Salesman Reports in : <?php echo $sdate.' - '.$edate; ?></b></h3>
                </div>

                <?php } else if ($report == 'monthlyReports') { ?>
                <div class="box-header" style="text-align: center;">
                  <h3 class="box-title"><b>Employee / Salesman Reports in : <?php echo $name.' '.$year; ?></b></h3>
                </div>

                <?php } else if ($report == 'yearlyReports') { ?>
                <div class="box-header" style="text-align: center;">
                  <h3 class="box-title"><b>Employee / Salesman Reports in : <?php echo $year; ?></b></h3>
                </div>
                <?php } ?>
              <?php } ?>

                <div id="table-content">
                  <table id="datatable" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>#SN.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Sales</th>
                        <!-- <?php if(isset($_GET['search'])) { ?>
                        <?php if ($report == 'monthlyReports') { ?>
                        <th>Target</th>
                        <th>Achieve ( %)</th>
                        <?php } ?>
                        <?php } ?> -->
                        <th>Paid</th>
                        <th>Returns</th>
                        <th>Net Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      $ts = 0;
                      $td = 0;
                      $tp = 0;
                      $tr = 0;
                      $tn = 0;
                      foreach ($employee as $rep){
                      $i++;
                      $id = $rep['uid'];

                      if(isset($_GET['search']))
                        {
                        $report = $_GET['reports'];
                        $data['report'] = $report;

                        if($report == 'dailyReports')
                          {
                          $tsale = $this->db->select("SUM(`totalAmount`) as total,SUM(`paidAmount`) as ptotal,SUM(`discountAmount`) as dtotal")
                                        ->FROM('sales')
                                        ->WHERE('regby',$id)
                                        ->where('saleDate >=', $sdate)
                                        ->where('saleDate <=', $edate)
                                        ->get()
                                        ->row();

                          $trp = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as stotal")
                                        ->FROM('returns')
                                        ->WHERE('empid',$id)
                                        ->where('returnDate >=', $sdate)
                                        ->where('returnDate <=', $edate)
                                        ->get()
                                        ->row();
                          }
                        else if($report == 'monthlyReports')
                          {
                          $tsale = $this->db->select("SUM(`totalAmount`) as total,SUM(`paidAmount`) as ptotal,SUM(`discountAmount`) as dtotal")
                                        ->FROM('sales')
                                        ->WHERE('regby',$id)
                                        ->where('MONTH(saleDate)',$month)
                                        ->where('YEAR(saleDate)',$year)
                                        ->get()
                                        ->row();

                          $trp = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as stotal")
                                        ->FROM('returns')
                                        ->WHERE('empid',$id)
                                        ->where('MONTH(returnDate)',$month)
                                        ->where('YEAR(returnDate)',$year)
                                        ->get()
                                        ->row();

                          $est = $this->db->select("*")
                                        ->FROM('emp_target')
                                        ->WHERE('empid',$id)
                                        ->where('month',$month)
                                        ->where('year',$year)
                                        ->get()
                                        ->row();
                          if ($est)
                            {
                            $esta = $est->tamount;
                            }
                          else
                            {
                            $esta = 0;
                            }
                          }
                        else if($report == 'yearlyReports')
                          {
                          $tsale = $this->db->select("SUM(`totalAmount`) as total,SUM(`paidAmount`) as ptotal,SUM(`discountAmount`) as dtotal")
                                        ->FROM('sales')
                                        ->WHERE('regby',$id)
                                        ->where('YEAR(saleDate)',$year)
                                        ->get()
                                        ->row();

                          $trp = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as stotal")
                                        ->FROM('returns')
                                        ->WHERE('empid',$id)
                                        ->where('YEAR(returnDate)',$year)
                                        ->get()
                                        ->row();
                          }
                        }
                      else
                        {
                        $tsale = $this->db->select("SUM(`totalAmount`) as total,SUM(`paidAmount`) as ptotal,SUM(`discountAmount`) as dtotal")
                                      ->FROM('sales')
                                      ->WHERE('regby',$id)
                                      ->get()
                                      ->row();

                        $trp = $this->db->select("SUM(`totalPrice`) as total,SUM(`scAmount`) as stotal")
                                      ->FROM('returns')
                                      ->WHERE('empid',$id)
                                      ->get()
                                      ->row();
                        }
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $rep['name']; ?></td>
                        <td><?php echo $rep['mobile']; ?></td>
                        <td><?php echo number_format(($tsale->total-$tsale->dtotal), 2); $ts += ($tsale->total-$tsale->dtotal); ?></td>
                       <!--  <?php if(isset($_GET['search'])) { ?>
                        <?php if ($report == 'monthlyReports') { ?>
                        <td><?php echo number_format($esta, 2); ?></td>
                        <td>
                          <?php if($esta == 0){ ?>
                          <?php echo '0 %'; ?>
                          <?php } else { ?>
                          <?php echo number_format((($tsale->total-$tsale->dtotal)*100)/$esta).' %'; ?>
                          <?php } ?>
                          </td>
                        <?php } ?>
                        <?php } ?> -->
                        <td><?php echo number_format($tsale->ptotal, 2); $tp += $tsale->ptotal; ?></td>
                        <td><?php echo number_format(($trp->total-$trp->stotal), 2); $tr += ($trp->total-$trp->stotal); ?></td>
                        <td>
                          <?php $tduea = (($tsale->total+$trp->stotal)-($tsale->dtotal+$tsale->ptotal+$trp->total)); ?>
                          <?php echo number_format($tduea, 2); $tn += $tduea; ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3" >Total</th>
                        <th><?php echo number_format($ts,2); ?></th>
                        <!-- <?php if(isset($_GET['search'])) { ?>
                        <?php if ($report == 'monthlyReports') { ?>
                          <th></th>
                          <th></th>
                        <?php } ?>
                        <?php } ?> -->
                        <th><?php echo number_format($tp, 2); ?></th>
                        <th><?php echo number_format($tr, 2); ?></th>
                        <th><?php echo number_format($tn, 2); ?></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <table class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                  <tr align="center">
                    <td class="col-md-3 col-sm-3 col-xs-3">
                      <p>------------------------------</p>
                      <p>Prepared By</p>
                    </td>
                    <td class="col-md-3 col-sm-3 col-xs-3">
                      <p>------------------------------</p>
                      <p>Checked By</p>
                    </td>
                    <td class="col-md-3 col-sm-3 col-xs-3">
                      <p>------------------------------</p>
                      <p>Verified By</p>
                    </td>
                    <td class="col-md-3 col-sm-3 col-xs-3">
                      <p>------------------------------</p>
                      <p>Authorized By</p>
                    </td>
                  </tr>
                </table>
              </div>
            </div><br>
            <div class="form-group col-md-12" style="text-align: center;margin-top: 20px">
              <a href="javascript:void(0)" style="width: 100px;" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"> </i>  Print</a>
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