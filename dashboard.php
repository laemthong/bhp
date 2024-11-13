<?php
session_start();
$inactive = 300;

if (isset($_SESSION['last_activity'])) {
    $session_life = time() - $_SESSION['last_activity'];
    if ($session_life > $inactive) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

$_SESSION['last_activity'] = time();
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$userName = $_SESSION['user_name']; // กำหนดตัวแปร $userName
include 'navbar.php';
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
        

        /* เพิ่ม padding ให้กับเนื้อหาเพื่อไม่ให้ซ้อนทับกับ navbar */
        .content {
            padding: 80px 20px;
            margin-top: 100px;
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
</body>
</html>
