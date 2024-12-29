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

function fetchPromotion($conn, $promoName) {
    $query = $conn->prepare("SELECT * FROM khuyenmai WHERE tenkm = ? AND ngaybd <= CURDATE() AND ngaykt >= CURDATE()");
    $query->bind_param("s", $promoName);
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

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $product = fetchProduct($conn, $cartItem['product_id']);
        $topping = isset($cartItem['topping_id']) ? fetchTopping($conn, $cartItem['topping_id']) : null;
        $size = fetchSize($conn, $cartItem['size_id']);

        if ($product && $size) {
            $basePrice = $product['gia'] + ($topping ? $topping['gia'] : 0) + $size['gia'];
            $totalItemPrice = $basePrice * $cartItem['quantity'];
            $totalAmount += $totalItemPrice;

            $cartItems[] = [
                'product' => $product,
                'toppings' => $topping,
                'size' => $size,
                'quantity' => $cartItem['quantity'],
                'totalPrice' => $totalItemPrice,
            ];
        }
    }
}

$discountAmount = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['idnguoidung'];
    $paymentMethod = 'Cash';
    $promoName = trim($_POST['promo_name'] ?? '');

    // Validate promotion name
    if (!empty($promoName)) {
        $promo = fetchPromotion($conn, $promoName);
        if ($promo) {
            $discountAmount = ($promo['phan_tram_giam'] / 100) * $totalAmount;
            $totalAmount -= $discountAmount; // Update total amount after discount
        } else {
            echo "<script>alert('Tên khuyến mãi không hợp lệ.');</script>";
        }
    }

    // Prepare to insert order
    $stmt = $conn->prepare("INSERT INTO donhang (idnguoidung, idkm, thanhtien, phuongthuc, trangthai, ngaytao) VALUES (?, ?, ?, ?, ?, ?)");
    $orderStatus = 'Đang chờ xử lý';
    $currentDate = date('Y-m-d');

    // Handle potential null for promo
    $promoId = $promo ? $promo['idkm'] : null;
    $stmt->bind_param("idsiss", $userId, $promoId, $totalAmount, $paymentMethod, $orderStatus, $currentDate);

    // Execute and check for errors
    if ($stmt->execute()) {
        $orderId = $conn->insert_id;
        echo "<script>alert('Đặt hàng thành công! Mã đơn hàng: $orderId'); window.location.href='index.php';</script>";
    } else {
        error_log("Order insertion error: " . $stmt->error);
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại sau.');</script>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="t.css">
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
                        <label for="recipient_name" class="form-label">Tên người dùng</label>
                        <input type="text" class="form-control" id="recipient_name" name="recipient_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}">
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
                                    <h6 class="card-title"><?php echo $item['toppings'] ? htmlspecialchars($item['toppings']['tentopping']) : 'Không có topping'; ?></h6>
                                    <p class="card-text">Kích cỡ: <?php echo htmlspecialchars($item['size']['tenkc']); ?></p>
                                    <p class="card-text">Giá: <?php echo number_format($item['totalPrice'], 0, ',', '.'); ?> VNĐ x <?php echo (int)$item['quantity']; ?> = <?php echo number_format($item['totalPrice'], 0, ',', '.'); ?> VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="mb-3">
                        <label for="promo_name" class="form-label">Nhập tên khuyến mãi</label>
                        <input type="text" class="form-control" id="promo_name" name="promo_name">
                    </div>
                   
                    <div class="total">
                        <strong>Tổng : <?php echo number_format($totalAmount + $discountAmount, 0, ',', '.'); ?> VNĐ</strong>
                    </div>
                    <div class="total">
                        <strong>Phí vận chuyển : 0 VNĐ</strong>
                    </div> 
                    <div class="total">
                        <strong>Khuyến mãi : <?php echo number_format($discountAmount, 0, ',', '.'); ?> VNĐ</strong>
                    </div>
                    <div class="total">
                        <strong>Tổng cộng : <?php echo number_format($totalAmount, 0, ',', '.'); ?> VNĐ</strong>
                    </div> 
                </div>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Đặt hàng</button>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>