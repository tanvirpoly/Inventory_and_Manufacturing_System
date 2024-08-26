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
                <h3 class="card-title">Manufacturer Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Manufacturer/save_manufacturer") ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Manufacturer Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Manufacturer Products *</label>
                          <select class="form-control select2" id="mproducts" required >
                            <option value="">Select One</option>
                            <?php foreach($rproduct as $value){ ?>
                            <option value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <table class="table table-bordered table-striped">
                          <thead class="btn-default">
                            <tr>
                              <th>Products</th>
                              <th>Stock</th>
                              <th>Quantity</th>
                              <th>Unit</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="mtable">

                          </tbody>
                        </table>
                      </div>
                      
                      <?php
                      $batch = $this->db->select('mcpid')
                                  ->from('manufact_cproduct')
                                  ->order_by('mcpid','DESC')
                                  ->get()
                                  ->row();
                      if($batch)
                        {
                        $pcode = ($batch->mcpid+1);
                        }
                      else
                        {
                        $pcode = '1';
                        }
                      ?>
                      <input type="hidden" id="pcode" value="<?php echo $pcode; ?>" required  >
                      <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Finish Products *</label>
                          <select class="form-control select2" id="fproducts" required >
                            <option value="">Select One</option>
                            <?php foreach($fproduct as $value){ ?>
                            <option value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <table class="table table-bordered table-striped">
                          <thead class="btn-default">
                            <tr>
                              <th>Products</th>
                              <th>Stock</th>
                              <th>Batch</th>
                              <th>Quantity</th>
                              <th>Unit</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="ftable">

                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" placeholder="If have any note">
                      </div>
                    </div>  
                    
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;SUBMIT</button>
                      <a href="<?php echo site_url('Manufacturer') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
                    </div>
                    
                  </div>
                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<?php $this->load->view('footer/footer'); ?>


    <script type="text/javascript">
      $(document).ready(function(){
        $('#mproducts').change(function(){    
          var id = $('#mproducts').val();
            //alert(id);
          var base_url = '<?php echo base_url() ?>'+'Manufacturer/get_Manufacturer_Product/'+id;
                // alert(base_url);
          $.ajax({
            type: 'GET',
            url: base_url,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#mtable').append(jsondata);
              }
            });
          });
        });
    </script>
    
    <script type="text/javascript">
      $(document).ready(function(){
        $('#fproducts').change(function(){    
          var id = $('#fproducts').val();
          var pcode = $('#pcode').val();
          var info = {'id':id,'pcode':pcode};
            //alert(id);
          var url = '<?php echo base_url() ?>'+'Manufacturer/get_Finish_Product';
                // alert(base_url);
          var pid = +pcode + +1;
          $('#pcode').val(pid);
          $.ajax({
            type: 'POST',
            url: url,
            data:info,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#ftable').append(jsondata);
              }
            });
          });
        });
    </script>
