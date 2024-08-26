<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PURCHASE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Purchase</li>
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
                <h3 class="card-title">PURCHASE DETAILS</h3>
              </div>
<!--<?php var_dump($purchase);?>-->
              <div class="card-body">
                <div class="invoice p-3 mb-3">
                  <div id="print">
                    <div class="row">
                      <div class="col-sm-3 col-3 invoice-col">
                      </div>
                      <div class="col-sm-6 col-6 invoice-col text-center">
                        <?php if($company){ ?><h3><b><?php echo $company->com_name; ?></b></h3><?php } ?>
                        <?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
                        <?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?>
                      </div>
                      <div class="col-sm-3 col-3 invoice-col">
                        <h3><b>PURCHASE</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Invoice #</td>
                              <td><?php echo $purchase['challanNo']; ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Date #</td>
                              <td><?php echo date('d-m-Y', strtotime($purchase['purchaseDate'])); ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Time #</td>
                              <td><?php echo date('h:ia',strtotime($purchase['regdate'])); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>BILL FROM</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Name #</td>
                              <td><?php if($company){ ?><b><?php echo $company->com_name; ?></b><?php } ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Mobile #</td>
                              <td><?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Address #</td>
                              <td><?php if($company){ ?><?php echo $company->com_address; ?><?php } ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-sm-6 col-6 invoice-col">
                        <h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>BILL TO</b></h3>
                        <table class="table table-striped table-bordered">
                          <tbody>
                            <tr style="line-height: 6px !important;">
                              <td>Supplier #</td>
                              <td><?php echo $purchase['supplierName'].' ( '.$purchase['sup_id'].' )'; ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Mobile #</td>
                              <td><?php echo $purchase['mobile']; ?></td>
                            </tr>
                            <tr style="line-height: 6px !important;">
                              <td>Address #</td>
                              <td><?php echo $purchase['address']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                
                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>ITEM NAME</th>
                              <th>QTY</th>
                              <th>UNIT PRICE</th>
                              <th>AMOUNT</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $tq = 0;
                            $tpa = 0;
                            foreach ($pproduct as $value) {
                            $i++;
                            ?>
                            <tr style="min-height: 200px;">
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['productName']; ?></td>
                              <td><?php echo round($value['quantity']).' '.$value['unitName']; $tq += $value['quantity']; ?></td>
                              <td><?php echo number_format($value['pprice'], 2); ?></td>
                              <td><?php echo number_format($value['totalPrice'], 2); $tpa += $value['totalPrice']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <td colspan="3">
                                <?php echo $purchase['terms']; ?>
                              </td>
                              <td colspan="2">
                                <table class="table table-striped">
                                  <tr>
                                    <tr>
                                      <td align="right">Total</td>
                                      <td><?php echo number_format($tpa, 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="right">Shipping Cost :</td>
                                      <td><?php echo number_format($purchase['sCost'], 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="right">VAT (<?php echo $purchase['vCost']; ?>) : </td>
                                      <td><?php echo number_format($purchase['vAmount'], 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="right">Nat Amount : </td>
                                      <td><?php echo number_format(($tpa+$purchase['sCost']+$purchase['vAmount']), 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="right">Discount (<?php echo $purchase['discount']; ?>) : </td>
                                      <td><?php echo number_format($purchase['disAmount'], 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="right">Total Amount : </td>
                                      <td><?php echo number_format($purchase['totalPrice'], 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td align="right">Paid Amount : </td>
                                      <td><?php echo number_format($purchase['paidAmount'], 2); ?></td>
                                    </tr>
                                    <tr>
                                      <td style="color: red;" align="right">Due Amount  : </td>
                                      <td style="color: red;"><?php echo number_format($purchase['due'], 2); ?></td>
                                    </tr>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            
                            
                            <!--<tr>-->
                            <!--  <td colspan="4" align="right"><b>Previous Due Amount  : </b></td>-->
                            <!--  <td>-->
                            <!--    <?php $pd = (($csdue->total)-($cvpa->total)); ?>-->
                            <!--    <b><?php echo number_format($pd, 2); ?></b>-->
                            <!--  </td>-->
                            <!--</tr>-->
                            <!--<tr>-->
                            <!--  <td colspan="4" align="right"><b>Total Due Amount  : </b></td>-->
                            <!--  <td><b><?php echo number_format(($pd+$purchase['due']), 2); ?></b></td>-->
                            <!--</tr>-->
                          </tbody>
                          <tbody style="text-align: left;">
                            <tr>
                              <?php $twa = round(abs($purchase['paidAmount'])); ?>
                              <td colspan="5"><b>( IN WORDS&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumber($twa); ?> )</b></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <?php if($purchase['note'] != null){ ?>
                    <div class="row">
                      <p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
                      <p class="lead"><?php echo $purchase['note']; ?></p>
                    </div>
                  <?php } ?>
                    <div class="row">
                      <div class="col-md-12 col-12" style="text-align: center;">
                        <div class="row">
                          <div class="col-md-3 col-sm-3 col-3">
                            <p>------------------------------</p>
                            <p>Supplier</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3">
                            <p>------------------------------</p>
                            <p>Prepared By</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3">
                            <p>------------------------------</p>
                            <p>Verified By</p>
                          </div>
                          <div class="col-md-3 col-sm-3 col-3">
                            <p>------------------------------</p>
                            <p>Authorized By</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row no-print" >
                    <div class="col-12" style="text-align: center;">
                      <a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')" ><i class="fas fa-print"></i> Print</a>
                      <a href="<?php echo site_url('Purchase') ?>" class="btn btn-danger" ><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<?php $this->load->view('footer/footer'); ?>

    <?php
      function convertNumber($number){
        $words = array(
          '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty');
    
        $number_length = strlen($number);

        $number_array = array(0,0,0,0,0,0,0,0,0);        
        $received_number_array = array();
    
        for($i=0;$i<$number_length;$i++)
          {    
          $received_number_array[$i] = substr($number,$i,1);    
          }
        
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++)
          { 
          $number_array[$i] = $received_number_array[$j]; 
          }
        $number_to_words_string = "";

        for($i=0,$j=1;$i<9;$i++,$j++)
          {
          if($i==0 || $i==2 || $i==4 || $i==7)
            {
            if($number_array[$j]==0 || $number_array[$i] == "1")
              {
              $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
              $number_array[$i] = 0;
              }
            }
          }
        $value = "";
        for($i=0;$i<9;$i++)
          {
          if($i==0 || $i==2 || $i==4 || $i==7)
            {    
            $value = $number_array[$i]*10; 
            }
          else
            { 
            $value = $number_array[$i];    
            }            
          if($value!=0)
            {
            $number_to_words_string.= $words["$value"]." ";
            }
          if($i==1 && $value!=0)
            {
            $number_to_words_string.= "Crores ";
            }
          if($i==3 && $value!=0)
            {
            $number_to_words_string.= "Lakhs ";
            }
          if($i==5 && $value!=0)
            {
            $number_to_words_string.= "Thousand ";
            }
          if($i==6 && $value!=0)
            {
            $number_to_words_string.= "Hundred ";
            }            
          }
        if($number_length>9)
          {
          $number_to_words_string = "Sorry This does not support more than 99 Crores";
          }
        return ucwords(strtolower($number_to_words_string)." Taka Only.");
        }
    ?>