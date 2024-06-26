<?php
session_start(); 

include "../BLL/TAIKHOANBLL.php";

$taikhoanBLL = new TAIKHOANBLL();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["tentk"];
    $password = $_POST["mk"];

    if ($taikhoanBLL->loginUser($username, $password)) {
        echo "<script>alert('Đăng nhập thành công!');</script>";
        echo "<script>window.location.href = 'trangchu.php';</script>";
        exit; // Exit after redirection
    } else {
        echo "<script>alert('Tên người dùng hoặc mật khẩu không đúng!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="dangnhapp.css">
</head>
<body>
    <h1>ĐĂNG NHẬP</h1>
    <form method="post" action="">
        <div style="border: 1px solid black;width: 400px;margin: 0 auto; margin-top: 50px; ">
            <br>
            <span>Tên người dùng:</span><br>
            <input type="text" id="tentk" name="tentk"><br>
            <span>Mật khẩu:</span><br>
            <input type="password" id="mk" name="mk"><br>
            <a href="#">Quên mật khẩu?</a><br>
            <input class="nut" type="submit" value="Đăng nhập" style="border-radius: 4px;"><br><br>
        </div>
    </form>
</body>
</html>
