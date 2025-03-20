<?php
	namespace BTL\view;
	
	// Sử dụng User model
	use BTL\model\User;
	
	// Giả định rằng chúng ta đã có session và user đã đăng nhập
	session_start();
	
	// Kiểm tra xem người dùng đã đăng nhập chưa
	if (!isset($_SESSION['ma'])) {
		header('Location: login.php');
		exit;
	}
	
	// Giả định rằng chúng ta có một đối tượng User
	require_once '../../model/User.php';
	require_once '../../controller/UserController.php';
	
	$userController = new \BTL\controller\UserController();
	$user = $userController->getUserById($_SESSION['ma']);
	
	// Xử lý form cập nhật thông tin
	$message = '';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['update_profile'])) {
			$ten = $_POST['ten'];
			$email = $_POST['email'];
			$diaChi = $_POST['diaChi'];
			
			// Xử lý upload ảnh nếu có
			$anh = $user->getAnh(); // Giữ nguyên ảnh cũ
			if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
				$uploadDir = '../uploads/';
				$fileName = time() . '_' . basename($_FILES['anh']['name']);
				$targetFile = $uploadDir . $fileName;
				
				if (move_uploaded_file($_FILES['anh']['tmp_name'], $targetFile)) {
					$anh = $fileName;
				}
			}
			
			// Cập nhật thông tin người dùng
			$user->setTen($ten);
			$user->setEmail($email);
			$user->setDiaChi($diaChi);
			$user->setAnh($anh);
			
			if ($userController->updateUser($user)) {
				$message = 'Cập nhật thông tin thành công!';
			} else {
				$message = 'Có lỗi xảy ra khi cập nhật thông tin!';
			}
		} elseif (isset($_POST['delete_account'])) {
			// Xóa tài khoản
			if ($userController->deleteUser($user->getMa())) {
				session_destroy();
				header('Location: login.php?message=Tài khoản đã được xóa');
				exit;
			} else {
				$message = 'Có lỗi xảy ra khi xóa tài khoản!';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thông tin cá nhân</title>
	<style>
        :root {
            --primary-color: #333;
            --secondary-color: #666;
            --accent-color: #999;
            --bg-color: #fff;
            --bg-accent: #f5f5f5;
            --border-color: #ddd;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--primary-color);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--bg-accent);
            border-radius: 8px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-color);
        }

        .profile-info {
            margin-left: 30px;
        }

        .profile-info h1 {
            margin: 0;
            color: var(--primary-color);
        }

        .profile-info p {
            color: var(--secondary-color);
            margin: 5px 0;
        }

        .form-container {
            background-color: var(--bg-accent);
            padding: 30px;
            border-radius: 8px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #f8f8f8;
            border-left: 4px solid #333;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--bg-color);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #000;
        }

        .btn-danger {
            background-color: #666;
            color: white;
            margin-left: 10px;
        }

        .btn-danger:hover {
            background-color: #444;
        }

        .delete-section {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .delete-section h2 {
            color: #444;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: var(--bg-color);
            margin: 15% auto;
            padding: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
        }

        .modal-header {
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-footer {
            padding: 10px 0;
            border-top: 1px solid var(--border-color);
            text-align: right;
        }

        .close {
            color: var(--secondary-color);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: var(--primary-color);
        }
	</style>
</head>
<body>
<div class="container">
	<div class="profile-header">
		<img src="<?php echo !empty($user->getAnh()) ? '../uploads/' . $user->getAnh() : '../assets/default-avatar.png'; ?>" alt="Profile Image" class="profile-image">
		<div class="profile-info">
			<h1><?php echo htmlspecialchars($user->getTen()); ?></h1>
			<p><?php echo htmlspecialchars($user->getEmail()); ?></p>
			<p><?php echo htmlspecialchars($user->getDiaChi()); ?></p>
		</div>
	</div>
	
	<?php if (!empty($message)): ?>
		<div class="alert">
			<?php echo $message; ?>
		</div>
	<?php endif; ?>
	
	<div class="form-container">
		<h2>Cập nhật thông tin cá nhân</h2>
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label for="ten">Họ và tên</label>
				<input type="text" id="ten" name="ten" class="form-control" value="<?php echo htmlspecialchars($user->getTen()); ?>" required>
			</div>
			
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>
			</div>
			
			<div class="form-group">
				<label for="diaChi">Địa chỉ</label>
				<input type="text" id="diaChi" name="diaChi" class="form-control" value="<?php echo htmlspecialchars($user->getDiaChi()); ?>">
			</div>
			
			<div class="form-group">
				<label for="anh">Ảnh đại diện</label>
				<input type="file" id="anh" name="anh" class="form-control" accept="image/*">
			</div>
			
			<div class="form-group">
				<button type="submit" name="update_profile" class="btn btn-primary">Cập nhật thông tin</button>
			</div>
		</form>
		
		<div class="delete-section">
			<h2>Xóa tài khoản</h2>
			<p>Khi bạn xóa tài khoản, tất cả dữ liệu liên quan đến tài khoản của bạn sẽ bị xóa vĩnh viễn.</p>
			<button id="openDeleteModal" class="btn btn-danger">Xóa tài khoản</button>
		</div>
	</div>
</div>

<!-- Modal xác nhận xóa tài khoản -->
<div id="deleteModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close">&times;</span>
			<h2>Xác nhận xóa tài khoản</h2>
		</div>
		<div class="modal-body">
			<p>Bạn có chắc chắn muốn xóa tài khoản này không? Hành động này không thể hoàn tác.</p>
		</div>
		<div class="modal-footer">
			<form method="POST">
				<button type="button" class="btn" id="closeModal">Hủy</button>
				<button type="submit" name="delete_account" class="btn btn-danger">Xác nhận xóa</button>
			</form>
		</div>
	</div>
</div>

<script>
    // JavaScript cho modal
    var modal = document.getElementById("deleteModal");
    var btn = document.getElementById("openDeleteModal");
    var span = document.getElementsByClassName("close")[0];
    var closeBtn = document.getElementById("closeModal");

    // Mở modal khi nhấp vào nút xóa tài khoản
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Đóng modal khi nhấp vào nút đóng (x)
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Đóng modal khi nhấp vào nút hủy
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Đóng modal khi nhấp vào bên ngoài modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>