<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Sales</li>
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
                <h3 class="card-title">Sale Delivery Chalan</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row">
                      <div class="col-sm-3 col-3 invoice-col">
                      </div>
                      <div class="col-sm-6 col-6 invoice-col text-center">
                        <?php if($company){ ?><h3><b><?php echo $company->com_name; ?></b></h3><?php } ?>
                        <?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
                        <?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?>
                      </div>
                      <div class="col-sm-3 col-3 invoice-col">
                        <h3><b>Delivery Challan</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Invoice #</td>
                              <td><?php echo $prints['invoice_no']; ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Date #</td>
                              <td><?php echo date('d-m-Y', strtotime($prints['saleDate'])); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>Bill From</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Name #</td>
                              <td><?php if($company){ ?><b><?php echo $company->com_name; ?></b><?php } ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Mobile #</td>
                              <td><?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Address #</td>
                              <td><?php if($company){ ?><?php echo $company->com_address; ?><?php } ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>Bill To</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Customer #</td>
                              <td><?php echo $prints['customerName']; ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Mobile #</td>
                              <td><?php echo $prints['mobile']; ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Address #</td>
                              <td><?php echo $prints['address']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                
                    <div class="row" style="margin-bottom:5%;">
                      <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>#SN.</th>
                              <th>ITEM</th>
                              <th>QTY</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            $stotal = 0;
                            foreach ($salesp as $value){
                            $i++;
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></td>
                              <td><?php echo round($value['quantity']); $tq += $value['quantity']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="2" align="right">Total </td>
                              <td><?php echo $tq; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <?php if($prints['note'] != null){ ?>
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $prints['note']; ?></p>
                    </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-md-12 col-12">
                        <div class="row">
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Customer</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Prepared By</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Verified By</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3" style="text-align: center;">
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
                      <a href="<?php echo site_url('Sale') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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