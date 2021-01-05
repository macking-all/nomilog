CREATE TABLE `SampleUser` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL COMMENT 'ユーザ名',
    `pass` varchar(400) NOT NULL COMMENT 'パスワード',
    `note` varchar(400) COMMENT '管理者フラグ',
    PRIMARY KEY (`id`)
);