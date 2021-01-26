<?php
namespace nomilog\models;
require "../nlfw/dao/baseDao.php";
require "../nlfw/config/daoConfig.php";

use nlfw\dao\baseDao;
use nlfw\dao\daoConfig;

/**
 * データ操作
 */

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

    protected function loadQuery($path) {
        $sql = file_get_contents($path);
        if ($sql === false) {
            throw new \RuntimeException('file not found.');
        }
        return $sql;
    }

    protected function select($sql,$params) {
        return parent::select($sql,$params);
    }

    protected function update($sql,$params) {
        return parent::execute($sql,$params);
    }

    protected function insert($sql,$params) {
        return parent::execute($sql,$params);
    }
    
    protected function delete($sql,$params) {
        return parent::execute($sql,$params);
    }
}

?>