<?php
	session_start();
	require_once __DIR__ . '/../../../controller/GioHangController.php';
	
	use BTL\controller\GioHangController;
	
	$controller = new GioHangController();
	$maChiTiet = $_GET['ma_chi_tiet'] ?? null;
	
	if ($maChiTiet) {
		$result = $controller->XoaChiTiet($maChiTiet);
		echo json_encode(['success' => $result]);
	} else {
		echo json_encode(['success' => false]);
	}