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
                <h3 class="card-title">Purchase Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Purchase/update_purchase") ?>">
                    <div class="row">
                        <input type="hidden" name="purhcase_id" value="<?php echo $purchase['purchaseID']; ?>">
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Purchase Date</label>
                            <input type="text" name="date" class="form-control datepicker" value="<?php echo date('d-m-Y',strtotime($purchase['purchaseDate'])) ?>" required >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Select Supplier *</label>
                            <select name="suppliers" class="form-control select2" required >
                                <option value="">Select One</option>
                                <?php foreach ($supplier as $value) { ?>
                                <option <?php echo ($purchase['supplier'] == $value['supplierID'])?'selected':''?> value="<?php echo $value['supplierID']; ?>" ><?php echo $value['supplierName'].' ( '.$value['sup_id'].' )'; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Select Product</label>                        
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
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php 
                                $ta = 0;
                                foreach($pproduct as $value):
                                $id = $value['productID'];
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $value['productName']; ?>
                                        <input type="hidden" readonly='readonly' name='product_id[]' value="<?php echo $value['productID']; ?>" required >
                                    </td> 
                                    <td>
                                        <input type='text' class="form-control" id="quantity_<?php echo $value['productID']?>" onkeyup="getTotal('<?php echo $id ?>')" name='quantity[]' value="<?php echo $value['quantity']; ?>" required >
                                    </td>
                                    <td>
                                        <!--<?php echo $value['pprice']; ?>-->
                                        <input type='text' onkeyup='getTotal(<?php echo $value['productID']?>)' id='tp_<?php echo $id; ?>' name='pprice[]' value='<?php echo $value['pprice']?>' required >
                                    </td>
                                    <td>
                                        <input readonly='readonly' type='text' class="tPrice" id='totalPrice_<?php echo $id; ?>' name='total_price[]' value='<?php echo $value['totalPrice']; $ta += $value['totalPrice']; ?>'>
                                    </td>
                                    <td>
                                      <span class="item_remove btn btn-danger btn-sm" onClick="$(this).parent().parent().remove();">x</span>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                            <tfoot>
                            <tr>
                              <td colspan="3" align="right">Shipping Cost</td>
                              <td colspan="2">
                                <input type="hidden" class="form-control" id="tsAmount"  value="<?php echo $ta; ?>" required >
                                <input type="text" class="form-control" name="sCost" id="sCost" onkeyup="shippingCost()" required value="<?php echo $purchase['sCost']; ?>" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">VAT (%)</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="vCost" id="vCost" onkeyup="vatcostcalculator()" value="<?php echo $purchase['vCost']; ?>" >
                                <input type="hidden" class="form-control" name="vType" id="vType" value="<?php echo $purchase['vType']; ?>"  >
                                <input type="hidden" class="form-control" name="vAmount" id="vAmount" value="<?php echo $purchase['vAmount']; ?>" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Net Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="nAmount" id="nAmount" value="<?php echo ($ta+$purchase['sCost']+$purchase['vAmount']); ?>" required readonly >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Discount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="discount" id="discount" onkeyup="discountType()" value="<?php echo $purchase['discount']; ?>" >
                                <input type="hidden" class="form-control" id="disType" name="disType" value="<?php echo $purchase['disType']; ?>" >
                                <input type="hidden" class="form-control" id="disAmount" name="disAmount" value="<?php echo $purchase['disAmount']; ?>" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Total Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" readonly name="totalPrice" id="totalPrice" required value="<?php echo $purchase['totalPrice']; ?>" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Paid Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" name="Paid" onkeyup="calculate_remain()" id="Paid" required value="<?php echo $purchase['paidAmount']; ?>" onkeypress="return isNumberKey(event)" >
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" align="right">Due Amount</td>
                              <td colspan="2">
                                <input type="text" class="form-control" readonly name="due" id="remainging" value="<?php echo $purchase['due']; ?>" >
                              </td>
                            </tr>
                          </tfoot>
                        </table>  
                    </div>    

                        <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                        <!--    <label>Total Price *</label>-->
                        <!--    <input type="text" class="form-control" readonly name="totalPrice" id="totalPrice" required value="<?php echo $purchase['totalPrice']; ?>" >-->
                        <!--</div>-->
                        <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                        <!--    <label>Paid Amount *</label>-->
                        <!--    <input type="text" class="form-control" name="Paid" onkeyup="calculate_remain()" id="Paid" required value="<?php echo $purchase['paidAmount']; ?>" onkeypress="return isNumberKey(event)" >-->
                        <!--</div>-->
                        <!--<div class="form-group col-md-4 col-sm-4 col-xs-12">-->
                        <!--    <label>Due Price</label>-->
                        <!--    <input type="text" class="form-control" readonly name="due" id="remainging" value="<?php echo $purchase['due']; ?>" >-->
                        <!--</div>-->
                        
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Account Type *</label>
                            <select class="form-control" name="accountType" id="accountType" required >
                                <option <?php echo ($purchase['accountType'] == 'Cash')?'selected':''?> value="Cash">Cash</option>
                                <option <?php echo ($purchase['accountType'] == 'Bank')?'selected':''?> value="Bank">Bank</option>
                                <option <?php echo ($purchase['accountType'] == 'Mobile')?'selected':''?> value="Mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Account Number *</label>
                            <select name="accountNo" id="accountNo" class="form-control" required >
                                <option value="">Select Account Type First</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Note</label>
                            <input type="text" class="form-control" name="note" value="<?php echo $purchase['note']; ?>" >
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-12">
                          <label>Terms & Conditions </label>
                          <textarea  type="text" class="form-control" name="terms" id="editor" placeholder="Terms & Conditions" rows="5" ><?php echo $purchase['terms']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                      <a href="<?php echo site_url('Purchase') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
            $('#accountNo').val("<?php echo $purchase['accountNo'] ?>");
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
