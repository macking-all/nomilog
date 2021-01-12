<?php
namespace nomilog\controllers;
require("baseController.php");
use nomilog\controllers\baseController;
class sampleController extends baseController {
    function __construct($r) {
        error_log("sample __construct");
        parent::__construct($r);
    }

    function postAction(){
        $this->define("default")?->html("index.html");
        $this->define("search")?->action("debug")->html("index.html");
    }

    function debug(){
        var_dump($_SESSION["__CURRENT"]["ACTION"]);
    }
}
?>