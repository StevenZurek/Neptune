UPDATE `invoice` SET
    `transactionId` = '?2',
    `gateway` = '?3',
    `discount` = '?4',
    `subtotal` = '?5',
    `shipping` = '?6',
    `total` = '?7',
    `domain` = '?8',
    `clientIPAddress` = '?9',
    `status` = '?10'
WHERE `invoiceId` = '?1'