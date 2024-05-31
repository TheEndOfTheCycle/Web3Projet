<?php
class RealisateurForm
{
    private $gdb;

    public function generateForm()
    { ?>
        <div class="container_acteur_form">
            <div class="sub-container">
                <div class="sub-container_2">
                    <form id="acteur-form" method="POST" enctype="multipart/form-data">
                        <legend class="title-form-acteur">NEW ACTEUR</legend>
                        <div class="mb-3 neon">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control name-acteur" id="name" name="name" aria-describedby="name">
                        </div>
                        <div class="mb-3 neon">
                            <label for="image" class="form-label">Image</label>
                            <div id="preview-container">
                                <img id="preview-image" src="">
                            </div>
                            <input type="file" class="form-control-image" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                        </div>
                        <div class="sub-form-acteur">
                            <button type="submit" class="btn sub">Submit</button>
                            <button type="reset" class="btn sub">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const preview = document.getElementById("preview-image");
                const fileInput = document.getElementById("image");

                fileInput.addEventListener('change', function () {
                    const file = fileInput.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '';
                        preview.style.display = 'none';
                    }
                });

                let form = document.getElementById("acteur-form");
                let name = document.getElementById("name");
                form.addEventListener('submit', function (ev) {
                    if (name.value.trim() === "") {
                        ev.preventDefault();
                        name.classList.add("error");
                    }
                });
                name.addEventListener('keydown', function () {
                    name.classList.remove("error");
                });
            });
        </script>
        <?php
    }

    public function createRealisateur($name, $imgFile = null)
    {
        if ($this->gdb == null) {
            $this->gdb = new Realisateurs();
        }

        $uploadedFilePath = null;

        if ($imgFile && $imgFile['error'] == 0) {
            $uploadDir = __DIR__ . '/../images/realisateurs/';
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
        $this->gdb->add_real_to_db($name, $imageFileName);

        // Redirect only if the insertion was successful
        header('location: ../pages/realisateurs.php');
        exit();
    }
}