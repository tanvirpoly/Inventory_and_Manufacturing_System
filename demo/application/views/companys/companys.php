<div class="content-wrapper" style="min-height: 1126px;">    
    <section class="content-header">
        <h1>Company / Warehouse</h1>
    </section>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Company / Warehouse List</h3>
            <button type="button" class="btn btn-primary add_company" data-toggle="modal" data-target=".bs-example-modal-add_company" style="float: right" ><i class="fa fa-plus"></i> Company / Warehouse</button>
        </div>
        <div class="box-body">
            <div id="table-content ">
                <table id="datatable" class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#SN.</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th style="width: 8%;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#SN.</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($companys as $key => $value) {
                        $i++;
                        ?>
                        <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['companyName']; ?></td>
                            <td><?php echo $value['companycode']; ?></td>
                            <td><?php echo $value['companyPhone']; ?></td>
                            <td><?php echo $value['companyEmail']; ?></td>
                            <td><?php echo $value['companyAddress']; ?></td>       
                            <td>
                                <button type="button" class="btn btn-success btn-sm company_edit" data-toggle="modal" data-target=".bs-example-modal-company_edit" data-id="<?php echo $value['companyID']; ?>" onclick="document.getElementById('company_edit').style.display='block'" ><i class="fa fa-edit"></i></button>
                                <a class=" btn btn-danger btn-sm" href="<?php echo site_url('Company/delete_Company').'/'.$value['companyID'] ?>" ><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>   
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <div id="add_company" class="modal fade bs-example-modal-add_company" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Company / Warehouse Information</h4>
          </div>
          <form action="<?php echo base_url('Company/SaveCompany');?>" method="POST">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Company / Warehouse Name *</label>
                <input type="text" class="form-control" name="companyName" required placeholder="Company / Warehouse Name" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Company / Warehouse Code</label>
                <input type="text" class="form-control" name="companycode" placeholder="Company / Warehouse Code" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="companyPhone" required placeholder="Contact Number" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Email</label>
                <input type="email" class="form-control" name="companyEmail" placeholder="example@gmail.com" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Address *</label>
                <input type="text" class="form-control" name="companyAddress" required placeholder="Address" >
            </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="company_edit" class="modal fade bs-example-modal-company_edit" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Update Company Information</h4>
          </div>
          <form action="<?php echo base_url('Company/update_company');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Company / Warehouse Name *</label>
                <input type="text" class="form-control" name="companyName" required id="companyName" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Company / Warehouse Code</label>
                <input type="text" class="form-control" name="companycode" id="companycode" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Contact Number *</label>
                <input type="text" class="form-control" name="companyPhone" required id="companyPhone" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Email</label>
                <input type="email" class="form-control" name="companyEmail" id="companyEmail" >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label>Address *</label>
                <input type="text" class="form-control" name="companyAddress" required id="companyAddress" >
            </div>
            </div>
            <input type="hidden" id="comp_id" name="comp_id" >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".company_edit").click(function () {
          var catid = $(this).data('id');
//alert(l_id);
          $('input[name="comp_id"]').val(catid);
        });

        $('.company_edit').click(function() {
          var id = $(this).data('id');
    //alert(id);
          var url = '<?php echo base_url() ?>Company/get_company_data';
    //alert(url);
            $.ajax({
              method: 'POST',
              url     : url,
              dataType: 'json',
              data    : {'id' : id},
              success:function(data){ 
    //alert(data);
              var HTML = data["companyName"];
              var HTML2 = data["companycode"];
              var HTML3 = data["companyPhone"];
              var HTML4 = data["companyEmail"];
              var HTML5 = data["companyAddress"];
    //alert(HTML);
              $("#companyName").val(HTML);
              $("#companycode").val(HTML2);
              $("#companyPhone").val(HTML3);
              $("#companyEmail").val(HTML4);
              $("#companyAddress").val(HTML5);
              },
              error:function(){
              alert('error');
              }
            });
        });
      });
    </script>