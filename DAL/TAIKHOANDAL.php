<?php
class TAIKHOANDAL {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "quanlyhanghoa";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        $this->conn->close();
    }

    
        public function validateUser($username, $password) {
        if (empty($username) || empty($password) || strpos($username, ' ') !== false || strpos($password, ' ') !== false) {
            return false;
        }

        $sql = "SELECT * FROM taikhoan WHERE tentk = ? AND matkhau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }
}
?>
