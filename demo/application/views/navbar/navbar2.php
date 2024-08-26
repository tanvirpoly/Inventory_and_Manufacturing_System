<body class="ps-loading">
    <div class="header--sidebar"></div>
    <header class="header">
      <nav class="navigation">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-2 col-md-2 col-12">
              <div class="left" >
                <h3 style="text-transform: uppercase; padding: 15px;"><a href="<?php echo base_url().'store/'.$store['sid'].'/'.$store['sName']; ?>"><b><?= $store['sName']; ?></b></a></h3>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
              <div class="center">
                <ul class="main-menu menu">
                  <li class="menu-item"><a href="<?php echo base_url().'store/'.$store['sid'].'/'.$store['sName']; ?>">Home</a></li>
                  <li class="menu-item"><a href="<?php echo base_url().'infoPage/'.$store['sid'].'/'.$store['sName']; ?>">About Us</a></li>
                  
                  <?php foreach ($mcategory as $value) { ?>
                  <li class="menu-item"><a href="<?php echo base_url().'catProduct/'.$value['categoryID'].'/'.$store['sid']; ?>"><?php echo $value['categoryName']; ?></a></li>
                  <?php } ?>
                  
                  <li class="menu-item"><a href="<?php echo base_url().'contactUs/'.$store['sid'].'/'.$store['sName']; ?>">Contact Us</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
              <div class="right">
                <!--<form class="ps-search--header" action="#" method="post">-->
                <!--  <input class="form-control" type="text" placeholder="Search Product…">-->
                <!--  <button><i class="ps-icon-search"></i></button>-->
                <!--</form>-->
                <div class="ps-cart"><a class="ps-cart__toggle" href="#" style="margin-top: 25px;"><i class="ps-icon-shopping-cart"></i></a>
                  <div class="ps-cart__listing" style="background-color: #fff; color: #000; width: 400px;">
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
                    <tbody id="detail_cart">
    
                    </tbody>
                    
                  </table>
                  <div class="cart-bottom" >
                    <a href="<?php echo base_url().'checkOut/'.$store['sid']; ?>" class="form-control btn btn-success" style="padding: 10px; background-color: #000; color: #fff;">Check out</a>
                  </div>
                  </div>
                </div>
                <div class="menu-toggle"><span></span></div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>