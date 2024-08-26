<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Order</li>
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
                <h3 class="card-title">Order Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row invoice-info">
                      <div class="col-sm-6 col-6 invoice-col">
                        <?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="height:80px; width:auto;"><?php } ?><br>
                        <div style="padding: 10px;">
                          <span style="padding: 10px; border: 2px solid #29B577; color: #29B577;">Billing From</span>
                        </div>
                        <address>
                          <?php if($company){ ?><h3><b><?php echo $company->com_name; ?></b></h3><?php } ?>
                          <p style="font-size: 22px;"><?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
                          <b>Mobile : </b><?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?><br>
                          <b>Email : </b><?php if($company){ ?><?php echo $company->com_email; ?><?php } ?>
                          </p>
                        </address>
                      </div>
                      <div class="col-sm-6 col-6 invoice-col">
                        <div class="col-sm-12 col-12">
                          <h3>Order Invoice</h3>
                          <p style="font-size: 22px;"><b>Order No. # </b><?php echo $order['order_no']; ?><br>
                          <b>Date #</b> <?php echo date('d-m-Y', strtotime($order['regdate'])); ?><br>
                        </div>
                        
                        <div style="padding: 10px;">
                          <span style="padding: 10px; border: 2px solid #29B577; color: #29B577;">Billing To</span>
                        </div>
                        
                        <address>
                          <h3><b><?php echo $order['custName']; ?></b></h3>
                          <p style="font-size: 22px;"><?php echo $order['custAddres']; ?><br>
                          <b>Mobile : </b><?php echo $order['custMobile']; ?><br>
                          <b>Email : </b><?php echo $order['custEmail']; ?></p>
                        </address>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th style="text-align: center;">Product Name</th>
                              <th style="text-align: center;">Quantity</th>
                              <th style="text-align: center;">Unit Price</th>
                              <th style="text-align: center;">Sub Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            $stotal = 0;
                            foreach ($product as $value){
                            $i++;
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td style="text-align: center;"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></td>
                              <td style="text-align: center;"><?php echo round($value['quantity']); $tq += $value['quantity']; ?></td>
                              <td style="text-align: center;"><?php echo number_format($value['sprice'], 2);; ?></td>
                              <td style="text-align: center;"><?php echo number_format($value['tPrice'], 2); $stotal += $value['tPrice']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="2" align="right">Grand Total </td>
                              <td align="center"><?php echo $tq; ?></td>
                              <td></td>
                              <td><?php echo number_format($stotal, 2); ?></td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12 col-12" >
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-6" style="text-align: center;">
                            <p>------------------------------</p>
                            <p>Customer</p>
                          </div>
                          <div class="col-md-6 col-sm-6 col-6" style="text-align: center;">
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
                      <a href="<?php echo site_url(); ?>order" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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