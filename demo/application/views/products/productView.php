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
                <h3 class="card-title">Product View</h3>
              </div>

              <div class="card-body">
                <div class="row">
                   <div class="col-md-4 col-sm-4 col-12">
                    <div class="col-md-12 col-sm-12 col-12" >
                      <?php if($product['image'] == null){ ?>
                      <i class="fa fa-shopping-cart fa-5x" ></i>
                      <?php } else{ ?>
                      <img src="<?php echo base_url('upload/product');?>/<?php echo $product['image']; ?>" style="width: 90%;height: auto;" alt="Product Image" >
                      <?php } ?>
                    </div>    
                  </div>
                  <div class="col-md-8 col-sm-8 col-8">
                    <table class="table table-bordered table-striped">
                      <tr>
                        <td>Product Name</td>
                        <td><?php if(isset($product['productName'])){echo $product['productName'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Product Code</td>
                        <td><?php if(isset($product['productcode'])){echo $product['productcode'];}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Product Type</td>
                        <td><?php 
                        if(isset($product['pType']))
                          {
                          if(isset($product['pType']) == 1)
                            {
                            echo 'Raw Materials';
                            }
                          else if(isset($product['pType']) == 2)
                            {
                            echo 'Finish Goods';
                            }
                          else{
                            echo '';
                            }    
                          }
                        else{
                          echo '';
                          }
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td>Category Name</td>
                        <td><?php 
                        if(isset($product['categoryID']))
                          {
                          $cat_name = $this->pm->get_category_data($product['categoryID']);
                          if(isset($cat_name->categoryName))
                            {
                            echo $cat_name->categoryName;
                            }
                          else{
                            echo '';
                            }    
                          }
                        else{
                          echo '';
                          }
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td>Purchase Price</td>
                        <td><?php if(isset($product['pprice'])){echo number_format($product['pprice'], 2);}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Sale Price</td>
                        <td><?php if(isset($product['sprice'])){echo number_format($product['sprice'], 2);}else{echo '';}?></td>
                      </tr>
                      <tr>
                        <td>Product Stock</td>
                        <td><?php 
                        if(isset($product['productID'])){
                            $stock = $this->pm->get_stock_data($product['productID']);
                            if(isset($stock->totalPices)) {
                                echo $stock->totalPices;
                            }else{
                                echo 'Stock out';
                            }    
                        }else{
                            echo '';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <td>Unit Name</td>
                        <td>
                          <?php 
                          $query = $this->db->select('*')
                                        ->from('sma_units')
                                        ->where('id',$product['unit'])
                                        ->get();
                          $result = $query->row();
                          if($result->unitName) {
                              echo $result->unitName;
                          } else {
                              echo '';
                          }
                          ?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-12" style="text-align: center;">
                  <a href="<?php echo site_url('Product') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left"></i> Back</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<?php $this->load->view('footer/footer'); ?>