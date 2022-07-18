CREATE DATABASE donkey_stay;
USE donkey_stay;

CREATE TABLE user (
    iduser INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(16) NOT NULL,
    user_password VARCHAR(32) NOT NULL,
    user_firstname VARCHAR(45) NOT NULL,
    user_lastname VARCHAR(45) NOT NULL,
    user_phone VARCHAR(30) NOT NULL,
    user_email VARCHAR(255) NOT NULL
);

CREATE TABLE cottage (
    idcottage INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cottage_name VARCHAR(45) NOT NULL,
    cottage_address VARCHAR(255) NOT NULL,
    cottage_city VARCHAR(45) NOT NULL,
    cottage_country VARCHAR(45) NOT NULL,
    cottage_price_per_night FLOAT NOT NULL,
    cottage_photo VARCHAR(255) NOT NULL
);

CREATE TABLE optional (
    idoptional INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    optional_name VARCHAR(45) NOT NULL,
    optional_price_per_adult FLOAT NOT NULL,
    optional_price_per_child FLOAT NOT NULL
);

CREATE TABLE booking (
    idbooking INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    user_iduser INTEGER NOT NULL,
    CONSTRAINT fk_booking_user FOREIGN KEY (user_iduser) REFERENCES user(iduser),
    cottage_idcottage INTEGER NOT NULL,
    CONSTRAINT fk_booking_cottage FOREIGN KEY (cottage_idcottage) REFERENCES cottage(idcottage),
    optional_idoptional INTEGER NOT NULL,
    CONSTRAINT fk_booking_optional FOREIGN KEY (optional_idoptional) REFERENCES optional(idoptional)
);

CREATE TABLE booked_date (
    idbooked_date INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    start_booked_date DATE NOT NULL,
    end_booked_date DATE NOT NULL
);

CREATE TABLE cottage_has_booked_date (
    idcottage_has_booked_date INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cottage_idcottage INTEGER NOT NULL,
    CONSTRAINT fk_cottage_has_booked_date_cottage_cottage FOREIGN KEY (cottage_idcottage) REFERENCES cottage(idcottage),
    booked_date_idbooked_date INTEGER NOT NULL,
    CONSTRAINT fk_cottage_has_booked_date_booked_date FOREIGN KEY (booked_date_idbooked_date) REFERENCES booked_date(idbooked_date)
);

/* Insertion données table user */
INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('Tich53', 'richard123', 'Richard', 'Douetté', '0695936812', 'rdouette@yahoo.fr');

INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('PatrickT', 'patrick123', 'Patrick', 'Tanguy', '06', 'patrick@gmail.com');

INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('Khouloud', 'khouloud123', 'Khouloud', 'Hadhek', '06', 'khouloud@gmail.com');

INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('Daniel', 'daniel123', 'Daniel', 'DESCLOUX', '06', 'daniel@gmail.com');


/* Insertion données table optional */
INSERT INTO optional (optional_name, optional_price_per_adult, optional_price_per_child)
VALUES ('Donkey ride', 12, 7);