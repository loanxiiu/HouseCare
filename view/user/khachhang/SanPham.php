<?php
	session_start();
	require_once __DIR__ . '/../../../controller/SanPhamController.php';
	require_once __DIR__ . '/../../../controller/DonHangController.php';
	
	use BTL\controller\SanPhamController;
	use BTL\controller\DonHangController;
	
	$controller = new SanPhamController();
	$donHangController = new DonHangController();
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
    <link rel="stylesheet" href="/view/assets/khachhang/css/sanpham.css">
    <link rel="stylesheet" href="/view/assets/khachhang/css/common.css">
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>

<div class="container">
	<?php if ($message): ?>
        <span class="message"><?php echo $message; ?></span>
	<?php endif; ?>
	
	<?php if ($_SESSION['message']): ?>
        <span class="message"><?php echo $_SESSION['message']; ?></span>
		<?php $_SESSION['message'] = null; ?>
	<?php endif; ?>
	
	<?php if ($product): ?>
        <div class="product-detail">
            <div class="product-images">
                <div class="main-image">
                    <img src="/view/assets/images/sanpham/<?php echo htmlspecialchars($product->getAnh()); ?>.jpg"
                         alt="<?php echo htmlspecialchars($product->getTen()); ?>" height="400">
                </div>
            </div>

            <div class="product-info">
                <h1><?php echo htmlspecialchars($product->getTen()); ?></h1>
                <div class="product-price"><?php echo number_format($product->getGia(), 0, ',', '.') . 'đ'; ?></div>
                <div class="product-rating">
                    <div class="stars">★★★★☆</div>
                    <div class="review-count">(0 đánh giá)</div>
                </div>

                <form method="post" id="product-form" action="../khachhang/be/ThemVaoGioHang.php">
                    <div class="product-options">
                        <label class="option-label">Số lượng:</label>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(-1)">-</button>
                            <input type="number" name="quantity" class="quantity-input"
                                   value="1" min="1" max="<?php echo $product->getSoLuong(); ?>">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>

                    <div class="button-group">
                        <input type="hidden" name="product_id" value="<?php echo $product->getMa(); ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart-btn">Thêm vào giỏ hàng</button>
                        <button type="submit" name="buy_now" class="buy-now-btn">Mua ngay</button>
                        <button type="button" class="wishlist-btn">Thêm vào danh sách yêu thích</button>
                    </div>
                </form>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Mã sản phẩm:</span>
                        <span><?php echo $product->getMa(); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Danh mục:</span>
                        <span><?php echo $product->getMaDanhMuc(); ?></span>
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
					$relatedProducts = $controller->LayTatCa();
					$count = 0;
					foreach ($relatedProducts as $relatedProduct) {
						if ($relatedProduct->getMa() != $product->getMa() && $count < 4) {
							echo '<div class="product-card">';
							echo '<div class="product-card-image">';
							echo '<img src="/view/assets/images/sanpham/' . htmlspecialchars($relatedProduct->getAnh()) . '.jpg" alt="' . htmlspecialchars($relatedProduct->getTen()) . '">';
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

<script>
    function updateQuantity(change) {
        const input = document.querySelector('.quantity-input');
        let value = parseInt(input.value) + change;
        const min = parseInt(input.min);
        const max = parseInt(input.max);

        if (value < min) value = min;
        if (value > max) value = max;
        input.value = value;
    }

    // Tab switching logic
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });
    });
</script>

<style>
    .success {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 10px;
        margin: 10px 0;
    }

    .error {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 10px;
        margin: 10px 0;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const message = document.querySelector('.message');
        if (message) {
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000); // Biến mất sau 3 giây
        }
    });
</script>
</body>
</html>