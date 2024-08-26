<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Recipe</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Recipe</li>
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
                <h3 class="card-title">Recipe Lists</h3>
                <?php if($_SESSION['new_recipe'] == 1){ ?>
                <a href="<?php echo site_url(); ?>newRecipe" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Recipe</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">Item Serial</th>
                      <th>Recipe Name</th>
                      <th>Raw Material Name</th>
                      <th>Quantity & Unit</th>
                      <!--<th>Notes</th>-->
                      <th>Status</th>
                      <th style="width: 10%;">OPTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($recipe as $value){
                    $i++;
                    $mp = $this->db->select('
                                        recipe_product.quantity,
                                        products.productName,
                                        sma_units.unitName')
                                  ->from('recipe_product')
                                  ->join('products','products.productID = recipe_product.pid','left')
                                  ->join('sma_units','sma_units.id = products.unit','left')
                                  ->where('rid',$value['rid'])
                                  ->get()
                                  ->result();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['productName']; ?></td>
                      <td>
                        <?php foreach($mp as $p){ ?>
                        <?php echo $p->productName; ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach($mp as $p){ ?>
                        <?php echo $p->quantity.' '.$p->unitName; ?><br>
                        <?php } ?>
                      </td>
                      
                      <!--<td><?php echo $value['rNotes']; ?></td>-->
                      
                      <td><?php echo $value['status']; ?></td>
                      <td>
                        <div class="input-group input-group-md mb-3">
                          <div class="input-group-prepend">
                              
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Action </button>
                            
                            <ul class="dropdown-menu">
                              <li class="dropdown-item"><a href="<?php echo site_url().'viewRecipe/'.$value['rid']; ?>"><i class="fa fa-eye"></i> View</a></li>
                              <?php if($_SESSION['edit_recipe'] == 1){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url().'editRecipe/'.$value['rid']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                              <?php } if($_SESSION['delete_recipe'] == 1){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url('Manufacturer/delete_recipe').'/'.$value['rid']; ?>" onclick="return confirm('Are you sure you want to delete this Recipe ?');" ><i class="fa fa-trash"></i> Delete</a></li>
                              <?php } ?>
                            </ul>
                          </div>
                        </div>
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

<?php $this->load->view('footer/footer'); ?>