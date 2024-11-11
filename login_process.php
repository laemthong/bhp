<?php
session_start();
include 'connect/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // คำสั่ง SQL เพื่อตรวจสอบผู้ใช้และรหัสผ่านในฐานข้อมูล admin
    $sql = "SELECT * FROM admin WHERE admin_name='$username' AND admin_password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin_login'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        header("Location: index.php"); // เปลี่ยนเส้นทางกลับไปยังหน้า login
        exit();
    }
}
?>
