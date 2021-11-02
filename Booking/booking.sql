DROP DATABASE IF EXISTS booking;

CREATE DATABASE booking;
USE booking; 

CREATE TABLE booking (
    bookingID INT AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    comments TEXT ,
    productProgress DOUBLE,
    projStartDate DATE,
    projEndDate DATE,
    PRIMARY KEY (bookingID)
) ENGINE=InnoDB; 

#date is in YYYY-MM-DD
INSERT INTO booking (username, productProgress, projStartDate, projEndDate) VALUES ("clement", 0.00, CURRENT_DATE, "2020-05-02");
INSERT INTO booking (username, productProgress, projStartDate, projEndDate) VALUES ("joel", 0.00, CURRENT_DATE, "2020-07-14");

CREATE TABLE bookingproducts (
    bookingID INT,
    productID INT,
    PRIMARY KEY (bookingID, productID),
    CONSTRAINT fk_bookingproducts FOREIGN KEY (bookingID) REFERENCES booking (bookingID)
) ENGINE=InnoDB; 

INSERT INTO bookingproducts (bookingID, productID) VALUES (2,2);
INSERT INTO bookingproducts (bookingID, productID) VALUES (2,1);
INSERT INTO bookingproducts (bookingID, productID) VALUES (2,3);
INSERT INTO bookingproducts (bookingID, productID) VALUES (2,4);
INSERT INTO bookingproducts (bookingID, productID) VALUES (1,1);
INSERT INTO bookingproducts (bookingID, productID) VALUES (1,2);
INSERT INTO bookingproducts (bookingID, productID) VALUES (1,3);
INSERT INTO bookingproducts (bookingID, productID) VALUES (1,4);
INSERT INTO bookingproducts (bookingID, productID) VALUES (1,5);
