<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SampleUser extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->execute(file_get_contents(dirname(__FILE__)."/../sql/".get_class($this).".sql"));
    }
    public function down()
    {
        $this->execute("
			DROP TABLE `SampleUser`;
		");
    }
}
