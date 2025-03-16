<?php
	
	namespace BTL\db;
	
	use mysqli;
	
	class DatabaseConnect
	{
		private static ?DatabaseConnect $instance = null;
		private mysqli $conn;
		
		private string $servername = "localhost";
		private string $username = "root";
		private string $password = "12341234";
		private string $dbname = "shop_gia_dung";
		
		// Constructor private để ngăn việc khởi tạo từ bên ngoài
		private function __construct()
		{
			// Kết nối đến MySQL
			$this->conn = new mysqli($this->servername, $this->username, $this->password);
			
			if ($this->conn->connect_error) {
				die("Kết nối thất bại: " . $this->conn->connect_error);
			}
			
			// Tạo database nếu chưa có
			$sql = "CREATE DATABASE IF NOT EXISTS {$this->dbname}";
			if (!$this->conn->query($sql)) {
				die("Không tạo được database: " . $this->conn->error);
			}
			
			// Kết nối lại với database vừa tạo
			$this->conn->close();
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			
			if ($this->conn->connect_error) {
				die("Kết nối thất bại: " . $this->conn->connect_error);
			}
			
			$DanhMuc_tbl = "CREATE TABLE IF NOT EXISTS DanhMuc (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    Ten NVARCHAR(100) NOT NULL)";
			
			$SanPham_tbl = "CREATE TABLE IF NOT EXISTS SanPham(
				Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    TenSP NVARCHAR(100) NOT NULL,
    MoTa NVARCHAR(1000),
    DonGia FLOAT(15) NOT NULL,
    SoLuong INT(6) NOT NULL,
    Anh NVARCHAR(100) NOT NULL,
    MaDM INT(6) NOT NULL REFERENCES DanhMuc (Ma)
)";
			
			$Quyen_tbl = "CREATE TABLE IF NOT EXISTS Quyen (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    Ten NVARCHAR(100) NOT NULL)";
			
			$User_tbl = "CREATE TABLE IF NOT EXISTS Users (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    Ten NVARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    DiaChi NVARCHAR(100) NOT NULL,
    Anh VARCHAR(100) NOT NULL,
    MaQuyen INT(6) NOT NULL REFERENCES Quyen (Ma))";
			
			$TaiKhoan_tbl = "CREATE TABLE IF NOT EXISTS TaiKhoan (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    MaUser INT(6) NOT NULL REFERENCES Users (Ma),
    MaQuyen INT(6) NOT NULL REFERENCES Quyen (Ma),
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL)";
			
			$GioHang_tbl = "CREATE TABLE IF NOT EXISTS GioHang (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    MaKhachHang INT(6) NOT NULL REFERENCES Users (Ma),
    DonGia FLOAT(15) NOT NULL)";
			
			$ChiTietGioHang_tbl = "CREATE TABLE IF NOT EXISTS ChiTietGioHang (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    MaGioHang INT(6) NOT NULL REFERENCES GioHang (Ma),
    MaSP INT(6) NOT NULL REFERENCES SanPham (Ma),
    SoLuong INT(6) NOT NULL)";
			
			$DonHang_tbl = "CREATE TABLE IF NOT EXISTS DonHang (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    DonGia FLOAT(15) NOT NULL,
    NgayBan DATE NOT NULL,
    MaKhachHang INT(6) NOT NULL REFERENCES Users (Ma),
    MaNhanVien INT(6) NOT NULL REFERENCES Users (Ma))";
			
			$ChiTietDonHang_tbl = "CREATE TABLE IF NOT EXISTS ChiTietDonHang (
     Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
     MaDonHang INT(6) NOT NULL REFERENCES DonHang (Ma),
     MaSP INT(6) NOT NULL REFERENCES SanPham (Ma),
     SoLuong INT(6) NOT NULL)";
			
			$ThanhToan_tbl = "CREATE TABLE IF NOT EXISTS ThanhToan (
    Ma INT(6) PRIMARY KEY AUTO_INCREMENT,
    MaDonHang INT(6) NOT NULL REFERENCES DonHang (Ma),
    NgayTao DATE NOT NULL,
    TongTien FLOAT(6) NOT NULL,
    MaKhachHang INT(6) NOT NULL REFERENCES Users (Ma),
    PhuongThucTT NVARCHAR(100) NOT NULL,
    TrangThai NVARCHAR(100) NOT NULL)";
			
			if ($this->conn->query($User_tbl) === TRUE
				&& $this->conn->query($Quyen_tbl) === TRUE
				&& $this->conn->query($DanhMuc_tbl) === TRUE
				&& $this->conn->query($SanPham_tbl) === TRUE
				&& $this->conn->query($DonHang_tbl) === TRUE
				&& $this->conn->query($ChiTietDonHang_tbl) === TRUE
				&& $this->conn->query($TaiKhoan_tbl) === TRUE
				&& $this->conn->query($GioHang_tbl) === TRUE
				&& $this->conn->query($ChiTietGioHang_tbl) === TRUE
				&& $this->conn->query($ThanhToan_tbl) === TRUE) {
//				echo "Tạo bảng thành công";
				return True;
			} else {
//				echo "Lỗi tạo bảng: " . $this->conn->error;
				return False;
			}
		}
		
		
		// Phương thức lấy instance duy nhất
		public static function getInstance(): DatabaseConnect
		{
			if (self::$instance === null) {
				self::$instance = new DatabaseConnect();
			}
			return self::$instance;
		}
		
		// Phương thức lấy kết nối
		public function getConnection(): mysqli
		{
			return $this->conn;
		}
	}
