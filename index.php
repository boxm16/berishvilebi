<?php
require_once 'Controller/PersonController.php';
$personController = new PersonController();
//$fullGenTree = $personController->getFullGenTree();
$generationsLayers = $personController->getGenerationsLayers();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="config.php">Go Config</a>
        <br>
        <a href="admin.php">Go Admin</a>
        <br>
        <?php
        foreach ($generationsLayers as $generationLayer) {
            foreach ($generationLayer as $person) {
                echo $person->getFirstName() . " " . $person->getSecondName() . " ";
                $id = $person->getId();
                echo "<a href='addChild.php?id=$id'>შვილის დამატება</a> ";
            }
            echo "<hr>";
        }
        ?>

    </body>
</html>
