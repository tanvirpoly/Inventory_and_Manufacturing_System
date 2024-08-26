<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Return</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Return</li>
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
                <h3 class="card-title">Return List</h3>
                <?php if($_SESSION['new_return'] == '1') { ?>
                <a href="<?php echo site_url('newReturn') ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i> New Return</a>
                <?php } ?> 
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                        <thead>
                            <tr>
                                <th style="width: 5%;">SN</th>
                                <th>DATE</th>
                                <th>R-INV. NO.</th>
                                <th>CUSTOMER</th>
 -->                            <th>TOTAL</th>
                                <th>CHARGE</th>
                                <th>PAID</th>
                                <th style="width: 10%;">OPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($return as $value) {
                            $i++;
                            ?>
                            <tr class="gradeX" style="border: 1px solid #000;">
                                <td><?php echo $i; ?></td>
                                <td><?php echo date('d-m-Y',strtotime($value['returnDate'])); ?></td>
                                <td><?php echo $value['rid']; ?></td>
                                <td><?php echo $value['customerName']; ?><br><?php echo $value['mobile']; ?></td>
                                <td><?php echo number_format($value['totalPrice'], 2); ?></td>
                                <td><?php echo number_format($value['scAmount'], 2); ?></td>
                                <td><?php echo number_format($value['paidAmount'], 2); ?></td>
                                <td>
                                    <a class=" btn btn-info btn-xs" href="<?php echo site_url('viewReturn').'/'.$value['returnId'] ?>"><i class="fa fa-eye"></i></a>
                                    <?php if($_SESSION['edit_return'] == '1') { ?>
                                    <a class=" btn btn-success btn-xs" href="<?php echo site_url('editReturn').'/'.$value['returnId'] ?>"><i class="fa fa-edit"></i></a>
                                    <?php } if($_SESSION['delete_return'] == '1') { ?>
                                    <a href="<?php echo site_url('Returns/delete_returns').'/'.$value['returnId'] ?>" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>   
                            <?php } ?> 
                        </tbody>
                        <tfoot>
                          
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer/footer'); ?>