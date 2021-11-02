DROP DATABASE IF EXISTS customer;

CREATE DATABASE customer;
USE customer; 

CREATE TABLE customer (
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    companyName VARCHAR(250) NOT NULL,
    email VARCHAR(150) NOT NULL,
    PRIMARY KEY (username)
); 


INSERT INTO customer (username, password, companyName, email) VALUES ("clement", "password", "CLEMENT'sWUHAN", "clement.ong.2018@sis.smu.edu.sg");
INSERT INTO customer (username, password, companyName, email) VALUES ("joel", "password", "CLEMENT'sWUHAN", "joel.lim.2018@sis.smu.edu.sg");
INSERT INTO customer (username, password, companyName, email) VALUES ("donavan", "password", "CLEMENT'sWUHAN", "yuheng.yieh.2018@sis.smu.edu.sg");
INSERT INTO customer (username, password, companyName, email) VALUES ("bryan", "password", "CLEMENT'sWUHAN", "bryan.yong.2018@sis.smu.edu.sg");
INSERT INTO customer (username, password, companyName, email) VALUES ("jermyn", "password", "CLEMENT'sWUHAN", "jermynyeo.2018@sis.smu.edu.sg");


