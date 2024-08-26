<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">ALL REPORTS</li>
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
                <h3 class="card-title">ALL REPORT</h3>
              </div>

              <div class="card-body">
                <div class="row">
                <?php if($_SESSION['sale_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('saleReport'); ?>" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">SALE REPORT</span>
                          <span class="info-box-number"><?php echo number_format($sale->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['purchase_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('purchaseReport'); ?>" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">PURCHASE REPORT</span>
                          <span class="info-box-number"><?php echo number_format($purchase->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['profit_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('profil-Loss'); ?>" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">PROFIT / LOSS</span>
                          <?php $ti = $psale->total+$pcvoucher->total; ?>
                          <?php $te = $ppurchase->total+$pdvoucher->total+$pempp->total+$preturn->total+$psvoucher->total; ?>
                          <span class="info-box-number"><?php echo number_format(($ti-$te), 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['customer_report'] == '1') { ?>
                  <!--<div class="col-md-3 col-sm-6 col-12">-->
                  <!--  <a href="<?php echo base_url() ?>spReports" > -->
                  <!--    <div class="info-box bg-danger">-->
                  <!--      <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>-->
                  <!--      <div class="info-box-content">-->
                  <!--        <span class="info-box-text">Sale / Purchase Profit</span>-->
                  <!--        <span class="info-box-number"><?php echo number_format(($psale->total-$ppurchase->total), 2); ?></span>-->
                  <!--      </div>-->
                  <!--    </div>-->
                  <!--  </a>-->
                  <!--</div>-->
                <?php } if($_SESSION['customer_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>cusReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">CUSTOMER REPORT</span>
                          <span class="info-box-number"><?php echo $customer; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['customer_ledger'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>cusLedger" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="far fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">CUSTOMER LEDGER</span>
                          <span class="info-box-number"><?php echo $customer; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['supplier_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>supplierReport" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">SUPPLIER REPORT</span>
                          <span class="info-box-number"><?php echo $supplier; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['supplier_ledger'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>supplierLedger" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="far fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">SUPPLIER LEDGER</span>
                          <span class="info-box-number"><?php echo $supplier; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['stock_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>stockReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">STOCK REPORT</span>
                          <span class="info-box-number"><?php echo $stock->total; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['stock_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>rawstockReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">RAW STOCK REPORT</span>
                          <span class="info-box-number"><?php echo $rstock->total; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['stock_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>finishstockReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">FINISH STOCK REPORT</span>
                          <span class="info-box-number"><?php echo $fstock->total; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['voucher_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>vReports" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-adjust"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">VOUCHER REPORT</span>
                          <span class="info-box-number"><?php echo number_format($voucher->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['daily_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>dReport" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fab fa-amazon-pay"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">DAILY REPORT</span>
                          <?php $pamount = (($psale->total+$pcvoucher->total)-($ppurchase->total+$pdvoucher->total+$pempp->total+$preturn->total+$psvoucher->total)); ?>
                          <?php $ti = $csale->total+$ccvoucher->total+$pamount; ?>
                          <?php $te = $cpurchase->total+$cdvoucher->total+$csvoucher->total; ?>
                          <span class="info-box-number"><?php echo number_format(($ti-$te), 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['cashbook'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>cashReport" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">CASH BOOK</span>
                          <?php $ti = $ksale->total+$kcvoucher->total; ?>
                          <?php $te = $kpurchase->total+$kdvoucher->total+$ksvoucher->total+$kempp->total+$kreturn->total; ?>
                          <span class="info-box-number"></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['bankbook'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>bankReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-university"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">BANK BOOK</span>
                          <?php $ti = $bsale->total+$bcvoucher->total; ?>
                          <?php $te = $bpurchase->total+$bdvoucher->total+$bsvoucher->total+$bempp->total+$breturn->total; ?>
                          <span class="info-box-number"></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['mobilebook'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>mobileReport" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-mobile-alt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">MOBILE BOOK</span>
                          <?php $ti = $msale->total+$mcvoucher->total; ?>
                          <?php $te = $mpurchase->total+$mdvoucher->total+$msvoucher->total+$mempp->total+$mreturn->total; ?>
                          <span class="info-box-number"></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['total_product'] == '1') { ?>
                 <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>Product" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fab fa-product-hunt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">TOTAL PRODUCTS</span>
                          <span class="info-box-number"><?php echo $product; ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['order_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>orderReport" > 
                      <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">ORDER REPORT</span>
                          <span class="info-box-number"></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['sprofit_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>salesiReport" > 
                      <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">PROFIT REPORT (Sale Wise)</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['due_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>salesdReport" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">DUE REPORT (Sale Wise)</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['bsale_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>tsProduct" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fab fa-product-hunt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">BEST SALE PRODUCTS</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['stock_alert'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>lowStock" > 
                      <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fab fa-product-hunt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">STOCK ALERT</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['bank_transction'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>bankTReport" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">BANK TRANSCTION</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['expense_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>costReport" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-adjust"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">EXPENSE REPORT</span>
                          <!--<span class="info-box-number"><?php echo number_format($tsdp->total, 2); ?></span>-->
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['duep_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>salepReport" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">DUE SALE PAYMENT</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['vat_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url() ?>salevReport" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">VAT REPORT</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['sproduct_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('saleProduct'); ?>" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">ITEM WISE SALE REPORT</span>
                          <span class="info-box-number"><?php echo number_format($sale->total, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['dproduct_report'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url('deliveryProduct'); ?>" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">ITEM WISE DELIVERY REPORT</span>
                        </div>
                      </div>
                    </a>
                  </div>
                  <?php } ?>
                </div>
                
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-12">
                  <h3>Accounting Reports</h3>
                  </div>
                <?php if($_SESSION['trail_balance'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url(); ?>trialBalance" > 
                      <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Trial Balance</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['balance_sheet'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url(); ?>balanceSheet" > 
                      <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Balance Sheet</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['cash_flow'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url(); ?>cashFlow" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Cash Flow Report</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } if($_SESSION['income_statement'] == '1') { ?>
                  <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?php echo base_url(); ?>incomeStatement" > 
                      <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Income Statement</span>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } ?>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>