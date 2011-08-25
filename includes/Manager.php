<?php
	class Manager {
	
		private $page;
		private $banner;
		private $topmenu;
		private $leftmenu;
		private $content;
		private $rightmenu;
		private $footer;
		private $log;
		private $action;
		private $id;
		private $pagenr;
		private $weeknr;
		private $get;
		private $area;
		private $subarea;
		private $top;
		
		public function __construct($params, $log) {
			$this->log = $log;
			$this->action = $action;
			$this->id = $id;
			$this->pagenr = $pagenr;
			$this->weeknr = $weeknr;
			$this->get = $get;
			$this->area = $area;
			$this->subarea = $subarea;
			$this->top = new Top();
			$this->banner = new Banner();
			$this->topmenu = new TopMenu();
			$this->leftmenu = new LeftMenu($this->log);
			$this->content = new Content($params, $this->log);
			$this->rightmenu = new RightMenu($this->log);
			$this->footer = new Footer();
		}
		
		public function generatePage() {
			$this->page .= $this->top->top;
			$this->page .= $this->banner->generate();
			$this->page .= $this->topmenu->generate();
			$this->page .= $this->leftmenu->generate();
			$this->page .= $this->content->generate();
			$this->page .= $this->rightmenu->generate();
			$this->page .= $this->footer->generate();
			$this->page .= file_get_contents('includes/bottom.html');
			return $this->page;
		}
	
	}