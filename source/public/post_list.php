<?php

require './dbconnect.php';
require './functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

$sql = 'select * from Posts';
$stmt = $dbs->query($sql);
$stmt->fetchAll();

?>

<?php include('./common/_header.php'); ?>
<body>
<main>
<h1>新規投稿</h1>

    <div>
      <a href="post.php">新規投稿</a>
    </div>

  <div id="contents">
    <div class="l-wrapper_01">
      <article class="card_01">
      <div class="card__header_01">
        <p class="card__title_01">店名店名店名店名店名店名</p>
      </div>
      <div class="card__body_01">
          <span>ジャンル</span>　<span>価格</span>　<span>地域</span>
        <p class="card__text2_01">コメントコメントコメントコメント</p>
      </div>
      </article>
    </div><!--./l-wrapper_01-->
  </div><!--./contents-->




    </main>
    <?php include('./common/_footer.php'); ?>