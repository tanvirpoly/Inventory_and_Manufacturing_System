<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <!--<section class="content-header">-->
    <!--  <div class="container-fluid">-->
    <!--    <div class="row mb-2">-->
    <!--      <div class="col-sm-6">-->
    <!--        <h1>Purchase</h1>-->
    <!--      </div>-->
    <!--      <div class="col-sm-6">-->
    <!--        <ol class="breadcrumb float-sm-right">-->
    <!--          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>-->
    <!--          <li class="breadcrumb-item active">Purchase</li>-->
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
                <h3 class="card-title"> NEW PURCHASE </h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Purchase/savedPurchase") ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>DATE *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('d-m-Y') ?>" required >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>SUPPLIER *</label>
                        <div class="input-group">
                          <select name="suppliers" id="suppliers" class="form-control select2" required >
                          </select>
                          <span class="input-group-append">
                            <button type="button" class="btn btn-danger btn-sm supplier_add" data-toggle="modal" data-target=".bs-example-modal-supplier_add" ><i class="fa fa-plus"></i></button>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>PRODUCTS *</label>
                        <!--<div class="input-group input-group-sm">-->
                        <!--  <select name="productID" id="products" class="form-control select2" required >-->
                        <!--  </select>-->
                        <!--  <span class="input-group-append">-->
                        <!--    <button type="button" class="btn btn-danger btn-sm product" data-toggle="modal" data-target=".bs-example-modal-product" ><i class="fa fa-plus"></i></button>-->
                        <!--  </span>-->
                        <!--</div>-->

                        <select id="products" class="form-control select2" >
                          <option value="">Select One</option>
                          <?php foreach($product as $value){ ?>
                          <option value="<?php echo $value->productID; ?>"><?php echo $value->productName.' ( '.$value->productcode.' )'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                        
                      <div class="col-md-12 col-sm-12 col-12">
                        <table id="mtable" class="table table-bordered table-striped">
                          <thead class="btn-default">
                            <tr style="text-transform:uppercase; text-align:center;">
                              <th>PRODUCT</th>
                              <!--<th>Stock</th>      -->
                              <th>quantity</th>      
                              <th>UNIT PRICE</th>
                              <th>TOTAL PRICE</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody id="mtable">

                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="3" align="right">Shipping Cost</td>
                              <td colspan="2">
                                <input type="hidden" class="form-control" id="tsAmount"  value="0" required >
                                <input type="text" class="form-control" name="sCost" id="sCost" onkeyup="shippingCost()" required value="0" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">VAT (%)</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="vCost" id="vCost" onkeyup="vatcostcalculator()" value="0" >
                                <input type="hidden" class="form-control" name="vType" id="vType" value="0" >
                                <input type="hidden" class="form-control" name="vAmount" id="vAmount" value="0" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Net Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="nAmount" id="nAmount" required readonly >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Discount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="discount" id="discount" onkeyup="discountType()" value="0" >
                                <input type="hidden" class="form-control" id="disType" name="disType" value="0" >
                                <input type="hidden" class="form-control" id="disAmount" name="disAmount" value="0" >
                              </td>
                            </tr>
                            <tr>
                              <td STYLE="font-weight: bold;" colspan="3" align="right">Total Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="totalPrice" id="totalPrice" required readonly >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Paid Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="Paid" onkeypress="return isNumberKey(event)" onkeyup="calculate_remain()" id="Paid" required >
                              </td>
                            </tr>
                            <tr style="color: red;">
                              <td  colspan="3" align="right">Due Amount</td>
                              <td colspan="2">
                                <input style="color: red;" type="text" class="form-control" readonly name="due" id="remainging" >
                              </td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>

                      <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                      <!--  <label>Total Price *</label>-->
                      <!--  <input type="text" class="form-control" readonly name="totalPrice" id="totalPrice" required >-->
                      <!--</div>-->
                      <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                      <!--  <label>Paid Amount *</label>-->
                      <!--  <input type="text" class="form-control" name="Paid" onkeypress="return isNumberKey(event)" onkeyup="calculate_remain()" id="Paid" required >-->
                      <!--</div>-->
                      <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                      <!--  <label>Due Amount</label>-->
                      <!--  <input type="text" class="form-control" readonly name="due" id="remainging" >-->
                      <!--</div>-->
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
                        <select name="accountNo" id="accountNo" class="form-control" required >
                          <option value="">Select Account Type First</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" placeholder="If have any note">
                      </div>
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Terms & Conditions (Optional) </label>
                        <textarea  type="text" class="form-control" name="terms" id="editor" placeholder="Terms & Conditions" rows="5" ></textarea>
                      </div>
                    </div>             
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
                      <a href="<?php echo site_url('Purchase') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <div id="supplier_add" class="modal fade bs-example-modal-supplier_add" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Supplier</h4>
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
            <button type="submit" class="btn btn-primary" id="pbsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <div id="product_add" class="modal fade bs-example-modal-product" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Product Name *</label>
                <input type="text" class="form-control" name="productName" id="productName" placeholder="Product Name" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Category *</label>
                <select name="categoryID" id="categoryID" class="form-control" required >
                  <option value="">Select One</option>
                  <?php foreach($category as $value) { ?>
                  <option value="<?php echo $value['categoryID']; ?>"><?php echo $value['categoryName']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Unit *</label>
                <select name="unit" id="unit" class="form-control" required >
                  <option value="">Select One</option>
                  <?php  foreach($unit as $value) { ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->unitName; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Purchases Price *</label>
                <input type="text" class="form-control" id="pprice" name="pprice" placeholder="Purchase price" onkeypress="return isNumberKey(event)" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Sale Price *</label>
                <input type="text" class="form-control" id="sprice" name="sprice" placeholder="Sale price" onkeypress="return isNumberKey(event)" required >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="psubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;CANCEL</button>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>

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
              $("#suppliers").html(HTML);
              },
            error:function(data){
               alert('error');
              }
            });
          }

        $("#pbsubmit").click(function(){
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
                window.location.reload();
              }
            });
          return false;
        });
      });
    </script>

    <script type="text/javascript" >
      $(function(){
        load_products();
        function load_products(){
          var url = "<?php echo base_url()?>Purchase/get_purchase_product";
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
                  HTML +="<option value='"+data[key]["productID"]+"'>" + data[key]["productName"]+' ( '+ data[key]["productcode"]+' )'+"</option>";
                  }
                }
              $("#products").html(HTML);
              },
            error:function(data){
            //   alert('error');
              }
            });
          }

        $("#psubmit").click(function(){
          var productName = $("#productName").val();
          var categoryID = $("#categoryID").val();
          var unit = $("#unit").val();
          var pprice = $("#pprice").val();
          var sprice = $("#sprice").val();
          var dataString = 'productName='+ productName + '&categoryID='+ categoryID + '&unit='+ unit + '&pprice='+ pprice + '&sprice='+ sprice;
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Product/add_product') ?>",
            data: dataString,
            cache: false,
            success: function(result){
              //alert(result);
              load_products();
              $('#product_add').remove();
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
        $('#products').change(function(){    
          var id = $('#products').val();
            //alert(id);
          var base_url = '<?php echo base_url() ?>'+'Purchase/get_Product/'+id;
                // alert(base_url);
          $.ajax({
            type: 'GET',
            url: base_url,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#mtable').append(jsondata);
              }
            });
          });
        });
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        var value = $("#accountType").val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        $('#accountNo').val(1);
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
      function getTotal(id)
        {
        var pices = $('#tp_'+id).val();
        var salePrice = $('#quantity_'+id).val();

        var totalPrice = (parseFloat(salePrice).toFixed(2)*pices);
        $('#totalPrice_'+id).val(parseFloat(totalPrice).toFixed(2));
        
        calculateTotalPrice();
        }

      function calculateTotalPrice()
        {
        var sum=0;
        $(".tPrice").each(function()
          {
          sum += parseFloat($(this).val());
          });
        $('#totalPrice').val(parseFloat(sum).toFixed(2));
        $('#tsAmount').val(parseFloat(sum).toFixed(2));
        $('#nAmount').val(parseFloat(sum).toFixed(2));
        $('#Paid').val(parseFloat(sum).toFixed(2));
        }

      function calculate_remain()
        {
        var paid = $('#Paid').val();
        var total = $('#totalPrice').val();
        //var disc = $('#total_discount').val();
        //var tp = +paid + +disc;
        var remaining = parseFloat(total).toFixed(2)-parseFloat(paid).toFixed(2);
        //alert(disc); alert(tp); alert(remaining);
        $('#remainging').val(remaining);
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
        $('#totalPrice').val(parseFloat(total).toFixed(2));
        $('#Paid').val(parseFloat(total).toFixed(2));
        
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
        
        $('#totalPrice').val(parseFloat(remaining).toFixed(2));
        $('#Paid').val(parseFloat(remaining).toFixed(2));
        }
    </script>
