DROP DATABASE IF EXISTS employee;

CREATE DATABASE employee;
USE employee; 

CREATE TABLE employee (
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL,
    PRIMARY KEY (username)
); 

INSERT INTO employee (username, password, email) VALUES ("clement", "password","clement.ong.2018@sis.smu.edu.sg");
INSERT INTO employee (username, password, email) VALUES ("joel", "password", "joel.lim.2018@sis.smu.edu.sg");
INSERT INTO employee (username, password, email) VALUES ("donavan", "password", "yuheng.yieh.2018@sis.smu.edu.sg");
INSERT INTO employee (username, password, email) VALUES ("bryan", "password", "bryan.yong.2018@sis.smu.edu.sg");
INSERT INTO employee (username, password, email) VALUES ("jermyn", "password", "jermynyeo.2018@sis.smu.edu.sg");
INSERT INTO employee (username, password, email) VALUES ("admin", "password", "admin@bysolutions.com");
