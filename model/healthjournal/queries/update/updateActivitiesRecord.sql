UPDATE `healthjournal_activities` SET
    `userId` = '?1',
    `activityDate` = '?2',
    `activityType` = '?3',
    `activityLevel` = '?4',
    `activityDistanceValue` = '?5',
    `activityDistanceType` = '?6',
    `activityDurationHours` = '?7',
    `activityDurationMinutes` = '?8',
    `activityDurationSeconds` = '?9',
    `activityCalories` = '?10'
WHERE `recordId` = '?11';