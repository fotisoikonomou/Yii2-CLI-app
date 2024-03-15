CREATE TABLE IF NOT EXISTS currency_rate (
     id INT AUTO_INCREMENT PRIMARY KEY,
     currency_date DATE NOT NULL,
     currency_symbol VARCHAR(3) NOT NULL,
    currency_rate DECIMAL(10, 6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;