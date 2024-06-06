<?php

require_once "../config.php";

use pdo_wrapper\PdoWrapper;

class Realisateurs extends PdoWrapper
{
    public function getAllreal()
    {
        return $this->exec(
            "SELECT * FROM realisateur ",
            null,
            'Realisateur'
        );
    }

    public function add_real_to_db($nom_real, $nom_img)
    {

        if ($nom_img === null) {
            $nom_img = "avatare.jpg";
        }
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

    public function getFilmsByRealisateur($nomRealisateur)
    {
        $req = "SELECT f.* 
                FROM Films f
                INNER JOIN realisateur r ON f.num_real = r.num_real
                WHERE r.nom_real = :nomRealisateur";
        $para = ["nomRealisateur" => $nomRealisateur];
        return $this->exec($req, $para, "Film");
    }

    public function getRealisateur($nom_realisateur)
    {
        // Supposons que getNumReal($nom_realisateur) est une méthode valide qui renvoie le numéro du réalisateur
        $num_realisateur = $this->getNumReal($nom_realisateur);

        // Correction de la requête et des paramètres
        $req = "SELECT * FROM realisateur WHERE num_real = :numR";
        $para = ["numR" => $num_realisateur];

        // Exécution de la requête
        $res = $this->exec($req, $para, "Realisateur");

        // Retourner le premier résultat, si disponible
        return isset($res[0]) ? $res[0] : null;
    }

    private function remove_real_from_csv($nom_real)
    {
        $csvFile = '/home/youcef/Bureau/WEB/yacine3/csv/realisateur.csv';
        $tempFile = '/home/youcef/Bureau/WEB/yacine3/csv/temp_acteur.csv';

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
    public function updateRealisateurName($numReal, $newName)
    {
        $req = "UPDATE realisateur SET nom_real = :newName WHERE num_real = :numReal";
        $params = ["newName" => $newName, "numReal" => $numReal];
        $this->exec($req, $params);
    }

    public function updateImageByNumReal($numRealisateur, $newImageName)
    {
        // Requête SQL pour mettre à jour le nom de l'image d'un réalisateur
        $req = "UPDATE realisateur SET nom_img = :newImageName WHERE num_real = :numReal";
        $params = ["newImageName" => $newImageName, "numReal" => $numRealisateur];
        $this->exec($req, $params);
    }

    public function realisateurExist($nomRealisateur)
    {
        $req = "SELECT COUNT(*) AS count FROM realisateur WHERE nom_real = :nomRealisateur";
        $params = ["nomRealisateur" => $nomRealisateur];
        $result = $this->exec($req, $params);

        if ($result[0]->count > 0) {
            return true; // Le réalisateur existe
        } else {
            return false; // Le réalisateur n'existe pas
        }
    }

    public function searchDirectors($directorName)
    {
        $req = "SELECT * FROM realisateur WHERE nom_real LIKE :directorName";
        $params = ["directorName" => '%' . trim($directorName) . '%'];
        return $this->exec($req, $params, 'Realisateur');
    }
}
