<?php 

require_once "../config.php";

use pdo_wrapper\PdoWrapper;

class Realisateurs extends PdoWrapper
{
    public function getAllreal(){
        return $this->exec(
            "SELECT * FROM realisateur ",
            null,
            'Realisateur'
        );
    }

    public function add_real_to_db($nom_real, $nom_img)
    {
        //on va inserer le numero le nom du real et de l image dans le tableau realisateur
        $req = "Insert into realisateur (nom_real, nom_img) values(:nom_real, :nom_img)";
        $para = ["nom_real" => $nom_real, "nom_img" => $nom_img];
        $this->exec($req, $para);
    }
    
    public function remove_real_from_db($nom_real)
    {
        // il faut d abord effacer le film de la bde
        $Tfilms = new Films();
        $films = $this->getFilmReal($nom_real);

        // Supprimer chaque film un par un
        foreach ($films as $film) {
            $Tfilms->remove_film_from_db($film->titre_film);
        }

        // Ensuite, supprimer le réalisateur
        $req = "delete from realisateur where num_real=:numR";
        $para = ["numR" => $this->getNumReal($nom_real)];
        $this->exec($req, $para);

        // Supprimer le réalisateur du fichier CSV
        $this->remove_real_from_csv($nom_real);
    }

    public function getNumReal($nom_real)
    {
        $req = "select * from realisateur where nom_real=:nomR";
        $para = ["nomR" => $nom_real];
        $res = $this->exec($req, $para, "Realisateur");
        return $res[0]->num_real;
    }
  
    public function getFilmReal($nom_real)
    {
        $req = "select Films.* from realisateur inner join Films on Films.num_real=" . $this->getNumReal($nom_real);
        return $this->exec($req, null, "Film");
    }

    private function remove_real_from_csv($nom_real)
    {
        $csvFile = 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/realisateur.csv';
        $tempFile = 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/temp_acteur.csv';

        if (file_exists($csvFile)) {
            if (($inputFile = fopen($csvFile, 'r')) !== false) {
                if (($outputFile = fopen($tempFile, 'w')) !== false) {
                    while (($data = fgetcsv($inputFile, 1000, ',')) !== false) {
                        // Check if the current row does not contain the real to be deleted
                        if ($data[1] !== $nom_real) {
                            fputcsv($outputFile, $data);
                        }
                    }
                    fclose($outputFile);
                }
                fclose($inputFile);
            }
            // Replace the original file with the updated file
            rename($tempFile, $csvFile);
        }
    }
}
