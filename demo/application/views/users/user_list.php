<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">User</li>
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
                <h3 class="card-title">User List</h3>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Password</th>
                      <th>Join</th>
                      <th>Expire</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($users as $value) {
                    $i++;
                    $package = $this->db->select('*')
                                      ->from('user_payments')
                                      ->where('uid',$value['uid'])
                                      ->where('pstatus',1)
                                      ->order_by('up_id','desc')
                                      ->get()
                                      ->row();

                    $now = date('Y-m-d h:i:s', strtotime($value['regdate']));
                    $cdate = date('Y-m-d h:i:s');
                    //$ddate = $cdate->diff($now);
                    $diff = abs(strtotime($now) - strtotime($cdate));

                    $years   = floor($diff / (365*60*60*24));  
                    $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                    $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));  
                    $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                    
                    $expdate = date('Y-m-d h:i:s',strtotime($now. ' +30 days'));
                    
                    //$ddate = $cdate->diff($now);
                    $expdiff = abs(strtotime($expdate) - strtotime($cdate));

                    $expyears   = floor($expdiff / (365*60*60*24));  
                    $expmonths  = floor(($expdiff - $expyears * 365*60*60*24) / (30*60*60*24));  
                    $expdays    = floor(($expdiff - $expyears * 365*60*60*24 - $expmonths*30*60*60*24)/ (60*60*24));
                    $exphours = floor(($expdiff - $expyears * 365*60*60*24 - $expmonths*30*60*60*24 - $expdays*60*60*24)/ (60*60));  
                    $expminuts  = floor(($expdiff - $expyears * 365*60*60*24 - $expmonths*30*60*60*24 - $expdays*60*60*24 - $exphours*60*60)/ 60);
                    ?>
                    <tr class="gradeX" style="
                    <?php if($value['status'] == 'Inactive'){ ?>
                        background-color: #ffa59e; color: #fff;
                    <?php } ?>
                    ">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['compid']; ?></td>
                      <td><?php echo $value['name']; ?></td>
                      <td><?php echo $value['mobile']; ?></td>
                      <td><?php echo $value['password']; ?></td>
                      <td>
                        <?php if($years){ ?>
                        <?php echo($years.' years'); ?>
                        <?php } if($months){ ?>
                        <?php echo($months.' months'); ?>
                        <?php } if($days){ ?>
                        <?php echo($days.' days'); ?>
                        <?php } if($hours){ ?>
                        <?php echo($hours.' hours'); ?>
                        <?php } if($minuts){ ?>
                        <?php echo($minuts.' minuts'.' ago'); ?>
                        <?php } ?>
                      </td> 
                      <td>
                        <?php if($package){ ?>
                        <?php
                        
                        $now2 = date('Y-m-d h:i:s', strtotime($package->pdate));

                        $diff2 = abs(strtotime($now2) - strtotime($cdate));
                        
                        $year2s   = floor($diff2 / (365*60*60*24));  
                        $month2s  = floor(($diff2 - $year2s * 365*60*60*24) / (30*60*60*24));  
                        $day2s    = floor(($diff2 - $year2s * 365*60*60*24 - $month2s*30*60*60*24)/ (60*60*24));
                        $hour2s = floor(($diff2 - $year2s * 365*60*60*24 - $month2s*30*60*60*24 - $day2s*60*60*24)/ (60*60));  
                        $minut2s  = floor(($diff2 - $year2s * 365*60*60*24 - $month2s*30*60*60*24 - $day2s*60*60*24 - $hour2s*60*60)/ 60);
                        ?>
                        <?php if($year2s){ ?>
                        <?php echo($year2s.' years'); ?>
                        <?php } if($month2s){ ?>
                        <?php echo($month2s.' months'); ?>
                        <?php } if($day2s){ ?>
                        <?php echo($day2s.' days'); ?>
                        <?php } if($hour2s){ ?>
                        <?php echo($hour2s.' hours'); ?>
                        <?php } if($minut2s){ ?>
                        <?php echo($minut2s.' minuts'); ?>
                        <?php } ?>
                        
                        <?php if($now2 > $cdate){ ?>
                        <?php echo' left'; ?>
                        <?php } else{ ?>
                        <?php echo' ago finished'; ?>
                        <?php } ?>
                        
                        <?php }else{ ?>
                        <?php if($expyears){ ?>
                        <?php echo($expyears.' years'); ?>
                        <?php } if($expmonths){ ?>
                        <?php echo($expmonths.' months'); ?>
                        <?php } if($expdays){ ?>
                        <?php echo($expdays.' days'); ?>
                        <?php } if($exphours){ ?>
                        <?php echo($exphours.' hours'); ?>
                        <?php } if($expminuts){ ?>
                        <?php echo($expminuts.' minuts'); ?>
                        <?php } ?>
                        <?php if($expdate > $cdate){ ?>
                        <?php echo' left'; ?>
                        <?php } else{ ?>
                        <?php echo' ago finished'; ?>
                        <?php } ?>
                        <?php } ?>
                      </td>         
                      <td>
                        <button type="button" class="btn btn-success btn-sm user_edit" data-toggle="modal" data-target=".bs-example-modal-euser" data-id="<?php echo $value['uid']; ?>" onclick="document.getElementById('user_edit').style.display='block'" ><i class="fa fa-plus"></i></button>
                        <?php if($value['status'] == 'Active'){ ?>
                          <a href="<?php echo site_url('User/inactive_users').'/'.$value['compid'] ?>" type="button" class="btn btn-warning btn-sm" ><i class="fa fa-times" ></i></a>
                        <?php }else{ ?>
                          <a href="<?php echo site_url('User/active_users').'/'.$value['compid'] ?>" type="button" class="btn btn-primary btn-sm" ><i class="fa fa-check" ></i></a>
                        <?php } ?>
                        <a href="<?php echo site_url('User/delete_all_user_info').'/'.$value['compid'] ?>" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this User ?');" ><i class="fa fa-trash" ></i></a>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <div class="modal fade bs-example-modal-euser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > User Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('User/save_user_payment');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label class="">Select Package *</label>
                <select class="form-control" name="utype" required >
                  <option value="">Select One</option>
                  <option value="Basic">Basic</option>
                  <option value="Standard">Standard</option>
                  <option value="Premium">Premium</option>
                </select>
              </div>
              <div class="form-group">
                <label class="">Select Package Time*</label>
                <select class="form-control" name="ptime" required >
                  <option value="">Select One</option>
                  <option value="1">One Month</option>
                  <option value="2">Three Months</option>
                  <option value="3">Six Months</option>
                  <option value="4">One Year</option>
                </select>
              </div>
              <div class="form-group">
                <label>Amount *</label>
                <input type="text" class="form-control" name="amount" placeholder="Amount" required >
              </div>
            </div>
            <input type="hidden" id="user_id" name="user_id" >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>
    

    <script type="text/javascript">
      $(document).ready(function(){
        $(".user_edit").click(function(){
          var catid = $(this).attr("data-id");
          //alert(l_id);
          $('input[name="user_id"]').val(catid);
          });
        });
    </script>