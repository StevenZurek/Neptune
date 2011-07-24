SELECT
    `activityDate`,
    SUM(`activityDistanceValue`) AS `totalMiles`
FROM healthjournal_activities
WHERE `activityDate` BETWEEN '?2' AND '?3' AND  `userId` = '?1'
GROUP BY `activityDate` ORDER BY `activityDate`