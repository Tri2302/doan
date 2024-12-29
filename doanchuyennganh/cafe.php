<?php
session_start();


define("HOST", "localhost");
define("DATABASE", "chuyenn");
define("USERNAME", "root");
define("PASSWORD", "");

try {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}


if (!isset($_SESSION['idnguoidung'])) {
    header("Location: dangki.php"); 
    exit();
}


$sql = "SELECT * FROM sanpham";
$r = $conn->query($sql);

$sqld = "SELECT * FROM danhmuc";
$rd = $conn->query($sqld);
$danhmuc = $rd ? $rd->fetch_all(MYSQLI_ASSOC) : [];

$sqlt = "SELECT * FROM topping";
$rt = $conn->query($sqlt);
$toppings = $rt ? $rt->fetch_all(MYSQLI_ASSOC) : [];

$sqlk = "SELECT * FROM kichco";
$rkc = $conn->query($sqlk);
$kc = $rkc ? $rkc->fetch_all(MYSQLI_ASSOC) : [];

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
            <a href="dangki.php">Đăng Kí</a> 
            <a href="dangnhap.php">Đăng Nhập</a> 
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

    <div class="container">
        <?php if ($r && $r->num_rows > 0): ?>
            <div class="row">
                <h2>Cafe</h2>
                <?php while ($product = $r->fetch_assoc()): ?>
                    <?php if ($product["iddanhmuc"] == '4'): ?>
                    <div class="col-md-4 mb-3">
                        <div class='product'>
                        <?php $imagePath = 'img/' . htmlspecialchars($product["hinh"]); ?>
                        <?php if (file_exists($imagePath)): ?>
                            <img src='<?= htmlspecialchars($imagePath) ?>' alt='<?= htmlspecialchars($product["tensp"]) ?>' class='img-fluid'>
                        <?php else: ?>
                            <p>Không có ảnh: <?= htmlspecialchars($imagePath) ?></p>
                        <?php endif; ?>
                        <h2><?= htmlspecialchars($product["tensp"]) ?></h2>
                        <p>Mô tả: <?= htmlspecialchars($product["mota"]) ?></p>
                        <p>Giá: <span class='base'><?= htmlspecialchars($product["gia"]) ?> VNĐ</span></p>

                        <div class='quantity-wrapper'>
                            <button type='button' class='minus-btn'>-</button>
                            <input type='text' class='quantity-input' value='1' readonly>
                            <button type='button' class='plus-btn'>+</button>
                        </div>
                        <p>+ <span class='total'><?= htmlspecialchars($product["gia"]) ?> VNĐ</span></p>

                        <form method='POST' action='giohang.php' class='add-to-cart-form'>
                            <input type='hidden' name='product_id' value='<?= $product["idsanpham"] ?>'>
                            <input type='hidden' name='quantity' class='quantity-input-hidden' value='1'>
                            <div>
                                <select name='kc' class='sizem'>
                                    <?php foreach ($kc as $size): ?>
                                        <option value='<?= $size["idkc"] ?>' data-price='<?= htmlspecialchars($size["gia"]) ?>'><?= htmlspecialchars($size["tenkc"]) ?> - <?= htmlspecialchars($size["gia"]) ?> VNĐ</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="toppings">Chọn topping:</label>
                                <?php foreach ($toppings as $topping): ?>
                                    <div>
                                        <input type="checkbox" name="topping_ids[]" value="<?= $topping['idtopping']; ?>" data-price="<?= htmlspecialchars($topping['gia']); ?>">
                                        <label><?= htmlspecialchars($topping['tentopping']); ?> (<?= htmlspecialchars($topping['gia']); ?> VNĐ)</label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type='submit' class='btn btn-success'>Thêm vào giỏ hàng</button>
                        </form>

                        </div>
                    </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Không có trà sữa</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="text-success">Hotline</h2>
                    <p>📞 0354219578</p>
                    <p>📍 Địa chỉ: 123 Đường ABC, Quận XYZ, Thành phố</p>
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

    <script>
    document.querySelectorAll('.product').forEach(wrapper => {
        const sizem = wrapper.querySelector('.sizem');
        const quantityInput = wrapper.querySelector('.quantity-input');
        const totalElement = wrapper.querySelector('.total');
        const base = parseInt(wrapper.querySelector('.base').textContent) || 0;
        const quantityInputHidden = wrapper.querySelector('.quantity-input-hidden');

        function update() {
            const sizemg = parseInt(sizem.options[sizem.selectedIndex].getAttribute('data-price')) || 0;
            const quantity = parseInt(quantityInput.value);
            quantityInputHidden.value = quantity; // Update hidden quantity input
            const toppings = Array.from(wrapper.querySelectorAll('input[name="topping_ids[]"]:checked')).map(topping => parseInt(topping.getAttribute('data-price')) || 0);
            const totalToppings = toppings.reduce((sum, price) => sum + price, 0);
            const total = (base + sizemg + totalToppings) * quantity;
            totalElement.textContent = total + ' VNĐ';
        }

        wrapper.querySelector('.minus-btn').addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
                update();
            }
        });

        wrapper.querySelector('.plus-btn').addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity < 10) {
                quantityInput.value = quantity + 1;
                update();
            }
        });

        sizem.addEventListener('change', update);
        wrapper.querySelectorAll('input[name="topping_ids[]"]').forEach(topping => {
            topping.addEventListener('change', update);
        });

        update(); // Initialize total on page load
    });
    </script>

</body>
</html>