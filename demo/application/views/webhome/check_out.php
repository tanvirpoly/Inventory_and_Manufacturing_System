<?php $this->load->view('header/header2'); ?>
<?php $this->load->view('navbar/navbar2'); ?>

    <main class="ps-main">
    <div class="ps-product--detail pt-30">
      <div class="ps-container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title m-0"><b>Checkout Information</b></h3>
              </div>
              <div class="card-body">
                <form action="<?php echo base_url('Webhome/save_order_product'); ?>" method="post" >
                  <input type="hidden" class="form-control" name="sid" value="<?php echo $store['sid']; ?>" required  >
                  <input type="hidden" class="form-control" name="sName" value="<?php echo $store['sName']; ?>"  required  >
                  <input type="hidden" class="form-control" name="compid" value="<?php echo $store['compid']; ?>"  required  >
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-12">
                      <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Your Name *" required  >
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="mobile" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" placeholder="Mobile Number *" required >
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="address" placeholder="Delivery Address *" required >
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email(Optional)" >
                      </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="cart_product">
    
                        </tbody>
                        
                      </table>
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                    <button style="background-color: #66BB6A;" type="submit" class="btn btn-info"><i class=""></i>&nbsp;&nbsp;Ordre Now</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer2'); ?>

    <script type="text/javascript">
      $(window).load(function(){

        $('#cart_product').load("<?php echo site_url('Webhome/load_product_cart');?>");
 
        $(document).on('click','.romove_cart',function(){
          var row_id = $(this).attr("id"); 
          $.ajax({
            url : "<?php echo site_url('Webhome/delete_cart');?>",
            method : "POST",
            data : {row_id : row_id},
            success :function(data){
              $('#cart_product').html(data);
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
        $(".tPrice").each(function()
          {
          sum += parseFloat($(this).val());
          });

        HTML = '<span>'+sum+'</span>';

        $('#tamount').html(HTML);
        }
    </script>