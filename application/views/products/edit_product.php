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
                <h3 class="card-title">Update Product</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Product/update_product" enctype="multipart/form-data" >
                  <div class="row">
                    <input type="hidden" class="form-control" name="productid" value="<?php echo $product['productID']; ?>" >
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Product Name *</label>
                      <input type="text" class="form-control" name="productName" value="<?php echo $product['productName']; ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Product Code</label>
                      <input type="text" class="form-control" name="productcode" value="<?php echo $product['productcode']; ?>" readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Product Type *</label>
                        <select class="form-control" name="pType" required >
                          <option value="">Select One</option>
                          <option <?php echo ($product['pType'] == 1)?'selected':''?> value="1">Raw Materials</option>
                          <option <?php echo ($product['pType'] == 2)?'selected':''?> value="2">Finish Goods</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Category</label>
                      <select name="categoryID" class="form-control"  >
                        <option value="">Select One</option>
                        <?php foreach($category as $value) { ?>
                        <option <?php echo ($product['categoryID'] == $value['categoryID'])?'selected':''?> value="<?php echo $value['categoryID']; ?>"><?php echo $value['categoryName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Unit</label>
                      <select name="units" class="form-control" >
                        <option value="">Select One</option>
                        <?php foreach($unit as $value) { ?>
                        <option <?php echo ($product['unit'] == $value->id)?'selected':''?> value="<?php echo $value->id; ?>"><?php echo $value->unitName; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Department</label>
                      <select name="mdid" class="form-control select2" >
                        <option value="">Select One</option>
                        <?php foreach($mdept as $value) { ?>
                        <option <?php echo ($product['mdid'] == $value['md_id'])?'selected':''?> value="<?php echo $value['md_id']; ?>"><?php echo $value['mdName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Purchase Price</label>
                      <input type="text" class="form-control" name="pprice" value="<?php echo $product['pprice']; ?>"  >
                    </div>
                    
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Wholesale Price</label>
                      <input type="text" class="form-control" name="sprice" value="<?php echo $product['sprice']; ?>"  >
                    </div>
                    
                     <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Retail Price</label>
                      <input type="text" class="form-control" name="rprice" value="<?php echo $product['rprice']; ?>"  >
                    </div>
                    
                    <!--<div class="form-group col-md-4 col-sm-4 col-12">-->
                    <!--  <label>Show Font Page *</label>-->
                    <!--  <div>-->
                    <!--    <?php if($product['spstatus'] == 1){ ?>-->
                    <!--    <input type="radio" name="spstatus" value="1" required checked >&nbsp;&nbsp;Yes&nbsp;&nbsp;-->
                    <!--    <input type="radio" name="spstatus" value="2" required >&nbsp;&nbsp;No-->
                    <!--    <?php } else{ ?>-->
                    <!--    <input type="radio" name="spstatus" value="1" required >&nbsp;&nbsp;Yes&nbsp;&nbsp;-->
                    <!--    <input type="radio" name="spstatus" value="2" required checked >&nbsp;&nbsp;No-->
                    <!--    <?php } ?>-->
                    <!--  </div>-->
                    <!--</div>-->
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <label>Product Image</label><br>
                      <input type="file" name="userfile" >
                    </div>
                    <!--<div class="form-group col-md-12 col-sm-12 col-12">-->
                    <!--    <label>Product Description</label>-->
                    <!--    <textarea type="text" class="form-control" name="details" id="editor" rows="5" placeholder="Description" ><?php echo $product['details']; ?></textarea>-->
                    <!--</div>-->
                    <!--<div class="form-group col-md-12 col-sm-12 col-12">-->
                    <!--    <label>Product Specification</label>-->
                    <!--    <textarea type="text" class="form-control" name="specification" id="ckeditor" rows="5" placeholder="Specification" ><?php echo $product['specifict']; ?></textarea>-->
                    <!--</div>-->
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="text-align: center; margin-top: 20px;">
                    <div class="col-md-9 col-md-offset-4">  
                      <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i> Update</button>
                      <a href="<?php echo site_url('Product') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
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