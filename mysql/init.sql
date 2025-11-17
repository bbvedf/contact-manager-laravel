CREATE DATABASE IF NOT EXISTS contact_manager;
CREATE USER IF NOT EXISTS 'laraveluser'@'%' IDENTIFIED BY 'secret123';
GRANT ALL PRIVILEGES ON contact_manager.* TO 'laraveluser'@'%';
FLUSH PRIVILEGES;