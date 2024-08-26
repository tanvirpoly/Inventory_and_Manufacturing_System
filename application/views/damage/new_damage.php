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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Damage Information</h3>
              </div>

              <div class="card-body" >
                <form method="POST" action="<?php echo site_url("Damage/saved_damage") ?>">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Date *</label>
                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Employee *</label>
                      <select name="employee" class="form-control" required >
                        <option value="">Select One</option>
                        <?php foreach($employee as $value){ ?>
                        <option value="<?php echo $value['employeeID']; ?>"><?php echo $value['employeeName'].' ( '.$value['phone'].' )'; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Product *</label>                        
                      <select id="products" class="form-control">
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
                          <tr style="text-align:center;">
                            <th>Product</th>
                            <th>Batch</th>    
                            <th>Quantity</th>      
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                      </table>
                    </div>
                    
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Total Amount *</label>                        
                      <input type="text" class="form-control" name="tAmount" id="tAmount" required readonly >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Note</label>                        
                      <input type="text" class="form-control" name="note" placeholder="If have any note">
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url() ?>Damage" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
        $('#products').change(function(){        
          var id = $('#products').val();
          var base_url = '<?php echo base_url() ?>'+'Damage/getProduct/' + id;
          // alert(id);
          // alert(base_url);
          $.ajax({
            type: 'GET',
            url: base_url,
            dataType: 'text',
            success: function(data){
              var jsondata = JSON.parse(data);                
              $('#tbody').append(jsondata);
              }
            });
          });
        });
    </script>

    <script type="text/javascript">
      function getTotal(id)
        {
        var tp = $('#tp_' + id).val();
        var quantity = $('#quantity_' + id).val();
        
        var totalPrice = parseFloat(quantity) * parseFloat(tp);
        $('#totalPrice_' + id).val(parseFloat(totalPrice).toFixed(2));
        
        calculatePrice();
        }

      function calculatePrice()
        {
        var sum=0;
        $(".tPrice").each(function(){
          sum += parseFloat($(this).val());
          });
        $('#tAmount').val(sum.toFixed(2));
        }
    </script>