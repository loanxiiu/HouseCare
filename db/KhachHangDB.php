<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/KhachHang.php';
	
	use BTL\model\KhachHang;
	
	class KhachHangDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm khách hàng mới (thêm vào Users và TaiKhoan với MaQuyen = 2)
		public function them(KhachHang $khachHang, $username, $password)
		{
			// Start transaction to ensure both inserts succeed
			$this->conn->begin_transaction();
			
			try {
				// Insert into Users
				$stmt = $this->conn->prepare("INSERT INTO Users (Ten, Email, DiaChi, Anh) VALUES (?, ?, ?, ?)");
				if ($stmt === false) {
					throw new Exception("Lỗi chuẩn bị câu lệnh Users: " . $this->conn->error);
				}
				
				$ten = $khachHang->getTen();
				$email = $khachHang->getEmail();
				$diaChi = $khachHang->getDiaChi();
				$anh = $khachHang->getAnh();
				
				$stmt->bind_param("ssss", $ten, $email, $diaChi, $anh);
				$result = $stmt->execute();
				if ($result === false) {
					throw new Exception("Lỗi thêm vào Users: " . $stmt->error);
				}
				
				// Get the last inserted User ID
				$maUser = $this->conn->insert_id;
				$stmt->close();
				
				// Insert into TaiKhoan with MaQuyen = 2
				$stmt = $this->conn->prepare("INSERT INTO TaiKhoan (MaUser, MaQuyen, username, password) VALUES (?, 2, ?, ?)");
				if ($stmt === false) {
					throw new Exception("Lỗi chuẩn bị câu lệnh TaiKhoan: " . $this->conn->error);
				}
				
				$stmt->bind_param("iss", $maUser, $username, $password);
				$result = $stmt->execute();
				if ($result === false) {
					throw new Exception("Lỗi thêm vào TaiKhoan: " . $stmt->error);
				}
				
				$stmt->close();
				
				// Commit transaction
				$this->conn->commit();
				$khachHang->setMa($maUser); // Update object with new ID
				return true;
			} catch (Exception $e) {
				$this->conn->rollback();
				echo $e->getMessage();
				return false;
			}
		}
		
		// Sửa thông tin khách hàng (chỉ cập nhật Users)
		public function sua(KhachHang $khachHang)
		{
			$stmt = $this->conn->prepare("UPDATE Users SET Ten = ?, Email = ?, DiaChi = ?, Anh = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$ma = $khachHang->getMa();
			$ten = $khachHang->getTen();
			$email = $khachHang->getEmail();
			$diaChi = $khachHang->getDiaChi();
			$anh = $khachHang->getAnh();
			
			$stmt->bind_param("ssssi", $ten, $email, $diaChi, $anh, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa khách hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa khách hàng theo ID (xóa từ Users, TaiKhoan sẽ cần xóa riêng nếu không có CASCADE)
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM Users WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa khách hàng: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả khách hàng (MaQuyen = 2)
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT u.* FROM Users u JOIN TaiKhoan t ON u.Ma = t.MaUser WHERE t.MaQuyen = 2");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$khachHangs = [];
			while ($row = $result->fetch_assoc()) {
				$khachHang = new KhachHang(
					(string)$row['Ma'], // Cast to string for consistency
					$row['Ten'],
					$row['Email'],
					$row['DiaChi'],
					$row['Anh']
				);
				$khachHangs[] = $khachHang;
			}
			
			$result->free();
			return $khachHangs;
		}
		
		// Lấy khách hàng theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT u.* FROM Users u JOIN TaiKhoan t ON u.Ma = t.MaUser WHERE u.Ma = ? AND t.MaQuyen = 2");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				return new KhachHang(
					(string)$row['Ma'],
					$row['Ten'],
					$row['Email'],
					$row['DiaChi'],
					$row['Anh']
				);
			}
			return null;
		}
		
		// Lấy khách hàng theo email
		public function layBangEmail($email)
		{
			$stmt = $this->conn->prepare("SELECT u.* FROM Users u JOIN TaiKhoan t ON u.Ma = t.MaUser WHERE u.Email LIKE ? AND t.MaQuyen = 2");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$likeEmail = "%$email%";
			$stmt->bind_param("s", $likeEmail);
			$stmt->execute();
			$result = $stmt->get_result();
			$khachHangs = [];
			
			while ($row = $result->fetch_assoc()) {
				$khachHang = new KhachHang(
					(string)$row['Ma'],
					$row['Ten'],
					$row['Email'],
					$row['DiaChi'],
					$row['Anh']
				);
				$khachHangs[] = $khachHang;
			}
			
			$stmt->close();
			return $khachHangs;
		}
	}
	?>