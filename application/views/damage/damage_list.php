<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Damage</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Damage</li>
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
                <h3 class="card-title"><b>Damage List</b></h3>
                <?php if($_SESSION['new_quotation'] == '1') { ?>
                <a href="<?php echo site_url(); ?>Damage/new_damage" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Damage</a>
                <?php } ?> 
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">Item Serial</th>
                      <th>DATE</th>
                       <th>Batch</th>
                      <th>Empolyee</th>
                      <th>Mobile</th>
                     
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Total</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($damage as $value) {
                    $id = $value['did'];
                    $i++;
                    
                    $pp = $this->db->select('damage_product.quantity,damage_product.batch,damage_product.price,products.productName,products.productcode')
                                  ->from('damage_product')
                                  ->join('products','products.productID = damage_product.pid','left')
                                  ->where('did',$value['did'])
                                  ->get()
                                  ->result();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['dDate'])) ?></td>
                        <td>
                        <?php foreach ($pp as $p) { ?>
                        <?php echo $p->batch ?><br>
                        <?php } ?>
                      </td>
                      <td><?php echo $value['employeeName']; ?></td>
                      <td><?php echo $value['phone']; ?></td>
                      
                      <td>
                        <?php foreach ($pp as $p) { ?>
                        <?php echo $p->productName ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach ($pp as $p) { ?>
                        <?php echo $p->quantity ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach ($pp as $p) { ?>
                        <?php echo number_format($p->price, 2) ?><br>
                        <?php } ?>
                      </td>
                      <td><?php echo number_format($value['tAmount'], 2) ?></td>
                      <td>
                        <a class="btn btn-info btn-xs"  href="<?php echo site_url().'Damage/view_damage/'.$id; ?>"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-success btn-xs"  href="<?php echo site_url().'Damage/edit_damage/'.$id; ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Damage/delete_damage').'/'.$id; ?>" onclick="return confirm('Are you sure you want to Delete this Damage ?');"><i class="fa fa-trash"></i></a>
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