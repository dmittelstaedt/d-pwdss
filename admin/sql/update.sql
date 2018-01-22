-- Revoke all privileges
revoke all privileges on *.* from 'pwdss_app_write'@'localhost';

-- Grant privileges for selecting, updating and inserting
grant select, update, insert on pwdss.* to 'pwdss_app_write'@'localhost';

-- Flush privileges
flush privileges;
