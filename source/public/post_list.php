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
        <div style="margin-top: 300px;">
            <a href="post.php">新規投稿</a>
        </div>
    </div>
    </main>
    <?php include('./common/_footer.php'); ?>