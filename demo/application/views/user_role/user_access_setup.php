<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Access Setup</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Access Setup</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Access Setup List</h3>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr style="text-transform:uppercase;text-align:center;">
                      <th style="width: 5%;">SN.</th>
                      <th style="width: 20%;">Company ID</th>
                      <th style="width: 20%;">User Type</th>
                      <th style="width: 20%;">Status</th>
                      <th style="width: 20%;">Created Date</th>
                      <th style="width: 15%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($user as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['compid']; ?></td>
                      <td><?php echo $value['lavelName']; ?></td>
                      <td><?php echo $value['status']; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['regdate'])); ?></td>                            
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url('viewUAccess').'/'.$value['ax_id']; ?>" ><i class="fa fa-eye"></i></a>
                        <a class="btn btn-success btn-xs" href="<?php echo site_url('editUAccess').'/'.$value['ax_id']; ?>" ><i class="fa fa-edit"></i></a>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  	</section>
  </div>


<?php $this->load->view('footer/footer');?>