<?php
session_start();
define("HOST", "localhost");
define("DATABASE", "chuyenn");
define("USERNAME", "root");
define("PASSWORD", "");

function connectDatabase() {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function fetchProduct($conn, $productId) {
    $query = $conn->prepare("SELECT * FROM sanpham WHERE idsanpham = ?");
    $query->bind_param("i", $productId);
    $query->execute();
    return $query->get_result()->fetch_assoc();
}

function fetchTopping($conn, $toppingId) {
    $query = $conn->prepare("SELECT * FROM topping WHERE idtopping = ?");
    $query->bind_param("i", $toppingId);
    $query->execute();
    return $query->get_result()->fetch_assoc();
}

function fetchSize($conn, $sizeId) {
    $query = $conn->prepare("SELECT * FROM kichco WHERE idkc = ?");
    $query->bind_param("i", $sizeId);
    $query->execute();
    return $query->get_result()->fetch_assoc();
}

function fetchPromotion($conn, $promoId) {
    $query = $conn->prepare("SELECT * FROM khuyenmai WHERE idkm = ?");
    $query->bind_param("i", $promoId);
    $query->execute();
    return $query->get_result()->fetch_assoc();
}

$conn = connectDatabase();

if (!isset($_SESSION['idnguoidung'])) {
    header("Location: dangki.php");
    exit();
}

$totalAmount = 0;
$cartItems = [];

// Initialize variables for form retention
$recipientName = '';
$address = '';
$phone = '';
$promoID = '';

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $product = fetchProduct($conn, $cartItem['product_id']);
        $toppings = []; // Initialize an array to hold toppings
        if (isset($cartItem['topping_ids'])) {
            foreach ($cartItem['topping_ids'] as $toppingId) {
                $topping = fetchTopping($conn, $toppingId);
                if ($topping) {
                    $toppings[] = $topping; // Store valid toppings
                }
            }
        }
        $size = fetchSize($conn, $cartItem['size_id']);

        if ($product && $size) {
            $basePrice = $product['gia'] + ($size['gia'] ?? 0);
            foreach ($toppings as $topping) {
                $basePrice += $topping['gia']; // Add topping price
            }
            $totalItemPrice = $basePrice * $cartItem['quantity'];
            $totalAmount += $totalItemPrice;

            $cartItems[] = [
                'product' => $product,
                'toppings' => $toppings, // Store all toppings
                'size' => $size,
                'quantity' => $cartItem['quantity'],
                'totalPrice' => $totalItemPrice,
            ];
        }
    }
}

$discountAmount = 0;
$finalAmount = $totalAmount; // Initialize final amount

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['idnguoidung'];
    $paymentMethod = trim($_POST['payment_method'] ?? 'Tiền mặt');
    
    // Retain form data
    $recipientName = trim($_POST['recipient_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $promoID = trim($_POST['promo_id'] ?? '');

    // Validate promotion ID
    if (!empty($promoID)) {
        $promo = fetchPromotion($conn, $promoID);
        if ($promo) {
            $currentDate = date('Y-m-d');
            // Check if promotion is valid
            if (isset($promo['ngaybd']) && isset($promo['ngaykt'])) {
                // Ensure the promotion date is valid
                if ($currentDate >= $promo['ngaybd'] && $currentDate <= $promo['ngaykt']) {
                    $discountAmount = ($promo['phan_tram_giam'] / 100) * $totalAmount;
                    $finalAmount = $totalAmount - $discountAmount; // Update final amount
                } else if($currentDate < $promo['ngaybd']) {
                    echo "<script>alert('Mã khuyến mãi chưa bắt đầu.');</script>";
                } else{
                    echo "<script>alert('Mã khuyến mãi đã hết hạn.');</script>";
                }
            } else  {
                echo "<script>alert('Thông tin mã khuyến mãi không đầy đủ.');</script>";
            }
        } else {
            echo "<script>alert('Mã khuyến mãi không hợp lệ.');</script>";
        }}
    
    
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sbm'])) {
    $userId = $_SESSION['idnguoidung'];
    $paymentMethod = $_POST['payment_method'] ?? 'Tiền mặt';
    error_log("Phương thức thanh toán: " . $paymentMethod);
    
    $stmt = $conn->prepare("INSERT INTO donhang (idnguoidung, idkm, thanhtien, phuongthuc, trangthai, ngaytao) VALUES (?, ?, ?, ?, ?, ?)");

    $orderStatus = 'Đang chờ xử lý';
    $currentDate = date('Y-m-d');

    // Handle potential null for promo
    $promoId = isset($promo) ? $promo['idkm'] : null;
    
    // Bind parameters: userId (int), promoId (int or null), finalAmount (float), paymentMethod (string), orderStatus (string), currentDate (string)
    $stmt->bind_param("idsiss", $userId, $promoId, $finalAmount, $paymentMethod, $orderStatus, $currentDate);

    // Execute and check for errors
    if ($stmt->execute()) {
        $orderId = $stmt->insert_id; // Lấy ID của đơn hàng vừa tạo
        foreach ($cartItems as $item) {
            // Lặp qua từng topping
            foreach ($item['toppings'] as $topping) {
                $stmtDetail = $conn->prepare("INSERT INTO chitiecdonhang (iddonhang, idsanpham, idtopping, idkc, soluong) VALUES (?, ?, ?, ?, ?)");
                
                // Lấy ID topping từ từng topping
                $toppingId = $topping['idtopping'];
                
                // Ràng buộc tham số
                // Đảm bảo rằng bạn đã xác định đúng số lượng tham số và kiểu dữ liệu
                $stmtDetail->bind_param("iiisi", $orderId, $item['product']['idsanpham'], $toppingId, $item['size']['idkc'], $item['quantity']);
                
                // Thực hiện chèn chi tiết đơn hàng
                if (!$stmtDetail->execute()) {
                    error_log("Detail insertion error: " . $stmtDetail->error);
                }
                $stmtDetail->close();
            }
        }
    
        clearCart();
        echo "<script>alert('Đặt hàng thành công!'); window.location.href='index.php';</script>";
    } else {
        error_log("Order insertion error: " . $stmt->error);
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại sau.');</script>";
    }
}

$conn->close();

function clearCart() {
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
        error_log("Giỏ hàng đã được xóa thành công.");
    } else {
        error_log("Giỏ hàng không tồn tại hoặc đã bị xóa trước đó.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILK_TEA Store 2003</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .checkout-summary, .delivery-info {
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<header class="d-flex justify-content-between align-items-center p-3">
    <div class="d-flex">
        <h4 class="me-2">MILK_TEA Store</h4>
        <img src="img/logo.png" width="70" alt="Logo">
    </div>
    <div class="d-flex">
        <form class="d-flex">
            <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search">
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
    <form method="POST" action="">
        <div class="row">
        <div class="col-md-6">
    <div class="delivery-info">
        <h5>Thông tin giao hàng</h5>
        
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" required><?php echo htmlspecialchars($address); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required pattern="[0-9]{10}">
        </div>
        <div class="mb-3">
            <label for="promo_id" class="form-label">Nhập mã khuyến mãi</label>
            <input type="text" class="form-control" id="promo_id" name="promo_id" value="<?php echo htmlspecialchars($promoID); ?>">
            <button class="btn btn-outline-success mt-2" type="submit">Áp Dụng</button>
        </div>
        <div class="mb-3">
        
        <div for="payment_method" class="body-title mb-10">Thanh toán <span class="tf-color-1">*</span></div>
        
            <select  name="payment_method" required>
               
                <option value="Tiền mặt">Tiền mặt</option>
                <option value="Momo">Momo</option>
                <option value="Momo">Ngân hàng</option>
            </select>
       
        </div>
    </div>
</div>
            <div class="col-md-6">
                <div class="checkout-summary">
                    <h5>Thông tin đơn hàng</h5>
                    <?php foreach ($cartItems as $item): ?>
                    <div class="product-card card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="img/<?php echo htmlspecialchars($item['product']['hinh']); ?>" alt="<?php echo htmlspecialchars($item['product']['tensp']); ?>" class="img-fluid">
                                </div>
                                <div class="col-8">
                                    <h6 class="card-title"><?php echo htmlspecialchars($item['product']['tensp']); ?></h6>
                                    <h6 class="card-text">Topping: 
                                        <?php 
                                            if (!empty($item['toppings'])) {
                                                echo implode(', ', array_map(function($topping) {
                                                    return htmlspecialchars($topping['tentopping']);
                                                }, $item['toppings']));
                                            } else {
                                                echo 'Không có topping';
                                            }
                                        ?>
                                    </h6>
                                    <p class="card-text">Kích cỡ: <?php echo htmlspecialchars($item['size']['tenkc']); ?></p>
                                    <p class="card-text">Giá: <?php echo number_format($item['totalPrice'], 0, ',', '.'); ?> VNĐ x <?php echo (int)$item['quantity']; ?> = <?php echo number_format($item['totalPrice'], 0, ',', '.'); ?> VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="total">
                        <strong>Tổng : <?php echo number_format($totalAmount, 0, ',', '.'); ?> VNĐ</strong>
                    </div>
                    <div class="total">
                        <strong>Khuyến mãi : <?php echo number_format($discountAmount, 0, ',', '.'); ?> VNĐ</strong>
                    </div>
                    <div class="total">
                        <strong>Tổng cộng : <?php echo number_format($finalAmount, 0, ',', '.'); ?> VNĐ</strong>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button name="sbm" type="submit" class="btn btn-primary">Đặt hàng</button>
        </div>
    </form>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-success">Hotline</h2>
                <p>📞 0354219578</p>
                <p>📍 Địa chỉ: 123 Đường Pạm Thị Tánh, Phường 4, Quận 8, TP. Hồ Chí Minh</p>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>