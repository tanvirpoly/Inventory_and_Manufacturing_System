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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manufacturer Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Manufacturer/update_recipe_manufacturer") ?>">
                  <input type="hidden" name="mid" value="<?php echo $manufacturer['mid']; ?>" required >
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Manufacturer Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y',strtotime($manufacturer['mDate'])) ?>" required >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Batch *</label>
                        <input type="text" class="form-control" name="batch" value="<?php echo $pproduct['batch']; ?>" required readonly >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Finish Product *</label>
                        <select class="form-control select2" name="mproduct" id="mproducts" required  >
                          <option value="">Select One</option>
                          <?php foreach($product as $value){ ?>
                          <option <?php echo ($pproduct['pid'] == $value['pid'])?'selected':''?> value="<?php echo $value['pid']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Finish Quantity (PCS) *</label>
                        <input type="text" class="form-control" name="mquantity" id="mquantity" onkeyup="calculatemquantity()" value="<?php echo $pproduct['quantity']; ?>" placeholder="Quantity" required >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Expire Day *</label>
                        <input type="number" class="form-control" name="mDay" value="<?php echo $pproduct['mDay']; ?>" placeholder="Expire" required min="1" >
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
                            </tr>
                          </thead>
                          <tbody id="ftable">
                            <?php foreach($mproduct as $value){
                            $stock = $this->db->select('totalPices')
                                      ->from('stock')
                                      ->where('product',$value['pid'])
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
                                <input type="hidden" name='fproduct[]' value="<?php echo $value['pid']; ?>" required >
                              </td> 
                              <td><?php echo $value['quantity']+$sqnt; ?></td>
                              <td>
                                <input type='text' class="form-control" name='fquantity[]' value="<?php echo $value['quantity']; ?>" required >
                                <input type='hidden' name='pquantity[]' value='<?php echo $value['quantity']; ?>' required >
                              </td>
                              <td><?php echo $value['unitName']; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" value="<?php echo $manufacturer['notes']; ?>">
                      </div>
                    </div>             
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
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
          var info = {'id':id};
            //alert(id);
          var url = '<?php echo base_url() ?>'+'Manufacturer/get_Recipe_Product';
                // alert(base_url);
          $.ajax({
            type: 'POST',
            url: url,
            data:info,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#ftable').html(jsondata);
              }
            });
          });
        });
    </script>
    
    <script type="text/javascript">
      function calculatemquantity()
        {
        var tmq = $('#mquantity').val();
        var id = $('#mproducts').val();
        var info = {'id':id,'tmq':tmq};
        var url = '<?php echo base_url() ?>'+'Manufacturer/get_Manufacturer_Details/';
            //alert(tmq); alert(id); alert(url);
        $.ajax({
          type: 'POST',
          async: false,
          url: url,
          data:info,
          dataType: 'json',
          success: function (data)
            {
            $('#ftable').html(data);
            },
        //   error:function(data){
        //     alert('Error');
        //     }
          });
        }
    </script>
