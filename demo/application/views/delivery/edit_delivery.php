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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Delivery/update_delivery") ?>">
                  <input type="hidden" name="did" value="<?php echo $delivery['did']; ?>" required >
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Delivery Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($delivery['dDate'])) ?>" required >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Select Outlet *</label>
                        <select class="form-control select2" name="employee" required  >
                          <option value="">Select One</option>
                          <?php foreach($employee as $value){ ?>
                          <option <?php echo ($delivery['empid'] == $value['employeeID'])?'selected':''?> value="<?php echo $value['employeeID']; ?>"><?php echo $value['employeeName']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Select Product *</label>
                        <select class="form-control select2" id="product"  >
                          <option value="">Select One</option>
                          <?php foreach($product as $value){ ?>
                          <option value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-12">
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
                          <tbody id="ptable">
                            <?php foreach($pproduct as $value){
                            $id = $value['pid'];
                            
                            $stock = $this->db->select('totalPices')
                                      ->from('stock')
                                      ->where('product',$id)
                                      ->get()
                                      ->row();
                            if($stock)
                              {
                              $sqnt = $stock->totalPices;
                              }
                            else
                              {
                              $sqnt = 0;
                              }
                            ?>
                            <tr>
                              <td>
                                <?php echo $value['productName']; ?>
                                <input type="hidden" name='product[]' value="<?php echo $value['pid']; ?>" required >
                              </td>
                              <td><?php echo $sqnt+$value['quantity']; ?></td> 
                              <td>
                                <input type='text' class="form-control" name='quantity[]'   value="<?php echo $value['quantity']; ?>" required >
                              </td>
                              <td><?php echo $value['unitName']; ?></td> 
                              <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" value="<?php echo $delivery['notes']; ?>" placeholder="If have any note">
                      </div>
                    </div>             
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                      <a href="<?php echo site_url('delivery') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
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
        $('#product').change(function(){
          var id = $('#product').val();
          var base_url = '<?php echo base_url() ?>'+'Delivery/get_delivery_product/'+id;
                // alert(base_url);
          $.ajax({
            type: 'GET',
            url: base_url,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#ptable').append(jsondata);
              }
            });
          });
        });
    </script>
    
