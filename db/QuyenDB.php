<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/Quyen.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\Quyen;
	
	class QuyenDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm quyền mới
		public function them(Quyen $quyen)
		{
			$stmt = $this->conn->prepare("INSERT INTO Quyen (Ten) VALUES (?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ten = $quyen->getTen();
			
			$stmt->bind_param("s", $ten);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm quyền: " . $stmt->error;
			}
			
			$stmt->close();
			return $result; // Return true on success, false on failure
		}
		
		// Sửa thông tin quyền
		public function sua(Quyen $quyen)
		{
			$stmt = $this->conn->prepare("UPDATE Quyen SET Ten = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ma = $quyen->getMa();
			$ten = $quyen->getTen();
			
			$stmt->bind_param("si", $ten, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa quyền: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa quyền theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM Quyen WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			// Bind parameter: integer (cast to int since Ma is INT in DB)
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa quyền: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả quyền
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM Quyen");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$quyens = [];
			while ($row = $result->fetch_assoc()) {
				$quyen = new Quyen();
				$quyen->setMa($row['Ma']);
				$quyen->setTen($row['Ten']);
				$quyens[] = $quyen;
			}
			
			$result->free();
			return $quyens;
		}
		
		// Lấy quyền theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM Quyen WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$quyen = new Quyen();
				$quyen->setMa($row['Ma']);
				$quyen->setTen($row['Ten']);
				return $quyen;
			}
			return null;
		}
		
		// Lấy quyền theo tên (tìm kiếm gần đúng)
		public function layBangTen($ten)
		{
			$stmt = $this->conn->prepare("SELECT * FROM Quyen WHERE Ten LIKE ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$likeTen = "%$ten%";
			$stmt->bind_param("s", $likeTen);
			$stmt->execute();
			$result = $stmt->get_result();
			$quyens = [];
			
			while ($row = $result->fetch_assoc()) {
				$quyen = new Quyen();
				$quyen->setMa($row['Ma']);
				$quyen->setTen($row['Ten']);
				$quyens[] = $quyen;
			}
			
			$stmt->close();
			return $quyens;
		}
	}
	?>