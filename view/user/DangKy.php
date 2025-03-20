<?php
	session_start();
	require_once __DIR__ . '/../../controller/KhachHangController.php';
	require_once __DIR__ . '/../../controller/TaiKhoanController.php';
	require_once __DIR__ . '/../../model/KhachHang.php';
	
	use BTL\controller\KhachHangController;
	use BTL\controller\TaiKhoanController;
	use BTL\model\KhachHang;
	
	$message = '';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dang_ky'])) {
		$ten = trim($_POST['ten']);
		$email = trim($_POST['email']);
		$diaChi = trim($_POST['diaChi']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$passwordConfirm = trim($_POST['passwordconfirm']);
		$termsAgreed = isset($_POST['terms']);
		
		$anh = 'default_user.jpg'; // Default image for new users
		
		if (empty($ten) || empty($email) || empty($diaChi) || empty($username) || empty($password) || empty($passwordConfirm)) {
			$message = "<p class='error'>Vui lòng điền đầy đủ thông tin!</p>";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$message = "<p class='error'>Email không hợp lệ!</p>";
		} elseif ($password !== $passwordConfirm) {
			$message = "<p class='error'>Mật khẩu và xác nhận mật khẩu không khớp!</p>";
		} elseif (!$termsAgreed) {
			$message = "<p class='error'>Bạn phải đồng ý với Chính sách & Điều khoản!</p>";
		} else {
			$controller = new KhachHangController();
			$khachHang = new KhachHang(null, $ten, $email, $diaChi, $anh);
			
			// Attempt to register
			if ($controller->Them($khachHang, $username, $password)) {
                $taiKhoanController = new TaiKhoanController();
                $taikhoan = $taiKhoanController->LayBangUserId($khachHang->getMa());
                
				$_SESSION['ma'] = $khachHang->getMa();
                $_SESSION['ten'] = $ten;
                $_SESSION['anh'] = $anh;
				$_SESSION['username'] = $username; // Auto-login after signup
                $_SESSION['quyen'] = $taikhoan->getMaQuyen();
				header("Location: ../khachhang/TrangChu.php");
				exit();
			} else {
				$message = "<p class='error'>Đăng ký thất bại! Tên đăng nhập hoặc email có thể đã tồn tại.</p>";
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
            <a href="">Quay lại</a>
        </div>
        <div class="form-header">
            <h2>Tạo tài khoản</h2>
            <p>Bạn đã có tài khoản? <a href="DangNhap.php">Đăng nhập</a></p>
        </div>
        <form method="post">
            <div class="form-group">
                <input type="text" name="ten" placeholder="Họ và tên"
                       value="<?php echo isset($_POST['ten']) ? htmlspecialchars($_POST['ten']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="diaChi" placeholder="Địa chỉ"
                       value="<?php echo isset($_POST['diaChi']) ? htmlspecialchars($_POST['diaChi']) : ''; ?>"
                       required>
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Tên đăng nhập"
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                       required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Mật khẩu" name="password" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Nhập lại mật khẩu" name="passwordconfirm" required>
            </div>
            <div class="remember-me">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms">Đồng ý với các <a href="#">Chính sách & Điều khoản</a></label>
            </div>
            <span style="color: white;">
			<?php echo $message ? $message : null; ?>
            </span>
            <br>
            <button type="submit" name="dang_ky" class="submit-btn">Đăng ký</button>
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