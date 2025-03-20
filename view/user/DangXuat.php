<?php
// user/logout.php
	session_start();

// Xóa tất cả các biến session
	session_unset();

// Hủy session
	session_destroy();

// Chuyển hướng về trang chủ hoặc trang đăng nhập
	header("Location: ../user/DangNhap.php"); // Hoặc có thể chuyển về "../khachhang/TrangChu.php"
	exit();
?>