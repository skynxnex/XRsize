<?php
	class Stats {
		
		private $q;
		private $id;
		private $params;
		private $weekNr;
		private $year;
		
		public function __construct($params) {
			$this->q = new Query();
			$this->params = $params;
			if(strlen($params[2] >= 1)) {
				$this->id = $params[2];
			} else {
				$this->id = $_SESSION['id'];				
			}
			if(strlen($this->params[3] >= 1)) {
				$this->year = $this->params[3];
			} else {
				$this->year = 2011;			
			}
			if(strlen($this->params[4] >= 1)) {
				$this->weekNr = $this->params[4];
			} else {
				$this->weekNr = date("W");			
			}
		}
		
		public function stats() {
			$id = $this->id;
		
			$name = $this->q->getName($id); 
			$last = $name[strlen($name)-1];
			if($last != 's' && $last != 'S') {
				$name .= 's';
			}
			
			$stats = $this->calculateStats($id);
			$returnvalue .= '<div id="stats">';
			$returnvalue .= '<div id="statspic"><img src="'.WEB_ROOT.'css/images/statistik.png" alt="" /></div>';
			if($id == $_SESSION['id']) {
				$returnvalue .= '<h2>Din statistik!</h2>';
			} else {
				$returnvalue .= '<h2>'.$name.' statistik!</h2>';
			}
			
			$returnvalue .= '<p>Totalt antal poäng: <b>'.$stats['total'].'</b></p><p>Antal <img src="'.WEB_ROOT.'css/images/star.png" /> är '.$stats['starweeks'].'</p>';
			if($stats['weektotal'] >= 180){
				$returnvalue .= '<p>Veckopoängen är maxad för den här veckan.</p>';
			}else {
				$returnvalue .= '<p>Veckopoängen för denna vecka är <b>'.$stats['weektotal'].'</b> av totalt <b>180</b>.</p>';
			}
			$returnvalue .= '<div id="weekdata">';
			foreach($stats['weekdata'] as $week) {
				$returnvalue .= '<p>Poäng för vecka <a href="'.WEB_ROOT.'event/week/'.$id.'/'.$week['year'].'/'.$week['week'].'">'.$week['week'].'</a> är '.$week['points'].' av totalt 180.</p>';
			}
			$returnvalue .= '</div>';
			$returnvalue .= '</div>';
			
			return $returnvalue;
		}
		
		private function calculateStats($id = null) {
			// poäng från alla veckor med poäng
			// total poäng detta år, och år innan dess
			if($id == null) {
				$id = $this->id;
			}			
			$times = $this->q->getStats($id);
			$weekTotal = $this->thisWeekPoints($times);
			
			$yearTotal = 0;
			$weekData = array();
			$thisweek = 0;
			$dayOfYear = date("z")+1;
			$week = date("W");
			$firstYear = 2011;
			$thisYear = date("Y");
			$starweeks = 0;
						
			for($i = $dayOfYear; $i >= 0; $i-=7) {
				$thisWeek = 0;
				$days = array();
				foreach($times as $time) {
					$atoms = explode('-',$time['date']);
					$year = $atoms[0];
					$month = str_replace('0', '', $atoms[1]);
					$day = $atoms[2];
					$date = date("z", mktime(0,0,0, $month, $day, $year));
					if($date <= $i && $date >= $i-7) {
						$dayName = date("l", mktime(0,0,0, $month, $day, $year));
						$dayName = fixDayName($dayName);
						$typeName = $this->q->getEventtypeName($time['eventtype_id']);
						if($thisWeek < 180) {
							$thisWeek += $time['time'];
						}
					}
					// 	$dayNumber = date('w', mktime(0,0,0, $month, $day, $year));
					// if($dayNumber =)
				}
				if($thisWeek >= 180) {
					$thisWeek = 180;
					$starweeks++;
				}
				if($thisWeek > 0) {
					$weekData[] = array(	'week' 		=> $week, 
											'points' 	=> $thisWeek,
											'days'		=> $days,
											'year'		=> $year						
					);
					$yearTotal += $thisWeek;
				}
				$week -= 1;	
			}
			
			$data = array(	'thisweek' 	=> $thisweek,
							'weektotal' => $weekTotal,
							'total' 	=> $yearTotal,
							'weekdata' 	=> $weekData,
							'starweeks'	=> $starweeks
							);
			
			return $data;
		}
		
		private function thisWeekPoints($times) {
			$weekPoints = 0;
			$firstday = 0;
			$daynumber = date("w",mktime());
			$dayOfYear = date("z")+1;
			
			if($daynumber == 0) {
				$firstday = $dayOfYear-$daynumber-7;
			}else{
				$firstday = $dayOfYear-$daynumber;
			}
			
			foreach($times as $time) {
				$atoms = explode('-',$time['date']);
				$year = $atoms[0];
				$month = str_replace('0', '', $atoms[1]);
				$day = $atoms[2];
				$date = date("z", mktime(0,0,0, $month, $day, $year));
				if($date <= $dayOfYear && $date >= $firstday) {
					$weekPoints += $time['time'];
				}
			}
			return $weekPoints;
		}
				
		public function group() {
			$id = $_SESSION['id'];
			$returnvalue .= '<div id="stats">';
			$returnvalue .= '<div id="statspic"><img src="'.WEB_ROOT.'css/images/statistik.png" alt="" /></div>';
			$returnvalue .= '<h2>Vänners statistik</h2>';
			$groupId = $this->q->getGroupId($id);
			$group = $this->q->getUsersInGroup($groupId);
			foreach($group as $member) {
				if($member['id'] != $_SESSION['id']) {
					$stats = $this->calculateStats($member['id']);
					$returnvalue .= '<div class="groupstat">';
					$returnvalue .= '<p><a href="'.WEB_ROOT.'stats/stats/'.$member['id'].'">'.$member['name'].'</a> har totalt '.$stats['total'].' poäng.</p>';
					if($stats['weektotal'] >= 180){
						$returnvalue .= '<p>Veckopoäng är maxad för den här veckan.</p>';
					}else {
						$returnvalue .= '<p>Veckopoängen är '.$stats['weektotal'].' av totalt 180.</p>';
					}
					$returnvalue .= '</div>';
				}
			}
			$returnvalue .= '</div>';
			
			return $returnvalue;
		}
		
		public function stars() {
			$rv = '<div id="ul" class="menu coloredmenu corners"><ul>';
			$list = array();
			// get all users in group
			$id = $_SESSION['id'];
			$groupId = $this->q->getGroupId($id);
			$group = $this->q->getUsersInGroup($groupId);
			
			// calculate star for each person
			foreach($group as $member) {
				$stats = $this->calculateStats($member['id']);
				$list[] = array($member['name'] => $stats['starweeks']);
				arsort($list);
				if($stats['starweeks'] == 1){
					$rv .= '<li><a href="'.WEB_ROOT.'stats/stats/'.$member['id'].'">'.$member['name'].'</a> har '.$stats['starweeks'].' stjärna.';
				}else {
					$rv .= '<li><a href="'.WEB_ROOT.'stats/stats/'.$member['id'].'">'.$member['name'].'</a> har '.$stats['starweeks'].' stjärnor.';
				}
			}
			$rv .= '</ul></div>';
			return $rv;
		}
	}