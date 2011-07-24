SELECT
    `invoice`.`description`,
    `invoice`.`invoiceId`,
    `invoice`.`userId`,
    `invoice`.`dateCreated`,
    `invoice`.`transactionId`,
    `invoice`.`gateway`,
    `invoice`.`domain`,
    `invoice`.`clientIPAddress`,
    `invoice`.`status`,
    group_concat(DISTINCT `invoice_lineitems`.`lineId` separator ',') AS 'lineIds'
FROM `invoice`
    LEFT JOIN `invoice_lineitems` ON `invoice_lineitems`.`invoiceId` = `invoice`.`invoiceId`
WHERE `invoice`.`invoiceId` = '?1'