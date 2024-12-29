<?php
    require 'config.php';
    if (isset($_GET['idsanpham']) && !empty($_GET['idsanpham'])) {
    $id = $_GET['idsanpham'];
    $sql = "DELETE FROM sanpham WHERE idsanpham=".$id;

    if ($connect->query($sql) === TRUE) {
        header('Location: Sanpham.php');
    } else {
        echo "Error deleting record: " . $connect->error;
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