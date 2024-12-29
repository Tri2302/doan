<?php
session_start();

if (isset($_SESSION['idnguoidung'])) {
    
    session_unset();

    session_destroy();

    
    header("Location: dangnhap.php"); 
    exit();
} else {
    
    header("Location: index.php"); 
    exit();
}