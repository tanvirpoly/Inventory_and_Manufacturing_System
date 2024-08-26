<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manufacturer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Manufacturer</li>
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
                <h3 class="card-title">Manufacturer Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row">
                      <div class="col-sm-3 col-3 invoice-col">
                        <div class="col-sm-4 col-md-4 col-4" style="margin-top: 15px;" >
                            <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="height:50px; width:auto;">
                        </div>
                      </div>
                      
                      <div class="col-sm-6 col-6 invoice-col text-center" >
                        <?php if($company){ ?><h3><b><?php echo $company->com_name; ?></b></h3><?php } ?>
                        <?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
                        <?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?>
                      </div>    <br> <br> <br> <br> 
                      
                      <div class="col-sm-3 col-3 invoice-col">
                        <h3><b>Manufacturer</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Date #</td>
                              <td><?php echo date('d-m-Y', strtotime($manufacturer['mDate'])); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>Manufacturer Products</b></h3>
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Item Serial</th>
                              <th>Raw Material</th>
                              <th>Unit</th>
                              <th>Pre saved Q.</th>
                              <th>Actual Q.</th>
                              <th>Cost (BDT)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tpmq = 0;
                            $tmq = 0;
                            $tca = 0;
                            foreach ($mproduct as $value) {
                            $i++;
                            ?>
                            <tr style="min-height: 200px;">
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['productName']; ?></td>
                              <td><?php echo $value['unitName']; ?></td> 
                              <td><?php echo $value['pquantity']; $tpmq += $value['pquantity']; ?></td>
                              
                              <td><?php echo $value['quantity']; $tmq += $value['quantity']; ?></td>
                              
                              <td><?php echo number_format(($value['quantity']*$value['pprice']), 2); $tca += ($value['quantity']*$value['pprice']); ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          
                          <tfoot>
                            <tr>
                              <td colspan="3" align="right">Grand Total</td>
                              <td><?php echo $tpmq; ?></td>
                              <td><?php echo $tmq; ?></td>
                              <td><?php echo number_format($tca, 2); ?></td>
                            </tr>
                          </tfoot>
                          
                        </table>
                      </div>
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>Finish Products</b></h3>
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Item Serial</th>
                              <th>Product</th>
                              <th>Batch</th>
                              <th>Quantity</th>
                              <th>Unit</th>
                              <th>Cost per unit</th>
                            </tr>
                          </thead>
                          
                          <tbody>
                            <?php
                            $i = 0;
                            $tfq = 0;
                            foreach ($fproduct as $value) {
                            $i++;
                            ?>
                            <tr style="min-height: 200px;">
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['productName']; ?></td>
                              <td><?php echo $value['batch']; ?></td>
                              <td><?php echo $value['quantity']; $tfq += $value['quantity']; ?></td>
                              <td><?php echo $value['unitName']; ?></td> 
                              
                             <td><?php echo  $tca / $value['quantity']; ?></td> 
                             
                            </tr>
                            <?php } ?>
                          </tbody>
                          
                          <tfoot>
                            <tr>
                              <td colspan="3" align="right">Grand Total</td>
                              <td><?php echo $tfq; ?></td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $manufacturer['notes']; ?></p>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12 col-12" style="text-align: center;">
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p>Prepared By</p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p>Verified By</p>
                          </div>
                          <div class="col-md-4 col-sm-4 col-4">
                            <p>------------------------------</p>
                            <p>Authorized By</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      <a href="<?php echo site_url('Manufacturer') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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
