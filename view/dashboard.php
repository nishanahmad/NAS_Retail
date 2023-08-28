<?php
namespace Phppot;

use \Phppot\Order;

session_start();
if (! empty($_SESSION["userId"]))
{
	require '../class/Order.php';
	require 'navbar.php';
    		
	$order = new Order();	
	$orderList = $order->getOrders($_SESSION["userId"]);
	
	$products = $order->getProducts();
	$godowns = $order->getGodowns();
	$trucks = $order->getTrucks();

	function statusCheck($bill)
	{
		if( fnmatch("B*",$bill) || fnmatch("C*",$bill) || fnmatch("D*",$bill) || fnmatch("GB*",$bill) || fnmatch("GC*",$bill) || fnmatch("PB*",$bill) || fnmatch("PC*",$bill) || fnmatch("TRF*",$bill))
			return 'Billed';
		else	
			return 'Pending';
			
	}																																																			?>
	<html>
	<head>
	<title>Order List</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
	<style>
	#snackbar {
	  visibility: hidden;
	  min-width: 250px;
	  margin-left: -125px;
	  background-color: #04844b;
	  color: #fff;
	  text-align: center;
	  border-radius: 2px;
	  padding: 16px;
	  position: fixed;
	  z-index: 1;
	  left: 50%;
	  bottom: 30px;
	  font-size: 17px;
	}

	#snackbar.show {
	  visibility: visible;
	  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
	  animation: fadein 0.5s, fadeout 0.5s 2.5s;
	}
	#country-list{list-style:none;margin-top:-3px;margin-left:120px;padding:0;width:190px;}
	#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
	#phone{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
	</style>
	</head>
	<body>
		<div>
			<br/><br/>
			<div id="snackbar"><i class="fa fa-bolt"></i>&nbsp;&nbsp;Order sent successfully !!!</div>
			<a href="#" class="btn btn-sm" role="button" style="background-color:#54698D;color:white;margin-left:45%" data-toggle="modal" data-target="#saleModal"><i class="fa fa-bolt"></i> New Order</a><br>
			<br/><br/>
		</div>
		<table class="maintable table table-hover table-bordered" style="width:95%;margin-left:2%;">
			<thead>
				<tr class="table-success">
					<th style="min-width:110px;"><i class="far fa-calendar-alt"></i> Date</th>
					<th style="width:70px;"><i class="fa fa-shield"></i> Product</th>
					<th style="width:180px;"><i class="far fa-user"></i> Customer</th>
					<th><i class="fas fa-map-marker-alt"></i> Address</th>
					<th><i class="far fa-comment-dots"></i>Remarks</th>
					<th><i class="fa fa-truck-moving"></i>Truck & Godown</th>
					<th></i>Driver</th>
					<th style="width:120px;"><i class="far fa-file-alt"></i> Status</th>
				</tr>	
			</thead>
			<tbody>	<?php
				if(isset($orderList))
				{
					foreach($orderList as $order) 
					{																																				?>	
						<tr>
							<td><?php echo date('d-m-Y',strtotime($order['entry_date'])); ?></td>
							<td><?php if($order['product'] == 1) echo 'ACC SURAKSHA';if($order['product'] == 6) echo 'CONCRETE+'?></br/>
									<?php echo $order['qty'].' bags'; ?>
							</td>
							<td><?php echo $order['customer_name'].'<br/><font>'.$order['customer_phone'].'</font>'; ?></td>
							<td><?php echo $order['address1']; ?></td>
							<td><?php echo $order['remarks']; ?></td>
							<td><?php if($order['truck'] > 0) echo $trucks[$order['truck']].'<br/>';
									  if($order['godown'] > 0) echo $godowns[$order['godown']]; ?></td>
							<td><?php echo $order['driver_name'].'<br/>'.$order['driver_phone'];?></td>									  
							<td><?php echo statusCheck($order['bill_no']); ?><br/>																						<?php 
								if(statusCheck($order['bill_no']) == 'Pending')
								{																																		?>
									<form name="deleteForm" id="deleteForm" method="post" action="../delete.php">
										<input hidden name="orderId" value="<?php echo $order['sales_id'];?>"/><br/>
										<button id="deleteBtn" class="btn" type="submit" onclick="return confirm('Are you sure you want to cancel this order?');" style="width:80px;font-size:12px;background-color:#54698D;color:white;">Cancel</button>
									</form>																																<?php
								}																																		?>
							</td>
						</tr>																																			<?php				
					}																																								
				}																																						?>
			</tbody>	
		</table>
		<br/><br/><br/>
	</div>	
		<div class="modal fade" id="saleModal">
		  <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
			<div class="modal-content">
				<div class="modal-header" style="background-color:#54698D;color:white">
					<h4 class="modal-title"><i class="fa fa-bolt"></i>&nbsp;&nbsp;New Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<br/>
					<p id="insertError" style="color:red;"></p>
					<form name="newSaleForm" id="newSaleForm" method="post" action="../insert.php">
						<div class="col-sm-6 col-md-5 offset-1">
							<div class="input-group mb-3">
								<span class="input-group-text col-md-5 col-xs-3"><i class="far fa-calendar-alt"></i>&nbsp;Date</span>
								<input type="text" id="date" class="form-control datepicker" name="date" required value="<?php echo date('d-m-Y'); ?>" autocomplete="off"/>
							</div>
						</div>
						<div class="col-sm-6 col-md-5 offset-1">
							<div class="input-group mb-3">
								<span class="input-group-text col-md-5"><i class="fa fa-shield"></i>&nbsp;Product</span>
								<select name="product" id="product" required class="form-control">
									<option value="1">ACC SURAKSHA</option>
									<option value="6">CONCRETE+</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 offset-1">
							<div class="input-group mb-3">
								<span class="input-group-text col-md-4"><i class="fab fa-buffer"></i>&nbsp;Qty</span>
								<input type="text" name="qty" id="qty" required class="form-control" pattern="[0-9]+" title="Input a valid number">
								&nbsp;&nbsp;
								<input class="form-check-input" type="checkbox" id="ar_direct" name="ar_direct">&nbsp;Shop Direct
							</div>
						</div>
						<div class="col-sm-6 col-md-5 offset-1 customerDetail">
							<div class="input-group mb-3">
								<span class="input-group-text" style="width:40%"><i class="fas fa-mobile-alt"></i>&nbsp;Phone</span>
								<input type="text" name="customerPhone" id="phone" class="form-control" autocomplete="off">
								<div id="suggesstion-box"></div>
							</div>
						</div>
						<div class="col-sm-6 col-md-5 offset-1 customerDetail">
							<div class="input-group mb-3">
								<span class="input-group-text" style="width:40%"><i class="far fa-user"></i></i>&nbsp;Customer</span>
								<input type="text" name="customerName" id="customer" class="form-control">
							</div>
						</div>					
						<div class="col-sm-6 col-md-6 offset-1 customerDetail">
							<div class="input-group mb-3">
								<span class="input-group-text col-md-4"><i class="fas fa-map-marker-alt"></i>&nbsp;Address</span>
								<textarea name="address1" id="address1" class="form-control" rows="3"></textarea>
							</div>
						</div>
						<div class="col-sm-6 col-md-5 offset-1 customerDetail">
							<div class="input-group mb-3">
								<span class="input-group-text" style="width:40%"><i class="fas fa-map-marker-alt"></i></i>&nbsp;PIN</span>
								<input type="text" name="pin" id="pin" class="form-control">
							</div>
						</div>										
						<div class="col-sm-6 col-md-5 offset-1">
							<div class="input-group mb-3">
								<span class="input-group-text" style="width:40%"><i class="fas fa-warehouse"></i></i>&nbsp;Godown</span>
								<select name="godown" id="godown" class="form-control" style="width:60%">
									<option value = "">---Select---</option>																						<?php
									foreach($godowns as $id => $name) 
									{																							?>
										<option value="<?php echo $id;?>"><?php echo $name;?></option>							<?php	
									}																							?>
								</select>									
							</div>
						</div>
						<div class="col-sm-6 col-md-5 offset-1">
							<div class="input-group mb-3">
								<span class="input-group-text" style="width:40%"><i class="fa fa-truck-moving"></i>&nbsp;Truck</span>
								<select name="truck" id="truck" class="form-control" style="width:60%">
									<option value = "">---Select---</option>																						<?php
									foreach($trucks as $id => $number) 
									{																							?>
										<option value="<?php echo $id;?>"><?php echo $number;?></option>						<?php	
									}																							?>
								</select>									
							</div>
						</div>						
						<div class="col-sm-6 col-md-6 offset-1">
							<div class="input-group mb-3">
								<span class="input-group-text col-md-4"></i>&nbsp;Remarks</span>
								<textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col col-md-5 offset-5">
								<div class="input-group mb-3">
									<button id="saveNew" class="btn" style="width:100px;font-size:18px;background-color:#54698D;color:white;"><i class="fa fa-save"></i> Save</button>
								</div>
							</div>							
						</div>			
					</form>
					<br/>
				</div>				
			</div>
			<div class="modal-footer"></div>
		  </div>
		</div>																																						
	</body>
	<script>
	 $( document ).ready(function() {
		var pickeropts = { dateFormat:"dd-mm-yy"}; 
		$( "#date" ).datepicker(pickeropts);	

		if(window.location.href.includes('success')){
			var x = document.getElementById("snackbar");
			x.className = "show";
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
		}	
		
		$("#phone").keyup(function(){
			$.ajax({
				type: "POST",
				url: "../class/readPhone.php",
				data:'keyword='+$(this).val(),
				beforeSend: function(){
					$("#phone").css("background","#FFF no-repeat 165px");
				},
				success: function(data){
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#phone").css("background","#FFF");
				}
			});
		});		
		
		$("#ar_direct").click(function(){
			if($(this).is(":checked")) 
				$(".customerDetail").hide();
			else
				$(".customerDetail").show();
		});		
	});

	//To select country name
	function selectPhone(val) {
		$("#phone").val(val);
		$("#suggesstion-box").hide();
		
		var phone = $("#phone").val();
		console.log(phone);		
		$.ajax({
			type: "POST",
			url: "../class/customerAJAX.php",
			dataType: 'json',
			data:'phone='+phone,
			success: function(response){
				console.log(response);
				if(response.status == 'success'){
					$('#customer').val(response.customer_name);
					$('#address1').val(response.address);
				}			
			},
			error: function (jqXHR, exception) {
				var msg = '';
				if (jqXHR.status === 0) {
					msg = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
					msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
					msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
					msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
					msg = 'Time out error.';
				} else if (exception === 'abort') {
					msg = 'Ajax request aborted.';
				} else {
					msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				$("#displayError").text(msg);
				console.log(msg);
				return false;
			}				
		});	
	}
	</script>	
	</html>																																															<?php
}
else
	header("Location:../index.php");