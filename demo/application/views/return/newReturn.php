<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Return</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Return</li>
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
                <h3 class="card-title">Return Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Returns/returns_by_sales_invoice">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12"  style="text-align:center;">
                      <label>Sales Invoice Number *</label>
                      <input type="text" class="form-control" name="returnid" placeholder="Invoice Number" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-4" style="margin-top: 30px;">
                      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Search</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>