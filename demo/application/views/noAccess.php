<div class="content-wrapper" style="min-height: 1126px;">
   
    <div class="col-md-12">
        <span class="successMassage">
            <?php
            if ($this->session->flashdata('msg')) {
                echo $this->session->flashdata('msg');
            }
            ?>
        </span>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">No Access</h3>
           
        </div>
        <div class="box-body">
            <div id="table-content ">
               You are not able to view home page
               Please click here to <a href="<?php echo base_url('login/logout')?>">Logout</a>
            </div>
        </div>
    </div>
</div>
