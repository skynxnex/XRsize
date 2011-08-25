<?php
	class LeftMenu {
		
		private $log;
		private $q;
		
		public function __construct($log) {
			$this->log = $log;
			$this->q = new Query();
		}
		
		public function generate () {
			$returnvalue = '';
			if($this->log == 1) { // logged in
				$id = $_SESSION['id'];
				$results = $this->q->getUserInfo($id);
				$name = $results[0]['name'];
				$returnvalue .= '	<div id="leftmenu" class="corners">
										<div id="login">
											<p>Inloggad som:<br /> '.$name.'</p>
											<form id="logout" method="post" action="">
											<input class="button" name="logout" type="submit" value="Logga ut" />
											</form>
										</div>
										<div id="ul" class="menu coloredmenu corners">
											<ul>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/Person-black.png" alt="Profil" /><a href="'.WEB_ROOT.'user/profile">Min profil</a></li>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/Heart.png" alt="Träningar" /><a href="'.WEB_ROOT.'event/events">Mina träningar</a></li>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/Heart-add.png" alt="Lägga till träningar" /><a href="'.WEB_ROOT.'event/add">Lägga till träning</a></li>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/Person.png" alt="Statistik" /><a href="'.WEB_ROOT.'stats/stats">Egen statistik</a></li>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/Person-group.png" alt="Grupp statistik" /><a href="'.WEB_ROOT.'stats/group">Vänners Statistik</a></li>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/List.png" alt="Träningsformer" /><a href="'.WEB_ROOT.'eventtype">Träningsformer</a></li>
												<li><img src="'.WEB_ROOT.'css/images/eleganticons/images/Paper.png" alt="Allmän statistik" /><a href="'.WEB_ROOT.'stats/allstats">Allmän statistik</a></li>
												<li><img src="'.WEB_ROOT.'css/images/star.png" alt="Stjärnligan" /><a href="'.WEB_ROOT.'stats/stars">Stjärnligan</a></li>
											</ul>
										</div>
									</div>';
			}else { // no data yet
				$returnvalue .= '<div id="leftmenu">
									<div id="login">';
				if($this->log == 2) {
					$returnvalue .= '<p class="red">Falaktigt användarnamn eller lösenord</p>';
				}
				$returnvalue .= '		
										<form id="loginform" action="" method="post">
											
											<div class="box">
												<label for="uname">Användarnamn:</label>
												<input id="uname" class="required" type="text" name="uname" />
											</div>
											<div class="box">
												<label for="password">Lösenord:</label>
												<input id="password" type="password" name="pass" class="required" />
											</div>
											<div class="box">
												Kom ihåg mig: <input type="checkbox" name="rememberme" value="1">
											</div>
											<div class="box">
												<input class="button" name="login" type="submit" value="Logga in" />
											</div>
											
										</form>
									</div>
								</div>';
			}
			return $returnvalue;
		}
	}