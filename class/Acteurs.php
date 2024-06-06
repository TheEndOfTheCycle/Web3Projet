<?php
require_once "../config.php";

use pdo_wrapper\PdoWrapper;

class Acteurs extends PdoWrapper
{
    public $actors = [];

    public function getAllActors()
    {
        return $this->exec("SELECT * FROM acteur", null, 'Acteur');
    }

    public function getNumAct($nom_act)
    {
        $req = "SELECT * FROM acteur WHERE nom_act=:nomA";
        $para = ["nomA" => $nom_act];
        $res = $this->exec($req, $para, "Acteur");
        return $res[0]->num_act;
    }
   
    


    public function getActeur($nom_acteur)
    {
        // Supposons que getNumAct($nom_acteur) est une méthode valide qui renvoie le numéro de l'acteur
        $num_acteur = $this->getNumAct($nom_acteur);

        // Correction de la requête et des paramètres
        $req = "SELECT * FROM acteur WHERE num_act = :numA";
        $para = ["numA" => $num_acteur];

        // Exécution de la requête
        $res = $this->exec($req, $para, "Acteur");

        // Retourner le premier résultat, si disponible
        return isset($res[0]) ? $res[0] : null;
    }


    public function check_actor_in_film($num_act, $num_film)
    {
        $req = "SELECT COUNT(*) as count FROM jouer WHERE num_act=:num_act AND num_film=:num_film";
        $para = ["num_act" => $num_act, "num_film" => $num_film];
        $result = $this->exec($req, $para);
        $count = $result[0]->count;
        return $count > 0;
    }

    public function add_actor_to_db($nomAct, $ImgAct)
    {
        // on va inserer le nom, le numero et le nom de l'image dans le tableau acteur
        $req = "INSERT INTO acteur (nom_act, nom_img) VALUES (:nom_act, :nom_img)";
        $para = ["nom_act" => $nomAct, "nom_img" => $ImgAct];
        $this->exec($req, $para);

        // Ajouter l'acteur au fichier CSV
        $this->add_actor_to_csv($nomAct, $ImgAct);
    }

    public function remove_actor_from_db($nom_act)
    {
        $num_act = $this->getNumAct($nom_act);
        $para = ["numA" => $num_act];

        // Effacer les rôles de l'acteur
        $req = "DELETE FROM jouer WHERE num_act=:numA";
        $this->exec($req, $para);

        // Effacer l'acteur de la table acteur
        $req = "DELETE FROM acteur WHERE num_act=:numA";
        $this->exec($req, $para);

        // Supprimer l'acteur du fichier CSV
        $this->remove_actor_from_csv($nom_act);
    }

    public function add_role($num_act, $num_film)
    {
        $req = "INSERT INTO jouer (num_act, num_film) VALUES(:num_act, :num_film)";
        $para = ["num_act" => $num_act, "num_film" => $num_film];
        $this->exec($req, $para);
    }

    public function remove_role($numAct, $numFilm)
    {
        $req = "DELETE FROM jouer WHERE num_act=:numA AND num_film=:numF";
        $para = ["numF" => $numFilm, "numA" => $numAct];
        $this->exec($req, $para);
    }

    private function add_actor_to_csv($nom_act, $nom_img)
    {
        $csvFile = '/home/youcef/Bureau/WEB/yacine3/csv/acteur.csv';
        $newId = $this->getNumAct($nom_act);

        // Write to CSV file
        $fileHandle = fopen($csvFile, 'a');
        if ($fileHandle !== false) {
            $line = [$newId, $nom_act, $nom_img];
            fputcsv($fileHandle, $line);
            fclose($fileHandle);
        } else {
            echo "Erreur lors de l'ouverture du fichier CSV.";
        }
    }

    private function remove_actor_from_csv($nom_act)
    {
        $csvFile = '/home/youcef/Bureau/WEB/yacine3/csv/acteur.csv';
        $tempFile = tempnam(sys_get_temp_dir(), 'csv');

        if (file_exists($csvFile)) {
            if (($inputFile = fopen($csvFile, 'r')) !== false) {
                if (($outputFile = fopen($tempFile, 'w')) !== false) {
                    while (($data = fgetcsv($inputFile, 1000, ',')) !== false) {
                        // Check if the current row does not contain the actor to be deleted
                        if ($data[1] !== $nom_act) {
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
    public function searchActors($actorName)
    {
        $req = "SELECT * FROM acteur WHERE nom_act LIKE :actorName";
        $params = ["actorName" => '%' . trim($actorName) . '%'];
        return $this->exec($req, $params, 'Acteur');
    }
    

}

