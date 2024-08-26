<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Voucher</li>
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
                <h3 class="card-title">Voucher Information</h3>
              </div>

              <div class="card-body">
                <div id="print">
                    <div class="col-sm-12 col-md-12 col-12">
                        <?php if($company){ ?>
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-4" style="margin-top: 25px;" >
                                <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="height:90px; width:auto;">
                            </div>
                            <div class="col-sm-8 col-md-8 col-8">
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <h3><b><?php echo $company->com_name; ?></b></h3>
                                </div>
                                <div class="col-sm-12 col-md-12 col-12">
                                    Address&nbsp;:&nbsp;<?php echo $company->com_address; ?>
                                </div>
                                <div class="col-sm-12 col-md-12 col-12">
                                    Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $company->com_email; ?>
                                </div>
                                <div class="col-sm-12 col-md-12 col-12">
                                    Mobile&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $company->com_mobile; ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="row">
                            <?php if($voucher['vauchertype'] == "Credit Voucher"){ ?>
                            <div class="col-md-7 col-sm-7 col-7">
                                <div class="col-md-12 col-sm-12 col-12">
                                    Customer ID&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['cus_id']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Customer Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['customerName']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Contact No&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['cm']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['cad']; ?>
                                </div>
                            </div>
                            <?php } else if($voucher['vauchertype'] == 'Debit Voucher'){ ?>
                            <div class="col-md-7 col-sm-7 col-7">
                                <div class="col-md-12 col-sm-12 col-12">
                                    Employee ID&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['empid']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Employee Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['name']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Contact No&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['um']; ?>
                                </div>
                            </div>
                            <?php } else if($voucher['vauchertype'] == 'Supplier Pay'){ ?>
                            <div class="col-md-7 col-sm-7 col-7">
                                <div class="col-md-12 col-sm-12 col-12">
                                    Supplier ID&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['sup_id']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Supplier Name&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['supplierName']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Contact No&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['sm']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['sad']; ?>
                                </div>
                            </div>
                            <?php } else { ?>
                            <?php } ?>
                            <div class="col-md-5 col-sm-5 col-5">
                                <div class="col-md-12 col-sm-12 col-12">
                                    Voucher No.&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['invoice']; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Date&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($voucher['voucherdate'])); ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Payment Mode&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['accountType']; ?>
                                </div>
                                <?php if($voucher['vauchertype'] == 'Debit Voucher'){ ?>
                                <div class="col-md-12 col-sm-12 col-12">
                                    Expenses Type&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['costName']; ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div style="text-align: center;"><h3><b><?php echo $voucher['vauchertype']; ?></b></h3></div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12" >
                            <table class="table table-bordered table-striped">
                                <thead style="background-color: #fff; color: #000;">
                                    <tr>
                                        <th style="width: 5%;">#SN.</th>
                                        <th>Details</th>
                                        <th style="width: 20%;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($voucherp as $value) {
                                    $i++;
                                    ?>
                                    <tr style="background-color: #fff; color: #000;" >
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['particulars']; ?></td>
                                        <td><?php echo number_format($value['amount'], 2); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tbody>
                                    <tr style="background-color: #fff; color: #000;">
                                        <td colspan="2" align="right" >Total Price</td>
                                        <td><?php echo number_format($voucher['totalamount'], 2); ?></td>
                                    </tr>
                                </tbody>
                                <tbody style="">
                                    <tr style="text-align: center; background-color: #fff; color: #000;">
                                        <?php $twa = abs($voucher['totalamount']); ?>
                                        <td colspan="3">( In Words&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumber($twa); ?> )</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div><br>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php if($voucher['reference'] != NULL){ ?>
                              <strong>Notes</strong>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $voucher['reference']; ?>
                              <?php } ?>
                            </div>
                        </div><br>

                        <div class="col-md-12 col-sm-12 col-12" style="text-align: center;">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-4">
                                    <p>------------------------------</p>
                                    <p>Approved By</p>
                                </div>
                                <div class="col-md-4 col-sm-4 col-4">
                                    <p>------------------------------</p>
                                    <p>Paid By</p>
                                </div>
                                <div class="col-md-4 col-sm-4 col-4">
                                    <p>------------------------------</p>
                                    <p>Received By</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px">
                    <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    <a href="<?php echo site_url('Voucher') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left"></i> Back</a>
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