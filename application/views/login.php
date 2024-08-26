<?php $this->load->view('header/header'); ?>

<style>
body {
    background: #222d32;
    font-family: "Roboto", sans-serif;
}

.login-box {
    margin-top: 75px;
    height: auto;
    background: #f2f6f8;
    text-align: center;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.login-key {
    height: 100px;
    font-size: 80px;
    line-height: 100px;
    background: -webkit-linear-gradient(#27ef9f, #0db8de);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.login-title {
    margin-top: 15px;
    text-align: center;
    font-size: 30px;
    letter-spacing: 2px;
    margin-top: 70px;
    font-weight: bold;
    color: #143c6b;
}

.login-form {
    margin-top: 25px;
    text-align: left;
}

input[type="text"] {
    background-color: #cbd7de;
    border: none;
    border-bottom: 2px solid #0db8de;
    border-top: 0px;
    border-radius: 0px;
    font-weight: bold;
    outline: 0;
    margin-bottom: 20px;
    padding-left: 0px;
    color: #ecf0f5;
}

input[type="password"] {
    background-color: #cbd7de;
    border: none;
    border-bottom: 2px solid #0db8de;
    border-top: 0px;
    border-radius: 0px;
    font-weight: bold;
    outline: 0;
    padding-left: 0px;
    margin-bottom: 20px;
    color: #ecf0f5;
}

.form-group {
    margin-bottom: 40px;
    outline: 0px;
}

.form-control:focus {
    border-color: inherit;
    -webkit-box-shadow: none;
    box-shadow: none;
    border-bottom: 2px solid #0db8de;
    outline: 0;
    background-color: #1a2226;
    color: #ecf0f5;
}

input:focus {
    outline: none;
    box-shadow: 0 0 0;
}

label {
    margin-bottom: 0px;
}

.form-control-label {
    font-size: 10px;
    color: #6c6c6c;
    font-weight: bold;
    letter-spacing: 1px;
}

.btn-outline-primary {
    border-color: #0db8de;
    color: #0db8de;
    border-radius: 0px;
    font-weight: bold;
    letter-spacing: 1px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}

.btn-outline-primary:hover {
    background-color: #0db8de;
    right: 0px;
}

.login-btm {
    float: left;
}

.login-button {
    padding-right: 0px;
    text-align: right;
    margin-bottom: 25px;
}

.login-text {
    text-align: left;
    padding-left: 0px;
    color: #a2a4a4;
}

.loginbttm {
    padding: 0px;
}
</style>

<body class="hold-transition login-page">
    <?php
  $exception = $this->session->userdata('exception');
  if (isset($exception)) {
    echo $exception;
    $this->session->unset_userdata('exception');
  } ?>


    <!--New login form start-->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key" style="text-align:center;">
                    <!--<i class="fa fa-key" aria-hidden="true"></i>-->
                    <div class="login-logo text-center">
                        <img src="<?php echo base_url() . 'upload/company/logo.png'; ?>"
                style="" alert="logo">
                    </div>
                </div>
                <div class="col-lg-12 login-title">
                    Nanan Enterprise Production, sales and Management 
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form class="form-group" action="<?php echo base_url('Login/loginProcess'); ?>" method="post">
                            <div class="form-group">
                                <label class="form-control-label">USERNAME</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">PASSWORD</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="remember">
                                                <label for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                        <!--<div class="col-4">-->
                                        <!--  <button type="submit" class="btn btn-primary btn-block">Sign In</button>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary">Sign In</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
      
    </div>

  
    <!--   </script>-->
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>

</body>

</html>