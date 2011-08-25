<?php

	class Query {
	
		private $db;
		
		public function __construct() {
			$this->db = new MysqlDB(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_BASE);
		}
	
		public function getNews() {
			$this->db->toNull();
			$query = 'SELECT * FROM info ORDER BY date DESC LIMIT 5';
			$results = $this->db->query($query);
			return $results;
		}
		
		public function getName($id) {
			$this->db->toNull();
			$query = 'SELECT name FROM user WHERE id='.$id;
			$result = $this->db->query($query);
			$name = $result[0]['name'];
			return $name;
		}
	
		public function getEventtypes() {
			$this->db->toNull();
			$results = $this->db->get("eventtype");
			return $results;
		}
		
		public function getEventtypeName($id) {
			$this->db->toNull();
			$query = 'SELECT name FROM eventtype WHERE id ='. $id;
			$eventtype = $this->db->query($query);
			return $eventtype[0]['name'];
		}
		
		public function getUserInfo($id) {
			$this->db->toNull();			
			$query = 'SELECT * FROM user WHERE id ='.$id;
			$user = $this->db->query($query);
			return $user;
		}
		
		public function getEvent($id) {
			$this->db->toNull();
			$this->db->where('id', $id);		
			$event = $this->db->get('event', 1);
			return $event;
		}
		
		public function getStats($id) {
			$query = 'SELECT * FROM event WHERE user_id ='. $id.' ORDER BY date ASC';
			$times = $this->db->query($query);
			return $times;
		}
		
		public function getGroupId($id) {
			$this->db->toNull();
			$query = 'SELECT group_id FROM user WHERE id = '.$id;			
			$group = $this->db->query($query);
			$groupId = $group[0]['group_id'];
			return $groupId;
		}
		
		public function getUsersInGroup($id) {
			$this->db->toNull();
			$query = 'SELECT * FROM user WHERE group_id = '.$id;
			$group = $this->db->query($query);
			return $group;
		}
		
		public function getEventsByUser($id) {
			$this->db->toNull();
			$query = 'SELECT * FROM event WHERE user_id = '.$id.' ORDER BY date DESC';			
			$events = $this->db->query($query);
			return $events;
		}
		
		public function getEventsByUserWithLimit($id, $start, $limit) {
			$this->db->toNull();
			$query = 'SELECT * FROM event WHERE user_id = '.$id.' ORDER BY date DESC LIMIT '.$start.', '.$limit;			
			$events = $this->db->query($query);
			return $events;
		}
		
		public function getBlogg() {
			$id = $_SESSION['id'];
			$groupid = $this->getGroupId($id);
			$this->db->toNull();
			$query = '	SELECT user.id, blogg.id, blogg.text, blogg.date, blogg.user_id
						FROM `group`, user, blogg
						WHERE user.group_id = group.id
						AND blogg.user_id = user.id
						AND group.id ='.$groupid.'
						ORDER BY date DESC LIMIT 10';

			$bloggs = $this->db->query($query);
			return $bloggs;
		}
		
		public function getInfoTypePic($typeid) {
			$this->db->toNull();
			$query = 'SELECT picture FROM infotype WHERE id='.$typeid;
			$infotype = $this->db->query($query);
			return $infotype[0]['picture'];
		}
		
		public function deleteEvent($id) {
			$this->db->toNull();
			$this->db->where('id', $id);
			$result = $this->db->delete('event');
			return $result;
		}
		
		public function newPass() {
		
		}
		
		public function getUserLogin($uname) {
			$this->db->toNull();
			$this->db->where('user_name', $uname);
			$query = 'SELECT * FROM user';
			$results = $this->db->query($query);
			return $results;	
		}
	
	}