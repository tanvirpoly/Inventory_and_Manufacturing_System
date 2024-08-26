<?php $this->load->view('header/header2'); ?>
<?php $this->load->view('navbar/navbar2'); ?>
  
  <main class="ps-main">
    <div class="ps-product--detail pt-30">
      <div class="ps-container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title m-0"><b>Product Information</b></h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12 mb-60" style="border-radius: 10px; padding: 10px;">
                    <div class="image">
                        <?php if($product['image'] != null){ ?>
                        <img src="<?php echo base_url().'/upload/product/'.$product['image']; ?>" alt="product" style="height: auto; width: 100%; border-radius: 20px;" >
                        <?php } else{ ?>
                        <img src="<?php echo base_url().'/assets/web/product.jpg'; ?>" alt="product" style="height: auto; width: 100%; border-radius: 20px;">
                        <?php } ?>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <div class="content">
                      <div class="title-category">
                        <h3><b><?php echo $product['productName']; ?></b></h3>
                      </div>
                      <div class="col-lg-12 col-md-12 col-12">
                        <h3>৳ <?php echo $product['sprice']; ?></h3>
                      </div><br>
                      <div class="col-lg-12 col-md-12 col-12">
                        <?php 
                        $query = $this->db->select('totalPices')->from('stock')->where('compid',$compid)->where('product',$product['productID'])->get()->row();
                        ?>
                        <h4>In Stock : <?php if($query){ ?> <?php echo $query->totalPices; ?> <?php } else { ?> <b><?php echo '0'; ?></b> <?php } ?></h4>
                      </div><br>
                      <div class="col-lg-12 col-md-12 col-12" style="padding-top: 20px;">
                        <button class="btn btn-info" id="add_cart" data-productid="<?php echo $product['productID']; ?>" data-productname="<?php echo $product['productName']; ?>" data-productprice="<?php echo $product['sprice']; ?>">add to cart</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="ps-product__content">
                  <ul class="tab-list" role="tablist">
                    <li class="active"><a href="#tab_01" aria-controls="tab_01" role="tab" data-toggle="tab">Product Description</a></li>
                    <li><a href="#tab_02" aria-controls="tab_02" role="tab" data-toggle="tab">Product Specification</a></li>
                  </ul>
                </div>
                <div class="tab-content mb-60">
                  <div class="tab-pane active" role="tabpanel" id="tab_01">
                    <p style="text-align: justify;"><?php echo $product['details']; ?></p>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="tab_02">
                    <p style="text-align: justify;"><?php echo $product['specifict']; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer2'); ?>

    <script type="text/javascript">
      $(window).load(function(){
        $('#add_cart').click(function(){
          var pid = $(this).data("productid");
          var name  = $(this).data("productname");
          var pprice = $(this).data("productprice");
          var url = '<?php echo base_url() ?>Webhome/add_to_cart';
          //alert(url);//alert(name);alert(pprice);
          $.ajax({
            url : url,
            method : "POST",
            data : {pid: pid,name:name,pprice:pprice},
            success: function(data){
                //alert(data);
              $('#detail_cart').html(data);
              }
            });
          });
 
        $('#detail_cart').load("<?php echo site_url('Webhome/load_cart');?>");
        
        $(document).on('click','.romove_cart',function(){
          var row_id = $(this).attr("id");
          //alert('hello');
          $.ajax({
            url : "<?php echo site_url('Webhome/delete_cart');?>",
            method : "POST",
            data : {row_id : row_id},
            success :function(data){
              $('#detail_cart').html(data);
              }
            });
          });
        });
    </script>