<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Notice</li>
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
                <h3 class="card-title">Notice List</h3>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th>#SN.</th>
                      <th>Date</th>
                      <th>Image</th>
                      <th>User</th>
                      <th>Subject</th>
                      <th>Message</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($notice as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['regdate'])); ?></td>
                      <td>
                        <?php if($value['image']){ ?>
                        <img src="<?php echo base_url('upload/');?><?php echo $value['image']; ?>" style="width: 50px;height: 50px;" alt="notice Image">
                        <?php } ?>
                      </td>
                      <td><?php echo $value['ntype']; ?></td>
                      <td><?php echo $value['subject']; ?></td>
                      <td><?php echo $value['message']; ?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-sm user_edit" data-toggle="modal" data-target=".bs-example-modal-euser" data-id="<?php echo $value['nid']; ?>" onclick="document.getElementById('user_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-4 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Notice Information</h3>
              </div>

              <div class="card-body">
                <form action="<?php echo base_url('Voucher/save_user_notice'); ?>" method="post" enctype="multipart/form-data" >
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label class="">Select User *</label>
                      <select class="form-control" name="user" required >
                        <option value="All">All User</option>
                        <?php foreach($users as $value){?>
                        <option value="<?php echo $value['uid']; ?>"><?php echo $value['name'].' ( '.$value['compname'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Subject *</label>
                      <input type="text" class="form-control" name="subject" placeholder="Subject" required >
                    </div>
                    <div class="form-group">
                      <label>Message *</label>
                      <textarea type="text" class="form-control" rows="5" name="message" placeholder="Message ................" required></textarea>
                    </div>
                    <div class="form-group">
                      <label>Image</label>
                      <input type="file" name="user_photo" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
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

    <div class="modal fade bs-example-modal-euser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > User Notice</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Voucher/update_user_notice');?>" method="post" enctype="multipart/form-data" >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label class="">Select User *</label>
                <select class="form-control" name="user" id="user" required >
                  <option value="All">All User</option>
                  <?php foreach($users as $value){?>
                  <option value="<?php echo $value['uid']; ?>"><?php echo $value['name'].' ( '.$value['compname'].' )'; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Subject *</label>
                <input type="text" class="form-control" name="subject" id="subject" required >
              </div>
              <div class="form-group">
                <label>Message *</label>
                <textarea type="text" class="form-control" rows="5" name="message" id="message" required ></textarea>
              </div>
              <div class="form-group">
                <label>Image</label>
                <input type="file" name="user_photo" >
              </div>
              <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status" id="status" >
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
            <input type="hidden" id="nid" name="nid" >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="pbsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <script type="text/javascript">
      $(document).ready(function(){
        $(".user_edit").click(function(){
          var catid = $(this).data('id');
          //alert(l_id);
          $('input[name="nid"]').val(catid);
          });

        $('.user_edit').click(function() {
          var id = $(this).data('id');
          //alert(id);
          var url = '<?php echo base_url() ?>Voucher/get_user_notice_data';
          //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
          //alert(data);
            var HTML = data["ntype"];
            var HTML2 = data["subject"];
            var HTML3 = data["message"];
            var HTML4 = data["status"];
          //alert(HTML);
            $("#user").val(HTML);
            $("#subject").val(HTML2);
            $("#message").val(HTML3);
            $("#status").val(HTML4);
            },
            error:function(){
            alert('error');
            }
          });
        });
      });
    </script>
