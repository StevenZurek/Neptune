UPDATE `healthjournal_body` SET
    `date` = '?2',
    `neck` = '?3',
    `shoulders` = '?4',
    `chest` = '?5',
    `leftBicep` = '?6',
    `rightBicep` = '?7',
    `leftForearm` = '?8',
    `rightForearm` = '?9',
    `waist` = '?10',
    `hips` = '?11',
    `leftThigh` = '?12',
    `rightThigh` = '?13',
    `leftCalf` = '?14',
    `rightCalf` = '?15'
WHERE `recordId` = '?1';