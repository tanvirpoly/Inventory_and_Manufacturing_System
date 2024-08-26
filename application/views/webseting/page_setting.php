<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>About Page Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">About Page Setting</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">About Page Setting Information</h3>
                <!--<button type="button" class="btn btn-primary add_supplier" data-toggle="modal" data-target=".bs-example-modal-add_supplier" style="float: right;" ><i class="fa fa-plus"></i> New Page Setting</button>-->
              </div>

              <div class="card-body">
                <form autocomplete="off" action="<?php echo base_url('Webseting/save_page_setting');?>" method="post">
                <div class="col-md-12 col-sm-12 col-12">
                  <div class="form-group">
                    <label>Page Title *</label>
                    <input type="text" class="form-control" name="pName" placeholder="Page Title" value="<?php if($pageSetup){ ?><?php echo $pageSetup[0]['pName']; ?><?php } ?>" required >
                  </div>
                  <div class="form-group">
                    <label>Page Content *</label>
                    <textarea class="form-control" name="pContent" placeholder="Page Content" rows="6" required ><?php if($pageSetup){ ?><?php echo $pageSetup[0]['pContent']; ?><?php } ?></textarea>
                  </div>
                </div>
                <div class="form-group" style="text-align: center;">
                  <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php $this->load->view('footer/footer'); ?>

    
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click','.category_edit',function(){
          var catid = $(this).attr("id");
            //alert(l_id);
          $('input[name="psid"]').val(catid);
          });

        $(document).on('click','.category_edit',function(){
          var id = $(this).attr("id");
          var url = '<?php echo base_url() ?>Webseting/get_page_setting_data';
            //alert(url);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
              //alert(data);
              var HTML = data["pName"];
              var HTML2 = data["pContent"];
              var HTML3 = data["status"];
              //alert(HTML);
              $("#pName").val(HTML);
              $("#pContent").val(HTML2);
              $("#status").val(HTML3);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>