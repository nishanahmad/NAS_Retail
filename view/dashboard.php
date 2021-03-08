<?php
namespace Phppot;

use \Phppot\Member;
use \Phppot\Order;

session_start();
if (! empty($_SESSION["userId"]))
{
    require '../class/Member.php';
	require '../class/Order.php';
    
	$member = new Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if(!empty($memberResult[0]["display_name"]))
        $displayName = ucwords($memberResult[0]["display_name"]);
	else
        $displayName = $memberResult[0]["user_name"];
		
	$order = new Order();	
	$orderList = $order->getOrders($_SESSION["userId"]);
	
	$products = $order->getProducts();
	$godowns = $order->getGodowns();
}
?>
<html>
<head>
<title>Order List</title>
<link href="style.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous"/>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/742221945b.js" crossorigin="anonymous"></script>
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
</style>
</head>
<body>
    <div>
        <div class="dashboard">
			<div id="snackbar"><i class="fa fa-bolt"></i>&nbsp;&nbsp;Order sent successfully !!!</div>
            <div class="member-dashboard"><a href="#" class="btn btn-sm" role="button" style="background-color:#54698D;color:white;float:right;margin-right:3%;" data-toggle="modal" data-target="#saleModal"><i class="fa fa-bolt"></i> New Sale</a><br>
                Click to <a href="../logout.php" class="logout-button">Logout</a>
            </div>
        </div>
    </div>
	<table class="maintable table table-hover table-bordered" style="width:95%;margin-left:2%;">
		<thead>
			<tr class="table-success">
				<th style="min-width:110px;"><i class="far fa-calendar-alt"></i> Date</th>
				<th style="width:70px;"><i class="fa fa-shield"></i> PRO</th>
				<th style="width:70px;"><i class="fab fa-buffer"></i> QTY</th>
				<th style="width:180px;"><i class="far fa-user"></i> CUSTOMER</th>
				<th><i class="fas fa-map-marker-alt"></i> ADDRESS</th>
				<th><i class="far fa-comment-dots"></i> REMARKS</th>
				<th style="width:120px;"><i class="far fa-file-alt"></i> BILL NO</th>
			</tr>	
		</thead>
		<tbody>	<?php
			if(isset($orderList))
			{
				foreach($orderList as $order) 
				{																																				?>	
					<tr>
						<td><?php echo date('d-m-Y',strtotime($order['entry_date'])); ?></td>
						<td><?php if($order['product'] == 1) echo 'ACC SURAKSHA';if($order['product'] == 6) echo 'CONCRETE+'?></td>
						<td><?php echo $order['qty']; ?></td>
						<td><?php echo $order['customer_name'].'<br/><font>'.$order['customer_phone'].'</font>'; ?></td>
						<td><?php echo $order['address1']; ?></td>
						<td><?php echo $order['remarks']; ?></td>
						<td><?php echo $order['bill_no']; ?></td>
					</tr>																																		<?php				
				}																																								
			}																																				?>
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
					<div class="col-sm-6 col-md-5 offset-1">
						<div class="input-group mb-3">
							<span class="input-group-text col-md-5"><i class="fab fa-buffer"></i>&nbsp;Qty</span>
							<input type="text" name="qty" id="qty" required class="form-control" pattern="[0-9]+" title="Input a valid number">
						</div>
					</div>
					<div class="col-sm-6 col-md-5 offset-1">
						<div class="input-group mb-3">
							<span class="input-group-text"><i class="far fa-user"></i></i>&nbsp;Customer</span>
							<input type="text" name="customerName" id="customer" class="form-control">
						</div>
					</div>
					<div class="col-sm-6 col-md-5 offset-1">
						<div class="input-group mb-3">
							<span class="input-group-text" style="width:40%"><i class="fas fa-mobile-alt"></i>&nbsp;Phone</span>
							<input type="text" name="customerPhone" id="phone" class="form-control">
						</div>
					</div>
					<div class="col-sm-6 col-md-6 offset-1">
						<div class="input-group mb-3">
							<span class="input-group-text col-md-4"><i class="fas fa-map-marker-alt"></i>&nbsp;Address</span>
							<textarea name="address1" id="address1" class="form-control" rows="3"></textarea>
						</div>
					</div>
					<div class="col-sm-6 col-md-5 offset-1">
						<div class="input-group mb-3">
							<span class="input-group-text" style="width:40%"><i class="fas fa-warehouse"></i></i>&nbsp;Godown</span>
							<select name="godown" id="godown" class="form-control" style="width:60%">
								<option value = "">---Select---</option>																						<?php
								foreach($godowns as $godown) 
								{																							?>
									<option value="<?php echo $godown['id'];?>"><?php echo $godown['name'];?></option>			<?php	
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
});
</script>	
</html>