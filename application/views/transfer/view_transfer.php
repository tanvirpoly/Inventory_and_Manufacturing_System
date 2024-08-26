<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>
  
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Transfer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Product Transfer</li>
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
                <h3 class="card-title">Product Transfer Information</h3>
              </div>

              <div class="card-body">
                <div class="invoice p-3 mb-3">

                  <div id="print">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-12">
                        <h4>
                          <?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="height:80px; width:auto;"><?php } ?>
                        </h4>
                      </div>
                      <div class="col-md-2 col-sm-2 col-12"></div>
                      <div class="col-md-6 col-sm-6 col-12 text-right">
                        <h6>
                          <br><?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
                          <?php if($company){ ?><?php echo $company->com_email; ?><?php } ?><br>
                          Contact No : <?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?><br>
                        </h6>
                      </div>
                    </div><hr>
                    
                    <div class="row invoice-info">
                      <div class="col-sm-4 col-4 invoice-col">
                        <table class="table table-bordered">
                          <tr>
                            <td><b>Date # </b></td>
                            <td><?php echo date('d-m-Y', strtotime($transfer['tDate'])); ?></td>
                          </tr>
                          <tr>
                            <td><b>Invoice # </b></td>
                            <td><?php echo $transfer['tsCode']; ?></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-sm-4 col-4 invoice-col"></div>
                      <div class="col-sm-4 col-4 invoice-col">
                        <table class="table table-bordered">
                          <?php
                          $fcompid = $this->db->select('com_name')->from('com_profile')->where('com_pid',$transfer['fcompid'])->get()->row();
                          $tcompid = $this->db->select('com_name')->from('com_profile')->where('com_pid',$transfer['tcompid'])->get()->row();
                          ?>
                          <tr>
                            <td><b>Form Warehouse # </b></td>
                            <td><?php echo $fcompid->com_name; ?></td>
                          </tr>
                          <tr>
                            <td><b>To Warehouse : </b></td>
                            <td><?php echo $tcompid->com_name; ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>

                    <div class="row" style="">
                      <div class="col-12">
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>SN #</th>
                              <th>Product</th>
                              <th>Batch</th>
                              <th>Quantity</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            foreach ($pproduct as $value){
                            $i++;
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['productName']; ?></td>
                              <td><?php echo $value['batch']; ?></td>
                              <td><?php echo round($value['quantity']).' '.$value['unitName']; $tq += $value['quantity']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="3" class="text-right" ><b>Grand Total :</b></td>
                              <td><b><?php echo $tq; ?></b></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $transfer['notes']; ?></p>
                    </div>
                    
                    <div class="row" id="header" style="display: none">
                      <div class="col-md-12 col-12" style="text-align: center; position: fixed; bottom: 0;">
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-6">
                            <p>------------------------------</p>
                            <p>Received By</p>
                          </div>
                          <div class="col-md-6 col-sm-6 col-6">
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
                      <a href="<?php echo site_url() ?>ptransfer" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
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
      function printpDiv(divName){
        $('#pprint').show();
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        }
    </script>