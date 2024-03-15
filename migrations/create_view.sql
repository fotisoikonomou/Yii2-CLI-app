-- Simple sql query for creating a view
CREATE OR REPLACE VIEW currency_today AS

SELECT
    currency_symbol,
    
    currency_rate
FROM
    currency_rate
WHERE
    currency_date = CURDATE();