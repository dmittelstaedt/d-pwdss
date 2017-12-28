-- Drop databse if exists
drop database if exists pwdss;

-- Create database pwdssdb
create database pwdss;

-- Use database pwdssdb
use pwdss;

-- Drop table user
drop table if exists user;

-- Create table user
create table if not exists user (
  user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(64) NOT NULL,
  lastname VARCHAR(64) NOT NULL,
  username VARCHAR(64) NOT NULL,
  realm VARCHAR(64) NOT NULL,
  role enum('app_user', 'app_admin') NOT NULL,
  permission enum('read', 'read_write') NOT NULL,
  password VARCHAR(64) NOT NULL,
  CONSTRAINT uc_user UNIQUE (user_id,username)
);
