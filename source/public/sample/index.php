<?php
require("../../controllers/sampleController.php");
use nomilog\controllers\sampleController;

$instance = new sampleController($_REQUEST);
$instance->postAction();
?>