alter table user add last_change TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

alter table user add last_change_password DATETIME;
update user set last_change_password=NOW();
alter table user modify last_change_password DATETIME NOT NULL;
