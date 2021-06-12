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
  customer_id INT NOT NULL,
  phone_number VARCHAR(127) NULL,
  phone_number_search VARCHAR(127) NULL,
  INDEX (phone_number)
);


INSERT INTO users (id, api_key) VALUES (1, "XPwb94dZfCP1pWdYPzR9p19HBT85kYutAMY0csPDs3B1OkcChKCJhXQkZlrXLmOV");

INSERT INTO `customers` (`id`, `id_gov`, `name_first`, `name_last`, `date_birth`, `sex`) VALUES (1,'317907001','Dor','Levi','2006-12-31','male');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (1,1,'(972) 52-344-6666','972523446666');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (2,1,'054-677-8868 ex 51','054677886851');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (3,1,'(972) 52-321-8376','972523218376');


INSERT INTO `customers` (`id`, `id_gov`, `name_first`, `name_last`, `date_birth`, `sex`) VALUES (2,'317907002','Ela','Hazan','2008-10-06','female');


INSERT INTO `customers` (`id`, `id_gov`, `name_first`, `name_last`, `date_birth`, `sex`) VALUES (3,'317907003','Rachel','Sara','2013-09-29','female');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (4,3,'058-767-8311','0587678311');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (5,3,'(972) 52-034-1936','972520341936');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (6,3,'054-776-9563 ex 13','054776956313');


INSERT INTO `customers` (`id`, `id_gov`, `name_first`, `name_last`, `date_birth`, `sex`) VALUES (4,'317907004','Yaakov','Orr','2004-04-01','male');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (7,4,'(972) 54-755-0000x2','9725475500002');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (8,4,'053-222-1321','0532221321');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (9,4,'(972) 52-353-3030','972523533030');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (10,4,'050-923-1313','0509231313');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (11,4,'(972) 50-123-4567','972501234567');

INSERT INTO `customers` (`id`, `id_gov`, `name_first`, `name_last`, `date_birth`, `sex`) VALUES (5,'317907005','Ethan','Yitchak','2004-04-01','male');
INSERT INTO `customer_phone_numbers` (`id`, `customer_id`, `phone_number`, `phone_number_search`) VALUES (12,5,'054-232-7878','0542327878');

