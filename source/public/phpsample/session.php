<?php
	session_start();
	$url = parse_url($_SERVER['HTTP_REFERER']);
	if($url['host'] !== 'localhost' || $_SESSION['login_user'] == '') 
	{
		header('location:login.php');
		exit;
	}
?>