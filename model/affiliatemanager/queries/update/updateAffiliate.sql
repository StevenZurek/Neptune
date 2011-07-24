UPDATE `affiliates` SET
    `name` = '?2',
    `address` = '?3',
    `image` = '?4',
    `url` = '?5',
    `description` = '?6',
    `phone` = '?7',
    `category` = '?8'
 WHERE `affiliateId` = '?1'