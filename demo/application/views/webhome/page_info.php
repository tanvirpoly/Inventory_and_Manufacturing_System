<?php $this->load->view('header/header2'); ?>
<?php $this->load->view('navbar/navbar2'); ?>

  <div class="content-wrapper">
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title m-0"><b><?php if($page){ ?><?php echo $page[0]['pName']; ?><?php } ?></b></h3>
              </div><hr>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-12 mb-60" style="text-align: justify;" >
                    <?php if($page){ ?><?php echo $page[0]['pContent']; ?><?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php $this->load->view('footer/footer2'); ?>