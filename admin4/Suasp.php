<?php

require 'config.php';
session_start();
if (isset($_POST['sbm'])) {

    move_uploaded_file($_FILES['Hinh']['tmp_name'] , 'images/img/'.$_FILES['Hinh']['name']);
    $Idsanpham = $_POST['Idsanpham'];
    $tensp = $_POST['tensp'];
    $Hinh = $_FILES['Hinh']['name'];
    $iddanhmuc = $_POST['iddanhmuc'];
    $gia = $_POST['gia'];
   
    $mota = $_POST['mota'];
    $Hinhanh =  $_POST['Hinhanh'];
    
    if($hinh == null)
    {
        $sql = "UPDATE sanpham SET tensp='$tensp',gia='$gia', hinh='$Hinh', iddanhmuc= '$iddanhmuc'
        , mota='$mota'
        WHERE idsanpham= '$Idsanpham ' " ;
        if ($connect->query($sql) === TRUE) {
            header('Location: Sanpham.php');
        } else {
            echo "Error updating record: " . $connect->error;
        }
        $connect->close();
    }
    else{
        $sql = "UPDATE sanpham SET tensp='$tensp',gia='$gia', hinh='$Hinh', iddanhmuc= '$iddanhmuc'
        , mota='$mota'
        WHERE idsanpham= '$Idsanpham ' " ;
        if ($connect->query($sql) === TRUE) {
            header('Location: Sanpham.php');
        } else {
            echo "Error updating record: " . $connect->error;
        }
        $connect->close();
    }
}


?><?Php $idsanpham = $_GET["idsanpham"];

$query="select s.idsanpham,s.tensp,s.gia,s.hinh,s.mota,dm.tendanhmuc as tendm ,s.iddanhmuc   from sanpham s left join danhmuc dm on s.iddanhmuc=dm.iddm
 WHERE  s.idsanpham =".$idsanpham;
$result = $connect->query($query);
$row = $result->fetch_assoc();
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
                                <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt="" src="images/logo/logo.png"
                                        data-light="images/logo/logo.png" data-dark="images/logo/logo.png"
                                        data-width="154px" data-height="52px" data-retina="images/logo/logo.png">
                                </a>
                              


                               

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

                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Sửa sản phẩm</h3>
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
                                            <a href="all-product.html">
                                                <div class="text-tiny">Sản phẩm</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Sửa sản phẩm</div>
                                        </li>   
                                    </ul>
                                </div>
                                <!-- form-add-product -->
                                <form class="" method="POST" enctype="multipart/form-data"
                                    action="">
                                    
                                    <div class="wg-box">
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Tên sản phẩm <span class="tf-color-1">*</span>
                                            </div>
                                            <input class="mb-10" type="text" placeholder="Nhập tên sản phẩm"
                                                name="tensp" tabindex="0" value="<?php echo $row["tensp"] ?>" aria-required="true" required="">
                                            <div class="text-tiny">Không vượt quá 100 ký tự khi nhập
                                            tên sản phẩm.</div>
                                        </fieldset>

                                       

                                        <div class="gap22 cols">
                                            <fieldset class="category">
                                                <div class="body-title mb-10">Danh Mục <span class="tf-color-1">*</span>
                                                </div>
                                                <div class="select">
                                                    <select class="" name="iddanhmuc">
                                                    <option selected="selected" value="<?php echo $row["iddanhmuc"] ?>"><?php echo $row["tendm"] ?></option>
                                                    <?php echo $row['Tennhasx']; ?>
                                                    </option>
                                                    <?php 
                                                    $sql = "SELECT iddm , tendanhmuc FROM danhmuc WHERE iddm != " . intval($row['iddanhmuc']);
                                                    $result = $connect->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($rows = $result->fetch_assoc()) {?>
                                                            <option value="<?php echo $rows["iddm"] ?>"><?php echo $rows["tendanhmuc"] ?></option>";
                                                    <?php    }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </fieldset>
                                            
                                        </div>
                                        <div class="cols gap22">
                                            <fieldset class="name">
                                                <div class="body-title mb-10">Giá <span
                                                        class="tf-color-1">*</span></div>
                                                <input class="mb-10" type="text" placeholder="Nhập giá thông thường"
                                                    name="gia" tabindex="0" value="<?php echo $row["gia"] ?>" aria-required="true"
                                                    required="">
                                            </fieldset>
                                           
                                        </div>
                                        <fieldset>
                                            <div class="body-title">Tải lên hình ảnh <span class="tf-color-1">*</span>
                                            </div>
                                            <div class="form-group">
                      
                                            
                      
                      <div class="col-sm-10">
                        <input type="file" class="form-control" name="Hinh" value="<?php echo $row["hinh"] ?>">
                      </div>
                      </div>
                      <div class="form-group">
                      <div class="body-title">Hình ảnh 
                        <div class="col-sm-10">
                      <img src="images/img/<?php echo $row["hinh"]?>" style="width:300px;height:300px">
                        </div>
                      </div>
                      <input type="hidden" class="form-control" name="Hinhanh" value="<?php echo $row["hinh"] ?>">
                      <input type="hidden" class="form-control" name="Idsanpham" value="<?php echo $row["idsanpham"] ?>">
                    </div>
                                        </fieldset>
                                        <div class="cols gap22">
                                            <fieldset class="name">
                                                <div class="body-title mb-10">Mô tả <span
                                                        class="tf-color-1">*</span></div>
                                                        <input type="text" name="mota" value="<?php echo $row['mota']; ?>" required>
                                            </fieldset>
                                           
                                        </div>   
                                       

                                        
                                             <div class="cols gap10">
                                            <button name="sbm" class="tf-button w-full" type="submit">Lưu</button>
                                        </div>
                                        
                                    </div>
                                   
                                </form>
                                <!-- /form-add-product -->
                            </div>
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->

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