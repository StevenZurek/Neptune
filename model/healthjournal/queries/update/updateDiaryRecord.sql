UPDATE `healthjournal_diary` SET
    `diaryDate` = '?2',
    `diaryTitle` = '?3',
    `entry` = '?4',
    `mood` = '?5',
    `energy` = '?6',
    `stress` = '?7',
    `anger` = '?8',
    `appetite` = '?9',
    `clarity` = '?10',
    `health` = '?11',
    `sleep` = '?12'
WHERE `recordId` = '?1';