<?php
	class User {
		private $q;
		
		public function __construct() {
			$this->q = new Query();
		}
		
		public function profile() {
			$id = $_SESSION['id'];
			$user = $this->q->getUserInfo($id);
			$name = $user[0]['name'];
			$uname = $user[0]['user_name'];
			$email = $user[0]['email'];
			$url = WEB_ROOT.'css/images/'.$user[0]['profile_img'];
			$returnvalue .= '<div id="profile">';
			$returnvalue .= '<h2>Din profil</h2>';
			$returnvalue .= '<div class="profilepic"><img src="'.$url.'" alt="" /></div>';
			$returnvalue .= '<div class="infocontent"><p>Ditt användarnamn är: '.$uname.'</p><p>Ditt namn är: '.$name.'</p><p>Din epost är: '.$email.'</p>';
			$returnvalue .= '<a href="'.WEB_ROOT.'user/edit"><button class="button buttonsmall">Ändra i profil</button></a>';
			$returnvalue .= '<a href="'.WEB_ROOT.'user/pass"><button class="button buttonsmall" >Byta lösenord</button></a>';
			$returnvalue .= '</div></div>';
				
			return $returnvalue;
		}
		
		public function pass() {
			$returnvalue .= '<div id="passchange">
								<form id="newpass" name="changepass" method="post">
									<fieldset>
								<p>Lösenordet måste vara minst 6 och max 12 tecken långt.</p>
									<legend>Ändra lösenord</legend>
									<p>
										<label for="pwd">Nytt lösen:</label>
										<input id="pwd" type="password" name="pwd" maxlength=12 class="required" />
									</p>
									<p>
										<label for="pwdval">Nytt lösen igen:</label>
										<input id="pwdval" type="password" name="pwdval" maxlength=12 class="required" />
									</p>
									<p><input class="button buttonsmall" name="changepass" type="submit" value="Ändra lösen" /></p>
									</fieldset>
								</form></div>';
			return $returnvalue;
		}
		
		public function edit() {
			$id = $_SESSION['id'];
			$user = $this->q->getUserInfo($id);
			$name = $user[0]['name'];
			$email = $user[0]['email'];
			$url = 'css/images/'.$user[0]['profile_img'];
			$returnvalue .= '<div id="profile">';
			$returnvalue .= '<h2>Din profil</h2>';
			$returnvalue .= '<div class="profilepic"><img src="'.$url.'" alt="" /></div>';
			$returnvalue .= '<div class="infocontent">';
			$returnvalue .= '<form id="editprofile" method="post">
								<fieldset>
									<p>
										<label for="name">Namn:</label>
										<input type="text" id="name" name="name" value="'.$name.'" />
									</p>
									<p>
										<label for="email">E-post:</label>
										<input id="email" type="text" name="email" value="'.$email.'"  />
			</p>
									<p><input class="button buttonsmall" name="updateprofile" type="submit" value="Uppdatera" /></p>
									</div></div>';
				
			return $returnvalue;
		}
		
		public function passok() {
			$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/Checkmark.png" alt="" />';
			$page .= '<h3>Ditt lösenord är nu ändrat!</p>';
			return $page;
		}
		
		public function profileok() {
			$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/Checkmark.png" alt="" />';
			$page .= '<h3>Din profil är nu ändrad!</p>';
			return $page;
		}
	}