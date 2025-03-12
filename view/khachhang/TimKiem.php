<?php
	require_once __DIR__ . '/../../controller/SanPhamController.php';
	
	use BTL\controller\SanPhamController;
	
	$tuKhoa = isset($_GET['timkiem']) ? trim($_GET['timkiem']) : '';
	
	$controller = new SanPhamController();
	$dsSanPham = $controller->timKiemSanPham($tuKhoa);
	
	// Xử lý sắp xếp
	$sortOption = isset($_GET['sort']) ? $_GET['sort'] : '';
	switch ($sortOption) {
		case 'bestseller':
			usort($dsSanPham, fn($a, $b) => $b->getSoLuong() - $a->getSoLuong());
			break;
		case 'price_asc':
			usort($dsSanPham, fn($a, $b) => $a->getGia() - $b->getGia());
			break;
		case 'price_desc':
			usort($dsSanPham, fn($a, $b) => $b->getGia() - $a->getGia());
			break;
		default:
			shuffle($dsSanPham); // Mặc định xáo trộn
	}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Trực Tuyến - Mua Sắm Như Shopee</title>
    <link rel="stylesheet" href="/assets/khachhang/css/timkiem.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="search-container">
            <a href="TrangChu.php" class="logo">
                <img src="/assets/images/logo/logo.jpg" alt="Shopee" />
                HOMECARE
            </a>
            <form class="search-box">
                <form method="get" action="">
                    <input type="text" class="search-input" name="timkiem" placeholder="<?php echo htmlspecialchars($tuKhoa); ?>">
                    <button type="submit" class="search-button">🔍</button>
                </form>
            </form>
            <div class="cart-icon">🛒</div>
        </div>
    </div>
</header>


<div class="category-bar">
    <div class="container">
        <ul class="category-list">
			<?php
				require_once __DIR__ . "/../../controller/DanhMucController.php";
				
				use \BTL\controller\DanhMucController;
				
				$controller = new DanhMucController();
				$danhMuc = $controller->LayTatCa();
				foreach ($danhMuc as $dm) {
					echo '<li class="category-item">' . $dm->ten . '</li>';
				}
			?>
        </ul>
    </div>
</div>

<div class="container">
<!--    <div class="banner">KHUYẾN MÃI ĐẶC BIỆT - GIẢM GIÁ ĐẾN 50%</div>-->

    <div class="filter-bar">
        <div class="filter-options">
            <a href="?timkiem=<?php echo urlencode($tuKhoa); ?>&sort=" class="filter-option <?php echo $sortOption == '' ? 'active' : ''; ?>">Phổ biến</a>
            <a href="?timkiem=<?php echo urlencode($tuKhoa); ?>&sort=bestseller" class="filter-option <?php echo $sortOption == 'bestseller' ? 'active' : ''; ?>">Bán chạy</a>
            <a href="?timkiem=<?php echo urlencode($tuKhoa); ?>&sort=price_asc" class="filter-option <?php echo $sortOption == 'price_asc' ? 'active' : ''; ?>">Giá: Thấp đến Cao</a>
            <a href="?timkiem=<?php echo urlencode($tuKhoa); ?>&sort=price_desc" class="filter-option <?php echo $sortOption == 'price_desc' ? 'active' : ''; ?>">Giá: Cao đến Thấp</a>
        </div>
        <div class="pages-info">1/50</div>
    </div>

    <div class="product-grid">
		<?php foreach ($dsSanPham as $sp): ?>
            <div class="product-card">
                <div class="product-image"
                     style="background-image: url('<?php echo '/assets/images/sanpham/' . htmlspecialchars($sp->getAnh()) . '.jpg'; ?>');"></div>
                <div class="product-info">
                    <div class="product-name"><?php echo htmlspecialchars($sp->getTen()); ?></div>
                    <div class="product-price"><?php echo number_format($sp->getGia(), 0, ',', '.'); ?>đ</div>
                    <div class="product-sold">Đã bán <?php echo $sp->getSoLuong(); ?></div>
                </div>
            </div>
		<?php endforeach; ?>

    </div>
    <script src="/assets/khachhang/js/timkiem.js"
</body>
</html>