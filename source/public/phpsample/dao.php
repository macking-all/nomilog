<?php
class DAO
{
	private $dsn = 'pgsql:dbname=postgres host=localhost port=5432';
	private $user = 'macking';
	private $pass = 'iammacking';
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