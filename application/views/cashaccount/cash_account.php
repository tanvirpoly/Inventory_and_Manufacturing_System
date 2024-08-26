<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cash Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Cash Account</li>
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
          <div class="col-md-8 col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cash Account List</h3>
              </div>

              <div class="card-body">
                <table class="table table-responsive table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">SN</th>
                      <th>Account NAME</th>
                      <th>Balance</th>
                      <th>Current</th>
                      <th style="width: 13%;">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($cash as $key => $value) { 
                    $i++;
                    
                    $id = $value['ca_id'];
                                        //var_dump($id);
                    
                    $sa = $this->db->select('SUM(paidAmount) as total')
                                ->from('sales')
                                ->where('accountType','Cash')
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
                                ->where('accountType','Cash')
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
                                ->where('accountType','Cash')
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
                                ->where('accountType','Cash')
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
                                ->where('accountType','Cash')
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
                                ->where('accountType','Cash')
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
                                ->where('facType','Cash')
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
                                ->where('sacType','Cash')
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
                    // var_dump($saa+$ttbta+$tpra);
                    ?>
                    <tr class="gradeX">      
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['cashName']; ?></td>
                      <td><?php echo number_format($value['balance'], 2); ?></td>
                      <td><?php echo number_format((($value['balance']+$saa+$tva+$ttbta)-($paa+$tempa+$tra+$tfbta)), 2); ?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs category_edit" data-toggle="modal" data-target=".bs-example-modal-category_edit" data-id="<?php echo $value['ca_id']; ?>" ><i class="fa fa-edit"></i></button>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('CashAccount/delete_cash_account').'/'.$value['ca_id']; ?>" onclick="return confirm('Are you sure you want to Delete this Account ?');" ><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="modal fade bs-example-modal-category_edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Category Information</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="<?php echo base_url('CashAccount/update_cash_account');?>" method="post">
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Account Name *</label>
                    <input type="text" class="form-control" name="cashName" id="cashName" placeholder="Account Name" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Balance</label>
                    <input type="text" class="form-control" name="balance" id="balance" placeholder="Amount"  >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" >
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <input type="hidden" id="ca_id" name="ca_id" required >
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cash Account Information</h3>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>CashAccount/save_cash_account" >
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Account Name *</label>
                    <input type="text" class="form-control" name="cashName" placeholder="Account Name" required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label> Balance</label>
                    <input type="text" class="form-control" name="balance" placeholder="Amount"  >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" >
                    <button type="submit" class="form-control btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    
    <script type="text/javascript">
      $(document).ready(function(){
        $(".category_edit").click(function(){
          var ca_id = $(this).data('id');
            //alert(l_id);
          $('input[name="ca_id"]').val(ca_id);
          });

        $('.category_edit').click(function(){
          var id = $(this).data('id');
          var url = '<?php echo base_url() ?>CashAccount/get_cash_account_data';
            //alert(url);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
              //alert(data);
              var HTML = data["cashName"];
              var HTML3 = data["balance"];
              //alert(HTML);
              $("#cashName").val(HTML);
              $("#balance").val(HTML3);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>