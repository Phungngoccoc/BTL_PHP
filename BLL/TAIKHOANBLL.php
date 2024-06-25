<?php
include "../DAL/TAIKHOANDAL.php";

class TAIKHOANBLL {
    private $taikhoanDAL;

    // Constructor to initialize Data Access Layer
    public function __construct() {
        $this->taikhoanDAL = new TAIKHOANDAL();
    }

    // Function to check and validate user login
    public function loginUser($username, $password) {
        if ($this->taikhoanDAL->validateUser($username, $password)) {
            // Start session and set session variables
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            return true; // Login successful
        } else {
            return false; // Login failed
        }
    }
}
?>
