<?php
$servername = "192.168.20.20";
$username = "bph";
$password = "adminbph11002"; // ใส่รหัสผ่านของ MySQL ที่คุณใช้
$dbname = "bph_person";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
?>
