-- Use database pwdssdb
use pwdss;

-- Insert some users in table users
insert into user (firstname, lastname, username, realm, role, password)
  values ("David", "Test", "david", "test", "app_admin", "046c56f38f0930c852d273bb5e5963f6"),
  ("Darth", "Vader", "vaderda", "test", "app_user", "vaderda"),
  ("Luke", "Skywalker", "skywallu", "test", "app_user", "skywallu");