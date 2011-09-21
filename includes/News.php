<?php

	class News {
		
		private $q;
		
		public function __construct() {
			$this->q = new Query();
		}
		
		public function getNews() {
			$returnvalue = '';
			$results = $this->q->getNews();
			foreach($results as $result) {
				$name = '';
				$name = $this->q->getName($result['user_id']);
				$infotypeid = $result['infotype_id'];
				$picture = $this->q->getInfoTypePic($infotypeid);
				$returnvalue .= '<div class="info">';
				$returnvalue .= '<h3>'.$result['header'].'</h3>';
				$url = WEB_ROOT.'css/images/'.$picture;
				$returnvalue .= '<div class="infopic"><img src="'.$url.'" alt="" /></div>';
				$returnvalue .= '<div class="infocontent"><p>'.$result['content'].'</p>';
				$returnvalue .= '<p class="small">Av '.$name.' '.$result['date'].'</p>';
				$returnvalue .= '</div></div>';
				$returnvalue .= '<div class="infodevider"></div>';
			}
			return $returnvalue;
		}
		
	}
