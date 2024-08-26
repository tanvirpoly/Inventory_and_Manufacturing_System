<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Transfer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Product Transfer</li>
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
                <h3 class="card-title">Product Transfer Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Ptransfer/update_product_transfer" enctype='multipart/form-data' >
                  <input type="hidden" name="tsid" value="<?php echo $transfer['tsid']; ?>" required >
                  <div class="row">
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Transfer Date *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y', strtotime($transfer['tDate'])) ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select Form Warehouse *</label>
                      <select class="form-control select2" name="fcompid" id="fcompid" required >
                        <option value="">Select One</option>
                        <?php foreach($warehouse as $value){ ?>
                        <option <?php echo ($transfer['fcompid'] == $value['com_pid'])?'selected':''?> value="<?php echo $value['com_pid']; ?>"><?php echo $value['com_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select To Warehouse *</label>
                      <select class="form-control select2" name="tcompid" id="tcompid" required >
                        <option value="">Select One</option>
                        <?php foreach($warehouse as $value){ ?>
                        <option <?php echo ($transfer['tcompid'] == $value['com_pid'])?'selected':''?> value="<?php echo $value['com_pid']; ?>"><?php echo $value['com_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select Product *</label>
                      <select class="form-control select2" id="productID" >
                        <option value="">Select One</option>
                        <?php foreach($product as $value){ ?>
                        <option value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-12" >
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Product</th>
                          <th>Batch</th>
                          <th>Stock</th>
                          <th>Quantity</th>
                          <th>Action</th>                       
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php
                        foreach($pproduct as $value){
                        $id = $value['pid'];
                        $batch = $this->db->select('*')
                                    ->from('stock')
                                    ->where('compid',$transfer['fcompid'])
                                    ->where('product',$id)
                                    ->where('totalPices >',0)
                                    ->get()
                                    ->result();
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['productName']; ?>
                            <input type='hidden' name='product[]' value="<?php echo $id; ?>" id='product_<?php echo $id ?>' required >
                          </td>
                          <td>
                            <select class='form-control' name='batch[]' id='batch_<?php echo $id ?>' onchange='batch_product_stock(<?php echo $id ?>)' required  >
                              <option value=''>Select One</option>
                              <?php foreach($batch as $bvalue){ ?>
                              <option <?php echo ($value['batch'] == $bvalue->batch)?'selected':''?> value="<?php echo $bvalue->batch; ?>"><?php echo $bvalue->batch; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td><input type='text' class='form-control' id='stock_".$id."' value='0' readonly ></td>     
                          <td>
                            <input type='text' class="form-control"  name='quantity[]' value="<?php echo $value['quantity']; ?>" required >
                          </td>
                          <td>
                            <span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Note</label>
                      <textarea type="text" class="form-control" name="notes" placeholder="If have any note" rows="5" ><?php echo $transfer['notes']; ?></textarea>
                    </div>
                  </div>
                    
                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info" onclick="this.form.submit(); this.disabled = true;" ><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <a href="<?php echo site_url() ?>ptransfer" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
      $('#productID').change(function(){
        var id = $('#productID').val();
        var compid = $('#fcompid').val();
        var url = '<?php echo base_url() ?>' + 'Ptransfer/get_product_details';
         // alert(id); alert(compid);
        $.ajax({
          method: "POST",
          url     : url,
          dataType: 'json',
          data    : {"id" : id,"compid" : compid},
          success: function(data){
            //alert(data);
            //var jsondata = JSON.parse(data);
            $('#mtable').append(data);
            }
          });
        });
    </script>
    
    
    <script type="text/javascript">
      function batch_product_stock(id){
        var pid = $('#product_'+id).val();
        var batch = $('#batch_'+id).val();
        var compid = $('#fcompid').val();
        var url = '<?php echo base_url() ?>' + 'Ptransfer/get_product_batch_stock';
          //alert(pid); alert(batch);
        $.ajax({
          method: "POST",
          url     : url,
          dataType: 'json',
          data    : {"pid" : pid,"batch" : batch,"compid" : compid},
          success: function(data){
            //alert(data);
            var HTML = data["totalPices"];
            
            $('#stock_'+id).val(HTML);
            }
          });
        }
    </script>
    
    