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
    public function define($action) {
        return $_SESSION["__CURRENT"]["ACTION"] == $action ? $this : null;
    }

    public function action($method) {
        $ref_act = $method;
        $ref_act();
        return $this;
    }

    public function html($path) {
        include "{$path}";
        // 出力を終了
        exit;
    }

    public function json($data) {
        header("Content-Type: application/json; charset=UTF-8"); 
        echo json_encode($data);
        exit;  
    }
}
?>