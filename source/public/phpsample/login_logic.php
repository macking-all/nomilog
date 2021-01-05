<?php
header("Content-Type: application/json; charset=UTF-8");
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] != 'xmlhttprequest')){
	return;
}
require "dao.php";
try{
	$name = filter_input(INPUT_POST,"name");
	$pass = filter_input(INPUT_POST,"pass");
	$dao = new DAO();
	$sql = 'select name,pass from SampleUser where name = ?';
	$state = $dao->Query($sql,array($name));
	$count = 0;
	$msg = "";
	$path = "";
	if($state->rowCount() === 1) {
		$row = $state->fetch(PDO::FETCH_ASSOC);
		if(password_verify($pass,$row["pass"])){
			//ログイン成功時の処理
			$msg .= "ログイン成功した気がする";
			$path .= "start.php";
			session_start();
			session_regenerate_id (true);
			$_SESSION['login_user'] = $row["name"];
		} else {
			//失敗
			$msg .= "ログイン失敗";
		}
	} else if($state->rowCount() === 0) {
		$msg .= "だめだこりゃ";
	} else {
		$msg = "ユーザ重複";
	}
	$ret = json_encode(array('message'=>$msg,'url'=>$path));
} catch(Error $e) {
	$ret = json_encode(array('message'=>$e->getMessage(),'url'=>$path));
} finally {
	$dao = null;
}
echo $ret;


?>