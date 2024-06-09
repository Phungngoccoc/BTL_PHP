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

    public function addNhaCungCap($MANCC, $TENNCC, $DIACHINCC) {
        return $this->dal->insertNhaCungCap($MANCC, $TENNCC, $DIACHINCC);
    }

    public function editNhaCungCap($MANCC, $TENNCC, $DIACHINCC) {
        return $this->dal->updateNhaCungCap($MANCC, $TENNCC, $DIACHINCC);
    }

    public function removeNhaCungCap($MANCC) {
        return $this->dal->deleteNhaCungCap($MANCC);
    }
}
