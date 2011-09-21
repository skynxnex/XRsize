<?php
	session_start();
	
	require_once('config/config.php');
	require_once('includes/functions.php');
	
	if(ismobile()) {
		if($_SERVER['HTTP_HOST'] != 'localhost') {
			header('location: http://mobile.xrsize.me');
		}
		header('location: http://localhost/XRsize/mobile/');
	}
	
	function __autoload($class_name) {
		include 'includes/'.$class_name . '.php';
	}
	
	if(isset($_GET['cookiereset'])){
		$data = array('cookiereset' => 1);
		$postman = new PostManager($data);
	}
	if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
			if(isset($_SESSION['cookie'])) {
			}else {
				if($_COOKIE['username'] == "" && $_COOKIE['username'] == "") {
				}else {
					$data = array('cookielogin' => 1);
					$postman = new PostManager($data);
				
			}
		}
	}

	#remove the directory path we don't want 
	$request  = str_replace("/XRsize/", "", $_SERVER['REQUEST_URI']); 
	#split the path by '/'  
	$params     = explode("/", $request); 
	$values = array();
	$length = count($params);
	
	
	if($_SERVER['HTTP_HOST'] != 'localhost') {
		for($i = 1; $i <= $length; $i++) {
			$values[] = $params[$i];
		}
	} else {
		$values = $params;
	}
  	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$postman = new PostManager($_POST);
	}
		
	$log = null;
	if(isset($_SESSION['user'])) {
		$log = $_SESSION['user'];
	}
	
	$manager = new Manager($values, $log);
	$page = $manager->generatePage();
	
	echo $page;
	
	
