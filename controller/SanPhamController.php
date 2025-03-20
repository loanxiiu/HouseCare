<?php
	
	namespace BTL\controller;
	
	use BTL\db\SanPhamDB;
	
	require_once __DIR__ . '/../db/SanPhamDB.php';
	
	class SanPhamController
	{
		private $db;
		
		public function __construct()
		{
			$this->db = new SanPhamDB();
		}
		
		public function LayTatCa()
		{
			$danhSachSanPham = $this->db->layTatCa();
			shuffle($danhSachSanPham); // Xáo trộn vị trí ngẫu nhiên
			return $danhSachSanPham;
		}
		
		public function LayBangId($id)
		{
		return $this->db->LayBangId($id);
		}
		
		public function timKiemSanPham($tuKhoa)
		{
			$dsSanPham = [];
			
			if (is_numeric($tuKhoa)) {
				// Nếu từ khóa là số, tìm theo ID (trả về 1 sản phẩm)
				$sanPham = $this->db->layBangId((int)$tuKhoa);
				if ($sanPham !== null) {
					$dsSanPham[] = $sanPham; // Thêm vào mảng kết quả
				}
			} else {
				// Nếu từ khóa là chữ, tìm theo tên (trả về danh sách sản phẩm)
				$dsSanPham = $this->db->layBangTen($tuKhoa);
			}
			
			return $dsSanPham;
		}
		
		
	}
