<?php
include "../DAL/DONHANGDAL.php";

class DONHANGBLL {
    private $dal;

    public function __construct($servername, $username, $password, $dbname) {
        $this->dal = new DONHANGDAL($servername, $username, $password, $dbname);
    }

    public function getDonHang($search) {
        if (!empty($search)) {
            return $this->dal->searchDonHang($search);
        } else {
            return $this->dal->getAllDonHang();
        }
    }

    

    public function getmadonhang($mahang) {
        return $this->dal->getmadonhang($mahang);
    }

    public function addDonHang($madonhang, $mahang, $nguoidathang, $soluong, $ngaydathang, $loai) {
        return $this->dal->insertDonHang($madonhang, $mahang, $nguoidathang, $soluong, $ngaydathang, $loai);
    }

    public function editDonHang($madonhang, $soluong, $ngaydathang, $loai) {
        return $this->dal->updateHangHoa($madonhang, $soluong, $ngaydathang, $loai);
    }
    

    
    
}
?>
