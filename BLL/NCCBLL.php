<?php
include "../DAL/NCCDAL.php";

class NCCBLL {
    private $dal;

    public function __construct($servername, $username, $password, $dbname) {
        $this->dal = new NCCDAL($servername, $username, $password, $dbname);
    }

    public function getNhaCungCap($search = '') {
        return $this->dal->getNhaCungCap($search);
    }
    public function getAllNhaCungCap() {
        return $this->dal->getAllNhaCungCap();
    }

    public function addNhaCungCap($MANCC, $TENNCC, $DIACHINCC, $EMAIL) {
         // Kiểm tra mã nhà cung cấp đã tồn tại trong database chưa
    if ($this->dal->dalCheckMaNCC($MANCC)) {
        return false; // Trả về false nếu mã nhà cung cấp đã tồn tại
    }
         // Chuẩn hóa dữ liệu trước khi thêm vào cơ sở dữ liệu
         $MANCC = str_replace(" ", "", $MANCC);
         $MANCC = strtoupper(trim($MANCC)); // Chuyển thành chữ hoa và loại bỏ khoảng trắng thừa         
         $TENNCC = ucwords(strtolower(trim($TENNCC))); // Chuẩn hóa chữ cái đầu của mỗi từ viết hoa, các ký tự còn lại viết thường
         $DIACHINCC = ucwords(strtolower(trim($DIACHINCC)));// Chuẩn hóa chữ cái đầu của mỗi từ viết hoa, các ký tự còn lại viết thường
         $EMAIL=trim($EMAIL);
        return $this->dal->insertNhaCungCap($MANCC, $TENNCC, $DIACHINCC, $EMAIL);
    }

    public function editNhaCungCap($MANCC, $TENNCC, $DIACHINCC, $EMAIL) {
        $MANCC = str_replace(" ", "", $MANCC);
        $MANCC = strtoupper(trim($MANCC)); // Chuyển thành chữ hoa và loại bỏ khoảng trắng thừa         
         $TENNCC = ucwords(strtolower(trim($TENNCC))); // Chuẩn hóa chữ cái đầu của mỗi từ viết hoa, các ký tự còn lại viết thường
         $DIACHINCC = ucwords(strtolower(trim($DIACHINCC)));// Chuẩn hóa chữ cái đầu của mỗi từ viết hoa, các ký tự còn lại viết thường
         $EMAIL=trim($EMAIL);
        return $this->dal->updateNhaCungCap($MANCC, $TENNCC, $DIACHINCC, $EMAIL);
    }

    public function removeNhaCungCap($MANCC) {
        return $this->dal->deleteNhaCungCap($MANCC);
    }
}
