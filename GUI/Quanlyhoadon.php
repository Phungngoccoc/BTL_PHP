<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Giao Diện Trang Chủ</title>
<link rel="stylesheet" href="quanlyhanghoa.css">
<style>
    .selected-row {
        background-color: #4CAF50;
        color: white;
    }
</style>
<script>
    function selectRow(row) {
        var selected = document.querySelector('.selected-row');
        if (selected) {
            selected.classList.remove('selected-row');
        }
        row.classList.add('selected-row');
        var cells = row.getElementsByTagName('td');
        document.getElementById('mahang').value = cells[0].innerText;
        document.getElementById('tenhang').value = cells[1].innerText;

        // Chuyển đổi đơn giá thành số nguyên
        var dongia = parseFloat(cells[2].innerText).toFixed(0);
        document.getElementById('dongia').value = dongia;

        document.getElementById('soluong').value = cells[3].innerText;
        document.getElementById('donvitinh').value = cells[4].innerText;
        document.getElementById('mancc').value = cells[5].innerText;
    }
</script>
</head>
<body>
<header>
    <h1>QUẢN LÝ ĐƠN HÀNG</h1>
</header>
<div class="search-bar">
    <form method="post">
        <input type="text" name="search" placeholder="Nhập tên hàng hóa">
        <button type="submit" name="action" value="Tìm">Tìm</button>
    </form>
</div>

<?php
include "../BLL/HANGHOABLL.php";
include "../BLL/NCCBLL.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlyhanghoa";

$bll = new HANGHOABLL($servername, $username, $password, $dbname);
$blll = new NCCBLL($servername, $username, $password, $dbname);

// Fetch supplier data
$suppliers = $blll->getAllNhaCungCap();

$errors = [];

function validateForm($data) {
    global $errors;
    
    // Special characters pattern
    $specialCharPattern = '/[!@#\$%\^\&*\)\(+=._-]+/';
    // Number pattern
    $numberPattern = '/^[0-9]+$/';
    
    if (empty($data['mahang'])) {
        $errors['mahang'] = 'Mã hàng không được để trống.';
        return empty($errors);
    } elseif (preg_match($specialCharPattern, $data['mahang']) || strpos($data['mahang'], ' ') !== false) {
        $errors['mahang'] = 'Mã hàng không được chứa ký tự đặc biệt hoặc khoảng trắng.';
        return empty($errors);
    }else if(strlen($data['mahang']) > 5)
    {
        $errors['mahang'] = 'Mã hàng không được dài hơn 5 kí tự.';
        return empty($errors);
    }

    if (empty($data['tenhang'])) {
        $errors['tenhang'] = 'Tên hàng không được để trống.';
        return empty($errors);
    } elseif (preg_match($specialCharPattern, $data['tenhang'])) {
        $errors['tenhang'] = 'Tên hàng không được chứa ký tự đặc biệt.';
        return empty($errors);
    }

    if (empty($data['dongia'])) {
        $errors['dongia'] = 'Đơn giá không được để trống.';
    } elseif (!preg_match($numberPattern, $data['dongia'])) {
        $errors['dongia'] = 'Đơn giá phải là số.';
        return empty($errors);
    }

    if (empty($data['soluong'])) {
        $errors['soluong'] = 'Số lượng không được để trống.';
        return empty($errors);
    } elseif (!preg_match($numberPattern, $data['soluong'])) {
        $errors['soluong'] = 'Số lượng phải là số.';
        return empty($errors);
    }

    if (empty($data['donvitinh'])) {
        $errors['donvitinh'] = 'Đơn vị tính không được để trống.';
        return empty($errors);
    } elseif (preg_match($specialCharPattern, $data['donvitinh'])) {
        $errors['donvitinh'] = 'Đơn vị tính không được chứa ký tự đặc biệt.';
        return empty($errors);
    }

    if (empty($data['mancc'])) {
        $errors['mancc'] = 'Mã nhà cung cấp không được để trống.';
        return empty($errors);
    }
    
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
        $mahang = strtoupper(trim($_POST['mahang'] ?? ''));
        $tenhang = ucwords(strtolower(trim($_POST['tenhang'] ?? '')));
        $dongia = trim($_POST['dongia'] ?? '');
        $soluong = trim($_POST['soluong'] ?? '');
        $donvitinh = ucwords(strtolower(trim($_POST['donvitinh'] ?? '')));
        $mancc = trim($_POST['mancc'] ?? '');

        $formData = [
            'mahang' => $mahang,
            'tenhang' => $tenhang,
            'dongia' => $dongia,
            'soluong' => $soluong,
            'donvitinh' => $donvitinh,
            'mancc' => $mancc,
        ];
        
        
        if ($action == 'Thêm') {
            $result = $bll->getmahang($mahang);
            if (validateForm($formData)) {
                if ($result->num_rows > 0) {
                    echo "<script>alert('Mã hàng đã tồn tại!');</script>";
                } else {
                    if ($bll->addHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc)) {
                        echo "<script>alert('Thêm hàng thành công!');</script>";
                    } else {
                        echo "<script>alert('Thêm hàng thất bại!');</script>";
                    }
                }
            } else {
                // Display validation errors
                foreach ($errors as $field => $error) {
                    echo "<script>alert('$error');</script>";
                }
            }
            
        } elseif ($action == 'Sửa') {
            $result = $bll->getmahang($mahang);
            if (validateForm($formData)) {
                if ($result->num_rows > 0) {
                    if ($bll->editHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc)) {
                        echo "<script>alert('Sửa hàng thành công!');</script>";
                    } else {
                        echo "<script>alert('Sửa hàng thất bại!');</script>";
                    }
                } else {
                    echo "<script>alert('Mã hàng không tồn tại!');</script>";
                }
            } else {
                // Display validation errors
                foreach ($errors as $field => $error) {
                    echo "<script>alert('$error');</script>";
                }
            }
            
        } elseif ($action == 'Xóa') {
            $result = $bll->getmahang($mahang);
            if (validateForm($formData)) {
                if ($result->num_rows > 0) {
                    if ($bll->removeHangHoa($mahang)) {
                        echo "<script>alert('Xóa hàng thành công!');</script>";
                    } else {
                        echo "<script>alert('Xóa hàng thất bại!');</script>";
                    }
                } else {
                    echo "<script>alert('Mã hàng không tồn tại!');</script>";
                }
            } else {
                // Display validation errors
                foreach ($errors as $field => $error) {
                    echo "<script>alert('$error');</script>";
                }
            }
            
        }
    }
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $result = $bll->getHangHoa($search);
?>

<form style="margin-top:50px;margin-left:100px" method="post">
    <label style="font-size: 20px;">Mã hàng:</label>
    <input type="text" id="mahang" name="mahang" style="width: 180px" value="<?php echo isset($mahang) ? $mahang : ''; ?>">
    <label style="font-size: 20px;margin-left:80px">Tên hàng:</label>
    <input type="text" id="tenhang" name="tenhang" style="width: 180px" value="<?php echo isset($tenhang) ? $tenhang : ''; ?>">
    <br><br>
    <label style="font-size: 20px;">Đơn giá:</label>
    <input type="text" id="dongia" name="dongia" style="width: 180px;margin-left:6px" value="<?php echo isset($dongia) ? $dongia : ''; ?>">
    <label style="font-size: 20px;margin-left:80px">Số lượng:</label>
    <input type="text" id="soluong" name="soluong" style="width: 180px;margin-left:2px" value="<?php echo isset($soluong) ? $soluong : ''; ?>">
    <br><br>
    <label style="font-size: 20px;">Đơn vị tính:</label>
    <input type="text" id="donvitinh" name="donvitinh" style="width: 158px;margin-left:0px" value="<?php echo isset($donvitinh) ? $donvitinh : ''; ?>">
    <label style="font-size: 20px;margin-left:80px">Mã NCC:</label>
    <select id="mancc" name="mancc" style="width: 180px;margin-left:2px">
        <?php
        if ($suppliers->num_rows > 0) {
            while ($row = $suppliers->fetch_assoc()) {
                $selected = isset($mancc) && $mancc == $row['mancc'] ? 'selected' : '';
                echo "<option value='" . $row["mancc"] . "' $selected>" . $row["mancc"] . "</option>";
            }
        }
        ?>
    </select>
    <br><br><br>
    <div class="search-bar">
        <button type="submit" name="action" value="Thêm" class="btn" style="margin-right: 100px;margin-left: 80px;">Thêm</button>
        <button type="submit" name="action" value="Sửa" class="btn" style="margin-right: 100px;">Sửa</button>
    </div>
</form>

<div style="margin-top:50px;margin-left:20px;margin-right:20px">
    <table border="1" cellpadding="auto" cellspacing="auto" style="border: 0px solid black;text-align: center;border-collapse: collapse">
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
                echo "<td>" . strtoupper($row["mahang"]) . "</td>";
                echo "<td>" . ucwords(strtolower($row["tenhang"])) . "</td>";
                echo "<td>" . $row["dongia"] . "</td>";
                echo "<td>" . $row["soluong"] . "</td>";
                echo "<td>" . ucwords(strtolower($row["donvitinh"])) . "</td>";
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