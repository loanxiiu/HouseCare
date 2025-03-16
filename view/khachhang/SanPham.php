<?php
	session_start();
	require_once __DIR__ . '/../../controller/SanPhamController.php';
	
	use BTL\controller\SanPhamController;
	
	$controller = new SanPhamController();
	$product = null;
	$message = '';
	
	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$product = $controller->LayBangId((int)$_GET['id']);
		if ($product === null) {
			$message = "<p class='error'>Sản phẩm không tồn tại!</p>";
		}
	} else {
		$message = "<p class='error'>Vui lòng cung cấp ID sản phẩm!</p>";
	}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="/assets/khachhang/css/sanpham.css">
    <link rel="stylesheet" href="/assets/khachhang/css/common.css">
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>

<div class="container">
	<?php if ($message): ?>
        <span class="error"><?php echo $message; ?></span>
	<?php elseif ($product): ?>
        <div class="product-detail">
            <div class="product-images">
                <div class="main-image">
                    <img src="/assets/images/sanpham/<?php echo htmlspecialchars($product->getAnh()); ?>.jpg" alt="<?php echo htmlspecialchars($product->getTen()); ?>" height="400">
                </div>
            </div>

            <div class="product-info">
                <h1><?php echo htmlspecialchars($product->getTen()); ?></h1>
                <div class="product-price"><?php echo number_format($product->getGia(), 0, ',', '.') . 'đ'; ?></div>
                <div class="product-rating">
                    <div class="stars">★★★★☆</div>
                    <div class="review-count">(0 đánh giá)</div>
                </div>

                <div class="product-options">
                    <label class="option-label">Số lượng:</label>
                    <div class="quantity-selector">
                        <button class="quantity-btn">-</button>
                        <input type="number" class="quantity-input" value="1" min="1" max="<?php echo $product->getSoLuong(); ?>">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>

                <div class="button-group">
                    <button class="add-to-cart-btn">Thêm vào giỏ hàng</button>
                    <button class="buy-now-btn">Mua ngay</button>
                    <button class="wishlist-btn">Thêm vào danh sách yêu thích</button>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Mã sản phẩm:</span>
                        <span><?php echo $product->getMa(); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Danh mục:</span>
                        <span><?php echo $product->getMaDanhMuc(); // You might want to join with DanhMuc table for name ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Số lượng còn lại:</span>
                        <span><?php echo $product->getSoLuong(); ?></span>
                    </div>
                </div>

                <div class="product-description">
                    <p><?php echo htmlspecialchars($product->getMoTa() ?: 'Không có mô tả'); ?></p>
                </div>

                <div class="product-features">
                    <ul class="feature-list">
                        <li>Giá cạnh tranh</li>
                        <li>Chất lượng cao</li>
                        <li>Giao hàng nhanh chóng</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tabs">
            <div class="tab-buttons">
                <button class="tab-button active" data-tab="description">Mô tả</button>
                <button class="tab-button" data-tab="specifications">Thông số</button>
                <button class="tab-button" data-tab="reviews">Đánh giá</button>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="description">
                    <p><?php echo htmlspecialchars($product->getMoTa() ?: 'Không có mô tả chi tiết'); ?></p>
                </div>
                <div class="tab-pane" id="specifications">
                    <table class="specifications-table">
                        <tr>
                            <th>Thông số</th>
                            <td><?php echo htmlspecialchars($product->getMoTa() ?: 'Chưa cập nhật'); ?></td>
                        </tr>
                        <!-- Add more rows as needed based on your product specs -->
                    </table>
                </div>
                <div class="tab-pane" id="reviews">
                    <div class="review">
                        <div class="review-header">
                            <span class="reviewer-name">Chưa có đánh giá</span>
                            <span class="review-date">N/A</span>
                        </div>
                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <div class="product-grid">
				<?php
					$relatedProducts = $controller->LayTatCa(); // Fetch all products for simplicity
					$count = 0;
					foreach ($relatedProducts as $relatedProduct) {
						if ($relatedProduct->getMa() != $product->getMa() && $count < 4) {
							echo '<div class="product-card">';
							echo '<div class="product-card-image">';
							echo '<img src="/assets/images/sanpham/' . htmlspecialchars($relatedProduct->getAnh()) . '.jpg" alt="' . htmlspecialchars($relatedProduct->getTen()) . '">';
							echo '</div>';
							echo '<div class="product-card-title">' . htmlspecialchars($relatedProduct->getTen()) . '</div>';
							echo '<div class="product-card-price">' . number_format($relatedProduct->getGia(), 0, ',', '.') . 'đ</div>';
							echo '</div>';
							$count++;
						}
					}
				?>
            </div>
        </div>
	<?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<!-- Include the external JavaScript file -->
<script src="/assets/khachhang/js/sanpham.js"></script>
</body>
</html>