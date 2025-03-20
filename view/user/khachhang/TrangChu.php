<?php session_start();?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopee Clone</title>
    <link rel="stylesheet" href="/view/assets/khachhang/css/style.css">
    <link rel="stylesheet" href="/view/assets/khachhang/css/common.css">
</head>
<body>
<!-- Header -->
<?php require_once __DIR__ . '/header.php'; ?>

<!-- Main content -->
<main class="container">
    <!-- Banner -->
    <div class="banner slide-up">
        <div class="banner-container" id="bannerContainer">
            <div class="banner-arrow banner-arrow-prev" id="prevArrow">◄</div>
            <div class="banner-slide" style="background-image: url('/view/assets/images/banner/anh2.jpg');"></div>
            <div class="banner-slide" style="background-image: url('/view/assets/images/banner/anh1.jpg');"></div>
            <div class="banner-slide" style="background-image: url('/view/assets/images/banner/anh3.jpg');"></div>
            <div class="banner-arrow banner-arrow-next" id="nextArrow">►</div>
        </div>
        <div class="banner-nav" id="bannerNav"></div>
    </div>

    <!-- Categories -->
    <div class="categories slide-up">
        <h2 class="section-title">Danh mục</h2>
        <div class="category-grid">
			<?php
				require_once __DIR__ . "/../../../controller/DanhMucController.php";
				use \BTL\controller\DanhMucController;
				
				$controller = new DanhMucController();
				$danhMuc = $controller->LayTatCa();
				$icon = ['📺', '🍳', '🚽', '🛋️', '🧴', '📱', '💡', '🔥', '🧺', '🌷'];
				foreach ($danhMuc as $dm) {
					echo '<div class="category-item">
                    <div class="category-icon">' . $icon[$dm->ma - 1] . '</div>
                    <div class="category-name">' . htmlspecialchars($dm->ten) . '</div>
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
				require_once __DIR__ . '/../../../controller/SanPhamController.php';
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
					$hinhAnh = '/view/assets/images/sanpham/' . htmlspecialchars($sp->getAnh()) . '.jpg';
					
					echo '<a href="../khachhang/SanPham.php?id=' . htmlspecialchars($sp->getMa()) . '" class="product-card">';
					echo '<div class="product-image" style="background-image: url(\'' . $hinhAnh . '\');"></div>';
					echo '<div class="product-info">';
					echo '<div class="product-name">' . htmlspecialchars($sp->getTen()) . '</div>';
					echo '<div>';
					echo '<span class="product-price">' . $gia . '</span>';
					echo '<span class="product-discount">-' . $randomDiscount . '%</span>';
					echo '</div>';
					echo '<div class="product-sold">Đã bán ' . $soLuong . '</div>';
					echo '</div>';
					echo '</a>';
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
					$hinhAnh = '/view/assets/images/sanpham/' . htmlspecialchars($sp->getAnh()) . '.jpg';
					
					echo '<a href="../khachhang/SanPham.php?id=' . htmlspecialchars($sp->getMa()) . '" class="product-card">';
					echo '<div class="product-image" style="background-image: url(\'' . $hinhAnh . '\');"></div>';
					echo '<div class="product-info">';
					echo '<div class="product-name">' . htmlspecialchars($sp->getTen()) . '</div>';
					echo '<div>';
					echo '<span class="product-price">' . $gia . '</span>';
					echo '<span class="product-discount">-' . $randomDiscount . '%</span>';
					echo '</div>';
					echo '<div class="product-sold">Đã bán ' . $soLuong . '</div>';
					echo '</div>';
					echo '</a>';
				}
			?>
        </div>
    </div>
</main>

<!-- Footer -->
<?php require_once __DIR__ . '/footer.php'; ?>

<script src="/view/assets/khachhang/js/script.js"></script>
</body>
</html>