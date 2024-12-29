<?php
session_start();
require 'config.php';
$kq = "";
if(isset($_POST['dnhapadmin']))
{

   
    $tk = $_POST['Email'];
    $mk = $_POST['Matkhau'];
    $sql="SELECT * FROM nguoidung  where email = '$tk'  and matkhau = '$mk'  and phanquyen like 'admin'"  ;
    $result = $connect->query($sql);
    // echo  $mk;
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $_SESSION['email'] = $row["email"];
            $_SESSION['tennd'] = $row["tennd"];
            $_SESSION['idnguoidung'] = $row["idnguoidung"];
            
            header('Location: index.php');
            $row = $result->fetch_assoc();  
        }         
    }
    else
    {
        $kq ="Thông tin không đúng vui lòng kiềm tra lại";
    }
    

}
?>