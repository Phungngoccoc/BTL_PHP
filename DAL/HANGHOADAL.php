<?php
class HANGHOADAL {
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

    public function getAllHangHoa() {
        $sql = "SELECT mahang, tenhang, dongia, soluong, donvitinh, mancc FROM hanghoa";
        return $this->conn->query($sql);
    }

    public function searchHangHoa($search) {
        $sql = "SELECT mahang, tenhang, dongia, soluong, donvitinh, mancc FROM hanghoa WHERE tenhang LIKE '%$search%'";
        return $this->conn->query($sql);
    }

    public function insertHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc) {
        $sql = "INSERT INTO hanghoa (mahang, tenhang, dongia, soluong, donvitinh, mancc) VALUES ('$mahang', '$tenhang', '$dongia', '$soluong', '$donvitinh', '$mancc')";
        return $this->conn->query($sql);
    }

    public function updateHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc) {
        $sql = "UPDATE hanghoa SET tenhang='$tenhang', dongia='$dongia', soluong='$soluong', donvitinh='$donvitinh', mancc='$mancc' WHERE mahang='$mahang'";
        return $this->conn->query($sql);
    }

    public function deleteHangHoa($mahang) {
        $sql = "DELETE FROM hanghoa WHERE mahang='$mahang'";
        return $this->conn->query($sql);
    }

    public function getmahang($mahang) {
        $sql = "SELECT * FROM hanghoa WHERE mahang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $mahang);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAllMaHangHoa() {
        $sql = "SELECT mahang FROM hanghoa";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getSoLuongHangHoa($mahang) {
        $sql = "SELECT soluong FROM hanghoa WHERE mahang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $mahang);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['soluong'];
        } else {
            return 0;
        }
    }

    public function updateSoLuongHangHoa($mahang, $soluong) {
        // First, get the current quantity
        $currentQuantity = $this->getSoLuongHangHoa($mahang);

        // Calculate the new quantity
        $newQuantity = $currentQuantity + $soluong;

        // Update the quantity in the database
        $sql = "UPDATE hanghoa SET soluong = ? WHERE mahang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $newQuantity, $mahang);
        return $stmt->execute();
    }
}
?>
