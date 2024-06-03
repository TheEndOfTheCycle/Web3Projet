<?php
class FilmForm
{
    private $gdb;

    public function generateForm()
    { ?>
        <div class="container_acteur_form">
            <div class="sub-container">
                <div class="sub-container_2">
                    <form id="acteur-form" method="POST" enctype="multipart/form-data">
                        <legend class="title-form-acteur">NEW FILM</legend>
                        <div class="mb-3">
                            <label for="titre" class="form-label neon">Titre</label>
                            <span id="titre-error" class="error-message"></span>
                            <input type="text" class="form-control titre-film" id="titre" name="titre" aria-describedby="titre">
                        </div>
                        <div class="mb-3">
                            <label for="annee" class="form-label neon">Année de sortie</label>
                            <span id="annee-error" class="error-message"></span>
                            <input type="text" class="form-control annee-film" id="annee" name="annee" aria-describedby="annee">
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label neon">Genre</label>
                            <span id="genre-error" class="error-message"></span>
                            <input type="text" class="form-control genre-film" id="genre" name="genre" aria-describedby="genre">
                        </div>
                        <div class="mb-3">
                            <label for="real" class="form-label neon">Réalisateur</label>
                            <span id="real-error" class="error-message"></span>
                            <input type="text" class="form-control real-film" id="real" name="real" aria-describedby="real">
                        </div>
                        <div class="mb-3">
                            <label for="affiche" class="form-label neon">Affiche</label>
                            <span id="affiche-error" class="error-message"></span>

                            <div id="preview-container">
                                <img id="preview-image" src="">
                            </div>
                            <input type="file" class="form-control-image" id="affiche" name="affiche"
                                accept="image/png, image/gif, image/jpeg">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label neon">Description</label>
                            <span id="description-error" class="error-message"></span>
                            <textarea class="form-control description-film" id="description" name="description" rows="5"
                                aria-describedby="description"></textarea>
                        </div>

                        <div class="sub-form-acteur">
                            <button type="submit" class="btn sub">Submit</button>
                            <button type="reset" class="btn sub res">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const preview = document.getElementById("preview-image");
                const fileInput = document.getElementById("affiche");
                let isImageSelected = false;

                fileInput.addEventListener('change', function () {
                    const file = fileInput.files[0];
                    if (file && file.type.startsWith('image/')) {
                        isImageSelected = true;
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        isImageSelected = false;
                        preview.src = '';
                        preview.style.display = 'none';
                    }
                });

                let form = document.getElementById("acteur-form");
                let titre = document.getElementById("titre");
                let titreError = document.getElementById("titre-error");
                let annee = document.getElementById("annee");
                let anneeError = document.getElementById("annee-error");
                let description = document.getElementById("description");
                let descriptionError = document.getElementById("description-error");
                let genre = document.getElementById("genre");
                let genreError = document.getElementById("genre-error");
                let real = document.getElementById("real");
                let realError = document.getElementById("real-error");
                let afficheError = document.getElementById("affiche-error");

                form.addEventListener('submit', function (ev) {
                    let hasError = false;

                    titreError.textContent = "";
                    anneeError.textContent = "";
                    descriptionError.textContent = "";
                    genreError.textContent = "";
                    realError.textContent = "";
                    afficheError.textContent = "";

                    if (titre.value.trim() === "") {
                        ev.preventDefault();
                        titreError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir un titre.';
                        hasError = true;
                    }

                    if (annee.value.trim() === "") {
                        ev.preventDefault();
                        anneeError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir une année de sortie.';
                        hasError = true;
                    }

                    if (description.value.trim() === "") {
                        ev.preventDefault();
                        descriptionError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir une description.';
                        hasError = true;
                    }

                    if (genre.value.trim() === "") {
                        ev.preventDefault();
                        genreError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir un genre.';
                        hasError = true;
                    }

                    if (real.value.trim() === "") {
                        ev.preventDefault();
                        realError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir un réalisateur.';
                        hasError = true;
                    }

                    if (!isImageSelected) {
                        afficheError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez sélectionner une image.';
                        hasError = true;
                    }

                    if (hasError) {
                        ev.preventDefault();
                    } else {
                        form.submit();
                    }
                });

                titre.addEventListener('keydown', function () {
                    titreError.textContent = "";
                });

                annee.addEventListener('keydown', function () {
                    anneeError.textContent = "";
                });

                description.addEventListener('keydown', function () {
                    descriptionError.textContent = "";
                });

                genre.addEventListener('keydown', function () {
                    genreError.textContent = "";
                });

                real.addEventListener('keydown', function () {
                    realError.textContent = "";
                });

                let resetButton = document.querySelector('.res');
                resetButton.addEventListener('click', function () {
                    preview.src = '';
                    preview.style.display = 'none';
                    fileInput.value = '';
                    titreError.textContent = "";
                    anneeError.textContent = "";
                    descriptionError.textContent = "";
                    genreError.textContent = "";
                    realError.textContent = "";
                    afficheError.textContent = "";
                });
            });
        </script>
        <?php
    }

    public function createFilm($titre, $annee, $genre, $real, $afficheFile = null, $syno)
    {
        if ($this->gdb == null) {
            $this->gdb = new Films();
        }

        $uploadedFilePath = null;

        if ($afficheFile && $afficheFile['error'] == 0) {
            $uploadDir = __DIR__ . '/../images/affiches/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExtension = pathinfo($afficheFile['name'], PATHINFO_EXTENSION);
            $newFileName = pathinfo($afficheFile['name'], PATHINFO_FILENAME) . '.' . $fileExtension;
            $uploadedFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($afficheFile['tmp_name'], $uploadedFilePath)) {
                echo "L'affiche a été téléchargée avec succès.";
            } else {
                echo "Erreur lors du téléchargement de l'affiche.";
                $uploadedFilePath = null;
            }
        }
        echo "1";
        $afficheFileName = $afficheFile ? $afficheFile['name'] : null;
        if (!$this->gdb->add_film_to_db($titre, $annee, $genre, $real, $afficheFileName, $syno)) {
            header('location: ../pages/realisateur_form.php');
            exit();
        } else {


            $tagss = new Tags();
            $num_tag = $tagss->getNumTag($genre);
            if ($num_tag === null) {
                $tagss->add_tag_to_db($genre);
            }
            $this->gdb->addTagToFilm($titre, $genre);

        }

        $csvFile = '/home/youcef/Bureau/WEB/yacine3/csv/film.csv';
        $lastId = 0;
        if (file_exists($csvFile)) {
            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if (is_numeric($data[0])) {
                        $lastId = max($lastId, intval($data[0]));
                    }
                }
                fclose($handle);
            }
        }
        $newId = $lastId + 1;

        $fileHandle = fopen($csvFile, 'a');
        if ($fileHandle !== false) {
            if ($lastId === 0) {
                fputcsv($fileHandle, ["num_film", "titre_film", "anSortie_film", "genre_film", "num_real", "nom_affiche", "synopsis"]);
            }
            $line = [$newId, $titre, $annee, $genre, $real, $afficheFileName, $syno];
            fputcsv($fileHandle, $line);
            fclose($fileHandle);
        } else {
            echo "Erreur lors de l'ouverture du fichier CSV.";
        }

        header('location: ../pages/films.php');
        exit();
    }
}
?>