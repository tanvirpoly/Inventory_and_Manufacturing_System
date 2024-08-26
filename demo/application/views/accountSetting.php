<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Change Password</li>
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
                <h3 class="card-title">Change Password</h3>
              </div>

              <div class="card-body">
                <form method="post" action="<?php echo base_url('Home/save_account_setting'); ?>" >
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label" style="text-align: right;">Current Password * :</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="cpassword" placeholder="Enter Password" required >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label" style="text-align: right;">New Password * :</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="password" id="npassword" placeholder="Enter Password" required >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label" style="text-align: right;">Confirm Password * :</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="npassword" id="cpassword" onkeyup="checkPass(); return false;" placeholder="Enter Password" required >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 25px;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
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

    <script type="text/javascript" >   
      function checkPass()
        { 
        var password = document.getElementById('npassword');
        var confirm_password = document.getElementById('cpassword');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";
        if(password.value == confirm_password.value)
          {
          confirm_password.style.backgroundColor = goodColor;
          }
        else
          {
          confirm_password.style.backgroundColor = badColor; 
          }
        } 
    </script>