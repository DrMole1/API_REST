CREATE TABLE Categories (
    Id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Name varchar(100) NOT NULL
)ENGINE=INNODB;


CREATE TABLE Skills (
    Id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Name varchar(100) NOT NULL,
    Description varchar(255),
    Image varchar(100),
    Category_Id int DEFAULT NULL,
    FOREIGN KEY (Category_Id) REFERENCES Categories(Id) ON UPDATE CASCADE
)ENGINE=INNODB;