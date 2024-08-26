<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar22'); ?>

  <div class="basic-form-area mg-b-15" style="min-height: 550px;">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">

              <div class="card-body">
                <div class="row">
                  <!--<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;" >-->
                  <!--  <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="width: 100%">-->
                  <!--</div>-->
                  <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;" >
                    <h3><b><?php echo $company->com_name; ?></b></h3>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;" >
                    <b><?php echo $company->com_address; ?></b>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;" >
                    <b>Mobile: <?php echo $company->com_mobile; ?></b>
                  </div>
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <h3 style="text-align: center; border: 2px solid; padding: 10px;">INVOICE</h3>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      Inv. No&nbsp;:&nbsp;<?php echo $sales->invoice_no; ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      Date&nbsp;:&nbsp;<?php echo date('d-m-Y', strtotime($sales->saleDate )); ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      Customer&nbsp;:&nbsp;<?php echo $sales->customerName; ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      Mobile&nbsp;:&nbsp;<?php echo $sales->mobile; ?>
                    </div>
                  </div>
                  
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;" >
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>SN</th>
                          <th>ITEM</th>
                          <th>QTY</th>
                          <th>AMOUNT</th>
                        </tr>
                      </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          $st = 0;
                          foreach ($salesp as $value){
                          $i++;
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value->productName; ?></td>
                            <td><?php echo $value->quantity; ?></td>
                            <td><?php echo number_format($value->totalPrice, 2); $st += $value->totalPrice; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <tbody>
                          <tr>
                            <th colspan="3" style="text-align: right;">Total :</th>
                            <td><?php echo number_format($st, 2); ?></td>
                          </tr>
                          <tr>
                            <th colspan="3" style="text-align: right;">Shipping Cost (+) :</th>
                            <td><?php echo number_format($sales->sCost, 2); ?></td>
                          </tr>
                          <tr>
                            <th colspan="3" style="text-align: right;">VAT Amount (+) <?php if($sales->vType == '%') { ?>(<?php echo $sales->vCost; ?>)<?php } ?> :</th>
                            <td><?php echo number_format($sales->vAmount, 2); ?></td>
                          </tr>
                          <tr>
                            <th colspan="3" style="text-align: right;">Discount (-) <?php if($sales->discountType == '%') { ?>(<?php echo $sales->discount; ?>)<?php } ?> :</th>
                            <td><?php echo number_format($sales->discountAmount, 2); ?></td>
                          </tr>
                          <tr>
                            <th colspan="3" style="text-align: right; font-weight: bold;">Net Amount :</th>
                            <td><?php echo number_format((($st+$sales->sCost+$sales->vAmount)-$sales->discountAmount), 2); ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php $this->load->view('footer/footer22'); ?>



    <script type="text/javascript">
        $(window).on('load', function() {
          window.print();
          setTimeout("closePrintView()", 3000);
          });
        
        function closePrintView() {
        document.location.href = 'https://sunshine.com.bd/app/posSales';
        }

    </script>