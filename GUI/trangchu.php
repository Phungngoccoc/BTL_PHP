<?php
session_start(); // Start session

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: dangnhap.php");
    exit;
}

// Xử lý yêu cầu đăng xuất nếu có
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Hủy bỏ session
    session_unset();
    session_destroy();
    
    // Chuyển hướng về trang đăng nhập sau khi đăng xuất
    header('Location: dangnhap.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="quanlyhanghoaa.css">
    <style>
        .logout-btn {
            top: 10px;
            right: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-family: 'Times New Roman', Times, serif;
        }
        .logout-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <header>
            <h1>QUẢN LÝ HÀNG HÓA</h1>
        </header>
        
        <a href="?action=logout" class="logout-btn" >Đăng xuất</a>

        <div id="menu">
            <br>
            <ul>
                <li><a href="quanlyhanghoa.php" target="content-frame">Quản lý thông tin hàng</a></li>
                <li><a href="Quanlynhacungcap.php" target="content-frame">Quản lý nhà cung cấp</a></li>
                <li><a href="Quanlyhoadon.php" target="content-frame">Quản lý đơn hàng</a></li>
                <li><a href="Baocaothongke.php" target="content-frame">Báo cáo thống kê</a></li>
            </ul>
            <br>
        </div>
        <div id="content">
            <iframe name="content-frame" src="quanlyhanghoa.php" frameborder="0" style="width:100%; height:670px;border: 1px solid black;margin-bottom: 50px;"></iframe>
        </div> 
    </div>
</body>
</html>
