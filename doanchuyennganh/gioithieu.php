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
    <link rel="stylesheet" href="t.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
<div class="row">
    <header class="d-flex justify-content-between align-items-center">
        <div class="d-flex">
            <h4 class="me-2">MILK_TEA Store</h4>
            <img src="img/logo.png" width="70" alt="">
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

<div class="row">
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
</div>

<div class="row">
    <div class="container mt-4">
        <article>
            <h2> Milk Tea Shop</h2>
            <p>Milk Tea Shop – Thiên đường dành cho những tín đồ yêu thích trà sữa, nơi bạn có thể tìm thấy những ly trà sữa tươi ngon và hấp dẫn nhất. Chúng tôi cam kết sử dụng nguyên liệu tự nhiên, đảm bảo sức khỏe và chất lượng cho từng sản phẩm. Bạn sẽ được trải nghiệm đa dạng các loại trà sữa, từ những hương vị truyền thống như trà sữa truyền thống và hồng trà sữa, đến những sáng tạo mới lạ như trà sữa kem.</p>
            
            <h2>Không Gian Thư Giãn</h2>
            <p>Milk Tea Shop không chỉ là nơi thưởng thức trà sữa mà còn là không gian lý tưởng để bạn gặp gỡ bạn bè và thư giãn sau những giờ làm việc căng thẳng. Với thiết kế hiện đại, ấm cúng và phong cách phục vụ tận tình, chúng tôi hy vọng sẽ mang đến cho bạn những giây phút thư giãn thoải mái nhất.</p>
            
            <h2>Khuyến Mãi Hấp Dẫn</h2>
            <p>Đừng bỏ lỡ các chương trình khuyến mãi đặc biệt diễn ra hàng tuần tại Milk Tea Shop! Hãy theo dõi fanpage của chúng tôi để cập nhật thông tin mới nhất và nhận những ưu đãi hấp dẫn.</p>
        </article>
        <section class="mt-4 d-flex align-items-center">
            <div class="flex-fill me-3">
                <h2>Chuyện của Trà</h2>
                <p>Từ những búp trà non được hái trực tiếp từ vùng trà cao hơn 1000m, những nghệ nhân KATINAT bắt đầu hành trình chinh phục phong vị mới đầy thú vị và độc đáo.</p>
                <p><strong>TRÀ SỮA</strong> – Dòng sản phẩm chủ chốt tạo nên tiếng vang của thương hiệu, mang làn gió thoảng hương thơm thanh tao mà đậm đà của các loại trà hái từ đồi cao.</p>
                <p><strong>TRÀ TRÁI CÂY</strong> – Sảng khoái với hương thơm của trà và sự tươi mát của những loại trái cây, Trà Trái Cây mang đến sự biến tấu mới lạ, làm mỗi ngụm trà trở nên thú vị.</p>
            </div>
            <img src="https://vitas.org.vn/wp-content/uploads/2021/08/trong-cay-tra-xanh.jpg" alt="Trà" style="max-width: 400px;">
        </section>

        <section class="mt-4 d-flex align-items-center flex-row-reverse">
            <div class="flex-fill ms-3">
                <h2>Chuyện của Cà Phê</h2>
                <p>Dưới bàn tay của nghệ nhân tại KATINAT, từng cốc cà phê trở thành một cuộc phiêu lưu hương vị đầy mới lạ.</p>
                <p><strong>CÀ PHÊ ESPRESSO</strong> – Một ngụm cà phê rang xay chát nhẹ với hậu vị ngọt êm, cân bằng, luôn là trải nghiệm đáng thử với những ai là tín đồ của thức uống này.</p>
                <p><strong>CÀ PHÊ PHIN MÊ</strong> – Bộ sưu tập Cà Phê Phin với công thức độc quyền từ KATINAT, làm bật nên vị đậm đặc trưng của Robusta Buôn Mê Thuột.</p>
            </div>
            <img src="http://caphenguyenchat.vn/wp-content/uploads/2013/10/Ca-Phe.jpeg" alt="Cà Phê" style="max-width: 400px;">
        </section>

        <div class="container ">
            <h2>Bản Đồ Cửa Hàng</h2>
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
    </div>
</body>
</html>