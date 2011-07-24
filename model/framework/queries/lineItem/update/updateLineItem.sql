UPDATE `invoice_lineitems` SET
    `invoiceId` = '?2',
    `productId` = '?3',
    `couponCode` = '?4',
    `categoryId` = '?5',
    `name` = '?6',
    `description` = '?7',
    `creditValue` = '?8',
    `debitValue` = '?9',
    `qty` = '?10'
WHERE `lineId` = '?1'