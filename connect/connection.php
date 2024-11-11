<?php
$servername = "127.0.0.1";
$username = "root";
$password = ""; // ใส่รหัสผ่านของ MySQL ที่คุณใช้
$dbname = "testbhp";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
?>
