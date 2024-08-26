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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Sale Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Sale/update_sale" >
                    <input type="hidden" name="saleID" value="<?php echo $sale['saleID']; ?>">
                    
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Sale Date *</label>
                            <input type="text" name="date" class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($sale['saleDate'])) ?>" required >
                        </div> 
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Select Customer *</label>
                            <select class="form-control select2" name="customerID" required >
                                <option value="">Select One</option>
                                <?php foreach($customer as $value):?>
                                <option <?php echo ($sale['customerID'] == $value['customerID'])?'selected':''?> value="<?php echo $value['customerID']; ?>"><?php echo $value['customerName'].' ( '.$value['mobile'].' )'; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Select Product</label>
                            <select name="productID" id="productID" class="form-control select2">
                                <option value="">Select One</option>
                                <?php foreach($product as $value){ ?>
                                <option value="<?php echo $value->productID; ?>"><?php echo $value->productName.' ( '.$value->productcode.' )'; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    <div class="col-sm-12 col-md-12 col-12"  >
                        <table id="mtable" class="table table-bordered table-striped">
                            <thead class="btn-default">
                                <tr>
                                    <th>Products</th>
                                    <th>Stock Quantity</th>
                                    <th>Sale Quantity</th>
                                    <th>Sale Price</th>
                                    <th>Total Price</th> 
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php
                                $sl = 0;
                                foreach($salesp as $value){
                                $id = $value['productID'];
                                $sqt = $this->db->select('totalPices')
                                            ->from('stock')
                                            ->where('compid',$_SESSION['compid'])
                                            ->where('product',$id)
                                            ->get()
                                            ->row();
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $value['productName']; ?>
                                        <input type='hidden' name='productID[]' value="<?php echo $value['productID']; ?>">
                                    </td>
                                    <td>
                                        <?php echo $sqt->totalPices; ?>
                                    </td>      
                                    <td>
                                        <input type='text' onkeyup='totalPrice(<?php echo $id ?>)' name='pices[]' id='pices_<?php echo $id ?>' value="<?php echo $value['quantity']; ?>">
                                    </td>
                                    <td>
                                        <!--<?php echo $value['sprice']?>-->
                                        <input type='text' onkeyup='totalPrice(<?php echo $id ?>)' name='salePrice[]' id='salePrice_<?php echo $id ?>' value="<?php echo $value['sprice']; ?>" required >
                                    </td>
                                    <td>
                                        <input type='text' class='totalPrice' name='totalPrice[]' readonly id='totalPrice_<?php echo $id ?>' value="<?php echo $value['totalPrice']; $sl += $value['totalPrice']; ?>" >
                                    </td>
                                    <td>
                                      <span class="item_remove btn btn-danger btn-sm" onClick="$(this).parent().parent().remove();">x</span>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4" align="right" ><b>Shipping Cost</b></td>
                                <td colspan="2" >
                                  <input type="hidden" class="form-control" id="tsAmount"  value="<?php echo $sl; ?>" required >
                                  <input type="text" class="form-control" name="sCost" id="sCost" onkeyup="shippingCost()" value="<?php echo $sale['sCost']; ?>" required  >
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" align="right" ><b>VAT (%)</b></td>
                                <td colspan="2" >
                                  <input type="text" class="form-control" name="vCost" id="vCost" onkeyup="vatcostcalculator()" value="<?php echo $sale['vCost']; ?>" >
                                  <input type="hidden" class="form-control" name="vType" id="vType" value="<?php echo $sale['vType']; ?>" >
                                  <input type="hidden" class="form-control" name="vAmount" id="vAmount" value="<?php echo $sale['vAmount']; ?>" >
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" align="right" ><b>Net Amount</b></td>
                                <td colspan="2" >
                                  <input type="text" class="form-control" name="nAmount" id="nAmount" value="<?php echo ($sl+$sale['sCost']+$sale['vAmount']); ?>" required readonly >
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" align="right" ><b>Discount</b></td>
                                <td colspan="2" >
                                  <input type="text" class="form-control" name="discount" id="discount" onkeyup="discountType()" value="<?php echo $sale['discount']; ?>" >
                                  <input type="hidden" class="form-control" id="disType" name="disType" value="<?php echo $sale['discountType']; ?>" >
                                  <input type="hidden" class="form-control" id="disAmount" name="disAmount" value="<?php echo $sale['discountAmount']; ?>" >
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" align="right" ><b>Total Amount</b></td>
                                <td colspan="2" >
                                  <input type="text" readonly name="totalprice" class="form-control" id="totalprice" required value="<?php echo $sale['totalAmount']; ?>" >
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" align="right" ><b>Paid Amount</b></td>
                                <td colspan="2" >
                                  <input type="text" id="total_paid" class="form-control" name="total_paid" onkeyup="calculate_remain()" value="<?php echo $sale['paidAmount']; ?>" onkeypress="return isNumberKey(event)" required >
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" align="right" ><b>Due Amount</b></td>
                                <td colspan="2" >
                                  <input type="text" readonly name="due" class="form-control" id="total_remain" value="<?php echo $sale['totalAmount']-$sale['paidAmount']; ?>"  >
                                </td>
                              </tr>
                            </tfoot>
                        </table>
                    </div>

                        <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                        <!--    <label>Total Amount *</label>-->
                        <!--    <input type="text" readonly name="totalprice" class="form-control" id="totalprice" required value="<?php echo $sale['totalAmount']; ?>" >-->
                        <!--</div>-->
                        <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                        <!--    <label>Total Amount *</label>-->
                        <!--    <input type="text" id="total_paid" class="form-control" name="total_paid" onkeyup="calculate_remain()" value="<?php echo $sale['paidAmount']; ?>" onkeypress="return isNumberKey(event)" required >-->
                        <!--</div>-->
                        <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                        <!--    <label>Due Amount </label>-->
                        <!--    <input type="text" readonly name="due" class="form-control" id="total_remain" value="<?php echo $sale['totalAmount']-$sale['paidAmount']; ?>"  >-->
                        <!--</div>-->
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Account Type *</label>
                            <select class="form-control" name="accountType" id="accountType" required >
                                <option value="">Select One</option>
                                <option <?php echo ($sale['accountType'] == 'Cash')?'selected':''?> value="Cash">Cash</option>
                                <option <?php echo ($sale['accountType'] == 'Bank')?'selected':''?> value="Bank">Bank</option>
                                <option <?php echo ($sale['accountType'] == 'Mobile')?'selected':''?> value="Mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Account No *</label>
                            <select class="form-control" name="accountNo" id="accountNo" required >
                                <option value="">Select Account Type First</option>
                            </select>
                        </div>
                        <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                        <!--    <label>Discount</label>-->
                        <!--    <input type="text" class="form-control" name="discount" id="discount" value="<?php echo $sale['discount']; ?>" onkeyup="discountType()" value="0" >-->
                        <!--    <input type="hidden" class="form-control" id="discounttype" name="discounttype" >-->
                        <!--    <input type="hidden" class="form-control" id="discountamount" name="discountamount" value="<?php echo $sale['discountAmount']; ?>" >-->
                        <!--</div>-->
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Note</label>
                            <input type="text" class="form-control" name="note" value="<?php echo $sale['note']; ?>" >
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-12">
                          <label>Terms & Conditions </label>
                          <textarea  type="text" class="form-control" name="terms" id="editor" placeholder="Terms & Conditions" rows="5" ><?php echo $sale['terms']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                        <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
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
    
<?php $this->load->view('footer/footer'); ?>


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

    <script type="text/javascript">

        $(document).ready(function(){
            var value = $("#accountType").val();
            $('#accountNo').empty();
            getAccountNo(value, '#accountNo');
            $('#accountNo').val("<?php echo $sale['accountNo'] ?>");
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
