<?php 
	require_once('../config/config.php');
	require_once('../includes/functions.php');

	function __autoload($class_name) {
		include '../includes/'.$class_name . '.php';
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$postman = new PostManager(array());
		$data = array('uname' => $_POST['uname'], 'pass' => $_POST['pass']);
		$value = $postman->mobileLogin($_POST);
		
		// var_dump($_SESSION);
		echo json_encode($value);
	}
	
	if(isset($_GET['uname'])) {
		$postman = new PostManager(array());
		$data = array('mobilelogin' => 1, 'uname' => $_GET['uname'], 'pass' => $_GET['pass']);
		return json_encode("test");
		// return json_encode($postman->mobileLogin($data));
	}

	// return true;




?>