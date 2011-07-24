UPDATE `healthjournal_vital` SET
    `date` = '?2',
    `weight` = '?3',
    `syc` = '?4',
    `dya` = '?5',
    `pulse` = '?6',
    `glucose` = '?7',
    `ldl` = '?8',
    `hdl` = '?9'
WHERE `recordId` = '?1'