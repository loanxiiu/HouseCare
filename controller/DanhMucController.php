<?php
	
	namespace BTL\controller;
	require_once __DIR__ . '/../db/DanhMucDB.php';
	require_once __DIR__ . '/../model/DanhMuc.php';
	use BTL\db\DanhMucDB;
	use BTL\model\DanhMuc;
	
	class DanhMucController
	{
		private $db;
		
		public function __construct()
		{
			$this->db = new DanhMucDB();
		}
		public function LayTatCa(){
			return $this->db->layTatCa();
		}
	}