<!DOCTYPE html>
<html>
<head>
    <title>Quản lý nhà cung cấp</title>
    <link rel="stylesheet" href="quanlyhanghoaa.css">
    <style>
    .selected-row {
        background-color:#4CAF50;
        color: white;
    }
    </style>
    <script>
        function selectRow(row) {
            // Xóa lớp 'selected-row' khỏi bất kỳ hàng nào đã chọn trước đó
            var selected = document.querySelector('.selected-row');
            if (selected) {
                selected.classList.remove('selected-row');
            }

          // Thêm lớp 'selected-row' vào hàng được nhấp chuột
            row.classList.add('selected-row');

           // Đặt giá trị biểu mẫu từ hàng được click
            var cells = row.getElementsByTagName('td');
            document.getElementById('mancc').value = cells[0].innerText;
            document.getElementById('tenncc').value = cells[1].innerText;
            document.getElementById('diachincc').value = cells[2].innerText;
            document.getElementById('email').value = cells[3].innerText;
        }
        function confirmDelete(event) {
        var action = event.target.value;
        if (action === "Xóa") {
            var confirmed = confirm("Bạn có chắc chắn muốn xóa hàng hóa này?");
            if (!confirmed) {
                event.preventDefault(); // Cancel form submission if not confirmed
            }
        }
    }
    </script>
</head>
<body>
    <header>
        <h1>QUẢN LÝ NHÀ CUNG CẤP</h1>
    </header>
    <div class="search-bar">
        <form method="post">
            <input type="text" name="search" placeholder="Nhập tên nhà cung cấp" style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">
            <button type="submit">Tìm</button>
        </form>
    </div>

    <?php
    include "../BLL/NCCBLL.php";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quanlyhanghoa";

    $bll = new NCCBLL($servername, $username, $password, $dbname);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $mancc = isset($_POST['mancc']) ? $_POST['mancc'] : '';
        $tenncc = isset($_POST['tenncc']) ? $_POST['tenncc'] : '';
        $diachincc = isset($_POST['diachincc']) ? $_POST['diachincc'] : '';
        $email  =  isset($_POST['email']) ? $_POST['email'] : '';

        if ($action == 'Thêm') {
            if ($bll->addNhaCungCap( $mancc, $tenncc, $diachincc, $email)) {
                echo "<script>alert('Thêm nhà cung cấp thành công!');</script>";
            } else {
                echo "<script>alert('Thêm nhà cung cấp thất bại!');</script>";
            }
        } elseif ($action == 'Sửa') {
            if ($bll->editNhaCungCap($mancc, $tenncc, $diachincc, $email)) {
                echo "<script>alert('Sửa nhà cung cấp thành công!');</script>";
            } else {
                echo "<script>alert('Sửa nhà cung cấp thất bại!');</script>";
            }
        } elseif ($action == 'Xóa') {
            if ($bll->removeNhaCungCap($mancc)) {
                echo "<script>alert('Xóa nhà cung cấp thành công!');</script>";
            } else {
                echo "<script>alert('Xóa nhà cung cấp thất bại!');</script>";
            }
        }
    }

    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $result = $bll->getNhaCungCap($search);
    ?>

    <form style="margin-top:50px;margin-left:100px" method="post">
        <label style="font-size: 20px;">Mã NCC:</label> <input type="text" id="mancc" name="mancc" style="width: 180px;font-size: 18px;font-family: 'Times New Roman', Times, serif;" required>
        <label style="font-size: 20px;margin-left:80px">Tên NCC:</label> <input type="text" id="tenncc" name="tenncc" style="width: 180px;font-size: 18px;font-family: 'Times New Roman', Times, serif;" required>
        <br><br>
        <label style="font-size: 20px;">Địa chỉ NCC:</label> <input type="text" id="diachincc" name="diachincc" style="width: 148px;margin-left:0px;font-size: 18px;font-family: 'Times New Roman', Times, serif;" required>
        <label style="font-size: 20px;margin-left:80px">Email NCC:</label> <input type="email" id="email" name="email" style="width: 164px;margin-left:0px;font-size: 18px;font-family: 'Times New Roman', Times, serif;" required>
        <div style="margin-top:50px" class="search-bar">
            <button type="submit" name="action" value="Thêm" class="btn" style="margin-right: 100px;margin-left: 80px;">Thêm</button>
            <button type="submit" name="action" value="Sửa" class="btn" style="margin-right: 100px;">Sửa</button>
            <button type="submit" name="action" value="Xóa" class="btn" style="margin-right: 100px;" onclick="confirmDelete(event)">Xóa</button>
        </div>
    </form>

    <div style="margin-top:50px;margin-left:20px;margin-right:20px;overflow-y: auto;height: 250px;">
    <table border="158px" cellpadding="auto" cellspacing="auto" style="border: 0px solid black;text-align: center;border-collapse: collapse">
            <tr>
                <th style="width:100px;background-color: #4CAF50;color: white;">Mã NCC</th>
                <th style="width:300px;background-color: #4CAF50;color: white;">Tên NCC</th>
                <th style="width:300px;background-color: #4CAF50;color: white;">Địa chỉ NCC</th>
                <th style="width:300px;background-color: #4CAF50;color: white;">Email NCC</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick='selectRow(this)'>";
                    echo "<td>" . $row["MANCC"] . "</td>";
                    echo "<td>" . $row["TENNCC"] . "</td>";
                    echo "<td>" . $row["DIACHINCC"] . "</td>";
                    echo "<td>" . $row["EMAIL"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
