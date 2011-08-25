<?php
	require_once('../config/config.php');
	require_once('../includes/functions.php');

	function __autoload($class_name) {
		include '../includes/'.$class_name . '.php';
	}
	if(isset($_GET['cookiereset'])){
		$data = array('cookiereset' => 1);
		$postman = new PostManager($data);
	}
	
/*	if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
			if(isset($_SESSION['cookie'])) {
			}else {
				if($_COOKIE['username'] == "" && $_COOKIE['username'] == "") {
				}else {
					$data = array('cookielogin' => 1);
					$postman = new PostManager($data);
				
			}
		}
	}
	*/
	if(isset($_GET['view'])) {
		$view = $_GET['view'];
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$postman = new PostManager($_POST);
	}
	
	if(isLoggedIn()) {
		if ($view == 'stats'){
			$page = file_get_contents('stats.html');
		}elseif ($view == 'add'){
			$page = file_get_contents('add.html');
		}elseif ($view == 'events'){
			$page = file_get_contents('events.html');
		}elseif ($view == 'mystats'){
			$page = file_get_contents('mystats.html');
		}elseif ($view == 'groupstats'){
			$page = file_get_contents('groupstats.html');
		}elseif ($view == 'stars'){
			$page = file_get_contents('stars.html');
		}else {
			$page = file_get_contents('index.html');
		}
	} else {
		$page = file_get_contents('login.php');		
	}
	
	echo $page;
