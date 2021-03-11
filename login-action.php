<?php
namespace Phppot;

use \Phppot\Member;
if (! empty($_POST["login"])) {
    session_start();
    $username = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    require 'class/Member.php';
    
    $member = new Member();
    $isLoggedIn = $member->processLogin($username, $password);
    if (! $isLoggedIn)
        $_SESSION["errorMessage"] = "Invalid Credentials";
	else
		echo('valid cred');
    
	//header("Location: index.php");
    exit();
}