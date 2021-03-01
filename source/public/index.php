<?php

require './functions.php';

session_start();
//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
  echo 'ようこそ' .  h($_SESSION['EMAIL']) . "さん<br>";
  echo "<a href='/logout.php'>ログアウトはこちら。</a>";
  exit;
}

?>

<?php include('./common/_header.php'); ?>
<body>
  <main>
    <h1>ログイン</h1>
    <div id="contents">
        <form action="login.php" method="post">
          <label for="email">メールアドレス</label>
          <input type="email" name="email">
          <label for="password">パスワード</label>
          <input type="password" name="password">
          <input type="submit" value="ログイン">
        </form>
    </div>
  </main>
<?php include('./common/_footer.php'); ?>