<?php
class NCCDAL {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $this->conn->connect_error);
        }
    }

    public function getNhaCungCap($search = '') {
        $sql = "SELECT * FROM nhacungcap";
        if (!empty($search)) {
            $sql .= " WHERE TENNCC LIKE '%$search%'";
        }
        $result = $this->conn->query($sql);
        return $result;
    }
    public function getAllNhaCungCap() {
        $sql = "SELECT mancc FROM nhacungcap";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function insertNhaCungCap($MANCC,$TENNCC, $DIACHINCC,$EMAIL) {
        $sql = "INSERT INTO nhacungcap (MANCC,TENNCC, DIACHINCC, EMAIL) VALUES ('$MANCC','$TENNCC', '$DIACHINCC','$EMAIL')";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function updateNhaCungCap($MANCC, $TENNCC, $DIACHINCC,$EMAIL) {
        $sql = "UPDATE nhacungcap SET TENNCC = '$TENNCC', DIACHINCC = '$DIACHINCC',EMAIL='$EMAIL' WHERE MANCC = '$MANCC'";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteNhaCungCap($MANCC) {
        // Bắt đầu giao dịch
        $this->conn->begin_transaction();
    
        try {
            // Xóa các đơn hàng liên quan đến nhà cung cấp
            $sql = "DELETE FROM donhang WHERE MAHANG IN (SELECT MAHANG FROM hanghoa WHERE MANCC = '$MANCC')";
            $this->conn->query($sql);
    
            // Xóa các sản phẩm liên quan đến nhà cung cấp
            $sql = "DELETE FROM hanghoa WHERE MANCC = '$MANCC'";
            $this->conn->query($sql);
    
            // Xóa nhà cung cấp
            $sql = "DELETE FROM nhacungcap WHERE MANCC = '$MANCC'";
            $this->conn->query($sql);
    
            // Commit giao dịch
            $this->conn->commit();
    
            return true;
        } catch (mysqli_sql_exception $e) {
            // Rollback giao dịch nếu có lỗi xảy ra
            $this->conn->rollback();
            throw $e;
        }
    }
    
}
