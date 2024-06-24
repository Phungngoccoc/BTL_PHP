<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>giaodientrangchu</title>
<style>
    body {
        font-family: 'Times New Roman', Times, serif;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    table {
        width: 100;
        margin: auto;
        border-collapse: collapse;
    }   
    caption {
        margin-top: 10px;
        padding: 20px;
        caption-side: top;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    #refresh-button {
        display: block;
        width: 150px;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 16px;
        font-family: 'Times New Roman', Times, serif;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #refresh-button:hover {
        background-color: #45a049;
    }
</style>
<link rel="stylesheet" href="quanlyhanghoa.css">
</head>
<body>
<header>
    <h1>BÁO CÁO THỐNG KÊ</h1>
</header>
<div id="content" style="border: none ;">
    <button id="refresh-button" onclick="location.reload();">Refresh</button>

    <?php
        // Kết nối với cơ sở dữ liệu
        $conn = new mysqli('localhost', 'root', '', 'quanlyhanghoa');

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        // Thực hiện truy vấn SQL
        $sql = "SELECT NHACUNGCAP.MANCC, NHACUNGCAP.TENNCC, COUNT(HANGHOA.MAHANG) AS SOHANGHOA
                FROM NHACUNGCAP
                JOIN HANGHOA ON NHACUNGCAP.MANCC = HANGHOA.MANCC
                GROUP BY NHACUNGCAP.MANCC";
        $result = $conn->query($sql);

        // Tạo bảng HTML với dữ liệu từ cơ sở dữ liệu
        echo "<table>";
        echo "<caption>Thống Kê Số Mặt Hàng Theo NCC</caption>";
        echo "<tr><th>Mã nhà cung cấp</th><th>Tên nhà cung cấp</th><th>Số lượng hàng hóa</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["MANCC"] . "</td><td>" . $row["TENNCC"] . "</td><td>" . $row["SOHANGHOA"] . "</td></tr>";
        }
        echo "</table>";

        // Đóng kết nối với cơ sở dữ liệu
        $conn->close();
    ?>

    <?php
        // Kết nối với cơ sở dữ liệu
        $conn = new mysqli('localhost', 'root', '', 'quanlyhanghoa');

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        // Thực hiện truy vấn SQL
        $sql = "SELECT HANGHOA.MAHANG, HANGHOA.TENHANG, SUM(DONHANG.SOLUONG) AS SODONHANG, SUM(DONHANG.SOLUONG * HANGHOA.DONGIA) AS DOANHTHU
                FROM HANGHOA
                JOIN DONHANG ON HANGHOA.MAHANG = DONHANG.MAHANG
                WHERE loai = 'Xuất  '
                GROUP BY HANGHOA.MAHANG";
        $result = $conn->query($sql);

        // Tạo bảng HTML với dữ liệu từ cơ sở dữ liệu
        echo "<table>";
        echo "<caption>Thống Kê Doanh Thu</caption>";
        echo "<tr><th>Mã hàng</th><th>Tên hàng</th><th>Số lượng bán ra</th><th>Doanh thu</th></tr>";
        $tongdt = 0;
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["MAHANG"] . "</td><td>" . $row["TENHANG"] . "</td><td>" . $row["SODONHANG"] . "</td><td>" . $row["DOANHTHU"] . "</td></tr>";
            $tongdt += $row["DOANHTHU"];
        }
        echo "<tr><td colspan='4' style = 'text-align: right;' >Tổng doanh thu: " . $tongdt . "</td></tr>";
        echo "</table>";

        // Đóng kết nối với cơ sở dữ liệu
        $conn->close();
    ?>
    <br>
    <br>
    <?php
        // Kết nối với cơ sở dữ liệu
        $conn = new mysqli('localhost', 'root', '', 'quanlyhanghoa');

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        // Thực hiện truy vấn SQL
        $sql = "SELECT HANGHOA.MAHANG, HANGHOA.TENHANG, SUM(DONHANG.SOLUONG) AS SODONHANG, SUM(DONHANG.SOLUONG * HANGHOA.DONGIA) AS DOANHTHU
                FROM HANGHOA
                JOIN DONHANG ON HANGHOA.MAHANG = DONHANG.MAHANG
                WHERE loai = 'Nhập'
                GROUP BY HANGHOA.MAHANG";
        $result = $conn->query($sql);

        // Tạo bảng HTML với dữ liệu từ cơ sở dữ liệu
        echo "<table>";
        echo "<caption>Thống Kê Chi Phí Nhập Hàng</caption>";
        echo "<tr><th>Mã hàng</th><th>Tên hàng</th><th>Số lượng nhập vào</th><th>Doanh thu</th></tr>";
        $tongdt = 0;
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["MAHANG"] . "</td><td>" . $row["TENHANG"] . "</td><td>" . $row["SODONHANG"] . "</td><td>" . $row["DOANHTHU"] . "</td></tr>";
            $tongdt += $row["DOANHTHU"];
        }
        echo "<tr><td colspan='4' style = 'text-align: right;' >Tổng chi phí: " . $tongdt . "</td></tr>";
        echo "</table>";

        // Đóng kết nối với cơ sở dữ liệu
        $conn->close();
    ?>
    <br><br>
</div>
</body>
</html>