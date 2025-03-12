<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/DanhMuc.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\DanhMuc;
	
	class DanhMucDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm danh mục mới
		public function them(DanhMuc $danhMuc)
		{
			$stmt = $this->conn->prepare("INSERT INTO DanhMuc (Ten) VALUES (?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ten = $danhMuc->getTen();
			
			$stmt->bind_param("s", $ten);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm danh mục: " . $stmt->error;
			}
			
			$stmt->close();
			return $result; // Return true on success, false on failure
		}
		
		// Sửa thông tin danh mục
		public function sua(DanhMuc $danhMuc)
		{
			$stmt = $this->conn->prepare("UPDATE DanhMuc SET Ten = ? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ma = $danhMuc->getMa();
			$ten = $danhMuc->getTen();
			
			$stmt->bind_param("si", $ten, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa danh mục: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa danh mục theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM DanhMuc WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			// Bind parameter: integer (cast to int since Ma is INT in DB)
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa danh mục: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả danh mục
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM DanhMuc");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$danhMucs = [];
			while ($row = $result->fetch_assoc()) {
				$danhMuc = new DanhMuc(
					$row['Ma'],
					$row['Ten']
				);
				$danhMucs[] = $danhMuc;
			}
			
			$result->free();
			return $danhMucs;
		}
		
		// Lấy danh mục theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM DanhMuc WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$danhMuc = new DanhMuc();
				$danhMuc->setMa($row['Ma']);
				$danhMuc->setTen($row['Ten']);
				return $danhMuc;
			}
			return null;
		}
		
		// Lấy danh mục theo tên (tìm kiếm gần đúng)
		public function layBangTen($ten)
		{
			$stmt = $this->conn->prepare("SELECT * FROM DanhMuc WHERE Ten LIKE ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$likeTen = "%$ten%";
			$stmt->bind_param("s", $likeTen);
			$stmt->execute();
			$result = $stmt->get_result();
			$danhMucs = [];
			
			while ($row = $result->fetch_assoc()) {
				$danhMuc = new DanhMuc();
				$danhMuc->setMa($row['Ma']);
				$danhMuc->setTen($row['Ten']);
				$danhMucs[] = $danhMuc;
			}
			
			$stmt->close();
			return $danhMucs;
		}
	}
	?>