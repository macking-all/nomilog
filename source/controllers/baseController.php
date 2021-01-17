<?php
namespace nomilog\controllers;

class baseController {

    function __construct($r) {
        error_log("parent __construct");
        //パラメータをセッションに積み替える
        $_SESSION["__CURRENT"] = [];
        foreach($r as $k => $v) {
            error_log("{$k}=>{$v}");
            $f = ($k == "ACTION" && $v == null);
            $_SESSION["__CURRENT"][$k] = $f ? "default" : $v;
        }
    }
    protected function define($action) {
        return $_SESSION["__CURRENT"]["ACTION"] == $action ? $this : null;
    }

    protected function action($method) {
        $ref_act = array($this, $method);
        $ref_act();
        return $this;
    }

    protected function html($path) {
        // VIEWへと転送をかける
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