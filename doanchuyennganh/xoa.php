<?php
session_start();


if (isset($_SESSION['cart'])) {
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart_key'])) {
        $keyToDelete = $_POST['cart_key'];

       
        if (isset($_SESSION['cart'][$keyToDelete])) {
            unset($_SESSION['cart'][$keyToDelete]);

            
            file_put_contents('cart.json', json_encode($_SESSION['cart']));
        }
    }
}


header("Location: giohang.php");
exit();
?>