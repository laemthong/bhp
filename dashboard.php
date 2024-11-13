<?php
session_start();

$inactive = 180; // 3 นาที (3 * 60 วินาที)

// ตรวจสอบว่า last_activity อยู่ในเซสชันหรือไม่
if (isset($_SESSION['last_activity'])) {
    // คำนวณความแตกต่างของเวลา
    $session_life = time() - $_SESSION['last_activity'];
    if ($session_life > $inactive) {
        // ถ้าเกิน 3 นาที ให้ลบข้อมูลเซสชันทั้งหมดและออกจากระบบ
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

// อัปเดตเวลาล่าสุดของการใช้งานในเซสชัน
$_SESSION['last_activity'] = time();

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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fc;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #3498db;
            padding: 10px 20px;
            color: #fff;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
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
            margin-right: auto;
        }
        .navbar ul li {
            position: relative;
            margin-right: auto;
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
            background-color:  #fbc531;
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
            background-color: #17c0eb;
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

        .navbar ul li .dropdown-content a::after {
            content: none; /* ไม่แสดงลูกศรในเมนูย่อย */
        }

      
        .navbar .user-info {
            margin-right: 20px;
        }

        /* เพิ่ม padding ให้กับเนื้อหาเพื่อไม่ให้ซ้อนทับกับ navbar */
        .content {
            padding: 80px 20px;
        }
        
        .user-info-container {
    position: relative;
    display: inline-block;
}

.user-info-dropdown {   
    background-color: #fbc531; /* เปลี่ยนสีพื้นหลังของปุ่ม */
    color: white; /* เปลี่ยนสีตัวอักษร */
    border-radius: 4px; /* เพิ่มขอบโค้ง */
    border: none;
    cursor: pointer;
    font-size: 16px;
    padding: 8px 15px;
    margin-right: 40px;
    position: relative;
}

/* เพิ่มลูกศรชี้ลง */
.user-info-dropdown::after {
    content: '';
    border: solid white;
    border-width: 0 2px 2px 0;
    display: inline-block;
    padding: 4px;
    margin-right: 5px;
    transform: rotate(45deg);
    transition: transform 0.3s;
}

/* หมุนลูกศรเมื่อโฮเวอร์ที่ dropdown */
.user-info-container:hover .user-info-dropdown::after {
    transform: rotate(-135deg);
}

/* สไตล์ dropdown-content สำหรับเมนู logout */
.user-info-container .dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #17c0eb;
    min-width: 150px;
    border-radius: 8px; /* ปรับขอบให้โค้ง */
    z-index: 1;
    margin-right: 38px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* เพิ่มเงาเพื่อให้ดูนุ่มนวล */
}

.user-info-container .dropdown-content a {
    color: #fff;
    padding: 10px 15px;
    display: block;
    text-decoration: none;
    border-radius: 4px; /* ขอบโค้งที่แต่ละตัวเลือก */
}

.user-info-container .dropdown-content a:hover {
    background-color: #575757;
    border-radius: 4px; /* เพิ่มขอบโค้งในสถานะ hover */
}

/* แสดง dropdown-content เมื่อ hover */
.user-info-container:hover .dropdown-content {
    display: block;
}
.dashboard {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .card h3 {
            color: #888;
            font-size: 16px;
            margin: 0;
        }

        .card p {
            font-size: 24px;
            color: #333;
            margin: 10px 0 0;
        }

      

        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .chart-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .chart-container h4 {
            font-size: 18px;
            color: #4e73df;
            margin-bottom: 15px;
        }


       
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo"><img src="https://scontent.fkkc3-1.fna.fbcdn.net/v/t1.15752-9/462642701_1648987868991321_8373427452202184159_n.png?_nc_cat=104&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeGa5uCObmcrsA79DAb3WeZBwgatLBJN9OjCBq0sEk306NG48TPnYjJhAFBIl0mTVXs8R2kfXtgoCHDW_kvziWy1&_nc_ohc=r23f8vZ2Hd4Q7kNvgGdzH1O&_nc_zt=23&_nc_ht=scontent.fkkc3-1.fna&oh=03_Q7cD1QH2MH7o4_9RRcnZXrHmtJnAEnoHT98_qybGEXoXJjhjBQ&oe=675A528C" alt="Login Logo" style="width: 90px; height:60px;">
</div>
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
    <div class="user-info-container dropdown">
        <button class="user-info-dropdown">
           <?= htmlspecialchars($userName); ?> 
        </button>
        <div class="dropdown-content">
            <a href="logout.php" onclick="confirmLogout(event)">ออกจากระบบ</a>
        </div>
    </div>
</div>


  

<div class="content">
    <div class="dashboard">
        <div class="card">
            <h3>EARNINGS (MONTHLY)</h3>
            <p>$40,000</p>
        </div>
        <div class="card">
            <h3>EARNINGS (ANNUAL)</h3>
            <p>$215,000</p>
        </div>
        <div class="card">
            <h3>TASKS</h3>
            <p>50%</p>
        </div>
        <div class="card">
            <h3>PENDING REQUESTS</h3>
            <p>18</p>
        </div>
    </div>

    <div class="charts">
        <div class="chart-container">
            <h4>Earnings Overview</h4>
            <canvas id="earningsChart"></canvas>
        </div>
        <div class="chart-container">
            <h4>Revenue Sources</h4>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Earnings Overview Chart
    const ctx1 = document.getElementById('earningsChart').getContext('2d');
    const earningsChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Earnings',
                data: [10000, 15000, 12000, 17000, 13000, 19000, 25000, 30000, 27000, 35000, 37000, 40000],
                borderColor: '#4e73df',
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 40000,
                    ticks: { callback: (value) => '$' + value.toLocaleString() }
                }
            }
        }
    });

    // Revenue Sources Chart
    const ctx2 = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Direct', 'Social', 'Referral'],
            datasets: [{
                data: [55, 30, 15],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>

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
