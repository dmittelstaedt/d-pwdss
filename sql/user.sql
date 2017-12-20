-- Drop user pwdss_app_write
drop user if exists 'pwdss_app_write'@'localhost';

-- Create user pwdss
create user if not exists 'pwdss_app_write'@'localhost' identified by 'YTE5NjgyZDgxODI4';

-- Grant privileges for selecting and updating
grant select,update on pwdss.* to 'pwdss_app_write'@'localhost';

-- Flush privileges
flush privileges;
