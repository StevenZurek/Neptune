UPDATE `user_address` SET 
    `firstName` = '?2',
    `lastName` = '?3',
    `address1` = '?4',
    `address2` = '?5',
    `city` = '?6',
    `state` = '?7',
    `zip` = '?8',
    `country` = '?9',
    `email` = '?10',
    `phone` = '?11',
    `other` = '?12'
WHERE `addressId` = (SELECT `currentAddress` FROM `user_profile`  WHERE `userId` = '?1' ORDER BY `profileId` DESC LIMIT 1)