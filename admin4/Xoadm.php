<?php
require 'config.php';

if (isset($_GET['iddm']) && !empty($_GET['iddm'])) {
    $id = intval($_GET['iddm']);

    
    $checkSql1 = "SELECT COUNT(*) as soluongsanpham FROM sanpham WHERE iddanhmuc = $id";
    $result = $connect->query($checkSql1);
    $row = $result->fetch_assoc();

    if ($row['soluongsanpham'] > 0) {
       
        header('Location: Danhmuc.php');
    } else {
        
        $sql = "DELETE FROM danhmuc WHERE iddm = $id";

        if ($connect->query($sql) === TRUE) {
            header('Location: Danhmuc.php');
        } else {
            echo "Error deleting record:  " . $connect->error;
        }
    }

    $connect->close();
} else {
    die('Error: Missing or invalid product ID.');
}
?>
<script>
function Del() {
    alert("Xóa thành công");
}
</script>
