<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        header h1 {
            font-size: 24px;
            font-weight: 500;
        }

        .close-btn {
            width: 30px;
            height: 30px;
            background-color: #666;
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .section-title {
            margin: 20px 0 10px;
            font-size: 18px;
            font-weight: 600;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .customer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .customer-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .customer-info p {
            color: #666;
            font-size: 14px;
            margin: 3px 0;
        }

        .edit-btn {
            background-color: transparent;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .edit-btn:hover {
            background-color: #f0f0f0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #666;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #aaa;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
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
            width: 80px;
            height: 80px;
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

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-weight: 700;
            font-size: 18px;
        }

        .payment-select {
            width: 100%;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: white;
            font-size: 16px;
            color: #333;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
            cursor: pointer;
        }

        .payment-select:focus {
            outline: none;
            border-color: #aaa;
        }

        .confirm-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .confirm-btn:hover {
            background-color: #444;
        }

        .footer {
            text-align: center;
            color: #999;
            margin-top: 20px;
            font-size: 14px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .close-modal {
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-cancel {
            padding: 10px 15px;
            border: 1px solid #ddd;
            background-color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-save {
            padding: 10px 15px;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .form-row {
                flex-direction: column;
                gap: 10px;
            }

            .item-image {
                width: 60px;
                height: 60px;
            }

            .item-price {
                min-width: 80px;
            }

            .modal-content {
                width: 95%;
                margin: 5% auto;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>Thanh Toán</h1>
    <button class="close-btn">X</button>
</header>

<div class="container">
    <h2 class="section-title">Thông tin người đặt</h2>
    <div class="card">
        <div class="customer-info">
            <div>
                <h3>Thông tin cá nhân</h3>
                <p id="customer-name">Nguyễn Văn A</p>
                <p id="customer-email">nguyenvana@email.com</p>
                <p id="customer-phone">0912345678</p>
            </div>
            <button class="edit-btn" id="edit-info-btn">Chỉnh sửa</button>
        </div>

        <div class="customer-info">
            <div>
                <h3>Địa chỉ giao hàng</h3>
                <p id="shipping-address">123 Đường ABC, Phường XYZ, Quận 1</p>
                <p id="shipping-city">TP. Hồ Chí Minh</p>
            </div>
            <button class="edit-btn" id="edit-address-btn">Chỉnh sửa</button>
        </div>
    </div>

    <h2 class="section-title">Thông tin đơn hàng</h2>
    <div class="card">
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

    <div class="card">
        <div class="summary-row">
            <div>Tổng tiền hàng:</div>
            <div>2.500.000₫</div>
        </div>
        <div class="summary-row">
            <div>Phí vận chuyển:</div>
            <div>30.000₫</div>
        </div>
        <div class="summary-row total">
            <div>Tổng thanh toán:</div>
            <div>2.530.000₫</div>
        </div>
    </div>

    <h2 class="section-title">Phương thức thanh toán</h2>
    <select id="paymentMethod" class="payment-select">
        <option value="" selected disabled>Chọn phương thức thanh toán</option>
        <option value="credit_card">Thẻ tín dụng / Ghi nợ</option>
        <option value="bank_transfer">Chuyển khoản ngân hàng</option>
        <option value="e_wallet">Ví điện tử</option>
    </select>

    <div id="paymentDetails" class="card" style="display: none;">
        <!-- Payment details will be dynamically inserted here -->
    </div>

    <button class="confirm-btn">Xác nhận thanh toán</button>

    <div class="footer">
        Thanh toán an toàn & bảo mật
    </div>
</div>

<!-- Modal for editing personal information -->
<div id="infoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Chỉnh sửa thông tin cá nhân</h2>
            <span class="close-modal">&times;</span>
        </div>
        <form id="info-form">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" value="Nguyễn Văn A" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="nguyenvana@email.com" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" value="0912345678" required>
                </div>
            </div>
            <div class="modal-buttons">
                <button type="button" class="modal-cancel">Hủy</button>
                <button type="submit" class="modal-save">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for editing shipping address -->
<div id="addressModal" class="modal">
    <div class="modal-content">
        <div class="modal-