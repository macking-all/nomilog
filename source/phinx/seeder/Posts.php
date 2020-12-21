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
            $insertData[] = [
                //みんなが修正する部分
                //ここにcsvのデータをつける読み込んでインサートの元ネタ作るコードを書く
                "pub_name"=>$data[1],
                "comment"=>$data[2],
                "user_id"=>$data[3],
                "cook_id"=>$data[4],
                "area_id"=>$data[5],
                "price_id"=>$data[6],
                "created"=>$data[7],
                "updated"=>$data[8],
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