<?php require 'config.php';
ob_start();
 ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng Nhập</title>
    <link rel="stylesheet" type="text/css" href="css/dangnhap.css">
</head>
<body>

<div class="login-container">
    <h2>Đăng Nhập</h2>
    <form method="POST" action="<?php include "DangnhapAdmin.php" ?>">
        <input type="text" name="Email" placeholder="Email" required>
        <input type="password" name="Matkhau" placeholder="Mật khẩu" required>
        <p style="color:red"><?php echo  $kq ?></p>
        <button type="submit" name="dnhapadmin">Đăng Nhập</button>
    </form>
</div>

</body>
</html>