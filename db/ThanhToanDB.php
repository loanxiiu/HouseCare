<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/ThanhToan.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\ThanhToan;
	
	class ThanhToanDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm thanh toán mới
		public function them(ThanhToan $thanhToan)
		{
			$stmt = $this->conn->prepare("INSERT INTO ThanhToan (MaDonHang, NgayTao, TongTien, MaKhachHang, PhuongThucThanhToan, TrangThai) VALUES (?, ?, ?, ?, ?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$maDonHang = $thanhToan->getMaDonHang();
			$ngayTao = $thanhToan->getNgayTao();
			$tongTien = $thanhToan->getTongTien();
			$maKhachHang = $thanhToan->getMaKhachHang();
			$phuongThucThanhToan = $thanhToan->getPhuongThucThanhToan();
			$trangThai = $thanhToan->getTrangThai();
			
			// Bind parameters: integer (MaDonHang), string (NgayTao), double (TongTien), integer (MaKhachHang), string (PhuongThucThanhToan), string (TrangThai)
			$stmt->bind_param("isdiss", $maDonHang, $ngayTao, $tongTien, $maKhachHang, $phuongThucThanhToan, $trangThai);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm thanh toán: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Sửa thông tin thanh toán
		public function sua(ThanhToan $thanhToan)
		{
			$stmt = $this->conn->prepare("UPDATE ThanhToan SET MaDonHang = ?, NgayTao = ?, TongTien = ?, MaKhachHang = ?, PhuongThucThanhToan = ?, TrangThai = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$ma = $thanhToan->getMa();
			$maDonHang = $thanhToan->getMaDonHang();
			$ngayTao = $thanhToan->getNgayTao();
			$tongTien = $thanhToan->getTongTien();
			$maKhachHang = $thanhToan->getMaKhachHang();
			$phuongThucThanhToan = $thanhToan->getPhuongThucThanhToan();
			$trangThai = $thanhToan->getTrangThai();
			
			// Bind parameters: integer, string, double, integer, string, string, integer (Ma)
			$stmt->bind_param("isdisss", $maDonHang, $ngayTao, $tongTien, $maKhachHang, $phuongThucThanhToan, $trangThai, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa thanh toán: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa thanh toán theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM ThanhToan WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa thanh toán: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả thanh toán
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM ThanhToan");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$thanhToans = [];
			while ($row = $result->fetch_assoc()) {
				$thanhToan = new ThanhToan(
					(string)$row['Ma'], // Cast to string for consistency
					$row['MaDonHang'],
					$row['NgayTao'],
					$row['TongTien'],
					$row['MaKhachHang'],
					$row['PhuongThucThanhToan'],
					$row['TrangThai']
				);
				$thanhToans[] = $thanhToan;
			}
			
			$result->free();
			return $thanhToans;
		}
		
		// Lấy thanh toán theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM ThanhToan WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				return new ThanhToan(
					(string)$row['Ma'],
					$row['MaDonHang'],
					$row['NgayTao'],
					$row['TongTien'],
					$row['MaKhachHang'],
					$row['PhuongThucThanhToan'],
					$row['TrangThai']
				);
			}
			return null;
		}
		
		// Lấy thanh toán theo mã đơn hàng
		public function layBangMaDonHang($maDonHang)
		{
			$stmt = $this->conn->prepare("SELECT * FROM ThanhToan WHERE MaDonHang = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maDonHang);
			$stmt->execute();
			$result = $stmt->get_result();
			$thanhToans = [];
			
			while ($row = $result->fetch_assoc()) {
				$thanhToan = new ThanhToan(
					(string)$row['Ma'],
					$row['MaDonHang'],
					$row['NgayTao'],
					$row['TongTien'],
					$row['MaKhachHang'],
					$row['PhuongThucThanhToan'],
					$row['TrangThai']
				);
				$thanhToans[] = $thanhToan;
			}
			
			$stmt->close();
			return $thanhToans;
		}
	}
	?>