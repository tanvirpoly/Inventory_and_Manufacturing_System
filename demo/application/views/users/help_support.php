<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Help & Support</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Help & Support</li>
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
                <h3 class="card-title">Help & Support Message List</h3>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo base_url('upload/userManual.pdf') ?>" target="_blank" >User Manul Dowanload</a>
                <button type="button" class="btn btn-primary add_user" data-toggle="modal" data-target=".bs-example-modal-auser" style="float: right" ><i class="fa fa-plus"></i> New Message</button>
              </div>

              <div class="card-body">
                <table id="example" class="table table-bordered" >
                  <thead>
                    <tr>
                      <!--<th style="width: 5%;">#SN.</th>-->
                      <th style="width: 10%;">Date</th>
                      <th style="width: 15%;">Ticket No.</th>
                      <th style="width: 20%;">Subject</th>
                      <th style="width: 38%;">Message</th>
                      <th style="width: 17%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($help as $value) {
                    $i++;
                    ?>
                    <tr>
                      <!--<td><?php echo $i; ?></td>-->
                      <td><?php echo date('d-m-Y h:i A', strtotime($value['regdate'])); ?></td>
                      <td><?php echo $value['s_id']; ?></td>
                      <td><?php echo $value['subject']; ?></td>
                      <td><?php echo $value['message']; ?></td>       
                      <td>
                        <button type="button" class="btn btn-success btn-xs user_edit" data-toggle="modal" data-target=".bs-example-modal-euser" data-id="<?php echo $value['hs_id']; ?>" ><i class="fa fa-plus"></i> Reply</button>
                        <button type="button" class="btn btn-info btn-xs msg_view" data-toggle="modal" data-target=".bs-example-modal-msg_view" data-id="<?php echo $value['hs_id']; ?>" ><i class="fa fa-eye"></i> View</button>
                        <a class=" btn btn-danger btn-xs" href="<?php echo site_url('User/delete_help_message').'/'.$value['hs_id']; ?>" onclick="return confirm('Are you sure you want to delete this message ?');" ><i class="fa fa-trash"></i></a>
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

    <div class="modal fade bs-example-modal-auser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title" >Help & Support Message</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('User/save_help_support_msg');?>" method="post">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label>Subject *</label>
                <input type="text" class="form-control" name="subject" placeholder="Subject" required >
              </div>
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label>Message *</label>
                <textarea type="text" class="form-control" name="message" placeholder="Message" required rows="5" ></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-euser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Reply Message</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('User/reply_help_support_msg');?>" method="post">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label>Reply Message *</label>
                <textarea type="text" class="form-control" name="message" placeholder="Message" required rows="5" ></textarea>
              </div>
            </div>
            <input type="hidden" id="hs_id" name="hs_id" >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-msg_view" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Reply Message Info.</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <table>
              <tbody id="reply">
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
          </div>
        </div>
      </div>
    </div>

</div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".user_edit").click(function(){
          var catid = $(this).attr("data-id");
          //alert(catid);
          $('input[name="hs_id"]').val(catid);
          });
        });
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('.msg_view').click(function(){
          var id = $(this).attr("data-id");
          //alert(id);
          var url = '<?php echo base_url() ?>User/get_help_reply_data';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              $('#reply').append(data);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>