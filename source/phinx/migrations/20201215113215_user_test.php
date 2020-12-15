<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserTest extends AbstractMigration
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
        $this->execute("
			CREATE TABLE `UserTest` (
			  `user_id` int(11) NOT NULL AUTO_INCREMENT,
			  `last_name` varchar(100) NOT NULL COMMENT '姓',
			  `first_name` varchar(100) NOT NULL COMMENT '名',
			  `last_kana_name` varchar(100) DEFAULT NULL COMMENT '姓（カナ）',
			  `first_kana_name` varchar(100) DEFAULT NULL COMMENT '名（カナ）',
			  `username` varchar(200) NOT NULL COMMENT 'ユーザ名',
			  `password` varchar(400) NOT NULL COMMENT 'パスワード',
			  `email` varchar(200) NOT NULL COMMENT 'Email',
			  `postcode` varchar(100) NOT NULL COMMENT '郵便番号',
			  `birthday` date NOT NULL COMMENT '誕生日',
			  `description` longtext COMMENT '説明',
			  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `updated` datetime DEFAULT NULL,
			  PRIMARY KEY (`user_id`)
			);
		");
    }
    public function down()
    {
        $this->execute("
			DROP TABLE `UserTest`;
		");
    }
}
