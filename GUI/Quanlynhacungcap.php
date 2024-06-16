<!DOCTYPE html>
<html>
<head>
    <title>Quản lý nhà cung cấp</title>
    <link rel="stylesheet" href="quanlynhacuncap.css">
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
            document.getElementById('mancc').value = cells[0].innerText;
            document.getElementById('tenncc').value = cells[1].innerText;
            document.getElementById('diachincc').value = cells[2].innerText;
        }
    </script>
</head>
<body>
    <header>
        <h1>QUẢN LÝ NHÀ CUNG CẤP</h1>
    </header>
    <div class="search-bar">
        <form method="post">
            <input type="text" name="search" placeholder="Nhập tên nhà cung cấp">
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

        if ($action == 'Thêm') {
            if ($bll->addNhaCungCap( $mancc, $tenncc, $diachincc)) {
                echo "<script>alert('Thêm nhà cung cấp thành công!');</script>";
            } else {
                echo "<script>alert('Thêm nhà cung cấp thất bại!');</script>";
            }
        } elseif ($action == 'Sửa') {
            if ($bll->editNhaCungCap($mancc, $tenncc, $diachincc)) {
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
        <label style="font-size: 20px;">Mã NCC:</label> <input type="text" id="mancc" name="mancc" style="width: 180px">
        <label style="font-size: 20px;margin-left:80px">Tên NCC:</label> <input type="text" id="tenncc" name="tenncc" style="width: 180px">
        <br><br>
        <label style="font-size: 20px;">Địa chỉ NCC:</label> <input type="text" id="diachincc" name="diachincc" style="width: 158px;margin-left:0px">
        <div style="margin-top:50px" class="search-bar">
            <button type="submit" name="action" value="Thêm" class="btn" style="margin-right: 100px;margin-left: 80px;">Thêm</button>
            <button type="submit" name="action" value="Sửa" class="btn" style="margin-right: 100px;">Sửa</button>
            <button type="submit" name="action" value="Xóa" class="btn" style="margin-right: 100px;">Xóa</button>
        </div>
    </form>

    <div style="margin-top:50px;margin-left:20px;margin-right:20px">
        <table border="158px" cellpadding="auto" cellspacing="auto" style="border: 0px solid black;text-align: center;">
            <tr>
                <th style="width:100px">Mã NCC</th>
                <th style="width:300px">Tên NCC</th>
                <th style="width:300px">Địa chỉ NCC</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick='selectRow(this)'>";
                    echo "<td>" . $row["MANCC"] . "</td>";
                    echo "<td>" . $row["TENNCC"] . "</td>";
                    echo "<td>" . $row["DIACHINCC"] . "</td>";
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
