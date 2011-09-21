<?php
	class RightMenu {
		
		private $q;
		private $log;
		
		public function __construct($log) {
			$_SESSION['url'] = selfURL();
			$this->q = new Query();
			$this->log = $log;
		}
		
		public function generate() {
			$returnvalue = '';
			$returnvalue .= '<div id="rightmenu" class="corners">';
			if($this->log == 1) { // logged in
				$returnvalue .= '<div id="peppheader"><h4>Peppbloggen</h4><p class="small">Senaste 10</p></div>';
				$returnvalue .= '<div id="eventblogg"><ul>';
				
				$entries = $this->q->getBlogg();
				foreach($entries as $entry) {	
					$name = $this->q->getName($entry['user_id']);
					$returnvalue .= '<li><p>'.$entry['text'].'</p><p class="small">av '.$name.' den '.$entry['date'].'</p></li>';
					$returnvalue .= '<hr width="95%" size="3"> ';
				}
				
				$returnvalue .= '</ul></div>';
					$returnvalue .= '<div id="addblogg">
												<form action="" method="post"><fieldset>
													<label for="text">Skriv i bloggen:</label>
													<textarea rows="2" cols="1" name="text" id="blogginput" class="elasticinput"></textarea>
													<input name="blogg" type="submit" class="button buttonsmall elasticinput" value="Skicka" />
												</form></fieldset>
											</div>';
			} else {
				$returnvalue .= '<div id="mail"><p>Är du intresserad av att få en inloggning?</p><p>Maila till <a href="mailto:pontus@xrsize.me">admin</a>.</div>';
			}
			
			$returnvalue .= '</div>';
		
			return $returnvalue;
						
							
							
								
							
						
		}
	}
