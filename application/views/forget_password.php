<?php $this->load->view('header/header'); ?>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="https://sunshine.com.bd">
        <img src="<?php echo base_url(); ?>assets/sunshine.png" style="width: 100%;" alert="logo" >
      </a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p><h3 style="text-align:center;">Forget Password ?</h3></p>
        
        <?php
        $exception = $this->session->userdata('exception');
        if(isset($exception))
        {
        echo $exception;
        $this->session->unset_userdata('exception');
        } ?>
        <br>

        <form action="<?php echo base_url('Login/check_forget_password_email'); ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Mobile Number or Email ID" required >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="<?php echo site_url() ?>Login">Login</a>
        </p>
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


    <script type="text/javascript">
      function isNumberKey(evt)
        {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
        }
    </script>