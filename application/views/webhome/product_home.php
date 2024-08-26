<?php $this->load->view('header/header2'); ?>
<?php $this->load->view('navbar/navbar2'); ?>
    
    <main class="ps-main">
      <div class="ps-banner">
        <div class="rev_slider fullscreenbanner" id="home-banner">
          <img src="<?php echo base_url().'upload/company/'.$store['sbImage']; ?>" alt="banar Image" style="margin-top: -15px; width: 100%; height: 360px;" >
        </div>
      </div>
      
      <div class="ps-section--features-product ps-section masonry-root pt-30">
        <div class="ps-container">
          <div class="ps-section__header mb-30">
            <h3 class="ps-section__title" data-mask="features">- Features Products</h3>
            <!--<ul class="ps-masonry__filter">-->
            <!--  <?php foreach ($category as $value) { ?>-->
            <!--  <li class="current"><a href="#" data-filter=".Consumable_Items"><?php echo $value['categoryName']; ?></a></li>-->
            <!--  <?php } ?>-->
            <!--</ul>-->
          </div>
          <div class="ps-section__content pb-50">
            <div class="masonry-wrapper" data-col-md="4" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
              <div class="ps-masonry">
                <div class="grid-sizer"></div>
                
                <?php foreach ($product as $pvalue) { ?>
                <div class="grid-item" style="height: 350px;">
                  <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                      <div class="ps-shoe__thumbnail">
                        <a class="ps-shoe__favorite" href="<?php echo base_url().'pDetails/'.$pvalue['productID'].'/'.$store['sid']; ?>"><i class="ps-icon-heart"></i></a>
                        <?php if($pvalue['image'] != null){ ?>
                        <img src="<?php echo base_url().'/upload/product/'.$pvalue['image']; ?>" alt="" style="height: 220px; width: auto;">
                        <?php } else{ ?>
                        <img src="<?php echo base_url().'/assets/web/product.jpg'; ?>" alt="" style="height: 220px; width: auto;">
                        <?php } ?>
                        <a class="ps-shoe__overlay" href="<?php echo base_url().'pDetails/'.$pvalue['productID'].'/'.$store['sid']; ?>"></a>
                      </div>
                      <div class="ps-shoe__content">
                        <div class="ps-shoe__detail">
                          <a class="ps-shoe__name" href="<?php echo base_url().'pDetails/'.$pvalue['productID'].'/'.$store['sid']; ?>"><?php echo $pvalue['productName']; ?></a>
                          <div class="ps-shoe__name"><b>৳ <?php echo $pvalue['sprice']; ?></b></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      
<?php $this->load->view('footer/footer2'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#add_cart').click(function(){
          var pid = $(this).data("productid");
          var name  = $(this).data("productname");
          var pprice = $(this).data("productprice");
          //alert(pid);alert(name);alert(pprice);
          $.ajax({
            url : "<?php echo site_url('Webhome/add_to_cart');?>",
            method : "POST",
            data : {pid: pid,name:name,pprice:pprice},
            success: function(data){
              $('#detail_cart').html(data);
              }
            });
          });
 
        $('#detail_cart').load("<?php echo site_url('Webhome/load_cart');?>");
 
        $(document).on('click','.romove_cart',function(){
          var row_id = $(this).attr("id"); 
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