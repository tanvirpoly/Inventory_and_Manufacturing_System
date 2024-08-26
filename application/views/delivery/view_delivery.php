<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

<style>
    @media print{
        #print{
            font-size:2rem !important;
        }
    }
</style>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery</li>
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
                <h3 class="card-title">Delivery Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row" style="display:flex;align-items:center;">
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3><b>Delivery Challan</b></h3>
                        Mobile: <?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?>
                      </div>
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 class="text-center"><b>Outlet</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Outlet Name: </td>
                              <td><?php echo $delivery['employeeName']; ?></td>
                            </tr>
                            <tr style="">
                              <td>Date: </td>
                              <td><?php echo date('d-m-Y',strtotime($delivery['dDate'])).' (<i><b>'.date('h:i a',strtotime($delivery['regdate'])).'</i></b>)'; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-12 col-12 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>Delivery Products</b></h3>
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Product</th>
                              <th>Quantity</th>
                              <th>Unit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tmq = 0;
                            foreach ($pproduct as $value) {
                            $i++;
                            ?>
                            <tr style="min-height: 200px;">
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['productName']; ?></td>
                              <td><?php echo $value['quantity']; $tmq += $value['quantity']; ?></td>
                              <td><?php echo $value['unitName']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2" align="right">Grand Total</td>
                              <td><?php echo $tmq; ?></td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $delivery['notes']; ?></p>
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
                      <a href="<?php echo site_url('delivery') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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
