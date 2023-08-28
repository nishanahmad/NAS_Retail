<?php
session_start();
if(!empty($_SESSION["userId"])) 
{
	if(isset($_GET['error']))
	{
		$error = $_GET['error'];
		header("Location:view/dashboard.php?error=$error");
	}
	else
	{
		header("Location:view/dashboard.php?");
	}
		
} 
else
{
	header("Location:view/login-form.php");
}																																	?>