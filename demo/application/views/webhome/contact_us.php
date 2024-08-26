<?php $this->load->view('header/header2'); ?>
<?php $this->load->view('navbar/navbar2'); ?>

  <div class="content-wrapper">
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3>Contact Us</h3>
                <p>Learn about our company profile, communityimpact, sustainable motivation, and more.</p>
              </div><hr>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12 mb-60">
                    <div class="form-group">
                      <span><?= $store['sMobile']; ?></span><br>
                      <span><?= $store['sEmail']; ?></span><br>
                      <span><?= $store['sAddress']; ?></span>
                    </div>
                    <div class="form-group">
                      <ul class="ps-social">
                        <li><a href="<?php echo $store['sFacebook']; ?>"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php echo $store['sGoogle']; ?>"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="<?php echo $store['sTwitter']; ?>"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php echo $store['sInstagram']; ?>"><i class="fa fa-instagram"></i></a></li>
                      </ul>
                    </div> 
                  </div>
                  <div class="col-lg-6 col-md-6 col-12 mb-60">
                    <form action="<?php echo base_url('Webhome/save_notice_msg'); ?>" method="post">
                        <input class="form-control" type="hidden" name="sid" placeholder="Name" value="<?= $store['sid']; ?>" required >
                        <input class="form-control" type="hidden" name="sName" placeholder="Name" value="<?= $store['sName']; ?>" required >
                      <div class="form-group">
                        <label>Name<span>*</span></label>
                        <input class="form-control" type="text" name="ntype" placeholder="Name" required >
                      </div>
                      <div class="form-group">
                        <label>Email<span>*</span></label>
                        <input class="form-control" type="email" name="subject" placeholder="Email" required>
                      </div>
                      <div class="form-group">
                        <label>Your message<span>*</span></label>
                        <textarea class="form-control" rows="4" name="message" placeholder="message" required></textarea>
                      </div>
                      <div class="form-group text-center">
                        <button class="ps-btn">Send Message<i class="fa fa-angle-right"></i></button>
                      </div>
                    </form>
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