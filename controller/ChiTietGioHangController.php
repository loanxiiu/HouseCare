<?php
	
	namespace BTL\controller;
	
	use BTL\db\ChiTietGioHangDB;
	use BTL\model\ChiTietGioHang;
	use BTL\controller\SanPhamController;
	
	require_once __DIR__ . '/../db/ChiTietGioHangDB.php';
	require_once __DIR__ . '/../model/ChiTietGioHang.php';
	require_once __DIR__ . '/SanPhamController.php';
	
	class ChiTietGioHangController
	{
		private $chiTietGioHangDB;
		private $sanPhamController;
		
		public function __construct()
		{
			$this->chiTietGioHangDB = new ChiTietGioHangDB();
			$this->sanPhamController = new SanPhamController();
		}
		
		// Thêm sản phẩm vào chi tiết giỏ hàng
		public function Them($maGioHang, $maSanPham, $soLuong)
		{
			$sanPham = $this->sanPhamController->LayBangId($maSanPham);
			if (!$sanPham) {
				return ['success' => false, 'message' => 'Sản phẩm không tồn tại!'];
			}
			
			if ($soLuong > $sanPham->getSoLuong()) {
				return ['success' => false, 'message' => "Số lượng yêu cầu ($soLuong) vượt quá số lượng trong kho ({$sanPham->getSoLuong()})!"];
			}
			
			// Kiểm tra xem sản phẩm đã có trong giỏ chưa
			$chiTietList = $this->chiTietGioHangDB->layBangMaGioHang($maGioHang);
			foreach ($chiTietList as $chiTiet) {
				if ($chiTiet->getMaSanPham() == $maSanPham) {
					$newQuantity = $chiTiet->getSoLuong() + $soLuong;
					if ($newQuantity > $sanPham->getSoLuong()) {
						return ['success' => false, 'message' => "Số lượng tổng cộng ($newQuantity) vượt quá số lượng trong kho ({$sanPham->getSoLuong()})!"];
					}
					$chiTiet->setSoLuong($newQuantity);
					$this->chiTietGioHangDB->sua($chiTiet);
					return ['success' => true, 'message' => 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!'];
				}
			}
			
			// Thêm mới nếu sản phẩm chưa có trong giỏ
			$chiTiet = new ChiTietGioHang(null, $maGioHang, $maSanPham, $soLuong);
			$result = $this->chiTietGioHangDB->them($chiTiet);
			if ($result) {
				return ['success' => true, 'message' => 'Đã thêm sản phẩm vào chi tiết giỏ hàng!'];
			}
			return ['success' => false, 'message' => 'Lỗi khi thêm sản phẩm vào giỏ hàng!'];
		}
		
		public function Sua($maChiTiet, $maGioHang, $maSanPham, $soLuong)
		{
			$chiTiet = new ChiTietGioHang($maChiTiet, $maGioHang, $maSanPham, $soLuong);
			return $this->chiTietGioHangDB->sua($chiTiet);
		}
		
		public function Xoa($maChiTiet)
		{
			return $this->chiTietGioHangDB->xoa($maChiTiet);
		}
		
		public function LayTatCa()
		{
			return $this->chiTietGioHangDB->layTatCa();
		}
		
		public function LayBangId($id)
		{
			return $this->chiTietGioHangDB->layBangId($id);
		}
	}