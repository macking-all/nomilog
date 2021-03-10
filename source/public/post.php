<?php
    session_start();

    require './dbconnect.php';
    require './functions.php';

    $dbs = new Database();
    $dbs->dbconnect();

    // 料理ジャンル選択肢取得
    $sql = 'select * from MCook';
    $stmt = $dbs->query($sql);
    $stmt->execute();
    $select_cook_names = $stmt->fetchAll();

    foreach($select_cook_names as $select_cook_name) {
        $select_cook .= '<option value="' . $select_cook_name['cook_id'] .  '">' . $select_cook_name['cook_name'] . '</option>';
    }

    // 価格選択肢取得
    $sql = 'select * from MPrice';
    $stmt = $dbs->query($sql);
    $stmt->execute();
    $select_price_ranges = $stmt->fetchAll();

    foreach($select_price_ranges as $select_price_range) {
        $select_price .= '<input type="checkbox" name="selected_price[]">' . $select_price_range['price_range'] . '　';
    }

    // 地域選択肢取得
    $sql = 'select * from MArea';
    $stmt = $dbs->query($sql);
    $stmt->execute();
    $select_area_names = $stmt->fetchAll();

    foreach($select_area_names as $select_area_name) {
        $select_area .= '<input type="checkbox" name="selected_area[]">' . $select_area_name['area_name'] . '　';
    }

    // 投稿ボタンを押された時の処理
    $post = filter_input(INPUT_POST, 'post');

    // 選択されたチェックボックスを取得
    if (isset($_POST['selected_cook']) && is_array($_POST['selected_cook'])) {
      $selected_cook = implode("、", $_POST['selected_cook']);
    }
    if (isset($_POST['selected_price']) && is_array($_POST['selected_price'])) {
      $selected_cook = implode("、", $_POST['selected_price']);
    }
    if (isset($_POST['selected_area']) && is_array($_POST['selected_area'])) {
      $selected_cook = implode("、", $_POST['selected_area']);
    }

    if(isset($post)) {
      $pub_name = filter_input(INPUT_POST, 'pub_name');
      $comment = filter_input(INPUT_POST, 'comment');
      $user_id = $_SESSION['USER_ID'];
      $cook_id = filter_input(INPUT_POST, 'pub_name');
      $price_id = filter_input(INPUT_POST, 'pub_name');
      $price_id = filter_input(INPUT_POST, 'pub_name');
      $sql = 'insert into Posts (
                pub_name, comment, user_id, cook_id, area_id, price_id
              ) values (
                
              )';
    }
    
    $dbs = null;

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
            <select>
              <option value=""></option>
              <?= $select_cook;?>
            </select>
            <label for="price_id">価格</label>
            <?= $select_price; ?>
            <label for="area_id">地域</label>
            <?= $select_area; ?>
            <label for="comment">コメント</label>
            <textarea name="comment"></textarea><br>
            <input type="submit" name="post" value="投稿">
        </form>
    </div><!--#/contents-->
</main>

<?php include('./common/_footer.php'); ?>