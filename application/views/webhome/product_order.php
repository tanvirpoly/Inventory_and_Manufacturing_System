<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Product Order</li>
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
                <h3 class="card-title">Product Order List</h3>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th style="width: 10%;">Date</th>
                      <th>Order No.</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <!--<th>Email</th> -->
                      <th>Address</th> 
                      <!--<th>Product</th>-->
                      <!--<th>Quantity</th>-->
                      <th>Amount</th>
                      <th style="width: 12%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($order as $value){
                    $i++;

                    $pp = $this->db->select('
                                        order.oid,
                                        order_product.*,
                                        products.productName')
                                  ->from('order_product')
                                  ->join('order','order.oid = order_product.oid','left')
                                  ->join('products','products.productID = order_product.product','left')
                                  ->where('order_product.oid',$value['oid'])
                                  ->get()
                                  ->result();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['regdate'])); ?></td>
                      <td><?php echo $value['order_no']; ?></td>
                      <td><?php echo $value['custName']; ?></td>
                      <td><?php echo $value['custMobile']; ?></td>
                      <!--<td><?php echo $value['custEmail']; ?></td>-->
                      <td><?php echo $value['custAddres']; ?></td>
                      <!--<td>-->
                      <!--  <?php foreach ($pp as $p) { ?>-->
                      <!--  <?php echo $p->productName; ?><br>-->
                      <!--  <?php } ?>-->
                      <!--</td>-->
                      <!--<td>-->
                      <!--  <?php foreach ($pp as $p) { ?>-->
                      <!--  <?php echo $p->quantity; ?><br>-->
                      <!--  <?php } ?>-->
                      <!--</td>-->
                      <td><?php echo number_format($value['tAmount'], 2); ?></td>
                      <td>
                        <a class="btn btn-success btn-xs" href="<?php echo site_url().'odView/'.$value['oid']; ?>"><i class="fa fa-eye"></i> View</a>
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