  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="https://decentpastryshop.com/" >Nanan Enterprise</a> .</strong> All rights reserved.
  </footer>
</div>
  
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
     <!--DataTables -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    

    <!-- date-picker -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    
    <!-- ck editor -->
    <script src="<?php echo site_url()?>assets/ckeditor/ckeditor.js"></script>
    <!-- Add this code to your footer file -->
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/js/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/js/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/js/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/new_datatables/js/buttons.html5.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard3.js"></script>
    <!-- page script -->
    
    <script src="<?php echo base_url(); ?>assets/dist/js/canvasjs.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>

    <!--<script type="text/javascript">-->
    <!--  function printDiv(divName){-->
    <!--    $('#header').show();-->
    <!--    var printContents = document.getElementById(divName).innerHTML;-->
    <!--    var originalContents = document.body.innerHTML;-->
    <!--    document.body.innerHTML = printContents;-->
    <!--    window.print();-->
    <!--    document.body.innerHTML = originalContents;-->
    <!--    }-->
    <!--</script>-->
<script type="text/javascript">
  function printDiv(divName) {
    $('#header').show();
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    // Create a new style element and set the font size
    var style = document.createElement('style');
    style.innerHTML = '@media print { body { font-size: 1.4rem; } }'; // Adjust the font size as needed

    // Append the style element to the head of the document
    document.head.appendChild(style);

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    // Remove the style element after printing
    document.head.removeChild(style);
  }
</script>


<!--<script type="text/javascript">-->
<!--  $(function(){-->
<!--    $("#example").DataTable({-->
<!--      });-->
<!--    });-->
<!--</script>-->

<script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        dom: 'lBfrtip',
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'btn btn-default'
          },
          {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'btn btn-default'
          },
          {
            extend: 'print',
            text: '<i class="fas fa-print"></i> Print',
            className: 'btn btn-default'
          }
        ]
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