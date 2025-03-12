<?php
	namespace BTL\controller;
	require_once __DIR__ . '/../db/KhachHangDB.php';
	require_once __DIR__ . '/../db/TaiKhoanDB.php';
	require_once __DIR__ . '/../model/KhachHang.php';
	use BTL\db\KhachHangDB;
	use BTL\db\TaiKhoanDB;
	use BTL\model\KhachHang;
	
	class KhachHangController
	{
		private $db;
		private $taiKhoanDB;
		
		public function __construct()
		{
			$this->db = new KhachHangDB();
			$this->taiKhoanDB = new TaiKhoanDB();
		}
		
		public function Them(KhachHang $khachHang, $username, $password)
		{
			// Hash password for security
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			
			// Add to Users and TaiKhoan in a transaction
			$result = $this->db->them($khachHang, $username, $hashedPassword);
			return $result;
		}
		
		public function Sua(KhachHang $khachHang)
		{
			return $this->db->sua($khachHang);
		}
		
		public function Xoa($id)
		{
			return $this->db->xoa($id);
		}
		
		public function LayTatCa()
		{
			return $this->db->layTatCa();
		}
		
		public function LayBangId($id)
		{
			return $this->db->layBangId($id);
		}
	}
	?>