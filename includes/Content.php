<?php
	class Content {
	
		private $log;
		private $action;
		private $id;
		private $q;
		private $start;
		private $end;
		private $pagenr;
		private $news;
		private $event;
		private $stats;
		private $user;
		private $weeknr;
		private $get;
		private $area;
		private $subarea;
		private $obj;
		private $params;
		private $func;
	
		public function __construct($params = array(), $log) {
			$this->params = $params;
			$this->log = $log;
			$this->q = new Query();
			$this->start = '<div id="content" class="corners">';
			$this->end = '</div>';
			$this->news = new News();
		}
	
		public function generate() {
			$func = '';
			$page = '';
			if(strlen($this->params[1]) >= 1) {
				$func = $this->params[1];
			} else {
				$func = null;
			}
			$page .= $this->start;
			if($this->action == 'about') {
				$page .= $this->about();
			}
			if(isLoggedIn()) { // logged in
				
				$this->area = ucfirst($this->params[0]);
				if(strlen($this->params[0]) >= 1) {
					$url = __DIR__.'/';
					// $url = INCLUDE_PATH.'includes/';;
					$filename = $url.$this->area.'.php';
					if(file_exists($filename)) {
						$this->obj = new $this->area($this->params);
						if($func != null) {
							if(method_exists($this->obj, $func)) {
								$page .= $this->obj->$func();
							} else {
								$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/X.png" alt="" /><h3>Funktionen du söker kan inte hittas.</h3>';
							}
						} else {
							$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/X.png" alt="" /><h3>Funktionen du söker kan inte hittas.</h3>';
						}
					} else {
						$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/X.png" alt="" /><h3>Objektet du söker kan inte hittas.</h3>';
					}
				}else {
					$page .= $this->news->getNews();
				}
			}elseif($this->action == 'about') {
				$page .= $this->about();
			}else {
				$page .= $this->news->getNews();
			}
			$page .= $this->end;
			return $page;
				/*
				
				
				if($this->action == 'event') {
					$page = $this->start;
					$page .= $this->event->addEvent();
					$page .= $this->end;

				}elseif($this->action == 'stat') {
					$page = $this->start;
					$page .= $this->stats->stats();
					$page .= $this->end;
				}elseif($this->action == 'weekstat') {
					$page = $this->start;
					$page .= $this->stats->weekStats();
					$page .= $this->end;
				}elseif($this->action == 'editprofile') {
					$page = $this->start;
					$page .= $this->user->editProfile();
					$page .= $this->end;
				}elseif($this->action == 'profile') {
					$page = $this->start;
					$page .= $this->user->getProfile();
					$page .= $this->end;
				}elseif($this->action == 'addeventcomplete') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/Checkmark.png" alt="" />';
					$page .= '<h3>Ditt träningstillfälle är nu tillagt!</h3><p>Se dina <a href="?action=eventslist">träningstillfällen</a></p>';
					$page .= $this->end;
				}elseif($this->action == 'addeventincomplete') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/X.png" alt="" />';
					$page .= '<h3>Fel!</h3><p>Det blev nåt fel när ditt träningstillfälle skulle läggas till. Kontakta webmaster om det är ett återkommande problem.</p>';
					$page .= $this->end;
				}elseif($this->action == 'deleteeventcomplete') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/Checkmark.png" alt="" />';
					$page .= '<h3>Ditt träningstillfälle är nu borttaget!</h3><p>Se dina <a href="?action=eventslist">träningstillfällen</a></p>';
					$page .= $this->end;
				}elseif($this->action == 'deleteeventincomplete') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/X.png" alt="" />';
					$page .= '<h3>Fel!</h3><p>Det blev nåt fel när ditt träningstillfälle skulle tas bort. Kontakta webmaster om det är ett återkommande problem.</p>';
					$page .= $this->end;
				}elseif($this->action == 'profileok') {
					$page = $this->start;
					$page .= '<h3>Din profil är uppdaterad!</h3>';
					$page .= $this->end;
				}elseif($this->action == 'profilenotok') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/X.png" alt="" />';
					$page .= '<h3>Fel!</h3><p>Det blev nåt fel när din profil skulle uppdateras. Kontakta webmaster om det är ett återkommande problem.</p>';
					$page .= $this->end;
				}elseif($this->action == 'passok') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/Checkmark.png" alt="" />';
					$page .= '<h3>Ditt lösenord är nu bytt!</h3>';
					$page .= $this->end;
				}elseif($this->action == 'passnotok') {
					$page = $this->start;
					$page .= '<img src="css/images/eleganticons/images/X.png" alt="" />';
					$page .= '<h3>Fel!</h3><p>Det blev nåt fel när ditt lösenord skulle ändras. Kontakta webmaster om det är ett återkommande problem.</p>';
					$page .= $this->end;
				}elseif($this->action == 'edit') {
					$page = $this->start;
					$page .= $this->event->editEvent();
					$page .= $this->end;
				}elseif($this->action == 'eventslist') {
					$page = $this->start;
					$page .= $this->event->eventList();
					$page .= $this->end;
				}elseif($this->action == 'about') {
					$page = $this->start;
					$page .= $this->about();
					$page .= $this->end;
				}elseif($this->action == 'groupstat') {
					$page = $this->start;
					$page .= $this->stats->groupStat();
					$page .= $this->end;
				}elseif($this->action == 'delete') {
					$page = $this->start;
					$page .= $this->event->deleteEvent();
					$page .= $this->end;
				}elseif($this->action == 'changepass') {
					$page = $this->start;
					$page .= $this->user->changePass();
					$page .= $this->end;
				}else {
					$page = $this->start;
					$page .= $this->news->getNews();
					$page .= $this->end;
				}
				*/
			
		}		
		
		private function about() {
			$returnvalue .= '<div class="about">';
			$returnvalue .= '<h3>OM</h3>';
			$returnvalue .= '<p>Testprojekt av Pontus Alm för att hjälpa de som har det jobbigt med träningen.</p>';
			$returnvalue .= '<p>Tanken är att det ska vara ett praktiskt prov i programmering för mig själv men även som en hjälp till andra.</p>';
			$returnvalue .= '<p>Hittar du buggar, fel eller något du saknar kan du maila till <a href="mailto:pontus@xrsize.me">mig</a>.</p>';
			$returnvalue .= '</div>';
			return $returnvalue;
		}
	}
