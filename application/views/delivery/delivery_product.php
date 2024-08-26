<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

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
                  <form action="<?php echo base_url() ?>deliveryProduct" method="get">
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
                            <label>From *</label>
                            <div>
                            <select class="form-control select2" name="duser" style="width: 100%;" >
                              <option value="All">Select All</option>
                              <?php foreach ($users as $value) { ?>
                              <option value="<?php echo $value['uid']; ?>" ><?php echo $value['name']; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>To *</label>
                            <div>
                            <select class="form-control select2" name="demployee" style="width: 100%;">
                              <option value="All">Select All</option>
                              <?php foreach ($employee as $value) { ?>
                              <option value="<?php echo $value['employeeID']; ?>" ><?php echo $value['employeeName']; ?></option>
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
                          <div class="form-group col-md-2 col-sm-2 col-12">
                            <label>Select Year *</label>
                            <select class="form-control" name="year" id="year" required="" >
                              <?php $d = date("Y"); ?>
                              <option value="">Select One</option>
                              <?php for ($x = 2020; $x <= $d; $x++) { ?>
                              <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>From *</label>
                            <div>
                            <select class="form-control select2" name="muser" style="width: 100%;" >
                              <option value="All">Select All</option>
                              <?php foreach ($users as $value) { ?>
                              <option value="<?php echo $value['uid']; ?>" ><?php echo $value['name']; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>To *</label>
                            <div>
                            <select class="form-control select2" name="memployee" style="width: 100%;">
                              <option value="All">Select All</option>
                              <?php foreach ($employee as $value) { ?>
                              <option value="<?php echo $value['employeeID']; ?>" ><?php echo $value['employeeName']; ?></option>
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
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>From *</label>
                            <div>
                            <select class="form-control select2" name="yuser" style="width: 100%;" >
                              <option value="All">Select All</option>
                              <?php foreach ($users as $value) { ?>
                              <option value="<?php echo $value['uid']; ?>" ><?php echo $value['name']; ?></option>
                              <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3 col-sm-3 col-12">
                            <label>To *</label>
                            <div>
                            <select class="form-control select2" name="yemployee" style="width: 100%;">
                              <option value="All">Select All</option>
                              <?php foreach ($employee as $value) { ?>
                              <option value="<?php echo $value['employeeID']; ?>" ><?php echo $value['employeeName']; ?></option>
                              <?php } ?>
                            </select>
                            </div>
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
                    
                    <div class="">
                      <table id="example" class="table table-responsive table-bordered" >
                        <thead>
                          <tr>
                            <th style="width: 5%;">#SN.</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th style="width: 10%;">Notes</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          $tsa = 0;
                          $tpa = 0;
                          $tda = 0;
                        //   var_dump ($sales);
                          foreach ($sales as $sale){
                          $i++;
                          
                          $mp = $this->db->select('
                                        delivery_product.quantity,
                                        products.productName,
                                        sma_units.unitName')
                                  ->from('delivery_product')
                                  ->join('products','products.productID = delivery_product.pid','left')
                                  ->join('sma_units','sma_units.id = products.unit','left')
                                  ->where('did',$sale->did)
                                  ->get()
                                  ->result();
                                  
                            // var_dump($sale->did);
                            // var_dump($mp);
                          
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($sale->dDate)); ?></td>
                            <td><?php echo $sale->name; ?></td>
                            <td><?php echo $sale->employeeName; ?></td>
                            <td>
                                <?php foreach ($mp as $p) { ?>
                                <?php echo $p->productName; ?><br>
                                <?php } ?>
                            </td>
                            <td>
                                <?php foreach ($mp as $p) { ?>
                                <?php echo $p->quantity; $tsa += $p->quantity; ?><br>
                                <?php } ?>
                            </td>
                            <td><?php echo $sale->notes;?></td>
                          </tr> 
                          <?php } ?>
                        </tbody>
                        <tbody>
                          <tr>
                            <td colspan="5" align="right"><b>Total Amount</b></td>
                            <td><b><?php echo $tsa; ?></b></td>
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