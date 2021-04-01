<?php

require './dbconnect.php';
require './functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

$errs = [];

if(isset($_POST['login'])){
  $email = filter_input(INPUT_POST, 'email');
  $password = filter_input(INPUT_POST, 'password');

  if(!isset($row['email'])){
    $errs .= 'メールアドレス又はパスワードが間違っています。';
  }
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errs .= '入力された値が不正です';
  }

  $sql = 'select * from MUser where email = ?';
  $stmt = $dbs->prepare($sql);
  $stmt->execute(array($email));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if(password_verify($password, $row['password'])){
    session_regenerate_id(true);

    $_SESSION['USER_ID'] = $row['user_id'];
    $_SESSION['USER_NAME'] = $row['user_name'];
    $_SESSION['ICON_IMAGE'] = $row['icon_image'];
    $_SESSION['ADMIN_FLAG'] = $row['admin_flag'];

    header('Location: post_list.php');

  } else {
    $errs .= 'メールアドレス又はパスワードが間違っています。';
  }
  
  foreach($errs as $err){
    $err_msgs .= '<li>' . $err . '</li>';
  }
}
?>

<?php include('./common/_header.php'); ?>

  <main>
    <h1>ログイン</h1>

    <div class="error-message">
      <ul>
        <?= $err_msgs; ?>
      </ul>
    </div>

    <div id="contents">
        <form action="" method="post">
          <label for="email">メールアドレス</label>
          <input type="email" name="email">
          <label for="password">パスワード</label>
          <input type="password" name="password">
          <input type="submit" name="login" value="ログイン">
        </form>
    </div>
  </main>
<?php include('./common/_footer.php'); ?>