<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title>Quản Lý Đơn Hàng</title>
</head>
<style>
    /* Tổng quát */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        color: #333;
    }

    /* Container */
    .container {
        display: flex;
        height: 100vh;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #202c46; /* Primary dark navy */
        border-bottom: 1px solid #151d30;
        height: 60px;
        color: #fff;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo img.avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .logo span {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
    }

    .menu {
        width: 100%;
        text-align: right;
    }

    .menu a {
        margin-left: 20px;
        text-decoration: none;
        color: #c3cad9;
        font-size: 14px;
        transition: color 0.3s;
    }

    .menu a:hover {
        color: #fff;
    }

    nav {
        display: block;
        unicode-bidi: isolate;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #293654; /* Slightly lighter navy for sidebar */
        border-right: 1px solid #202c46;
        padding: 20px 10px;
        text-align: left;
        color: #fff;
    }

    .sidebar .logo {
        text-align: center;
    }

    .sidebar .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
        border: 3px solid #3d4a68;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }

    .sidebar ul li {
        padding: 12px 15px;
        border-bottom: 1px solid #34405e;
    }

    .sidebar ul li a {
        text-decoration: none;
        color: #e0edff;
        display: block;
        transition: color 0.3s;
    }

    .sidebar ul li a:hover {
        color: #fff;
        background-color: #17213a; /* Darker navy for hover */
        border-radius: 4px;
        padding: 8px;
        margin: -8px;
    }

    /* Main Content */
    .main-content {
        flex-grow: 1;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        overflow-y: auto;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        background: #f5f8fc;
        border: 1px solid #d1dbe8;
        border-radius: 4px;
        padding: 8px 12px;
    }

    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        width: 250px;
        font-size: 14px;
    }

    .search-box button {
        background: none;
        border: none;
        color: #202c46;
        cursor: pointer;
    }

    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .pending {
        background-color: #fff8e1;
        color: #f57f17;
    }

    .processing {
        background-color: #e3f2fd;
        color: #1565c0;
    }

    .shipped {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .delivered {
        background-color: #e6f7e6;
        color: #2e7d32;
    }

    .cancelled {
        background-color: #feeae6;
        color: #c62828;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 5px;
    }

    .pagination button {
        padding: 8px 12px;
        border: 1px solid #d1dbe8;
        background-color: #fff;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .pagination button.active {
        background-color: #202c46;
        color: white;
        border-color: #202c46;
    }

    .pagination button:hover:not(.active) {
        background-color: #e6edf5;
    }

    /* Filter Options */
    .filter-options {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #d1dbe8;
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        outline: none;
    }

    h2 {
        color: #202c46; /* Dark navy heading */
        margin-bottom: 25px;
        border-bottom: 2px solid #d1dbe8;
        padding-bottom: 10px;
    }

    /* Orders Table */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(32, 44, 70, 0.1);
    }

    .orders-table th,
    .orders-table td {
        border: 1px solid #d1dbe8;
        padding: 12px 15px;
        text-align: left;
    }

    .orders-table th {
        background-color: #202c46;
        color: #fff;
        font-weight: 600;
    }

    .orders-table tr:nth-child(odd) {
        background-color: #f5f8fc;
    }

    .orders-table tr:hover {
        background-color: #e6edf5;
    }

    .order-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.3s;
    }

    .view-btn {
        background-color: #3d4a68;
        color: white;
    }

    .view-btn:hover {
        background-color: #293654;
    }

    .cancel-btn {
        background-color: #b32424;
        color: white;
    }

    .cancel-btn:hover {
        background-color: #8e1c1c;
    }

    .update-btn {
        background-color: #28a745;
        color: white;
    }

    .update-btn:hover {
        background-color: #218838;
    }

    /* Order details modal */
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
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #d1dbe8;
        border-radius: 8px;
        width: 70%;
        max-width: 800px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #d1dbe8;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .modal-title {
        font-size: 1.5rem;
        color: #202c46;
        margin: 0;
    }

    .close-btn {
        font-size: 28px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #333;
    }

    .order-detail-section {
        margin-bottom: 20px;
    }

    .order-detail-header {
        font-weight: bold;
        color: #202c46;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .order-items {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .order-items th, .order-items td {
        border: 1px solid #d1dbe8;
        padding: 8px 12px;
    }

    .order-items th {
        background-color: #f5f8fc;
    }

    .status-update-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #d1dbe8;
    }

    .status-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
<body>
<header class="header">
	<div class="logo">
		<img class="avatar" src="/assets/images/logo.png" alt="Logo">
		<span>Quản Trị Hệ Thống</span>
	</div>
	<div class="menu">
		<a href="/admin/dashboard">Trang Chủ</a>
		<a href="/admin/profile">Tài Khoản</a>
		<a href="/logout">Đăng Xuất</a>
	</div>
</header>
<div class="container">
	<!-- Sidebar -->
	<div class="sidebar">
		<div class="logo">
			<img class="avatar" src="/assets/images/admin-avatar.jpg" alt="Admin Avatar">
			<p>Xin chào, Admin</p>
		</div>
		<ul>
			<li><a href="/admin/dashboard">Bảng Điều Khiển</a></li>
			<li><a href="/admin/products">Quản Lý Sản Phẩm</a></li>
			<li><a href="/admin/categories">Quản Lý Danh Mục</a></li>
			<li><a href="/admin/orders" style="background-color: #17213a; border-radius: 4px; padding: 8px; margin: -8px;">Quản Lý Đơn Hàng</a></li>
			<li><a href="/admin/customers">Quản Lý Khách Hàng</a></li>
			<li><a href="/admin/reports">Báo Cáo Thống Kê</a></li>
			<li><a href="/admin/settings">Cài Đặt Hệ Thống</a></li>
		</ul>
	</div>
	
	<!-- Main Content -->
	<div class="main-content">
		<h2>Quản Lý Đơn Hàng</h2>
		
		<div class="action-bar">
			<div class="search-box">
				<input type="text" placeholder="Tìm kiếm theo mã đơn hoặc khách hàng...">
				<button>🔍</button>
			</div>
		</div>
		
		<div class="filter-options">
			<select class="filter-select" id="status-filter">
				<option value="">Tất cả trạng thái</option>
				<option value="pending">Chờ xác nhận</option>
				<option value="processing">Đang xử lý</option>
				<option value="shipped">Đã giao cho vận chuyển</option>
				<option value="delivered">Đã giao hàng</option>
				<option value="cancelled">Đã hủy</option>
			</select>
			
			<select class="filter-select" id="date-filter">
				<option value="">Tất cả thời gian</option>
				<option value="today">Hôm nay</option>
				<option value="yesterday">Hôm qua</option>
				<option value="thisweek">Tuần này</option>
				<option value="lastweek">Tuần trước</option>
				<option value="thismonth">Tháng này</option>
				<option value="lastmonth">Tháng trước</option>
			</select>
			
			<select class="filter-select" id="sort-filter">
				<option value="">Sắp xếp theo</option>
				<option value="newest">Mới nhất trước</option>
				<option value="oldest">Cũ nhất trước</option>
				<option value="price-high">Giá trị cao - thấp</option>
				<option value="price-low">Giá trị thấp - cao</option>
			</select>
		</div>
		
		<table class="orders-table">
			<thead>
			<tr>
				<th>Mã đơn</th>
				<th>Khách hàng</th>
				<th>Ngày đặt</th>
				<th>Sản phẩm</th>
				<th>Tổng tiền</th>
				<th>Trạng thái</th>
				<th>Hành động</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>#DH001</td>
				<td>Nguyễn Văn A</td>
				<td>12/03/2025</td>
				<td>3 sản phẩm</td>
				<td>265,000 ₫</td>
				<td><span class="status-badge pending">Chờ xác nhận</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH001')">Xem</button>
					<button class="action-btn update-btn">Xác nhận</button>
					<button class="action-btn cancel-btn">Hủy</button>
				</td>
			</tr>
			<tr>
				<td>#DH002</td>
				<td>Trần Thị B</td>
				<td>11/03/2025</td>
				<td>5 sản phẩm</td>
				<td>410,000 ₫</td>
				<td><span class="status-badge processing">Đang xử lý</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH002')">Xem</button>
					<button class="action-btn update-btn">Giao hàng</button>
					<button class="action-btn cancel-btn">Hủy</button>
				</td>
			</tr>
			<tr>
				<td>#DH003</td>
				<td>Phạm Văn C</td>
				<td>10/03/2025</td>
				<td>2 sản phẩm</td>
				<td>120,000 ₫</td>
				<td><span class="status-badge shipped">Đã giao cho vận chuyển</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH003')">Xem</button>
					<button class="action-btn update-btn">Đã giao</button>
				</td>
			</tr>
			<tr>
				<td>#DH004</td>
				<td>Hoàng Thị D</td>
				<td>09/03/2025</td>
				<td>4 sản phẩm</td>
				<td>320,000 ₫</td>
				<td><span class="status-badge delivered">Đã giao hàng</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH004')">Xem</button>
				</td>
			</tr>
			<tr>
				<td>#DH005</td>
				<td>Lê Văn E</td>
				<td>09/03/2025</td>
				<td>1 sản phẩm</td>
				<td>55,000 ₫</td>
				<td><span class="status-badge cancelled">Đã hủy</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH005')">Xem</button>
				</td>
			</tr>
			<tr>
				<td>#DH006</td>
				<td>Vũ Thị F</td>
				<td>08/03/2025</td>
				<td>3 sản phẩm</td>
				<td>180,000 ₫</td>
				<td><span class="status-badge delivered">Đã giao hàng</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH006')">Xem</button>
				</td>
			</tr>
			<tr>
				<td>#DH007</td>
				<td>Đặng Văn G</td>
				<td>08/03/2025</td>
				<td>2 sản phẩm</td>
				<td>95,000 ₫</td>
				<td><span class="status-badge processing">Đang xử lý</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH007')">Xem</button>
					<button class="action-btn update-btn">Giao hàng</button>
					<button class="action-btn cancel-btn">Hủy</button>
				</td>
			</tr>
			<tr>
				<td>#DH008</td>
				<td>Ngô Thị H</td>
				<td>07/03/2025</td>
				<td>6 sản phẩm</td>
				<td>520,000 ₫</td>
				<td><span class="status-badge shipped">Đã giao cho vận chuyển</span></td>
				<td class="order-actions">
					<button class="action-btn view-btn" onclick="showOrderDetails('DH008')">Xem</button>
					<button class="action-btn update-btn">Đã giao</button>
				</td>
			</tr>
			</tbody>
		</table>
		
		<div class="pagination">
			<button>«</button>
			<button class="active">1</button>
			<button>2</button>
			<button>3</button>
			<button>»</button>
		</div>
	</div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<h3 class="modal-title">Chi Tiết Đơn Hàng #<span id="orderIdDisplay"></span></h3>
			<span class="close-btn" onclick="closeOrderDetails()">&times;</span>
		</div>
		<div id="orderDetailsContent">
			<div class="order-detail-section">
				<div class="order-detail-header">Thông Tin Khách Hàng</div>
				<p><strong>Họ tên:</strong> <span id="customerName">Nguyễn Văn A</span></p>
				<p><strong>Số điện thoại:</strong> <span id="customerPhone">0912345678</span></p>
				<p><strong>Email:</strong> <span id="customerEmail">nguyenvana@example.com</span></p>
			</div>
			
			<div class="order-detail-section">
				<div class="order-detail-header">Thông Tin Giao Hàng</div>
				<p><strong>Địa chỉ:</strong> <span id="shippingAddress">123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</span></p>
				<p><strong>Phương thức vận chuyển:</strong> <span id="shippingMethod">Giao hàng tiêu chuẩn</span></p>
				<p><strong>Ghi chú:</strong> <span id="orderNotes">Giao hàng vào buổi sáng</span></p>
			</div>
			
			<div class="order-detail-section">
				<div class="order-detail-header">Thông Tin Thanh Toán</div>
				<p><strong>Phương thức thanh toán:</strong> <span id="paymentMethod">Thanh toán khi nhận hàng (COD)</span></p>
				<p><strong>Trạng thái thanh toán:</strong> <span id="paymentStatus">Chưa thanh toán</span></p>
			</div>
			
			<div class="order-detail-section">
				<div class="order-detail-header">Sản Phẩm Đặt Hàng</div>
				<table class="order-items">
					<thead>
					<tr>
						<th>Sản phẩm</th>
						<th>Đơn giá</th>
						<th>Số lượng</th>
						<th>Thành tiền</th>
					</tr>
					</thead>
					<tbody id="orderItemsList">
					<!-- Order items will be populated here -->
					</tbody>
					<tfoot>
					<tr>
						<td colspan="3" style="text-align: right;"><strong>Tổng cộng sản phẩm:</strong></td>
						<td id="orderSubtotal">245,000 ₫</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align: right;"><strong>Phí vận chuyển:</strong></td>
						<td id="shippingFee">20,000 ₫</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align: right;"><strong>Tổng thanh toán:</strong></td>
						<td id="orderTotal" style="font-weight: bold; color: #202c46;">265,000 ₫</td>
					</tr>
					</tfoot>
				</table>
			</div>
			
			<div class="order-detail-section">
				<div class="order-detail-header">Lịch Sử Trạng Thái</div>
				<table class="order-items">
					<thead>
					<tr>
						<th>Thời gian</th>
						<th>Trạng thái</th>
						<th>Ghi chú</th>
						<th>Người cập nhật</th>
					</tr>
					</thead>
					<tbody id="orderStatusHistory">
					<!-- Status history will be populated here -->
					</tbody>
				</table>
			</div>
			
			<div class="status-update-section">
				<div class="order-detail-header">Cập Nhật Trạng Thái</div>
				<form class="status-form">
					<select class="filter-select" id="statusUpdate">
						<option value="pending">Chờ xác nhận</option>
						<option value="processing">Đang xử lý</option>
						<option value="shipped">Đã giao cho vận chuyển</option>
						<option value="delivered">Đã giao hàng</option>
						<option value="cancelled">Đã hủy</option>
					</select>
					<input type="text" class="search-box" style="flex-grow: 1;" placeholder="Ghi chú cập nhật...">
					<button type="button" class="action-btn update-btn">Cập nhật</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
    // Placeholder data for the order details (this would come from your backend in a real application)
    const orderItems = {
        'DH001': [
            { name: 'Bánh mì thịt nướng', price: '35,000 ₫', quantity: 3, total: '105,000 ₫' },
            { name: 'Cà phê đen đá', price: '25,000 ₫', quantity: 2, total: '50,000 ₫' },
            { name: 'Bánh flan caramel', price: '18,000 ₫', quantity: 5, total: '90,000 ₫' }
        ],
        'DH002': [
            { name: 'Trà sữa trân châu', price: '40,000 ₫', quantity: 4, total: '160,000 ₫' },
            { name: 'Bánh quy chocolate', price: '28,000 ₫', quantity: 3, total: '84,000 ₫' },
            { name: 'Cơm chiên dương châu', price: '55,000 ₫', quantity: 2, total: '110,000 ₫' },
            { name: 'Nước cam tươi', price: '32,000 ₫', quantity: 1, total: '32,000 ₫' },
            { name: 'Bánh flan caramel', price: '18,000 ₫', quantity: 1, total: '18,000 ₫' }
        ],
        'DH003': [
            { name: 'Smoothie xoài', price: '38,000 ₫', quantity: 2, total: '76,000 ₫' },
            { name: 'Bánh quy chocolate', price: '28,000 ₫', quantity: 1, total: '28,000 ₫' }
        ],
        'DH004': [
            { name: 'Bánh mì thịt nướng', price: '35,000 ₫', quantity: 2, total: '70,000 ₫' },
            { name: 'Cà phê đen đá', price: '25,000 ₫', quantity: 4, total: '100,000 ₫' },
            { name: 'Cơm chiên dương châu', price: '55,000 ₫', quantity: 2, total: '110,000 ₫' },
            { name: 'Bánh flan caramel', price: '18,000 ₫', quantity: 1, total: '18,000 ₫' }
        ],
        'DH005': [
            { name: 'Cơm chiên dương châu', price: '55,000 ₫', quantity: 1, total: '55,000 ₫' }
        ],
        'DH006': [
            { name: 'Trà sữa trân châu', price: '40,000 ₫', quantity: 2, total: '80,000 ₫' },
            { name: 'Bánh flan caramel', price: '18,000 ₫', quantity: 3, total: '54,000 ₫' },
            { name: 'Nước cam tươi', price: '32,000 ₫', quantity: 1, total: '32,000 ₫' }
        ],
        'DH007': [
            { name: 'Cà phê đen đá', price: '25,000 ₫', quantity: 2, total: '50,000 ₫' },
            { name: 'Bánh quy chocolate', price: '28,000 ₫', quantity: 1, total: '28,000 ₫' }
        ],
        'DH008': [
            { name: 'Bánh mì thịt nướng', price: '35,000 ₫', quantity: 4, total: '140,000 ₫' },
            { name: 'Trà sữa trân châu', price: '40,000 ₫', quantity: 3, total: '120,000 ₫' },
            { name: 'Smoothie xoài', price: '38,000 ₫', quantity: 4, total: '152,000 ₫' },
            { name: 'Cơm chiên dương châu', price: '55,000 ₫', quantity: 1, total: '55,000 ₫' },
            { name: 'Bánh flan caramel', price: '18,000 ₫', quantity: 2, total: '36,000 ₫' },
            { name: 'Cà phê đen đá', price: