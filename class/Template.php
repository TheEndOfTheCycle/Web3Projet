<?php
class Template
{

    public static function render(string $content) : void{?>

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>CineCollection</title>

            <link rel="stylesheet" href="<?php echo $GLOBALS['CSS_DIR'] ?>CineCollection.css">

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