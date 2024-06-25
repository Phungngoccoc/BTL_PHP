<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Giao Diện Trang Chủ</title>
<link rel="stylesheet" href="quanlyhanghoaa.css">
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
        document.getElementById('madonhang').value = cells[0].innerText;
        document.getElementById('mahang').value = cells[1].innerText;
        document.getElementById('nguoidathang').value = cells[2].innerText;
        document.getElementById('soluong').value = cells[3].innerText;
        document.getElementById('ngaydathang').value = cells[4].innerText;
        document.getElementById('loai').value = cells[5].innerText;
    }
</script>
</head>
<body>
<header>
    <h1>QUẢN LÝ ĐƠN HÀNG</h1>
</header>
<div class="search-bar">
    <form method="post">
        <input type="text" name="search" placeholder="Nhập mã đơn hàng" style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">
        <button type="submit" name="action" value="Tìm">Tìm</button>
    </form>
</div>

<?php
include "../BLL/DONHANGBLL.php";
include "../BLL/NCCBLL.php";
include "../BLL/HANGHOABLL.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlyhanghoa";

$bll = new DONHANGBLL($servername, $username, $password, $dbname);
$a = new NCCBLL($servername, $username, $password, $dbname);
$b = new HANGHOABLL($servername, $username, $password, $dbname);
$mncc = $a->getAllNhaCungCap();
$mh = $b->getAllMaHangHoa();


function validateForm($data) {
    global $errors;
    
    // Special characters pattern
    $specialCharPattern = '/[!@#\$%\^\&*\)\(+=._-]+/';
    // Number pattern
    $numberPattern = '/^[0-9]+$/';
    
    if (empty($data['madonhang'])) {
        $errors['madonhang'] = 'Mã hàng không được để trống.';
        return empty($errors);
    } elseif (preg_match($specialCharPattern, $data['madonhang']) || strpos($data['madonhang'], ' ') !== false) {
        $errors['madonhang'] = 'Mã hàng không được chứa ký tự đặc biệt hoặc khoảng trắng.';
        return empty($errors);
    }else if(strlen($data['madonhang']) > 5)
    {
        $errors['mahang'] = 'Mã hàng không được dài hơn 5 kí tự.';
        return empty($errors);
    }

    if (empty($data['nguoidathang'])) {
        $errors['nguoidathang'] = 'Tên hàng không được để trống.';
        return empty($errors);
    } elseif (preg_match($specialCharPattern, $data['nguoidathang'])) {
        $errors['nguoidathang'] = 'Tên hàng không được chứa ký tự đặc biệt.';
        return empty($errors);
    }

    if ($data['soluong'] == 0) {
        $errors['soluong'] = 'Số lượng phải lớn hơn 0.';
        return empty($errors);
    } elseif (empty($data['soluong']) ) {
        $errors['soluong'] = 'Số lượng không được để trống.';
        return empty($errors);
    }elseif (!preg_match($numberPattern, $data['soluong'])) {
        $errors['soluong'] = 'Số lượng phải không hợp lệ.';
        return empty($errors);
    }

    if($data['ngaydathang'] == '1970/01/01')
    {
        $errors['ngaydathang'] = 'Chưa chọn ngày đặt hàng.';
        return empty($errors);
    }



    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $madonhang = strtoupper(trim($_POST['madonhang'] ?? ''));
    $mahang = strtoupper(trim($_POST['mahang'] ?? ''));
    $nguoidathang = ucwords(strtolower(trim($_POST['nguoidathang'] ?? '')));
    $soluong = trim($_POST['soluong'] ?? '');
    $ngaydathang = trim($_POST['ngaydathang'] ?? '');
    $ngaydathang = date('Y/m/d', strtotime($ngaydathang));
    $loai = trim($_POST['loai'] ?? '');

    $formData = [
        'madonhang' => $madonhang,
        'mahang' => $mahang,
        'nguoidathang' => $nguoidathang,
        'soluong' => $soluong,
        'ngaydathang' => $ngaydathang,
        'loai' => $loai,
    ];

    if ($action == 'Thêm') {
        $result = $bll->getmadonhang($madonhang);
        if (validateForm($formData)) {
            if ($result->num_rows > 0) {
                echo "<script>alert('Mã đơn hàng đã tồn tại!');</script>";
            } else {
                if ($loai == 'Nhập') {
                    $b->updateSoLuongHangHoa($mahang, $soluong);
                    if ($bll->addDonHang($madonhang, $mahang, $nguoidathang, $soluong, $ngaydathang, $loai)) {
                        echo "<script>alert('Thêm hàng thành công!');</script>";
                    } else {
                        echo "<script>alert('Thêm hàng thất bại!');</script>";
                    }
                } elseif ($loai == 'Xuất') {
                    $currentQuantity = $b->getSoLuongHangHoa($mahang);
                    if ($currentQuantity >= $soluong) {
                        $b->updateSoLuongHangHoa($mahang, -$soluong);
                        if ($bll->addDonHang($madonhang, $mahang, $nguoidathang, $soluong, $ngaydathang, $loai)) {
                            echo "<script>alert('Thêm hàng thành công!');</script>";
                        } else {
                            echo "<script>alert('Thêm hàng thất bại!');</script>";
                        }
                    } else {
                        echo "<script>alert('Số lượng hàng không đủ để xuất!');</script>";
                    }
                }
            }
        } else {
            foreach ($errors as $field => $error) {
                echo "<script>alert('$error');</script>";
            }
        }
    } elseif ($action == 'Sửa') {
        $result = $bll->getDonHang($madonhang);
        if (validateForm($formData)) {
            if ($result->num_rows > 0) {
                // Lấy thông tin đơn hàng hiện tại
                $currentDonHang = $result->fetch_assoc();
                $originalQuantity = $currentDonHang['soluong'];
                $originalLoai = $currentDonHang['loai'];
                $originalMahang = $currentDonHang['mahang'];
                $currentQuantity = $b->getSoLuongHangHoa($mahang);
    
                // Kiểm tra mã hàng có bị thay đổi hay không
                if ($originalMahang != $mahang) {
                    // Nếu mã hàng thay đổi, xử lý số lượng cho mã hàng cũ và mới
                    if ($originalLoai == 'Nhập') {
                        $b->updateSoLuongHangHoa($originalMahang, -$originalQuantity); // Giảm số lượng của mã hàng cũ
                    } elseif ($originalLoai == 'Xuất') {
                        $b->updateSoLuongHangHoa($originalMahang, $originalQuantity); // Tăng số lượng của mã hàng cũ
                    }
    
                    // Cập nhật số lượng cho mã hàng mới
                    if ($loai == 'Nhập') {
                        $b->updateSoLuongHangHoa($mahang, $soluong); // Tăng số lượng của mã hàng mới
                    } elseif ($loai == 'Xuất') {
                        $b->updateSoLuongHangHoa($mahang, -$soluong); // Giảm số lượng của mã hàng mới
                    }
                } else {
                    // Kiểm tra loại đơn hàng và cập nhật số lượng hàng hóa
                    if ($originalLoai == 'Nhập') {
                        if ($loai == 'Nhập') {
                            $b->updateSoLuongHangHoa($mahang, $soluong - $originalQuantity);
                        } elseif ($loai == 'Xuất') {
                            $b->updateSoLuongHangHoa($mahang, -$soluong - $originalQuantity);
                        }
                    } elseif ($originalLoai == 'Xuất') {
                        if ($loai == 'Nhập') {
                            $b->updateSoLuongHangHoa($mahang, $soluong + $originalQuantity);
                        } elseif ($loai == 'Xuất') {
                            $b->updateSoLuongHangHoa($mahang, $originalQuantity - $soluong);
                        }
                    }
                }
    
                // Kiểm tra số lượng hàng hóa có đủ để xuất không
                if ($loai == 'Xuất' && $currentQuantity < $soluong) {
                    echo "<script>alert('Số lượng hàng không đủ để xuất!');</script>";
                    // Hoàn tác cập nhật số lượng hàng hóa
                    if ($originalMahang != $mahang) {
                        if ($originalLoai == 'Nhập') {
                            $b->updateSoLuongHangHoa($originalMahang, $originalQuantity); // Khôi phục số lượng của mã hàng cũ
                        } elseif ($originalLoai == 'Xuất') {
                            $b->updateSoLuongHangHoa($originalMahang, -$originalQuantity); // Khôi phục số lượng của mã hàng cũ
                        }
                        if ($loai == 'Nhập') {
                            $b->updateSoLuongHangHoa($mahang, -$soluong); // Khôi phục số lượng của mã hàng mới
                        } elseif ($loai == 'Xuất') {
                            $b->updateSoLuongHangHoa($mahang, $soluong); // Khôi phục số lượng của mã hàng mới
                        }
                    } else {
                        if ($originalLoai == 'Nhập') {
                            if ($loai == 'Nhập') {
                                $b->updateSoLuongHangHoa($mahang, $originalQuantity - $soluong);
                            } elseif ($loai == 'Xuất') {
                                $b->updateSoLuongHangHoa($mahang, $soluong + $originalQuantity);
                            }
                        } elseif ($originalLoai == 'Xuất') {
                            if ($loai == 'Nhập') {
                                $b->updateSoLuongHangHoa($mahang, -$soluong - $originalQuantity);
                            } elseif ($loai == 'Xuất') {
                                $b->updateSoLuongHangHoa($mahang, $soluong - $originalQuantity);
                            }
                        }
                    }
                } else {
                    if ($bll->editDonHang($madonhang, $soluong, $ngaydathang, $loai)) {
                        echo "<script>alert('Sửa đơn hàng thành công!');</script>";
                    } else {
                        echo "<script>alert('Sửa đơn hàng thất bại!');</script>";
                        // Hoàn tác cập nhật số lượng hàng hóa
                        if ($originalMahang != $mahang) {
                            if ($originalLoai == 'Nhập') {
                                $b->updateSoLuongHangHoa($originalMahang, $originalQuantity); // Khôi phục số lượng của mã hàng cũ
                            } elseif ($originalLoai == 'Xuất') {
                                $b->updateSoLuongHangHoa($originalMahang, -$originalQuantity); // Khôi phục số lượng của mã hàng cũ
                            }
                            if ($loai == 'Nhập') {
                                $b->updateSoLuongHangHoa($mahang, -$soluong); // Khôi phục số lượng của mã hàng mới
                            } elseif ($loai == 'Xuất') {
                                $b->updateSoLuongHangHoa($mahang, $soluong); // Khôi phục số lượng của mã hàng mới
                            }
                        } else {
                            if ($originalLoai == 'Nhập') {
                                if ($loai == 'Nhập') {
                                    $b->updateSoLuongHangHoa($mahang, $originalQuantity - $soluong);
                                } elseif ($loai == 'Xuất') {
                                    $b->updateSoLuongHangHoa($mahang, $soluong + $originalQuantity);
                                }
                            } elseif ($originalLoai == 'Xuất') {
                                if ($loai == 'Nhập') {
                                    $b->updateSoLuongHangHoa($mahang, -$soluong - $originalQuantity);
                                } elseif ($loai == 'Xuất') {
                                    $b->updateSoLuongHangHoa($mahang, $soluong - $originalQuantity);
                                }
                            }
                        }
                    }
                }
            } else {
                echo "<script>alert('Đơn hàng không tồn tại!');</script>";
            }
        } else {
            // Hiển thị lỗi xác thực
            foreach ($errors as $field => $error) {
                echo "<script>alert('$error');</script>";
            }
        }
    }
    
}
    
$search = isset($_POST['search']) ? $_POST['search'] : '';
    $result = $bll->getDonHang($search);
?>

<form style="margin-top:50px; margin-left:100px" method="post">
    <label style="font-size: 20px;">Mã đơn hàng:</label>
    <input type="text" id="madonhang" name="madonhang" style="width: 150px;margin-left:19px;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    <label style="font-size: 20px; margin-left:80px">Mã hàng:</label>
    <select id="mahang" name="mahang" style="width: 150px;margin-left:10px;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    <?php
            if ($mh->num_rows > 0) {
                while ($row = $mh->fetch_assoc()) {
                    $selected = isset($mahang) && $mahang == $row['mahang'] ? 'selected' : '';
                    echo "<option value='" . $row["mahang"] . "' $selected>" . $row["mahang"] . "</option>";
                }
            }
        ?>
    </select>
    <br><br>
    <label style="font-size: 20px;">Người đặt hàng:</label>
    <input type="text" id="nguoidathang" name="nguoidathang" style="width: 150px;;font-size: 18px;font-family: 'Times New Roman', Times, serif; ">
    <label style="font-size: 20px; margin-left:80px">Số lượng:</label>
    <input type="text" id="soluong" name="soluong" style="width: 150px; margin-left:10px;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    <br><br>
    <label style="font-size: 20px;">Ngày đặt hàng:</label>
    <input type="date" id="ngaydathang" name="ngaydathang" style="width: 150px ; margin-left:8px;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    <label style="font-size: 20px; margin-left:80px">Loại:</label>
    <select id="loai" name="loai" style="width: 150px; margin-left:45px;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
        <option>Nhập</option>
        <option>Xuất</option>
    </select>
    <br><br>
    <div class="search-bar">
        <button type="submit" name="action" value="Thêm" class="btn" style="margin-right: 200px; margin-left: 120px;">Thêm</button>
        <button type="submit" name="action" value="Sửa" class="btn" style="margin-right: 100px;">Sửa</button>
    </div>
</form>

<div style="margin-top:50px; margin-left:20px; margin-right:20px;overflow-y: auto;height: 250px;">
    <table border="1" cellpadding="auto" cellspacing="auto" style="border: 0px solid black; text-align: center; border-collapse: collapse">
        <tr>
            <th style="width:100px; background-color: #4CAF50; color: white;">Mã đơn hàng</th>
            <th style="width:300px; background-color: #4CAF50; color: white">Mã hàng</th>
            <th style="width:200px; background-color: #4CAF50; color: white">Người đặt hàng</th>
            <th style="width:200px; background-color: #4CAF50; color: white">Số lượng</th>
            <th style="width:200px; background-color: #4CAF50; color: white">Ngày đặt hàng</th>
            <th style="width:100px; background-color: #4CAF50; color: white">Loại</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='selectRow(this)'>";
                echo "<td>" . $row["madonhang"] . "</td>";
                echo "<td>" . $row["mahang"] . "</td>";
                echo "<td>" . $row["nguoidathang"] . "</td>";
                echo "<td>" . $row["soluong"] . "</td>";
                echo "<td>" . $row["ngaydathang"] . "</td>";
                echo "<td>" . $row["loai"] . "</td>";
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
