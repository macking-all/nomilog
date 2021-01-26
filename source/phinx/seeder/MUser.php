<?php


use Phinx\Seed\AbstractSeed;

class MUser extends AbstractSeed
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
                "user_name"=>$data[1],
                "email"=>$data[2],
                "email_flag"=>$data[3],
                "icon_image"=>$data[4],
                "password"=>$data[5],
                "admin_flag"=>$data[6],
                "register_user"=>$data[7],
                "created"=>$data[8],
                "updated_user"=>$data[9],
                "updated"=>$data[10],
                "last_login"=>$data[11],
                "delete_flag"=>$data[12],
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