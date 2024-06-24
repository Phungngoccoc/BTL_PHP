<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dangnhap</title>
    <link rel="stylesheet" href="dangnhapp.css" >
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
            <input class="nut" type="submit" value="Đăng nhập"><br><br>
        </div>
    </form>
        
<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "quanlyhanghoa";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    function checkData($username, $password) {
        // Kiểm tra rỗng
        if (empty($username) || empty($password)) {
            return false;
        }
    
        // Kiểm tra ký tự đặc biệt
        if (strpos($username, ' ') !== false || strpos($password, ' ') !== false) {
            return false;
        }
    
        return true;
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form
        $username = $_POST["tentk"];
        $password = $_POST["mk"];

        // Kiểm tra dữ liệu
        if (checkData($username, $password)) {
            // Câu truy vấn để xác thực thông tin tài khoản và mật khẩu
            $sql = "SELECT * FROM taikhoan WHERE tentk = ? AND matkhau = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('Đăng nhập thành công!');</script>";
                echo "<script>window.location.href = 'trangchu.php';</script>";
            } else {
                echo "<script>alert('Tên người dùng hoặc mật khẩu không đúng!');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Tên người dùng hoặc mật khẩu không hợp lệ!');</script>";
        }
    }
    
    // Ngắt kết nối CSDL
    $conn->close();
?>
</body>
</html>
