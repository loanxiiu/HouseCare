<?php
	namespace BTL\controller;
	
	use BTL\db\ChiTietDonHangDB;
	use BTL\model\ChiTietDonHang;
	
	require_once __DIR__ . '/../db/ChiTietDonHangDB.php';
	require_once __DIR__ . '/../model/ChiTietDonHang.php';
	
	class ChiTietDonHangController
	{
		private $chiTietDonHangDB;
		
		public function __construct()
		{
			$this->chiTietDonHangDB = new ChiTietDonHangDB();
		}
		
		public function Them($maDonHang, $maSanPham, $soLuong)
		{
			$chiTiet = new ChiTietDonHang(null, $maDonHang, $maSanPham, $soLuong);
			return $this->chiTietDonHangDB->them($chiTiet);
		}
		
		public function Sua($maChiTiet, $maDonHang, $maSanPham, $soLuong)
		{
			$chiTiet = new ChiTietDonHang($maChiTiet, $maDonHang, $maSanPham, $soLuong);
			return $this->chiTietDonHangDB->sua($chiTiet);
		}
		
		public function Xoa($maChiTiet)
		{
			return $this->chiTietDonHangDB->xoa($maChiTiet);
		}
		
		public function LayTatCa()
		{
			return $this->chiTietDonHangDB->layTatCa();
		}
		
		public function LayBangId($id)
		{
			return $this->chiTietDonHangDB->layBangId($id);
		}
		
		public function LayBangMaDonHang($maDonHang)
		{
			return $this->chiTietDonHangDB->layBangMaDonHang($maDonHang);
		}
		public function LayChiTietDonHang($maDonHang)
		{
			$chiTietController = new ChiTietDonHangController();
			return $chiTietController->LayBangMaDonHang($maDonHang);
		}
	}