<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Product</li>
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
                <h3 class="card-title">Add Product</h3>
              </div>
              

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Product/save_product" enctype="multipart/form-data">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="form-group col-md-3 col-sm-3 col-12"></div>
                        <div class="form-group col-md-6 col-sm-6 col-6">

                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Product Name *</label>
                        <input type="text" class="form-control" name="productName" placeholder="Product Name" required>
                      </div>
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Product Type *</label>
                        <select class="form-control" name="pType" required >
                          <option value="">Select One</option>
                          <option value="1">Raw Material</option>
                          <option value="2">Finish Good</option>
                        </select>
                      </div>
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Select Category</label>
                        <select class="form-control" name="categoryID" id="categoryID">
                          <option value="">Select One</option>
                          <?php foreach($category as $value){ ?>
                          <option value="<?php echo $value['categoryID']; ?>"><?php echo $value['categoryName']; ?></option>
                          <?php } ?>
                          <option value="newCategory">New Category</option>
                        </select>
                      </div>
                      
                      <div class="d-none" id="newCategory">
                        <div class="form-group col-md-12 col-sm-12 col-12">
                          <label>New Category *</label>
                          <input type="text" class="form-control" name="newCategory" placeholder="New Category" id="newcat" required="">
                        </div>
                      </div>
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Select Units</label>
                        <select name="units" id="unit" class="form-control">
                          <option value="">Select One</option>
                          <?php  foreach($unit as $value) { ?>
                          <option value="<?php echo $value->id; ?>"><?php echo $value->unitName; ?></option>
                          <?php } ?>
                          <option value="newUnit">New Unit</option>
                        </select>
                      </div>
                      
                      <div class="d-none" id="newUnit">
                        <div class="form-group col-md-12 col-sm-12 col-12">
                          <label>New Unit *</label>
                          <input type="text" class="form-control" name="newUnit" placeholder="New Unit" id="newut" required="">
                        </div>
                      </div>
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Select Department</label>
                        <select name="mdid" id="mdid" class="form-control select2">
                          <option value="">Select One</option>
                          <?php  foreach($mdept as $value) { ?>
                          <option value="<?php echo $value['md_id']; ?>"><?php echo $value['mdName']; ?></option>
                          <?php } ?>
                          <!--<option value="newMD">New Department</option>-->
                        </select>
                      </div>
                      
                      <!--<div class="d-none" id="newDept">-->
                      <!--  <div class="form-group col-md-12 col-sm-12 col-12">-->
                      <!--    <label>New Department *</label>-->
                      <!--    <input type="text" class="form-control" name="newDept" placeholder="New Department" id="newmd" required="">-->
                      <!--  </div>-->
                      <!--</div>-->
                      <!--<div class="form-group col-md-12 col-sm-12 col-12">-->
                      <!--  <label>Department</label>-->
                      <!--  <input type="text" class="form-control" name="dept" placeholder="Department">-->
                      <!--</div>-->
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Purchase/Production Price</label>
                        <input type="text" class="form-control" name="pprice" placeholder="Purchase price" value=0 >
                      </div>
                      
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Wholesale Price</label>
                        <input type="number" class="form-control" name="sprice" placeholder="Wholesale Price" value=0 >
                      </div>
                      
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Retail Price</label>
                        <input type="number" class="form-control" name="rprice" placeholder="Retail Price" value=0 >
                      </div>
                      
                      <!--<div class="form-group col-md-12 col-sm-12 col-12">-->
                      <!--  <label>Show Online Store *</label>-->
                      <!--  <div>-->
                      <!--    <input type="radio" name="spstatus" value="1" required >&nbsp;&nbsp;Yes&nbsp;&nbsp;-->
                      <!--    <input type="radio" name="spstatus" value="2" required checked >&nbsp;&nbsp;No-->
                      <!--  </div>-->
                      <!--</div>-->
                      
                      <div class="form-group col-md-12 col-sm-12 col-12">
                        <label>Product Image <span style="color:gray;">(Optional) </span><br>(220X220 or 350X350 Px Size)</label>
                        <input type="file" name="userfile">
                      </div>
                    </div>
                    
                    <!--<div class="form-group col-md-12 col-sm-12 col-12">-->
                    <!--  <label>Product Description (Optional)</label>-->
                    <!--  <textarea type="text" class="form-control" name="details" rows="5"></textarea>-->
                    <!--</div>-->
                    <!--<div class="form-group col-md-12 col-sm-12 col-xs-12">-->
                    <!--  <label>Product Specification (Optional)</label>-->
                    <!--  <textarea type="text" class="form-control" name="specification" rows="5"></textarea>-->
                    <!--</div>-->
                    
                  </div>
                  </div>
                  <div class="form-group col-md-3 col-sm-3 col-12"></div>
                  <div class="form-group" style="text-align:center;">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('Product') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
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
    $(document).ready(function() {
      $('#categoryID').change(function(){
        var catid = $('#categoryID').val();
        //alert(catid);
        if (catid == 'newCategory') {
          $('#newCategory').removeAttr('class', 'd-none');
          $('#newcat').attr('required', 'required');
        } else {
          $('#newCategory').attr('class', 'd-none');
          $('#newcat').removeAttr('required', 'required');
        }
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#unit').change(function(){
        var catid = $('#unit').val();
        //alert(catid);
        if (catid == 'newMD') {
          $('#newUnit').removeAttr('class', 'd-none');
          $('#newut').attr('required', 'required');
        } else {
          $('#newUnit').attr('class', 'd-none');
          $('#newut').removeAttr('required', 'required');
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#mdid').change(function(){
        var catid = $('#mdid').val();
        //alert(catid);
        if (catid == 'newDept') {
          $('#newDept').removeAttr('class', 'd-none');
          $('#newmd').attr('required', 'required');
        } else {
          $('#newDept').attr('class', 'd-none');
          $('#newmd').removeAttr('required', 'required');
        }
      });
    });
  </script>