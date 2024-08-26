<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sale Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Sale Service</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Service Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Service/save_sale_service") ?>">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>DATE *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>CUSTOMER *</label>
                      <select name="customer" class="form-control" required >
                        <option value="">Select One</option>
                        <?php foreach($customer as $value){ ?>
                        <option value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>SELECT SERVICE *</label>
                      <select class="form-control" id="service" required >
                        <option value="">Select One</option>
                        <?php foreach($service as $value){ ?>
                        <option value="<?php echo $value['siid']; ?>"><?php echo $value['siName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="row" >
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>SERVICE NAME</th>
                          <th>QTY</th>
                          <th>UNIT PRICE</th>
                          <th>SUB TOTAL</th> 
                          <th>ACTION</th>                       
                        </tr>
                      </thead>
                      <tbody id="tbody">

                      </tbody>
                    </table>
                  </div>
                  
                  <div class="row" >
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>TOTAL*</label>
                      <input type="text" name="totalprice" class="form-control" id="totalprice" required readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label style="color: green;">PAID *</label>
                      <input type="text" id="total_paid" class="form-control" name="totalPaid" onkeyup="calculate_remain()" onkeypress="return isNumberKey(event)" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label style="color: red;">DUE</label>
                      <input style="color: red;" type="text" name="due" class="form-control" id="total_remain" readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>PAYMENT MODE *</label>
                      <select class="form-control" name="accountType" id="accountType" required >
                        <option value="">Select One</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank">Bank</option>
                        <option value="Mobile">Mobile</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>ACCOUNT*</label>
                      <select class="form-control" name="accountNo" id="accountNo" >
                        <option value="">Select Account Type First</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>NOTE</label>
                      <input type="text" class="form-control" name="note" placeholder="If have any note">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>TERMS & CONDITIONS </label>
                        <textarea  type="text" class="form-control" name="terms" id="editor" placeholder="Terms & Conditions" rows="5" ></textarea>
                    </div>
                  </div>

                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
                    <a href="<?php echo site_url('serviceSale') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#service').change(function(){ 
          var id = $('#service option:selected').val();
          var info = {'id':id};
          var url = '<?php echo base_url() ?>'+'Service/get_Service_Details/';
            //alert(id);alert(info);alert(url);
          $.ajax({
            type: 'POST',
            async: false,
            url: url,
            data:info,
            dataType: 'json',
            success: function (data)
              {                            
              $('#mtable tbody').append(data);
              }
            });
          });
        });
    </script>

    <script type="text/javascript">
      function totalPrice(id)
        {
        var pices = $('#pices_'+id).val();
        var salePrice = $('#salePrice_'+id).val();

        var totalPrice = (parseFloat(salePrice).toFixed(2)*pices);
        $('#totalPrice_'+id).val(parseFloat(totalPrice).toFixed(2));
        
        calculateTotalPrice();
        }
        

      function calculateTotalPrice()
        {
        var sum=0;
        $(".totalPrice").each(function()
          {
          sum += parseFloat($(this).val());
          });
        $('#totalprice').val(parseFloat(sum).toFixed(2));
        $('#total_paid').val(parseFloat(sum).toFixed(2));
        }

      function calculate_remain()
        {
        var paid = $('#total_paid').val();
        var total = $('#totalprice').val();
        var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);
        $('#total_remain').val(remaining);
        }
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