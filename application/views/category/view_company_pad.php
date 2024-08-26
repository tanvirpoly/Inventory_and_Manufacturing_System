<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/style.css">
    <title>Company Pad</title>
  </head>

  <body>
    <div class="my-5 page" size="A4">
      <div class="p-5">
          
        <section class="top-content bb d-flex justify-content-between">
          <div class="left_logo">
            <img src="<?php echo base_url(); ?>assets/dist/logo.png" alt="" class="img-fluid" >
          </div>
          
          <div class="top-left">
              
            <!--<div class="logo">-->
            <!--  <img src="<?php echo base_url(); ?>assets/dist/logo2.jpg" alt=""  >-->
            <!--</div>-->
            
            <div class="position-relative" style="right: 120px; top: 110px;">
                
                 <h1>NANAN ENTERPRISE</h1>
                 
              <!--<p><span>Eastern Mollika Shopping Complex</span> </p>-->
              <!--<p>Email: <span>bondonshop@gmail.com</span></p>-->
              <!--<p>Call: <span>01717-380568</span></p>-->
              
            </div>
          </div>
          
        </section>

        <section class="store-user mt-1">
          <div class="col-12">
            <div class="row pb-3">
              <div class="col-8">
                <p>Ref: <?php echo $cpad[0]['pRCode']; ?></p> 
              </div>
              <div class="col-4">
                <p>Date: <?php echo date('d-m-Y',strtotime($cpad[0]['pDate'])); ?></p>
              </div>
              <div class="col-12">
                <p><?php echo $cpad[0]['pDetails']; ?></p>
              </div>
            </div>
          </div>
        </section>
        
        
        
        
             <footer>
                
                <div class="container-fluid bg-3 text-center">    
                    <div class="row">
                      <div class="col-sm-4">
                        <span class="pr-2">
                            <i class="fa-solid fa-location-dot"></i>
                           <b><span> &nbsp Konora-1913, Nagarpur, Tangail</span></b> 
                        </span>
                      </div>

                      <div class="col-sm-4"> 
                        <span class="pr-2">
                            <i class="fa-solid fa-globe"></i>
                           <b><span> &nbsp www.nanan.com.bd
                            &nbsp &nbsp &nbsp &nbsp &nbsp nananfood@gmail.com</span></b> 
                        </span>
                      </div>

                      <div class="col-sm-4"> 
                        <span class="pr-2">
                            <i class="fa-solid fa-mobile-screen"></i>
                            <b><span> &nbsp 01728-176824</span></b> 
                        </span>
                      </div>
                  
                    </div>
                  </div>

            </footer>
        
        
        
        
        
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script type="text/javascript">
      $(function(){
        window.print();
        return false;
        });
    </script>
    
     <script src="https://kit.fontawesome.com/34b69a671e.js" crossorigin="anonymous"></script>
    
  </body>
  
</html>