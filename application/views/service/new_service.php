<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Service</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Service Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Service/save_service") ?>">
                  <div class="row">
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Service Start *</label>
                      <input type="text" name="sdate" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Service End *</label>
                      <input type="text" name="edate" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select Customer *</label>
                      <select name="customer" class="form-control select2" required >
                        <option value="">Select One</option>
                        <?php foreach($customer as $value){ ?>
                        <option value="<?php echo $value['customerID']; ?>"><?php echo $value['custName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-12">
                      <label>Select Service Type *</label>
                      <select name="stype" id="stype" class="form-control" required >
                        <option value="">Select One</option>
                        <option value="VITAL">VITAL</option>
                        <option value="IPM">IPM</option>
                      </select>
                    </div>
                  </div>

                  <div class="d-none" id="VITAL" >
                    <div class="row">
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>ULV Type *</label>
                        <div>
                          <input type="radio" name="ulvType" class="ulvType" value="Big" required="" >&nbsp;&nbsp;Big&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="ulvType" class="ulvType" value="Small" required="" >&nbsp;&nbsp;Small&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="ulvType" class="ulvType" value="Both" required="" >&nbsp;&nbsp;Both
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Virex || 256 used ? *</label>
                        <div>
                          <input type="radio" name="virex" class="virex" value="Yes" required="" >&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="virex" class="virex" value="No" required="" >&nbsp;&nbsp;No
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Of Floors / Size *</label>
                        <input type="text" name="floor" id="floor" class="form-control" placeholder="Floors / Size" required="" >
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Of Technicians *</label>
                        <input type="number" name="technicians" id="technic" class="form-control" placeholder="Technicians Number" required="" >
                      </div>
                    </div>
                  </div>

                  <div class="d-none" id="IPM" >
                    <div class="row" >
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Checked Glue Boards/Baits *</label>
                        <div>
                          <input type="radio" name="glue" class="glue" value="Yes" required="" >&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="glue" class="glue" value="No" required="" >&nbsp;&nbsp;No
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Gel Treatment *</label>
                        <div>
                          <input type="radio" name="geltrt" id="ygeltrt" class="geltrt" value="Yes" required="" >&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="geltrt" id="ngeltrt" class="geltrt" value="No" required="" >&nbsp;&nbsp;No
                        </div>
                        <div>
                          <input type="hidden" name="gtreatment" class="form-control" id="gtreatment" placeholder="Gel Treatment Note" required="" >
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Spray Treatment *</label>
                        <div>
                          <input type="radio" name="spraytrt" id="yspraytrt" class="spraytrt" value="Yes" required="" >&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="spraytrt" id="nspraytrt" class="spraytrt" value="No" required="" >&nbsp;&nbsp;No
                        </div>
                        <div>
                          <input type="hidden" name="streatment" id="streatment" class="form-control" placeholder="Spray Treatment Note" required="" >
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Other Treatment *</label>
                        <div>
                          <input type="radio" name="othertrt" id="yothertrt" class="othertrt" value="Yes" required="" >&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="othertrt" id="nothertrt" class="othertrt" value="No" required="" >&nbsp;&nbsp;No
                        </div>
                        <div>
                          <input type="hidden" name="otreatment" id="otreatment" class="form-control" placeholder="Other Treatment Note" required="" >
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-12">
                        <label>Any Device/Traps *</label>
                        <div>
                          <input type="radio" name="anyDevice" id="yanyDevice" class="anyDevice" value="Yes" required="" >&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="anyDevice" id="nanyDevice" class="anyDevice" value="No" required="" >&nbsp;&nbsp;No
                        </div>
                        <div>
                          <input type="hidden" name="anyTraps" id="anyTraps" class="form-control" placeholder="Device/Traps Noye" required="" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                    <a href="<?php echo site_url('service') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php $this->load->view('footer/footer'); ?>
    
    <script type="text/javascript">
      $(document).ready(function(){
        $('#stype').change(function(){       
          var id = $('#stype').val();
            //alert(id);
          if(id == "VITAL")
            {
            $('#VITAL').removeAttr('class','d-none');
            $('#IPM').attr('class','d-none');

            $('.ulvType').attr('required','required');
            $('.virex').attr('required','required');
            $('#floor').attr('required','required');
            $('#technic').attr('required','required');
            
            $('.glue').removeAttr('required','required');
            $('.geltrt').removeAttr('required','required');
            $('.spraytrt').removeAttr('required','required');
            $('.othertrt').removeAttr('required','required');
            $('.anyDevice').removeAttr('required','required');
            }
          else
            {
            $('#VITAL').attr('class','d-none');
            $('#IPM').removeAttr('class','d-none');

            $('.ulvType').removeAttr('required','required');
            $('.virex').removeAttr('required','required');
            $('#floor').removeAttr('required','required');
            $('#technic').removeAttr('required','required');
            
            $('.glue').attr('required','required');
            $('.geltrt').attr('required','required');
            $('.spraytrt').attr('required','required');
            $('.othertrt').attr('required','required');
            $('.anyDevice').attr('required','required');
            }
          });
        });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#ygeltrt').click(function(){
          $('#gtreatment').removeAttr('type','hidden');
          $('#gtreatment').attr('required','required');
          });

        $('#ngeltrt').click(function(){
          $('#gtreatment').attr('type','hidden');
          $('#gtreatment').removeAttr('required','required');
          });

        $('#yspraytrt').click(function(){
          $('#streatment').removeAttr('type','hidden');
          $('#streatment').attr('required','required');
          });

        $('#nspraytrt').click(function(){
          $('#streatment').attr('type','hidden');
          $('#streatment').removeAttr('required','required');
          });

        $('#yothertrt').click(function(){
          $('#otreatment').removeAttr('type','hidden');
          $('#otreatment').attr('required','required');
          });

        $('#nothertrt').click(function(){
          $('#otreatment').attr('type','hidden');
          $('#otreatment').removeAttr('required','required');
          });

        $('#yanyDevice').click(function(){
          $('#anyTraps').removeAttr('type','hidden');
          $('#anyTraps').attr('required','required');
          });

        $('#nanyDevice').click(function(){
          $('#anyTraps').attr('type','hidden');
          $('#anyTraps').removeAttr('required','required');
          });
        });
    </script>