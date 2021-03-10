CREATE TABLE `Posts` (
    `post_id` int(11) NOT NULL AUTO_INCREMENT,
    `pub_name` varchar(100) NOT NULL COMMENT '店名',
    `comment` varchar(400) NOT NULL COMMENT '投稿内容',
    `user_id` int(11) NOT NULL COMMENT 'ユーザID',
    `cook_id` int(11) NOT NULL COMMENT '料理ID',
    `area_id` int(11) NOT NULL COMMENT '地域ID',
    `price_id` int(11) NOT NULL COMMENT '価格ID',
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`post_id`)
);