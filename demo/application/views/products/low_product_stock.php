<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Alert Stock Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Stock Report</li>
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
                <h3 class="card-title">Alert Product Stock Report</h3>
              </div>

              <div class="card-body">
                <div id="print">
                    <div class="row" id="header" style="display: none" >
                      <?php if($company){ ?>
                      <div class="col-sm-2 col-md-2 col-2" style="margin-top: 30px;">
                        <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>"  style="width: 100%;">
                      </div>
                      <div class="col-sm-10 col-md-10 col-10">
                        <div class="col-sm-12 col-md-12 col-12">
                          <h3><b><?php echo $company->com_name; ?></b></h3>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_address; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_email; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_mobile; ?></b>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  <table id="example" class="table table-responsive table-bordered" >
                    <thead>
                      <tr>
                        <th style="width: 5%;">#SN.</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th style="width: 15%;">Stock Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      $tpq = 0;
                      $tsq = 0;
                      $tq = 0;
                      $tr = 0;
                      $taq = 0;
                      foreach ($stock as $result){
                      $i++;
                      $pid = $result['product'];
                      $cid = $result['compid'];

                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['productcode']; ?></td>
                        <td><?php echo $result['productName']; ?></td>
                        <td><?php echo $result['totalPices']; $tq += $result['totalPices']; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div><br>
                <div class="form-group col-md-12" style="text-align: center;margin-top: 20px">
                  <a href="javascript:void(0)" style="width: 100px;" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"> </i>  Print</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>