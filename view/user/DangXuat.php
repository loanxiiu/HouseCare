<?php
	session_start();
	require_once __DIR__ . '/../../controller/TaiKhoanController.php';
	
	use BTL\controller\TaiKhoanController;
	
	$controller = new TaiKhoanController();

// Clear remember token if exists
	if (isset($_SESSION['ma'])) {
		$controller->clearRememberToken($_SESSION['ma']);
	}

// Clear cookies
	setcookie('remember_token', '', time() - 3600, "/");
	setcookie('username', '', time() - 3600, "/");

// Clear session
	session_destroy();
	
	header("Location: /view/khachhang/TrangChu.php");
	exit();
?>