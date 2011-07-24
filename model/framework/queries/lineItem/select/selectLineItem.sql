SELECT
    `invoice_lineitems`.`lineId`,
    `invoice_lineitems`.`invoiceId`,
    `invoice_lineitems`.`productId`,
    `invoice_lineitems`.`couponCode`,
    `invoice_lineitems`.`categoryId`,
    `invoice_lineitems`.`name`,
    `invoice_lineitems`.`description`,
    `invoice_lineitems`.`creditValue`,
    `invoice_lineitems`.`debitValue`,
    `invoice_lineitems`.`qty`
FROM `invoice_lineitems` WHERE `lineId` = '?1';