<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-lg-6 col-md-6  col-sm-6">
					<h1>Returns</h1>
				</div>
				<div class="col-lg-6 col-md-6  col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
						<li class="breadcrumb-item active">Return</li>
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
							<h3 class="card-title">Return Information</h3>
						</div>

						<div class="card-body">
							<div class="invoice p-3 mb-3">
								<div id="print">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12 invoice-col">
											<h4>
												<?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>"
													style="height:50px; width:auto;"><?php } ?>
												<!-- <small class="float-right">Print Date : <?php echo date('d-m-Y'); ?></small> -->
											</h4>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-6 invoice-col text-center">
											<?php if($company){ ?><h3><b><?php echo $company->com_name; ?></b></h3><?php } ?>
											<?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
											<?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-6 invoice-col text-center">
											<h3><b>RETURN INVOICE</b></h3>
											<!-- <?php echo var_dump($returns); ?> -->
											<table class="table table-striped table-bordered">
												<tbody>
													<tr style="line-height: 6px !important;">
														<td>Invoice</td>
														<td><?php echo $returns['rid']; ?></td>
													</tr>
													<tr style="line-height: 6px !important;">
														<td>Return Date</td>
														<td><?php echo date('d-m-Y', strtotime($returns['returnDate'])); ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6 col-md-12 col-sm-12 invoice-col">
											<h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>BILL FROM</b></h3>
											<table class="table table-striped table-bordered">
												<tbody>
													<tr style="line-height: 6px !important;">
														<td>Name</td>
														<td><?php if($company){ ?><b><?php echo $company->com_name; ?></b><?php } ?></td>
													</tr>
													<tr style="line-height: 6px !important;">
														<td>Mobile</td>
														<td><?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?></td>
													</tr>
													<tr style="line-height: 6px !important;">
														<td>Address</td>
														<td><?php if($company){ ?><?php echo $company->com_address; ?><?php } ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12 invoice-col">
											<h3 style="background: #183B6A; color: #fff; padding: 5px;"><b>BILL TO</b></h3>
											<table class="table table-striped table-bordered">
												<tbody>
													<tr style="line-height: 6px !important;">
														<td>Customer</td>
														<td><?php echo $returns['customerName']; ?></td>
													</tr>
													<tr style="line-height: 6px !important;">
														<td>Mobile</td>
														<td><?php echo $returns['mobile']; ?></td>
													</tr>
													<tr style="line-height: 6px !important;">
														<td>Address</td>
														<td><?php echo $returns['address']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="row">
										<div class="col-12 table-responsive">
											<table class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>SN</th>
														<th style="text-align: left;">PRODUCT NAME</th>
														<th style="text-align: left;">QUANTITY</th>
														<th style="text-align: left;">UNIT PRICE</th>
														<th style="text-align: left;">AMOUNT</th>
													</tr>
												</thead>
												<tbody>
													<?php
                            $i = 0;
                            $tq = 0;
                            $stotal = 0;
                            foreach ($rproduct as $value){
                            $i++;
                            ?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo $value['productName'].' ( '.$value['productcode'].' )'; ?></td>
														<td><?php echo round($value['quantity']); $tq += $value['quantity']; ?></td>
														<td><?php echo number_format($value['salePrice'], 2);; ?></td>
														<td><?php echo number_format($value['totalPrice'], 2); $stotal += $value['totalPrice']; ?>
														</td>
													</tr>
													<?php } ?>
												</tbody>
												<tbody>
													<tr>
														<td colspan="3">
															<!-- <?php echo $returns['terms']; ?> -->
														</td>
														<td colspan="2">
															<table class="table table-striped">
																<tr>
																	<td align="right">Sub Total </td>
																	<td><?php echo number_format($stotal, 2); ?></td>
																</tr>
																<tr>
																	<td align="right">Service Charge
																		<?php if($returns['sctype'] == '%') { ?>(<?php echo $returns['scharge']; ?>)<?php } ?>
																	</td>
																	<td><?php echo number_format($returns['scAmount'], 2); ?></td>
																</tr>
																<!-- <tr>
																	<td align="right">VAT Amount
																		<?php if($returns['vType'] == '%') { ?>(<?php echo $returns['vCost']; ?>)<?php } ?>
																	</td>
																	<td><?php echo number_format($returns['vAmount'], 2); ?></td>
																</tr> -->
																<!-- <tr>
																	<td align="right">Discount
																		<?php if($returns['discountType'] == '%') { ?>(<?php echo $returns['discount']; ?>)<?php } ?>
																	</td>
																	<td><?php echo number_format($returns['discountAmount'], 2); ?></td>
																</tr> -->
																<!-- <tr>
																	<td align="right">Payable Amount </td>
																	<td>
																		<?php echo number_format((($stotal+$returns['sCost']+$returns['vAmount'])-$returns['discountAmount']), 2); ?>
																	</td>
																</tr> -->
																<tr style="font-size:1.5rem; font-weight:bold;">
																	<td align="right">Paid Amount</td>
																	<td><?php echo number_format($returns['paidAmount'], 2); ?></td>
																</tr>
																<!-- <tr>
																	<td style="color: red;" align="right">Due Amount </td>
																	<td style="color: red;">
																		<?php echo number_format(($stotal+$returns['sCost']+$returns['vAmount'])-($returns['discountAmount']+$returns['paidAmount']), 2); ?>
																	</td>
																</tr> -->
															</table>
														</td>
													</tr>
												</tbody>
												<!--<tbody>-->
												<!--  <tr>-->
												<!--    <td colspan="4" align="right">Previous Due</td>-->
												<!--    <td>-->
												<!--      <?php $pd = ($csdue->total-($cvpa->total+$cra->total)); ?>-->
												<!--      <?php echo number_format($pd, 2); ?>-->
												<!--    </td>-->
												<!--  </tr>-->
												<!--  <tr>-->
												<!--    <td colspan="4" align="right">Total Due</td>-->
												<!--    <td><?php echo number_format(($pd+$returns['dueamount']), 2); ?></td>-->
												<!--  </tr>-->
												<!--</tbody>-->
												<tbody style="text-align: left;">
													<tr>
														<?php $twa = round(abs($returns['paidAmount'])); ?>
														<td colspan="5">( IN WORDS&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumber($twa); ?> )</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<?php if($returns['note'] != null){ ?>
									<div class="row">
										<p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
										<p class="lead"><?php echo $returns['note']; ?></p>
									</div>
									<?php } ?>

								</div>
                    <!-- POS Print Setup -->
								<div id="pprint" class="d-none">
									<div class="row">
										<div class="col-12">
											<h4>
												<?php if($company){ ?><img src="<?php echo base_url().'upload/company/'.$company->com_logo; ?>"
													style="height:50px; width:auto;">&nbsp;&nbsp;<?php echo $company->com_name; ?><?php } ?>
											</h4>
											<address>
												<?php if($company){ ?><?php echo $company->com_address; ?><?php } ?><br>
												Phone : <?php if($company){ ?><?php echo $company->com_mobile; ?><?php } ?><br>
												Email : <?php if($company){ ?><?php echo $company->com_email; ?><?php } ?>
											</address>
										</div>
									</div>
									<div class="row invoice-info">
										<div class="col-sm-6 col-12 invoice-col">
											<b>Returns Date :</b> <?php echo date('d-m-Y', strtotime($returns['returnDate'])); ?><br>
											<b>Invoice No. # <?php echo $returns['rid']; ?></b><br>
											<b>Payment Mode :</b> <?php echo $returns['accountType']; ?>
										</div>
										<div class="col-sm-6 col-12 invoice-col">
											<address>
												Customer : <?php echo $returns['customerName'].' ( '.$returns['cus_id'].' )'; ?><br>
												Phone : <?php echo $returns['mobile']; ?><br>
												Address : <?php echo $returns['address']; ?><br>
											</address>
										</div>
									</div>

									<div class="row invoice-info">
										<div class="col-12 invoice-col">
											<table class="table">
												<thead>
													<tr>
														<th style="width:15%;">Product</th>
														<th style="width:5%;">Qnt.</th>
														<th style="width:10%;">Unit</th>
														<th style="width:60%;">Total</th>
													</tr>
												</thead>
												<tbody>
													<?php
                            $tq = 0;
                            $stotal = 0;
                            foreach ($rproduct as $value){
                            ?>
													<tr>
														<td><?php echo $value['productName']; ?></td>
														<td><?php echo round($value['quantity']); $tq += $value['quantity']; ?></td>
														<td><?php echo number_format($value['salePrice'], 2);; ?></td>
														<td><?php echo number_format($value['totalPrice'], 2); $stotal += $value['totalPrice']; ?>
														</td>
													</tr>
													<?php } ?>
												</tbody>
												<tbody>
													<tr>
														<td colspan="3" style="text-align: center;">Total Amount</td>
														<td><?php echo number_format($stotal, 2); ?></td>
													</tr>
													<!-- <tr>
														<td colspan="3" style="text-align: center;">Discount
															<?php if($returns['discountType'] == '%') { ?>(<?php echo $returns['discount']; ?>)<?php } ?>
														</td>
														<td><?php echo number_format($returns['discountAmount'], 2); ?></td>
													</tr> -->
													<!-- <tr>
														<td colspan="3" style="text-align: center;">Payable Amount </td>
														<td><?php echo number_format(($stotal-$returns['discountAmount']), 2); ?></td>
													</tr>
													<tr> -->
														<td colspan="3" style="text-align: center;">Paid Amount</td>
														<td><?php echo number_format($returns['paidAmount'], 2); ?></td>
													</tr>
													<!-- <tr>
														<td colspan="3" style="text-align: center;">Due Amount </td>
														<td><?php echo number_format($returns['dueamount'], 2); ?></td>
													</tr> -->
												</tbody>
												<tbody>
													<!-- <tr>
														<td colspan="3" style="text-align: center;">Previous Due</td>
														<td>
															<?php $pd = ($csdue->total-($cvpa->total+$cra->total)); ?>
															<?php echo number_format($pd, 2); ?>
														</td>
													</tr> -->
													<!-- <tr>
														<td colspan="3" style="text-align: center;">Total Due</td>
														<td><?php echo number_format(($pd+$returns['dueamount']), 2); ?></td>
													</tr> -->
												</tbody>
												<tbody>
													<tr>
														<?php $twa = round(abs($returns['paidAmount'])); ?>
														<td colspan="4">( In Words&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo convertNumber($twa); ?> )</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<?php if($returns['note'] != null){ ?>
									<div class="row">
										<p class="lead">Note / Remarks&nbsp;:&nbsp;</p>
										<p class="lead"><?php echo $returns['note']; ?></p>
									</div>
									<?php } ?>
								</div>

								<div class="row no-print">
									<div class="col-12" style="text-align: center;">
										<a href="javascript:void(0)" class="btn btn-primary" onclick="printpDiv('pprint')"><i
												class="fas fa-print"></i> POS Print</a>
										<a href="javascript:void(0)" class="btn btn-primary" onclick="printDiv('print')"><i
												class="fas fa-print"></i> General Print</a>
										<a href="<?php echo site_url('Return') ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
											Back</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php $this->load->view('footer/footer'); ?>

<?php
      function convertNumber($number){
        $words = array(
          '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty');
    
        $number_length = strlen($number);

        $number_array = array(0,0,0,0,0,0,0,0,0);        
        $received_number_array = array();
    
        for($i=0;$i<$number_length;$i++)
          {    
          $received_number_array[$i] = substr($number,$i,1);    
          }
        
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++)
          { 
          $number_array[$i] = $received_number_array[$j]; 
          }
        $number_to_words_string = "";

        for($i=0,$j=1;$i<9;$i++,$j++)
          {
          if($i==0 || $i==2 || $i==4 || $i==7)
            {
            if($number_array[$j]==0 || $number_array[$i] == "1")
              {
              $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
              $number_array[$i] = 0;
              }
            }
          }
        $value = "";
        for($i=0;$i<9;$i++)
          {
          if($i==0 || $i==2 || $i==4 || $i==7)
            {    
            $value = $number_array[$i]*10; 
            }
          else
            { 
            $value = $number_array[$i];    
            }            
          if($value!=0)
            {
            $number_to_words_string.= $words["$value"]." ";
            }
          if($i==1 && $value!=0)
            {
            $number_to_words_string.= "Crores ";
            }
          if($i==3 && $value!=0)
            {
            $number_to_words_string.= "Lakhs ";
            }
          if($i==5 && $value!=0)
            {
            $number_to_words_string.= "Thousand ";
            }
          if($i==6 && $value!=0)
            {
            $number_to_words_string.= "Hundred ";
            }            
          }
        if($number_length>9)
          {
          $number_to_words_string = "Sorry This does not support more than 99 Crores";
          }
        return ucwords(strtolower($number_to_words_string)." Taka Only.");
        }
    ?>

<script type="text/javascript">
	function printpDiv(divName) {
		$('#pprint').show();
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}

</script>
