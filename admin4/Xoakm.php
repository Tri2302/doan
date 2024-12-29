<?php
    require 'config.php';
    if (isset($_GET['idkm']) && !empty($_GET['idkm'])) {
    $id = $_GET['idkm'];
    
    $sql = "DELETE FROM khuyenmai WHERE idkm=".$id;

    if ($connect->query($sql) === TRUE) {
        header('Location: Khuyenmai.php');
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