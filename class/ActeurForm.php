<?php
class ActeurForm
{
    private $gdb;

    public function generateForm()
    { ?>
        <div class="container_acteur_form">
            <div class="sub-container">
                <div class="sub-container_2">
                    <form id="acteur-form" method="POST" enctype="multipart/form-data">
                        <legend class="title-form-acteur">NEW ACTEUR</legend>
                        <div class="mb-3 ">
                            <label for="name" class="form-label neon">Name</label>
                            <span id="name-error" class="error-message"></span>
                            <input type="text" class="form-control name-acteur" id="name" name="name" aria-describedby="name">

                        </div>
                        <div class="mb-3 ">
                            <label for="image" class="form-label neon">Image</label>
                            <span id="image-error" class="error-message"></span>

                            <div id="preview-container">
                                <img id="preview-image" src="">
                            </div>
                            <input type="file" class="form-control-image" id="image" name="image"
                                accept="image/png, image/gif, image/jpeg">
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
                const fileInput = document.getElementById("image");
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
                let name = document.getElementById("name");
                let nameError = document.getElementById("name-error");
                let imageError = document.getElementById("image-error");

                form.addEventListener('submit', function (ev) {
                    let hasError = false;

                    nameError.textContent = "";
                    imageError.textContent = "";

                    if (name.value.trim() === "") {
                        ev.preventDefault();
                        nameError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir un nom.';
                        hasError = true;
                    }

                    if (!isImageSelected) {
                        ev.preventDefault();
                        imageError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez sélectionner une image.';
                        hasError = true;
                    }

                    if (hasError) {
                        ev.preventDefault();
                    } else {
                        form.submit();
                    }
                });

                name.addEventListener('keydown', function () {
                    nameError.textContent = "";
                });

                let resetButton = document.querySelector('.res');
                resetButton.addEventListener('click', function () {
                    preview.src = '';
                    preview.style.display = 'none';
                    fileInput.value = '';
                    nameError.textContent = "";
                    imageError.textContent = "";
                });
            });
        </script>
        <?php
    }

    public function createActeur($name, $imgFile = null)
    {
        if ($this->gdb == null) {
            $this->gdb = new Acteurs();
        }

        $uploadedFilePath = null;

        if ($imgFile && $imgFile['error'] == 0) {
            $uploadDir = __DIR__ . '/../images/acteurs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExtension = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
            $newFileName = pathinfo($imgFile['name'], PATHINFO_FILENAME) . '.' . $fileExtension;
            $uploadedFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($imgFile['tmp_name'], $uploadedFilePath)) {
                echo "L'image a été téléchargée avec succès.";
            } else {
                echo "Erreur lors du téléchargement de l'image.";
                $uploadedFilePath = null;
            }
        }

        // Ensure the image name is passed correctly
        $imageFileName = $imgFile ? $imgFile['name'] : null;

        // Appel de la méthode pour créer un acteur dans la base de données
        $this->gdb->add_actor_to_db($name, $imageFileName);

        // Read the CSV file to find the last num_act
        $csvFile = 'C:/Program Files/MySQL/MySQL Server 8.0/Uploads/acteur.csv';
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

        // Write to CSV file
        $fileHandle = fopen($csvFile, 'a');
        if ($fileHandle !== false) {
            if ($lastId === 0) {
                // Write the header if the file was empty or just created
                fputcsv($fileHandle, ['num_act', 'nom_act', 'nom_img',]);
            }
            $line = [$newId, $name, $imageFileName];
            fputcsv($fileHandle, $line);
            fclose($fileHandle);
        } else {
            echo "Erreur lors de l'ouverture du fichier CSV.";
        }


        // Redirect only if the insertion was successful
        header('location: ../pages/acteurs.php');
        exit();
    }
}
?>