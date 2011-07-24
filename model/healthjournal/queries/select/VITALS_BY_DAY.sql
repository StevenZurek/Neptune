SELECT
    `date`,
    AVG(`glucose`) AS 'glucose',
    AVG(`syc`) AS 'syc',
    AVG(`dya`) AS 'dya',
    AVG(`ldl`) AS 'ldl',
    AVG(`hdl`) AS 'hdl'
FROM `healthjournal_vital`
WHERE `date` BETWEEN '?2' AND '?3' AND  `userId` = '?1'
GROUP BY `date` ORDER BY `date`