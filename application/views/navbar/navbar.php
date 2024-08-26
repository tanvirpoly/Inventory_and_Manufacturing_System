<style>
    .brand-link{
        padding-bottom:2.5rem;
    }
</style>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
      
  <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if($_SESSION['role'] > 1){ ?>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url() ?>uNotice">
            <i class="far fa-bell"></i>
          </a>
        </li>
        
        
        
        
                <!--<li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">0</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">00 Notifications</span>
                  <div class="dropdown-divider"></div>
                   <a href="#" class="dropdown-item">
                     <i class="fas fa-envelope mr-2"></i>0 new messages
                 <span class="float-right text-muted text-sm">0 mins</span>
                   </a>
                  <div class="dropdown-divider"></div>
                   <a href="<?php echo base_url() ?>uNotice" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
                </li>-->
        
        
        
        
        <?php  } ?>
        
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#"><?= $_SESSION['name'] ?>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
          </a>
          
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              
            <a href="<?php echo base_url(); ?>myProfile" class="dropdown-item">
              My Profile
            </a>
            
        <?php if($_SESSION['company_setup'] == 1){ ?>
            <a href="<?php echo base_url(); ?>comProfile" class="dropdown-item">Company Profile</a>
            
            
            
        <?php } ?>
            <a href="<?php echo base_url(); ?>aSetting" class="dropdown-item">
              Password Change
            </a>
            
            <a href="<?php echo base_url(); ?>Login/logout" class="dropdown-item">
              Logout
            </a>
            
          </div>
          
        </li>
        
      </ul>
      
    </nav>
    
    
  <!-- /.navbar -->

      <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000;" >
      <a href="<?php echo base_url(); ?>Dashboard" class="brand-link">
        <img src="<?php echo base_url(); ?>upload/company/logo.png" alt="Logo" class="brand-image elevation-3" style="opacity: .8; width: 200px ">
        <!--<span class="brand-text font-weight-light"><?= $_SESSION['compname'] ?></span>-->
      </a>

      <div class="sidebar">
    <?php $this->load->view('sidebar/sidebar'); ?>
	  
      </div>
    </aside>