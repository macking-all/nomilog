<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] != 'xmlhttprequest')){
	return;
}
	$url = parse_url($_SERVER['HTTP_REFERER']);
	if($url['host'] !== 'localhost' || $_SESSION['login_user'] == '') 
	{
		return;
	}
require 'dao.php';

try{
	$proc = filter_input(INPUT_POST,"proc");
	$message = "";
	$key = filter_input(INPUT_POST,"key");
	$dao = new DAO();
	switch($proc){
		case "search":
			break;
		case "delete":
			$sql = "delete from SampleUser where id=?";
			$dao->Query($sql,array($key));
			$message = "ID:" . $key . " のデータを削除しました。";
			break;
		case "update":
			$sql = "update SampleUser set name = ?, pass = ?, note = ? where id = ?";
			$dao->Query($sql,array(filter_input(INPUT_POST,"name"),password_hash(filter_input(INPUT_POST,"pass"),PASSWORD_DEFAULT ),filter_input(INPUT_POST,"note"),filter_input(INPUT_POST,"key")));
			$message = "ID:" . $key . " のデータを更新しました。";
			break;
		case "insert":
			$id = " (select min(id)+1 id from (select 0 id union all select id from SampleUser) user2 where id+1 not in(select id id from SampleUser)) ";
			$sql = "insert into SampleUser(id,name,pass,note) values(" . $id . " ,?,?,?)";
			$dao->Query($sql,array(filter_input(INPUT_POST,"name"),password_hash(filter_input(INPUT_POST,"pass"),PASSWORD_DEFAULT),filter_input(INPUT_POST,"note")));
			$message = "新規データを登録しました。";
			break;
		default:
			return;
	}
	$sql = "select * from SampleUser order by id";
	$body = "";
	$num = 3;
	$count = 1;
	$state = $dao->Query($sql);
	while($row = $state->fetch(PDO::FETCH_ASSOC)){
		$body .= str_repeat("\t",$num) . "<tr>\r\n";
		$body .= str_repeat("\t",$num+1) . "<td><input type=\"button\" value=\"修正\" id=\"update" . $count . "\" /></td>\r\n";
		$body .= str_repeat("\t",$num+1) . "<td><input type=\"button\" value=\"削除\" id=\"delete" . $count++ . "\" /></td>\r\n";
		foreach($row as $key => $val){
			if($key == "pass") continue;
			$body .= str_repeat("\t",$num + 1) . "<td>" . _h($val) . "</td>\r\n";
		}			
		$body .= str_repeat("\t",$num) . "</tr>\r\n";
	}

	$ret = json_encode(array('return'=>$body,'message'=>$message,'row'=>$state->rowCount()));
	
}catch(Error $e){
	$ret = json_encode(array('return'=>'','message'=>$e->getMessage(),'row'=>-1));
}
finally{
	$dao = null;
}
echo $ret;

function _h($s) {
	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

class pgUser
{
	private $name = "";
	private $pass = "";
	private $note = "";
	function __construct($name,$pass,$note){
		$this->name = $name;
		$this->pass = $pass;
		$this->note = $note;
	}
	
	function __destruct(){
		
	}
	
	function IsRecuire(){
		
	}
	
	function Validate(){
		
	}
}
?>