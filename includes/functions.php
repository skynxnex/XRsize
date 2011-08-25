<?php

	function ismobile() {
		$is_mobile = '0';
		
		if(preg_match('/(android|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $is_mobile=1;
		}
		
		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		    $is_mobile=1;
		}
		
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
		
		if(in_array($mobile_ua,$mobile_agents)) {
		    $is_mobile=1;
		}
		
		if (isset($_SERVER['ALL_HTTP'])) {
		    if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
		        $is_mobile=1;
		    }
		}
		
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
		    $is_mobile=0;
		}
	
		return $is_mobile;
	}

	function doLogout() {
		session_destroy();
		setcookie('username', "", time()+60*60*24*365);
		setcookie('password', "", time()+60*60*24*365);
		header('location: '.WEB_ROOT);
	}
	
	function selfURL() { 
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
	} 
	
	function strleft($s1, $s2) { 
		return substr($s1, 0, strpos($s1, $s2)); 
	}
	
	function isLoggedIn () {
		if(isset($_SESSION['user']) && $_SESSION['user'] == 1) {
			return true;
		}
		return false;
	}
	
	function splitDate($date) {
		$atoms = explode('-',$date);
		$year = $atoms[0];
		$month = str_replace('0', '', $atoms[1]);
		$day = $atoms[2];
		return array('year' => $year, 'month' => $month, 'day' => $day);
	}
	
	function monthName($month) {
		$months = array(
			1 	=> 'Januari',
			2 	=> 'Februari',
			3 	=> 'Mars',
			4	=> 'April',
			5	=> 'Maj',
			6	=> 'Juni',
			7	=> 'Juli',
			8	=> 'Augusti',
			9	=> 'September',
			10	=> 'Oktober',
			11	=> 'November',
			12	=> 'December'
		);
		return $months[$month];
	}
	
	function weekToDate ($week, $year) {
		$start = date(datetime::ISO8601,strtotime($year."W".$week));
		$end = date(datetime::ISO8601,strtotime($year."W".$week."7"));
		$start =  substr_replace($start, '', 10);
		$end =  substr_replace($end, '', 10);
		
		$startatoms = explode('-',$start);
		$startyear = $startatoms[0];
		$startmonth = str_replace('0', '', $startatoms[1]);
		$startday = $startatoms[2];
		// $startday = str_replace('0', '', $startatoms[2]);
		$start = date("z", mktime(0,0,0, $startmonth, $startday, $startyear));
		
		$endatoms = explode('-',$end);
		$endyear = $endatoms[0];
		$endmonth = str_replace('0', '', $endatoms[1]);
		$endday = $endatoms[2];
		//$endday = str_replace('0', '', $endatoms[2]);
		$end = date("z", mktime(0,0,0, $endmonth, $endday, $endyear));
		
		
		
		$range = array((int)$start, (int)$end);
		return $range;
	}
	
	function fixDayName($dayName){
		$dayNames = array (
							'Monday' 	=> 'Måndag',
							'Tuesday' 	=> 'Tisdag',
							'Wednesday'	=> 'Onsdag',
							'Thursday'	=> 'Torsdag',
							'Friday'	=> 'Fredag',
							'Saturday'	=> 'Lördag',
							'Sunday'	=> 'Söndag'
		);
		return $dayNames[$dayName];			
	}
	
	function paging($nr, $thispagenr, $id = null) {
		
		$paging .= '<div id="paging"><ul><span>Sida</span>';
		if($thispagenr == 1) {
			$paging .= '<li class="selected">1</li>';
		} else {
			$paging .= '<li><a href="'.WEB_ROOT.'event/events/1">1</a></li>';
		}
		for($i = 2; $nr >= 6; $i++) {
			if($thispagenr == $i) {
				$paging .= '<li class="selected">'.$i.'</li>';
			} else {
				$paging .= '<li><a href="'.WEB_ROOT.'event/events/'.$id.'/'.$i.'">'.$i.'</a></li>';
			}
			$nr -= 5;
		}
		$paging .= '</ul></div>';
		return $paging;
	}