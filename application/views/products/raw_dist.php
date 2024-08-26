<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Raw Material Distribution Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Raw Material Distribution Report</li>
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
                <h3 class="card-title">Raw Material Distribution Report</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>rawDistReport" method="get">
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <b>
                          <input type="radio" name="reports" value="dailyReports" id="daily" required >&nbsp;&nbsp;Daily Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="monthlyReports" id="monthly" required>&nbsp;&nbsp;Monthly Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="reports" value="yearlyReports" id="yearly" required>&nbsp;&nbsp;Yearly Reports
                        </b>
                      </div>

                      <div class="d-none" id="dreports">
                        <div class="row">
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Start Date *</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('m/d/Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('m/d/Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus"></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="mreports">
                        <div class="row">
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Month *</label>
                            <select class="form-control" name="month" id="month" required="">
                              <option value="">Select One</option>
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="year" id="year" required="">
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus"></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="yreports">
                        <div class="row">
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="ryear" id="ryear" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-xs-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="col-sm-12 col-md-12 col-12">
                  <div id="print">
                    <div id="header" style="display: none">
                      <div class="row">
                        <div class="col-sm-2 col-md-2 col-2">
                          <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="width: 100%;" alt="company logo" >
                        </div>
                        <div class="col-sm-8 col-md-8 col-8" style="text-align: center">
                          <div class="col-sm-12 col-md-12 col-12">
                            <h3><b><?php echo $company->com_name; ?></b></h3>
                          </div>
                          <div class="col-sm-12 col-md-12 col-12">
                            <?php echo $company->com_address; ?>
                          </div>
                          <div class="col-sm-12 col-md-12 col-12">
                            <?php echo $company->com_email; ?>
                          </div>
                          <div class="col-sm-12 col-md-12 col-12">
                            <?php echo $company->com_mobile; ?>
                          </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-2" style="margin-top:30px;">
                          <div class="col-sm-12 col-md-12 col-12">
                            Date &nbsp;:&nbsp;<?php echo date('d-m-Y'); ?>
                          </div>
                        </div>
                      </div><br>
                    </div>

                    <div class="col-sm-12 col-md-12 col-12" style="overflow-x: auto;">
                      <table id="example" class="table table-bordered" style="width: 100%; ">
                        <thead>
                          <tr>
                            <th style="width: 5%;">#SN.</th>
                            <th>Raw Materials</th>
                            <th>Opening</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <?php foreach($mdept as $mvalue){ ?>
                            <th><?php echo $mvalue['mdName']; ?></th>
                            <?php } ?>
                            <th>Total Send</th>
                            <th>Total Amount</th>
                            <th>Closing Qty</th>
                            <th>Closing Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach($product as $value){
                          $i++;

                          if(isset($_GET['search']))
                            {
                            $report = $_GET['reports'];
                            if($report == 'dailyReports')
                              {
                              $oproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) <',$sdate)
                                              ->get()
                                              ->row();
                              $mproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate)',$sdate)
                                              ->get()
                                              ->row();
                              }
                            else if($report == 'monthlyReports')
                              {
                              $oproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                              $mproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              }
                            else if($report == 'yearlyReports')
                              {
                              $oproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              $mproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              }
                            if($oproduct)
                              {
                              $opening = $oproduct->tqnt;
                              }
                            else
                              {
                              $opening = 0;
                              }
                            }
                          else
                            {
                            $mproduct = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->get()
                                              ->row();
                            
                            $opening = 0;
                            }
                          if($mproduct)
                            {
                            $tqnt = $mproduct->tqnt;
                            }
                          else
                            {
                            $tqnt = 0;
                            }
                          if($tqnt>0){
                          ?>
                          
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['productName']; ?></td>
                            <td><?php echo $opening; ?></td>
                            <td><?php echo $tqnt; ?></td>
                            <td><?php echo number_format($value['pprice'], 2); ?></td>
                            <td><?php echo number_format(($value['pprice']*$tqnt), 2); ?></td>
                            <?php 
                            $tfpqnt = 0;
                            foreach($mdept as $md)
                              {
                              if(isset($_GET['search']))
                                {
                                $report = $_GET['reports'];
                                if($report == 'dailyReports')
                                  {
                                  $ompqnt = $this->db->select('SUM(manufact_product.quantity) as tqnt,manufact_cproduct.pid,products.mdid')
                                                  ->from('manufact_product')
                                                  ->join('manufact_cproduct','manufact_cproduct.mid = manufact_product.mid', 'left')
                                                  ->join('products','products.productID = manufact_cproduct.pid', 'left')
                                                  ->where('manufact_product.pid',$value['productID'])
                                                  ->where('products.mdid',$md['md_id'])
                                                  ->where('DATE(manufact_product.regdate)',$sdate)
                                                  ->get()
                                                  ->row();          
                                  }
                                else if($report == 'monthlyReports')
                                  {
                                  $ompqnt = $this->db->select('SUM(manufact_product.quantity) as tqnt,manufact_cproduct.pid,products.mdid')
                                                  ->from('manufact_product')
                                                  ->join('manufact_cproduct','manufact_cproduct.mid = manufact_product.mid', 'left')
                                                  ->join('products','products.productID = manufact_cproduct.pid', 'left')
                                                  ->where('manufact_product.pid',$value['productID'])
                                                  ->where('products.mdid',$md['md_id'])
                                                  ->where('MONTH(manufact_product.regdate)',$month)
                                                  ->where('YEAR(manufact_product.regdate)',$year)
                                                  ->get()
                                                  ->row();       
                                  }
                                else if($report == 'yearlyReports')
                                  {
                                  $ompqnt = $this->db->select('SUM(manufact_product.quantity) as tqnt,manufact_cproduct.pid,products.mdid')
                                                  ->from('manufact_product')
                                                  ->join('manufact_cproduct','manufact_cproduct.mid = manufact_product.mid', 'left')
                                                  ->join('products','products.productID = manufact_cproduct.pid', 'left')
                                                  ->where('manufact_product.pid',$value['productID'])
                                                  ->where('products.mdid',$md['md_id'])
                                                  ->where('YEAR(manufact_product.regdate)',$year)
                                                  ->get()
                                                  ->row();                
                                  }
                                }
                              else
                                {
                                $ompqnt = $this->db->select('SUM(manufact_product.quantity) as tqnt,manufact_cproduct.pid,products.mdid')
                                              ->from('manufact_product')
                                              ->join('manufact_cproduct','manufact_cproduct.mid = manufact_product.mid', 'left')
                                              ->join('products','products.productID = manufact_cproduct.pid', 'left')
                                              ->where('manufact_product.pid',$value['productID'])
                                              ->where('products.mdid', $md['md_id'])
                                              ->get()
                                              ->row();
                                }
                              if($ompqnt)
                                {
                                $dpqntout = $ompqnt->tqnt;
                                }
                              else
                                {
                                $dpqntout = '0';
                                }
                              ?>
                            <td><?php echo number_format($dpqntout, 2); $tfpqnt += $dpqntout; ?></td>
                            <?php }?>
                            <td><?php echo $tfpqnt; ?></td>
                            <td><?php echo number_format(($value['pprice']*$tfpqnt), 2); ?></td>
                            <td><?php echo (($opening+$tqnt)-$tfpqnt); ?></td>
                            <td><?php echo number_format(($value['pprice']*(($opening+$tqnt)-$tfpqnt)), 2); ?></td>
                          </tr>
                          <?php }  }?>
                        </tbody>
                      </table>
                    </div>
                    <div class="row no-print">
                      <div class="col-12" style="text-align: center;">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')"><i class="fas fa-print"></i> Print</a>
                      </div>
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
      $(document).ready(function(){
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