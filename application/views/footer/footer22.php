  <footer class="main-footer">
  </footer>
</div>
    <?php
    $upayment = $this->db->select("*")->FROM('user_payments')->WHERE('compid',$_SESSION['compid'])->WHERE('pstatus',1)->order_by('up_id','DESC')->limit(1)->get()->row();
    
    $uregdate = $this->db->select("*")->FROM('users')->WHERE('compid',$_SESSION['compid'])->WHERE('date(regdate) <=','2022-01-12')->get()->row();
    
    $ureg2date = $this->db->select("*")->FROM('users')->WHERE('compid',$_SESSION['compid'])->WHERE('date(regdate) >','2022-01-12')->get()->row();
    
    $cudate = date('Y-m-d');
    $cu2date = date("Y-m-d h:i:s");
    
    if($upayment)
      {
      $lastdate = date("Y-m-d", strtotime($upayment->pdate));
      }
    else if($ureg2date)
      {
      $cu3date = date("Y-m-d", strtotime($ureg2date->regdate));
      $lastdate =  date('Y-m-d',strtotime($cu3date. ' + 30 days'));
      }
    else if($uregdate)
      {
      $lastdate = '2022-01-12';
      }
    else
      {
      $lastdate =  '';
      }
    
    ?>
    
    <div class="modal fade hide" id="myModal" >
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header" style="color: red; text-align: center;">
            <h4 class="modal-title">Warning !</h4>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-12 col-12" style="text-align: center;" >
              <img src="<?php echo base_url().'assets/payment.jpg'; ?>" style="height:90px; width:auto;">
            </div>
            <?php if($upayment && $lastdate < $cudate){ ?>
            <div class="col-md-12 col-sm-12 col-12" style="margin: 10px; color: #000; text-align: center;">
              <h4><b>Your Subscription is Over !</b></h4>
              <h4><b>You can now Upgrade your Plan.</b></h4>
            </div>
            <?php } else{ ?>
            <div class="col-md-12 col-sm-12 col-12" style="margin: 10px; color: #000; text-align: center;">
              <h4><b>Your Free Trial is Over !</b></h4>
              <h4><b>You can now Upgrade to a suitable paid plan,extend the free trial to try the app for a few more days.</b></h4>
            </div>
            <?php } ?>
            <div class="col-sm-12 col-md-12 col-12" style="text-align: center;" ></a>
              <a class="btn btn-primary" href="<?php echo site_url(); ?>payBill" ><i class="fa fa-arrow-right"></i>  Pay Now</a>
            </div>
            <div class="col-sm-12 col-md-12 col-12" style="text-align: right;">
              <a class="btn btn-danger" href="<?php echo site_url(); ?>Login/logout" style="text-align: right; margin: 10px; " ><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <!-- date-picker -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard3.js"></script>
    <!-- page script -->
    
    <script src="<?php echo base_url(); ?>assets/dist/js/canvasjs.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>

    
    
    <!-- <?php if($_SESSION['role'] > 1){ ?>
    <?php if($lastdate < $cudate){ ?>
    <script type="text/javascript">
      $(window).on('load', function() {
        //$('#myModal').modal('show');
        $('#myModal').modal({
        backdrop: 'static',
        keyboard: false
        })
        });
    </script>
    <?php } } ?> -->
    
    <script type="text/javascript">
      $(function(){
        $(".select2").select2();
      });
    </script>
    
  </body>
</html>