<?php

session_start();

define("HOST", "localhost");

define("DATABASE", "chuyenn");

define("USERNAME", "root");

define("PASSWORD", "");

try {

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {

throw new Exception("Error: " . $conn->connect_error);

}

} catch (Exception $e) {

die($e->getMessage());

}

if (!isset($_SESSION['idnguoidung'])) {

header("Location: dangki.php");

exit();

}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$sql = "SELECT * FROM sanpham";

$products = [];

$result = $conn->query($sql);

if ($result) {

while ($row = $result->fetch_assoc()) {

$products[$row['idsanpham']] = $row;

}

}

$sqlT = "SELECT * FROM topping";

$toppings = [];

$rt = $conn->query($sqlT);

if ($rt) {

while ($row = $rt->fetch_assoc()) {

$toppings[$row['idtopping']] = $row;

}

}

$sqlS = "SELECT * FROM kichco";

$sizes = [];

$rs = $conn->query($sqlS);

if ($rs) {

while ($row = $rs->fetch_assoc()) {

$sizes[$row['idkc']] = $row;

}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'] ?? null;
    $topping_id = $_POST['topping_ids'] ?? [];
    $size_id = $_POST['kc'] ?? null;
    $quantity = max(1, (int)($_POST['quantity'] ?? 1)); // Số lượng mặc định là 1

    if ($product_id) {
        if (!is_array($topping_id)) {
            $topping_id = [];
        }

        $key = $product_id . '-' . $size_id . '-' . implode('-', $topping_id);

        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        if (!isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key] = [
                'product_id' => $product_id,
                'size_id' => $size_id,
                'topping_ids' => $topping_id,
                'quantity' => $quantity // Khởi tạo số lượng với giá trị hiện tại
            ];
        } else {
            // Nếu sản phẩm đã có, chỉ cần cập nhật số lượng
            $_SESSION['cart'][$key]['quantity'] += $quantity;
        }

        // Ghi lại giỏ hàng vào file JSON
        file_put_contents('cart.json', json_encode($_SESSION['cart']));
    }
}

$totalAmount = 0;

$totalQuantity = 0;

foreach ($_SESSION['cart'] as $cartItem) {

$product = $products[$cartItem['product_id']] ?? null;

$size = $sizes[$cartItem['size_id']] ?? null;

$toppingPrices = 0;

if (isset($cartItem['topping_ids']) && is_array($cartItem['topping_ids'])) {

foreach ($cartItem['topping_ids'] as $topping_id) {

if (isset($toppings[$topping_id])) {

$toppingPrices += $toppings[$topping_id]['gia'];

}

}

}

if ($product && $size) {

$totalItemPrice = ($product['gia'] + $size['gia'] + $toppingPrices) * $cartItem['quantity'];

$totalAmount += $totalItemPrice;

$totalQuantity += $cartItem['quantity'];

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

<link rel="stylesheet" href="t.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<div class="container ">
    <h2>Giỏ hàng</h2>
    <div class="row">
        <?php if ($_SESSION['cart'] > 0): ?>
            <?php foreach ($_SESSION['cart'] as $key => $cartItem): ?>
                <?php
                $product = $products[$cartItem['product_id']] ?? null;
                $size = $sizes[$cartItem['size_id']] ?? null;
                $toppingNames = [];

                if (isset($cartItem['topping_ids']) && is_array($cartItem['topping_ids'])) {
                    foreach ($cartItem['topping_ids'] as $topping_id) {
                        if (isset($toppings[$topping_id])) {
                            $toppingNames[] = htmlspecialchars($toppings[$topping_id]['tentopping']);
                        }
                    }
                }

                $sizeName = $size ? htmlspecialchars($size['tenkc']) : 'N/A';
                $toppingList = implode(', ', $toppingNames);
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <?php if ($product): ?>
                            <img src="img/<?php echo htmlspecialchars($product['hinh']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['tensp']); ?>" onerror="this.onerror=null; this.src='img/default.png';" style="width: 300px;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['tensp']); ?></h5>
                                <p>Giá sản phẩm: <?php echo number_format((float)$product['gia'], 0, ',', '.'); ?> VNĐ</p>
                                <p>Mô tả: <?php echo htmlspecialchars($product['mota']); ?></p>
                                <p>Kích cỡ: <?php echo $sizeName; ?></p>
                                <p>Topping: <?php echo $toppingList; ?></p>
                                <p>Số lượng: <strong><?php echo (int)$cartItem['quantity']; ?></strong></p>
                                <form method="POST" action="xoa.php">
                                    <input type="hidden" name="cart_key" value="<?php echo $key; ?>">
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                                
                            </div>
                        <?php else: ?>
                            <p>Sản phẩm không hợp lệ.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>
    </div>
    <div><a href="index.php" class="btn btn-primary">Chọn Sản Phẩm Khác</a></div>
    <div class="mt-4">
        <h4>Tổng số lượng sản phẩm: <?php echo $totalQuantity; ?></h4>
        <h4>Tổng tiền: <?php echo number_format($totalAmount, 0, ',', '.'); ?> VNĐ</h4>
     
        
        <form method="POST" action="thanhtoan.php" class="mt-2">
    <input type="hidden" name="total_amount" value="<?php echo $totalAmount; ?>">
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['idnguoidung']; ?>">
    <button type="submit" class="btn btn-primary">Thanh Toán</button>
</form>
    </div>
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