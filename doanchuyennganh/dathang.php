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

function clearCart() {
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
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
        $product = getProduct($conn, $cartItem['product_id']);
        $size = getSize($conn, $cartItem['size_id']);
        
        if ($product && $size) {
            $itemPrice = ($product['gia'] + $size['gia']) * $cartItem['quantity'];
            $totalAmount += $itemPrice;
            $cartItems[] = [
                'product' => $product,
                'size' => $size,
                'quantity' => $cartItem['quantity'],
                'totalPrice' => $itemPrice,
            ];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['idnguoidung'];
    $stmt = $conn->prepare("INSERT INTO donhang (idnguoidung, thanhtien, phuongthuc, trangthai, ngaytao) VALUES (?, ?, ?, ?, ?)");
    $orderStatus = 'Đang chờ xử lý';
    $currentDate = date('Y-m-d H:i:s');

    $stmt->bind_param("idsis", $userId, $totalAmount, 'Tiền mặt', $orderStatus, $currentDate);
    if ($stmt->execute()) {
        $orderId = $stmt->insert_id;

        // Insert order details
        foreach ($cartItems as $item) {
            $stmtDetail = $conn->prepare("INSERT INTO chitietdonhang (iddonhang, idsanpham, soluong, gia) VALUES (?, ?, ?, ?)");
            $stmtDetail->bind_param("iiid", $orderId, $item['product']['idsanpham'], $item['quantity'], $item['product']['gia']);
            $stmtDetail->execute();
        }
        clearCart();
        header("Location: thanhtoan.php?success=true");
        exit();
    }
}

$conn->close();

function getProduct($conn, $productId) {
    $query = $conn->prepare("SELECT * FROM sanpham WHERE idsanpham = ?");
    $query->bind_param("i", $productId);
    $query->execute();
    return $query->get_result()->fetch_assoc();
}

function getSize($conn, $sizeId) {
    $query = $conn->prepare("SELECT * FROM kichco WHERE idkc = ?");
    $query->bind_param("i", $sizeId);
    $query->execute();
    return $query->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILK_TEA Store 2003</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="d-flex justify-content-between align-items-center p-3">
        <h4 class="me-2">MILK_TEA Store</h4>
        <img src="img/logo.png" width="70" alt="Logo">
    </header>

    <div class="container mt-5">
        <h1>Đặt hàng thành công</h1>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            <div class='alert alert-success'>Đặt hàng thành công!</div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">Quay lại trang chính</a>
    </div>

    <footer>
        <div class="text-center mt-4">
            <p>&copy; 2023 Milk Tea Store. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>