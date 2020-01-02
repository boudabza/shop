UPDATE `general_settings` SET `value` = '1.5.5' WHERE `general_settings`.`general_settings_id` = 78;

CREATE TABLE `user_rating` (
  `rating_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` decimal(10,2) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `user_rating`
  ADD PRIMARY KEY (`rating_id`);

ALTER TABLE `user_rating`
  MODIFY `rating_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

ALTER TABLE `product` CHANGE `rating_total` `rating_total` DECIMAL(20,2) NOT NULL DEFAULT '0';
ALTER TABLE `customer_product` CHANGE `rating_num` `rating_num` DECIMAL(20,2) NOT NULL DEFAULT '0';
