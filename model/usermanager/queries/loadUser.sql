SELECT
    `user`.`userId` ,
    -- ACCOUNT
    `user_account`.`username`,
    `user_account`.`group`,
    `user_account_validation`.`validationCode`,
    `user_account_validation`.`validated`,
    -- USER PROFILE
    `user_profile_address`.`addressId` AS 'profile_addressId',
    `user_profile_address`.`firstName` AS 'profile_firstName',
    `user_profile_address`.`lastName` AS 'profile_lastName',
    `user_profile_address`.`address1` AS 'profile_address1',
    `user_profile_address`.`address2` AS 'profile_address2',
    `user_profile_address`.`city` AS 'profile_city',
    `user_profile_address`.`state` AS 'profile_state',
    `user_profile_address`.`zip` AS 'profile_zip',
    `user_profile_address`.`country` AS 'profile_country',
    `user_profile_address`.`email` AS 'profile_email',
    `user_profile_address`.`phone` AS 'profile_phone',
    `user_profile_address`.`other` AS 'profile_other',
    -- USER BILLING PROFILE
    `user_billing_address`.`addressId` AS 'billing_addressId',
    `user_billing_address`.`firstName` AS 'billing_firstName',
    `user_billing_address`.`lastName` AS 'billing_lastName',
    `user_billing_address`.`address1` AS 'billing_address1',
    `user_billing_address`.`address2` AS 'billing_address2',
    `user_billing_address`.`city` AS 'billing_city',
    `user_billing_address`.`state` AS 'billing_state',
    `user_billing_address`.`zip` AS 'billing_zip',
    `user_billing_address`.`country` AS 'billing_country',
    `user_billing_address`.`email` AS 'billing_email',
    `user_billing_address`.`phone` AS 'billing_phone',
    `user_billing_address`.`other` AS 'billing_other',
    -- USER SHIPPING PROFILE
    `user_shipping_address`.`addressId` AS 'shipping_addressId',
    `user_shipping_address`.`firstName` AS 'shipping_firstName',
    `user_shipping_address`.`lastName` AS 'shipping_lastName',
    `user_shipping_address`.`address1` AS 'shipping_address1',
    `user_shipping_address`.`address2` AS 'shipping_address2',
    `user_shipping_address`.`city` AS 'shipping_city',
    `user_shipping_address`.`state` AS 'shipping_state',
    `user_shipping_address`.`zip` AS 'shipping_zip',
    `user_shipping_address`.`country` AS 'shipping_country',
    `user_shipping_address`.`email` AS 'shipping_email',
    `user_shipping_address`.`phone` AS 'shipping_phone',
    `user_shipping_address`.`other` AS 'shipping_other'

FROM `user`
    LEFT JOIN `user_account` ON `user`.`userId` = `user_account`.`userId`
    LEFT JOIN `user_account_validation` ON `user`.`userId` = `user_account_validation`.`userId`

    LEFT JOIN `user_profile` ON `user`.`userId` = `user_profile`.`userId`
    LEFT JOIN `user_address` AS user_profile_address ON (SELECT `currentAddress` FROM `user_profile`  WHERE `userId` = '?1' ORDER BY `profileId` DESC LIMIT 1) = `user_profile_address`.`addressId`

    LEFT JOIN `user_billingprofile` ON `user`.`userId` = `user_billingprofile`.`userId`
    LEFT JOIN `user_address` AS user_billing_address ON (SELECT `currentAddress` FROM `user_billingprofile`  WHERE `userId` = '?1' ORDER BY `profileId` DESC LIMIT 1) = `user_billing_address`.`addressId`

    LEFT JOIN `user_shippingprofile` ON `user`.`userId` = `user_shippingprofile`.`userId`
    LEFT JOIN `user_address` AS user_shipping_address ON (SELECT `currentAddress` FROM `user_shippingprofile`  WHERE `userId` = '?1' ORDER BY `profileId` DESC LIMIT 1) = `user_shipping_address`.`addressId`

WHERE `user`.`userId` = '?1'
GROUP BY `user`.`userId`