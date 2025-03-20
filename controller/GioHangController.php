<?php
	namespace BTL\controller;
	
	use BTL\db\GioHangDB;
	use BTL\model\GioHang;
	use BTL\db\ChiTietGioHangDB;
	
	require_once __DIR__ . '/../db/GioHangDB.php';
	require_once __DIR__ . '/../model/GioHang.php';
	require_once __DIR__ . '/../db/ChiTietGioHangDB.php';
	require_once __DIR__ . '/../model/ChiTietGioHang.php';
	require_once __DIR__ . '/ChiTietGioHangController.php';
	
	class GioHangController
	{
		private $gioHangDB;
		private $chiTietGioHangDB;
		private $chiTietGioHangController;
		
		public function __construct()
		{
			$this->gioHangDB = new GioHangDB();
			$this->chiTietGioHangDB = new ChiTietGioHangDB();
			$this->chiTietGioHangController = new ChiTietGioHangController();
		}
		
		// Phương thức thêm sản phẩm vào giỏ hàng
		public function ThemSanPhamVaoGioHang($maSanPham, $soLuong)
		{
			if (!isset($_SESSION['ma'])) {
				return ['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm!'];
			}
			
			$maKhachHang = $_SESSION['ma'];
			$gioHang = $this->gioHangDB->layHoacTaoGioHang($maKhachHang);
			if (!$gioHang) {
				return ['success' => false, 'message' => 'Không thể tạo hoặc lấy giỏ hàng!'];
			}
			
			// Gọi ChiTietGioHangController để thêm chi tiết
			$result = $this->chiTietGioHangController->Them($gioHang->getMa(), $maSanPham, $soLuong);
			if ($result['success']) {
				$this->CapNhatDonGia($gioHang->getMa());
				return ['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng!'];
			}
			return $result; // Trả về kết quả từ ChiTietGioHangController
		}
		
		// Các phương thức hiện có
		public function Them()
		{
			if (!isset($_SESSION['ma'])) {
				return false; // User must be logged in
			}
			
			$maKhachHang = $_SESSION['ma'];
			$gioHang = $this->gioHangDB->layHoacTaoGioHang($maKhachHang);
			return $gioHang->getMa() ? true : false;
		}
		
		public function Sua()
		{
			if (!isset($_POST['ma_gio_hang']) || !isset($_POST['don_gia'])) {
				return false;
			}
			
			$gioHang = new GioHang($_POST['ma_gio_hang'], $_SESSION['ma'], $_POST['don_gia']);
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
			if (!isset($_SESSION['ma'])) {
				return null;
			}
			
			$maKhachHang = $_SESSION['ma'];
			$gioHang = $this->gioHangDB->layHoacTaoGioHang($maKhachHang);
			if ($gioHang) {
				$chiTietGioHangs = $this->chiTietGioHangDB->layBangMaGioHang($gioHang->getMa());
				$gioHang->setChiTietGioHangs($chiTietGioHangs);
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