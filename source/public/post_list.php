<?php

require './dbconnect.php';
require './functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

/* ページネーション*/

// 1ページに表示する投稿数設定
define('max_view', 5);

// 必要なページ数を求める
$count = $dbs->prepare('select count(*) as count from posts');
$count->execute();
$total_count = $count->fetch(PDO::FETCH_ASSOC);
$pages = ceil($total_count['count'] / max_view);

// 現在いるページのpage_idを取得
if(!isset($_REQUEST['page_id'])){
  $now = 1;
} else {
  $now = $_REQUEST['page_id'];
}

// 表示する記事を取得するsql
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
          order by Posts.created desc limit :start, :max';

$select_posts = $dbs->prepare($sql);

if($now == 1) {
  // 1ページ目の処理
  $select_posts->bindValue(':start', $now -1, PDO::PARAM_INT);
  $select_posts->bindValue(':max', max_view, PDO::PARAM_INT);
} else {
  // 1ページ目の以外の処理
  $select_posts->bindValue(':start', ($now -1) * max_view, PDO::PARAM_INT);
  $select_posts->bindValue(':max', max_view, PDO::PARAM_INT);
}

$select_posts->execute();
$posts = $select_posts->fetchAll(PDO::FETCH_ASSOC);

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

    <?php
    // ページネーション表示
     for($n = 1; $n <= $pages; $n++){
       if($n == $now) {
         echo '<span style="padding: 5px;">' . $now . '</span>';
       } else {
         echo '<a href="./post_list.php?page_id=' . $n . '" style="padding: 5px;">' . $n . '</a>';
       }
     }
    ?>

</main>
<?php include('./common/_footer.php'); ?>