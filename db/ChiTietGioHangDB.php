<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/ChiTietGioHang.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\ChiTietGioHang;
	
	class ChiTietGioHangDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm chi tiết giỏ hàng mới
		public function them(ChiTietGioHang $chiTiet)
		{
			$stmt = $this->conn->prepare("INSERT INTO ChiTietGioHang (MaGioHang, MaSP, SoLuong) VALUES (?, ?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$maGioHang = $chiTiet->getMaGioHang();
			$maSanPham = $chiTiet->getMaSanPham();
			$soLuong = $chiTiet->getSoLuong();
			
			// Bind parameters: integer (MaGioHang), integer (MaSP), integer (SoLuong)
			$stmt->bind_param("iii", $maGioHang, $maSanPham, $soLuong);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm chi tiết giỏ hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Sửa thông tin chi tiết giỏ hàng
		public function sua(ChiTietGioHang $chiTiet)
		{
			$stmt = $this->conn->prepare("UPDATE ChiTietGioHang SET MaGioHang = ?, MaSP = ?, SoLuong = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$ma = $chiTiet->getMa();
			$maGioHang = $chiTiet->getMaGioHang();
			$maSanPham = $chiTiet->getMaSanPham();
			$soLuong = $chiTiet->getSoLuong();
			
			// Bind parameters: integer, integer, integer, integer (Ma)
			$stmt->bind_param("iiii", $maGioHang, $maSanPham, $soLuong, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa chi tiết giỏ hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa chi tiết giỏ hàng theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM ChiTietGioHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa chi tiết giỏ hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả chi tiết giỏ hàng
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM ChiTietGioHang");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$chiTietGioHangs = [];
			while ($row = $result->fetch_assoc()) {
				$chiTiet = new ChiTietGioHang(
					(string)$row['Ma'], // Cast to string for consistency
					$row['MaGioHang'],
					$row['MaSP'],
					$row['SoLuong']
				);
				$chiTietGioHangs[] = $chiTiet;
			}
			
			$result->free();
			return $chiTietGioHangs;
		}
		
		// Lấy chi tiết giỏ hàng theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM ChiTietGioHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				return new ChiTietGioHang(
					(string)$row['Ma'],
					$row['MaGioHang'],
					$row['MaSP'],
					$row['SoLuong']
				);
			}
			return null;
		}
		
		// Lấy chi tiết giỏ hàng theo mã giỏ hàng
		public function layBangMaGioHang($maGioHang)
		{
			$stmt = $this->conn->prepare("SELECT * FROM ChiTietGioHang WHERE MaGioHang = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maGioHang);
			$stmt->execute();
			$result = $stmt->get_result();
			$chiTietGioHangs = [];
			
			while ($row = $result->fetch_assoc()) {
				$chiTiet = new ChiTietGioHang(
					(string)$row['Ma'],
					$row['MaGioHang'],
					$row['MaSP'],
					$row['SoLuong']
				);
				$chiTietGioHangs[] = $chiTiet;
			}
			
			$stmt->close();
			return $chiTietGioHangs;
		}
		public function xoaTheoMaGioHang($maGioHang)
		{
			$stmt = $this->conn->prepare("DELETE FROM ChiTietGioHang WHERE MaGioHang = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maGioHang);
			$result = $stmt->execute();
			$stmt->close();
			return $result;
		}
	}
	?>