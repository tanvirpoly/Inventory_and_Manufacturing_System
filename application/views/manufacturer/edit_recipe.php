<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Recipe</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Recipe</li>
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
                <h3 class="card-title">Recipe Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Manufacturer/update_recipe") ?>">
                  <input type="hidden" name="rid" value="<?php echo $recipe['rid']; ?>" required >
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Recipe Name *</label>
                        <select class="form-control select2" name="product" required >
                          <option value="">Select One</option>
                          <?php foreach($product as $value){ ?>
                          <option <?php echo ($recipe['pid'] == $value['productID'])?'selected':''?> value="<?php echo $value['productID']; ?>"><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Recipe Notes</label>
                        <input type="text" class="form-control" name="rNotes"  value="<?php echo $recipe['rNotes']; ?>" >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Select Products *</label>
                        <select class="form-control select2" id="mproducts" >
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
                              <th>Quantity</th>
                              <th>Unit</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="mtable">
                            <?php foreach ($mproduct as $value){ ?>
                            <tr style="min-height: 200px;">
                              <td><?php echo $value['productName']; ?><input type='hidden' name='mproduct[]' value='<?php echo $value['pid']; ?>' required ></td>
                              <td>
                                <input type='text' class='form-control' name='mquantity[]' value='<?php echo $value['quantity']; ?>' required >
                                <input type='hidden' name='pquantity[]' value='<?php echo $value['quantity']; ?>' required >
                              </td>
                              <td><?php echo $value['unitName']; ?></td>
                              <td><span class='item_remove btn btn-danger btn-sm' onClick='$(this).parent().parent().remove();'>x</span></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                              
                    <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                      <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                      <a href="<?php echo site_url('recipeList') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;BACK</a>
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
    
