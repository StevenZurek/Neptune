SELECT
    `activityType`,
    SUM(`activityDurationMinutes` + (`activityDurationHours` * 60) + (`activityDurationSeconds` / 60)) AS `totalMinutes`
FROM healthjournal_activities
WHERE `activityDate` BETWEEN '?2' AND '?3' AND  `userId` = '?1'
GROUP BY `activityType` ORDER BY `activityType`