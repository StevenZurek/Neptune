SELECT
    `coupon_coupons`.`code`,
    `coupon_coupons`.`discountType` AS 'type',
    `coupon_coupons`.`discountAmount` AS 'amount',
    `coupon_coupons`.`discountApplied` AS 'applied',
    `coupon_coupons`.`description`,
    group_concat(`coupon_targetsku`.`sku` separator ';') AS 'targetsku'
FROM `coupon_coupons`
    JOIN `coupon_targetsku` ON `coupon_coupons`.`code` = `coupon_targetsku`.`code`
WHERE `coupon_coupons`.`code` = '?1'
GROUP BY `coupon_coupons`.`code`