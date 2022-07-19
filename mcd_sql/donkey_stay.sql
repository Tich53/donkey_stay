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
/* MAJ 18072022 */

INSERT INTO cottage (cottage_name, cottage_address, cottage_city, cottage_country, cottage_price_per_night, cottage_photo)
VALUES ('MAISON MÉDIÉVALE', 'Catalogne', 'El Canós', 'Espagne', 120, 'https://a0.muscache.com/im/pictures/80af4642-c7dc-4bec-863d-fcbdf54cf0eb.jpg?im_w=1200'),
('MAS DU XVÈME SIÈCLE', 'Occitanie', 'Arles-sur-Tech', 'France', 80, 'https://a0.muscache.com/im/pictures/miso/Hosting-32888733/original/ce8cd349-e143-47ba-8fff-9d7b26b3f57e.jpeg?im_w=1200'),
('BELLE GRANGE RENOVEE', 'Occitanie', 'Loudervielle', 'France', 140, 'https://a0.muscache.com/im/pictures/57010138-b232-4536-b24d-9a376552bfeb.jpg?im_w=1200'),
('CHÂTEAU D`ESCLAVELLES', 'Normandie', 'Esclavelles', 'France', 120, 'https://a0.muscache.com/im/pictures/miso/Hosting-606307396190257695/original/81944cd3-bba5-4522-9b52-b7edf005de8f.jpeg?im_w=1200'),
('DOMAINE DE NOINTEL', 'Île-de-France', 'Nointel', 'France', 120, 'https://a0.muscache.com/im/pictures/miso/Hosting-626636234442140357/original/3f14ce83-0af9-43fa-8298-c6101c4d36f1.jpeg?im_w=1200'),
('GRANGE RÉHABILITÉE', 'Hauts-de-France', 'Montépilloy', 'France', 120, 'https://a0.muscache.com/im/pictures/miso/Hosting-557702590908765257/original/04a08d1d-a946-4839-b3e7-f524d75fa25b.jpeg?im_w=1200'),
('DOMAINE LE GROS CHÊNE', 'Normandie', 'Le Landin', 'France', 220, 'https://a0.muscache.com/im/pictures/5d37c4a0-d426-4f95-8264-f181a7b30e02.jpg?im_w=1200');

/* Modification nom de la colonne cottage_address par cottage_region dans la table cottage */
/* MAJ 19072022 */

ALTER TABLE cottage
CHANGE cottage_address cottage_region varchar(255) NOT NULL;