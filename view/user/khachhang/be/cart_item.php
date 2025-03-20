<?php
	session_start();
	require_once __DIR__ . '/../../../../controller/GioHangController.php';
	
	use BTL\controller\GioHangController;
	
	if (!isset($_SESSION['ma'])) {
		header("Location: ../user/DangNhap.php");
		exit();
	}
	
	$gioHangController = new GioHangController();
	$maChiTiet = isset($_POST['maChiTiet']) ? $_POST['maChiTiet'] : '';
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	if (!$maChiTiet) {
		header("Location: ../GioHang.php?error=invalid_request");
		exit();
	}
	
	switch ($action) {
		case 'remove':
			// Xóa sản phẩm khỏi giỏ hàng
			$success = $gioHangController->XoaChiTiet($maChiTiet);
			if ($success) {
				header("Location: ../GioHang.php?message=removed");
			} else {
				header("Location: ../GioHang.php?error=remove_failed");
			}
			break;
		
		case 'increase':
			// Tăng số lượng
			$gioHang = $gioHangController->LayGioHangCuaNguoiDung();
			foreach ($gioHang->getChiTietGioHangs() as $chiTiet) {
				if ($chiTiet->getMa() === $maChiTiet) {
					$newQuantity = $chiTiet->getSoLuong() + 1;
					$success = $gioHangController->CapNhatSoLuong($maChiTiet, $newQuantity);
					break;
				}
			}
			if ($success) {
				header("Location: ../GioHang.php?message=quantity_updated");
			} else {
				header("Location: ../GioHang.php?error=update_failed");
			}
			break;
		
		case 'decrease':
			// Giảm số lượng (nhưng không dưới 1)
			$gioHang = $gioHangController->LayGioHangCuaNguoiDung();
			foreach ($gioHang->getChiTietGioHangs() as $chiTiet) {
				if ($chiTiet->getMa() === $maChiTiet) {
					$currentQuantity = $chiTiet->getSoLuong();
					if ($currentQuantity > 1) {
						$newQuantity = $currentQuantity - 1;
						$success = $gioHangController->CapNhatSoLuong($maChiTiet, $newQuantity);
					} else {
						$success = false; // Không giảm nếu số lượng đã là 1
					}
					break;
				}
			}
			if ($success) {
				header("Location: ../GioHang.php?message=quantity_updated");
			} else {
				header("Location: ../GioHang.php?error=update_failed");
			}
			break;
		
		case 'buy_now':
			// Chuyển hướng đến trang thanh toán với sản phẩm cụ thể
			header("Location: ../thanhtoan.php?maChiTiet=" . urlencode($maChiTiet));
			break;
		
		default:
			header("Location: ../GioHang.php?error=invalid_action");
			break;
	}
	
	exit();
?>