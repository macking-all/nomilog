<?php
namespace nomilog\controllers;

class baseController {

    function __construct($r) {
        error_log("parent __construct");
        //パラメータをセッションに積み替える
        $_SESSION["__CURRENT"] = [];
        var_dump($r);
        foreach($r as $k => $v) {
            error_log("{$k}=>{$v}");
            $f = ($k == "ACTION" && $v == null);
            $_SESSION["__CURRENT"][$k] = $f?"default":$v;
            error_log(var_dump($_SESSION["__CURRENT"][$k]));
        }

    }
    protected function define($action) {
        error_log("{$action}");
        return $_SESSION["__CURRENT"]["ACTION"] == $action ? self : null;
    }

    protected function action($method) {
        error_log("{$method}");
        $ref_act = array(self, $method);
        $ref_act();
        return self;
    }

    protected function html($path) {
        // VIEWへと転送をかける
        error_log("{$path}");
        header('Location: ./' . $path, true , 301);
        // 出力を終了
        exit;
    }

    protected function json($data) {
        header("Content-Type: application/json; charset=UTF-8"); 
        echo json_encode($data);
        exit;  
    }
}
?>