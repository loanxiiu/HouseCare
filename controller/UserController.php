<?php
	namespace BTL\controller;
	
	use BTL\db\KhachHangDB;
	use BTL\model\KhachHang;
	
	require_once __DIR__ . '/../db/KhachHangDB.php';
	require_once __DIR__ . '/../model/KhachHang.php';
	
	class UserController
	{
		private $khachHangDB;
		
		public function __construct()
		{
			$this->khachHangDB = new KhachHangDB();
		}
		
		public function Sua($ma)
		{
			return $this->khachHangDB->sua($ma);
		}
		
		public function Xoa($ma)
		{
			return $this->khachHangDB->xoa($ma);
		}
		
		public function LayTatCa()
		{
			return $this->khachHangDB->layTatCa();
		}
		
		public function LayBangId($id)
		{
			return $this->khachHangDB->layBangId($id);
		}
		
		public function updateUser(KhachHang $khachHang)
		{
			return $this->khachHangDB->sua($khachHang);
		}
		
		public function deleteUser($id)
		{
			return $this->khachHangDB->xoa($id);
		}
		
		public function getUserById($id)
		{
			return $this->khachHangDB->layBangId($id);
		}
	}
	?>