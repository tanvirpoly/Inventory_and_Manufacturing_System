<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <!--<section class="content-header">-->
    <!--  <div class="container-fluid">-->
    <!--    <div class="row mb-2">-->
    <!--      <div class="col-sm-6">-->
    <!--        <h1>Voucher</h1>-->
    <!--      </div>-->
    <!--      <div class="col-sm-6">-->
    <!--        <ol class="breadcrumb float-sm-right">-->
    <!--          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>-->
    <!--          <li class="breadcrumb-item active">Voucher</li>-->
    <!--        </ol>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Voucher Information</h3>
              </div>

              <div class="card-body" style="text-transform:uppercase;">
                <form method="POST" action="<?php echo site_url("Voucher/save_voucher") ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-2 col-sm-2 col-12">
                        <label>Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('d-m-Y') ?>" required >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Voucher Type *</label>
                        <div style="text-transform:capitalize;">
                          <input type="radio" name="vaucher" value="Credit Voucher" id="credit" required >&nbsp;&nbsp;Income Voucher&nbsp;&nbsp;
                          <input type="radio" name="vaucher" value="Debit Voucher" id="debit" required >&nbsp;&nbsp;Expense Voucher&nbsp;&nbsp;
                          <!-- <input type="radio" name="vaucher" value="Customer Pay" id="customerPay" required >&nbsp;&nbsp;Customer Pay&nbsp;&nbsp; -->
                          <input type="radio" name="vaucher" value="Supplier Pay" id="supplierPay" required >&nbsp;&nbsp;Supplier Pay
                        </div>
                      </div>
                      <div class="d-none col-md-6 col-sm-6 col-xs-12" id="customer">
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Customer *</label>
                        <!--<div>-->
                        <!--<select name="customerID" id="customerID" class="form-control" required="" style="width: 100%;" >-->
                        <!--  <option value="">Select One</option>-->
                        <!--  <?php foreach($customer as $value):?>-->
                        <!--  <option value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>-->
                        <!--  <?php endforeach;?>-->
                        <!--</select>-->
                        <!--</div>-->
                        <div class="input-group">
                        <select name="customerID" id="customerID" class="form-control" required="" style="width: 90%;" >
                        </select>
                        <span class="input-group-append">
                          <button type="button" class="btn btn-danger btn-sm customer_add" data-toggle="modal" data-target=".bs-example-modal-customer_add" ><i class="fa fa-plus"></i></button>
                        </span>
                      </div>
                      </div>
                    </div>

                    <div class="d-none col-md-6 col-sm-6 col-xs-12" id="employee">
                        <div class="form-group col-md-12 col-sm-12 col-12">
                          <label>Expenses Type *</label>
                          <div class="input-group">
                            <select name="costType" id="costType" class="form-control" required="" style="width: 90%;" >
                            </select>
                            <span class="input-group-append">
                              <button type="button" class="btn btn-danger btn-sm addCosttype" data-toggle="modal" data-target=".bs-example-modal-addCosttype" ><i class="fa fa-plus"></i></button>
                            </span>
                          </div>
                        </div>
                    </div>

                    <div class="d-none col-md-6 col-sm-6 col-xs-12" id="supplier">
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Supplier *</label>
                        <!--<select class="form-control" name="supplier" id="supplierID" required="" style="width: 100%;" >-->
                        <!--  <option value="">Select One</option>-->
                        <!--  <?php foreach($supplier as $value):?>-->
                        <!--  <option value="<?php echo $value['supplierID']; ?>"><?php echo $value['supplierName'].' ( '.$value['sup_id'].' )'; ?></option>-->
                        <!--  <?php endforeach;?>-->
                        <!--</select>-->
                        <div class="input-group">
                          <select name="supplier" id="supplierID" class="form-control" required="" style="width: 90%;" >
                            <option value="">Select One</option>
                          </select>
                          <span class="input-group-append">
                            <button type="button" class="btn btn-danger btn-sm supplier_add" data-toggle="modal" data-target=".bs-example-modal-supplier_add" ><i class="fa fa-plus"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>
                    </div>
                    
                    

                    
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="row" style="background-color:#298894; color: black;" align="center">
                        <div class="form-group col-md-6 col-sm-6 col-6">
                          <label>Expenses</label>
                          <input type="text" class="form-control" name="particular[]" placeholder="Particulars" required >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-4">
                          <label>Amount</label>
                          <input type="text" class="form-control" name="amount[]" placeholder="Amount" required >
                        </div>
                        <div class="form-group col-md-2 col-sm-2 col-2">
                          <!--<label>Add</label>-->
                          <button type="button" class="form-control btn btn-defult" id="addmore">Add Line</button>
                        </div>
                      </div>

                      <div class="row">   
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <ol id="list" style="list-style-type:none;"></ol>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="row">
                        
                        <div class="form-group col-md-4 col-sm-4 col-12">
                          <label>Account Type *</label>
                          <select class="form-control" name="accountType" id="accountType" required >
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                            <option value="Mobile">Mobile</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                          <label>Account No *</label>
                          <select class="form-control" name="accountNo" id="accountNo" required >
                            <option value="">Select One</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                          <label>Reference / Note</label>
                          <input type="text" class="form-control" name="reference" placeholder="Reference / Note"  >
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                      <a href="<?php echo site_url('Voucher') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
                    </div>
                  </div>
                </form>

                <div class="d-none col-md-12 col-sm-12 col-xs-12">
                  <div id="product">
                    <ol class="ct">
                      <div class="row" style="background-color:#c5c745; border-radius: 4px; border:1px solid #fff; color: black; margin-left: -90px;" >
                        <div class="form-group col-md-6 col-sm-6 col-6">
                          <label>Particulars</label>
                          <input type="text" name="particular[]" placeholder="Particulars" class="form-control" >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-4">
                          <label>Amount</label>
                          <input type="text" name="amount[]" placeholder="Amount" class="form-control" >
                        </div>
                        <div class="form-group col-md-2 col-sm-2 col-2">
                          <input type="button" class="btn btn-danger" value="Remove" onClick="$(this).parent().parent().remove();" style="margin-top: 30px;" >
                        </div>
                      </div>
                    </ol>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
    
    <div id="customer_add" class="modal fade bs-example-modal-customer_add" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Customer Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" name="customerName" id="customerName" placeholder="Customer Name *" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number *" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <input type="email" class="form-control" name="email" id="email" placeholder="example@sunshine.com">
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" name="address" id="address" placeholder="Address *" required >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" name="balance" id="balance" placeholder="Amount" >
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="pbsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </div>
    </div>


    <div id="addCosttype" class="modal fade bs-example-modal-addCosttype" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Expense Type</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label>Expense Type *</label>
              <input type="text" class="form-control" name="costName" id="costName" placeholder="Expense Type" required >
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="costsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </div>
    </div>
    
    <div id="supplier_add" class="modal fade bs-example-modal-supplier_add" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Supplier Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
            <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Supplier Name *</label>
                <input type="text" class="form-control" name="supplierName" id="supplierName" placeholder="Supplier Name" required >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Supplier Company</label>
                <input type="text" class="form-control" name="compname" id="compname" placeholder="Supplier Company" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="example@sunshine.com" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-12">
                <label>Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" >
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Opening Balance</label>
                <input type="text" class="form-control" name="balance" id="balance" onkeypress="return isNumberKey(event)" placeholder="Amount" >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="supsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </div>
    </div>


<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#credit').click(function(){
          $('#customer').removeAttr('class','d-none');
          $('#employee').attr('class','d-none');
          $('#supplier').attr('class','d-none');

          $('#customerID').attr('required','required');
          $('#costType').removeAttr('required','required');
          $('#reference').removeAttr('required','required');
          $('#supplierID').removeAttr('required','required');
          });

        $('#debit').click(function(){
          $('#employee').removeAttr('class','d-none');
          $('#customer').attr('class','d-none');
          $('#supplier').attr('class','d-none');

          $('#customerID').removeAttr('required','required');
          $('#costType').attr('required','required');
          $('#reference').attr('required','required');
          $('#supplierID').removeAttr('required','required');
          });

        $('#supplierPay').click(function(){
          $('#supplier').removeAttr('class','d-none');
          $('#customer').attr('class','d-none');
          $('#employee').attr('class','d-none');

          $('#customerID').removeAttr('required','required');
          $('#costType').removeAttr('required','required');
          $('#reference').removeAttr('required','required');
          $('#supplierID').attr('required','required');
          });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
        var value = $("#accountType").val();
        $('#accountNo').val(1);
        getAccountNo(value, '#accountNo');
        });
        
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

    <script type="text/javascript">
      $(document).ready(function(){
        $("#addmore").click(function(){
          $("#list").append($("#product").html());
          $("ol ol.ct input").removeAttr("id");
          });

        $("#remove_more").click(function(){
          $('ol.ct').has('input:checkbox:checked').remove();
          });
        });
    </script>

    <script type="text/javascript" >
      $(function(){
        load_cost_type();
        function load_cost_type(){
          var url = "<?php echo base_url()?>Voucher/get_cost_type";
          //alert(url);
          $.ajax({
            type:'POST',
            url: url,       
            dataType: 'json',
            success:function(data){ 
            //alert(data);
              var HTML = "<option value=''>Select One</option>";
              for (var key in data) 
                {
                if (data.hasOwnProperty(key))
                  {
                  HTML +="<option value='"+data[key]["ct_id"]+"'>" + data[key]["costName"]+"</option>";
                  }
                }
              $("#costType").html(HTML);
              },
            error:function(data){
               alert('error');
              }
            });
          }

        $("#costsubmit").click(function(){
          var costName = $("#costName").val();
          var dataString = 'costName='+ costName;
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Cost/add_cost_type') ?>",
            data: dataString,
            cache: false,
            success: function(result){
              //alert(result);
              load_cost_type();
              $('#addCosttype').remove();
              $('.modal-backdrop').remove();
              }
            });
          return false;
        });
      });
    </script>
    
    <script type="text/javascript" >
      $(function(){
        load_customers();
        function load_customers(){
          var url = "<?php echo base_url()?>Sale/get_sale_customer";
          //alert(url);
          $.ajax({
            type:'POST',
            url: url,       
            dataType: 'json',
            success:function(data){ 
            //alert(data);
              //var HTML = "<option value=''>Select One</option>";
              var HTML = "";
              for (var key in data) 
                {
                if (data.hasOwnProperty(key))
                  {
                  HTML +="<option value='"+data[key]["customerID"]+"'>" + data[key]["customerName"]+' ( '+data[key]["mobile"]+' )'+"</option>";
                  }
                }
              $("#customerID").html(HTML);
              },
            error:function(data){
               alert('error');
              }
            });
          }

        $("#pbsubmit").click(function(){
          var customerName = $("#customerName").val();
          var mobile = $("#mobile").val();
          var email = $("#email").val();
          var address = $("#address").val();
          var balance = $("#balance").val();
          var dataString = 'customerName='+ customerName + '&mobile='+ mobile + '&email='+ email + '&address='+ address + '&balance='+ balance;
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Customer/add_customer') ?>",
            data: dataString,
            cache: false,
            success: function(result){
              //alert(result);
              load_customers();
              $('#customer_add').remove();
              $('.modal-backdrop').remove();
              }
            });
          return false;
        });
      });
    </script>
    
    <script type="text/javascript" >
      $(function(){
        load_suppliers();
        function load_suppliers(){
          var url = "<?php echo base_url()?>Purchase/get_purchase_supplier";
          //alert(url);
          $.ajax({
            type:'POST',
            url: url,       
            dataType: 'json',
            success:function(data){ 
            //alert(data);
              var HTML = "<option value=''>Select One</option>";
              for (var key in data) 
                {
                if (data.hasOwnProperty(key))
                  {
                  HTML +="<option value='"+data[key]["supplierID"]+"'>" + data[key]["supplierName"]+' ( '+ data[key]["sup_id"]+' )'+"</option>";
                  }
                }
              $("#supplierID").html(HTML);
              },
            error:function(data){
               alert('error');
              }
            });
          }

        $("#supsubmit").click(function(){
          var supplierName = $("#supplierName").val();
          var compname = $("#compname").val();
          var mobile = $("#mobile").val();
          var email = $("#email").val();
          var address = $("#address").val();
          var balance = $("#balance").val();
          var dataString = 'supplierName='+ supplierName + '&compname='+ compname + '&mobile='+ mobile + '&email='+ email + '&address='+ address + '&balance='+ balance;
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Supplier/save_supplier') ?>",
            data: dataString,
            cache: false,
            success: function(result){
              //alert(result);
              load_suppliers();
              $('#supplier_add').remove();
              $('.modal-backdrop').remove();
              }
            });
          return false;
        });
      });
    </script>