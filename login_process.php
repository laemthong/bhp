
<?php
// นำเข้าไฟล์การเชื่อมต่อ
include 'connect/connection.php';

// รับข้อมูลจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// เข้ารหัสรหัสผ่านด้วย MD5
$hashed_password = md5($password);

// สร้างคำสั่ง SQL สำหรับตรวจสอบผู้ใช้
$sql = "SELECT * FROM officer WHERE officer_login_name = ? AND officer_login_password_md5 = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบผลลัพธ์
if ($result->num_rows == 1) {
    $_SESSION['login'] = $username;
    header("Location: dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    header("Location: index.php"); // เปลี่ยนเส้นทางกลับไปยังหน้า login
    exit();
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->closehh();
?>

