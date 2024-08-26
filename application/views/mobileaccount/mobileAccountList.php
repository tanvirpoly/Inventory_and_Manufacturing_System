<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mobile Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Mobile Account</li>
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
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Mobile Account</h3>
              <?php if($_SESSION['new_maccount'] == 1){ ?>
              <button type="button" class="btn btn-primary mobilet" data-toggle="modal" data-target=".bs-example-modal-mobile" style="float: right" ><i class="fa fa-plus"></i> New Mobile Transaction</button>
              <?php } ?>
            </div>

            <div class="card-body">
                <table class="table table-responsive table-striped table-bordered">
                    <thead>
                        <tr style="text-transform:uppercase; text-align:center;">
                            <th style="width: 5%;">SN</th>
                            <th style="width: 15%;">ACCOUNT NAME</th>
                            <th style="width: 15%;">ACCOUNT NO</th>
                            <th style="width: 15%;">ACCOUNT OWNER</th>
                            <th style="width: 15%;">OPENING</th>
                            <th style="width: 15%;">CURRENT</th>
                            <th style="width: 11%;">STATUS</th>
                            <th style="width: 1%;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $tba = 0;
                        foreach ($maccount as $key => $value) {
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
                            <td><?php echo $value['accountOwner']; ?></td>
                            <td><?php echo number_format(($value['balance']), 2); ?></td>
                            <td><?php echo number_format(((($value['balance'])+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta)), 2); $tba += ((($value['balance'])+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta)); ?></td>
                            <td><?php echo $value['status']; ?></td>
                            <td>
                              <?php if($_SESSION['edit_maccount'] == 1){ ?>
                              <button type="button" class="btn btn-success btn-xs mobile_edit" data-toggle="modal" data-target=".bs-example-modal-emobt" data-id="<?php echo $value['ma_id']; ?>" ><i class="fa fa-edit"></i></button>
                              <?php } if($_SESSION['delete_maccount'] == 1){ ?>
                              <a href="<?php echo site_url('MobileAccount/mobile_account_delete').'/'.$value['ma_id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this Mobile Account ?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                              <?php } ?>
                            </td>
                        </tr>   
                        <?php } ?> 
                    </tbody>
                    <!--<tfoot>-->
                    <!--    <tr>-->
                    <!--        <th>#SN.</th>-->
                    <!--        <th>Account Name</th>-->
                    <!--        <th>Account No</th>-->
                    <!--        <th>Account Owner</th>-->
                    <!--        <th>Opening</th>-->
                    <!--        <td><?php echo number_format(($tba), 2); ?></td>-->
                    <!--        <th>Status</th>-->
                    <!--        <th>Action</th>-->
                    <!--    </tr>-->
                    <!--</tfoot>-->
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade bs-example-modal-mobile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Mobile Account Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="<?php echo base_url('MobileAccount/save_mobile_account');?>" method="post">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label>Account Name *</label>
                            <input type="text" class="form-control" name="accountName" placeholder="Account Name" required >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label>Account No *</label>
                            <input type="text" class="form-control" name="accountNo" placeholder="Account No" required >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label>Account Owner</label>
                            <input type="text" class="form-control" name="accountOwner" placeholder="Account Owner" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label>Account Balance</label>
                            <input type="text" class="form-control" name="balance" placeholder="Account Balance" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-emobt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Mobile Account Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="<?php echo base_url('MobileAccount/update_mobile_account');?>" method="post">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Account Name *</label>
                            <input type="text" class="form-control" name="accountName" id="accountName" placeholder="Account Name" required >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Account No *</label>
                            <input type="text" class="form-control" name="accountNo" id="accountNo" required >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Account Owner</label>
                            <input type="text" class="form-control" name="accountOwner" id="accountOwner" placeholder="Account Owner" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Account Balance</label>
                            <input type="text" class="form-control" name="balance" id="balance" placeholder="Account Balance" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                            <label>Status</label>
                            <select class="form-control" name="status" id="status" >
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="mobileAccountId" name="mobileAccountId" >
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
</div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".mobile_edit").click(function(){
          var catid = $(this).data('id');
            //alert(l_id);
          $('input[name="mobileAccountId"]').val(catid);
        });

        $('.mobile_edit').click(function() {
          var id = $(this).data('id');
            //alert(id);
          var url = '<?php echo base_url() ?>MobileAccount/get_mobile_account';
            //alert(url);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
                //alert(data);
              var HTML = data["accountNo"];
              var HTML2 = data["accountName"];
              var HTML3 = data["accountOwner"];
              var HTML4 = data["balance"];
              var HTML5 = data["status"];
                //alert(HTML);
              $("#accountNo").val(HTML);
              $("#accountName").val(HTML2);
              $("#accountOwner").val(HTML3);
              $("#balance").val(HTML4);
              $("#status").val(HTML5);
              },
              error:function(){
              alert('error');
              }
            });
        });
      });
    </script>