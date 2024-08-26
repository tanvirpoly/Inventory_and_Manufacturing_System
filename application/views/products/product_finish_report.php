<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>FINISH STOCK REPORT</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Finish Stock Report</li>
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
                <h3 class="card-title">Finish Product Stock Report</h3>
              </div>

              <div class="card-body">
                <div id="print">
                  <div class="row" id="header" style="display: none" >
                    <?php if($company){ ?>
                      <div class="col-sm-2 col-md-2 col-2" style="margin-top: 30px;">
                        <img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>"  style="width: 100%;">
                      </div>
                      <div class="col-sm-10 col-md-10 col-10">
                        <div class="col-sm-12 col-md-12 col-12">
                          <h3><b><?php echo $company->com_name; ?></b></h3>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_address; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_email; ?></b>
                        </div>
                        <div class="col-sm-12 col-md-12 col-12">
                          <b>Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->com_mobile; ?></b>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                  <table id="example" class="table table-striped table-bordered" >
                    <thead>
                      <tr>
                        <th style="width: 5%;">Item Serial</th>
                        <th>Batch</th>
                        <th>ITEM NAME</th>
                        <th>CODE</th>
                        <th>STORE</th>
                        <th>PURCHASE</th>
                        <th>SALE</th>
                        <th>RETURN</th>
                        <th>STOCK QTY</th>
                        <th style="width: 10%;">VALUE</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      $ts = 0;
                      $tpq = 0;
                      $tsq = 0;
                      $tq = 0;
                      $tr = 0;
                      $taq = 0;
                      foreach ($stock as $result){
                      $i++;
                      $pid = $result->product;
                      $cid = $result->compid;

                      $pp = $this->db->select("SUM(purchase_product.quantity) as tpq,purchase.compid")
                                    ->from('purchase_product')
                                    ->join('purchase','purchase.purchaseID = purchase_product.purchaseID','left')
                                    ->where('productID',$pid)
                                    ->where('compid',$cid)
                                    ->get()
                                    ->row();
                      if($pp)
                        {
                        $tpp = $pp->tpq;
                        }
                      else
                        {
                        $tpp = 0;
                        }
                      $spp = $this->db->select("SUM(sale_product.quantity) as tsq,sales.compid")
                                    ->from('sale_product')
                                    ->join('sales','sales.saleID = sale_product.saleID','left')
                                    ->where('productID',$pid)
                                    ->where('compid',$cid)
                                    ->get()
                                    ->row();
                      
                      if($spp)
                        {
                        $tspp = $spp->tsq;
                        }
                      else
                        {
                        $tspp = 0;
                        }
                        
                      $rpp = $this->db->select("SUM(returns_product.quantity) as trq,returns.compid")
                                    ->from('returns_product')
                                    ->join('returns','returns.returnId = returns_product.rt_id','left')
                                    ->where('productID',$pid)
                                    ->where('returns.compid',$cid)
                                    ->get()
                                    ->row();
                      if($rpp)
                        {
                        $trpp = $rpp->trq;
                        }
                      else
                        {
                        $trpp = 0;
                        }
                      $sp = $this->db->select("SUM(totalPices) as trq")
                                    ->from('stock_store')
                                    ->where('product',$pid)
                                    ->where('compid',$cid)
                                    ->get()
                                    ->row();
                      if($sp)
                        {
                        $tsp = $sp->trq;
                        }
                      else
                        {
                        $tsp = 0;
                        }
                      
                      $taqnt = ($tpp+$tsp+$trpp)-$tspp;
                      
                      //$this->pm->update_stock_product($pid,$taqnt);
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                         <td><?php echo $result->batch; ?></td>
                        <td><?php echo $result->productName; ?></td>
                        <td><?php echo $result->productcode; ?></td>
                        <td><?php echo $tsp; $ts += $tsp; ?></td>
                        <td><?php echo $tpp; $tpq += $tpp; ?></td>
                        <td><?php echo $tspp; $tsq += $tspp; ?></td>
                        <td><?php echo $trpp; $tr += $trpp; ?></td>
                        <td><?php echo $result->totalPices; $tq += $result->totalPices; ?></td>
                        <td><?php echo number_format(($result->totalPices*$result->pprice), 2); $taq += ($result->totalPices*$result->pprice); ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4" style="text-align: right;" >Total</th>
                        <th><?php echo $ts; ?></th>
                        <th><?php echo $tpq; ?></th>
                        <th><?php echo $tsq; ?></th>
                        <th><?php echo $tr; ?></th>
                        <th><?php echo $tq; ?></th>
                        <th><?php echo number_format($taq, 2); ?></th>
                      </tr>
                    </tfoot>
                  </table>
                </div><br>
                <div class="form-group col-md-12" style="text-align: center; margin-top: 20px">
                  <a href="javascript:void(0)" style="width: 100px;" value="Print" onclick="printDiv('print')" class="btn btn-primary"><i class="fa fa-print"> </i>  Print</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>