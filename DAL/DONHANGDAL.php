<?php
class DONHANGDAL{
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        // Close connection
        $this->conn->close();
    }

    public function getAllDonHang() {
        $sql = "SELECT madonhang,mahang,nguoidathang,soluong,ngaydathang,loai FROM donhang";
        return $this->conn->query($sql);
    }

    public function searchDonHang($search) {
        $sql = "SELECT madonhang,mahang,nguoidathang,soluong,ngaydathang,loai FROM donhang WHERE madonhang LIKE '%$search%'";
        return $this->conn->query($sql);
    }

    public function insertDonHang($madonhang, $mahang, $nguoidathang, $soluong, $ngaydathang, $loai) {
        $sql = "INSERT INTO donhang VALUES ('$madonhang', '$mahang', '$nguoidathang', '$soluong', '$ngaydathang', '$loai')";
        return $this->conn->query($sql);
    }

    public function updateHangHoa($madonhang, $soluong, $ngaydathang, $loai) {
        $sql = "UPDATE donhang SET soluong='$soluong', ngaydathang='$ngaydathang',loai='$loai' WHERE madonhang='$madonhang'";
        return $this->conn->query($sql);
    }

    public function getmadonhang($madonhang) {
        $sql = "SELECT * FROM donhang WHERE madonhang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $madonhang);
        $stmt->execute();
        return $stmt->get_result();
    }
    
}
?>
