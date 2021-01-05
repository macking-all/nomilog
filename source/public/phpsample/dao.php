<?php
class DAO
{
	private $dsn = 'mysql:host=nomilog_nldb_1;dbname=nomilog;port=3306';
	private $user = 'root';
	private $pass = 'root';
	private $dbh = null;

	public function __construct(){
		try{
			$this->dbh = new PDO($this->dsn,$this->user,$this->pass);
		}
		catch(Error $e){
			throw new Error("接続できないよ");
		}
	}
	public function __destruct(){
		$this->dbh = null;
	}
			
	public function Query(string $sql,array $condition = null){
		if($this->dbh == null) return false;
		$st = $this->dbh->prepare($sql);
		$st->execute($condition);
		return $st;
	}
}
?>