<?php
require "../Nexrender/controller/index-controller.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digika Render</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div id="global-page">
        <div id="title">
            <div class="dash"></div>
            <h1>digika</h1>
        </div>
        <h2>Créez votre contenu</h2>
        <form enctype="multipart/form-data" method="post" action="">
<!--            <fieldset>-->
<!--                <label for="title">-->
<!--                    <input type="text" name="title" placeholder="Tapez le nom du fichier ici"></label>-->
<!--            </fieldset>-->
                <label for="text">Texte<input id="text" name="text" type="text"
                                              placeholder="Type your title here"></label>
                <label for="image">Choisir une image<input id="image" name="image" type="file"
                                                           placeholder="Drop your picture here"></label>
            <input type="submit" name="submit">

        </form>

    <?php
    $render = 'assets/render';
    $scanDir = scandir($render);
    $directory = end($scanDir);
    $lastFolder = $render . "/" . $directory;
    if (isset($_POST['text'], $_FILES['image']) && !empty($_POST['text']) && file_exists($render)) {

        ?>
        <div class="video">
            <a href="<?= $lastFolder . "/video.mp4" ?>" download="video.mp4">Télécharger</a>
            <video controls>
                <source src="<?= $lastFolder . "/video.mp4" ?>"
                        type="video/mp4">
            </video>
        </div>
        <?php
    }
    ?>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>