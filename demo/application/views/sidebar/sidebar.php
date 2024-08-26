    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview menu-open">
          <a href="<?php echo base_url(); ?>Dashboard" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i><p> Dashboard</p>
          </a>
        </li>
        <?php if($_SESSION['customer'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Customer" class="nav-link">
            <i class="nav-icon fa fa-user"></i><p> Customer </p>
          </a>
        </li>
        <?php } if($_SESSION['product_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Product" class="nav-link">
            <i class="nav-icon fab fa-product-hunt"></i><p> Products </p>
          </a>
        </li>
        <?php } if($_SESSION['purchase_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Purchase" class="nav-link">
            <i class="nav-icon far fa-credit-card"></i><p> Purchases </p>
          </a>
        </li>
	    <?php } if($_SESSION['sales_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Sale" class="nav-link">
            <i class="nav-icon far fa-money-bill-alt"></i><p> Sales</p>
          </a>
        </li>
        <?php } if($_SESSION['return_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Return" class="nav-link">
            <i class="nav-icon fas fa-retweet"></i><p> Returns</p>
          </a>
        </li>
        <?php } if($_SESSION['quotation_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Quotation" class="nav-link">
            <i class="nav-icon fab fa-quora"></i> <p> Quotation</p>
          </a>
        </li>
        <?php } if($_SESSION['recipe_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>recipeList" class="nav-link">
            <i class="nav-icon fas fa-retweet"></i><p> Recipes</p>
          </a>
        </li>
        <?php } if($_SESSION['manufacturer_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Manufacturer" class="nav-link">
            <i class="nav-icon fas fa-retweet"></i><p> Manufacturers</p>
          </a>
        </li>
        <?php } if($_SESSION['delivery_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>delivery" class="nav-link">
            <i class="nav-icon fas fa-retweet"></i><p> Delivery</p>
          </a>
        </li>
        <?php } if($_SESSION['voucher_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Voucher" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i><p> Vouchers</p>
          </a>
        </li>
        <?php } if($_SESSION['salary_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>empPayment" class="nav-link">
            <i class="nav-icon fab fa-paypal"></i> <p> Salary</p>
          </a>
        </li>
        <?php } if($_SESSION['transfer_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>transAccount" class="nav-link">
            <i class="nav-icon fab fa-paypal"></i> <p> Balance Transfer</p>
          </a>
        </li>
	    <?php } if($_SESSION['users'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>uSetting" class="nav-link">
            <i class="nav-icon fas fa-users"></i><p> Users</p>
          </a>
        </li>
	    <?php } if($_SESSION['report'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>uReport" class="nav-link">
            <i class="nav-icon far fa-flag"></i><p> Reports</p>
          </a>
        </li>
	    <?php } if($_SESSION['setting'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Setting" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i><p> Settings</p>
          </a>
        </li>
        <?php } if($_SESSION['accessetup'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>userAccess" class="nav-link">
            <i class="nav-icon fas fa-cog"></i><p> Access Setup</p>
          </a>
        </li>
        <?php } ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Login/logout" class="nav-link">
            <i class="nav-icon far fa-arrow-alt-circle-left"></i><p> Logout</p>
          </a>
        </li>
      </ul>
    </nav>