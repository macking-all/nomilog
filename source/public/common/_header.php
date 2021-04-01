<?php
  
  //require '../functions.php';
  session_start();

  if(isset($_SESSION['ADMIN_FLAG'])){
    $adFlag = $_SESSION['ADMIN_FLAG'];
  } else {
    $adFlag = NULL;
  }
  
  

  //function menuDisplay(){
    switch($adFlag){
      case NULL:
        $navi = '<ul>
                  <li><a href="../index.php">ログイン</a></li>
                  <li><a href="../signup.php">新規ユーザ登録</a></li>
                  <li><a>ヘルプ</a></li>
                 </ul>';
        break;
      case 0:
        $navi = '<ul>
                  <li><a href="../post_list.php">投稿一覧</a></li>
                  <li><a>ヘルプ</a></li>
                  <li><a href="../logout.php">ログアウト</a></li>
                  <li><a>' . $_SESSION['USER_NAME'] . '</a></li>
                  <li class="icon-img"><img src="../images/' . $_SESSION['ICON_IMAGE'] . '" alt=""></li>
                 </ul>';
        break;
      case 1:
        $navi = '<ul>
                  <li><a href="../post_list.php">投稿一覧</a></li>
                  <li><a href="../management.php">マスタ管理</a></li>
                  <li><a>ヘルプ</a></li>
                  <li><a href="../logout.php">ログアウト</a></li>
                  <li><a>' . $_SESSION['USER_NAME'] . '</a></li>
                  <li class="icon-img"><img src="../images/' . $_SESSION['ICON_IMAGE'] .'" alt=""></li>
                 </ul>';
        break;
    }
  //}

  //menuDisplay(); 

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マスタ管理画面</title>
  <link rel="stylesheet" href="../css/style_m.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css"
    type="text/css" media="all" />
    <script src="../js/jquery-3.5.1.slim.min.js"></script>
</head>

<body>
  <header>
    <div>
      <h2><i class="fas fa-beer fa-lg fa-fw my-white"></i><a href="../post_list.php">呑みログ</a></h2>
    </div>
    <div class="header-list">
    <?= $navi;?>
    </div>
  </header>