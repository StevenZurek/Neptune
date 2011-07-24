SELECT
    -- PRODUCTS
    `products_products`.`sku`,
    `products_products`.`name` ,
    `products_products`.`description` ,
    -- RETAIL
    `products_products`.`ppu`,
    -- WHOLESALE
    `products_wholesale`.`ppu` AS 'wholesale_ppu',
    -- SHIPPING
    `products_shipping`.`shipping`,
    `products_shipping`.`internationalShipping`,
    -- ATTRIBUTES
    group_concat(DISTINCT concat(`products_attributes`.`attribute`, ':', `products_attributes`.`value`) separator ';') AS 'attributes',
    -- IMAGES
    group_concat(DISTINCT `products_images`.`imageURI` separator ';') AS 'images',
    -- KEYWORDS
    group_concat(DISTINCT `products_keywords`.`keyword` separator ';') AS 'keywords'
FROM `products_products`
    LEFT JOIN `products_shipping` ON `products_products`.`sku` = `products_shipping`.`sku`
    LEFT JOIN `products_attributes` ON `products_products`.`sku` = `products_attributes`.`sku`
    LEFT JOIN `products_images` ON `products_products`.`sku` = `products_images`.`sku`
    LEFT JOIN `products_keywords` ON `products_products`.`sku` = `products_keywords`.`sku`
    LEFT JOIN `products_wholesale` ON `products_products`.`sku` = `products_wholesale`.`sku`
WHERE `products_products`.`sku` = '?1'
GROUP BY `products_products`.`sku`