-- EXPECTED TABLE RETURNED
--  +----------+--------------+---------------+------------------+
--  | module   | enabled      | sessionObject | runStartupScript |
--  +----------+--------------+---------------+------------------+
--  | string   | true / false | string        | true / false     |
--  +----------+--------------+---------------+------------------+
SELECT `module`, `enabled`, `sessionObject`, `runStartupScript` FROM `cfg_modules` WHERE `enabled` = 'true';