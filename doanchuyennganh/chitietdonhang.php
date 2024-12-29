<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILK_TEA Store 2003</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="t.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="d-flex justify-content-between align-items-center p-3">
        <div class="d-flex">
            <h4 class="me-2">MILK_TEA Store</h4>
            <img src="img/logo.png" width="70" alt="Logo">
        </div>
        <div class="d-flex">
            <form class="d-flex" action="timkiem.php" method="GET">
                <input class="form-control" type="search" name="query" placeholder="Tìm kiếm..." aria-label="Search" required>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <a href="dangxuat.php" class="nav-link" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?');">Đăng Xuất</a>
        </div>
    </header>

    <nav class="bg-success">
        <div class="container-fluid">
            <ul class="nav-item d-flex justify-content-around align-items-center">
                <li class="nav"><a class="nav-link" href="index.php">Trang Chủ</a></li>
                <li class="nav"><a class="nav-link" href="gioithieu.php">Giới Thiệu</a></li>
                <li class="nav dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="menu" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
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

    <div class="container mt-5">
        <h1>Đặt hàng thành công </h1>
        <?php
        // Check if success parameter is set
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            echo "<div class='alert alert-success'>Đặt hàng thành công!</div>";
        }
        ?>
        <a href="index.php" class="btn btn-primary">Quay lại trang chính</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <footer >
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
    </div>
</footer>
</body>
</html>