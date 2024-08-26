<?php $this->load->view('header/header'); ?>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="https://sunshine.com.bd"><b>Sunshine</b> IT</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">OTP for Password Reset</p>
        <span style="color: black;"> Enter your otp number in the space below and we will do you the Account verify</span><br>
        <?php
        $exception = $this->session->userdata('exception');
        if(isset($exception))
        {
        echo $exception;
        $this->session->unset_userdata('exception');
        } ?>
        <br>
        <form action="<?php echo base_url('Login/save_otp_check');?>" method="POST" enctype="multipart/form-data" >
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <input type="text" name="otp" required placeholder="Enter OTP" class="form-control" style="border-radius: 5px;">
          </div>
          <div class="form-group" style="text-align: center;">
            <button type="submit" name="submit" class="form-control btn btn-primary" style="border-radius: 15px;" ><i class="" aria-hidden="true"></i> Submit</button>
          </div>
        </form>
        <div class="form-group" style="text-align: center;">
          <p style="color: black;">Unless you change your password <a style="color: #5580e5;" href="<?php echo site_url('Login')?>">Login now!</a></p>
        </div>
      </div>
    </div>
  </div>
  
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
</body>
</html>