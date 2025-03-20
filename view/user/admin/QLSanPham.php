<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title>Quản Lý Sản Phẩm</title>
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

    .add-product {
        padding: 10px 15px;
        background-color: #202c46;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-product:hover {
        background-color: #17213a;
    }

    /* Products Table */
    .products-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(32, 44, 70, 0.1);
    }

    .products-table th,
    .products-table td {
        border: 1px solid #d1dbe8;
        padding: 12px 15px;
        text-align: left;
    }

    .products-table th {
        background-color: #202c46;
        color: #fff;
        font-weight: 600;
    }

    .products-table tr:nth-child(odd) {
        background-color: #f5f8fc;
    }

    .products-table tr:hover {
        background-color: #e6edf5;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }

    .product-actions {
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

    .edit-btn {
        background-color: #3d4a68;
        color: white;
    }

    .edit-btn:hover {
        background-color: #293654;
    }

    .delete-btn {
        background-color: #b32424;
        color: white;
    }

    .delete-btn:hover {
        background-color: #8e1c1c;
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

    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .active {
        background-color: #e6f7e6;
        color: #2e7d32;
    }

    .inactive {
        background-color: #feeae6;
        color: #c62828;
    }

    .low-stock {
        background-color: #fff8e1;
        color: #f57f17;
    }
</style>
<body>
<header class="header">
	<div class="logo">
		<img class="avatar" src="/view/assets/images/logo.png" alt="Logo">
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
			<img class="avatar" src="/view/assets/images/admin-avatar.jpg" alt="Admin Avatar">
			<p>Xin chào, Admin</p>
		</div>
		<ul>
			<li><a href="/admin/dashboard">Bảng Điều Khiển</a></li>
			<li><a href="/admin/products" style="background-color: #17213a; border-radius: 4px; padding: 8px; margin: -8px;">Quản Lý Sản Phẩm</a></li>
			<li><a href="/admin/categories">Quản Lý Danh Mục</a></li>
			<li><a href="/admin/orders">Quản Lý Đơn Hàng</a></li>
			<li><a href="/admin/customers">Quản Lý Khách Hàng</a></li>
			<li><a href="/admin/reports">Báo Cáo Thống Kê</a></li>
			<li><a href="/admin/settings">Cài Đặt Hệ Thống</a></li>
		</ul>
	</div>
	
	<!-- Main Content -->
	<div class="main-content">
		<h2>Quản Lý Sản Phẩm</h2>
		
		<div class="action-bar">
			<div class="search-box">
				<input type="text" placeholder="Tìm kiếm sản phẩm...">
				<button>🔍</button>
			</div>
			<button class="add-product">+ Thêm Sản Phẩm Mới</button>
		</div>
		
		<div class="filter-options">
			<select class="filter-select">
				<option value="">Tất cả danh mục</option>
				<option value="food">Thực phẩm</option>
				<option value="drinks">Đồ uống</option>
				<option value="desserts">Tráng miệng</option>
				<option value="snacks">Đồ ăn nhẹ</option>
			</select>
			
			<select class="filter-select">
				<option value="">Tất cả trạng thái</option>
				<option value="active">Đang bán</option>
				<option value="inactive">Ngừng bán</option>
				<option value="low">Sắp hết hàng</option>
			</select>
			
			<select class="filter-select">
				<option value="">Sắp xếp theo</option>
				<option value="name-asc">Tên (A-Z)</option>
				<option value="name-desc">Tên (Z-A)</option>
				<option value="price-asc">Giá (Thấp-Cao)</option>
				<option value="price-desc">Giá (Cao-Thấp)</option>
				<option value="stock-asc">Tồn kho (Thấp-Cao)</option>
				<option value="stock-desc">Tồn kho (Cao-Thấp)</option>
			</select>
		</div>
		
		<table class="products-table">
			<thead>
			<tr>
				<th>ID</th>
				<th>Hình ảnh</th>
				<th>Tên sản phẩm</th>
				<th>Danh mục</th>
				<th>Giá bán</th>
				<th>Tồn kho</th>
				<th>Trạng thái</th>
				<th>Hành động</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>#SP001</td>
				<td><img src="/view/assets/images/product1.jpg" alt="Bánh mì" class="product-image"></td>
				<td>Bánh mì thịt nướng</td>
				<td>Thực phẩm</td>
				<td>35,000 ₫</td>
				<td>120</td>
				<td><span class="status-badge active">Đang bán</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP002</td>
				<td><img src="/view/assets/images/product2.jpg" alt="Cà phê" class="product-image"></td>
				<td>Cà phê đen đá</td>
				<td>Đồ uống</td>
				<td>25,000 ₫</td>
				<td>85</td>
				<td><span class="status-badge active">Đang bán</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP003</td>
				<td><img src="/view/assets/images/product3.jpg" alt="Bánh flan" class="product-image"></td>
				<td>Bánh flan caramel</td>
				<td>Tráng miệng</td>
				<td>18,000 ₫</td>
				<td>5</td>
				<td><span class="status-badge low-stock">Sắp hết hàng</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP004</td>
				<td><img src="/view/assets/images/product4.jpg" alt="Nước cam" class="product-image"></td>
				<td>Nước cam tươi</td>
				<td>Đồ uống</td>
				<td>32,000 ₫</td>
				<td>42</td>
				<td><span class="status-badge active">Đang bán</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP005</td>
				<td><img src="/view/assets/images/product5.jpg" alt="Bánh quy" class="product-image"></td>
				<td>Bánh quy chocolate</td>
				<td>Đồ ăn nhẹ</td>
				<td>28,000 ₫</td>
				<td>0</td>
				<td><span class="status-badge inactive">Ngừng bán</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP006</td>
				<td><img src="/view/assets/images/product6.jpg" alt="Trà sữa" class="product-image"></td>
				<td>Trà sữa trân châu</td>
				<td>Đồ uống</td>
				<td>40,000 ₫</td>
				<td>65</td>
				<td><span class="status-badge active">Đang bán</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP007</td>
				<td><img src="/view/assets/images/product7.jpg" alt="Cơm chiên" class="product-image"></td>
				<td>Cơm chiên dương châu</td>
				<td>Thực phẩm</td>
				<td>55,000 ₫</td>
				<td>30</td>
				<td><span class="status-badge active">Đang bán</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
				</td>
			</tr>
			<tr>
				<td>#SP008</td>
				<td><img src="/view/assets/images/product8.jpg" alt="Smoothie" class="product-image"></td>
				<td>Smoothie xoài</td>
				<td>Đồ uống</td>
				<td>38,000 ₫</td>
				<td>12</td>
				<td><span class="status-badge low-stock">Sắp hết hàng</span></td>
				<td class="product-actions">
					<button class="action-btn edit-btn">Sửa</button>
					<button class="action-btn delete-btn">Xóa</button>
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

<script>
    // Placeholder for product management JavaScript functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add product button functionality
        document.querySelector('.add-product').addEventListener('click', function() {
            alert('Chức năng thêm sản phẩm sẽ mở ra form thêm sản phẩm mới');
        });

        // Edit buttons functionality
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const productId = row.querySelector('td:first-child').textContent;
                alert('Sửa sản phẩm có ID: ' + productId);
            });
        });

        // Delete buttons functionality
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const productId = row.querySelector('td:first-child').textContent;
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm có ID: ' + productId + '?')) {
                    alert('Đã xóa sản phẩm có ID: ' + productId);
                }
            });
        });

        // Filter selects functionality
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                console.log('Filter changed:', this.value);
                // Would implement actual filtering logic here
            });
        });

        // Search box functionality
        document.querySelector('.search-box button').addEventListener('click', function() {
            const searchTerm = document.querySelector('.search-box input').value;
            alert('Tìm kiếm: ' + searchTerm);
        });

        // Pagination functionality
        document.querySelectorAll('.pagination button').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('active')) {
                    document.querySelector('.pagination button.active').classList.remove('active');
                    this.classList.add('active');
                    // Would implement actual page changing logic here
                }
            });
        });
    });
</script>
</body>
</html>