CREATE TABLE `M_Cook` (
    `cook_id` int(11) NOT NULL AUTO_INCREMENT,
    `cook_name` varchar(100) NOT NULL COMMENT '姓',
    `delete_flag` boolean COMMENT '削除フラグ',
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated` datetime DEFAULT NULL,
    PRIMARY KEY (`cook_id`)
);