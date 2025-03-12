<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/Admin.php';
	require_once __DIR__ . '/../model/TaiKhoan.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\Admin;
	use BTL\model\TaiKhoan;
	
	class AdminDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm admin mới (thêm vào Users và TaiKhoan với MaQuyen = 1)
		public function them(Admin $admin, $username, $password)
		{
			// Start transaction to ensure both inserts succeed
			$this->conn->begin_transaction();
			
			try {
				// Insert into Users
				$stmt = $this->conn->prepare("INSERT INTO Users (Ten, Email, DiaChi, Anh, MaQuyen) VALUES (?, ?, ?, ?, 1)");
				if ($stmt === false) {
					throw new Exception("Lỗi chuẩn bị câu lệnh Users: " . $this->conn->error);
				}
				
				$ten = $admin->getTen();
				$email = $admin->getEmail();
				$diaChi = $admin->getDiaChi();
				$anh = $admin->getAnh();
				
				$stmt->bind_param("ssss", $ten, $email, $diaChi, $anh);
				$result = $stmt->execute();
				if ($result === false) {
					throw new Exception("Lỗi thêm vào Users: " . $stmt->error);
				}
				
				// Get the last inserted User ID
				$maUser = $this->conn->insert_id;
				$stmt->close();
				
				// Insert into TaiKhoan with MaQuyen = 1
				$stmt = $this->conn->prepare("INSERT INTO TaiKhoan (MaUser, MaQuyen, username, password) VALUES (?, 1, ?, ?)");
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
				$admin->setMa($maUser); // Update object with new ID
				return true;
			} catch (Exception $e) {
				$this->conn->rollback();
				echo $e->getMessage();
				return false;
			}
		}
		
		// Sửa thông tin admin (chỉ cập nhật Users)
		public function sua(Admin $admin)
		{
			$stmt = $this->conn->prepare("UPDATE Users SET Ten = ?, Email = ?, DiaChi = ?, Anh = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$ma = $admin->getMa();
			$ten = $admin->getTen();
			$email = $admin->getEmail();
			$diaChi = $admin->getDiaChi();
			$anh = $admin->getAnh();
			
			$stmt->bind_param("ssssi", $ten, $email, $diaChi, $anh, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa admin: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa admin theo ID (xóa từ Users, TaiKhoan sẽ cần xóa riêng nếu không có CASCADE)
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM Users WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa admin: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả admin (MaQuyen = 1)
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT u.* FROM Users u JOIN TaiKhoan t ON u.Ma = t.MaUser WHERE t.MaQuyen = 1");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$admins = [];
			while ($row = $result->fetch_assoc()) {
				$admin = new Admin(
					(string)$row['Ma'], // Cast to string for consistency
					$row['Ten'],
					$row['Email'],
					$row['DiaChi'],
					$row['Anh']
				);
				$admins[] = $admin;
			}
			
			$result->free();
			return $admins;
		}
		
		// Lấy admin theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT u.* FROM Users u JOIN TaiKhoan t ON u.Ma = t.MaUser WHERE u.Ma = ? AND t.MaQuyen = 1");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				return new Admin(
					(string)$row['Ma'],
					$row['Ten'],
					$row['Email'],
					$row['DiaChi'],
					$row['Anh']
				);
			}
			return null;
		}
		
		// Lấy admin theo email
		public function layBangEmail($email)
		{
			$stmt = $this->conn->prepare("SELECT u.* FROM Users u JOIN TaiKhoan t ON u.Ma = t.MaUser WHERE u.Email LIKE ? AND t.MaQuyen = 1");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$likeEmail = "%$email%";
			$stmt->bind_param("s", $likeEmail);
			$stmt->execute();
			$result = $stmt->get_result();
			$admins = [];
			
			while ($row = $result->fetch_assoc()) {
				$admin = new Admin(
					(string)$row['Ma'],
					$row['Ten'],
					$row['Email'],
					$row['DiaChi'],
					$row['Anh']
				);
				$admins[] = $admin;
			}
			
			$stmt->close();
			return $admins;
		}
	}
	?>