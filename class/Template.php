<?php
class Template
{

    public static function render(string $content) : void{?>

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>CineCollection</title>
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/login.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="icon" href="../images/logo.png">
            <script src="script/main.js"></script>
        </head>
        <body>
            <?php include "header.php" ?>

            <div id="content">
                <?php echo $content ?> 
            </div>

            <?php include "footer.php" ?>

        </body>
        </html>

    <?php
    }

}

