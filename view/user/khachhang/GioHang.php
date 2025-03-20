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
	$gioHang = $gioHangController->LayGioHangCuaNguoiDung();

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="/view/assets/khachhang/css/common.css">
    <link rel="stylesheet" href="/view/assets/khachhang/css/giohang.css">
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="container">
    <h1>Giỏ hàng của bạn</h1>
	
	<?php if ($gioHang && !empty($gioHang->getChiTietGioHangs())): ?>
        <div class="cart-container">
            <div class="cart-header">
                <div>Sản phẩm</div>
                <div>Giá</div>
                <div>Số lượng</div>
                <div>Tổng</div>
            </div>
			
			<?php
				$tongTamTinh = 0;
				$phiVanChuyen = 30000; // Fixed shipping fee
				foreach ($gioHang->getChiTietGioHangs() as $chiTiet):
					$maSanPham = $chiTiet->getMaSanPham(); // Assuming this method exists in ChiTietGioHang
					$sanPhamController = new SanPhamController();
					$sanPham = $sanPhamController->LayBangId($maSanPham);
					$tongSanPham = $sanPham->getGia() * $chiTiet->getSoLuong();
					$tongTamTinh += $tongSanPham;
					?>
                    <form method="post" action="../khachhang/be/cart_item.php" class="cart-item-form">
                        <a href="<?php echo "../khachhang/SanPham.php?id=" . htmlspecialchars($sanPham->getMa()) ?>"
                           class="cart-item" data-id="<?php echo $chiTiet->getMa(); ?>"
                           style="text-decoration: none; color: black;">
                            <div class="product">
                                <div class="product-image"
                                     style="background-image: url('<?php echo '/view/assets/images/sanpham/' . $sanPham->getAnh() . '.jpg'; ?>')"></div>
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($sanPham->getTen()); ?></h3>
                                    <button type="submit" name="action" value="remove" class="remove-btn"
                                            data-id="<?php echo $chiTiet->getMa(); ?>">Xóa
                                    </button>
                                </div>
                            </div>
                            <div><?php echo number_format($sanPham->getGia(), 0, ',', '.') . '₫'; ?></div>
                            <div class="quantity">
                                <button type="submit" name="action" value="decrease" class="decrease">-</button>
                                <span><?php echo $chiTiet->getSoLuong(); ?></span>
                                <button type="submit" name="action" value="increase" class="increase">+</button>
                            </div>
                            <div><?php echo number_format($tongSanPham, 0, ',', '.') . '₫'; ?></div>
                            <div class="buy-now">
                                <input type="hidden" name="maChiTiet" value="<?php echo $chiTiet->getMa(); ?>">
                                <button type="submit" name="action" value="buy_now" class="buy-now-btn">Mua ngay
                                </button>
                            </div>
                        </a>
                    </form>
                <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Tạm tính</span>
                <span><?php echo number_format($tongTamTinh, 0, ',', '.') . '₫'; ?></span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển</span>
                <span><?php echo number_format($phiVanChuyen, 0, ',', '.') . '₫'; ?></span>
            </div>
            <div class="summary-row total">
                <span>Tổng cộng</span>
                <span><?php echo number_format($tongTamTinh + $phiVanChuyen, 0, ',', '.') . '₫'; ?></span>
            </div>
            <form method="post" action="../khachhang/ThanhToan.php">
                <input type="hidden" name="maGioHang" value="<?php echo $gioHang->getMa(); ?>">
                <button type="submit" class="checkout-btn">TIẾN HÀNH THANH TOÁN</button>
            </form>
        </div>
	<?php else: ?>
        <div class="cart-container">
            <div class="empty-cart">
                <h2>Giỏ hàng của bạn đang trống</h2>
                <p>Thêm sản phẩm vào giỏ hàng để tiếp tục.</p>
                <a href="#" class="continue-shopping">Tiếp tục mua sắm</a>
            </div>
        </div>
	<?php endif; ?>
</div>

<script>
    // Thanh toán
    document.querySelector('.checkout-btn')?.addEventListener('click', function () {
        window.location.href = '../khachhang/thanhtoan.php'; // Redirect to payment page
    });
</script>

</body>
</html>