<?php include('./common/_header.php'); ?>


  <main>
    <div class="main-font">
      <h1><span>マスタ管理画面</span></h1>
    </div>
    <div id="contents">
    <div class="main-button main-button-flex">
      <div class="main-button-layout">
        <a href="./user_master/master.php" class="btn--blue btn--shadow btn--big">ユーザーマスタ</a>
      </div>
      <div class="main-button-layout">
        <a href="./area_master/master.php" class="btn--blue btn--shadow btn--big">地域マスタ</a>
      </div>
      <div class="main-button-layout">
        <a href="./price_master/master.php" class="btn--blue btn--shadow btn--big">価格マスタ</a>
      </div>
      <div class="main-button-layout">
        <a href="./cook_master/master.php" class="btn--blue btn--shadow btn--big">料理ジャンルマスタ</a>
      </div>
    </div>
    </div><!--#/contents-->
  </main>
  <?php include('./common/_footer.php'); ?>