-- I use delimeter in order to write code and mysql not stop me be displaying errors in order
-- to be able to write the procedure
DELIMITER //

-- The db procedure name in which I will call it through cronjob
CREATE PROCEDURE MonthlySummary()
BEGIN
    --First I clear the data if there are any data and make sure it always has new data 
    DELETE FROM monthly_summary;
    
    --Simple sql query
    INSERT INTO monthly_summary (month, currency_symbol, min_rate, max_rate, avg_rate)
    SELECT
        DATE_FORMAT(currency_date, '%Y-%m') AS month,
        currency_symbol,
        MIN(currency_rate) AS min_rate,
        MAX(currency_rate) AS max_rate,
        AVG(currency_rate) AS avg_rate
    FROM
        currency_rate
    GROUP BY
        month,
        currency_symbol;
END //
-- End of procedure

DELIMITER ;
-- End of delimeter