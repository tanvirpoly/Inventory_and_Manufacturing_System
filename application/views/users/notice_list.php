<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Notice</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Notice</h3>
            </div>

            <div class="card-body">
              <table id="example" class="table table-responsive table-bordered">
                <thead>
                  <tr>
                    <th style="width: 5%;">#SN.</th>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 20%;">Subject</th>
                    <th style="width: 60%;">Message</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($notice as $value) {
                  $i++;
                  ?>
                  <tr class="gradeX">
                    <td><?php echo $i; ?></td>
                    <td><?php echo date('d-m-Y h:i A', strtotime($value->regdate)); ?></td>
                    <td><?php echo $value->subject; ?></td>
                    <td><?php echo $value->message; ?></td>
                  </tr>   
                  <?php } ?> 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>