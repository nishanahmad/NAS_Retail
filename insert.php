<?php
namespace Phppot;

ini_set('display_errors', 1);
error_reporting(E_ALL);

use \Phppot\Member;
use \Phppot\Order;

session_start();
if (! empty($_SESSION["userId"])) 
{
    require 'class/Member.php';
	require 'class/Order.php';

	$order = new Order();	
	$member = new Member();	

	$memberResult = $member->getMemberById($_SESSION["userId"]);

	$entry_date = date("Y-m-d", strtotime($_POST['date']));
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$ar_id = $_SESSION["userId"];
	$customer_name = $_POST['customerName'];
	$customer_phone = $_POST['customerPhone'];
	$address1 = $_POST['address1'];
	$pin = $_POST['pin'];
	$truck = $_POST['truck'];
	$remarks = $_POST['remarks'];
	$godown = $_POST['godown'];
	$entered_by = $memberResult[0]["user_name"];
	$entered_on = date('Y-m-d H:i:s');	
		
	$order->insertOrder($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$pin,$truck,$remarks,$godown,$entered_by,$entered_on);
	
	if($order > 0)	
		header("Location: index.php?success");
}
?>