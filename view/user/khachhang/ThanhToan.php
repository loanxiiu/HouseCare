<?php
	session_start();
	require_once __DIR__ . '/../../../db/DatabaseConnect.php';
	require_once __DIR__ . '/../../../controller/GioHangController.php';
	require_once __DIR__ . '/../../../controller/SanPhamController.php';
	
	use BTL\controller\GioHangController;
	use BTL\controller\SanPhamController;
	
	if (!isset($_SESSION['ma'])) {
		header("Location: ../user/DangNhap.php");
		exit();
	}
	
	$gioHangController = new GioHangController();
	$sanPhamController = new SanPhamController();
	
	$maChiTiet = isset($_GET['maChiTiet']) ? $_GET['maChiTiet'] : null; // Từ "Mua ngay"
	$maGioHang = isset($_POST['maGioHang']) ? $_POST['maGioHang'] : null; // Từ "Thanh toán toàn bộ"
	$items = [];
	$total = 0;
	$phiVanChuyen = 30000;
	
	if ($maChiTiet) {
		// Trường hợp "Mua ngay" - chỉ 1 sản phẩm
		$gioHang = $gioHangController->LayGioHangCuaNguoiDung();
		foreach ($gioHang->getChiTietGioHangs() as $chiTiet) {
			if ($chiTiet->getMa() === $maChiTiet) {
				$sanPham = $sanPhamController->LayBangId($chiTiet->getMaSanPham());
				$items[] = [
					'sanPham' => $sanPham,
					'soLuong' => $chiTiet->getSoLuong(),
					'tong' => $sanPham->getGia() * $chiTiet->getSoLuong()
				];
				$total += $items[0]['tong'];
				break;
			}
		}
	} elseif ($maGioHang) {
		// Trường hợp thanh toán toàn bộ giỏ hàng
		$gioHang = $gioHangController->LayGioHangCuaNguoiDung();
		foreach ($gioHang->getChiTietGioHangs() as $chiTiet) {
			$sanPham = $sanPhamController->LayBangId($chiTiet->getMaSanPham());
			$items[] = [
				'sanPham' => $sanPham,
				'soLuong' => $chiTiet->getSoLuong(),
				'tong' => $sanPham->getGia() * $chiTiet->getSoLuong()
			];
			$total += $sanPham->getGia() * $chiTiet->getSoLuong();
		}
	}
	
	if (empty($items)) {
		header("Location: ../GioHang.php?error=no_items");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="../../assets/khachhang/css/thanhtoan.css">

</head>
<body>
<header>
    <h1>Thanh Toán</h1>
    <button class="close-btn">X</button>
</header>

<div class="container">
    <form method="POST" action="">
        <h2 class="section-title">Thông tin người đặt</h2>
        <div class="card">
            <div class="customer-info">
                <div>
                    <h3>Thông tin cá nhân</h3>
                    <p id="customer-name"><?php echo htmlspecialchars($_SESSION['ten'] ?? 'Nguyễn Văn A'); ?></p>
                    <p id="customer-email"><?php echo htmlspecialchars($_SESSION['email'] ?? 'nguyenvana@email.com'); ?></p>
                    <p id="customer-phone"><?php echo htmlspecialchars($_SESSION['sdt'] ?? '0912345678'); ?></p>
                </div>
                <button type="button" class="edit-btn" id="edit-info-btn">Chỉnh sửa</button>
            </div>
            <div class="customer-info">
                <div>
                    <h3>Địa chỉ giao hàng</h3>
                    <p id="shipping-address"><?php echo htmlspecialchars($_SESSION['diaChi'] ?? '123 Đường ABC, Phường XYZ, Quận 1'); ?></p>
                    <p id="shipping-city"><?php echo htmlspecialchars($_SESSION['thanhPho'] ?? 'TP. Hồ Chí Minh'); ?></p>
                </div>
                <button type="button" class="edit-btn" id="edit-address-btn">Chỉnh sửa</button>
            </div>
        </div>

        <h2 class="section-title">Thông tin đơn hàng</h2>
        <div class="card">
			<?php foreach ($items as $item): ?>
                <div class="order-item">
                    <div class="item-image" style="background-image: url('/view/assets/images/sanpham/<?php echo $item['sanPham']->getAnh(); ?>.jpg')"></div>
                    <div class="item-details">
                        <div class="item-name"><?php echo htmlspecialchars($item['sanPham']->getTen()); ?></div>
                        <div class="item-qty">Số lượng: <?php echo $item['soLuong']; ?></div>
                    </div>
                    <div class="item-price"><?php echo number_format($item['tong'], 0, ',', '.') . '₫'; ?></div>
                </div>
			<?php endforeach; ?>
        </div>

        <div class="card">
            <div class="summary-row">
                <div>Tổng tiền hàng:</div>
                <div><?php echo number_format($total, 0, ',', '.') . '₫'; ?></div>
            </div>
            <div class="summary-row">
                <div>Phí vận chuyển:</div>
                <div><?php echo number_format($phiVanChuyen, 0, ',', '.') . '₫'; ?></div>
            </div>
            <div class="summary-row total">
                <div>Tổng thanh toán:</div>
                <div><?php echo number_format($total + $phiVanChuyen, 0, ',', '.') . '₫'; ?></div>
            </div>
        </div>

        <h2 class="section-title">Phương thức thanh toán</h2>
        <select id="paymentMethod" name="paymentMethod" class="payment-select">
            <option value="" selected disabled>Chọn phương thức thanh toán</option>
            <option value="cod">Thanh Toán khi nhận hàng</option>
            <option value="credit_card">Thẻ tín dụng / Ghi nợ</option>
            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
            <option value="e_wallet">Ví điện tử</option>
        </select>

        <div id="paymentDetails" class="card" style="display: none;"></div>

        <button type="submit" class="confirm-btn">Xác nhận thanh toán</button>

        <div class="footer">Thanh toán an toàn & bảo mật</div>
    </form>
</div>

<!-- Modal cho chỉnh sửa thông tin -->
<div id="infoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Chỉnh sửa thông tin cá nhân</h2>
            <span class="close-modal">×</span>
        </div>
        <form id="info-form">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" value="<?php echo htmlspecialchars($_SESSION['ten'] ?? 'Nguyễn Văn A'); ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? 'nguyenvana@email.com'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" value="<?php echo htmlspecialchars($_SESSION['sdt'] ?? '0912345678'); ?>" required>
                </div>
            </div>
            <div class="modal-buttons">
                <button type="button" class="modal-cancel">Hủy</button>
                <button type="submit" class="modal-save">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<div id="addressModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Chỉnh sửa địa chỉ giao hàng</h2>
            <span class="close-modal">×</span>
        </div>
        <form id="address-form">
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" value="<?php echo htmlspecialchars($_SESSION['diaChi'] ?? '123 Đường ABC, Phường XYZ, Quận 1'); ?>" required>
            </div>
            <div class="form-group">
                <label for="city">Thành phố</label>
                <input type="text" id="city" value="<?php echo htmlspecialchars($_SESSION['thanhPho'] ?? 'TP. Hồ Chí Minh'); ?>" required>
            </div>
            <div class="modal-buttons">
                <button type="button" class="modal-cancel">Hủy</button>
                <button type="submit" class="modal-save">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
<script src="../../assets/khachhang/js/thanhtoan.js"></script>
</body>
</html>