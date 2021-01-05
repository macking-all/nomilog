<?php
require("../../controllers/sampleController.php");
use nomilog\controllers\sampleController;
var_dump($_REQUEST);
$instance = new sampleController($_REQUEST);
$instance->postAction();
?>