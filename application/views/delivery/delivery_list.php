<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery</li>
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
                <h3 class="card-title">Delivery Lists</h3>
                <?php if($_SESSION['new_delivery'] == 1){ ?>
                <a href="<?php echo site_url(); ?>newDelivery" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Delivery</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">SN</th>
                      <th>Date</th>
                      <th>Employee</th>
                      <th>Mobile</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th style="width: 10%;">OPTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($delivery as $value){
                    $i++;
                    $mp = $this->db->select('
                                        delivery_product.quantity,
                                        products.productName,
                                        sma_units.unitName')
                                  ->from('delivery_product')
                                  ->join('products','products.productID = delivery_product.pid','left')
                                  ->join('sma_units','sma_units.id = products.unit','left')
                                  ->where('did',$value['did'])
                                  ->get()
                                  ->result();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['dDate'])).'<br><i><b>'.date('h:i a',strtotime($value['regdate'])).'</i></b>'; ?></td>
                      <td><?php echo $value['employeeName']; ?></td>
                      <td><?php echo $value['phone']; ?></td>
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
                        <div class="input-group input-group-md mb-3">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Action </button>
                            <ul class="dropdown-menu">
                              <li class="dropdown-item"><a href="<?php echo site_url().'viewDelivery/'.$value['did']; ?>"><i class="fa fa-eye"></i> View</a></li>
                              <?php if($_SESSION['edit_delivery'] == 1){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url().'editDelivery/'.$value['did']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                              <?php } if($_SESSION['delete_delivery'] == 1){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item"><a href="<?php echo site_url('Delivery/delete_delivery').'/'.$value['did']; ?>" onclick="return confirm('Are you sure you want to delete this Delivery ?');" ><i class="fa fa-trash"></i> Delete</a></li>
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