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

    public function addNhaCungCap($MANCC, $TENNCC, $DIACHINCC) {
         // Chuẩn hóa dữ liệu trước khi thêm vào cơ sở dữ liệu
         $MANCC = strtoupper(trim($MANCC)); // Chuyển thành chữ hoa và loại bỏ khoảng trắng thừa         
         $TENNCC = ucwords(strtolower(trim($TENNCC))); // Chuẩn hóa chữ cái đầu của mỗi từ viết hoa, các ký tự còn lại viết thường
         $DIACHINCC = ucwords(strtolower(trim($DIACHINCC)));// Chuẩn hóa chữ cái đầu của mỗi từ viết hoa, các ký tự còn lại viết thường
        return $this->dal->insertNhaCungCap($MANCC, $TENNCC, $DIACHINCC);
    }

    public function editNhaCungCap($MANCC, $TENNCC, $DIACHINCC) {
        return $this->dal->updateNhaCungCap($MANCC, $TENNCC, $DIACHINCC);
    }

    public function removeNhaCungCap($MANCC) {
        return $this->dal->deleteNhaCungCap($MANCC);
    }
}
