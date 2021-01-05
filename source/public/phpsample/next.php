<?php
	include 'session.php';
?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<input type="button" value="戻る" id="back" />
	<input type="button" value="ログアウト" id="logout" />
	<p>セッション維持できてそう</p>
	<ul>
		<li><a href="start.php">戻る</a></li>
		<li><a href="login.html">ログアウト</a></li>
	</ul>

<script type="text/javascript" src="/js/jquery-3.4.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#back").click(function(){
		location.href = "start.php";
	});
	$("#logout").click(function(){
		location.href = "login.html";
	});
});
</script>
</body>
</html>