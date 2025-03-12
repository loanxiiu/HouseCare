<?php
	
	namespace BTL\controller;
	require_once __DIR__ . '/../db/AdminDB.php';
	use BTL\db\AdminDB;
	
	class AdminController
	{
		private $conn;
		public function __construct(){
			$this->conn = new AdminDB();
		}
		
		public function Them()
		{
		
		}
		
		public function Sua(){
		
		}
		
		public function Xoa(){
		
		}
		
		public function LayTatCa()
		{
		
		}
		
		public function LayBangId()
		{
		
		}
	}