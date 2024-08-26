<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Staff / Employee Payments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Staff / Employee Payments</li>
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
                <h3 class="card-title">Staff / Employee Payment Information</h3>
              </div>

              <div class="card-body">
                <div id="print">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <h3 style="text-align: center;"><b>Employee Payments</b></h3>
                  </div>
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <div class="col-md-6 col-sm-6 col-xs-6" ><b>Payment Receipt No.&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $empp['empPid']; ?></b></div>
                    <div class="col-md-4 col-sm-4 col-xs-4"><b>Date&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($empp['regdate'])); ?></b></div>
                  </div><br>

                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <div class="col-md-2 col-sm-2 col-xs-4">Employee Name</div>
                    <div class="col-md-8 col-sm-8 col-xs-6">:&nbsp;&nbsp;<?php echo $empp['employeeName']; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <div class="col-md-2 col-sm-2 col-xs-4">Employee Address</div>
                    <div class="col-md-8 col-sm-8 col-xs-6">:&nbsp;&nbsp;<?php echo $empp['empaddress']; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <div class="col-md-2 col-sm-2 col-xs-4">Mobile Number</div>
                    <div class="col-md-8 col-sm-8 col-xs-6">:&nbsp;&nbsp;<?php echo $empp['phone']?></div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <div class="col-md-2 col-sm-2 col-xs-4">Email</div>
                    <div class="col-md-8 col-sm-8 col-xs-6">:&nbsp;&nbsp;<?php echo $empp['email']?></div>
                  </div><br>

                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <div class="col-md-2 col-sm-2 col-xs-4"><b>Salary Amount</b></div>
                    <div class="col-md-8 col-sm-8 col-xs-6"><b>:&nbsp;&nbsp;<?php echo number_format($empp['salary'], 2); ?></b></div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2"></div>
                    <?php $twa = abs($empp['salary']); ?>
                    <div class="col-md-10 col-sm-10 col-xs-10"><b>In Words&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumberToWordsForIndia($twa); ?></b></div>
                  </div><br>
                  
                  <div class="row" style="margin-top: 20px;">
                    <div class="col-md-3 col-sm-3 col-xs-3" align="center">
                      <p>------------------------------</p>
                      <p>Customer</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3" align="center">
                      <p>------------------------------</p>
                      <p>Prepared By</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3" align="center">
                      <p>------------------------------</p>
                      <p>Verified By</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3" align="center">
                      <p>------------------------------</p>
                      <p>Authorized By</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12" style="text-align: center; margin-top: 20px;">
                  <a href="javascript:void(0)" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                  <a href="<?php echo site_url('empPayment') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
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
      function convertNumberToWordsForIndia($number){
        $words = array(
          '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty');
    
        $number_length = strlen($number);
        $number_array = array(0,0,0,0,0,0,0,0,0);        
        $received_number_array = array();
    
        for($i=0;$i<$number_length;$i++){    
          $received_number_array[$i] = substr($number,$i,1);    
          }

        for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
          $number_array[$i] = $received_number_array[$j]; 
          }
        $number_to_words_string = "";

        for($i=0,$j=1;$i<9;$i++,$j++){
          if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$j]==0 || $number_array[$i] == "1"){
              $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
              $number_array[$i] = 0;
              }
            }
          }
        $value = "";
        for($i=0;$i<9;$i++){
          if($i==0 || $i==2 || $i==4 || $i==7){    
            $value = $number_array[$i]*10; 
            }
          else{ 
            $value = $number_array[$i];    
            }            
          if($value!=0){$number_to_words_string.= $words["$value"]." ";}
          if($i==1 && $value!=0){$number_to_words_string.= "Crores ";}
          if($i==3 && $value!=0){$number_to_words_string.= "Lakhs ";}
          if($i==5 && $value!=0){$number_to_words_string.= "Thousand ";}
          if($i==6 && $value!=0){$number_to_words_string.= "Hundred ";}
          }
        if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
        return ucwords(strtolower($number_to_words_string)." Taka Only.");
        }
    ?>
            