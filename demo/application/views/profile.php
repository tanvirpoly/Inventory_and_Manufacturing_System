<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">User Profile</li>
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
                <h3 class="card-title">User Profile Information</h3>
              </div>

              <div class="card-body">
                <div class="col-md-12 col-sm-12 col-12">
                  <div class="row">
                    <div class="col-md-4 col-sm-4 col-4" >
                      <img src="<?php echo base_url('upload/users/');?><?php echo $user->photo; ?>" style="width: 90%;height: 250px;margin: 0px 15px;" alt="User Image">
                    </div>
                    <div class="col-md-8 col-sm-8 col-8">
                      <table class="table table-bordered table-striped">
                        <!--<tr>-->
                        <!--  <td>User ID</td>-->
                        <!--  <td><?php echo $user->uid; ?></td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                        <!--  <td>Employee ID</td>-->
                        <!--  <td><?php echo $user->empid; ?></td>-->
                        <!--</tr>-->
                        <tr>
                          <td>Company ID</td>
                          <td><?php echo $user->compid; ?></td>
                        </tr>
                        <tr>
                          <td>Name</td>
                          <td><?php echo $user->name; ?></td>
                        </tr>
                        <tr>
                          <td>E-mail</td>
                          <td><?php echo $user->email; ?></td>
                        </tr>
                        <tr>
                          <td>Mobile</td>
                          <td><?php echo $user->mobile; ?></td>
                        </tr>
                        <tr>
                          <td>Company Name</td>
                          <td><?php echo $user->compname; ?></td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td><?php echo $user->status; ?></td>
                        </tr>
                         <tr>
                          <td>Registration</td>
                          <td><?php echo date('d-m-Y h:i A', strtotime($user->regdate)); ?></td>
                        </tr>
                         <tr>
                          <td>Profile Update</td>
                          <td><?php echo date('d-m-Y h:i A', strtotime($user->update)); ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
            
                  <div class="col-md-12 col-sm-12 col-12" style="height: 250px;">
                    <div class="profile-update">
                      <h4>Do you update your profile picture?</h4><hr/>
                      <div class="small-12 medium-2 large-2 columns">
                        <div class="circle">
                          <img class="profile-pic" src="<?php echo base_url('upload/users');?>/<?php echo $user->photo; ?>">
                        </div>
                        <form method="post" action="<?php echo site_url('Home/profile_update') ?>" enctype="multipart/form-data">
                          <div class="p-image">
                            <i class="fa fa-camera upload-button"></i>
                            <input class="file-upload" type="file" name="user_photo" style="display: none;" accept="image/*" required >
                            <input type="hidden" name="uid" value="<?php echo $user->uid; ?>">
                          </div>
                        </div>
                      </div>
                    </div>
            
                    <button class="btn btn-primary" type="submit" style="margin-left: 300px;">Update</button>
                  </form>
                </div>
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
        var readURL = function(input){
          if(input.files && input.files[0])
            {
            var reader = new FileReader();

            reader.onload = function(e){
              $('.profile-pic').attr('src', e.target.result);
              }
            reader.readAsDataURL(input.files[0]);
            }
          }
    
      $(".file-upload").on('change', function(){
        readURL(this);
        });
    
      $(".upload-button").on('click', function() {
        $(".file-upload").click();
        });
      });
    </script>

<style type="text/css">
  
  .profile-pic
    {
    max-width: 200px;
    max-height: 200px;
    display: block;
    }

  .file-upload
    {
    display: none;
    }

  .circle
    {
    border-radius: 1000px !important;
    overflow: hidden;
    width: 128px;
    height: 128px;
    border: 5px solid rgba(195, 189, 189, 0.7);
    position: absolute;
    top: 72px;
    margin: 15px 250px;
    }

  img
    {
    max-width: 100%;
    height: auto;
    }

  .p-image
    {
    position: absolute;
    top: 161px;
    right: 494px;
    color: #666666;
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }

  .p-image:hover
    {
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }

  .upload-button
    {
    font-size: 1.2em;
    }

  .upload-button:hover
    {
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    color: #999;
    }
</style>

<style type="text/css">
  #animate
    {
    background: #dce8f5 !important;
    padding: 10px;
    margin-bottom: 10px;
    }

  .single_div
    {
    width: 100% !important;
    height: 100px !important;
    background: #fff !important;
    }

  .left
    {
    float: left;
    position: absolute;
    clear: both;
    padding: 10px 20px;
    }

  .right1
    {
    width: 30px !important;
    height: 30px !important;
    float: right;
    background: #1382d6 !important;
    position: relative;
    }

  .right2
    {
    width: 30px !important;
    height: 30px !important;
    float: right;
    background: #c60afa;
    position: relative;
    }

  .right3
    {
    width: 30px !important;
    height: 30px !important;
    float: right;
    background: red;
    position: relative;
    }

  .vat
    {
  	float: right;
    line-height: 0.7;
    position: relative;
    margin-top: 52px;
    color: gray;
    margin-right: -20px;
    text-align: right;
    }

  .vat p
    {
  	font-size: 12px;
    }

  .percent
    {
  	background: #3cb73c;
    color: #fff;
    border-radius: 10px;
    padding: 2px 8px;
    font-size: 13px;
    }
</style>