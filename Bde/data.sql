DROP Table if EXISTS Films;
DROP table if EXISTS acteur;
DROP table if EXISTS realisateur;
DROP table if EXISTS jouer;
 CREATE TABLE Films (
  num_film int,
   titre_film varchar(255),
   anSortie_film int,
   genre_film varchar(255),
   num_real int,
    num_syn int
 
);
CREATE TABLE acteur(

    num_act int,
    nom_act varchar(255),
    num_img int

);
CREATE TABLE realisateur(
     num_real int,
    nom_real varchar(255),
    anNais_real int,
    num_img int


);
CREATE TABLE jouer
(
    num_act int,
    num_film int
);
LOAD DATA LOCAL INFILE 'C:/Users/chakr/Desktop/ProjetWeb3/Bde/acteur.csv'
INTO TABLE acteur
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Users/chakr/Desktop/ProjetWeb3/Bde/film.csv'
INTO TABLE Films
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Users/chakr/Desktop/ProjetWeb3/Bde/realisateur.csv'
INTO TABLE realisateur
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
LOAD DATA LOCAL INFILE 'C:/Users/chakr/Desktop/ProjetWeb3/Bde/jouer.csv'
INTO TABLE jouer
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
