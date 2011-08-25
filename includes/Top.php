<?php

	class Top {
		
		
		public $top;
		
		public function __construct() {
			$this->top .= $this->header();
			$this->top .= $this->css();
			$this->top .= $this->js();
			$this->top .= $this->html();
		}

		private function header() {
			return '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>XRsize.me -- Din träningspepp i vardagen!</title>';
		}
		
		private function css() {
			return '<link rel="stylesheet" type="text/css" href="'.WEB_ROOT.'css/jquery-ui.css" />
					<link rel="stylesheet" type="text/css" href="'.WEB_ROOT.'css/dark.css" />';
					// <link rel="stylesheet" type="text/css" href="'.WEB_ROOT.'css/style.css" />';
		}
		
		private function js() {
			return 	'<script src="'.WEB_ROOT.'js/jquery.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/jquery-ui.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/easySlider1.7.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/jquery.validate.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/jquery.ui.datepicker.validation.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/jquery-confirm.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/jquery.elastic.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/error_mess.js" type="text/javascript"></script>
					<script src="'.WEB_ROOT.'js/script.js" type="text/javascript"></script>';
		}
		
		private function html() {
			return '</head><body><div id="wrapper">';
		}
	}


?>
