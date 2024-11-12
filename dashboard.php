<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}
$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* สไตล์สำหรับ Navbar */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
            color: #fff;
        }
        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .navbar ul li {
            position: relative;
            margin-left: 20px;
        }
        .navbar ul li a {
            text-decoration: none;
            color: #fff;
            padding: 8px 15px;
            transition: background 0.3s;
            display: flex;
            align-items: center;
        }
        .navbar ul li a:hover {
            background-color: #575757;
            border-radius: 4px;
        }

        /* เพิ่มลูกศรชี้ลง */
        .navbar ul li a::after {
            content: '';
            border: solid white;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 4px;
            margin-left: 5px;
            transform: rotate(45deg);
            transition: transform 0.3s;
        }

        /* ซ่อนลูกศรในเมนูที่ไม่มี dropdown */
        .navbar ul li:not(.dropdown) > a::after {
            content: none;
        }

        /* สไตล์สำหรับ Dropdown */
        .navbar ul li .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #333;
            min-width: 150px;
            border-radius: 4px;
            z-index: 1;
        }
        .navbar ul li .dropdown-content a {
            color: #fff;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .navbar ul li .dropdown-content a:hover {
            background-color: #575757;
        }

        /* แสดง Dropdown เมื่อ Hover ที่เมนูหลัก และหมุนลูกศร */
        .navbar ul li:hover .dropdown-content {
            display: block;
        }
        .navbar ul li:hover > a::after {
            transform: rotate(-135deg);
        }
        /* เอาลูกศรออกจากเมนูย่อย */
.navbar ul li:not(.dropdown) > a::after {
    content: none;
}

.navbar ul li .dropdown-content a::after {
    content: none; /* ไม่แสดงลูกศรในเมนูย่อย */
}


        .navbar .logout-button {
            background-color: #d9534f;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .navbar .logout-button:hover {
            background-color: #c9302c;
        }
        .navbar .user-info{
            margin-left:900px;
            
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Dashboard</div>
        <ul>
            <li><a href="#home">บุคลากร</a></li>
            <li class="dropdown">
                <a href="#leave">การลา</a>
                <!-- Dropdown เมนูย่อย -->
                <div class="dropdown-content">
                    <a href="#sick-leave">ลาป่วย</a>
                    <a href="#personal-leave">ลากิจ</a>
                    <a href="#vacation-leave">ลาพักร้อน</a>
                </div>
            </li>
        </ul>
        <div class="user-info">ยินดีต้อนรับ, <?= htmlspecialchars($userName); ?></div>
        <a href="logout.php" class="logout-button" onclick="confirmLogout(event)">ออกจากระบบ</a>


    </div>

    <!-- เนื้อหาในหน้านี้ -->
    <div class="content">
        <h1>Welcome to the Dashboard</h1>
    </div>
    <script>
    function confirmLogout(event) {
        event.preventDefault(); // ป้องกันการคลิกลิงก์ทันที
        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการออกจากระบบ',
            text: 'คุณแน่ใจหรือไม่ว่าต้องการออกจากระบบ?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ยืนยัน!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "logout.php"; // เปลี่ยนเส้นทางไปยังหน้า logout.php หากผู้ใช้ยืนยัน
            }
        });
    }
</script>

   

</body>
</html>