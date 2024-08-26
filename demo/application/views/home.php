<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dashboard</h3>
              </div>

              <div class="card-body">

                <section class="content">
                  <div class="container-fluid">
                    <div class="box-header with-border">
                      <h2><b>WELCOME TO "<?php echo $_SESSION['compname']; ?>"</b></h2>
                    </div>
                      <?php $unotice = $this->db->select('*')->from('notice')->order_by('nid','DESC')->limit(1)->get()->row(); ?>
                      <div class="col-md-12 col-sm-12 col-12">
                        <?php if($unotice){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php echo $unotice->message; ?>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button><br>
                          <a href="<?php echo site_url(); ?>uNotice" style="text-decoration: none;"  >All Notice</a>
                        </div>
                        <?php } ?>
                      </div>
          
                    <div class="row">
                    <?php if($_SESSION['sales_list'] == '1') { ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url(); ?>Sale" >
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?php echo number_format($sale->total, 2); ?></h3>
                            <p>TODAY SALES</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                    <?php } if($_SESSION['purchase_list'] == '1') { ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url(); ?>Purchase" >
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?php echo number_format($purchase->total, 2); ?></h3>
                            <p>TODAY PURCHASE</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                    <?php } if($_SESSION['voucher_list'] == '1') { ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url(); ?>Voucher" >
                        <div class="small-box bg-warning">
                          <div class="inner">
                            <h3><?php echo number_format($cvoucher->total, 2); ?></h3>
                            <p>TODAY COLLECTION</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-person-add"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                    <?php } if($_SESSION['voucher_list'] == '1') { ?>
                      <div class="col-lg-3 col-6">
                        <a href="<?php echo base_url(); ?>Voucher" >
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?php echo number_format(($dvoucher->total+$svoucher->total), 2); ?></h3>
                            <p>TODAY EXPENSE</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                          </div>
                        </div>
                        </a>
                      </div>
                    <?php } ?>
                    </div>

                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="card">
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                        <!-- <div class="card-header border-0">
                          <div class="d-flex justify-content-between">
                            <h3 class="card-title">Sales Purchases Report in Last 7 days</h3>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="300"></canvas>
                          </div>
                          <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                              <i class="fas fa-square text-primary"></i> Sales
                            </span>
                            <span>
                              <i class="fas fa-square text-gray"></i> Purchases
                            </span>
                          </div>
                        </div> -->
                      </div>
                    </div>

                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      window.onload = function() {

        CanvasJS.addColorSet("greenShades",
          [
          "#1382d6",
          "#1382d6",
          "#1382d6",
          "#1382d6",
          "#1382d6" ,               
          "#1382d6" ,               
          "#1382d6"                
          ]);
 
        var chart = new CanvasJS.Chart("chartContainer", {
          animationEnabled: true,
          theme: "light1",
          colorSet: "greenShades",
          title:{
            text: "Last 7 Days Sales"
            },
          axisY: {
            title: "Products sales amount"
            },
          data: [{
            type: "column",
            yValueFormatString: "#,##0.## Taka",
            dataPoints: <?php echo json_encode($this->pm->graph_data_point(), JSON_NUMERIC_CHECK); ?>
          }]
        });
      chart.render();
      }
    </script>