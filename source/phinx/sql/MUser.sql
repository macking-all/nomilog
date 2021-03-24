CREATE TABLE `MUser` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_name` varchar(20) NOT NULL COMMENT 'ユーザ名',
    `email` varchar(200) NOT NULL COMMENT 'Email',
    `email_flag` boolean COMMENT 'Email送信フラグ',
    `icon_image` varchar(200) DEFAULT NULL COMMENT 'アイコン画像',
    `password` varchar(200) NOT NULL COMMENT 'パスワード',
    `admin_flag` boolean COMMENT '管理者フラグ',
    `register_user` int(11) DEFAULT NULL COMMENT '登録者',
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_user` int(11) DEFAULT NULL COMMENT '更新者',
    `updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `delete_flag` boolean COMMENT '削除フラグ',
    PRIMARY KEY (`user_id`)
);

-- CREATE TABLE `M_User` (
--     `user_id` int(11) NOT NULL AUTO_INCREMENT,
--     `last_name` varchar(100) NOT NULL COMMENT '姓',
--     `first_name` varchar(100) NOT NULL COMMENT '名',
--     `last_kana_name` varchar(100) DEFAULT NULL COMMENT '姓（カナ）',
--     `first_kana_name` varchar(100) DEFAULT NULL COMMENT '名（カナ）',
--     `username` varchar(200) NOT NULL COMMENT 'ユーザ名',
--     `password` varchar(400) NOT NULL COMMENT 'パスワード',
--     `email` varchar(200) NOT NULL COMMENT 'Email',
--     `postcode` varchar(100) NOT NULL COMMENT '郵便番号',
--     `birthday` date NOT NULL COMMENT '誕生日',
--     `description` longtext COMMENT '説明',
--     `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     `updated` datetime DEFAULT NULL,
--     PRIMARY KEY (`user_id`)
-- );
