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
                <form method="POST" action="<?php echo site_url("Service/update_sale_service") ?>">
                  <input type="hidden" name="ssid" class="form-control" value="<?php echo $service['ssid']; ?>" required >
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Sale Date *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($service['ssDate'])) ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Customer *</label>
                      <select name="customer" class="form-control select2" required >
                        <option value="">Select One</option>
                        <?php foreach($customer as $value){ ?>
                        <option <?php echo ($service['custid'] == $value['customerID'])?'selected':''?> value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Service</label>
                      <select class="form-control" id="service" >
                        <option value="">Select One</option>
                        <?php foreach($serviceInfo as $value){ ?>
                        <option value="<?php echo $value['siid']; ?>"><?php echo $value['siName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="row" >
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Service</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Sub Total</th> 
                          <th>Action</th>                       
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php
                        $sl = 0;
                        foreach($sservice as $value){
                        $id = $value['siid'];
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['siName']; ?>
                            <input type='hidden' name='siid[]' value="<?php echo $value['siid']; ?>" required >
                          </td>     
                          <td>
                            <input type='text' onkeyup='totalPrice(<?php echo $id ?>)' class="form-control" name='pices[]' id='pices_<?php echo $id ?>' value="<?php echo $value['quantity']; ?>" required >
                          </td>
                          <td>
                            <input type='text' onkeyup='totalPrice(<?php echo $id ?>)' name='salePrice[]' id='salePrice_<?php echo $id ?>' class="form-control" value="<?php echo $value['sprice']; ?>" required >
                          </td>
                          <td>
                            <input type='text' class='totalPrice form-control' name='totalPrice[]' readonly id='totalPrice_<?php echo $id ?>' value="<?php echo $value['tPrice'] ?>" required >
                          </td>
                          <td>
                            <input type="button" class="btn btn-danger" value="Remove" onClick="$(this).parent().parent().remove();">
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="row" >
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Total Amount *</label>
                      <input type="text" name="totalprice" class="form-control" id="totalprice" value="<?php echo $service['amount']; ?>" required readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Paid Amount *</label>
                      <input type="text" id="total_paid" class="form-control" name="totalPaid" onkeyup="calculate_remain()" onkeypress="return isNumberKey(event)" value="<?php echo $service['pAmount']; ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Due Amount</label>
                      <input type="text" name="due" class="form-control" value="<?php echo $service['amount']-$service['pAmount']; ?>" id="total_remain" readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Account Type *</label>
                      <select class="form-control" name="accountType" id="accountType" required >
                        <option value="">Select One</option>
                        <option <?php echo ($service['accountType'] == 'Cash')?'selected':''?> value="Cash">Cash</option>
                        <option <?php echo ($service['accountType'] == 'Bank')?'selected':''?> value="Bank">Bank</option>
                        <option <?php echo ($service['accountType'] == 'Mobile')?'selected':''?> value="Mobile">Mobile</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Account No *</label>
                      <select class="form-control" name="accountNo" id="accountNo" >
                        <option value="">Select Account Type First</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" value="<?php echo $service['note']; ?>" >
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Terms & Conditions </label>
                        <textarea  type="text" class="form-control" name="terms" id="editor" placeholder="Terms & Conditions" rows="5" ><?php echo $service['terms']; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('serviceSale') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
      $(document).ready(function(){
        var value = $("#accountType").val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        $('#accountNo').val("<?php echo $service['accountNo']; ?>");
        });

      var url = '<?php echo site_url('Voucher')?>';

      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value,'#accountNo');
        });

        function getAccountNo(value,place){
          $(place).empty();
          if(value != '')
            {
            $.ajax({
              url: url+'/getAccountNo',
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
          else {
            $.alert({
              title: 'Alert!',
              content: 'Please Select Account Type',
              type: "red",
              icon: 'fa fa-warning',
              theme: "material",
              });
            }
        }
    </script>