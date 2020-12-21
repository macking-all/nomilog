CREATE TABLE `MPrice` (
    `price_id` int(11) NOT NULL AUTO_INCREMENT,
    `price_range` varchar(100) NOT NULL COMMENT '価格帯',
    `delete_flag` boolean COMMENT '削除フラグ',
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`price_id`)
);