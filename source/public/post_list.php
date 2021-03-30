<?php

require './dbconnect.php';
require './functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

$sql = 'select 
          Posts.pub_name,
          Posts.comment,
          Posts.created,
          MCook.cook_name,
          MArea.area_name,
          MPrice.price_range
          from Posts
        left join
          Mcook on Posts.cook_id = MCook.cook_id
        left join 
          MArea on Posts.area_id = MArea.area_id
        left join 
          MPrice on Posts.price_id = MPrice.price_id
          order by Posts.created desc';

$stmt = $dbs->query($sql);
$posts = $stmt->fetchAll();

foreach($posts as $post)
$posts_list .= '<div class="l-wrapper_01"><article class="card_01"><div class="card__header_01"><p class="card__title_01">'
            . h($post['pub_name']) . '</p></div><div class="card__body_01">
            <span>ジャンル' .h($post['cook_name']) . '</span>　<span>価格' . h($post['price_range']) . '</span>　<span>地域' . h($post['area_name']) . '</span><br>
            <span>' . h($post['created']) . '</span><p class="card__text2_01">' . h($post['comment']) . '</p></div></article></div>';
?>

<?php include('./common/_header.php'); ?>

<main>
<h1>投稿一覧</h1>

    <div>
      <a href="post.php">新規投稿</a>
    </div>

    <div id="contents">
      <?= $posts_list; ?>
    </div><!--./contents-->

</main>
<?php include('./common/_footer.php'); ?>