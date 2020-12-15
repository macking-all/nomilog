<?php


use Phinx\Seed\AbstractSeed;

class UserTest extends AbstractSeed
{
    //いちいちテーブル名とか書くのだるいのでconstで楽するよ
    public function getName() {
        return get_class($this);
    }
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        foreach ($this->fileGetLines(dirname(__FILE__)."/../csv/".$this->getName().".csv") as $data) {
            $row = explode(",",$data);

            $insertData = [
                //みんなが修正する部分
                //ここにcsvのデータをつける読み込んでインサートの元ネタ作るコードを書く
                "last_name"=>$row[1],
                "first_name"=>$row[2],
                "last_kana_name"=>$row[3],
                "first_kana_name"=>$row[4],
                "username"=>$row[5],
                "password"=>$row[6],
                "email"=>$row[7],
                "postcode"=>$row[8],
                "birthday"=>$row[9],
                "description"=>$row[10],
                "created"=>$row[11],
                "updated"=>$row[12],
          ];
            //全部貯めてもメモリが爆発するので1000レコードごとに1回バルクインサートする
            if (count($insertData) >= 1000) {
                $this->insert($this->getName(), $insertData);
                $insertData = [];
            }
        }
        $this->insert($this->getName(), $insertData);
    }
    
    public function fileGetLines($filepath) {
        $flag = true;
        $lines = [];
        $fp = fopen($filepath, "rb");
        while(($line = fgets($fp)) !== false) {
            if($flag) { //先頭行を無視するよ
                $flag = false;
                continue;
            }
            yield $line;
        }
        fclose($fp);
    }}
