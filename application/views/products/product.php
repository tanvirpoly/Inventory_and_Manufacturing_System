<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">Products List</h3>
                <?php if($_SESSION['new_product'] == 1){ ?>
                <a href="<?php echo site_url('newProduct') ?>" class="btn btn-primary" style="float: right; margin-left: 10px;"><i class="fa fa-plus"></i> New Product</a>
                <?php } if($_SESSION['store_product'] == 1){ ?>
                <button type="button" class="btn btn-danger storeProduct" data-toggle="modal" data-target=".bs-example-modal-storeProduct" style="float: right; margin-left: 10px;"><i class="fa fa-plus"></i> Store Product</button>
                <?php } if($_SESSION['import_product'] == 1){ ?>
                <button type="button" class="btn btn-success template" data-toggle="modal" data-target=".bs-example-modal-template" style="float: right; margin-left: 10px;"><i class="fa fa-plus"></i> Import</button>
                <?php } ?>
              </div>
              
              <div class="card-body">
                <div class="col-sm-12 col-md-12 col-12">
                  <form action="<?php echo base_url() ?>Product" method="get">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Product Type *</label>
                        <select class="form-control" name="pType" required >
                          <option value="">Select One</option>
                          <option value="1">Raw Material</option>
                          <option value="2">Finish Good</option>
                        </select>
                      </div>
                      <div class="form-group col-md-2 col-sm-2 col-12">
                        <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                      </div>
                    </div>
                  </form>
                </div><hr>
                
                <table id="example" class="table table-responsive table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">Item Serial</th>
                      <th>Code</th>
                      <th>Product N.</th>
                      <th>Type</th>
                      <th>Category</th>
                      <th>Unit</th>
                      <th>Department</th>
                      <th>P-Price</th>
                      <th>W-Price</th>
                      <th>R-Price</th>
                      <th>Stock</th>
                      <th style="width: 15%;">Option</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($product as $value){
                    $i++;
                    $pd = $this->db->select('*')
                                  ->from('stock')
                                  ->where('stock.product',$value->productID)
                                  ->where('compid',$_SESSION['compid'])
                                  ->get()
                                  ->row();
                      
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value->productcode; ?></td>
                      <td><?php echo $value->productName; ?></td>
                      <td>
                        <?php if($value->pType == 1){ ?>
                        <?php echo 'Raw Material'; ?>
                        <?php } else{ ?>
                        <?php echo 'Finish Good'; ?>
                        <?php } ?> 
                      </td>
                      <td><?php echo $value->categoryName; ?></td>
                      <td><?php echo $value->unitName; ?></td>
                      <td><?php echo $value->mdName; ?></td>
                      <td><?php echo number_format($value->pprice, 2); ?></td>
                      <td><?php echo number_format($value->sprice, 2); ?></td>
                      <td><?php echo number_format($value->rprice, 2); ?></td>
                      <td>
                        <?php if($pd){ ?>
                        <?php echo $pd->totalPices.' '.$value->unitName; ?>
                        <?php } else{ ?>
                        <?php echo '0'; ?>
                        <?php } ?> 
                      </td>
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo base_url().'viewProduct/'.$value->productID; ?>"><i class="fa fa-eye"></i></a>
                        <?php if($_SESSION['edit_product'] == 1){ ?>
                        <a class="btn btn-success btn-xs" href="<?php echo base_url().'editProduct/'.$value->productID; ?>"><i class="fa fa-edit"></i></a>
                        <?php } if($_SESSION['delete_product'] == 1){ ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo base_url('Product/delete_products').'/'.$value->productID; ?>"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                        <a class="btn btn-warning btn-xs" href="<?php echo base_url().'pBarcode/'.$value->productID; ?>"><i class="fa fa-barcode"></i></a>
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

    <div class="modal fade bs-example-modal-storeProduct" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Store Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <form action="<?php echo base_url() ?>Product/save_product_store" method="POST">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Select Product</label>
                <select name="product" class="form-control" required>
                  <option value="">Select One</option>
                  <?php foreach($product as $value) { ?>
                  <option value="<?php echo $value->productID; ?>"><?php echo $value->productName.' ( '.$value->productcode.' )'; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Product Quantity</label>
                <input type="text" class="form-control" name="quantity" placeholder="Product Quantity" required>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade bs-example-modal-template" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Import Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <div style="width: 100%;height: 100px;background: #fff4f4;text-align: center;">
                  <a href="<?php echo base_url('assets/templates/products.xlsx') ?>" style="padding:1em;text-align: center; display:inline-block;text-decoration: none !important;margin:0 auto;">Blank format</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-12">
              
            <form method="post" action="<?php echo base_url('Product/excel_import');?>" id="import_form" enctype="multipart/form-data">
              <div class="form-group col-md-12 col-sm-12 col-12">
                <label>Import Product<span style="color: red"> *</span><br>(Excel file Upload)</label>
                <input type="file" name="file" id="file" required accept=".xls, .xlsx">
              </div>
              <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top: 20px; text-align: center;">
                <input type="submit" name="import" value="Import" class="btn btn-info">
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>


  <script type="text/javascript">
  
    $(document).ready(function(){
      $('#import_form').on('submit',function(event){
        event.preventDefault();
        $.ajax({
          url:"<?php echo base_url(); ?>Product/excel_import",
          method:"POST",
          data:new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          success:function(data){
              window.location.reload();
                $('#file').val('');
                // load_data();
                // alert(data);
                console.log(data);
                $('#templete').remove();
                $('.modal-backdrop').remove();
                // window.location.reload();
              }
          });
        });
      });
      
      
      
    
  </script>