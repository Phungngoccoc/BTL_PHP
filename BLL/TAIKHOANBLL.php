<?php
include "../DAL/TAIKHOANDAL.php";

class TAIKHOANBLL {
    private $taikhoanDAL;

    public function __construct() {
        $this->taikhoanDAL = new TAIKHOANDAL();
    }

    public function loginUser($username, $password) {
        if ($this->taikhoanDAL->validateUser($username, $password)) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            return true; 
        } else {
            return false; 
        }
    }
}
?>
