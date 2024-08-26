<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pay My Bill</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Pay My Bill</li>
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
              <!--<div class="card-header">-->
              <!--  <h3 class="card-title">Pay My Bill Information</h3>-->
              <!--</div>-->

              <div class="card-body">
                <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>requestapih">
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                      <div class="form-group">
                        <h4><b>Pakage Details</b></h4><hr>
                      </div>
                      <div class="form-group">
                        <h4><b><input type="radio" name="utype" value="Month" id="muType" required >&nbsp;&nbsp;Basic Pakage - ( 499 Taka )</b></h4>
                        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( 1 Month Plan )</h5>
                      </div>
                      <div class="form-group">
                        <h4><b><input type="radio" name="utype" value="Basic" id="buType" required >&nbsp;&nbsp;Basic Pakage - ( 4999 Taka )</b></h4>
                        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( 1 Year Plan )</h5>
                      </div>
                      <div class="form-group">
                        <h4><b><input type="radio" name="utype" value="Standard" id="suType" required >&nbsp;&nbsp;Standard Pakage - ( 9999 Taka )</b></h4>
                        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( 1 Year Plan )</h5>
                      </div>
                      <div class="form-group">
                        <h4><b><input type="radio" name="utype" value="Premium" id="puType" required >&nbsp;&nbsp;Premium Pakage - ( 19999 Taka )</b></h4>
                        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( 1 Year Plan )</h5>
                      </div>
                      <input type="hidden" class="form-control" id="ptime" name="ptime" value="4" required >
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4" style="background-color: #f1eded;">
                      <div class="form-group" style="margin-top: 20px; margin-left: 20px;">
                        <h4><b>Checkout Summary</b></h4><hr>
                      </div>
                      <div class="form-group" style="margin-left: 20px;">
                        <h5><b>SubTotal : <span id="tsAmount">00.00</span> Taka</b></h5>
                      </div>
                      <div class="form-group" style="margin-left: 20px;">
                        <h5><b>Delivery : <span>00.00</span> Taka</b></h5>
                      </div>
                      <div class="form-group" style="margin-left: 20px;">
                        <h5><b>Total : <span id="tpAmount">00.00</span> Taka</b></h5>
                      </div>
                      <input type="hidden" class="form-control" name="amount" id="pAmount" value="0"required  >
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-12 col-12" style="margin-top: 30px;" >
                    <h5><b>Payment Method</b></h5><hr>
                  </div>
                  <div class="col-sm-12 col-md-12 col-12" >
                    <img src="<?php echo base_url().'assets/pby.png'; ?>" style="height:auto; width: 60%;">
                  </div>
                  <div class="col-sm-12 col-md-12 col-12" style="margin-top: 20px;" >
                    <input type="checkbox" name="checkbox" value="1" required > I have read and agree to the website terms and conditions, Privacy Policy, Return and Refund Policy*
                  </div>
                 <div class="form-group col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
    
<?php $this->load->view('footer/footer12'); ?>
    
    <script type="text/javascript" >
      $(document).ready(function(){
        $('#muType').click(function(){
            
          var tpa = 499;
          var pt = 1;
          //alert(tpa);
          $('#tsAmount').html(parseFloat(tpa).toFixed(2));
          $('#tpAmount').html(parseFloat(tpa).toFixed(2));
          $('#pAmount').val(parseFloat(tpa).toFixed(2));
          $('#ptime').val(pt);
          });
        
        $('#buType').click(function(){
            
          var tpa = 4999;
          var pt = 4;
          //alert(tpa);
          $('#tsAmount').html(parseFloat(tpa).toFixed(2));
          $('#tpAmount').html(parseFloat(tpa).toFixed(2));
          $('#pAmount').val(parseFloat(tpa).toFixed(2));
          $('#ptime').val(pt);
          });
        
        $('#suType').click(function(){
            
          var tpa = 9999;
          var pt = 4;
          //alert(tpa);
          $('#tsAmount').html(parseFloat(tpa).toFixed(2));
          $('#tpAmount').html(parseFloat(tpa).toFixed(2));
          $('#pAmount').val(parseFloat(tpa).toFixed(2));
          $('#ptime').val(pt);
          });
        
        $('#puType').click(function(){
            
          var tpa = 19999;
          var pt = 4;
          //alert(tpa);
          $('#tsAmount').html(parseFloat(tpa).toFixed(2));
          $('#tpAmount').html(parseFloat(tpa).toFixed(2));
          $('#pAmount').val(parseFloat(tpa).toFixed(2));
          $('#ptime').val(pt);
          });
        });
    </script>
    
    <script type="text/JavaScript">
        // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function(){
        'use strict';

        window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
              form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>