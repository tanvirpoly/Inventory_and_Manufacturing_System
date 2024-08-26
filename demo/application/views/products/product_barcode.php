<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>
    
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Information</h3>
              </div>

              <div class="card-body">
                <div class="col-md-12 col-sm-12 col-12">
                  <?php $id = $product[0]['productID']; ?>
                  <form action="<?php echo base_url().'pBarcode/'.$id; ?>" method="get">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Number of Print *</label>
                        <input type="text" class="form-control" name="nopack" placeholder="Number of Print" required >
                      </div>
                      <div class="form-group col-md-2 col-sm-2 col-xs-12">
                        <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                      </div>
                    </div>
                  </form>
                </div>
                
                <?php if(isset($_GET['search'])) { ?>
                <div class="col-sm-12 col-md-12 col-12" >
                  <div class="row"  >
                    <?php for($i = 0; $i < $nopack; $i++){ ?>
                    <div class="col-sm-3 col-md-3 col-12" style="text-align: center;" >
                      <div class="col-sm-12 col-md-12 col-12">
                        <?php
                        $pcode = $product[0]['productcode'];
    
                        $file = Zend_Barcode::draw('code128', 'image', array('text' => $pcode, 'drawText' => FALSE, 'barHeight'=>30, 'factor'=>2), array());
                        $barcode = $pcode.'.png';
                        imagepng($file,"upload/barcode/{$pcode}.png");
                        ?>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <h4><b><?php echo $product[0]['productName']; ?></b></h4>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <h3><b>TK. <?php echo number_format($product[0]['sprice'], 2); ?></b></h3>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <img src="<?php echo base_url().'upload/barcode/'.$barcode; ?>" alt="barcode" style="width: 70%"  >
                      </div>
                      
                      <div class="col-sm-12 col-md-12 col-12">
                        <h4><b><?php echo $product[0]['productcode']; ?></b></h4>
                      </div>
                      
                    </div>
                    <?php } ?>
                  </div>
                </div>
                
                <div class="row"  >
                  <div id="printArea" >
                    <div id="header" style="display: none;" >
                    <?php for($i = 0; $i < $nopack; $i++){ ?>
                    <div class="text-center" style="text-align: center; margin-top: 50px; margin-left: 200px; transform: rotate(90deg); page-break-after: always;" >
                      <div class="col-sm-12 col-md-12 col-12">
                        <?php
                        $pcode = $product[0]['productcode'];
    
                        $file = Zend_Barcode::draw('code128', 'image', array('text' => $pcode, 'drawText' => FALSE, 'barHeight'=>30, 'factor'=>2), array());
                        $barcode = $pcode.'.png';
                        imagepng($file,"upload/barcode/{$pcode}.png");
                        ?>
                      </div>
                      <div class="text-center" style="margin-top: 400px;" >
                        <div class="col-sm-12 col-md-12 col-12" >
                          <img src="<?php echo base_url().'upload/barcode/'.$barcode; ?>" alt="barcode" style="width: 100%;"  >
                          <h1 style="font-size: 80px;"><b><?php echo $product[0]['productName']; ?></b></h1>
                          <h1 style="font-size: 80px;"><b><?php echo $product[0]['productcode']; ?></b></h1>
                          <h1 style="font-size: 80px;"><b>TK. <?php echo number_format($product[0]['sprice'], 2); ?></b></h1>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                    </div>
                  </div>
                </div>
                  
                <div class="form-group col-sm-12 col-md-12 col-xs-12" style="text-align: center; margin-top: 20px">      
                  <a href="javascript:void(0)" value="Print" onclick="printDiv('printArea')" class="btn btn-primary"><i class="fa fa-print"> </i> Print</a>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      function printDiv(divName){
        $('#header').show();
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        }
    </script>