SELECT
    `healthjournal_food`.`recordId`,
    `healthjournal_food`.`userId`,
    `healthjournal_food`.`date`,
    `healthjournal_food`.`meal`,
    `healthjournal_food_items`.`name`,
    `healthjournal_food_items`.`calories`,
    `healthjournal_food_items`.`cholesterol`,
    `healthjournal_food_items`.`carbs`,
    `healthjournal_food_items`.`dietaryFiber`,
    `healthjournal_food_items`.`totalFat`,
    `healthjournal_food_items`.`sodium`,
    `healthjournal_food_items`.`sugars`,
    `healthjournal_food_items`.`protein`,
    `healthjournal_food_items`.`autocomplete`
FROM `healthjournal_food`
    LEFT JOIN `healthjournal_food_items` ON `healthjournal_food_items`.`recordId` = `healthjournal_food`.`item`
WHERE `healthjournal_food`.`recordId` = '?1';