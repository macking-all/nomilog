<?php
require "../nlfw/dao/baseDao.php";
require "../nlfw/config/daoConfig.php";

use nlfw\dao\baseDao;
use nlfw\dao\daoConfig;

class baseModel extends baseDao {
    //コンストラクタ
    //クラスのインスタンスが生成される時に動作する
    function __construct() {
        parent::connect(daoConfig::DSN,daoConfig::DB_USER,daoConfig::DB_PWD);
    }
    //デストラクタ
    //インスタンスが破棄されるときに動作する
    function __destruct() {
        parent::disconnect();
    }

    public function select() {
        return parent::select();
    }

    public function update() {
        return parent::execute();
    }

    public function insert() {
        return parent::execute();
    }
    
    public function delete() {
        return parent::execute();
    }
}

?>