<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>giaodientrangchu</title>
<link rel="stylesheet" href="quanlyhanghoa.css">
<script>
    function selectRow(row) {
        // Lấy các ô trong dòng đã chọn
        var cells = row.getElementsByTagName('td');

        // Gán giá trị của các ô cho các input tương ứng
        document.getElementById('mahang').value = cells[0].innerText;
        document.getElementById('tenhang').value = cells[1].innerText;
        document.getElementById('dongia').value = cells[2].innerText;
        document.getElementById('soluong').value = cells[3].innerText;
        document.getElementById('hinhanh').value = cells[4].getElementsByTagName('img')[0].src;
        document.getElementById('mancc').value = cells[5].innerText;
    }
</script>
</head>
<body>
<header>
    <h1>QUẢN LÝ THÔNG TIN HÀNG</h1>
</header>
<div class="search-bar">
    <form method="post">
        <input type="text" name="search" placeholder="Nhập tên hàng hóa" >
        <button type="submit">Tìm</button>
    </form>
</div>

<?php
// Kết nối tới cơ sở dữ liệu và hiển thị dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlyhanghoa";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi nhấn nút "Thêm"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'Thêm') {
    $mahang = $_POST['mahang'];
    $tenhang = $_POST['tenhang'];
    $dongia = $_POST['dongia'];
    $soluong = $_POST['soluong'];
    $hinhanh = $_POST['hinhanh'];
    $mancc = $_POST['mancc'];

    $sql = "INSERT INTO hanghoa (mahang, tenhang, dongia, soluong, anh, mancc) VALUES ('$mahang', '$tenhang', '$dongia', '$soluong', '$hinhanh', '$mancc')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thêm hàng thành công!');</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xử lý khi nhấn nút "Sửa"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'Sửa') {
    $mahang = $_POST['mahang'];
    $tenhang = $_POST['tenhang'];
    $dongia = $_POST['dongia'];
    $soluong = $_POST['soluong'];
    $hinhanh = $_POST['hinhanh'];
    $mancc = $_POST['mancc'];

    $sql = "UPDATE hanghoa SET tenhang='$tenhang', dongia='$dongia', soluong='$soluong', anh='$hinhanh', mancc='$mancc' WHERE mahang='$mahang'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sửa hàng thành công!');</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xử lý khi nhấn nút "Xóa"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'Xóa') {
    $mahang = $_POST['mahang'];
    $tenhang = $_POST['tenhang'];
    $dongia = $_POST['dongia'];
    $soluong = $_POST['soluong'];
    $hinhanh = $_POST['hinhanh'];
    $mancc = $_POST['mancc'];

    // Xóa các bản ghi liên quan trong bảng donhang trước khi xóa bản ghi trong bảng hanghoa
    $sql = "DELETE FROM donhang WHERE mahang='$mahang'";
    $conn->query($sql);
    
    // Xóa bản ghi trong bảng hanghoa
    $sql = "DELETE FROM hanghoa WHERE mahang='$mahang'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa hàng thành công!');</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Kiểm tra xem có từ khóa tìm kiếm không
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Truy vấn dữ liệu
if ($search != '') {
    $sql = "SELECT mahang, tenhang, dongia, soluong, anh, mancc FROM hanghoa WHERE tenhang LIKE '%$search%'";
} else {
    $sql = "SELECT mahang, tenhang, dongia, soluong, anh, mancc FROM hanghoa";
}
$result = $conn->query($sql);
?>

<form style="margin-top:50px;margin-left:100px" method="post">
    <label style="font-size: 20px;">Mã hàng:</label> <input type="text" id="mahang" name="mahang" style="width: 180px">
    <label style="font-size: 20px;margin-left:80px">Tên hàng:</label> <input type="text" id="tenhang" name="tenhang" style="width: 180px">
    <br><br>
    <label style="font-size: 20px;">Đơn giá:</label> <input type="text" id="dongia" name="dongia" style="width: 180px;margin-left:6px">
    <label style="font-size: 20px;margin-left:80px">Số lượng:</label> <input type="text" id="soluong" name="soluong" style="width: 180px;margin-left:2px">
    <br><br>
    <label style="font-size: 20px;">Hình ảnh:</label> <input type="text" id="hinhanh" name="hinhanh" style="width: 180px;margin-left:0px">
    <label style="font-size: 20px;margin-left:80px">Mã NCC:</label> <input type="text" id="mancc" name="mancc" style="width: 180px;margin-left:2px">
    <br><br>
    <div class="search-bar">
        <button type="submit" name="action" value="Thêm" class="btn" style="margin-right: 100px;margin-left: 80px;">Thêm</button>
        <button type="submit" name="action" value="Sửa" class="btn" style="margin-right: 100px;">Sửa</button>
        <button type="submit" name="action" value="Xóa" class="btn" style="margin-right: 100px;">Xóa</button>
    </div>
</form>

<div style="margin-top:50px;margin-left:20px;margin-right:20px">
    <table border="1" cellpadding="auto" cellspacing="auto">
        <tr>
            <th style="width:100px">Mã hàng</th>
            <th style="width:200px">Tên hàng</th>
            <th style="width:200px">Đơn giá</th>
            <th style="width:100px">Số lượng</th>
            <th style="width:200px">Hình ảnh</th>
            <th style="width:100px">Mã NCC</th>
        </tr>
        <?php
        // Hiển thị dữ liệu
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr onclick='selectRow(this)'>";
                echo "<td>" . $row["mahang"] . "</td>";
                echo "<td>" . $row["tenhang"] . "</td>";
                echo "<td>" . $row["dongia"] . "</td>";
                echo "<td>" . $row["soluong"] . "</td>";
                echo "<td><img src='" . $row["anh"] . "' alt='Image' width='100'></td>";
                echo "<td>" . $row["mancc"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
        }

        // Đóng kết nối
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
