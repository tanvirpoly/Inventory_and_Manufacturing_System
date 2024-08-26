<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Staff / Employee Payments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Payments</li>
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
                <h3 class="card-title">Staff / Employee Payments</h3>
              </div>

              <div class="card-body" style="text-transform:uppercase;">
                <form action="<?php echo base_url('Employee_payment/SaveInfo'); ?>" method="POST">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Month *</label>
                      <select class="form-control" name="month" id="month" required >
                        <option value="">Select One</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Year *</label>
                      <select class="form-control" name="year" id="year" required >
                        <?php $d = date("Y"); ?>
                        <option value="">Select One</option>
                        <?php for ($x = 2020; $x <= $d; $x++) { ?>
                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Employee *</label>
                      <select class="form-control" name="empid" id="empid" required >
                        <option value="">Select One</option>
                        <?php foreach($employee as $value){ ?>
                        <option value="<?php echo $value['employeeID']; ?>"><?php echo $value['employeeName']; ?></option>
                        <?php } ;?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label>Salary Amount *</label>                        
                      <input type="text" class="form-control" name="salary" id="salary" placeholder="Amount" readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label>Payment Amount * </label>                        
                      <input type="text" class="form-control" name="ppaid" id="ppaid" placeholder="Amount" readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label>Paid Amount * </label>                        
                      <input type="text" class="form-control" name="pAmount" id="pAmount" placeholder="Amount" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label>Payment Mode * </label>                        
                      <select class="form-control" name="accountType" id="accountType" required >
                        <option value="">Select One</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank">Bank</option>
                        <option value="Mobile">Mobile</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label>Account * </label>                        
                      <select class="form-control" name="accountNo" id="accountNo" required >
                        <option value="">Select One</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label>Note</label>                        
                      <input type="text" class="form-control" placeholder="if have any Note" name="note">
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;" >
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save" ></i> Submit </button>
                    <a href="<?php echo site_url('empPayment')?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>Back</a>
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
        $(document).ready(function(){
          $('#empid').change(function(){
            var url = "<?php echo base_url(); ?>Employee_payment/get_emp_salary";
            var id = $('#month').val();
            var id2 = $('#year').val();
            var id3 = $('#empid').val();
            //alert(id); alert(id2); alert(id3);
            $.ajax({
              method: "POST",
              url     : url,
              dataType: 'json',
              data    : {'id':id,'id2':id2,'id3':id3},
              success:function(data){ 
              //alert(data);
              var HTML = data["salary"];
              var HTML2 = data["total"];
              var HTML3 = HTML - HTML2;

              $("#salary").val(HTML);
              $("#ppaid").val(HTML2);
              $("#pAmount").val(HTML3);
                },
              error:function(data){
              alert('error');
              }
            });
          });
        });
      </script>

      <script type="text/javascript">

      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        });
        
        function getAccountNo(value,place){
          $(place).empty();
          if(value != ''){
            $.ajax({
              url: '<?php echo site_url()?>Voucher/getAccountNo',
              async: false,
              dataType: "json",
              data: 'id=' + value,
              type: "POST",
              success: function (data){
                $(place).append(data);
                $(place).trigger("chosen:updated");
                }
              });
            }
          else
            {
            customAlert('Please Select Account Type', "error", true);
            }
          }
    </script>