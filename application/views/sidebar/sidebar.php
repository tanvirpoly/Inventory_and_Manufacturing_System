    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview menu-open">
          <a href="<?php echo base_url(); ?>Dashboard" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Dashboard'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i><p> Dashboard</p>
          </a>
        </li>
        
        
        <?php if($_SESSION['customer'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Customer" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Customer'){ ?>active<?php } ?>">
            <i class="nav-icon fa fa-user"></i><p> Customer </p>
          </a>
        </li>
        
        <?php } if($_SESSION['product_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Product" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Product' || $_SERVER['REQUEST_URI'] == '/newProduct'){ ?>active<?php } ?>">
            <i class="nav-icon fab fa-product-hunt"></i><p> Products </p>
          </a>
        </li>
        
        <?php } if($_SESSION['purchase_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Purchase" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Purchase' || $_SERVER['REQUEST_URI'] == '/newPurchase'){ ?>active<?php } ?>">
            <i class="nav-icon far fa-credit-card"></i><p> Purchases </p>
          </a>
        </li>
        
	    <?php } if($_SESSION['sales_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Sale" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Sale' || $_SERVER['REQUEST_URI'] == '/newSale'){ ?>active<?php } ?>">
            <i class="nav-icon far fa-money-bill-alt"></i><p> Sales</p>
          </a>
        </li>
        
       
       
        
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Damage" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Damage'){ ?>active<?php } ?>">
            <i class="nav-icon fa fa-recycle"></i><p> Damage Product</p>
          </a>
        </li>
        
        
        
        <?php } if($_SESSION['return_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Return" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Return' || $_SERVER['REQUEST_URI'] == '/newReturn'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-retweet"></i><p> Returns</p>
          </a>
        </li>
        
        <?php } if($_SESSION['quotation_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Quotation" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Quotation' || $_SERVER['REQUEST_URI'] == '/newQuotation'){ ?>active<?php } ?>">
            <i class="nav-icon fab fa-quora"></i> <p> Quotation</p>
          </a>
        </li>
        
        <?php } if($_SESSION['recipe_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>recipeList" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/recipeList' || $_SERVER['REQUEST_URI'] == '/newRecipe'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-retweet"></i><p> Recipes</p>
          </a>
        </li>
        <?php } if($_SESSION['manufacturer_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Manufacturer" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Manufacturer' || $_SERVER['REQUEST_URI'] == '/newManufacturer'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-retweet"></i><p> Manufacturers</p>
          </a>
        </li>
        
        
     
        
        <?php } if($_SESSION['delivery_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>delivery" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/delivery' || $_SERVER['REQUEST_URI'] == '/newDelivery'){ ?>active<?php } ?>">
            <i class="nav-icon fa fa-truck"></i><p> Delivery</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>ptransfer" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/ptransfer'){ ?>active<?php } ?>">
            <i class="nav-icon fa fa-recycle"></i><p> Product Transfer</p>
          </a>
        </li>
        
        <?php } if($_SESSION['voucher_list'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Voucher" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Voucher' || $_SERVER['REQUEST_URI'] == '/newVoucher'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-tasks"></i><p> Vouchers</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>comPad" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/comPad'){ ?>active<?php } ?>">
            <i class="nav-icon fa fa-wallet"></i> <p> Company Pad</p>
          </a>
        </li>
        
        <?php } if($_SESSION['salary_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>empPayment" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/empPayment' || $_SERVER['REQUEST_URI'] == '/newempPayment'){ ?>active<?php } ?>">
            <i class="nav-icon fa fa-wallet"></i> <p> Salary</p>
          </a>
        </li>
        
        <?php } if($_SESSION['transfer_list'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>transAccount" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/transAccount'){ ?>active<?php } ?>">
            <i class="nav-icon fab fa-paypal"></i> <p> Balance Transfer</p>
          </a>
        </li>
	    <?php } if($_SESSION['users'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>uSetting" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/uSetting'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-users"></i><p> Users</p>
          </a>
        </li>
	    <?php } if($_SESSION['report'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>uReport" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/uReport' || $_SERVER['REQUEST_URI'] == '/saleReport' || $_SERVER['REQUEST_URI'] == '/purchaseReport' || $_SERVER['REQUEST_URI'] == '/profil-Loss' || $_SERVER['REQUEST_URI'] == '/cusReport' || $_SERVER['REQUEST_URI'] == '/cusLedger' || $_SERVER['REQUEST_URI'] == '/supplierReport' || $_SERVER['REQUEST_URI'] == '/supplierLedger' || $_SERVER['REQUEST_URI'] == '/stockReport' || $_SERVER['REQUEST_URI'] == '/rawDistReport' || $_SERVER['REQUEST_URI'] == '/rawstockReport' || $_SERVER['REQUEST_URI'] == '/finishstockReport' || $_SERVER['REQUEST_URI'] == '/vReports' || $_SERVER['REQUEST_URI'] == '/dReport' || $_SERVER['REQUEST_URI'] == '/cashReport' || $_SERVER['REQUEST_URI'] == '/bankReport' || $_SERVER['REQUEST_URI'] == '/mobileReport' || $_SERVER['REQUEST_URI'] == '/orderReport' || $_SERVER['REQUEST_URI'] == '/salesiReport' || $_SERVER['REQUEST_URI'] == '/salesdReport' || $_SERVER['REQUEST_URI'] == '/tsProduct' || $_SERVER['REQUEST_URI'] == '/lowStock' || $_SERVER['REQUEST_URI'] == '/bankTReport' || $_SERVER['REQUEST_URI'] == '/costReport' || $_SERVER['REQUEST_URI'] == '/salepReport' || $_SERVER['REQUEST_URI'] == '/salevReport' || $_SERVER['REQUEST_URI'] == '/saleProduct' || $_SERVER['REQUEST_URI'] == '/deliveryProduct' || $_SERVER['REQUEST_URI'] == '/pdivReport' || $_SERVER['REQUEST_URI'] == '/trialBalance' || $_SERVER['REQUEST_URI'] == '/balanceSheet' || $_SERVER['REQUEST_URI'] == '/cashFlow' || $_SERVER['REQUEST_URI'] == '/incomeStatement'){ ?>active<?php } ?>">
            <i class="nav-icon far fa-flag"></i><p> Reports</p>
          </a>
        </li>
	    <?php } if($_SESSION['setting'] == '1') { ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Setting" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/Setting' || $_SERVER['REQUEST_URI'] == '/Category' || $_SERVER['REQUEST_URI'] == '/Unit' || $_SERVER['REQUEST_URI'] == '/Expense' || $_SERVER['REQUEST_URI'] == '/Department' || $_SERVER['REQUEST_URI'] == '/mDept' || $_SERVER['REQUEST_URI'] == '/BankAccount' || $_SERVER['REQUEST_URI'] == '/MobileAccount' || $_SERVER['REQUEST_URI'] == '/uRole'){ ?>active<?php } ?>">
            <i class="nav-icon fas fa-cogs"></i><p> Settings</p>
          </a>
        </li>
        <?php } if($_SESSION['accessetup'] == '1') { ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>userAccess" class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/userAccess'){ ?>active<?php } ?>">
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