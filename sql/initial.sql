# Create Database pwssdb
#create database pwssdb;

# User Database pwssdb;
#use pwssdb;

# Create Table user
create table if not exists user (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(64) NOT NULL,
  lastname VARCHAR(64) NOT NULL,
  username VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL
);

# Insert some users in table users
delete from user where username="david";
insert into user (firstname, lastname, username, password)
  values ("David", "Test", "david", "$apr1$wD3re7A/$QjMeU6boYvoLS2hBZVoLg1");
