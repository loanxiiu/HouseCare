<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopee Clone</title>
    <link rel="stylesheet" href="/assets/khachhang/css/style.css">
</head>
<body>
<!-- Header -->
<header class="header">
    <div class="container header-container">
        <a href="TrangChu.php" class="logo">
            <img src="/assets/images/logo/logo.jpg" alt="Shopee"/>
            HOMECARE
        </a>

        <form action="TimKiem.php" method="GET" class="search-bar">
            <input type="text" name="timkiem" placeholder="Tìm sản phẩm, thương hiệu và tên shop" required>
            <button type="submit" class="search-button">
                🔍
            </button>
        </form>

        <div class="nav-menu">
			<?php session_start();
                if (isset($_SESSION['ten']) && $_SESSION['quyen'] == 2) {
				echo '<a href="#" class="nav-item">
                <i>🛒</i> Giỏ hàng
	            </a>
	            <a href="#" class="nav-item">
                <i>🙋 Xin chào '.$_SESSION['ten'].'</i>
	            </a>';
			} else {
				echo '<a href="../user/DangNhap.php" class="nav-item">
                <i>🙋</i> Đăng nhập
	            </a>';
			} ?>


        </div>
    </div>
</header>

<!-- Main content -->
<main class="container">
    <!-- Banner -->
    <div class="banner slide-up">
        <div class="banner-container" id="bannerContainer">
            <div class="banner-arrow banner-arrow-prev" id="prevArrow">◄</div>
            <div class="banner-slide" style="background-image: url('/assets/images/banner/anh2.jpg');"></div>
            <div class="banner-slide" style="background-image: url('/assets/images/banner/anh1.jpg');"></div>
            <div class="banner-slide" style="background-image: url('/assets/images/banner/anh3.jpg');"></div>
            <div class="banner-arrow banner-arrow-next" id="nextArrow">►</div>
        </div>
        <div class="banner-nav" id="bannerNav"></div>
    </div>

    <!-- Categories -->
    <div class="categories slide-up">
        <h2 class="section-title">Danh mục</h2>
        <div class="category-grid">
			<?php
				require_once __DIR__ . "/../../controller/DanhMucController.php";
				
				use \BTL\controller\DanhMucController;
				
				$controller = new DanhMucController();
				$danhMuc = $controller->LayTatCa();
				$icon = ['📺', '🍳', '🚽', '🛋️', '🧴', '📱', '💡', '🔥', '🧺', '🌷'];
				foreach ($danhMuc as $dm) {
					echo '<div class="category-item">
                <div class="category-icon">' . $icon[$dm->ma - 1] . '</div>
                <div class="category-name">' . $dm->ten . '</div>
            </div>';
				}
			?>
        </div>
    </div>

    <!-- Flash Sale -->
    <div class="flash-sale slide-up">
        <div class="flash-sale-header">
            <div class="flash-sale-title">FLASH SALE</div>
            <div class="timer">
                <span>KẾT THÚC TRONG</span>
                <div class="timer-block" id="hours">00</div>
                <div class="timer-block" id="minutes">00</div>
                <div class="timer-block" id="seconds">00</div>
            </div>
        </div>
        <div class="flash-sale-container" id="flashSaleContainer">
			<?php
				// Lấy danh sách sản phẩm từ Controller
				require_once __DIR__ . '/../../controller/SanPhamController.php';
				
				use BTL\controller\SanPhamController;
				
				$controller = new SanPhamController();
				$danhSachSanPham = $controller->LayTatCa();
				
				foreach ($danhSachSanPham as $sp) {
					// Generate a random discount between 10% and 49% (under 50%)
					$randomDiscount = rand(10, 49);
					
					// Handle null or invalid values for price and quantity
					$gia = $sp->getGia() ? number_format($sp->getGia(), 0, ',', '.') . 'đ' : 'Giá không xác định';
					$soLuong = $sp->getSoLuong() !== null && $sp->getSoLuong() >= 0 ? $sp->getSoLuong() : '0';
					
					// Lấy ảnh sản phẩm hoặc đặt ảnh mặc định
					$hinhAnh = '/assets/images/sanpham/' . $sp->getAnh() . '.jpg';
					
					echo '<div class="product-card">
        <div class="product-image" style="background-image: url(\'' . htmlspecialchars($hinhAnh) . '\');"></div>
        <div class="product-info">
            <div class="product-name">' . htmlspecialchars($sp->getTen()) . '</div>
            <div>
                <span class="product-price">' . $gia . '</span>
                <span class="product-discount">-' . $randomDiscount . '%</span>
            </div>
            <div class="product-sold">Đã bán ' . $soLuong . '</div>
        </div>
    </div>';
				}
			?>
        </div>
    </div>

    <!-- Products Section -->
    <div class="products-section slide-up">
        <h2 class="section-title">Gợi ý hôm nay</h2>
        <div class="products-grid">
			<?php
				$controller = new SanPhamController();
				$danhSachSanPham = $controller->LayTatCa();
				
				foreach ($danhSachSanPham as $sp) {
					// Generate a random discount between 10% and 49% (under 50%)
					$randomDiscount = rand(10, 49);
					
					// Handle null or invalid values for price and quantity
					$gia = $sp->getGia() ? number_format($sp->getGia(), 0, ',', '.') . 'đ' : 'Giá không xác định';
					$soLuong = $sp->getSoLuong() !== null && $sp->getSoLuong() >= 0 ? $sp->getSoLuong() : '0';
					
					// Lấy ảnh sản phẩm hoặc đặt ảnh mặc định
					$hinhAnh = '/assets/images/sanpham/' . $sp->getAnh() . '.jpg';
					
					echo '<div class="product-card">
        <div class="product-image" style="background-image: url(\'' . htmlspecialchars($hinhAnh) . '\');"></div>
        <div class="product-info">
            <div class="product-name">' . htmlspecialchars($sp->getTen()) . '</div>
            <div>
                <span class="product-price">' . $gia . '</span>
                <span class="product-discount">-' . $randomDiscount . '%</span>
            </div>
            <div class="product-sold">Đã bán ' . $soLuong . '</div>
        </div>
    </div>';
				}
			?>
        </div>
    </div>
</main>

<!-- Footer -->
<footer>
    <div class="container footer-container">
        <div class="footer-column">
            <h3>CHĂM SÓC KHÁCH HÀNG</h3>
            <ul>
                <li><a href="#">Trung tâm trợ giúp</a></li>
                <li><a href="#">Shopee Blog</a></li>
                <li><a href="#">Hướng dẫn mua hàng</a></li>
                <li><a href="#">Thanh toán</a></li>
                <li><a href="#">Vận chuyển</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>VỀ SHOPEE</h3>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Tuyển dụng</a></li>
                <li><a href="#">Điều khoản</a></li>
                <li><a href="#">Chính sách</a></li>
                <li><a href="#">Flash Sale</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>THANH TOÁN</h3>
            <ul>
                <li><a href="#">Thẻ tín dụng</a></li>
                <li><a href="#">Ví điện tử</a></li>
                <li><a href="#">Chuyển khoản</a></li>
                <li><a href="#">Trả góp</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>THEO DÕI CHÚNG TÔI</h3>
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">LinkedIn</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>TẢI ỨNG DỤNG</h3>
            <ul>
                <li><a href="#">App Store</a></li>
                <li><a href="#">Google Play</a></li>
                <li><a href="#">AppGallery</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        © 2025 Shopee Clone. Tất cả các quyền được bảo lưu.
    </div>
</footer>

// Replace your current JavaScript with this enhanced version
<script src="/assets/khachhang/js/script.js"></script>
</body>
</html>