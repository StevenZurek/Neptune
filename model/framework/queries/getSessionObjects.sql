-- EXPECTED TABLE RETURNED
--  +----------+----------------+
--  | module   | sessionObject  |
--  +----------+----------------+
--  | string   | string         |
--  +----------+----------------+
SELECT `module`, `sessionObject` FROM `cfg_modules` WHERE `enabled` = 'true' AND `sessionObject` <> 'NULL';