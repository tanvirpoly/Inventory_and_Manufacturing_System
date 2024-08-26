<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Staff / Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Staff / Employee</li>
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
                <h3 class="card-title">Staff / Employee Information</h3>
              </div>

              <div class="card-body">
                <div id="print">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-4">
                    <div class="col-md-12 col-sm-12 col-12" >
                      <?php if($employee['empImage'] == null){ ?>
                      <i class="fa fa-user fa-5x" ></i>
                      <?php } else{ ?>
                      <img src="<?php echo base_url().'upload/employee/'.$employee['empImage']; ?>" style="width: 90%; height: 170px;" alt="Product Image" >
                      <?php } ?>
                    </div>   
                    <div class="col-md-12 col-sm-12 col-12" >
                      <?php if($employee['empSignature']){ ?>
                      <img src="<?php echo base_url().'upload/employee/'.$employee['empSignature']; ?>" style="width: 90%; height: 170px;" alt="Product Image" >
                      <?php } ?>
                    </div>   
                  </div>
                  <div class="col-md-8 col-sm-8 col-8">
                    <table class="table table-bordered table-striped">
                      <tr>
                        <td>Name</td>
                        <td><?php if(isset($employee['employeeName'])){echo $employee['employeeName'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>ID</td>
                        <td><?php if(isset($employee['emp_id'])){echo $employee['emp_id'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Mobile</td>
                        <td><?php if(isset($employee['phone'])){echo $employee['phone'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><?php if(isset($employee['email'])){echo $employee['email'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td><?php if(isset($employee['empaddress'])){echo $employee['empaddress'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Join Date</td>
                        <td><?php if(isset($employee['joiningDate'])){echo date('d-m-Y', strtotime($employee['joiningDate']));}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Leave Date</td>
                        <td><?php if(isset($employee['leavingDate'])){echo date('d-m-Y', strtotime($employee['leavingDate']));}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Salary</td>
                        <td><?php if(isset($employee['salary'])){echo number_format($employee['salary'], 2);}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Consent</td>
                        <td><?php if(isset($employee['consent'])){echo $employee['consent'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td><?php if(isset($employee['status'])){echo $employee['status'];}else{echo '';}?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                </div>
                <div class="col-sm-12 col-md-12 col-12" style="text-align: center;">
                  <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"> </i> Print</a>
                  <a href="<?php echo site_url('Employee') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left"></i> Back</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<?php $this->load->view('footer/footer'); ?>