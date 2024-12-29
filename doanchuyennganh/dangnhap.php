<?php
session_start();

// Database connection constants
define("HOST", "localhost");
define("DATABASE", "chuyenn");
define("USERNAME", "root");
define("PASSWORD", "");

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error = '';
$loginError = '';

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['idnguoidung'])) {
    header("Location: index.php");
    exit();
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Email'], $_POST['matkhaut'])) {
        $login_Email = $_POST['Email'];
        $login_matkhau = $_POST['matkhaut'];

        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare("SELECT idnguoidung, matkhau FROM nguoidung WHERE email = ?");
        $stmt->bind_param("s", $login_Email);
        $stmt->execute();
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();

        // Kiểm tra mật khẩu
        if ($stored_password && $login_matkhau == $stored_password) {
            $_SESSION['idnguoidung'] = $user_id;
            $_SESSION['tennd'] = $login_Email;
            header("Location: index.php");
            exit();
        } else {
            $loginError = "Tên người dùng hoặc mật khẩu không đúng.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILK_TEA Store 2003</title>
    <link rel="stylesheet" href="t.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="row">
    <header class="d-flex justify-content-between align-items-center">
        <div class="d-flex">
            <h4 class="me-2">MILK_TEA Store</h4>
            <img src="img/logo.png" width="70" alt="MILK TEA SHOP 2003">
        </div>
        <div class="d-flex">
            <form class="d-flex" action="timkiem.php" method="GET">
                <input class="form-control" type="search" name="query" placeholder="Tìm kiếm..." required>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <a href="dangki.php" class="ms-2">Đăng Kí</a> 
            <a href="dangnhap.php" class="ms-2">Đăng Nhập</a> 
        </div>
    </header>
</div>

<div class="row">
<nav class="bg-success">
    <div class="container-fluid">
        <ul class="nav-item d-flex justify-content-around align-items-center">
            <li class="nav"><a class="nav-link" href="index.php">Trang Chủ</a></li>
            <li class="nav"><a class="nav-link" href="gioithieu.php">Giới Thiệu</a></li>
            <li class="nav dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="menu" data-bs-toggle="dropdown">Menu</a>
                <ul class="dropdown-menu" aria-labelledby="menu">
                    <li><a class="dropdown-item" href="trasua.php">Trà Sữa</a></li>
                    <li><a class="dropdown-item" href="tratraicay.php">Trà Trái Cây</a></li>
                    <li><a class="dropdown-item" href="trasuakem.php">Trà Sữa Kem</a></li>
                    <li><a class="dropdown-item" href="cafe.php">Cafe</a></li>
                </ul>
            </li>
            <li class="nav"><a class="nav-link" href="khuyenmai.php">Khuyến Mãi</a></li>
            <li class="nav"><a class="nav-link" href="giohang.php"><img src="https://hasaki.vn/wap-static/images/graphics/cart_top.svg" alt="Giỏ hàng" width="30"></a></li>
        </ul>
    </div>
</nav>
</div>

<div class="row">
    <h2>Đăng Nhập</h2>
    
    <?php if ($loginError): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
    <?php endif; ?>
    
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="Email" class="form-label">Email</label>
            <input type="email" class="form-control" id="Email" name="Email" required>
        </div>
        <div class="mb-3">
            <label for="matkhaut" class="form-label">Mật Khẩu</label>
            <input type="password" class="form-control" id="matkhaut" name="matkhaut" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </form>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-success">Hotline</h2>
                <p>📞 0354219578</p>
                <p>📍 Địa chỉ: 123 Đường Pạm Thị Tánh, Phường 4, Quận 8, tp. Hồ Chí Minh</p>
            </div>
            <div class="col-md-4 text-center">
                <h2 class="text-success">Về Chúng Tôi</h2>
                <p>Milk Tea Store cung cấp các loại trà sữa thơm ngon và đa dạng, phục vụ nhu cầu của mọi khách hàng.</p>
                <div>
                    <a href="#" class="text-success me-2">Privacy Policy</a>
                    <a href="#" class="text-success">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <p>&copy; 2023 Milk Tea Store. All rights reserved.</p>
    </div>
</footer>
</body>
</html>