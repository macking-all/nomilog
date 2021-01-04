<?php
namespace nomilog\controllers;

class baseController {

    function __construct() {
        //パラメータをセッションに積み替える
        $_SESSION["__CURRENT"] = null;

        foreach($_REQUEST as $k => $v) {
            $_SESSION["__CURRENT"][] = [$k => $v];
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