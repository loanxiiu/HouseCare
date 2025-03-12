<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/ChiTietDonHang.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\ChiTietDonHang;
	
	class ChiTietDonHangDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm chi tiết đơn hàng mới
		public function them(ChiTietDonHang $chiTiet)
		{
			$stmt = $this->conn->prepare("INSERT INTO ChiTietDonHang (MaDonHang, MaSP, SoLuong) VALUES (?, ?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$maDH = $chiTiet->getMaDH();
			$maSP = $chiTiet->getMaSP();
			$soLuong = $chiTiet->getSoluong();
			
			// Bind parameters: integer (MaDonHang), integer (MaSP), integer (SoLuong)
			$stmt->bind_param("iii", $maDH, $maSP, $soLuong);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm chi tiết đơn hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Sửa thông tin chi tiết đơn hàng
		public function sua(ChiTietDonHang $chiTiet)
		{
			$stmt = $this->conn->prepare("UPDATE ChiTietDonHang SET MaDonHang = ?, MaSP = ?, SoLuong = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$ma = $chiTiet->getMa();
			$maDH = $chiTiet->getMaDH();
			$maSP = $chiTiet->getMaSP();
			$soLuong = $chiTiet->getSoluong();
			
			// Bind parameters: integer, integer, integer, integer (Ma)
			$stmt->bind_param("iiii", $maDH, $maSP, $soLuong, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa chi tiết đơn hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa chi tiết đơn hàng theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM ChiTietDonHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa chi tiết đơn hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả chi tiết đơn hàng
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM ChiTietDonHang");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$chiTietDonHangs = [];
			while ($row = $result->fetch_assoc()) {
				$chiTiet = new ChiTietDonHang(
					(string)$row['Ma'], // Cast to string for consistency
					$row['MaDonHang'],
					$row['MaSP'],
					$row['SoLuong']
				);
				$chiTietDonHangs[] = $chiTiet;
			}
			
			$result->free();
			return $chiTietDonHangs;
		}
		
		// Lấy chi tiết đơn hàng theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM ChiTietDonHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				return new ChiTietDonHang(
					(string)$row['Ma'],
					$row['MaDonHang'],
					$row['MaSP'],
					$row['SoLuong']
				);
			}
			return null;
		}
		
		// Lấy chi tiết đơn hàng theo mã đơn hàng
		public function layBangMaDonHang($maDonHang)
		{
			$stmt = $this->conn->prepare("SELECT * FROM ChiTietDonHang WHERE MaDonHang = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maDonHang);
			$stmt->execute();
			$result = $stmt->get_result();
			$chiTietDonHangs = [];
			
			while ($row = $result->fetch_assoc()) {
				$chiTiet = new ChiTietDonHang(
					(string)$row['Ma'],
					$row['MaDonHang'],
					$row['MaSP'],
					$row['SoLuong']
				);
				$chiTietDonHangs[] = $chiTiet;
			}
			
			$stmt->close();
			return $chiTietDonHangs;
		}
	}
	?>