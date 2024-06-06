<?php
// Inclure votre fichier de configuration et la classe Autoloader
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();
$trie = new Trie();
$Bacts = new Acteurs();
$estAct=0;//permet de savoir si un real est un acteur
$estReal=0;//permet de savoir si un acteur est un real
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    //echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}



// Vérifier si le terme de recherche est présent dans les paramètres GET
if (isset($_GET['query'])  ) {
    $query = trim($_GET['query']);

    // Vérifier que le terme de recherche n'est pas vide
    if (!empty($query)) {
        // Effectuer la recherche de films
        $resultAll = $trie->searchMovies($query);//on cherche les films
        $resultAllActs =$trie->searchActor($query);//on cherche les acteurs
        $resultAllReal =$trie->searchReal($query);//on cherche les reals
        $tempo= array();
        // Vérifier si des résultats ont été trouvés
        if ($resultAll !== false && !empty($resultAll)) {
            // Convertir les résultats en un tableau associatif approprié pour le JSON
            $jsonResults = array();
            foreach ($resultAll as $result) {
                foreach($result->getTags() as $tag)
                {
                  $tempo []=  $tag->nom_tag . " ";
                }
               
                $jsonResults[] = array(
                    'titre_film' => htmlspecialchars($result->titre_film, ENT_QUOTES, 'UTF-8'),
                    'img_film' => htmlspecialchars($result->nom_affiche, ENT_QUOTES, 'UTF-8'),
                    'anSortie_film' => htmlspecialchars($result->anSortie_film, ENT_QUOTES, 'UTF-8'),
                    'genre' => htmlspecialchars(implode(" ",$tempo), ENT_QUOTES, 'UTF-8'), // Il serait préférable de rendre ce champ dynamique
                    'type' =>"Film",
                );
                $tempo = array();
                
            }
            foreach ($resultAllActs as $result) {
                foreach($Bacts->acteurEstreal() as $res)
                {
                    $TnameAct=$result->nom_act;

                    if($res->nom_act==$result->nom_act)
                    {
                       $estReal=1;
                        break;
                    }
                   
                }
                $jsonResults[] = array(
                    'nom_act' => htmlspecialchars($TnameAct, ENT_QUOTES, 'UTF-8'),
                    'type' => "Acteur",
                    'img_act' =>htmlspecialchars($result->nom_img, ENT_QUOTES, 'UTF-8'),
                    'estReal' =>$estReal,
                );
                $estReal=0;
            }
            foreach($resultAllReal as $result)
            {
                foreach($Bacts->acteurEstreal() as $res)
                {
                    $TrealName=$result->nom_real;
                    if($res->nom_real==$result->nom_real)
                    {
                       $estAct=1;
                        break;
                    }
                }
                $jsonResults[] = array(
                    'nom_real' => htmlspecialchars($TrealName, ENT_QUOTES, 'UTF-8'),
                    'type' => "Realisateur",
                    'img_real' =>htmlspecialchars($result->nom_img, ENT_QUOTES, 'UTF-8'),
                    'estAct' =>$estAct,
                );
                $estAct=0;
            }

            // Renvoyer les résultats au format JSON
            echo json_encode($jsonResults);
        } else {
            // Aucun résultat trouvé
            http_response_code(404);
            echo json_encode(array('error' => 'No movies found'));
        }
    } else {
        // Terme de recherche vide
        http_response_code(400);
        echo json_encode(array('error' => 'Empty search query provided'));
    }
} 
   


