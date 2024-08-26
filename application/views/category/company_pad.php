<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Company Pad</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Company Pad</li>
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
                <h3 class="card-title">Company Pad List</h3>
                <button type="button" class="btn btn-primary btn-sm comPad" data-toggle="modal" data-target=".bs-example-modal-comPad"  style="float: right; margin-left: 10px;"  ><i class="fa fa-plus"></i> Add Pad</button>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 5%;">SN</th>
                      <th>Date</th>
                      <th>Ref. No.</th>
                      <th>Content</th>
                      <th style="width: 12%;">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($cpad as $key => $value) { 
                    $i++;
                    ?>
                    <tr class="gradeX">      
                      <td><?php echo $i; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['pDate'])); ?></td>
                      <td><?php echo $value['pRCode']; ?></td>     
                      <td><?php echo $value['pDetails']; ?></td>  
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo site_url().'viewCPad/'.$value['cpid']; ?>" target="_blank" ><i class="far fa-eye"></i></a>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Category/delete_company_pad').'/'.$value['cpid']; ?>" onclick="return confirm('Are you sure you want to delete this Pad ?');" ><i class="far fa-trash-alt"></i></a>
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
  
    <?php
    $query = $this->db->select('cpid')
                  ->from('company_pad')
                  ->limit(1)
                  ->order_by('cpid','DESC')
                  ->get()
                  ->row();
    if($query)
      {
      $sn = $query->cpid+1;
      }
    else
      {
      $sn = 1;
      }
    //var_dump($sn); exit();
    $cn = strtoupper(substr($_SESSION['compname'],0,3));
    $pc = sprintf("%'05d",$sn);

    $cusid = 'CP-'.$cn.$pc;
    ?>
      <div class="modal fade bs-example-modal-comPad" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Company Pad Information</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="<?php echo base_url('Category/saved_company_pad');?>" method="post">
              <div class="col-md-12 col-sm-12 col-12">
                <div class="row">
                  <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Date *</label>
                    <input type="text" name="pDate" class="form-control datepicker" value="<?php echo date('m/d/Y'); ?>" required >
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Reference No. *</label>
                    <input type="text" name="pRCode" class="form-control" value="<?php echo $cusid; ?>" placeholder="Reference No." required >
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12">
                    <label>Pad Content *</label>
                    <textarea  type="text" class="form-control" name="pDetails" id="editor" placeholder="Pad Content" rows="5" required ></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

<?php $this->load->view('footer/footer'); ?>
