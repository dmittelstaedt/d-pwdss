-- Create database pwssdb
-- create database pwssdb;

-- Use database pwssdb
use pwssdb;

-- Drop table user
drop table user;

-- Create table user
create table if not exists user (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(64) NOT NULL,
  lastname VARCHAR(64) NOT NULL,
  username VARCHAR(64) NOT NULL,
  realm VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL
);

-- Insert some users in table users
insert into user (firstname, lastname, username, realm, password)
  values ("David", "Test", "david", "test", "046c56f38f0930c852d273bb5e5963f6");
insert into user (firstname, lastname, username, realm, password)
  values ("Darth", "Vader", "vaderda", "test", "password");
