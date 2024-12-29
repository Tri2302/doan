<?php
require 'config.php';
session_start();

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnguoidung=$_SESSION['idnguoidung'];
    $Tennd = $_POST['Tennd'] ;
    $Sodienthoai = $_POST['Sodienthoai'] ;
    $Email = $_POST['Email'] ;
    $Matkhau = $_POST['Matkhau'] ;
    $matkhaumoi = $_POST['matkhaumoi'] ;
    $Nhaplaimatkhaumoi = $_POST['Nhaplaimatkhaumoi'] ;
    

        $sql = "UPDATE nguoidung SET tennd = '$Tennd', email ='$Email' , sodienthoai ='$Sodienthoai'  
        WHERE idnguoidung=  '$idnguoidung' " ;
        $connect->query($sql);
        // Handle password update
    
            // Fetch current password
            $sql1 = "select * from nguoidung WHERE email='$Email' and matkhau = '$Matkhau'" ;
            $result = $connect->query($sql1);
            $c=$result->num_rows;
        if ( $c > 0){
            
                if ($matkhaumoi === $Nhaplaimatkhaumoi) {
                    
                    $sql2 = "UPDATE nguoidung SET matkhau='$matkhaumoi'  
                    WHERE idnguoidung=  '$idnguoidung' " ;
                    $connect->query($sql2);
                    $error_message = "Cập nhật thành công!";
                } else {
                    $error_message = "Mật khẩu mới không khớp.";
                }
            
        }
        else {
            $error_message=" mat khau khong hop le";
        }
}
?>
<?Php $idnguoidung = $_SESSION['idnguoidung'];

$query="select * from nguoidung
 WHERE  idnguoidung =".$idnguoidung;
$result = $connect->query($query);
$row = $result->fetch_assoc();
?>
<!DOCTYPE php>
<php xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

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
                                <a href="index-2.php">
                                    <img class="" id="logo_header_mobile" alt="" src="images/logo/logo.png"
                                        data-light="images/logo/logo.png" data-dark="images/logo/logo.png"
                                        data-width="154px" data-height="52px" data-retina="images/logo/logo.png">
                                </a>
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

                        <style>
                            .text-danger {
                                font-size: initial;
                                line-height: 36px;
                            }

                            .alert {
                                font-size: initial;
                            }
                        </style>

                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Cài đặt</h3>
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
                                            <div class="text-tiny">Cài đặt</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="col-lg-12">
                                        <div class="page-content my-account__edit">
                                            <div class="my-account__edit-form">
                                                <form name="account_edit_form" action="#" method="POST"
                                                    class="form-new-product form-style-1 needs-validation"
                                                    novalidate="">

                                                    <fieldset class="name">
                                                        <div class="body-title">Họ và tên <span class="tf-color-1">*</span>
                                                        </div>
                                                        <input class="flex-grow" type="text" placeholder="Nhập họ và tên"
                                                            name="Tennd" tabindex="0" value="<?php echo  $row['tennd'] ?>" aria-required="true"
                                                            required="">
                                                    </fieldset>

                                                    <fieldset class="name">
                                                        <div class="body-title">Số điện thoại <span
                                                                class="tf-color-1">*</span></div>
                                                                <input class="flex-grow" type="text" placeholder="Số điện thoại"
                                                                name="Sodienthoai" tabindex="0" value="<?php echo $row['sodienthoai']  ?>" aria-required="true" required>
                                                    </fieldset>

                                                    <fieldset class="name">
                                                        <div class="body-title">Email  <span
                                                                class="tf-color-1">*</span></div>
                                                        <input class="flex-grow" type="text" placeholder="Email "
                                                            name="Email" tabindex="0" value="<?php echo  $row['email'] ?>" aria-required="true"
                                                            required="">
                                                    </fieldset>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="my-3">
                                                                <h5 class="text-uppercase mb-0">Thay đổi mật khẩu</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <fieldset class="name">
                                                                <div class="body-title pb-3">Mật khẩu cũ <span
                                                                        class="tf-color-1">*</span>
                                                                </div>
                                                                <input class="flex-grow" type="password"
                                                                    placeholder="Mật khẩu cũ" id="old_password"
                                                                    name="Matkhau" aria-required="true"
                                                                    required="">
                                                            </fieldset>

                                                        </div>
                                                        <div class="col-md-12">
                                                            <fieldset class="name">
                                                                <div class="body-title pb-3">Mật khẩu mới <span class="tf-color-1">*</span></div>
                                                                <input class="flex-grow" type="password" placeholder="Mật khẩu mới" id="new_password" name="matkhaumoi" aria-required="true" required="">
                                                              
                                                         </fieldset>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <fieldset class="name">
                                                                <div class="body-title pb-3">Nhập lại mật khẩu mới <span class="tf-color-1">*</span></div>
                                                                <input class="flex-grow" type="password" placeholder="Nhập lại mật khẩu mới" name="Nhaplaimatkhaumoi" aria-required="true" required="">
                                                                
                                                            </fieldset>
                                                            
                                                        </div><p style="color:red"><?php echo  $error_message ?></p>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="my-3">
                                                                <button type="submit"
                                                                    class="btn btn-primary tf-button w208">Lưu thay đổi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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

</php>