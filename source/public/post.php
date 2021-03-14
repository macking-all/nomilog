<?php
    session_start();

    require './dbconnect.php';
    require './functions.php';

    $dbs = new Database();
    $dbs->dbconnect();

    // 各セレクトボックス取得
    $select_cook = selectOption('MCook', 'cook_id', 'cook_name');
    $select_price = selectOption('MPrice', 'price_id', 'price_range');
    $select_area = selectOption('MArea', 'area_id', 'area_name');

    // 投稿ボタンを押された時の処理
    $post = filter_input(INPUT_POST, 'post');
    
    if(isset($post)) {
      $pub_name = filter_input(INPUT_POST, 'pub_name');
      if(!$pub_name)){
        
      }
      $comment = filter_input(INPUT_POST, 'comment');

      // 選択された項目のIDを取得
      if (isset($_POST['select_cook'])) {
        $cook_id = filter_input(INPUT_POST, 'select_cook');
      }
      if (isset($_POST['select_price'])) {
        $price_id = filter_input(INPUT_POST, 'select_price');
      }
      if (isset($_POST['select_area'])) {
        $area_id = filter_input(INPUT_POST, 'select_area');
      }
  
      $sql = 'insert into Posts (
                pub_name, comment, user_id, cook_id, area_id, price_id
              ) values (
                :pub_name, :comment, :user_id, :cook_id, :area_id, :price_id
              )';
      $stmt = $dbs->prepare($sql);
      $stmt->bindValue('pub_name', $pub_name, PDO::PARAM_STR);
      $stmt->bindValue('comment', $comment, PDO::PARAM_STR);
      $stmt->bindValue('user_id', $_SESSION['USER_ID'], PDO::PARAM_INT);
      $stmt->bindValue('cook_id', $cook_id, PDO::PARAM_INT);
      $stmt->bindValue('area_id', $area_id, PDO::PARAM_INT);
      $stmt->bindValue('price_id', $price_id, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: post_list.php');
    }

?>

<?php include('./common/_header.php'); ?>

<body>
<main>
    <h1>新規投稿</h1>
    <div id="post_contents">
        <form action="" method="post">
            <label for="pub_name">店名</label>
            <input type="text" name="pub_name">
            <label for="cook_id">ジャンル</label>
            <select name="select_cook">
              <option value=""></option>
              <?= $select_cook;?>
            </select>
            <label for="price_id">価格</label>
            <select name="select_price">
              <option value=""></option>
            <?= $select_price; ?>
            </select>
            <label for="area_id">地域</label>
            <select name="select_area">
              <option value=""></option>
            <?= $select_area; ?>
            </select>
            <label for="comment">コメント</label>
            <textarea name="comment"></textarea><br>
            <input type="submit" name="post" value="投稿">
        </form>
    </div><!--#/contents-->
</main>

<?php include('./common/_footer.php'); ?>