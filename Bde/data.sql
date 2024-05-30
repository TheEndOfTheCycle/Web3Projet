DROP Table if EXISTS Films;
DROP table if EXISTS acteur;
DROP table if EXISTS realisateur;
DROP table if EXISTS jouer;
DROP table if EXISTS genre;
 CREATE TABLE Films (
  num_film int,
   titre_film varchar(255),
   anSortie_film int,
   genre_film varchar(255),
   num_real int,
   nom_affiche varchar(255),
    synopsis varchar(255)
 
);
CREATE TABLE acteur(

    num_act int,
    nom_act varchar(255),
    nom_img varchar(255)

);
CREATE TABLE realisateur(
     num_real int,
    nom_real varchar(255),
    nom_img varchar(255)


);
CREATE TABLE jouer
(
    num_act int,
    num_film int
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
