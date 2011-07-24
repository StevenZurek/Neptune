-- GETS GROUP LEVEL OF AN ELEMENT
SELECT
    `user_groups`.`groupLevel`
FROM
    `user_groups`
WHERE `user_groups`.`groupName` = (SELECT `user_elements`.`groupName` FROM `user_elements` WHERE `user_elements`.`elementName` = 'tab2');

-- GETS GROUP LEVEL OF A USER ID
SELECT
    `user_groups`.`groupLevel`
FROM
    `user_groups`
WHERE `user_groups`.`groupName` = (SELECT `user_account`.`group` FROM `user_account` WHERE `user_account`.`userId` = '1');