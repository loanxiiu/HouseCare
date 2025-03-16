<?php
	namespace BTL\controller;
	
	use BTL\db\GioHangDB;
	use BTL\model\GioHang;
	use BTL\db\ChiTietGioHangDB;
	use BTL\model\ChiTietGioHang;
	
	class GioHangController
	{
		private $gioHangDB;
		private $chiTietGioHangDB;
		
		public function __construct()
		{
			$this->gioHangDB = new GioHangDB();
			$this->chiTietGioHangDB = new ChiTietGioHangDB();
		}
		
		public function Them()
		{
			if (!isset($_SESSION['ma_user'])) {
				return false; // User must be logged in
			}
			
			$maKhachHang = $_SESSION['ma_user'];
			$gioHang = $this->gioHangDB->layHoacTaoGioHang($maKhachHang);
			return $gioHang->getMa() ? true : false;
		}
		
		public function Sua()
		{
			if (!isset($_POST['ma_gio_hang']) || !isset($_POST['don_gia'])) {
				return false;
			}
			
			$gioHang = new GioHang();
			$gioHang->setMa($_POST['ma_gio_hang']);
			$gioHang->setMaKhachHang($_SESSION['ma_user']);
			$gioHang->setDonGia($_POST['don_gia']);
			return $this->gioHangDB->sua($gioHang);
		}
		
		public function Xoa()
		{
			if (!isset($_GET['ma_gio_hang'])) {
				return false;
			}
			
			$maGioHang = $_GET['ma_gio_hang'];
			return $this->gioHangDB->xoa($maGioHang);
		}
		
		public function LayTatCa()
		{
			return $this->gioHangDB->layTatCa();
		}
		
		public function LayBangId($id)
		{
			return $this->gioHangDB->layBangId($id);
		}
		
		public function LayGioHangCuaNguoiDung()
		{
			if (!isset($_SESSION['ma_user'])) {
				return null;
			}
			
			$maKhachHang = $_SESSION['ma_user'];
			$gioHang = $this->gioHangDB->layHoacTaoGioHang($maKhachHang);
			if ($gioHang) {
				$chiTietGioHangs = $this->chiTietGioHangDB->layBangMaGioHang($gioHang->getMa());
				$gioHang->setChiTietGioHangs($chiTietGioHangs); // Assuming GioHang has a setter for chi tiet
				return $gioHang;
			}
			return null;
		}
		
		public function CapNhatDonGia($maGioHang)
		{
			return $this->gioHangDB->capNhatDonGia($maGioHang);
		}
		
		public function CapNhatSoLuong($maChiTiet, $soLuong)
		{
			$chiTiet = $this->chiTietGioHangDB->layBangId($maChiTiet);
			if ($chiTiet) {
				$chiTiet->setSoLuong($soLuong);
				return $this->chiTietGioHangDB->sua($chiTiet);
			}
			return false;
		}
		
		public function XoaChiTiet($maChiTiet)
		{
			return $this->chiTietGioHangDB->xoa($maChiTiet);
		}
	}