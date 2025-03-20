<!-- /view/components/header.php -->
<div class="header">
	<div class="container header-container">
		<a href="../khachhang/TrangChu.php" class="logo">
			<img src="/view/assets/images/logo/logo.jpg" alt="Shopee"/>
			HOMECARE
		</a>
		
		<form action=" method=" GET" class="search-bar">
			<input type="text" name="timkiem" placeholder="Tìm sản phẩm, thương hiệu và tên shop" required>
			<button type="submit" class="search-button">
				🔍
			</button>
		</form>

        <div class="nav-menu">
			<?php
				if (isset($_SESSION['ten']) && $_SESSION['quyen'] == 2) {
					echo '<a href="../khachhang/GioHang.php" class="nav-item">
                    <i>🛒</i> Giỏ hàng
                </a>
                <a href="#" class="nav-item">
                    <i>🙋 Xin chào ' . htmlspecialchars($_SESSION['ten']) . '</i>
                </a>
                <a href="javascript:void(0)" onclick="confirmLogout()" class="nav-item">
                    <i>🚪</i> Đăng xuất
                </a>';
				} else {
					echo '<a href="../DangNhap.php" class="nav-item">
                    <i>🙋</i> Đăng nhập
                </a>';
				}
			?>
        </div>

        <script>
            function confirmLogout() {
                if (confirm("Bạn có chắc muốn đăng xuất không?")) {
                    window.location.href = "../DangXuat.php";
                }
            }
        </script>
	</div>
</div>