<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Thành Công</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        header h1 {
            font-size: 24px;
            font-weight: 500;
        }

        .success-card {
            background-color: white;
            border-radius: 0 0 10px 10px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #333;
            color: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        .success-message {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .success-details {
            color: #666;
            margin-bottom: 30px;
        }

        .order-details {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .detail-label {
            color: #666;
        }

        .detail-value {
            font-weight: 500;
        }

        .item-list {
            margin-top: 20px;
        }

        .order-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .order-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .item-image {
            width: 60px;
            height: 60px;
            background-color: #d9d9d9;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-qty {
            color: #666;
            font-size: 14px;
        }

        .item-price {
            font-weight: 500;
            text-align: right;
            min-width: 100px;
        }

        .buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .primary-btn {
            flex: 1;
            padding: 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .primary-btn:hover {
            background-color: #444;
        }

        .secondary-btn {
            flex: 1;
            padding: 15px;
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .secondary-btn:hover {
            background-color: #f5f5f5;
        }

        .footer {
            text-align: center;
            color: #999;
            margin-top: 30px;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
                margin: 20px auto;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Thanh Toán</h1>
    </header>

    <div class="success-card">
        <div class="success-icon">✓</div>
        <div class="success-message">Thanh toán thành công!</div>
        <div class="success-details">
            Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đã được xác nhận.
        </div>
    </div>

    <div class="order-details">
        <h2 class="section-title">Thông tin đơn hàng</h2>

        <div class="detail-row">
            <div class="detail-label">Mã đơn hàng:</div>
            <div class="detail-value">#123456789</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Ngày đặt hàng:</div>
            <div class="detail-value">16/03/2025</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Phương thức thanh toán:</div>
            <div class="detail-value">Thẻ tín dụng</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Tổng thanh toán:</div>
            <div class="detail-value">2.530.000₫</div>
        </div>

        <div class="item-list">
            <div class="order-item">
                <div class="item-image" style="background-image: url('/assets/images/sanpham/anh1.jpg')"></div>
                <div class="item-details">
                    <div class="item-name">Nồi cơm điện Philips</div>
                    <div class="item-qty">Số lượng: 1</div>
                </div>
                <div class="item-price">1.200.000₫</div>
            </div>

            <div class="order-item">
                <div class="item-image" style="background-image: url('/assets/images/sanpham/anh2.jpg')"></div>
                <div class="item-details">
                    <div class="item-name">Máy xay sinh tố Sunhouse</div>
                    <div class="item-qty">Số lượng: 1</div>
                </div>
                <div class="item-price">800.000₫</div>
            </div>

            <div class="order-item">
                <div class="item-image" style="background-image: url('/assets/images/sanpham/anh3.jpg')"></div>
                <div class="item-details">
                    <div class="item-name">Bộ dao nhà bếp Elmich</div>
                    <div class="item-qty">Số lượng: 1</div>
                </div>
                <div class="item-price">500.000₫</div>
            </div>
        </div>
    </div>

    <div class="buttons">
        <button class="primary-btn">Theo dõi đơn hàng</button>
        <button class="secondary-btn">Tiếp tục mua sắm</button>
    </div>

    <div class="footer">
        <p>Mọi thắc mắc xin liên hệ hotline: 1900 1234</p>
        <p>Email: support@example.com</p>
    </div>
</div>

<script>
    // Thêm hiệu ứng cho nút
    document.addEventListener('DOMContentLoaded', function () {
        const primaryBtn = document.querySelector('.primary-btn');
        const secondaryBtn = document.querySelector('.secondary-btn');

        primaryBtn.addEventListener('click', function () {
            alert('Chuyển đến trang theo dõi đơn hàng');
        });

        secondaryBtn.addEventListener('click', function () {
            alert('Chuyển đến trang chủ');
        });
    });
</script>
</body>
</html>