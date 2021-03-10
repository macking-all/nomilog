<?php

require './dbconnect.php';
require './functions.php';

session_start();
$user_name = $_SESSION['EMAIL'];


?>

<?php include('./common/_header.php'); ?>
<body>
<main>
    <div class="contents">
        <?= $user_name; ?>
    </div>
    </main>
    <?php include('./common/_footer.php'); ?>