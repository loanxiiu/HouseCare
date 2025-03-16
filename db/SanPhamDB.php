<?php
	namespace BTL\db;
	require_once __DIR__ . '/../db/DatabaseConnect.php';
	require_once __DIR__ . '/../model/SanPham.php';
	
	use BTL\db\DatabaseConnect;
	use BTL\model\SanPham;
	
	class SanPhamDB
	{
		public $conn;
		
		public function __construct()
		{
			$this->conn = DatabaseConnect::getInstance()->getConnection();
		}
		
		// Thêm sản phẩm mới
		public function them(SanPham $sanPham)
		{
			$stmt = $this->conn->prepare("INSERT INTO SanPham (TenSP, DonGia, SoLuong, Anh, MaDM, MoTa) VALUES (?, ?, ?, ?, ?, ?)");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ten = $sanPham->getTen();
			$gia = $sanPham->getGia();
			$soLuong = $sanPham->getSoLuong();
			$anh = $sanPham->getAnh();
			$maDanhMuc = $sanPham->getMaDanhMuc();
			$moTa = $sanPham->getMoTa();

			$stmt->bind_param("sdisi", $ten, $gia, $soLuong, $anh, $maDanhMuc, $moTa);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi thêm sản phẩm: " . $stmt->error;
			}
			
			$stmt->close();
			return $result; // Return true on success, false on failure
		}
		
		// Sửa thông tin sản phẩm
		public function sua(SanPham $sanPham)
		{
			$stmt = $this->conn->prepare("UPDATE SanPham SET TenSP = ?, DonGia = ?, SoLuong = ?, Anh = ?, MaDM = ?, MoTa=? WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			$ma = $sanPham->getMa();
			$ten = $sanPham->getTen();
			$gia = $sanPham->getGia();
			$soLuong = $sanPham->getSoLuong();
			$anh = $sanPham->getAnh();
			$maDanhMuc = $sanPham->getMaDanhMuc();
			$moTa = $sanPham->getMoTa();
			
			$stmt->bind_param("sdisii", $ten, $gia, $soLuong, $anh, $maDanhMuc, $ma);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi sửa sản phẩm: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Xóa sản phẩm theo ID
		public function xoa($id)
		{
			$stmt = $this->conn->prepare("DELETE FROM SanPham WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			// Bind parameter: integer (cast to int since Ma is INT in DB)
			$stmt->bind_param("i", $id);
			
			$result = $stmt->execute();
			if ($result === false) {
				echo "Lỗi xóa sản phẩm: " . $stmt->error;
			}
			
			$stmt->close();
			return $result;
		}
		
		// Lấy tất cả sản phẩm
		public function layTatCa()
		{
			$result = $this->conn->query("SELECT * FROM SanPham");
			if ($result === false) {
				die("Lỗi truy vấn: " . $this->conn->error);
			}
			
			$sanPhams = [];
			while ($row = $result->fetch_assoc()) {
				$sanPham = new SanPham(
					$row['Ma'], // Cast to string to match model
					$row['TenSP'],
					$row['SoLuong'],
					$row['DonGia'],
					$row['Anh'],
					$row['MaDM'],
					$row['MoTa']
				);
				$sanPhams[] = $sanPham;
			}
			
			$result->free();
			return $sanPhams;
		}
		
		// Lấy sản phẩm theo ID
		public function layBangId($id)
		{
			$stmt = $this->conn->prepare("SELECT * FROM SanPham WHERE Ma = ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();
			
			if ($row) {
				$sanPham = new SanPham(
					$row['Ma'],
					$row['TenSP'],
					$row['SoLuong'],
					$row['DonGia'],
					$row['Anh'],
					$row['MaDM'],
					$row['MoTa']
				);
				return $sanPham;
			}
			return null;
		}
		
		// Lấy sản phẩm theo tên (tìm kiếm gần đúng)
		public function layBangTen($ten)
		{
			$stmt = $this->conn->prepare("SELECT * FROM SanPham WHERE TenSP LIKE ?");
			if ($stmt === false) {
				die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
			}
			
			$likeTen = "%$ten%";
			$stmt->bind_param("s", $likeTen);
			$stmt->execute();
			$result = $stmt->get_result();
			$sanPhams = [];
			
			while ($row = $result->fetch_assoc()) {
				$sanPham = new SanPham(
					(string)$row['Ma'],
					$row['TenSP'],
					$row['SoLuong'],
					$row['DonGia'],
					$row['Anh'],
					$row['MaDM'],
					$row['MoTa']
				);
				$sanPhams[] = $sanPham;
			}
			
			$stmt->close();
			return $sanPhams;
		}
	}
	?>