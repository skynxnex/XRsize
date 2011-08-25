<?php
	
	class Event {
		
		private $q;
		private $id;
		private $pagenr;
		private $params;
		private $weekNr;
		private $year;
		
		public function __construct($params, $id = null) {
			$this->q = new Query();
			$this->id = $id;
			$this->params = $params;
			if(strlen($params[3]) >=1) {
				$this->pagenr = $params[3];
			} else {
				$this->pagenr = 1;
			}
			if($this->params[1] == 'week') {
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
				if(strlen($params[2] >= 1)) {
					$this->id = $params[2];
				} else {
					$this->id = $_SESSION['id'];				
				}
			}
		}
		
		public function add() {
			$returnvalue .= '<div id="addevent">';
			$returnvalue .= '<div id="trainpic"><img src="'.WEB_ROOT.'css/images/training.png" alt="" /></div>';
			$returnvalue .= '<form id="adde" action="" method="post">
								<h3>Lägg till träningstillfälle</h3>
								<fieldset>
								<label for="datepicker">Datum:</label>
								<p><input id="datepicker" class="dpDate required" type="text" name="date" /></p>
								<p>Antal minuter:
									<p><select id="time" name="time">
										<option value="30">30</option>
										<option value="45">45</option>
										<option value="60">60</option>
										<option value="75">75</option>
										<option value="90">90</option>
									</select></p>
								</p>';
			$results = $this->q->getEventtypes();
			$returnvalue .= '<label for="type">Träningstyp:</label>
									<p><select id="type" name="type">';
			foreach($results as $result) {
				$returnvalue .= '<option value="'.$result['id'].'">'.$result['name'].'</option>';
			}							
			$returnvalue .=	'</select><p>';
			$returnvalue .= '<p>Kommentar:</p><textarea class="elasticinput" rows="2" cols="40" id="comment"name="comment"></textarea>';
			$returnvalue .=	'<p><input class="button" name="addevent" type="submit" value="Skicka" /></p>
							</fieldset></form>';
			$returnvalue .= '</div>';
			
			return $returnvalue;
		}
		
		public function edit() {
			$event = $this->q->getEvent($this->params[2]);
			$times = array(30, 45, 60, 75, 90);
			$returnvalue .= '<div id="addevent">';
			$returnvalue .= '<form id="adde" action="" method="post">
								<fieldset>
								<legend>Ändra träningstillfälle</legend>
								<input type="hidden" type="text" name="id" value="'.$this->params[2].'">
								<label for="datepicker">Datum:</label>
								<input id="datepicker" class="dpDate required" type="text" name="date" value="'.$event[0]['date'].'" />
								<p>Antal minuter:
									<select id="time" name="time">';
			foreach($times as $time) {
				if($event[0]['time'] == $time) {
					$returnvalue .= '<option value="'.$time.'" selected="selected">'.$time.'</option>';
				} else {
					$returnvalue .= '<option value="'.$time.'">'.$time.'</option>';
				}
			}
			$returnvalue .= '</select>
								</p>';
			$results = $this->q->getEventtypes();
			$returnvalue .= '<p>Träningstyp:
									<select id="type" name="type">';
			foreach($results as $result) {
				if($result['id'] == $event[0]['eventtype_id']) {
					$returnvalue .= '<option selected="selected" value="'.$result['id'].'">'.$result['name'].'</option>';
				}else {
					$returnvalue .= '<option value="'.$result['id'].'">'.$result['name'].'</option>';
				}
			}							
			$returnvalue .=	'</select>
								</p>';
			$returnvalue .= '<p>Kommentar:</p><textarea rows="10" cols="40" name="comment">'.$event[0]['comment'].'</textarea>';
			$returnvalue .=	'<p><input class="button buttonall" name="editevent" type="submit" value="Skicka" /></p>
							</fieldset></form>';
			$returnvalue .= '</div>';
			
			return $returnvalue;
		}
		
		public function events() {
			$id = '';
			if(strlen($this->params[2] >= 1)) {
				$id = $this->params[2];
			} else {
				$id = $_SESSION['id'];				
			}
			$name = $this->q->getName($id);
			$paging = '';
			$returnvalue .= '<div id="eventlist">';
			$returnvalue .= '<h3>Träningstillfällen för '.$name.':</h3>';
			$events = $this->q->getEventsByUser($id);
			$number = count($events);
			// paging
			if($number >= 6) {
				$paging = paging($number, $this->pagenr, $id);
			}
			$start = $this->pagenr * 5 - 5;
			$limit = 5;
			$events = $this->q->getEventsByUserWithLimit($id, $start, $limit);
			$returnvalue .= $paging;
			foreach($events as $event) {
				$returnvalue .= $this->event($event);
			}
			$returnvalue .= $paging;
			$returnvalue .= '</div>';
			
			return $returnvalue;
		}
		
		public function delete() {
			$result = $this->q->deleteEvent($this->params[2]);
			if($result) {
				header('location: '.WEB_ROOT.'event/deletecomplete');
			} else {
				header('location: '.WEB_ROOT.'event/error');
			}
		}
		
		private function event($event) {
			$splitdate = splitDate($event['date']);
			$eventtype = $this->q->getEventtypeName($event['eventtype_id']);
			$returnvalue .= '<div class="event"><p class="calendar">'.$splitdate['day'].'<em>'.monthName($splitdate['month']).'</em></p><p>Träningstid: '.$event['time'].'min.</p><p>Träningstyp: '.$eventtype.'</p><p>Egen Kommentar: '.$event['comment'].'</p>';
			$returnvalue .= '<p>';
			$returnvalue .= '<a href="'.WEB_ROOT.'event/edit/'.$event['id'].'"><button class="button buttonsmall" >Ändra</button></a>';
			$returnvalue .= '<a href="'.WEB_ROOT.'event/delete/'.$event['id'].'"><button class="button clickable buttonsmall" >Ta bort</button></a>';
			$returnvalue .= '</p>';
			$returnvalue .= '</div>';
			$returnvalue .= '<hr width="100%" size="3"> ';
			
			return $returnvalue;
			
		}
		
		public function week(){
			$thisweek = 0;
			$dayName = '';
			$typeName = '';
			$days = '';
			
			$times = $this->q->getStats($this->id);
			$interval = weekToDate($this->weekNr, $this->year);
			foreach($times as $time) {
				$atoms = explode('-',$time['date']);
				$year = $atoms[0];
				$month = str_replace('0', '', $atoms[1]);
				$day = $atoms[2];
				$date = date("z", mktime(0,0,0, $month, $day, $year));
				if($date <= $interval[1] && $date >= $interval[0]) {
					$dayName = date("l", mktime(0,0,0, $month, $day, $year));
					$dayName = fixDayName($dayName);
					$typeName = $this->q->getEventtypeName($time['eventtype_id']);
					if($thisWeek < 180) {
						$thisWeek += $time['time'];
					}
					$days .= $this->event($time);
				}				
			}
			$returnvalue .= '<div id="stats">';
			$returnvalue .= '<h3>Träning för vecka '.$this->weekNr.'</h3>';
			$returnvalue .= $days;
			$returnvalue .= '</div>';
			return $returnvalue;
		}
	
		public function deletecomplete() {
			$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/Checkmark.png" alt="" />';
			$page .= '<h3>Ditt träningstillfälle är nu borttaget!</h3><p>Se dina <a href="'.WEB_ROOT.'event/events">träningstillfällen</a></p>';
			return $page;
		}
		
		public function addcomplete() {
			$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/Checkmark.png" alt="" />';
			$page .= '<h3>Ditt träningstillfälle är nu registrerat!</h3><p>Se dina <a href="'.WEB_ROOT.'event/events">träningstillfällen</a></p>';
			return $page;
		}
		
	public function editcomplete() {
			$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/Checkmark.png" alt="" />';
			$page .= '<h3>Ditt träningstillfälle är nu ändrat!</h3><p>Se dina <a href="'.WEB_ROOT.'event/events">träningstillfällen</a></p>';
			return $page;
		}
		
		public function error () {
			$page .= '<img src="'.WEB_ROOT.'css/images/eleganticons/images/X.png" alt="" />';
			$page .= '<h3>Fel!</h3><p>Någonting gick fel. Kontakta webmaster om det är ett återkommande problem.</p>';
			return $page;	
		}
					
	}