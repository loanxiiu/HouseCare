<?php
	session_start();
	require_once __DIR__ . '/../../../controller/GioHangController.php';
	
	use BTL\controller\GioHangController;
	
	$controller = new GioHangController();
	$maChiTiet = $_GET['ma_chi_tiet'] ?? null;
	$soLuong = $_GET['so_luong'] ?? 1;
	
	if ($maChiTiet && $soLuong) {
		$result = $controller->CapNhatSoLuong($maChiTiet, $soLuong);
		echo json_encode(['success' => $result]);
	} else {
		echo json_encode(['success' => false]);
	}