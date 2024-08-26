<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">SALES</li>
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
                <h3 class="card-title">SALES LIST</h3>
                <?php if($_SESSION['new_sale'] == '1') { ?>
                <a href="<?php echo site_url('newSale') ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i> New Sale</a>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-responsive table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN</th>
                      <th>INVOICE</th>
                      <th>DATE</th>
                      <th>Outlet</th>
                      <th>CUSTOMER</th>
                      <th>TOTAL</th>            
                      <th>PAID</th>
                      <th>DISCOUNT</th>
                      <th>DUE</th>
                      <th>TYPE</th>
                      <th>STATUS</th>
                      <th style="width: 9%;">OPTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($sales as $value){
                    $i++;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['invoice_no']; ?></td>
                      <td><?php echo date('d-m-Y',strtotime($value['saleDate'])); ?></td>
                      <td><?php echo $value['name']; ?></td>
                      <td><?php echo $value['customerName']; ?><br><?php echo $value['mobile']; ?></td>
                      <td><?php echo number_format($value['totalAmount'], 2); ?></td>
                      <td><?php echo number_format($value['paidAmount'], 2); ?></td>
                      <td><?php echo number_format($value['discountAmount'], 2); ?></td>
                      <td style="color:red;"><?php echo number_format($value['dueamount'], 2); ?></td>
                      <td>
                        <?php
                        if($value['status'] == 1){
                          echo '<span style="color:green">General</span>';
                        }else{
                          echo '<span style="color:blue">POS</span>';
                        } ?>
                      </td>
                      <td>
                        <?php
                        if($value['dueamount'] == 0){
                          echo '<span style="color:green">PAID</span>';
                        }elseif ($value['dueamount'] < $value['totalAmount']) {
                          echo '<span style="color:red">PARTIAL</span>';
                        }else{
                          echo '<span style="color:red">DUE</span>';
                        } ?>
                      </td>
                      <td>
                        <div class="input-group input-group-md mb-3">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Action </button>
                            <ul class="dropdown-menu">
                              <li class="dropdown-item"><a href="<?php echo site_url('viewSale').'/'.$value['saleID']; ?>"><i class="fa fa-eye"></i> View</a></li>
                              <li class="dropdown-divider"></li>
                            <?php if($_SESSION['edit_sale'] == '1') { ?>
                              <li class="dropdown-item"><a href="<?php echo site_url('editSale').'/'.$value['saleID']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                              <li class="dropdown-divider"></li>
                            <?php } if($_SESSION['delete_sale'] == '1') { ?>
                              <li class="dropdown-item"><a href="<?php echo site_url('Sale/delete_sales').'/'.$value['saleID']; ?>"><i class="fa fa-trash"></i> Delete</a></li>
                            <?php } ?> 
                              <?php if($value['dueamount'] > 0){ ?>
                              <li class="dropdown-divider"></li>
                              <li class="dropdown-item">
                                <a href="#" class="payment" data-toggle="modal" data-target=".bs-example-modal-payment" data-id="<?php echo $value['saleID']; ?>" ><i class="fa fa-plus"></i> Payment</a>
                              </li>
                            <?php } ?>
                              <li class="dropdown-item"><a href="<?php echo site_url('deliveryChalan').'/'.$value['saleID']; ?>"><i class="fa fa-car"></i> Delivery</a></li>
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

    <div id="payment" class="modal fade bs-example-modal-payment" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" > Payment Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Sale/save_sales_payment');?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label>Due Amount</label>
                <input type="text" class="form-control" name="damount" id="damount" readonly >
              </div>
              <input type="hidden" class="form-control" name="pamount" id="pamount" >
              <div class="form-group">
                <label>Paid Amount *</label>
                <input type="text" class="form-control" name="amount" id="payamount" placeholder="Amount" required >
              </div>
            </div>
            <input type="hidden" id="saleID" name="saleID" >
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
          $('input[name="saleID"]').val(id);
          });

        $('.payment').click(function(){
          var id = $(this).data('id');
            //alert(id);
          var url = "<?php echo base_url(); ?>Sale/get_sales_payment";
            //alert(url);
          $.ajax({
            method: "POST",
            url     : url,
            dataType: "json",
            data    : {'id' : id},
            success:function(data){
            //alert(data);
              var HTML = data["dueamount"];
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