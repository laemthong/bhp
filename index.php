<?php
session_start();
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear error after displaying it
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Josefin+Sans');
        * {
            box-sizing: border-box;
        }
        body {
            padding: 0;
            margin: 0;
            background: #f4f4f4;
            font-family: 'Josefin Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 350px;
            background: #FFF;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 8px;
        }
        #login-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        #login-logo #border {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #51a9d6;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }
        #login-logo i {
            color: #fff;
            font-size: 40pt;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        #login-logo #elzero {
            font-size: 17pt;
            color: gray;
            margin-top: 10px;
        }
        .input-container {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }
        .input-container input {
            width: 100%;
            height: 40px;
            padding: 10px;
            background: #DADCDB;
            border: none;
            border-radius: 4px;
            font-size: 14pt;
        }
        .input-container label {
            position: absolute;
            top: 50%;
            left: 10px;
            color: gray;
            font-size: 12pt;
            transform: translateY(-50%);
            transition: 0.3s ease;
            pointer-events: none;
        }
        .input-container input:focus + label,
        .input-container input:not(:placeholder-shown) + label {
            top: -5px;
            left: 10px;
            color: #51a9d6;
            font-size: 10pt;
            background-color: #FFF;
            padding: 0 5px;
        }
        .input-container:before {
            position: absolute;
            font-family: fontawesome;
            font-size: 16pt;
            color: gray;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        #user:before { content: "\f007"; }
        #Pass:before { content: "\f023"; }
        .container input[type=submit] {
            width: 100%;
            height: 40px;
            background: #000;
            color: #FFF;
            border: none;
            font-size: 15pt;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .container input[type=submit]:hover {
            background: #333;
        }
        #remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 10pt;
        }
        #remember a {
            color: #51a9d6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
    <div id="login-logo">
    <div>
        <img src="https://โรงงานเสาเข็ม.com/wp-content/uploads/2022/06/%E0%B8%A3%E0%B8%9E.%E0%B8%9A%E0%B8%9C-800x675.png" alt="Login Logo" style="width: 250px; height:200px;"> <!-- กำหนดขนาดตามต้องการ -->
    </div>
    <div id="elzero">Banphai Hospital Login</div>
</div>

        <form autocomplete="off" action="login_process.php" method="post">
            <div id="user" class="input-container">
                <input type="text" id="userInput" name="username" placeholder=" " required />
                <label for="userInput">Username</label>
            </div>
            <div id="Pass" class="input-container">
                <input type="password" id="passInput" name="password" placeholder=" " required />
                <label for="passInput">Password</label>
            </div>
            <input type="submit" value="Login" />
        </form>
    </div>

    <?php if (isset($error)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?= $error ?>',
                confirmButtonText: 'ตกลง'
            });
        </script>
    <?php endif; ?>
</body>
</html>