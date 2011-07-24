UPDATE `events` SET
    `title` = '?2',
    `date` = '?3',
    `timeHour` = '?4',
    `timeMinute` = '?5',
    `timeAMPM` = '?6',
    `location` = '?7',
    `image` = '?8',
    `description` = '?9',
    `url` = '?10',
    `recurring` = '?11',
    `category` = '?12'
WHERE `eventId` = '?1'