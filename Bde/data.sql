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
     num_real int NOT NULL AUTO_INCREMENT,
    nom_real varchar(255),
    nom_img varchar(255),
    PRIMARY KEY (num_real)

);
CREATE TABLE Films (
  num_film INT NOT NULL AUTO_INCREMENT,
  titre_film VARCHAR(255),
  anSortie_film INT,
  genre_film VARCHAR(255),
  num_real INT,
  nom_affiche VARCHAR(255),
  synopsis TEXT,
  PRIMARY KEY (num_film),
  CONSTRAINT FOREIGN KEY (num_real) REFERENCES realisateur(num_real)
);


CREATE TABLE acteur(

    num_act int NOT NULL  AUTO_INCREMENT  ,
    nom_act varchar(255),
    nom_img varchar(255),
    PRIMARY KEY (num_act)


);
ALTER TABLE acteur AUTO_INCREMENT = 1;
CREATE TABLE jouer
(
    num_act int ,
    num_film int ,
    CONSTRAINT FOREIGN KEY (num_film) REFERENCES Films(num_film),
    CONSTRAINT FOREIGN KEY (num_act) REFERENCES acteur(num_act)

);
CREATE TABLE tags(
    nom_tag varchar(255),
    num_tag int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(num_tag)

);
CREATE Table film_tag(
    num_film int ,
    num_tag int ,
   CONSTRAINT FOREIGN KEY (num_film) REFERENCES Films(num_film),
  CONSTRAINT  FOREIGN KEY (num_tag) REFERENCES tags(num_tag)


);

LOAD DATA LOCAL INFILE '/home/youcef/Bureau/WEB/yacine3/csv/acteur.csv'
INTO TABLE acteur
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL  INFILE '/home/youcef/Bureau/WEB/yacine3/csv/realisateur.csv'
INTO TABLE realisateur
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE '/home/youcef/Bureau/WEB/yacine3/csv/film.csv'
INTO TABLE Films
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE '/home/youcef/Bureau/WEB/yacine3/csv/jouer.csv'
INTO TABLE jouer
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE '/home/youcef/Bureau/WEB/yacine3/csv/tags.csv'
INTO TABLE tags
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE '/home/youcef/Bureau/WEB/yacine3/csv/films_tag.csv'
INTO TABLE film_tag
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;





