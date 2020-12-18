<?php


use Phinx\Seed\AbstractSeed;

class Posts extends AbstractSeed
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
        //多重に流しても死なないようにとりあえずtruncate流しておく
        $this->table($this->getName())->truncate();
        foreach ($this->fileGetLines() as $data) {
            $insertData = [
                //みんなが修正する部分
                //ここにcsvのデータをつける読み込んでインサートの元ネタ作るコードを書く
                "last_name"=>$data[1],
                "first_name"=>$data[2],
                "last_kana_name"=>$data[3],
                "first_kana_name"=>$data[4],
                "username"=>$data[5],
                "password"=>$data[6],
                "email"=>$data[7],
                "postcode"=>$data[8],
                "birthday"=>$data[9],
                "description"=>$data[10],
                "created"=>$data[11],
                "updated"=>$data[12],
          ];
            //全部貯めてもメモリが爆発するので1000レコードごとに1回バルクインサートする
            if (count($insertData) >= 1000) {
                $this->insert($this->getName(), $insertData);
                $insertData = [];
            }
        }
        $this->insert($this->getName(), $insertData);
    }
    
    public function fileGetLines() {
        $filepath = dirname(__FILE__)."/../csv/".$this->getName().".csv";
        $flag = true;
        $lines = [];
        $fp = fopen($filepath, "rb");
        while(($line = fgets($fp)) !== false) {
            if($flag) { //先頭行を無視するよ
                $flag = false;
                continue;
            }
            yield explode(",",$line);
        }
        fclose($fp);
    }}