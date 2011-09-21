<?php
	require_once('../config/config.php');

	function __autoload($class_name) {
		include '../includes/'.$class_name . '.php';
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$postman = new PostManager($_POST);
	}

	$top = new Top();
	echo $top->top;

	if(isset($_SESSION['saved'])) {
		$info = '<p>Senaste tillägget: '.$_SESSION['saved'].'</p>';
	}

	if($_SESSION['admin']) {
		echo '<div id=content>
				<h1>Meny</h1>
				'.$info.'
				<ul><li>
					<form id="addeventtype" method="post" action="">
						<div class="box">
							<label for="eventtype">Träningstyp:</label>
							<input id="eventtype" type="text" name="eventtype" />
						</div>
						<div class="box">
							<input class="button" name="addeventtype" type="submit" value="Lägg till" />
						</div>
					</form>
				</li>
				<li>
					<form id="adduser" method="post" action="">
						<div class="box">
							<label for="uname">Användarnamn:</label>
							<input id="uname" type="text" name="uname" /><br />
							<label for="name">Namn:</label>
							<input id="name" type="text" name="name" /><br />
							<label for="pass">Lösenord</label>
							<input id="pass" type="password" name="pass" /><br />
							<label for="email">Email:</label>
							<input id="email" type="text" name="email" /><br />
							<label for="group_id">Grupp id:</label>
							<input id="group_id" type="text" name="group_id" /><br />
						</div>
						<div class="box">
							<input class="button" name="adduser" type="submit" value="Lägg till" />
						</div>
					</form>
				
				</li>	
		</ul>
		
		';
		echo '<div class="infodevider"></div>
		
			<div id="login">
					<form id="logout" method="post" action="">
						<input class="button" name="logout" type="submit" value="Logga ut" />
					</form>
				</div></div>';
	} else {
		echo '<h1>Ej behörighet</h1>';
	}
	
	echo file_get_contents('../includes/bottom.html');
