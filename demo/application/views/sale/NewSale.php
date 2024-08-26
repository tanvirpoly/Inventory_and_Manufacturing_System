<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <!--<section class="content-header">-->
    <!--  <div class="container-fluid">-->
    <!--    <div class="row mb-2">-->
    <!--      <div class="col-sm-6">-->
    <!--        <h1>Sales</h1>-->
    <!--      </div>-->
    <!--      <div class="col-sm-6">-->
    <!--        <ol class="breadcrumb float-sm-right">-->
    <!--          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>-->
    <!--          <li class="breadcrumb-item active">Sales</li>-->
    <!--        </ol>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->
    
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
              <div class="card-header">
                <h3 class="card-title">NEW SALE</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Sale/saved_sale" >
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>DATE *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('d-m-Y') ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>CUSTOMER *</label>
                      <div class="input-group input-group-sm">
                        <select name="customerID" id="customerID" class="form-control select2" required >
                        </select>
                        <span class="input-group-append">
                          <button type="button" class="btn btn-danger btn-sm customer_add" data-toggle="modal" data-target=".bs-example-modal-customer_add" ><i class="fa fa-plus"></i></button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>PRODUCT *</label>
                      <select id="productID" class="form-control select2"  >
                        <option value="">Select One</option>
                        <?php foreach($product as $value): ?>
                        <option value="<?php echo $value->productID; ?>"><?php echo $value->productName.' ( '.$value->productcode.' )'; ?></option>
                        <?php endforeach?>
                      </select>
                    </div>

                    <div class="col-md-12 col-sm-12 col-12" >
                      <table id="mtable" class="table table-bordered table-striped">
                        <thead class="btn-default">
                          <tr>
                            <th>PRODUCT NAME</th>
                            <th>STOCK</th>
                            <th>SALE QTY</th>
                            <th>UNIT PRICE</th>
                            <th>SUB TOTAL</th> 
                            <th>ACTION</th>                       
                          </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4" align="right" ><b>Shipping Cost</b></td>
                            <td colspan="2" >
                              <input type="hidden" class="form-control" id="tsAmount"  value="0" required >
                              <input type="text" class="form-control" name="sCost" id="sCost" onkeyup="shippingCost()" required value="0" >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="right" ><b>VAT (%)</b></td>
                            <td colspan="2" >
                              <input type="text" class="form-control" name="vCost" id="vCost" onkeyup="vatcostcalculator()" value="0" >
                              <input type="hidden" class="form-control" name="vType" id="vType" value="0" >
                              <input type="hidden" class="form-control" name="vAmount" id="vAmount" value="0" >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="right" ><b>Net Amount</b></td>
                            <td colspan="2" >
                              <input type="text" class="form-control" name="nAmount" id="nAmount" required readonly >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="right" ><b>Discount</b></td>
                            <td colspan="2" >
                              <input type="text" class="form-control" name="discount" id="discount" onkeyup="discountType()" value="0" >
                              <input type="hidden" class="form-control" id="disType" name="disType" value="0" >
                              <input type="hidden" class="form-control" id="disAmount" name="disAmount" value="0" >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="right" ><b>Total Amount</b></td>
                            <td colspan="2" >
                              <input type="text" name="totalprice" class="form-control" id="totalprice" required readonly >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="right" ><b>Paid Amount</b></td>
                            <td colspan="2" >
                              <input type="text" id="total_paid" class="form-control" name="total_paid" onkeyup="calculate_remain()" value="0" onkeypress="return isNumberKey(event)" required >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="right" ><b style="color: red;">Due Amount</b></td>
                            <td colspan="2" >
                              <input type="text" name="due" class="form-control" id="total_remain" readonly >
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>PAYMENT MODE *</label>
                      <select class="form-control" name="accountType" id="accountType" required >
                        <option value="Cash">Cash</option>
                        <option value="Bank">Bank</option>
                        <option value="Mobile">Mobile</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>ACCOUNT *</label>
                      <select class="form-control" name="accountNo" id="accountNo" required >
                        <option value="">Select Account Type First</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Note</label>
                      <input type="text" class="form-control" name="note" placeholder="If have any note">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Terms & Conditions </label>
                        <textarea  type="text" class="form-control" name="terms" id="editor" placeholder="Terms & Conditions" rows="5" ></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('Sale') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
                  </div>
                </form>
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


<?php $this->load->view('footer/footer'); ?>

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
                window.location.reload();
              }
            });
          return false;
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#productID').change(function(){ 
          var id = $('#productID option:selected').val();
          var table = 'products';
          var info = {'id':id,'table':table};
          var base_url = '<?php echo base_url() ?>' + 'Sale/getDetails/';
            
          $.ajax({
            type: 'POST',
            async: false,
            url: base_url,
            data:info,
            dataType: 'json',
            success: function (data)
              {
              $('#mtable tbody').append(data);
              },
            error:function(data){
               alert('Your stock is over');
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
        $('#tsAmount').val(parseFloat(sum).toFixed(2));
        $('#nAmount').val(parseFloat(sum).toFixed(2));
        $('#total_paid').val(parseFloat(sum).toFixed(2));
        }

      function calculate_remain()
        {
        var paid = $('#total_paid').val();
        var total = $('#totalprice').val();
        //var disc = $('#total_discount').val();
        //var tp = +paid + +disc;
        var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);
        //alert(disc); alert(tp); alert(remaining);
        $('#total_remain').val(remaining);
        }
    </script>
    
    <script type="text/javascript">
      function shippingCost(){
        var sCost = $('#sCost').val();
        var total = $('#tsAmount').val();
        var tdis = $('#disAmount').val();
        var tvat = $('#vAmount').val();
      
        var da = +sCost + +total;
        var dat = +da + +tvat;
            //alert(da);alert(dat);
        var total = dat-tdis;
            //alert(remaining);
        
        $('#nAmount').val(parseFloat(total).toFixed(2));
        $('#totalprice').val(parseFloat(total).toFixed(2));
        $('#total_paid').val(parseFloat(total).toFixed(2));
        
        }
    </script>
    
    <script type="text/javascript">
      function vatcostcalculator(){
        var vat = $('#vCost').val();
        var total = $('#tsAmount').val();
        var discc = vat.slice(-1);
        var disca = vat.substring(0, vat.length - 1);
        //alert(discc);
        $('#vType').val(discc);
        
        if(discc == '%')
          {
          var da = parseFloat(total).toFixed(2)*parseFloat(disca).toFixed(2);
          var dat = parseFloat(da).toFixed(2)/100;
            //alert(da);alert(dat);
          //var remaining = parseFloat(total).toFixed(2)-parseFloat(dat).toFixed(2);
            
          $('#vAmount').val(dat);
          }
        else
          {
          var remaining = parseFloat(total).toFixed(2)-parseFloat(vat).toFixed(2);
          $('#vAmount').val(vat);
          }
            //alert(remaining);
        shippingCost();
        }
    </script>
    
    <script type="text/javascript">
      function discountType(){
        var disc = $('#discount').val();
        var total = $('#nAmount').val();
        var discc = disc.slice(-1);
        var disca = disc.substring(0, disc.length - 1);
            //alert(discc);
        $('#disType').val(discc);
        
        if(discc == '%')
          {
          var da = parseFloat(total).toFixed(2)*parseFloat(disca).toFixed(2);
          var dat = parseFloat(da).toFixed(2)/100;
            //alert(da);alert(dat);
          var remaining = parseFloat(total).toFixed(2)-parseFloat(dat).toFixed(2);
            
          $('#disAmount').val(dat);
          }
        else
          {
          var remaining = parseFloat(total).toFixed(2)-parseFloat(disc).toFixed(2);
          $('#disAmount').val(disc);
          }
          //alert(remaining);
        
        $('#totalprice').val(parseFloat(remaining).toFixed(2));
        $('#total_paid').val(parseFloat(remaining).toFixed(2));
        }
    </script>
    
    <script type="text/javascript" >
        function myFunction() {
          var checkBox = document.getElementById("fullPaid");
          if(checkBox.checked == true)
            {
            var disc = $('#total_discount').val();
            var total = $('#totalprice').val();
            //alert(total); alert(disc); 
            var remaining = parseFloat(total).toFixed(2)-parseFloat(disc).toFixed(2);
            $('#total_paid').val(remaining);
            $('#total_remain').val(0);
            } 
        else
            {var disc = $('#total_discount').val();
            var total = $('#totalprice').val();
            var remaining = parseFloat(total).toFixed(2)-parseFloat(disc).toFixed(2);
            $('#total_paid').val(0);
            $('#total_remain').val(remaining);
            }
        }
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        var value = $("#accountType").val();
        $('#accountNo').val(1);
        getAccountNo(value, '#accountNo');
        //$('#accountNo').val(1);
        });
    
      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        });
        
        function getAccountNo(value,place){
          $(place).empty();
          if(value != ''){
              //alert(value);
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