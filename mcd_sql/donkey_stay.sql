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
    cottage_region VARCHAR(255) NOT NULL,
    cottage_city VARCHAR(45) NOT NULL,
    cottage_country VARCHAR(45) NOT NULL,
    cottage_nb_bed INTEGER NOT NULL,
    cottage_nb_bathroom INTEGER NOT NULL,
    cottage_price_per_night FLOAT NOT NULL,
    cottage_description VARCHAR(255),
    cottage_photo1 VARCHAR(255) NOT NULL,
    cottage_photo2 VARCHAR(255),
    cottage_photo3 VARCHAR(255),
    cottage_photo4 VARCHAR(255),
    cottage_photo5 VARCHAR(255),
    cottage_photo6 VARCHAR(255)
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
    nb_adult INTEGER NOT NULL,
    nb_child INTEGER NOT NULL,
    total_price FLOAT NOT NULL,
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
VALUES ('Tich53', 'richard123', 'Richard', 'Douetté', '0695936812', 'richard.douette-std@donkey.school');

INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('PatrickT', 'patrick123', 'Patrick', 'Tanguy', '06', 'patrick.tanguy-std@donkey.school');

INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('Khouloud', 'khouloud123', 'Khouloud', 'Hadhek', '06', 'khouloud.hadhek-std@donkey.school');

INSERT INTO user (username, user_password, user_firstname, user_lastname, user_phone, user_email)
VALUES ('Daniel', 'daniel123', 'Daniel', 'DESCLOUX', '06', 'daniel.descloux-std@donkey.school');


/* Insertion données table optional */
INSERT INTO optional (optional_name, optional_price_per_adult, optional_price_per_child)
VALUES ('Donkey ride', 12, 7);

/* Insertion données table cottage */
INSERT INTO cottage (cottage_name, cottage_region, cottage_city, cottage_country, cottage_nb_bed, cottage_nb_bathroom, cottage_price_per_night, cottage_photo)
VALUES ('MAISON MÉDIÉVALE', 'Catalogne', 'El Canós', 'Espagne', 3, 2, 120, 'images/gite1_1.webp'),
('MAS DU XVÈME SIÈCLE', 'Occitanie', 'Arles-sur-Tech', 'France', 80, 2, 1, 'images/gite2_1.webp'),
('BELLE GRANGE RENOVEE', 'Occitanie', 'Loudervielle', 'France', 140, 4, 3, 'images/gite3_1.webp'),
('CHÂTEAU D`ESCLAVELLES', 'Normandie', 'Esclavelles', 'France', 120, 3, 2, 'images/gite4_1.webp'),
('DOMAINE DE NOINTEL', 'Île-de-France', 'Nointel', 'France', 120, 3, 1, 'images/gite5_1.webp'),
('GRANGE RÉHABILITÉE', 'Hauts-de-France', 'Montépilloy', 'France', 120, 4, 2, 'images/gite6_1.webp'),
('DOMAINE LE GROS CHÊNE', 'Normandie', 'Le Landin', 'France', 220, 5, 3, 'images/gite7_1.webp');

