<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/TaiKhoan.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\TaiKhoan;
	
	class TaiKhoanDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm tài khoản mới
		public function them(TaiKhoan $taiKhoan)
		{
			$stmt = $this->conn->prepare("INSERT INTO TaiKhoan (MaUser, MaQuyen, username, password) VALUES (?, ?, ?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$maUser = $taiKhoan->getMaUser();
			$maQuyen = $taiKhoan->getMaQuyen();
			$username = $taiKhoan->getUsername();
			$password = $taiKhoan->getPassword();
			
			$stmt->bind_param("iiss", $maUser, $maQuyen, $username, $password);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm tài khoản: " . $stmt->error;
			}
			
			$stmt->close();
			return $result; // Return true on success, false on failure
		}
		
		// Sửa thông tin tài khoản
		public function sua(TaiKhoan $taiKhoan)
		{
			$stmt = $this->conn->prepare("UPDATE TaiKhoan SET MaUser = ?, MaQuyen = ?, username = ?, password = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ma = $taiKhoan->getMa();
			$maUser = $taiKhoan->getMaUser();
			$maQuyen = $taiKhoan->getMaQuyen();
			$username = $taiKhoan->getUsername();
			$password = $taiKhoan->getPassword();
			
			$stmt->bind_param("iissi", $maUser, $maQuyen, $username, $password, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa tài khoản: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa tài khoản theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM TaiKhoan WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa tài khoản: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả tài khoản
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM TaiKhoan");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$taiKhoans = [];
			while ($row = $result->fetch_assoc()) {
				$taiKhoan = new TaiKhoan();
				$taiKhoan->setMa($row['Ma']);
				$taiKhoan->setMaUser($row['MaUser']);
				$taiKhoan->setMaQuyen($row['MaQuyen']);
				$taiKhoan->setUsername($row['username']);
				$taiKhoan->setPassword($row['password']);
				$taiKhoans[] = $taiKhoan;
			}
			
			$result->free();
			return $taiKhoans;
		}
		
		// Lấy tài khoản theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM TaiKhoan WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$taiKhoan = new TaiKhoan();
				$taiKhoan->setMa($row['Ma']);
				$taiKhoan->setMaUser($row['MaUser']);
				$taiKhoan->setMaQuyen($row['MaQuyen']);
				$taiKhoan->setUsername($row['username']);
				$taiKhoan->setPassword($row['password']);
				return $taiKhoan;
			}
			return null;
		}
		
		// Lấy tài khoản theo username
		public function layBangUsername($username)
		{
			$stmt = $this->conn->prepare("SELECT * FROM TaiKhoan WHERE username = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$taiKhoan = new TaiKhoan();
				$taiKhoan->setMa($row['Ma']);
				$taiKhoan->setMaUser($row['MaUser']);
				$taiKhoan->setMaQuyen($row['MaQuyen']);
				$taiKhoan->setUsername($row['username']);
				$taiKhoan->setPassword($row['password']);
				return $taiKhoan;
			}
			return null;
		}
		
		// Lấy tài khoản theo MaUser
		public function layBangUserId($maUser)
		{
			$stmt = $this->conn->prepare("SELECT * FROM TaiKhoan WHERE MaUser = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $maUser);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$taiKhoan = new TaiKhoan();
				$taiKhoan->setMa($row['Ma']);
				$taiKhoan->setMaUser($row['MaUser']);
				$taiKhoan->setMaQuyen($row['MaQuyen']);
				$taiKhoan->setUsername($row['username']);
				$taiKhoan->setPassword($row['password']);
				return $taiKhoan;
			}
			return null;
		}
		
		// Kiểm tra đăng nhập
		public function kiemTraDangNhap($username, $password)
		{
			$stmt = $this->conn->prepare("SELECT * FROM TaiKhoan WHERE username = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row && password_verify($password, $row['password'])) {
				$taiKhoan = new TaiKhoan();
				$taiKhoan->setMa($row['Ma']);
				$taiKhoan->setMaUser($row['MaUser']);
				$taiKhoan->setMaQuyen($row['MaQuyen']);
				$taiKhoan->setUsername($row['username']);
				$taiKhoan->setPassword($row['password']);
				return $taiKhoan;
			}
			return null;
		}
	}
	?>

