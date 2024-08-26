<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mobile Book</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Mobile Book</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Mobile Book</h3>
            </div>

            <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                    <div id="print">
                        <?php if($company){ ?>
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-4" style="margin-top: 25px;" >
                                <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>" style="height:90px; width:auto;">
                            </div>
                            <div class="col-sm-8 col-md-8 col-8">
                                <div class="col-sm-12 col-md-12 col-12">
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
                        <div class="col-md-12 col-sm-12 col-12">
                            <div style="text-align: center;"><h3><b>Mobile Book</b></h3></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">
                            <div>
                                <b>Date : <?php echo date("d-m-Y"). "<br>"; ?></b>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#SN.</th>
                                        <th>Account Name</th>
                                        <th>Account No.</th>
                                        <th style="width: 10%;">OPENING</th>
                                        <th style="width: 10%;">CURRENT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $tba = 0;
                                    foreach ($mobile as $value) {
                                    $id = $value['ma_id'];
            
                                    $sa = $this->db->select('SUM(paidAmount) as total')
                                                ->from('sales')
                                                ->where('accountType','Mobile')
                                                ->where('accountNo',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($sa); exit();
                                    if($sa)
                                      {
                                      $saa = $sa->total;
                                      }
                                    else
                                      {
                                      $saa = 0;
                                      }
            
                                    $pa = $this->db->select("SUM(paidAmount) as total")
                                                ->from('purchase')
                                                ->where('accountType','Mobile')
                                                ->where('accountNo',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); exit();
                                    if($pa)
                                      {
                                      $paa = $pa->total;
                                      }
                                    else
                                      {
                                      $paa = 0;
                                      }
            
                                    $va = $this->db->select("SUM(totalamount) as total")
                                                ->from('vaucher')
                                                ->where('accountType','Mobile')
                                                ->where('vauchertype','Credit Voucher')
                                                ->where('accountNo',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); //exit();
                                    if($va)
                                      {
                                      $vaa = $va->total;
                                      }
                                    else
                                      {
                                      $vaa = 0;
                                      }
            
                                    $va2 = $this->db->select("SUM(totalamount) as total")
                                                ->from('vaucher')
                                                ->where('accountType','Mobile')
                                                ->where_not_in('vauchertype','Credit Voucher')
                                                ->where('accountNo',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); //exit();
                                    if($va2)
                                      {
                                      $vaa2 = $va2->total;
                                      }
                                    else
                                      {
                                      $vaa2 = 0;
                                      }
                                    $tva = $vaa-$vaa2;
            
                                    $temp = $this->db->select("SUM(salary) as total")
                                                ->from('employee_payment')
                                                ->where('accountType','Mobile')
                                                ->where('accountNo',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); //exit();
                                    if($temp)
                                      {
                                      $tempa = $temp->total;
                                      }
                                    else
                                      {
                                      $tempa = 0;
                                      }
            
                                    $tr = $this->db->select("SUM(totalPrice) as total,SUM(scAmount) as sctotal")
                                                ->from('returns')
                                                ->where('accountType','Mobile')
                                                ->where('accountNo',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); //exit();
                                    if($tr)
                                      {
                                      $tra = $tr->total-$tr->sctotal;
                                      }
                                    else
                                      {
                                      $tra = 0;
                                      }
                                    
                                    $tfbt = $this->db->select("SUM(amount) as total")
                                                ->from('transfer_account')
                                                ->where('facType','Mobile')
                                                ->where('facAcno',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); //exit();
                                    if($tfbt)
                                      {
                                      $tfbta = $tfbt->total;
                                      }
                                    else
                                      {
                                      $tfbta = 0;
                                      }
                                    
                                    $ttbt = $this->db->select("SUM(amount) as total")
                                                ->from('transfer_account')
                                                ->where('sacType','Mobile')
                                                ->where('sacAcno',$id)
                                                ->get()
                                                ->row();
                                    //var_dump($pa); //exit();
                                    if($ttbt)
                                      {
                                      $ttbta = $ttbt->total;
                                      }
                                    else
                                      {
                                      $ttbta = 0;
                                      }
                        
                                    $i++;
                                    ?>
                                    <tr class="gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['accountName']; ?></td>
                                        <td><?php echo $value['accountNo']; ?></td>
                                        <td><?php echo number_format(($value['balance']), 2); ?></td>
                                        <td><?php echo number_format(((($value['balance'])+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta)), 2); $tba += ((($value['balance'])+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta)); ?></td>
                                    </tr>   
                                    <?php } ?> 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align: right;">Grand Total</th>
                                        <td><?php echo number_format(($tba), 2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px">
                        <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</section>
</div>

<?php $this->load->view('footer/footer'); ?>