<?php
namespace Phppot;

ini_set('display_errors', 1);
error_reporting(E_ALL);

use \Phppot\Order;

session_start();
if (! empty($_SESSION["userId"])) 
{
	require 'class/Order.php';

	$order = new Order();	

	$id = $_POST['orderId'];
	echo $id;
		
	$order->deleteOrder($id);
	
	if($order)	
		header("Location: index.php?success");
	else
		header("Location: index.php?error=bill");
}
?>