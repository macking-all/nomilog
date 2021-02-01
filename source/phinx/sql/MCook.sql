CREATE TABLE `MCook` (
    `cook_id` int(11) NOT NULL AUTO_INCREMENT,
    `cook_name` varchar(100) NOT NULL COMMENT '料理名',
    `register_user` varchar(200) DEFAULT NULL COMMENT '登録者',
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_user` varchar(200) DEFAULT NULL COMMENT '更新者',
    `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `delete_flag` boolean COMMENT '削除フラグ',
    PRIMARY KEY (`cook_id`)
);