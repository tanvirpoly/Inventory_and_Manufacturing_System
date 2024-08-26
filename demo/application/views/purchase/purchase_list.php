<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">PURCHASE</li>
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
                <h3 class="card-title">PURCHASE LIST</h3>
                <?php if($_SESSION['new_purchase'] == '1') { ?>
                <a href="<?php echo site_url('newPurchase'); ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;New Purchase</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">SN</th>
                      <th>PURCHASE No</th>
                      <th>DATE</th>
                      <th>SUPPLIER</th>
                      <th style="width: 15%;">Product</th> 
                      <th>Quantity</th>
                      <!-- <th style="width: 10%;">Unit Price</th> -->
                      <th>TOTAL</th>
                      <th>PAID</th>
                      <th>DUE</th>
                      <!-- <th>Status</th> -->
                      <th style="width: 10%;">OPTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($purchase as $value){
                    $i++;
                    $pp = $this->db->select('purchase_product.productID, Sum(quantity) as tq, products.*')
                                  ->from('purchase_product')
                                  ->join('products','products.productID = purchase_product.productID','left')
                                  ->where('purchaseID',$value['purchaseID'])
                                  ->get()
                                  ->row();
                    
                    $mp = $this->db->select('
                                        products.productName,
                                        products.unit,
                                        purchase_product.*,
                                        sma_units.unitName')
                                  ->from('purchase_product')
                                  ->join('products','products.productID = purchase_product.productID','left')
                                  ->join('sma_units','sma_units.id = products.unit','left')
                                  ->where('purchaseID',$value['purchaseID'])
                                  ->get()
                                  ->result();
                    // var_dump($mp);
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['challanNo'] ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['purchaseDate'])).'<br><b>'.date('h:ia',strtotime($value['regdate'])).'</b>' ?></td>
                      <td><?php echo $value['supplierName']; ?><br><?php echo $value['mobile']; ?></td>
                      <td>
                         <?php foreach ($mp as $p) { ?>
                        <?php echo $p->productName; ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach ($mp as $p) { ?>
                        <?php echo $p->quantity.' '.$p->unitName; ?><br>
                        <?php } ?>
                        <!--<?php echo $pp->tq; ?>-->
                      </td>
                      <!-- <td>
                        <?php foreach ($pp as $p) { ?>
                        <?php echo number_format($p->pprice, 2); ?><br>
                        <?php } ?>
                      </td> -->
                      <td><?php echo number_format($value['totalPrice'], 2) ?></td>
                      <td><?php echo number_format($value['paidAmount'], 2) ?></td>
                      <td style="color:RED;"><?php echo number_format($value['due'], 2); ?></td>
                      <!-- <td>
                        <?php
                        if($value['due'] == 0){
                          echo '<span style="color:green">Paid</span>';
                        }elseif ($value['due'] < $value['totalPrice']) {
                          echo '<span style="color:red">Partial</span>';
                        }else{
                          echo '<span style="color:red">Due</span>';
                        } ?>
                      </td> -->
                      <td>
                        <div class="input-group input-group-md mb-3">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Action </button>
                            <ul class="dropdown-menu">
                              <li class="dropdown-item"><a href="<?php echo site_url('viewPurchase').'/'.$value['purchaseID']; ?>"><i class="fa fa-eye"></i> View</a></li>
                              <li class="dropdown-divider"></li>
                            <?php if($_SESSION['edit_purchase'] == '1') { ?>
                              <li class="dropdown-item"><a href="<?php echo site_url('editPurchase').'/'.$value['purchaseID']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                              <li class="dropdown-divider"></li>
                            <?php } if($_SESSION['delete_purchase'] == '1') { ?>
                              <li class="dropdown-item"><a href="<?php echo site_url('Purchase/delete_purchases').'/'.$value['purchaseID']; ?>"><i class="fa fa-trash"></i> Delete</a></li>
                            <?php } ?> 
                              <?php if($value['due'] > 0){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item">
                                <a href="#" class="payment" data-toggle="modal" data-target=".bs-example-modal-payment" data-id="<?php echo $value['purchaseID']; ?>"><i class="fa fa-plus"></i> Payment</a>
                              </li>
                              <?php } ?> 
                            </ul>
                          </div>
                        </div>
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

    <div class="modal fade bs-example-modal-payment" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Add Due Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Purchase/save_purchase_payment');?>" method="post">
            <div class="col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label>Due Amount</label>
                <input type="text" class="form-control" name="damount" id="damount" readonly >
              </div>
              <input type="hidden" class="form-control" name="pamount" id="pamount" >
              <div class="form-group">
                <label>Paid Amount *</label>
                <input type="text" class="form-control" name="amount" placeholder="Amount" required >
              </div>
            </div>
            <input type="hidden" id="purchaseID" name="purchaseID" >
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="pbsubmit" ><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer/footer'); ?>


    <script type="text/javascript">
      $(document).ready(function(){
        $(".payment").click(function(){
          var id = $(this).data('id');
        //alert(l_id);
          $('input[name="purchaseID"]').val(id);
          });

        $('.payment').click(function(){
          var id = $(this).data('id');
            //alert(id);
          var url = '<?php echo base_url() ?>Purchase/get_purchase_payment';
            //alert(url);
          $.ajax({
            type: 'POST',
            async: false,
            url: url,
            data:{"id":id},
            dataType: 'json',
            success: function(data){
            //alert(data);
              var HTML = data["due"];
              var HTML2 = data["paidAmount"];
            //alert(HTML2);
              $("#damount").val(HTML);
              $("#pamount").val(HTML2);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>