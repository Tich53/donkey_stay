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
    cottage_description VARCHAR(600) NOT NULL,
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
    nb_adult INTEGER,
    nb_child INTEGER,
    total_price FLOAT,
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
INSERT INTO cottage (cottage_name, cottage_region, cottage_city, cottage_country, cottage_nb_bed, cottage_nb_bathroom, cottage_price_per_night, cottage_photo1, cottage_description)
VALUES ('MAISON MÉDIÉVALE', 'Catalogne', 'El Canós', 'Espagne', 3, 2, 120, 'images/gite1_1.webp', "Casa del Portal est une maison privée, située dans un petit village médiéval (El Canós), entouré de champs, dans la région de Segarra (Lleida). Entièrement restauré, il dispose de 3 chambres d'une capacité de 8 personnes, d'un salon avec cheminée, d'une salle à manger, d'une cuisine, d'une salle de bain avec baignoire et terrasse. Dans le village, il y a une piscine avec une aire de jeux, que les clients peuvent utiliser gratuitement."),
('MAS DU XVÈME SIÈCLE', 'Occitanie', 'Arles-sur-Tech', 'France', 2, 1, 80, 'images/gite2_1.webp', "Notre ferme catalane du 15ème siècle avec gîte et studio indépendant au bord de la piscine est parfaite pour les familles ou les groupes d'amis à la recherche d'une escapade isolée dans ce coin pittoresque des Pyrénées Orientales. Situé dans un hectare de beaux jardins avec un ruisseau et une piscine à débordement, c'est le lieu idéal pour se détendre et profiter de la nature."),
('BELLE GRANGE RENOVEE', 'Occitanie', 'Loudervielle', 'France', 4, 3, 140, 'images/gite3_1.webp', "Grange rénovée qui allie le charme de l'ancien et le confort d'un intérieur moderne et design au cœur des Hautes-Pyrénées. Le village de Loudervielle est perché à 1 100m d'altitude, à mi-chemin entre Loudenvielle et la station de ski de Peyragudes. C'est le lieu idéal pour les amoureux de la nature (rando, chiens de traineaux...), de sport (station de ski de Peyragudes à 4 km, spot de parapente) ou de détente (Balnéa)."),
('CHÂTEAU D`ESCLAVELLES', 'Normandie', 'Esclavelles', 'France', 3, 2, 120,'images/gite4_1.webp', "Passez un séjour unique dans ce château du XVI siècle situé en plein cœur d'un élevage de chevaux de sport avec une vue époustouflante sur la boutonnière du pays de Bray. C'est au cœur du Pays de Brays, dans un domaine préservé de 3,5 hectares où se niche un authentique château du 16ème siècle aux multiples facettes enchanteresses."),
('DOMAINE DE NOINTEL', 'Île-de-France', 'Nointel', 'France', 3, 1, 120, 'images/gite5_1.webp', "Dans le domaine de Nointel, venez profiter de notre magnifique maison et de son cadre bucolique. Anciennes écuries du château récemment rénovées, la maison appelle à la contemplation et au repos. Nichée entre un château, son domaine, ses dépendances et une église, elle séduira les amoureux de vieilles pierres."),
('GRANGE RÉHABILITÉE', 'Hauts-de-France', 'Montépilloy', 'France', 4, 2, 120, 'images/gite6_1.webp', "Venez vous détendre dans cette chaleureuse grange réhabilitée, avec cour pavée et jardin fleuri, dans un petit village culminant à 134m d'altitude, au cœur du Parc Naturel Régional Oise-Pays de France. Grange réhabilitée dans un petit village au calme comprenant 3 chambres avec lits doubles et 2 matelas individuels en plus."),
('DOMAINE LE GROS CHÊNE', 'Normandie', 'Le Landin', 'France', 5, 3, 220, 'images/gite7_1.webp', "Maison de vacances familiale disposant d'une piscine intérieure (chauffée de mi mai jusqu'au 15 septembre uniquement et sans exception, donc inutilisable en dehors), un court de tennis extérieur utilisable de mars à octobre, une salle de billards, un babyfoot, le tout au centre d'un paisible domaine de 15 hectares. Dans les boucles de la Seine, située à 140 km de Paris, 60 km d'Honfleur et Deauville, 40 km de Rouen.");

/* Insertion images table cottage */
UPDATE cottage
SET cottage_photo2 = 'images/gite1_2.webp', cottage_photo3 = 'images/gite1_3.webp', cottage_photo4 = 'images/gite1_4.webp' WHERE idcottage = 1;
UPDATE cottage
SET cottage_photo2 = 'images/gite2_2.webp', cottage_photo3 = 'images/gite2_3.webp', cottage_photo4 = 'images/gite2_4.webp' WHERE idcottage = 2;
UPDATE cottage
SET cottage_photo2 = 'images/gite3_2.webp', cottage_photo3 = 'images/gite3_3.webp', cottage_photo4 = 'images/gite3_4.webp' WHERE idcottage = 3;
UPDATE cottage
SET cottage_photo2 = 'images/gite4_2.webp', cottage_photo3 = 'images/gite4_3.webp', cottage_photo4 = 'images/gite4_4.webp' WHERE idcottage = 4;
UPDATE cottage
SET cottage_photo2 = 'images/gite5_2.webp', cottage_photo3 = 'images/gite5_3.webp', cottage_photo4 = 'images/gite5_4.webp' WHERE idcottage = 5;
UPDATE cottage
SET cottage_photo2 = 'images/gite6_2.webp', cottage_photo3 = 'images/gite6_3.webp', cottage_photo4 = 'images/gite6_4.webp' WHERE idcottage = 6;
UPDATE cottage
SET cottage_photo2 = 'images/gite7_2.webp', cottage_photo3 = 'images/gite7_3.webp', cottage_photo4 = 'images/gite7_4.webp' WHERE idcottage = 7;