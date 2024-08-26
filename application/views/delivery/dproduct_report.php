<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

<style type="text/css" media="print">
    @page {
      size: A4 landscape;
      margin: 0;
    }

    /* Adjust the table to fit the width of the page */
    #example {
      width: 100%;
    }
</style>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery Product Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery Reports</li>
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
                <h3 class="card-title">Delivery Product Reports</h3>
              </div>

              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>pdivReport" method="get">
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Start Date *</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('m/d/Y') ?>" id="sdate" required="" >
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>End Date *</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('m/d/Y') ?>" id="edate" required="" >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                          </div>
                        </div>
                      </div>

                      <div class="d-none" id="mreports">
                        <div class="row">
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>Select Month *</label>
                            <select class="form-control" name="month" id="month" required="" >
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
                            <select class="form-control" name="year" id="year" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
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
                            <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Search</button>
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
                          <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="width: 100%;">
                        </div>
                        <div class="col-sm-8 col-md-8 col-8" style="text-align: center" >
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
                        <div class="col-sm-2 col-md-2 col-2" style="margin-top:30px;" >
                          <div class="col-sm-12 col-md-12 col-12">
                            Date &nbsp;:&nbsp;<?php echo date('d-m-Y'); ?>
                          </div>
                        </div>
                      </div><br>
                    </div>
                    
                    <div class="col-sm-12 col-md-12 col-12">
                      <table id="example" class="table table-striped table-bordered" style="width:100%"  >
                        <thead>
                          <tr>
                            <th style="width: 5%;">#SN.</th>
                            <th>Products</th>
                            <th>Opening</th>
                            <th>QNT</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <?php foreach($outlet as $ovalue){ ?>
                            <th><?php echo $ovalue['employeeName']; ?></th>
                            <?php } ?>
                            <th>Sales</th>
                            <th>Closing</th>
                            <th>Dif. Qnt.</th>
                            <th>Dif. Amt.</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                                //   var_dump ($sales);
                          foreach($product as $value){
                          $i++;
                          if(isset($_GET['search']))
                            {
                            $report = $_GET['reports'];
                            if($report == 'dailyReports')
                              {
                              $ospqnt = $this->db->select('SUM(totalPices) as tqnt')
                                              ->from('stock_store')
                                              ->where('product',$value['productID'])
                                              ->where('DATE(regdate) <', $sdate)
                                              ->get()
                                              ->row();
                              $oppqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) <', $sdate)
                                              ->get()
                                              ->row();
                              $osapqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('sale_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) <', $sdate)
                                              ->get()
                                              ->row();
                              $orpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('returns_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) <', $sdate)
                                              ->get()
                                              ->row();
                              $ompqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('manufact_cproduct')
                                              ->where('pid',$value['productID'])
                                              ->where('DATE(regdate) <', $sdate)
                                              ->get()
                                              ->row();
                              $odpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('delivery_product')
                                              ->where('pid',$value['productID'])
                                              ->where('DATE(regdate) <', $sdate)
                                              ->get()
                                              ->row();
                              
                              
                              $spqnt = $this->db->select('SUM(totalPices) as tqnt')
                                              ->from('stock_store')
                                              ->where('product',$value['productID'])
                                              ->where('DATE(regdate) >=', $sdate)
                                              ->where('DATE(regdate) <=', $edate)
                                              ->get()
                                              ->row();
                              $ppqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) >=', $sdate)
                                              ->where('DATE(regdate) <=', $edate)
                                              ->get()
                                              ->row();
                              $sapqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('sale_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) >=', $sdate)
                                              ->where('DATE(regdate) <=', $edate)
                                              ->get()
                                              ->row();
                              $rpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('returns_product')
                                              ->where('productID',$value['productID'])
                                              ->where('DATE(regdate) >=', $sdate)
                                              ->where('DATE(regdate) <=', $edate)
                                              ->get()
                                              ->row();
                              $mpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('manufact_cproduct')
                                              ->where('pid',$value['productID'])
                                              ->where('DATE(regdate) >=', $sdate)
                                              ->where('DATE(regdate) <=', $edate)
                                              ->get()
                                              ->row();
                              $dpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('delivery_product')
                                              ->where('pid',$value['productID'])
                                              ->where('DATE(regdate) >=', $sdate)
                                              ->where('DATE(regdate) <=', $edate)
                                              ->get()
                                              ->row();
                              }
                            else if($report == 'monthlyReports')
                              {
                              $ospqnt = $this->db->select('SUM(totalPices) as tqnt')
                                              ->from('stock_store')
                                              ->where('product',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                              $oppqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                              $osapqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('sale_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                              $orpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('returns_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                              $ompqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('manufact_cproduct')
                                              ->where('pid',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                              $odpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('delivery_product')
                                              ->where('pid',$value['productID'])
                                              ->where('MONTH(regdate) <', $month)
                                              ->where('YEAR(regdate) <=', $year)
                                              ->get()
                                              ->row();
                                              
                              $spqnt = $this->db->select('SUM(totalPices) as tqnt')
                                              ->from('stock_store')
                                              ->where('product',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $ppqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $sapqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('sale_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $rpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('returns_product')
                                              ->where('productID',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $mpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('manufact_cproduct')
                                              ->where('pid',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $dpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('delivery_product')
                                              ->where('pid',$value['productID'])
                                              ->where('MONTH(regdate)', $month)
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              }
                            else if($report == 'yearlyReports')
                              {
                              $ospqnt = $this->db->select('SUM(totalPices) as tqnt')
                                              ->from('stock_store')
                                              ->where('product',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              $oppqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              $osapqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('sale_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              $orpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('returns_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              $ompqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('manufact_cproduct')
                                              ->where('pid',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              $odpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('delivery_product')
                                              ->where('pid',$value['productID'])
                                              ->where('YEAR(regdate) <', $year)
                                              ->get()
                                              ->row();
                              
                              $spqnt = $this->db->select('SUM(totalPices) as tqnt')
                                              ->from('stock_store')
                                              ->where('product',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $ppqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('purchase_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $sapqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('sale_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $rpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('returns_product')
                                              ->where('productID',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $mpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('manufact_cproduct')
                                              ->where('pid',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              $dpqnt = $this->db->select('SUM(quantity) as tqnt')
                                              ->from('delivery_product')
                                              ->where('pid',$value['productID'])
                                              ->where('YEAR(regdate)', $year)
                                              ->get()
                                              ->row();
                              }
                            $otqnt = (($ospqnt->tqnt+$oppqnt->tqnt+$orpqnt->tqnt+$ompqnt->tqnt)-($osapqnt->tqnt+$odpqnt->tqnt));
                            //$otqnt = $odpqnt->tqnt;
                            }
                          else
                            {
                            $otqnt = 0;
                            
                            $spqnt = $this->db->select('SUM(totalPices) as tqnt')
                                          ->from('stock_store')
                                          ->where('product',$value['productID'])
                                          ->get()
                                          ->row();
                            $ppqnt = $this->db->select('SUM(quantity) as tqnt')
                                          ->from('purchase_product')
                                          ->where('productID',$value['productID'])
                                          ->get()
                                          ->row();
                            $sapqnt = $this->db->select('SUM(quantity) as tqnt')
                                          ->from('sale_product')
                                          ->where('productID',$value['productID'])
                                          ->get()
                                          ->row();
                            $rpqnt = $this->db->select('SUM(quantity) as tqnt')
                                          ->from('returns_product')
                                          ->where('productID',$value['productID'])
                                          ->get()
                                          ->row();
                            $mpqnt = $this->db->select('SUM(quantity) as tqnt')
                                          ->from('manufact_cproduct')
                                          ->where('pid',$value['productID'])
                                          ->get()
                                          ->row();
                            $dpqnt = $this->db->select('SUM(quantity) as tqnt')
                                          ->from('delivery_product')
                                          ->where('pid',$value['productID'])
                                          ->get()
                                          ->row();
                            }
                          //$tqnt = $dpqnt->tqnt;
                          $tqnt = (($spqnt->tqnt+$ppqnt->tqnt+$rpqnt->tqnt+$mpqnt->tqnt)-($sapqnt->tqnt+$dpqnt->tqnt));
                          $stqnt = $sapqnt->tqnt;
                            // var_dump($sale->did);
                            // var_dump($mp);
                        //   if($tqnt>0){
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['productName']; ?></td>
                            <td><?php echo $otqnt; ?></td>
                            <td><?php echo $tqnt; ?></td>
                            <td><?php echo number_format($value['sprice'], 2); ?></td>
                            <td><?php echo number_format(($value['sprice']*$tqnt), 2); ?></td>
                            <?php 
                            $tdqnt = 0;
                            foreach($outlet as $ovalue){
                              if(isset($_GET['search']))
                                {
                                $report = $_GET['reports'];
                                if($report == 'dailyReports')
                                  {
                                  $outdpqnt = $this->db->select('SUM(delivery_product.quantity) as tqnt,delivery.empid')
                                                  ->from('delivery_product')
                                                  ->join('delivery','delivery.did = delivery_product.did','left')
                                                  ->where('pid',$value['productID'])
                                                  ->where('empid',$ovalue['employeeID'])
                                                  ->where('DATE(delivery_product.regdate) >=', $sdate)
                                                  ->where('DATE(delivery_product.regdate) <=', $edate)
                                                  ->get()
                                                  ->row();
                                  }
                                else if($report == 'monthlyReports')
                                  {
                                  $outdpqnt = $this->db->select('SUM(delivery_product.quantity) as tqnt,delivery.empid')
                                                  ->from('delivery_product')
                                                  ->join('delivery','delivery.did = delivery_product.did','left')
                                                  ->where('pid',$value['productID'])
                                                  ->where('empid',$ovalue['employeeID'])
                                                  ->where('MONTH(delivery_product.regdate)', $month)
                                                  ->where('YEAR(delivery_product.regdate)', $year)
                                                  ->get()
                                                  ->row();
                                  }
                                else if($report == 'yearlyReports')
                                  {
                                  $outdpqnt = $this->db->select('SUM(delivery_product.quantity) as tqnt,delivery.empid')
                                                  ->from('delivery_product')
                                                  ->join('delivery','delivery.did = delivery_product.did','left')
                                                  ->where('pid',$value['productID'])
                                                  ->where('empid',$ovalue['employeeID'])
                                                  ->where('YEAR(delivery_product.regdate)', $year)
                                                  ->get()
                                                  ->row();
                                  }
                                }
                              else
                                {
                                $outdpqnt = $this->db->select('SUM(delivery_product.quantity) as tqnt,delivery.empid')
                                                  ->from('delivery_product')
                                                  ->join('delivery','delivery.did = delivery_product.did','left')
                                                  ->where('pid',$value['productID'])
                                                  ->where('empid',$ovalue['employeeID'])
                                                  ->get()
                                                  ->row();
                                }
                              if($outdpqnt)
                                {
                                $dpqntout = $outdpqnt->tqnt;
                                }
                              else
                                {
                                $dpqntout = '0';
                                }
                              ?>
                            <td><?php echo $dpqntout; $tdqnt += $dpqntout; ?></td>
                            <?php } ?>
                            <td><?php echo $stqnt; ?></td>
                            <td><?php echo (($otqnt+$tqnt)-$stqnt); ?></td>
                            <td><?php echo ($tqnt-$stqnt); ?></td>
                            <td><?php echo number_format(($value['sprice']*($tqnt-$stqnt))); ?></td>
                          </tr> 
                          <?php  }?>
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