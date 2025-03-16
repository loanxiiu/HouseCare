<?php session_start();?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="/assets/khachhang/css/common.css">
    <link rel="stylesheet" href="/assets/khachhang/css/giohang.css">
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="container">

    <h1>Giỏ hàng của bạn</h1>

    <div class="cart-container">
        <div class="cart-header">
            <div>Sản phẩm</div>
            <div>Giá</div>
            <div>Số lượng</div>
            <div>Tổng</div>
        </div>

        <div class="cart-item">
            <div class="product">
                <div class="product-image" style="background-image: url('/assets/images/sanpham/anh1.jpg')"></div>
                <div class="product-info">
                    <h3>Máy lọc không khí</h3>
                    <button class="remove-btn">Xóa</button>
                </div>
            </div>
            <div>350.000₫</div>
            <div class="quantity">
                <button>-</button>
                <span>1</span>
                <button>+</button>
            </div>
            <div>350.000₫</div>
        </div>

        <div class="cart-item">
            <div class="product">
                <div class="product-image" style="background-image: url('/assets/images/sanpham/anh2.jpg')"></div>
                <div class="product-info">
                    <h3>Quạt điều hòa</h3>
                    <button class="remove-btn">Xóa</button>
                </div>
            </div>
            <div>550.000₫</div>
            <div class="quantity">
                <button>-</button>
                <span>1</span>
                <button>+</button>
            </div>
            <div>550.000₫</div>
        </div>

        <div class="cart-item">
            <div class="product">
                <div class="product-image" style="background-image: url('/assets/images/sanpham/anh3.jpg')"></div>
                <div class="product-info">
                    <h3>Bếp từ đôi</h3>
                    <button class="remove-btn">Xóa</button>
                </div>
            </div>
            <div>780.000₫</div>
            <div class="quantity">
                <button>-</button>
                <span>1</span>
                <button>+</button>
            </div>
            <div>780.000₫</div>
        </div>
    </div>

    <div class="cart-summary">
        <div class="summary-row">
            <span>Tạm tính</span>
            <span>1.680.000₫</span>
        </div>
        <div class="summary-row">
            <span>Phí vận chuyển</span>
            <span>30.000₫</span>
        </div>
        <div class="summary-row total">
            <span>Tổng cộng</span>
            <span>1.710.000₫</span>
        </div>
        <button class="checkout-btn">TIẾN HÀNH THANH TOÁN</button>
    </div>

    <!-- For empty cart state, uncomment below -->
    <!--
	<div class="cart-container">
		<div class="empty-cart">
			<h2>Giỏ hàng của bạn đang trống</h2>
			<p>Thêm sản phẩm vào giỏ hàng để tiếp tục.</p>
			<a href="#" class="continue-shopping">Tiếp tục mua sắm</a>
		</div>
	</div>
	-->
</div>
</body>
</html>