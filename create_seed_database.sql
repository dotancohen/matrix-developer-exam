CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  api_key CHAR(64) NULL,
  INDEX (api_key)
);

CREATE TABLE customers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_gov VARCHAR(127) NULL,
  name_first VARCHAR(127) NULL,
  name_last VARCHAR(127) NULL,
  date_birth DATE NULL,
  sex ENUM('male', 'female', 'other') NULL,
  INDEX (id_gov)
);

CREATE TABLE customer_phone_numbers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  phone_number VARCHAR(127) NULL,
  phone_number_search BIGINT UNSIGNED NULL,
  INDEX (phone_number)
);

INSERT INTO users (id, api_key) VALUES (0, "XPwb94dZfCP1pWdYPzR9p19HBT85kYutAMY0csPDs3B1OkcChKCJhXQkZlrXLmOV");

