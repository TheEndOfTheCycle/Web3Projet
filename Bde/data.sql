SET FOREIGN_KEY_CHECKS=0; 


DROP Table if EXISTS Films ;
DROP table if EXISTS acteur ;
DROP table if EXISTS realisateur ;
DROP table if EXISTS jouer ;
DROP table if EXISTS genre ;
DROP table if EXISTS tags ;
DROP table if EXISTS film_tag ;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE realisateur(
     num_real int,
    nom_real varchar(255),
    nom_img varchar(255),
    PRIMARY KEY (num_real)

);

 CREATE TABLE Films (
  num_film int,
   titre_film varchar(255),
   anSortie_film int,
   genre_film varchar(255),
   num_real int,
   nom_affiche varchar(255),
    synopsis varchar(255),
    PRIMARY KEY (num_film)               

 
 
);

CREATE TABLE acteur(

    num_act int,
    nom_act varchar(255),
    nom_img varchar(255),
    PRIMARY KEY (num_act)


);

CREATE TABLE jouer
(
    num_act int,
    num_film int,
    CONSTRAINT FOREIGN KEY (num_film) REFERENCES Films(num_film),
    CONSTRAINT FOREIGN KEY (num_act) REFERENCES acteur(num_act)

);
CREATE TABLE tags(
    nom_tag varchar(255),
    num_tag int,
    PRIMARY KEY(num_tag)

);
CREATE Table film_tag(
    num_film int ,
    num_tag int,
   CONSTRAINT FOREIGN KEY (num_film) REFERENCES Films(num_film),
  CONSTRAINT  FOREIGN KEY (num_tag) REFERENCES tags(num_tag)


);

LOAD DATA LOCAL INFILE 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/acteur.csv'
INTO TABLE acteur
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/film.csv'
INTO TABLE Films
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL  INFILE 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/realisateur.csv'
INTO TABLE realisateur
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/jouer.csv'
INTO TABLE jouer
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/tags.csv'
INTO TABLE tags
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/films_tag.csv'
INTO TABLE film_tag
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;



