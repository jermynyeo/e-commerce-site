DROP DATABASE IF EXISTS product;

CREATE DATABASE product;
USE product; 

CREATE TABLE product (
    productID INT AUTO_INCREMENT,
    productCat VARCHAR(50) NOT NULL,
    productSubCat VARCHAR(50) NOT NULL,
    productName VARCHAR(50) NOT NULL,
    quantity INT,
    price DOUBLE,
    PRIMARY KEY (productID, productCat, productSubCat, productName)
); 

                                                                                 -- Productcat,   productsubcat, product name,) 
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Hardware", "Storage", "100GB", 25, 9 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Hardware", "Storage", "500GB", 10, 10 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Hardware", "Storage", "1TB", 1, 25 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Hardware", "Service Type", "SaaS", 2, 24 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Hardware", "Service Type", "PaaS", 5, 7 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Hardware", "Service Type", "IaaS", 8, 10 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Analytics", "Machine Learning", "Market Basket Analysis", 5, 8 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Analytics", "Machine Learning", "Predictive Modelling", 2, 66 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Analytics", "Machine Learning", "Forecasing Modelling", 12, 120 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Analytics", "Tools", "Datapine", 5, 8 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Analytics", "Tools", "Yellowfin BI", 2, 66 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Analytics", "Tools", "Qlik Sense", 12, 120 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Digital", "Tools", "Optical Blend", 5, 8 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Digital", "Tools", "VADAAR", 2, 66 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Digital", "Tools", "AV Automation", 12, 120 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Digital", "IoT", "Movement Radar", 5, 8 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Digital", "IoT", "Heat Radar", 2, 69 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Digital", "IoT", "Light Radar", 12, 120 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Socialmedia", "Influencer", "B Tier", 5, 45 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Socialmedia", "Influencer", "A Tier", 2, 66 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Socialmedia", "Influencer", "S Tier", 12, 120 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Socialmedia", "Platform", "Facebook", 2, 66 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Socialmedia", "Platform", "Instagram", 5, 81 );
INSERT INTO product (productCat, productSubCat, productName, quantity, price) VALUES ("Socialmedia", "Platform", "Tik Tok", 12, 120 );

