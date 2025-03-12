<?php
	namespace BTL\controller;
	require_once __DIR__ . '/../db/TaiKhoanDB.php';
	require_once __DIR__ . '/../model/TaiKhoan.php';
	require_once __DIR__ . '/../db/KhachHangDB.php'; // For customer details
	require_once __DIR__ . '/../db/AdminDB.php';     // For admin details
	require_once __DIR__ . '/../model/KhachHang.php';
	require_once __DIR__ . '/../model/Admin.php';
	
	use BTL\db\TaiKhoanDB;
	use BTL\model\TaiKhoan;
	use BTL\db\KhachHangDB;
	use BTL\db\AdminDB;
	use BTL\model\KhachHang;
	use BTL\model\Admin;
	
	class TaiKhoanController
	{
		private $db;
		private $khachHangDB;
		private $adminDB;
		
		public function __construct()
		{
			$this->db = new TaiKhoanDB();
			$this->khachHangDB = new KhachHangDB();
			$this->adminDB = new AdminDB();
		}
		
		public function Them(TaiKhoan $taiKhoan)
		{
			return $this->db->them($taiKhoan);
		}
		
		public function Sua(TaiKhoan $taiKhoan)
		{
			return $this->db->sua($taiKhoan);
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
		
		public function LayBangUserId($userId)
		{
			return $this->db->layBangUserId($userId);
		}
		
		public function DangNhap($username, $password)
		{
			$taiKhoan = $this->db->kiemTraDangNhap($username, $password);
			if ($taiKhoan) {
				$maUser = $taiKhoan->getMaUser();
				$maQuyen = $taiKhoan->getMaQuyen();
				
				// Fetch user details based on MaQuyen
				if ($maQuyen == 1) { // Admin
					$admin = $this->adminDB->layBangId($maUser);
					if ($admin) {
						return [
							'success' => true,
							'ma' => $maUser,
							'ten' => $admin->getTen(),
							'anh' => $admin->getAnh(),
							'username' => $username,
							'role' => 1
						];
					}
				} elseif ($maQuyen == 2) { // Customer
					$khachHang = $this->khachHangDB->layBangId($maUser);
					if ($khachHang) {
						return [
							'success' => true,
							'ma' => $maUser,
							'ten' => $khachHang->getTen(),
							'anh' => $khachHang->getAnh(),
							'username' => $username,
							'role' => 2
						];
					}
				}
			}
			return ['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng!'];
		}

	}
	?>