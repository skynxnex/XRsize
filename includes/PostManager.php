<?php

class PostManager {

	private $db;
	private $postdata;
	private $url;
	private $query;

	public function __construct($data) {
		$this->db = new MysqlDB(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_BASE);
		$this->postdata = $data;
		$this->query = new Query();
		if($this->postdata['login']) {
			$this->doLogin();
		}elseif($this->postdata['cookielogin']) {
			$this->cookieLogin();
		}elseif($this->postdata['mobilelogin']) {
			$this->mobileLogin();
		}elseif($this->postdata['addevent']) {
			$this->addEvent();
		}elseif($this->postdata['editevent']) {
			$this->editEvent();
		}elseif($this->postdata['blogg']) {
			$this->addBloggEvent();
		}elseif($this->postdata['changepass']) {
			$this->changePass();
		}elseif($this->postdata['updateprofile']) {
			$this->updateProfile();
		}elseif($this->postdata['logout']) {
			$this->logout();
		}elseif($this->postdata['cookiereset'] == 1) {
			$this->cookiereset();
		}elseif($this->postdata['adduser']) {
			$this->addUser();
		}elseif($this->postdata['addeventtype']) {
			$this->addEventType();
		}
	}

	private function doLogin() {
		$this->db->toNull();
		$name = $this->postdata['uname'];
		$name = stripslashes($name);
		$pass = $this->postdata['pass'];
		$pass = stripslashes($pass);
		$this->db->where('user_name', $name);
		$query = 'SELECT * FROM user';
		$results = $this->db->query($query);
		$success = false;
		foreach($results as $result) {
			if($name == $result['user_name']) {
				$checkpass = $result['pass'];
				if(sha1($pass) == $checkpass) {
					$_SESSION['user'] = 1;
					$_SESSION['id'] = $result['id'];
					if($result['admin'] == 100) {
						$_SESSION['admin'] = 1;
					}
					$success = true;
					
					if(isset($this->postdata['rememberme'])) {
						setcookie('username', $name, time()+60*60*24*365);
						setcookie('password', sha1($pass), time()+60*60*24*365);
						$_SESSION['cookie'] = 1;
						header('location: '.WEB_ROOT);
					}
				}
			}
		}
		if (!$success) {
			$_SESSION['user'] = 2;
			header('location: '.WEB_ROOT);
		}
	header('location: '.WEB_ROOT);
	}
	
	public function mobileLogin($data) {
		$this->db->toNull();
		$name = $data['uname'];
		$name = stripslashes($name);
		$pass = $data['pass'];
		$pass = stripslashes($pass);
		
		$results = $this->query->getUserLogin($name);
		$success = false;
		// $test = 
		foreach($results as $result) {
			if($name == $result['user_name']) {
				$checkpass = $result['pass'];
				if(sha1($pass) == $checkpass) {
					$_SESSION['user'] = 1;
					$_SESSION['id'] = $result['id'];
					
					$success = true;
					
					if(isset($this->postdata['rememberme'])) {
						setcookie('username', $name, time()+60*60*24*365);
						setcookie('password', sha1($pass), time()+60*60*24*365);
						$_SESSION['cookie'] = 1;
						// return 1;
					}
				} 
			} 
		}
		if (!$success) {
			$_SESSION['user'] = 2;
			// $success = false;
		}
		return $success;
	}
	
	public function logout () {
			session_destroy();
			setcookie('username');
			setcookie('password');
			header('location: '.WEB_ROOT.'?cookiereset=1');
		}
		
	private function cookiereset () {
		header('location: '.WEB_ROOT);
	}
		
	private function cookieLogin() {
		$pass = $_COOKIE['password'];
		$name = $_COOKIE['username'];
		$this->db->toNull();
		$this->db->where('user_name', $name);
		$query = 'SELECT * FROM user';
		$results = $this->db->query($query);
		$success = false;
		foreach($results as $result) {
			if($name == $result['user_name']) {
				$checkpass = $result['pass'];
				if($pass == $checkpass) {
					$_SESSION['user'] = 1;
					$_SESSION['id'] = $result['id'];
					$success = true;
				}
			}
		}
		if (!$success) {
			$_SESSION['user'] = 2;
		}
	}
	
	private function addEvent() {
		$this->db->toNull();
		
		$date = $this->postdata['date'];
		$date = stripslashes($date);
		$time = $this->postdata['time'];
		$time = stripslashes($time);
		$comment = $this->postdata['comment'];
		$comment = stripslashes($comment);
		$new = $this->postdata['neweventtype'];
		$new = stripslashes($new);
		if($new != "") {
			$data = array('name' => $this->postdata['neweventtype']);
			$result = $this->db->insert('eventtype', $data);
			if(!$result) {
				header('location: '.WEB_ROOT.'event/error');
				$_SESSION['error'] = 'Couldnt save eventtype';
			} else {
				$this->postdata['type'] = $this->db->getLastInsertedId();
			}
		}
		
		$data = array ( 'user_id' => $_SESSION['id'],
						'date' => $date,
						'time' => $time,
						'eventtype_id' => $this->postdata['type'],
						'comment' => $comment);
		$this->db->toNull();
		$result = $this->db->insert("event", $data);
		if($result == 1) {
			header('location: '.WEB_ROOT.'event/addcomplete');
		}else {
			header('location: '.WEB_ROOT.'event/error');
			$_SESSION['error'] = 'Couldnt save event. eventtypeid = '.$this->postdata;
		}
	}
	
	private function editEvent() {
		$this->db->toNull();
		$data = array(	'date' => $this->postdata['date'],
						'time' => $this->postdata['time'],
						'eventtype_id' => $this->postdata['type'],
						'comment' => $this->postdata['comment']
		);
		$this->db->where('id', $this->postdata['id']);
		$result = $this->db->update("event", $data);
		if($result == 1) {
			header('location: '.WEB_ROOT.'event/editcomplete');
		}else {
			header('location: '.WEB_ROOT.'event/error');
		}
	}
	
	private function addBloggEvent() {
		$this->db->toNull();
		$date = date('Y-m-d H:i:s', time());
		$data = array(	'text' => $this->postdata['text'],
						'user_id' => $_SESSION['id'],
						'date' => $date
					);
		$result = $this->db->insert("blogg", $data);
		$url = $_SESSION['url'];
		header('location: '.$url);
	}
	
	private function changePass() {
		$id = $_SESSION['id'];
		$pass = $this->postdata['pwd'];
		$pass = stripslashes($pass);
		$data = array('pass' => sha1($pass));
		$this->db->where('id', $id);
		$result =$this->db->update('user', $data);
		if($result) {
			header('location: '.WEB_ROOT.'user/passok');
		} else {
			header('location: '.WEB_ROOT.'event/error');
		}
	}
	
	private function updateProfile() {
		$id = $_SESSION['id'];
		$name = $this->postdata['name'];
		$name = stripslashes($name);
		$email = $this->postdata['email'];
		$email = stripslashes($email);
		$data = array('name' => $name, 'email' => $email);
		$this->db->where('id', $id);
		$result =$this->db->update('user', $data);
		if($result) {
			header('location: '.WEB_ROOT.'user/profileok');
		} else {
			header('location: '.WEB_ROOT.'event/error');
		}
	}
	
	private function addUser() {
		$this->db->toNull();
		$data = array(	'user_name'	=> $this->postdata['uname'],
						'name' 		=> $this->postdata['name'],
						'pass' 		=> sha1($this->postdata['pass']),
						'email' 	=> $this->postdata['email'],
						'group_id' 	=> $this->postdata['group_id']
		
		);
		$result = $this->db->insert("user", $data);
		$_SESSION['saved'] = "Laggt till användare ".$this->postdata['uname'];
	}
	
	private function addEventType() {
		$this->db->toNull();
		$data = array('name' => $this->postdata['eventtype']);
		$result = $this->db->insert("eventtype", $data);
		$_SESSION['saved'] = "Laggt till träningstyp ".$this->postdata['eventtype'];
	}
}
