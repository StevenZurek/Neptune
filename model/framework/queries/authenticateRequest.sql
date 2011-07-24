SELECT
    `user`.`userId`
FROM `user`
WHERE
   `user`.`userId` = '?1'
AND
-- GETS GROUP LEVEL OF AN ELEMENT > GETS GROUP LEVEL OF A USER ID
    (SELECT
        `user_groups`.`groupLevel`
    FROM `user_groups`
    WHERE `user_groups`.`groupName` =
        (SELECT `sec_?2`.`groupName` FROM `sec_?2` WHERE `sec_?2`.`method` = '?3'))
    >=
    (SELECT
        `user_groups`.`groupLevel`
    FROM `user_groups`
    WHERE `user_groups`.`groupName` =
        (SELECT `user_account`.`group` FROM `user_account` WHERE `user_account`.`userId` = '?1'))