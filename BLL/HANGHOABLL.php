<?php
include "../DAL/HANGHOADAL.php";

class HANGHOABLL {
    private $dal;

    public function __construct($servername, $username, $password, $dbname) {
        $this->dal = new HANGHOADAL($servername, $username, $password, $dbname);
    }

    public function getHangHoa($search = '') {
        if ($search) {
            return $this->dal->searchHangHoa($search);
        } else {
            return $this->dal->getAllHangHoa();
        }
    }
    public function getmahang($mahang) {
        return $this->dal->getmahang($mahang);
    }

    public function addHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc) {
        return $this->dal->insertHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc);
    }

    public function editHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc) {
        return $this->dal->updateHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc);
    }

    public function removeHangHoa($mahang) {
        return $this->dal->deleteHangHoa($mahang);
    }
    public function getAllMaHangHoa() {
        return $this->dal->getAllHangHoa();
    }
    public function getSoLuongHangHoa($mahang) {
        return $this->dal->getSoLuongHangHoa($mahang);
    }
    public function updateSoLuongHangHoa($mahang, $soluong)
    {
        return $this->dal->updateSoLuongHangHoa($mahang, $soluong);
    }
}
?>
