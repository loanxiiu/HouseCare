<?php
	namespace BTL\controller;
	
	use BTL\db\DatabaseConnect;
	use BTL\db\GioHangDB;
	use BTL\db\ChiTietGioHangDB;
	use BTL\db\DonHangDB;
	use BTL\model\DonHang;
	
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../db/GioHangDB.php';
	require_once __DIR__ . '/../db/ChiTietGioHangDB.php';
	require_once __DIR__ . '/../db/DonHangDB.php';
	
	class DonHangController
	{
		private $conn;
		private $gioHangDB;
		private $chiTietGioHangDB;
		private $donHangDB;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
			$this->gioHangDB = new GioHangDB();
			$this->chiTietGioHangDB = new ChiTietGioHangDB();
			$this->donHangDB = new DonHangDB();
		}
		
		public function DatHang($maKhachHang)
		{
			$gioHang = $this->gioHangDB->layBangMaKhachHang($maKhachHang);
			if (!$gioHang || $gioHang->getDonGia() <= 0) {
				return ['success' => false, 'message' => 'Giỏ hàng trống'];
			}
			
			$chiTietList = $this->chiTietGioHangDB->layBangMaGioHang($gioHang->getMa());
			if (empty($chiTietList)) {
				return ['success' => false, 'message' => 'Không có sản phẩm trong giỏ hàng'];
			}
			
			$this->conn->begin_transaction();
			try {
				// Create order
				$donHang = new DonHang(null, $gioHang->getDonGia(), date('Y-m-d'), $maKhachHang, 1); // Default MaNhanVien = 1
				$this->donHangDB->them($donHang);
				$maDonHang = $this->conn->insert_id;
				
				// Create order details
				$chiTietController = new ChiTietDonHangController();
				foreach ($chiTietList as $chiTiet) {
					$chiTietController->Them($maDonHang, $chiTiet->getMaSanPham(), $chiTiet->getSoLuong());
					
					// Update product quantity
					$stmt = $this->conn->prepare("UPDATE SanPham SET SoLuong = SoLuong - ? WHERE Ma = ?");
					$stmt->bind_param("ii", $chiTiet->getSoLuong(), $chiTiet->getMaSanPham());
					$stmt->execute();
				}
				
				// Clear cart
				$this->chiTietGioHangDB->xoaTheoMaGioHang($gioHang->getMa());
				$this->gioHangDB->xoa($gioHang->getMa());
				
				$this->conn->commit();
				return ['success' => true, 'message' => 'Đặt hàng thành công', 'maDonHang' => $maDonHang];
			} catch (Exception $e) {
				$this->conn->rollback();
				return ['success' => false, 'message' => 'Lỗi khi đặt hàng: ' . $e->getMessage()];
			}
		}
		
		public function LayTatCa()
		{
			return $this->donHangDB->layTatCa();
		}
		
		public function LayBangId($id)
		{
			return $this->donHangDB->layBangId($id);
		}
		
		public function LayTatCaTheoKhachHang($maKhachHang)
		{
			return $this->donHangDB->layTatCaTheoKhachHang($maKhachHang);
		}
		
		public function LayChiTietDonHang($maDonHang)
		{
			$chiTietController = new ChiTietDonHangController();
			return $chiTietController->LayBangMaDonHang($maDonHang);
		}
	}