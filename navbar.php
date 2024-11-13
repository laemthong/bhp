<?php
// ตรวจสอบว่ามีการเริ่มเซสชันไปแล้วหรือไม่
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['user_name'] ?? 'Guest'; // ให้ชื่อผู้ใช้แสดงใน navbar
?>
<div class="navbar">
<div class="logo">
        <a href="dashboard.php">
            <img src="https://scontent.fkkc3-1.fna.fbcdn.net/v/t1.15752-9/462642701_1648987868991321_8373427452202184159_n.png?_nc_cat=104&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeGa5uCObmcrsA79DAb3WeZBwgatLBJN9OjCBq0sEk306NG48TPnYjJhAFBIl0mTVXs8R2kfXtgoCHDW_kvziWy1&_nc_ohc=r23f8vZ2Hd4Q7kNvgGdzH1O&_nc_zt=23&_nc_ht=scontent.fkkc3-1.fna&oh=03_Q7cD1QH2MH7o4_9RRcnZXrHmtJnAEnoHT98_qybGEXoXJjhjBQ&oe=675A528C" alt="Login Logo" style="width: 90px; height:60px;">
        </a>
    </div>
    <ul>
        <li><a href="form_person.php">บุคลากร</a></li>
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
<style>
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
        background-color: #fbc531;
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
         
        .user-info-container {
    position: relative;
    display: inline-block;
}

.user-info-dropdown {
        background-color: #fbc531;
        color: white;
        border-radius: 4px;
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
        border-radius: 8px;
        z-index: 1;
        margin-right: 38px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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
    </style>

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
