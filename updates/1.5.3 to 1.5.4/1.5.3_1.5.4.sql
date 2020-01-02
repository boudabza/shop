UPDATE `general_settings` SET `value` = '1.5.4' WHERE `general_settings`.`general_settings_id` = 78;

INSERT INTO `ui_settings` (`ui_settings_id`, `type`, `value`) VALUES
(58, 'home3_categories', '[{\"category\":\"4\",\"sub_category\":[\"8\",\"11\",\"34\",\"35\",\"36\",\"37\",\"39\",\"40\"],\"color_back\":null,\"color_text\":null},{\"category\":\"5\",\"sub_category\":[\"27\",\"28\",\"29\",\"30\",\"89\",\"90\"],\"color_back\":null,\"color_text\":null}]'),
(59, 'todays_deal_show', 'ok'),
(60, 'todays_deal_product_box_style', '4'),
(61, 'no_of_deal_products', '8');

ALTER TABLE `role` CHANGE `permission` `permission` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;