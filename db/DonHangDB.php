<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/DonHang.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\DonHang;
	
	class DonHangDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm đơn hàng mới
		public function them(DonHang $donHang)
		{
			$stmt = $this->conn->prepare("INSERT INTO DonHang (DonGia, NgayBan, MaKhachHang, MaNhanVien) VALUES (?, ?, ?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$donGia = $donHang->getDonGia();
			$ngayBan = $donHang->getNgayBan();
			$maKhachHang = $donHang->getMaKhachHang();
			$maNhanVien = $donHang->getMaNhanVien();
			
			// Bind parameters: double (DonGia), string (NgayBan), integer (MaKhachHang), integer (MaNhanVien)
			$stmt->bind_param("dsii", $donGia, $ngayBan, $maKhachHang, $maNhanVien);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm đơn hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Sửa thông tin đơn hàng
		public function sua(DonHang $donHang)
		{
			$stmt = $this->conn->prepare("UPDATE DonHang SET DonGia = ?, NgayBan = ?, MaKhachHang = ?, MaNhanVien = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$ma = $donHang->getMa();
			$donGia = $donHang->getDonGia();
			$ngayBan = $donHang->getNgayBan();
			$maKhachHang = $donHang->getMaKhachHang();
			$maNhanVien = $donHang->getMaNhanVien();
			
			// Bind parameters: double, string, integer, integer, integer (Ma)
			$stmt->bind_param("dsiii", $donGia, $ngayBan, $maKhachHang, $maNhanVien, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa đơn hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa đơn hàng theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM DonHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa đơn hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả đơn hàng
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM DonHang");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$donHangs = [];
			while ($row = $result->fetch_assoc()) {
				$donHang = new DonHang(
					(string)$row['Ma'], // Cast to string for consistency with SanPham
					$row['DonGia'],
					$row['NgayBan'],
					$row['MaKhachHang'],
					$row['MaNhanVien']
				);
				$donHangs[] = $donHang;
			}
			
			$result->free();
			return $donHangs;
		}
		
		// Lấy đơn hàng theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM DonHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				return new DonHang(
					(string)$row['Ma'],
					$row['DonGia'],
					$row['NgayBan'],
					$row['MaKhachHang'],
					$row['MaNhanVien']
				);
			}
			return null;
		}
		
		// Lấy đơn hàng theo ngày bán (tìm kiếm chính xác)
		public function layBangNgay($ngayBan)
		{
			$stmt = $this->conn->prepare("SELECT * FROM DonHang WHERE NgayBan = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("s", $ngayBan); // Date as string (e.g., "2025-03-11")
			$stmt->execute();
			$result = $stmt->get_result();
			$donHangs = [];
			
			while ($row = $result->fetch_assoc()) {
				$donHang = new DonHang(
					(string)$row['Ma'],
					$row['DonGia'],
					$row['NgayBan'],
					$row['MaKhachHang'],
					$row['MaNhanVien']
				);
				$donHangs[] = $donHang;
			}
			
			$stmt->close();
			return $donHangs;
		}
	}
	?>