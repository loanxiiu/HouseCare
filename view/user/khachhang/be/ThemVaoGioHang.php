<?php
	session_start();
	require_once __DIR__ . '/../../../../controller/GioHangController.php';
	require_once __DIR__ . '/../../../../controller/SanPhamController.php';
	
	use BTL\controller\GioHangController;
	use BTL\controller\SanPhamController;
	
	$gioHangController = new GioHangController();
	$sanPhamController = new SanPhamController();
	$message = '';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
		$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
		
		if ($quantity < 1 || !$product_id) {
			$message = "<p class='error'>Dữ liệu không hợp lệ!</p>";
		} else {
			// Xử lý "Thêm vào giỏ hàng"
			if (isset($_POST['add_to_cart'])) {
				$result = $gioHangController->ThemSanPhamVaoGioHang($product_id, $quantity);
				$message = "<p class='" . ($result['success'] ? 'success' : 'error') . "'>" . htmlspecialchars($result['message']) . "</p>";
				if (!isset($_SESSION['ma']) && !$result['success']) {
					header("Location: /view/user/DangNhap.php?returnUrl=" . urlencode($_SERVER['HTTP_REFERER']));
					exit();
				}

// Lưu thông báo vào session và chuyển hướng về trang trước
				$_SESSION['message'] = $message;
				header("Location: " . $_SERVER['HTTP_REFERER']);
				exit();
			}
			
			// Xử lý "Mua ngay"
			if (isset($_POST['buy_now'])) {
				if (!isset($_SESSION['ma'])) {
					header("Location: /view/user/DangNhap.php?returnUrl=" . urlencode($_SERVER['HTTP_REFERER']));
					exit();
				}
				
				// Kiểm tra sản phẩm
				$product = $sanPhamController->LayBangId($product_id);
				echo $product_id;
				if (!$product) {
					$message = "<p class='error'>Sản phẩm không tồn tại!</p>";
				} elseif ($quantity > $product->getSoLuong()) {
					$message = "<p class='error'>Số lượng yêu cầu ($quantity) vượt quá số lượng trong kho ({$product->getSoLuong()})!</p>";
				} else {
					$_SESSION['buy_now'] = [
						'product_id' => $product_id,
						'quantity' => $quantity,
						'price' => $product->getGia(),
						'total' => $product->getGia() * $quantity
					];
					header("Location: ../ThanhToan.php");
					exit();
				}
			}
		}
	}

?>