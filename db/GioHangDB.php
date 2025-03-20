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
			
			if ($result) {
				$gioHang->setMa($this->conn->insert_id);
			}
			
			$stmt->close();
			return $result;
		}
		
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
		
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM GioHang");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$gioHangs = [];
			while ($row = $result->fetch_assoc()) {
				$gioHang = new GioHang(
					$row['Ma'],
					$row['MaKhachHang'],
					$row['DonGia']
				);
				$gioHangs[] = $gioHang;
			}
			
			$result->free();
			return $gioHangs;
		}
		
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
				$gioHang = new GioHang(
					$row['Ma'],
					$row['MaKhachHang'],
					$row['DonGia']
				);
				return $gioHang;
			}
			return null;
		}
		
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
				$gioHang = new GioHang(
					$row['Ma'],
					$row['MaKhachHang'],
					$row['DonGia']
				);
				return $gioHang;
			}
			return null;
		}
		
		public function layHoacTaoGioHang($maKhachHang)
		{
			$gioHang = $this->layBangMaKhachHang($maKhachHang);
			
			if ($gioHang === null) {
				$gioHang = new GioHang(null, $maKhachHang, 0);
				$this->them($gioHang);
			}
			
			return $gioHang;
		}
		
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