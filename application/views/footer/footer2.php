  <div class="ps-footer bg--cover" >
    <div class="ps-footer__content" style="padding: 30px 0;">
      <div class="ps-container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
            <aside class="ps-widget--footer ps-widget--info">
              <footer style="color: #fff;">
                <span style="font-size: 20px;"><?= $store['sName']; ?></span><br><br>
                <span><?= $store['sMobile']; ?></span><br>
                <span><?= $store['sEmail']; ?></span><br>
                <span><?= $store['sAddress']; ?></span>
              </footer>
            </aside>
          </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                <aside class="ps-widget--footer ps-widget--link">
                  <header>
                    <h3 class="ps-widget__title">Information</h3>
                  </header>
                  <footer>
                    <ul class="ps-list--link">
                      <li><a href="<?php echo base_url().'infoPage/'.$store['sid'].'/'.$store['sName']; ?>">About Us</a></li>
                      <li><a href="<?php echo base_url().'contactUs/'.$store['sid'].'/'.$store['sName']; ?>">Contact Us</a></li>
                    </ul>
                  </footer>
                </aside>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                <aside class="ps-widget--footer ps-widget--link">
                  <header>
                    <h3 class="ps-widget__title">Categorys</h3>
                  </header>
                  <footer>
                    <ul class="ps-list--line">
                      <?php foreach ($category as $pvalue) { ?>
                      <li><a href="<?php echo base_url().'catProduct/'.$pvalue['categoryID'].'/'.$store['sid']; ?>"><?php echo $pvalue['categoryName']; ?></a></li>
                      <?php } ?>
                    </ul>
                  </footer>
                </aside>
              </div>
            </div>
          </div>
        </div>
        <div class="ps-footer__copyright">
          <div class="ps-container">
            <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                <p><strong>Copyright &copy; 2021 <a href="<?php echo base_url().'store/'.$store['sid'].'/'.$store['sName']; ?>" target="_blank" ><?= $store['sName']; ?></a> .</strong> All rights reserved. <strong> <a href="https://sunshine.com.bd/" target="_blank" >Powered by Sunshine</a> .</strong></p>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                <ul class="ps-social">
                  <li><a href="<?php echo $store['sFacebook']; ?>"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="<?php echo $store['sGoogle']; ?>"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="<?php echo $store['sTwitter']; ?>"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="<?php echo $store['sInstagram']; ?>"><i class="fa fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-angle-up fa-2x" ></i></button>
    
    <!-- JS Library-->
    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/owl-carousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/gmap3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/imagesloaded.pkgd.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/jquery.matchHeight-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/slick/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/elevatezoom/jquery.elevatezoom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/Magnific-Popup/dist/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAx39JFH5nhxze1ZydH-Kl8xXM3OK4fvcg&amp;region=GB"></script><script type="text/javascript" src="plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/plugins/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <!-- Custom scripts-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/web/js/main.js"></script>
    
    
    <script type="text/javascript">
        //Get the button
        var mybutton = document.getElementById("myBtn");
        
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};
        
        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
        }
        
        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }
    </script>
    
  </body>
</html>