CREATE USER 'adminZTE'@'localhost' IDENTIFIED BY 'a4b3c2d1';
GRANT ALL PRIVILEGES ON ZTE_FONADE. * TO 'adminZTE'@'localhost';
FLUSH PRIVILEGES;

CREATE USER 'userZTE'@'localhost' IDENTIFIED BY 'qwerty098';
GRANT select ON ZTE_FONADE. * TO 'userZTE'@'localhost';
GRANT update ON ZTE_FONADE. * TO 'userZTE'@'localhost';
GRANT insert ON ZTE_FONADE. * TO 'userZTE'@'localhost';
FLUSH PRIVILEGES;
