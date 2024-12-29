<?php
session_start();
include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILK_TEA Store 2003</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="thu.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        h2 {
            text-align: center;
        }
    
        
    </style>
</head>
<body>
<div class="row">
    <header class="d-flex justify-content-between align-items-center">
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
</div>

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

<div class="row d-flex">
    <section class="prod">
        <h2>Sản phẩm</h2>
        <div class="product-container">
            <div class="text-center">
                <img src="./img/trasuakemphomai.png" alt="Trà Sữa" class="img-fluid" style="width: 200px; height: 200px;">
                <h3>Trà Sữa</h3>
                <a href="trasua.php" class="btn btn-outline-primary">Xem Ngay</a>
            </div>
            <div class="text-center">
                <img src="./img/hongtrachach.png" alt="Trà Trái cây" class="img-fluid" style="width: 200px; height: 200px;">
                <h3>Trà Trái cây</h3>
                <a href="tratraicay.php" class="btn btn-outline-primary">Xem Ngay</a>
            </div>
            <div class="text-center">
                <img src="./img/trasuakemduanuong.png" class="img-fluid" style="width: 200px; height: 200px;">
                <h3>Trà Sữa Kem</h3>
                <a href="trasuakem.php" class="btn btn-outline-primary">Xem Ngay</a>
            </div>
            <div class="text-center">
                <img src="./img/cafedenda.png" class="img-fluid" style="width: 200px; height: 200px;">
                <h3>Cafe</h3>
                <a href="cafe.php" class="btn btn-outline-primary">Xem Ngay</a>
            </div>
        </div>
    </section>
    <aside class="welcome"> 
        <h2>MilkTeaShop</h2>
        <p>Milk Tea Shop – Thiên đường dành cho những tín đồ yêu thích  <a class="btn btn-primary" href="gioithieu.php">Xem Thêm</a></p>
    </aside>
</div>

<div class="row">
    <article>
        <h2>Sản phẩm trà sữa nổi bật</h2>
        <div class="d-flex justify-content-center flex-wrap">
            <div class="product-item">
                <img src="img/TraSuaVietQuat.png" class="img-fluid" style="width: 300px; height: 300px;">
                <h3>Trà Sữa Việt Quất</h3>
                <a href="trasuavietquat.php" class="btn btn-outline-primary">Xem chi tiết</a>
            </div>
            <div class="product-item">
                <img src="img/trasuaSocola.png" class="img-fluid" style="width: 300px; height: 300px;">
                <h3>Trà Sữa Sôcôla</h3>
                <a href="trasuasocola.php" class="btn btn-outline-primary">Xem chi tiết</a>
            </div>
            <div class="product-item">
                <img src="img/TraSuaXoai.png" alt="Trà Sữa Xoài" class="img-fluid" style="width: 300px; height: 300px;">
                <h3>Trà Sữa Xoài</h3>
                <a href="trasuaxoai.php" class="btn btn-outline-primary">Xem chi tiết</a>
            </div>
        </div>
    </article>
</div>

<div class="row">
    <h3>Bản Đồ Cửa Hàng</h3>
    <iframe class="w-100" style="height: 300px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5126489776944!2d106.62917361589957!3d10.76262246024939!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e0f3c7d9b3%3A0x3b1a0b7e9f6f67f1!2zMTIzIEPDoG5nIEFCQywgUXXhuqFpIFZpbmgsIFZJQVRNQU5H!5e0!3m2!1svi!2s!4v1614072628631!5m2!1svi!2s" allowfullscreen></iframe>
</div>



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