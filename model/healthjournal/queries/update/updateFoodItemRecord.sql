UPDATE `healthjournal_food_items` SET
    `name` = '?2',
    `calories` = '?3',
    `cholesterol` = '?4',
    `carbs` = '?5',
    `dietaryFiber` = '?6',
    `totalFat` = '?7',
    `sodium` = '?8',
    `sugars` = '?9',
    `protein` = '?10'
WHERE `recordId` = '?1';