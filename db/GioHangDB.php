<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/GioHang.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\GioHang;
	
	class GioHangDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm giỏ hàng mới
		public function them(GioHang $gioHang)
		{
			$stmt = $this->conn->prepare("INSERT INTO GioHang (MaKhachHang, DonGia) VALUES (?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$maKhachHang = $gioHang->getMaKhachHang();
			$donGia = $gioHang->getDonGia();
			
			$stmt->bind_param("id", $maKhachHang, $donGia);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm giỏ hàng: " . $stmt->error;
			}
			
			// Lấy ID của giỏ hàng vừa thêm
			if ($result) {
				$gioHang->setMa($this->conn->insert_id);
			}
			
			$stmt->close();
			return $result; // Return true on success, false on failure
		}
		
		// Sửa thông tin giỏ hàng
		public function sua(GioHang $gioHang)
		{
			$stmt = $this->conn->prepare("UPDATE GioHang SET MaKhachHang = ?, DonGia = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ma = $gioHang->getMa();
			$maKhachHang = $gioHang->getMaKhachHang();
			$donGia = $gioHang->getDonGia();
			
			$stmt->bind_param("idi", $maKhachHang, $donGia, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa giỏ hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa giỏ hàng theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM GioHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa giỏ hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả giỏ hàng
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM GioHang");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$gioHangs = [];
			while ($row = $result->fetch_assoc()) {
				$gioHang = new GioHang();
				$gioHang->setMa($row['Ma']);
				$gioHang->setMaKhachHang($row['MaKhachHang']);
				$gioHang->setDonGia($row['DonGia']);
				$gioHangs[] = $gioHang;
			}
			
			$result->free();
			return $gioHangs;
		}
		
		// Lấy giỏ hàng theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM GioHang WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$gioHang = new GioHang();
				$gioHang->setMa($row['Ma']);
				$gioHang->setMaKhachHang($row['MaKhachHang']);
				$gioHang->setDonGia($row['DonGia']);
				return $gioHang;
			}
			return null;
		}
		
		// Lấy giỏ hàng theo mã khách hàng
		public function layBangMaKhachHang($maKhachHang)
		{
			$stmt = $this->conn->prepare("SELECT * FROM GioHang WHERE MaKhachHang = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maKhachHang);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$gioHang = new GioHang();
				$gioHang->setMa($row['Ma']);
				$gioHang->setMaKhachHang($row['MaKhachHang']);
				$gioHang->setDonGia($row['DonGia']);
				return $gioHang;
			}
			return null;
		}
		
		// Lấy hoặc tạo giỏ hàng theo mã khách hàng
		public function layHoacTaoGioHang($maKhachHang)
		{
			$gioHang = $this->layBangMaKhachHang($maKhachHang);
			
			if ($gioHang === null) {
				// Nếu khách hàng chưa có giỏ hàng, tạo mới
				$gioHang = new GioHang();
				$gioHang->setMaKhachHang($maKhachHang);
				$gioHang->setDonGia(0); // Giỏ hàng mới có giá trị = 0
				$this->them($gioHang);
			}
			
			return $gioHang;
		}
		
		// Cập nhật tổng đơn giá của giỏ hàng
		public function capNhatDonGia($maGioHang)
		{
			$sql = "SELECT SUM(ct.SoLuong * sp.DonGia) as TongGia
                FROM ChiTietGioHang ct
                JOIN SanPham sp ON ct.MaSP = sp.Ma
                WHERE ct.MaGioHang = ?";
			
			$stmt = $this->conn->prepare($sql);
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maGioHang);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			$tongGia = ($row && $row['TongGia']) ? $row['TongGia'] : 0;
			
			// Cập nhật đơn giá của giỏ hàng
			$updateStmt = $this->conn->prepare("UPDATE GioHang SET DonGia = ? WHERE Ma = ?");
			if ($updateStmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$updateStmt->bind_param("di", $tongGia, $maGioHang);
			$result = $updateStmt->execute();
			$updateStmt->close();
			
			return $result;
		}
	}
	?>