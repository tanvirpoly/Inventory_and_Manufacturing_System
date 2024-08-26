<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manufacturer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Manufacturer</li>
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
                <h3 class="card-title">Manufacturer Lists</h3>
                <?php if($_SESSION['new_manufacturer'] == 1){ ?>
                <!--<a href="<?php echo site_url(); ?>newManufacturer" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Manufacturer</a>-->
                <a href="<?php echo site_url(); ?>newMRecipe" class="btn btn-primary" style="float: right; margin-right: 10px;" ><i class="fa fa-plus"></i>&nbsp;New Recipe Manufacturer</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">Item Serial</th>
                      <th>M-Date</th>
                      <th>E-Date</th>
                      <th>Batch</th>
                      <th>Manufacturer</th>
                      <th>Quantity & Unit</th>
                      <th>Finish</th>
                      <th>Quantity</th>
                      <th>Status</th>
                      <th style="width: 10%;">OPTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($manufacturer as $value){
                    $i++;
                    $mp = $this->db->select('
                                        manufact_product.quantity,
                                        products.productName,
                                        sma_units.unitName')
                                  ->from('manufact_product')
                                  ->join('products','products.productID = manufact_product.pid','left')
                                  ->join('sma_units','sma_units.id = products.unit','left')
                                  ->where('mid',$value['mid'])
                                  ->get()
                                  ->result();

                    $cp = $this->db->select('
                                        manufact_cproduct.mcpid,
                                        manufact_cproduct.quantity,
                                        manufact_cproduct.batch,
                                        manufact_cproduct.mDay,
                                        products.productName,
                                        sma_units.unitName')
                                  ->from('manufact_cproduct')
                                  ->join('products','products.productID = manufact_cproduct.pid','left')
                                  ->join('sma_units','sma_units.id = products.unit','left')
                                  ->where('mid',$value['mid'])
                                  ->get()
                                  ->result();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['mDate'])) ?></td>
                      <td>
                        <?php foreach($cp as $p){ ?>
                        <?php echo date('d-m-Y',strtotime($value['mDate']. ' + '.$p->mDay.' days')) ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach($cp as $p){ ?>
                        <?php echo $p->batch; ?><br>
                        <?php } ?>
                      </td>
                      <!--<td>-->
                      <!--  <?php if($value['mType'] == 2){ ?>-->
                      <!--  <?php echo 'Recipe Manufacturer'; ?>-->
                      <!--  <?php } else { ?>-->
                      <!--  <?php echo 'General Manufacturer'; ?>-->
                      <!--  <?php } ?>-->
                      <!--</td>-->
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
                      <td>
                        <?php foreach($cp as $p){ ?>
                        <?php echo $p->productName; ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach($cp as $p){ ?>
                        <?php echo $p->quantity.' '.$p->unitName; ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if($value['status'] == 1){ ?>
                        <?php echo 'Approved'; ?>
                        <?php } else { ?>
                        <?php echo 'Pending'; ?>
                        <?php } ?>
                      </td>
                      <td>
                        <div class="input-group input-group-md mb-3">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Action </button>
                            <ul class="dropdown-menu">
                              <li class="dropdown-item"><a href="<?php echo site_url().'viewManufacturer/'.$value['mid']; ?>"><i class="fa fa-eye"></i> View</a></li>
                              <?php if($value['status'] == 0){ ?>
                              <?php if($_SESSION['edit_manufacturer'] == 1){ ?>
                              <li class="dropdown-divider"></li>
                              <?php if($value['mType'] == 2){ ?>
                              <li class="dropdown-item"><a href="<?php echo site_url().'editRManufacturer/'.$value['mid']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                              <?php } else { ?>
                              <li class="dropdown-item"><a href="<?php echo site_url().'editManufacturer/'.$value['mid']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                              <?php } ?>
                              <?php } if($_SESSION['delete_manufacturer'] == 1){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url('Manufacturer/approve_manufacturer').'/'.$value['mid']; ?>" onclick="return confirm('Are you sure you want to Approve this Manufacturer ?');" ><i class="fa fa-check"></i> Approve</a></li>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url('Manufacturer/delete_Manufacturer').'/'.$value['mid']; ?>" onclick="return confirm('Are you sure you want to delete this Manufacturer ?');" ><i class="fa fa-trash"></i> Delete</a></li>
                              <?php } ?>
                              <?php } ?>
                              <?php foreach($cp as $p){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url().'mlevel/'.$p->mcpid; ?>" ><i class="fa fa-barcode"></i> Barcode</a></li>
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