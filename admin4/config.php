<?php
$connect = mysqli_connect("localhost", "root", "", "chuyenn");

if ($connect->connect_error) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$connect->set_charset("utf8");
