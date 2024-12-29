<?php

define("HOST", "localhost");
define("DATABASE", "chuyenn");
define("USERNAME", "root");
define("PASSWORD", "");

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$sql = "SELECT * FROM sanpham";
$r = $conn->query($sql);

// Fetch toppings
$sqlt = "SELECT * FROM topping";
$rt = $conn->query($sqlt);
$toppings = [];

if ($rt && $rt->num_rows > 0) {
    while ($row = $rt->fetch_assoc()) {
        $toppings[] = $row;
    }
}

// Fetch sizes
$sqlk = "SELECT * FROM kichco";
$rkc = $conn->query($sqlk);
$kc = [];

if ($rkc && $rkc->num_rows > 0) {
    while ($row = $rkc->fetch_assoc()) {
        $kc[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILK_TEA Store 2003</title>
    <link rel="stylesheet" href="t.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

<div class="row">
    <nav class="bg-success">
        <div class="container-fluid">
            <ul class="nav-item d-flex justify-content-around align-items-center">
                <li class="nav"><a class="nav-link" href="indexuser.php">Trang Chủ</a></li>
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

<h2 class="mt-4">Trà Sữa Việt Quất</h2>
<?php if ($r && $r->num_rows > 0): ?>
    <div class="row">
        <?php while ($product = $r->fetch_assoc()): ?>
            <?php if ($product["iddanhmuc"] == '1' && stripos($product["tensp"], 'việt quất') !== false): ?>
                <div class="col-md-4 mb-3">
                    <article class='product'>
                        <?php $imagePath = 'img/' . htmlspecialchars($product["hinh"]); ?>
                        <?php if (file_exists($imagePath)): ?>
                            <img src='<?= htmlspecialchars($imagePath) ?>' alt='<?= htmlspecialchars($product["tensp"]) ?>' class='img-fluid'>
                        <?php else: ?>
                            <p>Không có ảnh: <?= htmlspecialchars($imagePath) ?></p>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($product["tensp"]) ?></h3>
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
                    </article>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Không có trà sữa</p>
<?php endif; ?>

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
    const base = parseInt(wrapper.querySelector('.base').textContent);

    function update() {
        const sizemg = parseInt(sizem.options[sizem.selectedIndex].getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value);
        const total = (base + sizemg) * quantity; // Only size price added to base here
        totalElement.textContent = total + ' VNĐ';
        wrapper.querySelector('.quantity-input-hidden').value = quantity; // Update hidden quantity input
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
    update(); // Initialize total on page load
});
</script>

</body>
</html>