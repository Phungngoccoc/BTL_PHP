<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>giaodientrangchu</title>
<link rel="stylesheet" href="quanlyhanghoa.css">
<style>
    .selected-row {
        background-color:#4CAF50;
        color: white;
    }
</style>
<script>
    function selectRow(row) {
        // Remove 'selected-row' class from any previously selected row
        var selected = document.querySelector('.selected-row');
        if (selected) {
            selected.classList.remove('selected-row');
        }

        // Add 'selected-row' class to the clicked row
        row.classList.add('selected-row');

        // Set form values from the clicked row
        var cells = row.getElementsByTagName('td');
        document.getElementById('mahang').value = cells[0].innerText;
        document.getElementById('tenhang').value = cells[1].innerText;
        document.getElementById('dongia').value = cells[2].innerText;
        document.getElementById('soluong').value = cells[3].innerText;
        document.getElementById('donvitinh').value = cells[4].innerText;
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
include "../BLL/HANGHOABLL.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlyhanghoa";

$bll = new HANGHOABLL($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $mahang = isset($_POST['mahang']) ? $_POST['mahang'] : '';
    $tenhang = isset($_POST['tenhang']) ? $_POST['tenhang'] : '';
    $dongia = isset($_POST['dongia']) ? $_POST['dongia'] : '';
    $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';
    $donvitinh = isset($_POST['donvitinh']) ? $_POST['donvitinh'] : '';
    $mancc = isset($_POST['mancc']) ? $_POST['mancc'] : '';

    if ($action == 'Thêm') {
        if(empty($mahang)||empty($tenhang)||empty($dongia)||empty($soluong)||empty($donvitinh))
        {
            echo "<script>alert('Không được để trống thông tin!');</script>";
        }else{
            $result = $bll->getmahang($mahang);
            if($result->num_rows > 0)
            {
                echo "<script>alert('Mã hàng đã tồn tại!');</script>";
            }else{
                if ($bll->addHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc)) {
                    echo "<script>alert('Thêm hàng thành công!');</script>";
                } else {
                    echo "<script>alert('Thêm hàng thất bại!');</script>";
                }
            }
            
        }
        
    } elseif ($action == 'Sửa') {
        if(empty($mahang)||empty($tenhang)||empty($dongia)||empty($soluong)||empty($donvitinh))
        {
            echo "<script>alert('Không được để trống thông tin!');</script>";
        }else{
            $result = $bll->getmahang($mahang);
            if($result->num_rows > 0)
            {
                if ($bll->editHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc)) {
                    echo "<script>alert('Sửa hàng thành công!');</script>";
                } else {
                    echo "<script>alert('Sửa hàng thất bại!');</script>";
                }
            }else{
                echo "<script>alert('Mã hàng không tồn tại!');</script>";
            }
            
        }
        
    } elseif ($action == 'Xóa') {
        if(empty($mahang))
        {
            echo "<script>alert('Không được để trống thông tin!');</script>";
        }else{
            $result = $bll->getmahang($mahang);
            if($result->num_rows > 0)
            {
                if ($bll->removeHangHoa($mahang)) {
                    echo "<script>alert('Xóa hàng thành công!');</script>";
                } else {
                    echo "<script>alert('Xóa hàng thất bại!');</script>";
                }
            }else{
                echo "<script>alert('Mã hàng không tồn tại!');</script>";
            }
            
        }  
    }
}

$search = isset($_POST['search']) ? $_POST['search'] : '';
$result = $bll->getHangHoa($search);
?>

<form style="margin-top:50px;margin-left:100px" method="post">
    <label style="font-size: 20px;">Mã hàng:</label> <input type="text" id="mahang" name="mahang" style="width: 180px">
    <label style="font-size: 20px;margin-left:80px">Tên hàng:</label> <input type="text" id="tenhang" name="tenhang" style="width: 180px">
    <br><br>
    <label style="font-size: 20px;">Đơn giá:</label> <input type="text" id="dongia" name="dongia" style="width: 180px;margin-left:6px">
    <label style="font-size: 20px;margin-left:80px">Số lượng:</label> <input type="text" id="soluong" name="soluong" style="width: 180px;margin-left:2px">
    <br><br>
    <label style="font-size: 20px;">Đơn vị tính:</label> <input type="text" id="donvitinh" name="donvitinh" style="width: 158px;margin-left:0px">
    <label style="font-size: 20px;margin-left:80px">Mã NCC:</label> <input type="text" id="mancc" name="mancc" style="width: 180px;margin-left:2px">
    <br><br>
    <div class="search-bar">
        <button type="submit" name="action" value="Thêm" class="btn" style="margin-right: 100px;margin-left: 80px;">Thêm</button>
        <button type="submit" name="action" value="Sửa" class="btn" style="margin-right: 100px;">Sửa</button>
        <button type="submit" name="action" value="Xóa" class="btn" style="margin-right: 100px;">Xóa</button>
    </div>
</form>

<div style="margin-top:50px;margin-left:20px;margin-right:20px">
    <table border="158px" cellpadding="auto" cellspacing="auto" style="border: 0px solid black;text-align: center;border-collapse: collapse">
        <tr>
            <th style="width:100px;background-color: #4CAF50;color: white;">Mã hàng</th>
            <th style="width:300px;background-color: #4CAF50;color: white">Tên hàng</th>
            <th style="width:200px;background-color: #4CAF50;color: white">Đơn giá</th>
            <th style="width:200px;background-color: #4CAF50;color: white">Số lượng</th>
            <th style="width:200px;background-color: #4CAF50;color: white">Đơn vị tính</th>
            <th style="width:100px;background-color: #4CAF50;color: white">Mã NCC</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='selectRow(this)'>";
                echo "<td>" . $row["mahang"] . "</td>";
                echo "<td>" . $row["tenhang"] . "</td>";
                echo "<td>" . $row["dongia"] . "</td>";
                echo "<td>" . $row["soluong"] . "</td>";
                echo "<td>" . $row["donvitinh"] . "</td>";
                echo "<td>" . $row["mancc"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
