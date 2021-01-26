<?php
require("../../controllers/baseController.php");
require("../../controllers/sampleController.php");
use nomilog\controllers\baseController;
use nomilog\controllers\sampleController;

/**
 * とりあえず画面からのPOSTをここで受け取るコントローラー
 * baseCotrollerのメソッドを利用して制御する
 */


$instance = new baseController($_REQUEST);

/*
処理置き場
*/
$instance->define("default")?->html("index.html");
$instance->define("search")?->action("debug")->html("index.html");

function debug(){
    var_dump($_SESSION["__CURRENT"]["ACTION"]);
}

?>