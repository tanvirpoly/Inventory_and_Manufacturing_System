  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="https://decentpastryshop.com/" >Decent Pastry Shop</a> .</strong> All rights reserved.
  </footer>
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
    
    <!-- ck editor -->
    <script src="<?php echo site_url()?>assets/ckeditor/ckeditor.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard3.js"></script>
    <!-- page script -->
    
    <script src="<?php echo base_url(); ?>assets/dist/js/canvasjs.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>

    <script type="text/javascript">
      function printDiv(divName){
        $('#header').show();
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        }
    </script>

    <script type="text/javascript">
      $(function(){
        $("#example").DataTable({
          "responsive": true,
          "autoWidth": false,
          "stateSave": true
          });
        });
    </script>

    <script type="text/javascript">
      function isNumberKey(evt)
        {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
        }
    </script>
    
    <script type="text/javascript">
      $(function(){
        $('.datepicker').datepicker({
          autoclose: true,
          todayHighlight: true
          });
        });
    </script>
    
    <script type="text/javascript">
      $(function(){
        $(".select2").select2();
      });
    </script>
    
    <script type="text/javascript" >
      CKEDITOR.replace('editor');
    </script>
    

  </body>
</html>