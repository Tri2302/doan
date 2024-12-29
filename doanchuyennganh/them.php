<?php
session_start();

define("HOST", "localhost");
define("DATABASE", "chuyenn");
define("USERNAME", "root");
define("PASSWORD", "");

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ["status" => "error", "message" => "Invalid input"];

    if (isset($_POST['product'], $_POST['quantity'], $_POST['topping'], $_POST['size'])) {
        $product_id = intval($_POST['product']);
        $quantity = intval($_POST['quantity']);
        $topping_id = intval($_POST['topping']);
        $size_id = intval($_POST['size']);

        if ($quantity <= 0) {
            echo json_encode(["status" => "error", "message" => "Quantity must be greater than zero"]);
            exit;
        }

        
        $productQuery = $conn->prepare("SELECT * FROM sanpham WHERE idsanpham = ?");
        $productQuery->bind_param("i", $product_id);
        $productQuery->execute();
        $productResult = $productQuery->get_result();
        $product = $productResult->fetch_assoc();

        $toppingQuery = $conn->prepare("SELECT * FROM topping WHERE idtopping = ?");
        $toppingQuery->bind_param("i", $topping_id);
        $toppingQuery->execute();
        $toppingResult = $toppingQuery->get_result();
        $topping = $toppingResult->fetch_assoc();

        
        $sizeQuery = $conn->prepare("SELECT * FROM kichco WHERE idkc = ?");
        $sizeQuery->bind_param("i", $size_id);
        $sizeQuery->execute();
        $sizeResult = $sizeQuery->get_result();
        $size = $sizeResult->fetch_assoc();

        if ($product && $size && $topping) {
           
            $cartKey = $product_id . '-' . $size_id . '-' . $topping_id;

            
            if (!isset($_SESSION['giohang'][$cartKey])) {
                $_SESSION['giohang'][$cartKey] = [
                    'product_name' => $product['tensp'],
                    'size_name' => $size['tenkc'],
                    'topping_name' => $topping['tentopping'],
                    'product_price' => (float)$product['gia'],
                    'size_price' => (float)$size['gia'],
                    'topping_price' => (float)$topping['gia'],
                    'quantity' => 0,
                    'image' => $product['hinh'],
                ];
            }
          
            $_SESSION['giohang'][$cartKey]['quantity'] += $quantity;

            
            $response = [
                "status" => "success",
                "message" => "Products added to cart",
                "cart" => $_SESSION['giohang']
            ];

            
            $totalAmount = 0;
            $totalQuantity = 0;

            foreach ($_SESSION['giohang'] as $item) {
                $totalAmount += ($item['product_price'] + $item['size_price'] + $item['topping_price']) * $item['quantity'];
                $totalQuantity += $item['quantity'];
            }

            $response['totalAmount'] = $totalAmount; 
            $response['totalQuantity'] = $totalQuantity; 
            $response['message'] = "Invalid product, size, or topping selection.";
        }

        
        $productQuery->close();
        $toppingQuery->close();
        $sizeQuery->close();

        echo json_encode($response);
    } else {
        echo json_encode($response);
    }
}

$conn->close();