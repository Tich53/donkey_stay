CREATE DATABASE donkey_stay;

USE donkey_stay;

CREATE TABLE user (
    iduser INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR (16) NOT NULL,
    user_password VARCHAR (32) NOT NULL,
    user_firstname VARCHAR (45) NOT NULL,
    user_lastname VARCHAR (45) NOT NULL,
    user_phone VARCHAR (30) NOT NULL,
    user_email VARCHAR (255) NOT NULL
);

CREATE TABLE cottage (
    idcottage INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cottage_name VARCHAR (45) NOT NULL,
    cottage_region VARCHAR (255) NOT NULL,
    cottage_city VARCHAR (45) NOT NULL,
    cottage_country VARCHAR (45) NOT NULL,
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
    optional_name VARCHAR (45) NOT NULL,
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
    CONSTRAINT fk_booking_user FOREIGN KEY (user_iduser) REFERENCES user (iduser),
    cottage_idcottage INTEGER NOT NULL,
    CONSTRAINT fk_booking_cottage FOREIGN KEY (cottage_idcottage) REFERENCES cottage (idcottage),
    optional_idoptional INTEGER NOT NULL,
    CONSTRAINT fk_booking_optional FOREIGN KEY (optional_idoptional) REFERENCES optional (idoptional)
);

CREATE TABLE booked_date (
    idbooked_date INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    start_booked_date DATE NOT NULL,
    end_booked_date DATE NOT NULL
);

CREATE TABLE cottage_has_booked_date (
    idcottage_has_booked_date INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cottage_idcottage INTEGER NOT NULL,
    CONSTRAINT fk_cottage_has_booked_date_cottage_cottage FOREIGN KEY (cottage_idcottage) REFERENCES cottage (idcottage),
    booked_date_idbooked_date INTEGER NOT NULL,
    CONSTRAINT fk_cottage_has_booked_date_booked_date FOREIGN KEY (booked_date_idbooked_date) REFERENCES booked_date (idbooked_date)
);

/* Insertion donn??es table user */
INSERT INTO
    user (
        username,
        user_password,
        user_firstname,
        user_lastname,
        user_phone,
        user_email
    )
VALUES
    (
        'Tich53',
        'richard123',
        'Richard',
        'Douett??',
        '0695936812',
        'richard.douette-std@donkey.school'
    );

INSERT INTO
    user (
        username,
        user_password,
        user_firstname,
        user_lastname,
        user_phone,
        user_email
    )
VALUES
    (
        'PatrickT',
        'patrick123',
        'Patrick',
        'Tanguy',
        '06',
        'patrick.tanguy-std@donkey.school'
    );

INSERT INTO
    user (
        username,
        user_password,
        user_firstname,
        user_lastname,
        user_phone,
        user_email
    )
VALUES
    (
        'Khouloud',
        'khouloud123',
        'Khouloud',
        'Hadhek',
        '06',
        'khouloud.hadhek-std@donkey.school'
    );

INSERT INTO
    user (
        username,
        user_password,
        user_firstname,
        user_lastname,
        user_phone,
        user_email
    )
VALUES
    (
        'Daniel',
        'daniel123',
        'Daniel',
        'DESCLOUX',
        '06',
        'daniel.descloux-std@donkey.school'
    );

/* Insertion donn??es table optional */
INSERT INTO
    optional (
        optional_name,
        optional_price_per_adult,
        optional_price_per_child
    )
VALUES
    ('Donkey ride', 12, 7);

/* Insertion donn??es table cottage */
INSERT INTO
    cottage (
        cottage_name,
        cottage_region,
        cottage_city,
        cottage_country,
        cottage_nb_bed,
        cottage_nb_bathroom,
        cottage_price_per_night,
        cottage_photo1,
        cottage_description
    )
VALUES
    (
        'MAISON M??DI??VALE',
        'Catalogne',
        'El Can??s',
        'Espagne',
        3,
        2,
        120,
        'images/gite1_1.webp',
        "Casa del Portal est une maison priv??e, situ??e dans un petit village m??di??val (El Can??s), entour?? de champs, dans la r??gion de Segarra (Lleida). Enti??rement restaur??, il dispose de 3 chambres d'une capacit?? de 8 personnes, d'un salon avec chemin??e, d'une salle ?? manger, d'une cuisine, d'une salle de bain avec baignoire et terrasse. Dans le village, il y a une piscine avec une aire de jeux, que les clients peuvent utiliser gratuitement."
    ),
    (
        'MAS DU XV??ME SI??CLE',
        'Occitanie',
        'Arles-sur-Tech',
        'France',
        2,
        1,
        80,
        'images/gite2_1.webp',
        "Notre ferme catalane du 15??me si??cle avec g??te et studio ind??pendant au bord de la piscine est parfaite pour les familles ou les groupes d'amis ?? la recherche d'une escapade isol??e dans ce coin pittoresque des Pyr??n??es Orientales. Situ?? dans un hectare de beaux jardins avec un ruisseau et une piscine ?? d??bordement, c'est le lieu id??al pour se d??tendre et profiter de la nature."
    ),
    (
        'BELLE GRANGE RENOVEE',
        'Occitanie',
        'Loudervielle',
        'France',
        4,
        3,
        140,
        'images/gite3_1.webp',
        "Grange r??nov??e qui allie le charme de l'ancien et le confort d'un int??rieur moderne et design au c??ur des Hautes-Pyr??n??es. Le village de Loudervielle est perch?? ?? 1 100m d'altitude, ?? mi-chemin entre Loudenvielle et la station de ski de Peyragudes. C'est le lieu id??al pour les amoureux de la nature (rando, chiens de traineaux...), de sport (station de ski de Peyragudes ?? 4 km, spot de parapente) ou de d??tente (Baln??a)."
    ),
    (
        'CH??TEAU D`ESCLAVELLES',
        'Normandie',
        'Esclavelles',
        'France',
        3,
        2,
        120,
        'images/gite4_1.webp',
        "Passez un s??jour unique dans ce ch??teau du XVI si??cle situ?? en plein c??ur d'un ??levage de chevaux de sport avec une vue ??poustouflante sur la boutonni??re du pays de Bray. C'est au c??ur du Pays de Brays, dans un domaine pr??serv?? de 3,5 hectares o?? se niche un authentique ch??teau du 16??me si??cle aux multiples facettes enchanteresses."
    ),
    (
        'DOMAINE DE NOINTEL',
        '??le-de-France',
        'Nointel',
        'France',
        3,
        1,
        120,
        'images/gite5_1.webp',
        "Dans le domaine de Nointel, venez profiter de notre magnifique maison et de son cadre bucolique. Anciennes ??curies du ch??teau r??cemment r??nov??es, la maison appelle ?? la contemplation et au repos. Nich??e entre un ch??teau, son domaine, ses d??pendances et une ??glise, elle s??duira les amoureux de vieilles pierres."
    ),
    (
        'GRANGE R??HABILIT??E',
        'Hauts-de-France',
        'Mont??pilloy',
        'France',
        4,
        2,
        120,
        'images/gite6_1.webp',
        "Venez vous d??tendre dans cette chaleureuse grange r??habilit??e, avec cour pav??e et jardin fleuri, dans un petit village culminant ?? 134m d'altitude, au c??ur du Parc Naturel R??gional Oise-Pays de France. Grange r??habilit??e dans un petit village au calme comprenant 3 chambres avec lits doubles et 2 matelas individuels en plus."
    ),
    (
        'DOMAINE LE GROS CH??NE',
        'Normandie',
        'Le Landin',
        'France',
        5,
        3,
        220,
        'images/gite7_1.webp',
        "Maison de vacances familiale disposant d'une piscine int??rieure (chauff??e de mi mai jusqu'au 15 septembre uniquement et sans exception, donc inutilisable en dehors), un court de tennis ext??rieur utilisable de mars ?? octobre, une salle de billards, un babyfoot, le tout au centre d'un paisible domaine de 15 hectares. Dans les boucles de la Seine, situ??e ?? 140 km de Paris, 60 km d'Honfleur et Deauville, 40 km de Rouen."
    );

/* Insertion images table cottage */
UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite1_2.webp',
    cottage_photo3 = 'images/gite1_3.webp',
    cottage_photo4 = 'images/gite1_4.webp'
WHERE
    idcottage = 1;

UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite2_2.webp',
    cottage_photo3 = 'images/gite2_3.webp',
    cottage_photo4 = 'images/gite2_4.webp'
WHERE
    idcottage = 2;

UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite3_2.webp',
    cottage_photo3 = 'images/gite3_3.webp',
    cottage_photo4 = 'images/gite3_4.webp'
WHERE
    idcottage = 3;

UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite4_2.webp',
    cottage_photo3 = 'images/gite4_3.webp',
    cottage_photo4 = 'images/gite4_4.webp'
WHERE
    idcottage = 4;

UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite5_2.webp',
    cottage_photo3 = 'images/gite5_3.webp',
    cottage_photo4 = 'images/gite5_4.webp'
WHERE
    idcottage = 5;

UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite6_2.webp',
    cottage_photo3 = 'images/gite6_3.webp',
    cottage_photo4 = 'images/gite6_4.webp'
WHERE
    idcottage = 6;

UPDATE
    cottage
SET
    cottage_photo2 = 'images/gite7_2.webp',
    cottage_photo3 = 'images/gite7_3.webp',
    cottage_photo4 = 'images/gite7_4.webp'
WHERE
    idcottage = 7;