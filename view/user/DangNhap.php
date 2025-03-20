<?php
	session_start();
	require_once __DIR__ . '/../../controller/TaiKhoanController.php';
	
	use BTL\controller\TaiKhoanController;
	
	$message = '';
	$controller = new TaiKhoanController();
	
	// Pre-fill username from cookie if available
	$username_value = isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : (isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '');
	
	// Handle login form submission
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dang_nhap'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$remember = isset($_POST['remember']);
		
		if (empty($username) || empty($password)) {
			$message = "<p class='error'>Vui lòng điền đầy đủ thông tin!</p>";
		} else {
			$result = $controller->DangNhap($username, $password, $remember);
			if ($result['success']) {
				$_SESSION['ma'] = $result['ma'];
				$_SESSION['ten'] = $result['ten'];
				$_SESSION['anh'] = $result['anh'];
				$_SESSION['username'] = $result['username'];
				$_SESSION['quyen'] = $result['role'];
				
				if ($result['role'] === 1) {
					header("Location: ../../admin/Dashboard.php");
				} else {
					header("Location: ../user/khachhang/TrangChu.php");
				}
				exit();
			} else {
				$message = "<p class='error'>" . htmlspecialchars($result['message']) . "</p>";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
          integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/view/assets/user/css/dangnhap.css">
</head>
<body>
<div class="login-container">
    <div class="left-section">
        <div style="background-image: url('/view/assets/images/dangnhap/img.png');" class="image-container"></div>
    </div>
    <div class="right-section">
        <div class="back-link">
            <a href="#">Quay lại</a>
        </div>
        <div class="form-header">
            <h2>Đăng nhập</h2>
            <p>Bạn chưa có tài khoản? <a href="DangKy.php">Đăng kí</a></p>
        </div>
        <span style="color: red; margin-bottom: 10px"><?php echo $message ? $message : ''; ?></span>
        <form method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Tên đăng nhập" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                <label for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <button type="submit" name="dang_nhap" class="submit-btn">Đăng nhập</button>
            <div class="social-login">
                <button type="button" class="social-btn">
                    <i class="fa-brands fa-google"></i>
                    Google
                </button>
                <button type="button" class="social-btn">
                    <i class="fa-brands fa-facebook-f"></i>
                    Facebook
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>