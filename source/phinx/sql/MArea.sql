CREATE TABLE `MArea` (
    `area_id` int(11) NOT NULL AUTO_INCREMENT,
    `area_name` varchar(100) NOT NULL COMMENT '地域名',
    `delete_flag` boolean COMMENT '削除フラグ',
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`area_id`)
);