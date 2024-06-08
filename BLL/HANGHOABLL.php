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

    public function addHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc) {
        return $this->dal->insertHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc);
    }

    public function editHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc) {
        return $this->dal->updateHangHoa($mahang, $tenhang, $dongia, $soluong, $donvitinh, $mancc);
    }

    public function removeHangHoa($mahang) {
        return $this->dal->deleteHangHoa($mahang);
    }
}
?>
