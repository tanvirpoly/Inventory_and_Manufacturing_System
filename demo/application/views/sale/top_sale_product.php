<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Top Sales Product</h1>
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
                <h3 class="card-title">Top Sales Product Report</h3>
              </div>

              <div class="card-body">
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
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-12">
                    <table id="example" class="table table-responsive table-bordered" >
                      <thead>
                        <tr>
                          <th style="width: 5%;">#SN.</th>
                          <th>Code</th>
                          <th>Product</th>
                          <th style="width: 10%;">Quantity</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0;
                        foreach ($sales as $value){
                        $i++;
                        ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $value->productcode; ?></td>
                          <td><?php echo $value->productName; ?></td>
                          <td><?php echo $value->total; ?></td>
                        </tr>   
                        <?php } ?> 
                      </tbody>
                    </table>
                  </div>
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
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>
