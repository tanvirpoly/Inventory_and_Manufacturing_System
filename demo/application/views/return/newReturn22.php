<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Return</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Return</li>
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
                <h3 class="card-title">Return Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Returns/save_returns">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Returns Date *</label>
                            <input type="text" class="form-control datepicker" name="date" value="<?php echo date('d-m-Y') ?>" required >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Select Customer *</label>
                            <select class="form-control select2" name="customer" required >
                                <option value="">Select One</option>
                                <?php foreach ($customer as $value) { ?>
                                <option value="<?php echo $value['customerID'] ?>"><?php echo $value['customerName'].' ( '.$value['cus_id'].' )'; ?></option>
                                <?php } ?>
                            </select>
                        </div>  
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label>Select Product *</label>
                            <select name="productID" id="productID" class="form-control select2" required >
                                <option value="">Select One</option>
                                <?php foreach($product as $value): ?>
                                <option value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                                <?php endforeach?>
                            </select>
                        </div>
                    </div>

                    <div class="row" >
                        <table id="mtable" class="table table-bordered">
                            <thead class="btn-default">
                                <tr>
                                    <th>Products</th>
                                    <th>Quantity</th>              
                                    <th>Sale Price</th>
                                    <th>Total Price</th>                      
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Total Amount *</label>
                            <input type="text" class="form-control" name="totalprice" id="totalprice" readonly required >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Service Charge</label>
                            <input type="text" class="form-control" name="scharge" id="scharge" onkeyup="discountType()" value="0" >
                            <input type="hidden" class="form-control" id="sctype" name="sctype" >
                            <input type="hidden" class="form-control" id="scAmount" name="scAmount" >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Invoice No *</label>
                            <input type="text" class="form-control" name="invoice" required >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Account Type *</label>
                            <select class="form-control" name="accountType" id="accountType" required >
                                <option value="">Select One</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank</option>
                                <option value="Mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Account No *</label>
                            <select class="form-control" name="accountNo" id="accountNo" required >
                                <option value="">Select Account Type First</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Note</label>
                            <input type="text" class="form-control" name="note" placeholder="If have any note">
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                        <a href="<?php echo site_url('Return') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
        $('#productID').on('change',function(){
            var productID = $('#productID option:selected').val();
            //alert(productID);
            var table = 'products';
            var info = {'id':productID,'table':table};
            var base_url = '<?php echo base_url() ?>' + 'Returns/getDetails/';
            
            $.ajax({
                type: 'POST',
                async: false,
                url: base_url,
                data:info,
                dataType: 'json',
                success: function (data) {                            
                    $('#mtable tbody').append(data);
                    }
                });
            });
    </script>

    <script type="text/javascript">

        function totalPrice(id){
            var pices = $('#pices_'+id).val();
            var salePrice = $('#salePrice_'+id).val();
            
            var totalPrice = (parseFloat(salePrice).toFixed(2)*pices);
            $('#totalPrice_'+id).val(parseFloat(totalPrice).toFixed(2));
            
            calculateTotalPrice();
            }

        function calculateTotalPrice(){
            var sum=0;
            $(".totalPrice").each(function(){
                sum += parseFloat($(this).val());
            });
            $('#totalprice').val(parseFloat(sum).toFixed(2));
            }
    </script>

    <script type="text/javascript">
        function discountType(){
            var disc = $('#scharge').val();
            var discc = disc.slice(-1);
            var disca = disc.substring(0, disc.length - 1);
        //alert(disca);
            $('#sctype').val(discc);
            $('#scAmount').val(disca);
            }
    </script>

    <script type="text/javascript">

        $('#accountType').on('change', function(){
            var value = $(this).val();
            $('#accountNo').empty();
            getAccountNo(value,'#accountNo');
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
                    success: function(data){
                        //alert('hello');
                        $(place).append(data);
                        $(place).trigger("chosen:updated");
                    }
                });

            } else {
                $.alert({
                    title: 'Alert!',
                    content: 'Select Account Type',
                    type: "red",
                    icon: 'fa fa-warning',
                    theme: "material",
                });
            }
        }
    </script>