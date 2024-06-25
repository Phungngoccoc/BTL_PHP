<?php
class TAIKHOANDAL {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "quanlyhanghoa";
    private $conn;

    // Constructor to establish database connection
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Destructor to close database connection
    public function __destruct() {
        $this->conn->close();
    }

    // Function to validate username and password
    public function validateUser($username, $password) {
        // Check for empty or invalid characters
        if (empty($username) || empty($password) || strpos($username, ' ') !== false || strpos($password, ' ') !== false) {
            return false;
        }

        // Validate user in the database
        $sql = "SELECT * FROM taikhoan WHERE tentk = ? AND matkhau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; // User validated successfully
        } else {
            return false; // User not found or invalid credentials
        }
    }
}
?>
