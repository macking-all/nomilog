<?php

	require 'dao.php';
	$msg = "";
	$user = "";
	$pass = "";
	$user_warn = "";
	$pass_warn = "";
	$url = parse_url($_SERVER['HTTP_REFERER']);
	if($url['host'] === 'localhost' && $url['path'] === "/login.php" && filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
		try{
			$user = filter_input(INPUT_POST,"user");
			$pass = filter_input(INPUT_POST,"pass");
			
			if($user == "") {
				$user_warn = "<span class=\"warn\">アカウントは必須入力です</span>";
			}
			if($pass == "") {
				$pass_warn = "<span class=\"warn\">パスワードは必須入力です</span>";
			}
			
			if($user_warn == "" && $pass_warn == "") {
				$dao = new DAO();
				$sql = 'select name,pass from public.user where name = ?';
				$state = $dao->Query($sql,array($user));
				$count = 0;
				$msg = "";
				if($state->rowCount() === 1) {
					$row = $state->fetch(PDO::FETCH_ASSOC);
					if(password_verify($pass,$row["pass"])){
						//ログイン成功時の処理
						$msg .= "ログイン成功した気がする";
						session_start();
						session_regenerate_id (true);
						$_SESSION['login_user'] = $row["name"];
						http_response_code(301);
						header('location:start.php');
						exit;
					} else {
						//失敗
						$msg .= "<p>だめだこりゃ</p>";
					}
				} else if($state->rowCount() === 0) {
					$msg .= "<p>だめだこりゃ</p>";
				} else {
					$msg = "<p>ユーザ重複</p>";		
				}
			}
		} catch(Error $e) {
			$msg = "<p>" . $e->getMessage() . "</p>";
		} finally {
			$dao = null;
		}
	}

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ログイン</title>
</head>
<body>
	<h1>ログイン</h1>
	<?=$msg?>
	<form action="login.php" method="post">
		<label for="user">アカウント</label><input type="text" name="user" id="user" value="<?=$user?>" /><?=$user_warn?><br />
		<label for="pass">パスワード</label><input type="password" name="pass" id="pass"  /><?=$pass_warn?><br />
		<input type="submit" value="ログイン" id="login" /><br />
	</form>
	<p id="message"></p>

</body>
</html>