<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Transfer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Product Transfer</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Transfer List</h3>
                <a href="<?php echo site_url() ?>newTransfer" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i> New Transfer</a>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>In. No.</th>
                      <th>Date</th>
                      <th>Form Warehouse</th>
                      <th>To Warehouse</th>            
                      <th>Notes</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($transfer as $value){
                    $i++;
                    
                    $fcompid = $this->db->select('com_name')->from('com_profile')->where('com_pid',$value['fcompid'])->get()->row();
                    $tcompid = $this->db->select('com_name')->from('com_profile')->where('com_pid',$value['tcompid'])->get()->row();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['tsCode']; ?></td>
                      <td><?php echo date('d/m/Y',strtotime($value['tDate'])); ?></td>
                      <td><?php if($fcompid){ echo $fcompid->com_name; } ?></td>
                      <td><?php if($tcompid){ echo $tcompid->com_name; } ?></td>
                      <td><?php echo $value['notes']; ?></td>
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url().'viewTransfer/'.$value['tsid']; ?>"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-success btn-xs" href="<?php echo site_url().'editTransfer/'.$value['tsid']; ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Ptransfer/delete_product_transfer').'/'.$value['tsid']; ?>" onclick="return confirm('Are you sure you want to delete this Transport ?');" ><i class="fa fa-trash"></i></a>
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
    </div>
  </div>

<?php $this->load->view('footer/footer'); ?>