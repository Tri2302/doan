<?php
require 'config.php';
session_start();
$tukhoa = isset($_GET['tukhoa']) ? $_GET['tukhoa'] : '';

// Chuẩn bị truy vấn
$sql="select *,tennd from donhang d left join nguoidung nd on d.idnguoidung=nd.idnguoidung";

// Nếu có từ khóa tìm kiếm, thêm điều kiện vào truy vấn
if (!empty($tukhoa)) {
    $tukhoa = $connect->real_escape_string($tukhoa); // Bảo vệ khỏi SQL injection
    $sql .= " WHERE iddonhang LIKE '%$tukhoa%' or  tennd like '%$tukhoa%' ";
}

$result = $connect->query($sql);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>Milk Tea Shop</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/animation.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="font/fonts.css">
    <link rel="stylesheet" href="icon/style.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <!-- <div id="preload" class="preload-container">
    <div class="preloading">
        <span></span>
    </div>
</div> -->
<div class="section-menu-left">
                    <div class="box-logo">
                        <a href="index.php" id="site-logo-inner">
                            <img class="" id="logo_header" alt="images/logo/logo.png" src="images/logo/logo.png"
                                data-light="images/logo/logo.png" data-dark="images/logo/logo.png"width="80" height="30">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Trang chủ chính</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="index.php" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Bảng điều khiển</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Sản phẩm</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="Themsp.php" class="">
                                                <div class="text">Thêm sản phẩm</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="Sanpham.php" class="">
                                                <div class="text">Sản phẩm</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                              
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Danh mục</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="ThemDM.php" class="">
                                                <div class="text">Danh mục mới</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="Danhmuc.php" class="">
                                                <div class="text">Danh mục</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">Đơn hàng</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="Donhang.php" class="">
                                                <div class="text">Đơn hàng</div>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </li>
                               
                                <li class="menu-item">
                                    <a href="Khuyenmai.php" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Khuyến Mãi</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="Nguoidung.php" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">Người dùng</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="Caidat.php" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Cài đặt</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                              
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>


                                

                            </div>
                            <div class="header-grid">

                                




                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    <img src="images/avatar/user-1.png" alt="">
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2"><?php echo $_SESSION['tennd'] ; ?></span>
                                                    <span class="text-tiny">Admin</span>
                                                </span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton3">
                                           <li>
                                                <a href="Caidat.php" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="body-title-2">Tài Khoản</div>
                                                </a>
                                            </li>
                                            
                                            
                                           
                                            <li>
                                                <a href="Dangnhap.php" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-log-out"></i>
                                                    </div>
                                                    <div class="body-title-2">Đăng xuất</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">

                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Tất cả khuyến mãi</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.php">
                                                <div class="text-tiny">Bảng điều khiển</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Tất cả khuyến mãi</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" value="<?php echo $tukhoa ?>" placeholder="Tìm kiếm mã đơn hàng..." class="" name="tukhoa"
                                                        tabindex="2" value="" name="timkiem" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button   class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="ThemKM.php"><i
                                                class="icon-plus"></i>Thêm khuyến mãi</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                            <thead>
                                                    <tr>
                                                        <th >Mã đơn hàng</th>
                                                        <th  >Tên người đặt hàng</th>
                                                        <th >Mã khuyến mãi</th>
                                                        <th >Thành tiền</th>
                                                        <th >Phương thức</th>
                                                        <th >Trạng thái</th>
                                                        <th >Ngày tạo</th>
                                                        <th>Tác vụ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                
                                                  if ($result->num_rows > 0) {
                                                  
                                                  while ($row = $result->fetch_assoc()) {
                                                ?>
                                                    <tr>
                                                        <td ><?php echo $row['iddonhang'] ?></td>
                                                        <td ><?php echo $row['tennd'] ?></td>
                                                        <td ><?php echo $row['idkm'] ?></td>
                                                        <td ><?php echo $row['thanhtien'] ?>VNĐ</td>
                                                        <td ><?php echo $row['phuongthuc'] ?></td>
                                                        <td ><?php echo $row['trangthai'] ?></td>

                                                        <td ><?php echo $row['ngaytao'] ?></td>
                                                        
                                                        
                                                        <td class="text-center">
                                                            <a href="Chitiecdonhang.php?iddonhang=<?php echo $row["iddonhang"] ?>">
                                                                <div class="list-icon-function view-icon">
                                                                    <div class="item eye">
                                                                        <i class="icon-eye"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php }}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 Milk Tea Shop</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>   
    <script src="js/apexcharts/apexcharts.js"></script>
    <script src="js/main.js"></script>
</body>

</html>